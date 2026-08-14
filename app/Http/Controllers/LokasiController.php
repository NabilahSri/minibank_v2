<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LokasiController extends Controller
{
    public function index(Request $req)
    {
        $search = trim($req->input('q', ''));

        $query = Lokasi::withCount('pegawai');

        if ($search !== '') {
            $query->where('nama_lokasi', 'like', "%{$search}%");
        }

        $lokasis = $query->latest()->paginate(10)->withQueryString();
        $totalLokasi = Lokasi::count();
        $totalPegawaiOnLokasi = Lokasi::withCount('pegawai')->get()->sum('pegawai_count');

        return view('admin.lokasi.index', compact(
            'lokasis',
            'search',
            'totalLokasi',
            'totalPegawaiOnLokasi'
        ));
    }

    public function store(Request $req)
    {
        $validated = $req->validate([
            'nama_lokasi' => ['required', 'string', 'max:100', 'unique:lokasis,nama_lokasi'],
        ], [
            'nama_lokasi.required' => 'Nama lokasi wajib diisi.',
            'nama_lokasi.unique'   => 'Nama lokasi ini sudah ada, gunakan nama lain.',
            'nama_lokasi.max'      => 'Nama lokasi maksimal 100 karakter.',
        ]);

        $lokasi = Lokasi::create(['nama_lokasi' => $validated['nama_lokasi']]);

        if ($req->wantsJson() || $req->ajax() || $req->has('ajax')) {
            return response()->json([
                'success' => true,
                'id'      => $lokasi->id,
                'nama'    => $lokasi->nama_lokasi,
                'message' => 'Lokasi berhasil ditambahkan.',
            ]);
        }

        return redirect()->route('lokasi.index')
            ->with('toast_success', [
                'title'   => 'Lokasi Ditambahkan',
                'message' => "Lokasi \"{$lokasi->nama_lokasi}\" berhasil ditambahkan."
            ]);
    }

    public function update(Request $req, Lokasi $lokasi)
    {
        $validated = $req->validate([
            'nama_lokasi' => ['required', 'string', 'max:100', Rule::unique('lokasis', 'nama_lokasi')->ignore($lokasi->id)],
        ], [
            'nama_lokasi.required' => 'Nama lokasi wajib diisi.',
            'nama_lokasi.unique'   => 'Nama lokasi ini sudah ada, gunakan nama lain.',
        ]);

        $namaLama = $lokasi->nama_lokasi;
        $lokasi->update(['nama_lokasi' => $validated['nama_lokasi']]);

        if ($req->wantsJson() || $req->ajax() || $req->has('ajax')) {
            return response()->json([
                'success' => true,
                'id'      => $lokasi->id,
                'nama'    => $lokasi->nama_lokasi,
                'message' => 'Lokasi berhasil diperbarui.',
            ]);
        }

        return redirect()->route('lokasi.index')
            ->with('toast_success', [
                'title'   => 'Lokasi Diperbarui',
                'message' => "Lokasi \"{$namaLama}\" diubah menjadi \"{$lokasi->nama_lokasi}\"."
            ]);
    }

    public function destroy(Lokasi $lokasi)
    {
        $nama = $lokasi->nama_lokasi;

        try {
            $lokasi->delete();
            $msg = "Lokasi \"{$nama}\" berhasil dihapus.";
            $flash = 'toast_success';
            $title = 'Lokasi Dihapus';
        } catch (\Illuminate\Database\QueryException $e) {
            if (
                str_contains($e->getMessage(), 'foreign key constraint fails') ||
                str_contains($e->getMessage(), 'Integrity constraint violation')
            ) {
                $msg = "Tidak dapat menghapus lokasi \"{$nama}\" karena masih ada pegawai yang terdaftar di lokasi ini. Pindahkan dulu pegawai-nya.";
                $flash = 'toast_error';
                $title = 'Gagal Menghapus';
            } else {
                $msg = "Gagal menghapus lokasi: " . $e->getMessage();
                $flash = 'toast_error';
                $title = 'Gagal Menghapus';
            }
        }

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => $flash === 'toast_success',
                'message' => $msg,
                'title'   => $title,
            ]);
        }

        return redirect()->route('lokasi.index')
            ->with($flash, [
                'title'   => $title,
                'message' => $msg
            ]);
    }
}
