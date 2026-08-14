<?php

namespace App\Http\Controllers;

use App\Models\ViaTransaksi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ViaTransaksiController extends Controller
{
    public function index(Request $req)
    {
        $search = trim($req->input('q', ''));

        $query = ViaTransaksi::withCount('transaksi');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        $vias = $query->orderBy('kode')->paginate(10)->withQueryString();
        
        $totalVia = ViaTransaksi::count();

        return view('admin.via_transaksi.index', compact(
            'vias',
            'search',
            'totalVia'
        ));
    }

    public function store(Request $req)
    {
        $validated = $req->validate([
            'kode' => ['required', 'string', 'max:10', 'unique:via_transaksis,kode'],
            'nama' => ['required', 'string', 'max:50'],
        ], [
            'kode.required' => 'Kode via wajib diisi.',
            'kode.unique' => 'Kode via ini sudah terdaftar.',
            'kode.max' => 'Kode via maksimal 10 karakter.',
            'nama.required' => 'Nama via wajib diisi.',
            'nama.max' => 'Nama via maksimal 50 karakter.',
        ]);

        $via = ViaTransaksi::create($validated);

        if ($req->wantsJson() || $req->ajax() || $req->has('ajax')) {
            return response()->json([
                'success' => true,
                'id' => $via->id,
                'nama' => $via->nama,
                'message' => 'Via transaksi berhasil ditambahkan.',
            ]);
        }

        return redirect()->route('via.index')
            ->with('toast_success', [
                'title' => 'Via Ditambahkan',
                'message' => "Via Transaksi \"{$via->nama}\" berhasil ditambahkan."
            ]);
    }

    public function update(Request $req, ViaTransaksi $via)
    {
        $validated = $req->validate([
            'kode' => ['required', 'string', 'max:10', Rule::unique('via_transaksis', 'kode')->ignore($via->id)],
            'nama' => ['required', 'string', 'max:50'],
        ], [
            'kode.required' => 'Kode via wajib diisi.',
            'kode.unique' => 'Kode via ini sudah terdaftar.',
            'kode.max' => 'Kode via maksimal 10 karakter.',
            'nama.required' => 'Nama via wajib diisi.',
            'nama.max' => 'Nama via maksimal 50 karakter.',
        ]);

        $namaLama = $via->nama;
        $via->update($validated);

        if ($req->wantsJson() || $req->ajax() || $req->has('ajax')) {
            return response()->json([
                'success' => true,
                'id' => $via->id,
                'nama' => $via->nama,
                'message' => 'Via transaksi berhasil diperbarui.',
            ]);
        }

        return redirect()->route('via.index')
            ->with('toast_success', [
                'title' => 'Via Diperbarui',
                'message' => "Via Transaksi \"{$namaLama}\" diubah menjadi \"{$via->nama}\"."
            ]);
    }

    public function destroy(ViaTransaksi $via)
    {
        $nama = $via->nama;

        try {
            $via->delete();
            $msg = "Via Transaksi \"{$nama}\" berhasil dihapus.";
            $flash = 'toast_success';
            $title = 'Via Dihapus';
        } catch (\Illuminate\Database\QueryException $e) {
            if (
                str_contains($e->getMessage(), 'foreign key constraint fails') ||
                str_contains($e->getMessage(), 'Integrity constraint violation')
            ) {
                $msg = "Tidak dapat menghapus Via Transaksi \"{$nama}\" karena masih ada riwayat transaksi yang menggunakan via transaksi ini.";
                $flash = 'toast_error';
                $title = 'Gagal Menghapus';
            } else {
                $msg = "Gagal menghapus via transaksi: " . $e->getMessage();
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

        return redirect()->route('via.index')
            ->with($flash, [
                'title' => $title,
                'message' => $msg
            ]);
    }
}
