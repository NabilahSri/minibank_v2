<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use App\Models\Transaksi;
use App\Models\SandiTransaksi;
use App\Models\ViaTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TransaksiController extends Controller
{
    public function index(Request $req)
    {
        $search = trim($req->input('q', ''));

        $rekenings = Rekening::with(['nasabah'])
            ->where('status', true)
            ->get()
            ->sortBy(function ($rek) {
                return $rek->nasabah?->nama ?? '';
            });

        $query = Transaksi::with(['rekeningAsal.nasabah', 'sandi'])
            ->whereHas('sandi', function ($q) {
                $q->whereIn('jenis_transaksi', ['setor', 'tarik']);
            });

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->whereHas('rekeningAsal.nasabah', function ($sq) use ($search) {
                    $sq->where('nama', 'like', "%{$search}%");
                })->orWhereHas('rekeningAsal', function ($sq) use ($search) {
                    $sq->where('no_rek', 'like', "%{$search}%");
                });
            });
        }

        $transaksis = $query->latest('waktu')->paginate(10)->withQueryString();

        return view('admin.transaksi.index', compact('rekenings', 'transaksis', 'search'));
    }

    public function store(Request $req)
    {
        $validated = $req->validate([
            'rekening_id' => ['required', 'uuid', 'exists:rekenings,id'],
            'jenis_transaksi' => ['required', 'in:setor,tarik'],
            'nominal' => ['required', 'numeric', 'min:1000'],
            'pin' => ['nullable', 'string'],
        ], [
            'rekening_id.required' => 'Pilih nasabah terlebih dahulu.',
            'rekening_id.exists' => 'Rekening tidak ditemukan.',
            'nominal.required' => 'Nominal transaksi wajib diisi.',
            'nominal.min' => 'Nominal transaksi minimal Rp 1.000.',
        ]);

        $rekening = Rekening::findOrFail($validated['rekening_id']);

        if ($validated['jenis_transaksi'] === 'tarik') {
            if (empty($req->pin)) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['pin' => 'PIN wajib diisi untuk melakukan penarikan.']);
            }

            if (!Hash::check($req->pin, $rekening->pin)) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['pin' => 'PIN yang Anda masukkan salah.']);
            }

            if ($rekening->saldo < $validated['nominal']) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['nominal' => 'Saldo rekening tidak mencukupi untuk melakukan penarikan.']);
            }
        }

        $sandi = SandiTransaksi::where('jenis_transaksi', $validated['jenis_transaksi'])->first();
        $via = ViaTransaksi::where('kode', '101')->first();

        Transaksi::create([
            'rekening_id' => $rekening->id,
            'user_id' => Auth::id(),
            'sandi_id' => $sandi->id,
            'via_id' => $via->id,
            'nominal' => $validated['nominal'],
            'waktu' => now(),
            'keterangan' => $validated['jenis_transaksi'] === 'setor' ? 'Setoran Tunai' : 'Penarikan Tunai',
        ]);

        $typeName = $validated['jenis_transaksi'] === 'setor' ? 'Setoran' : 'Penarikan';
        $successMsg = "Transaksi {$typeName} sebesar Rp " . number_format($validated['nominal'], 0, ',', '.') . " untuk rekening {$rekening->no_rek} atas nama \"{$rekening->nasabah->nama}\" berhasil diproses.";

        return redirect()->route('transaksi.index')
            ->with('toast_success', [
                'title' => 'Transaksi Berhasil',
                'message' => $successMsg
            ]);
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return redirect()->route('transaksi.index')
            ->with('toast_success', [
                'title' => 'Transaksi Dibatalkan',
                'message' => 'Transaksi berhasil dibatalkan dan dihapus dari sistem.'
            ]);
    }
}
