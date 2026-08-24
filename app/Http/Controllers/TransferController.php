<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Rekening;
use App\Models\Subrekening;
use App\Models\SandiTransaksi;
use App\Models\ViaTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    public function index(Request $req)
    {
        $search = trim($req->input('q', ''));

        // Load active accounts for Sender (Pengirim)
        $rekenings = Rekening::with(['nasabah.siswa'])
            ->where('status', true)
            ->get()
            ->sortBy(function ($rek) {
                return $rek->nasabah?->nama ?? '';
            });

        // Load all active accounts for Destination (Tujuan)
        $rekeningTujuans = Rekening::with(['nasabah', 'subrekening'])
            ->where('status', true)
            ->get()
            ->sortBy(function ($rek) {
                return $rek->nasabah?->nama ?? '';
            });

        // Map subrekenings with their name, code, nominal, and payment year
        $subrekeningMapping = [];
        foreach ($rekeningTujuans as $rek) {
            $subrekeningMapping[$rek->id] = $rek->subrekening->map(function ($sub) {
                return [
                    'value' => $sub->id,
                    'label' => $sub->kode_subrekening . ' - ' . $sub->subrekening . ' (' . $sub->tahun_pembayaran . ')',
                    'nominal' => (float) $sub->nominal,
                    'tahun' => (int) $sub->tahun_pembayaran,
                ];
            })->toArray();
        }

        // Query transfer transactions
        $query = Transaksi::with(['rekeningAsal.nasabah', 'rekeningTujuan.nasabah', 'subrekening', 'sandi'])
            ->whereHas('sandi', function ($q) {
                $q->where('jenis_transaksi', 'transfer');
            })
            ->whereDate('waktu', today());

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->whereHas('rekeningAsal.nasabah', function ($sq) use ($search) {
                    $sq->where('nama', 'like', "%{$search}%");
                })->orWhereHas('rekeningAsal', function ($sq) use ($search) {
                    $sq->where('no_rek', 'like', "%{$search}%");
                })->orWhereHas('rekeningTujuan.nasabah', function ($sq) use ($search) {
                    $sq->where('nama', 'like', "%{$search}%");
                })->orWhereHas('rekeningTujuan', function ($sq) use ($search) {
                    $sq->where('no_rek', 'like', "%{$search}%");
                });
            });
        }

        $transaksis = $query->latest()->paginate(10)->withQueryString();

        return view('admin.transfer.index', compact('rekenings', 'rekeningTujuans', 'subrekeningMapping', 'transaksis', 'search'));
    }

    public function store(Request $req)
    {
        $validated = $req->validate([
            'rekening_id' => ['required', 'uuid', 'exists:rekenings,id'],
            'rekening_tujuan_id' => ['required', 'uuid', 'exists:rekenings,id', 'different:rekening_id'],
            'subrekening_id' => ['nullable', 'uuid', 'exists:subrekenings,id'],
            'nominal' => ['required', 'numeric', 'min:1000'],
            'keterangan' => ['nullable', 'string'],
        ], [
            'rekening_id.required' => 'Rekening pengirim wajib dipilih.',
            'rekening_tujuan_id.required' => 'Rekening tujuan wajib dipilih.',
            'rekening_tujuan_id.different' => 'Rekening tujuan harus berbeda dari rekening pengirim.',
            'nominal.required' => 'Nominal transfer wajib diisi.',
            'nominal.min' => 'Nominal transfer minimal Rp 1.000.',
        ]);

        $rekeningAsal = Rekening::with('nasabah.siswa')->findOrFail($validated['rekening_id']);
        $rekeningTujuan = Rekening::with('subrekening')->findOrFail($validated['rekening_tujuan_id']);

        $hasSubrekenings = $rekeningTujuan->subrekening->isNotEmpty();
        $subrekeningId = null;
        $keteranganDefault = 'Transfer Tabungan';

        if ($hasSubrekenings) {
            // subrekening_id is required
            if (empty($validated['subrekening_id'])) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['subrekening_id' => 'Sub rekening wajib dipilih untuk rekening tujuan ini.']);
            }

            $subrekening = Subrekening::findOrFail($validated['subrekening_id']);

            // Verify subrekening ownership
            if ($subrekening->rekening_id !== $validated['rekening_tujuan_id']) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['subrekening_id' => 'Sub rekening tidak sesuai dengan rekening tujuan yang dipilih.']);
            }

            // Verify year match (student only)
            if ($rekeningAsal->nasabah?->siswa) {
                $tahunMasuk = $rekeningAsal->nasabah->siswa->tahun_masuk;
                if ($subrekening->tahun_pembayaran != $tahunMasuk) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['subrekening_id' => "Tahun pembayaran subrekening ({$subrekening->tahun_pembayaran}) tidak cocok dengan tahun masuk nasabah pengirim ({$tahunMasuk})."]);
                }
            }

            $subrekeningId = $subrekening->id;
            $keteranganDefault = 'Transfer Pembayaran ' . $subrekening->subrekening;
        }

        // Verify sender balance
        if ($rekeningAsal->saldo < $validated['nominal']) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nominal' => 'Saldo rekening pengirim tidak mencukupi untuk melakukan transfer.']);
        }

        $sandi = SandiTransaksi::where('kode', '04')->first();
        if (!$sandi) {
            $sandi = SandiTransaksi::where('jenis_transaksi', 'transfer')->first();
        }

        Transaksi::create([
            'rekening_id' => $rekeningAsal->id,
            'rekening_tujuan_id' => $rekeningTujuan->id,
            'subrekening_id' => $subrekeningId,
            'user_id' => Auth::id(),
            'sandi_id' => $sandi->id,
            'nominal' => $validated['nominal'],
            'keterangan' => $validated['keterangan'] ?? $keteranganDefault,
            'waktu' => now(),
        ]);

        $successMsg = "Transfer sebesar Rp " . number_format($validated['nominal'], 0, ',', '.') . " dari rekening {$rekeningAsal->no_rek} ke {$rekeningTujuan->no_rek} berhasil diproses.";

        return redirect()->route('transfer.index')
            ->with('toast_success', [
                'title' => 'Transfer Berhasil',
                'message' => $successMsg
            ]);
    }

    public function destroy(Transaksi $transaksi)
    {
        if ($transaksi->sandi?->jenis_transaksi !== 'transfer') {
            abort(403);
        }

        $transaksi->delete();

        return redirect()->route('transfer.index')
            ->with('toast_success', [
                'title' => 'Transfer Dibatalkan',
                'message' => 'Transaksi transfer berhasil dibatalkan dan dihapus dari sistem.'
            ]);
    }
}
