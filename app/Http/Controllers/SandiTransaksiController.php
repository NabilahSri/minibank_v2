<?php

namespace App\Http\Controllers;

use App\Models\SandiTransaksi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SandiTransaksiController extends Controller
{
    public function index(Request $req)
    {
        $search = trim($req->input('q', ''));

        $query = SandiTransaksi::withCount('transaksi');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('jenis_transaksi', 'like', "%{$search}%");
            });
        }

        $sandis = $query->orderBy('kode')->paginate(10)->withQueryString();
        
        $totalSandi = SandiTransaksi::count();
        $totalSetor = SandiTransaksi::where('jenis_transaksi', 'setor')->count();
        $totalTarik = SandiTransaksi::where('jenis_transaksi', 'tarik')->count();
        $totalTransfer = SandiTransaksi::where('jenis_transaksi', 'transfer')->count();

        return view('admin.sandi_transaksi.index', compact(
            'sandis',
            'search',
            'totalSandi',
            'totalSetor',
            'totalTarik',
            'totalTransfer'
        ));
    }

    public function store(Request $req)
    {
        $validated = $req->validate([
            'kode' => ['required', 'string', 'max:10', 'unique:sandi_transaksis,kode'],
            'nama' => ['required', 'string', 'max:50'],
            'jenis_transaksi' => ['required', 'in:setor,tarik,transfer'],
        ], [
            'kode.required' => 'Kode sandi wajib diisi.',
            'kode.unique' => 'Kode sandi ini sudah terdaftar.',
            'kode.max' => 'Kode sandi maksimal 10 karakter.',
            'nama.required' => 'Nama sandi wajib diisi.',
            'nama.max' => 'Nama sandi maksimal 50 karakter.',
            'jenis_transaksi.required' => 'Jenis transaksi wajib dipilih.',
            'jenis_transaksi.in' => 'Jenis transaksi tidak valid.',
        ]);

        $sandi = SandiTransaksi::create($validated);

        if ($req->wantsJson() || $req->ajax() || $req->has('ajax')) {
            return response()->json([
                'success' => true,
                'id' => $sandi->id,
                'nama' => $sandi->nama,
                'message' => 'Sandi transaksi berhasil ditambahkan.',
            ]);
        }

        return redirect()->route('sandi.index')
            ->with('toast_success', [
                'title' => 'Sandi Ditambahkan',
                'message' => "Sandi Transaksi \"{$sandi->nama}\" berhasil ditambahkan."
            ]);
    }

    public function update(Request $req, SandiTransaksi $sandi)
    {
        $validated = $req->validate([
            'kode' => ['required', 'string', 'max:10', Rule::unique('sandi_transaksis', 'kode')->ignore($sandi->id)],
            'nama' => ['required', 'string', 'max:50'],
            'jenis_transaksi' => ['required', 'in:setor,tarik,transfer'],
        ], [
            'kode.required' => 'Kode sandi wajib diisi.',
            'kode.unique' => 'Kode sandi ini sudah terdaftar.',
            'kode.max' => 'Kode sandi maksimal 10 karakter.',
            'nama.required' => 'Nama sandi wajib diisi.',
            'nama.max' => 'Nama sandi maksimal 50 karakter.',
            'jenis_transaksi.required' => 'Jenis transaksi wajib dipilih.',
            'jenis_transaksi.in' => 'Jenis transaksi tidak valid.',
        ]);

        $namaLama = $sandi->nama;
        $sandi->update($validated);

        if ($req->wantsJson() || $req->ajax() || $req->has('ajax')) {
            return response()->json([
                'success' => true,
                'id' => $sandi->id,
                'nama' => $sandi->nama,
                'message' => 'Sandi transaksi berhasil diperbarui.',
            ]);
        }

        return redirect()->route('sandi.index')
            ->with('toast_success', [
                'title' => 'Sandi Diperbarui',
                'message' => "Sandi Transaksi \"{$namaLama}\" diubah menjadi \"{$sandi->nama}\"."
            ]);
    }

    public function destroy(SandiTransaksi $sandi)
    {
        $nama = $sandi->nama;

        try {
            $sandi->delete();
            $msg = "Sandi Transaksi \"{$nama}\" berhasil dihapus.";
            $flash = 'toast_success';
            $title = 'Sandi Dihapus';
        } catch (\Illuminate\Database\QueryException $e) {
            if (
                str_contains($e->getMessage(), 'foreign key constraint fails') ||
                str_contains($e->getMessage(), 'Integrity constraint violation')
            ) {
                $msg = "Tidak dapat menghapus Sandi Transaksi \"{$nama}\" karena masih ada riwayat transaksi yang menggunakan sandi ini.";
                $flash = 'toast_error';
                $title = 'Gagal Menghapus';
            } else {
                $msg = "Gagal menghapus sandi transaksi: " . $e->getMessage();
                $flash = 'toast_error';
                $title = 'Gagal Menghapus';
            }
        }

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => $flash === 'toast_success',
                'message' => $msg,
                'title' => $title,
            ]);
        }

        return redirect()->route('sandi.index')
            ->with($flash, [
                'title' => $title,
                'message' => $msg
            ]);
    }
}
