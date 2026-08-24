<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class CetakBukuController extends Controller
{
    public function index(Request $request)
    {
        $rekenings = Rekening::with('nasabah')
            ->where('status', true)
            ->get()
            ->sortBy(function ($r) {
                return $r->nasabah?->nama ?? '';
            });

        $selectedRekening = null;
        $formattedTransactions = [];
        $rekeningId = $request->input('rekening_id');

        if ($rekeningId) {
            $selectedRekening = Rekening::with('nasabah')->findOrFail($rekeningId);
            
            // Retrieve all transactions involving this account chronologically
            $transactions = Transaksi::where(function ($q) use ($rekeningId) {
                    $q->where('rekening_id', $rekeningId)
                      ->orWhere('rekening_tujuan_id', $rekeningId);
                })
                ->with(['sandi', 'user.pegawai'])
                ->orderBy('waktu', 'asc')
                ->orderBy('created_at', 'asc')
                ->get();

            $runningBalance = 0;

            foreach ($transactions as $index => $tx) {
                $isSetor = $tx->sandi?->jenis_transaksi === 'setor';
                $isTarik = $tx->sandi?->jenis_transaksi === 'tarik';
                $isTransfer = $tx->sandi?->jenis_transaksi === 'transfer';
                
                $debit = 0;
                $kredit = 0;
                
                if ($isSetor) {
                    $kredit = (float) $tx->nominal;
                    $runningBalance += $kredit;
                } elseif ($isTarik) {
                    $debit = (float) $tx->nominal;
                    $runningBalance -= $debit;
                } elseif ($isTransfer) {
                    if ($tx->rekening_id === $rekeningId) {
                        $debit = (float) $tx->nominal;
                        $runningBalance -= $debit;
                    } else {
                        $kredit = (float) $tx->nominal;
                        $runningBalance += $kredit;
                    }
                }
                
                // Ambil inisial nama atau username
                $paraf = '—';
                if ($tx->user) {
                    $name = $tx->user->pegawai->nama ?? $tx->user->username;
                    $words = explode(' ', trim($name));
                    $initials = '';
                    foreach ($words as $w) {
                        if (!empty($w)) $initials .= strtoupper($w[0]);
                    }
                    $initials = substr($initials, 0, 2); // Maksimal 2 huruf pertama
                    
                    // Tambahkan 2 karakter terakhir UUID agar pasti unik jika inisial sama
                    $suffix = strtoupper(substr(str_replace('-', '', $tx->user->id), -2));
                    $paraf = $initials . $suffix;
                }

                $formattedTransactions[] = [
                    'index' => $index + 1,
                    'id' => $tx->id,
                    'waktu' => $tx->waktu,
                    'sandi' => $tx->sandi?->kode ?? '—',
                    'debit' => $debit > 0 ? $debit : null,
                    'kredit' => $kredit > 0 ? $kredit : null,
                    'saldo' => $runningBalance,
                    'paraf' => $paraf,
                ];
            }
        }

        return view('admin.cetak_buku.index', compact('rekenings', 'selectedRekening', 'formattedTransactions'));
    }
}
