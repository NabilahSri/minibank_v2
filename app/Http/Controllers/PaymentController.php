<?php

namespace App\Http\Controllers;

use App\Models\Notif;
use App\Models\Rekening;
use App\Models\SandiTransaksi;
use App\Models\Tagihan;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\ViaTransaksi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Webhook Callback Endpoint (Called by BPI MAKA / Bank BSI)
     */
    public function notif(Request $request): JsonResponse
    {
        Log::info('BPI Payment Webhook Received', $request->all());

        // 1. Simpan log mentah ke tabel notifs (Audit Log)
        try {
            Notif::create([
                'code'             => $request->input('code'),
                'message'          => $request->input('message'),
                'type'             => $request->input('type'),
                'number'           => $request->input('number'),
                'amount'           => $request->input('amount', 0),
                'remaining_amount' => $request->input('remainingAmount', 0),
                'va'               => $request->input('va'),
                'date'             => $request->input('date'),
                'bank_code'        => $request->input('bankCode'),
                'bank_name'        => $request->input('bankName'),
                'ref'              => $request->input('ref'),
                'channel'          => $request->input('channel'),
                'name'             => $request->input('name'),
                'phone'            => $request->input('phone'),
                'email'            => $request->input('email'),
                'address'          => $request->input('address'),
                'time_notif'       => now(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Gagal mencatat log notif BPI: ' . $e->getMessage());
        }

        // 2. Jika kode respon bukan '00' (bukan transaksi sukses) -> abaikan penambahan saldo
        if ($request->input('code') !== '00') {
            return response()->json([
                'code'    => '00',
                'message' => 'Notif non-sukses diterima',
            ]);
        }

        $ref = $request->input('ref');
        $vaNumber = $request->input('va');
        $amount = (float) $request->input('amount', 0);

        // 3. Pengecekan Anti-Duplikat (Wajib)
        if ($ref) {
            $alreadyProcessed = Transaksi::where('ref', $ref)->exists();
            if ($alreadyProcessed) {
                return response()->json([
                    'code'    => '00',
                    'message' => 'OK (sudah pernah diproses)',
                ]);
            }
        }

        // 4. Cari rekening nasabah berdasarkan nomor VA (nomor rekening = nomor VA)
        $rekening = Rekening::where('no_rek', $vaNumber)->first();

        if (!$rekening) {
            Log::warning("BPI Callback: Nomor Rekening / VA {$vaNumber} tidak ditemukan di sistem.");
            return response()->json([
                'code'    => '00',
                'message' => 'Nomor VA tidak terdaftar',
            ]);
        }

        // Get Sandi (Setor = 01) & Via (VA/Payment = 102)
        $sandi = SandiTransaksi::where('kode', '01')->orWhere('jenis_transaksi', 'setor')->first();
        $via = ViaTransaksi::where('kode', '102')->first();
        $systemUser = User::where('role', 'adm')->first() ?? User::first();

        if (!$sandi || !$systemUser) {
            Log::error("BPI Callback: Master Sandi atau User Sistem tidak ditemukan.");
            return response()->json([
                'code'    => '01',
                'message' => 'Sistem belum siap menerima transaksi',
            ]);
        }

        // 5. Eksekusi penambahan saldo & pencatatan transaksi dalam DB Transaction
        try {
            DB::transaction(function () use ($rekening, $sandi, $via, $systemUser, $amount, $ref, $request, $vaNumber) {
                // Insert Transaksi Setor
                Transaksi::create([
                    'rekening_id' => $rekening->id,
                    'user_id'     => $systemUser->id,
                    'sandi_id'    => $sandi->id,
                    'via_id'      => $via?->id,
                    'nominal'     => $amount,
                    'ref'         => $ref,
                    'keterangan'  => 'Setoran VA BSI (' . ($request->input('channel') ?? 'Payment') . ') - Ref: ' . $ref,
                    'waktu'       => $request->input('date') ?? now(),
                ]);

                // Saldo dihitung otomatis dari tabel transaksi (via getSaldoAttribute)
                // Jadi kita tidak perlu melakukan $rekening->increment('saldo', $amount);

                // Update status tagihan jika ada yang cocok
                Tagihan::where('nomor_pembayaran', $request->input('number'))
                    ->orWhere('nomor_induk', $vaNumber)
                    ->update([
                        'is_tagihan_aktif' => false,
                    ]);
            });

            Log::info("BPI Callback Sukses: VA {$vaNumber} bertambah Rp " . number_format($amount, 0, ',', '.'));

            return response()->json([
                'code'    => '00',
                'message' => 'OK',
            ]);
        } catch (\Throwable $e) {
            Log::error('BPI Callback Processing Exception: ' . $e->getMessage());
            return response()->json([
                'code'    => '99',
                'message' => 'Gagal memproses transaksi: ' . $e->getMessage(),
            ], 500);
        }
    }
}
