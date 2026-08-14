<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NasabahController extends Controller
{
    public function index(Request $req)
    {
        $search = trim($req->input('q', ''));
        $kategori = $req->input('kategori', '');
        $status = $req->input('status', '');

        $query = Nasabah::with(['rekening', 'siswa']);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nin', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (in_array($kategori, ['siswa', 'umum'], true)) {
            $query->where('kategori', $kategori);
        }

        if ($status === 'aktif') {
            $query->whereHas('rekening', fn($q) => $q->where('status', true));
        } elseif ($status === 'nonaktif') {
            $query->whereDoesntHave('rekening', fn($q) => $q->where('status', true));
        } elseif ($status === 'belum') {
            $query->doesntHave('rekening');
        }

        $nasabahs = $query->latest()->paginate(10)->withQueryString();

        $totalNasabah = Nasabah::count();
        $totalSiswa = Nasabah::where('kategori', 'siswa')->count();
        $totalUmum = Nasabah::where('kategori', 'umum')->count();
        $totalAktif = Nasabah::whereHas('rekening', fn($q) => $q->where('status', true))->count();

        return view('admin.nasabah.index', compact(
            'nasabahs',
            'search',
            'kategori',
            'status',
            'totalNasabah',
            'totalSiswa',
            'totalUmum',
            'totalAktif'
        ));
    }

    public function create()
    {
        return view('admin.nasabah.create');
    }

    public function store(Request $req)
    {
        $validated = $req->validate([
            'nin'        => ['required', 'string', 'max:50', 'unique:nasabahs,nin'],
            'nama'       => ['required', 'string', 'max:100'],
            'jk'         => ['required', 'string', Rule::in(['L', 'P'])],
            'no_hp'      => ['nullable', 'string', 'max:20'],
            'email'      => ['nullable', 'email', 'max:100'],
            'alamat'     => ['nullable', 'string', 'max:255'],
            'nama_ortu'  => ['nullable', 'string', 'max:100'],
            'kategori'   => ['required', 'string', Rule::in(['siswa', 'umum'])],
            'nisn'       => ['nullable', 'required_if:kategori,siswa', 'string', 'max:50', 'unique:siswas,nisn'],
            'tahun_masuk' => ['nullable', 'required_if:kategori,siswa', 'integer', 'digits:4', 'min:2000', 'max:' . (date('Y') + 1)],
        ], [
            'nin.unique'         => 'NIN sudah terdaftar, silakan gunakan NIN lain.',
            'nisn.unique'        => 'NISN sudah terdaftar, silakan gunakan NISN lain.',
            'nisn.required_if'   => 'NISN wajib diisi untuk kategori Siswa.',
            'tahun_masuk.required_if' => 'Tahun Masuk wajib diisi untuk kategori Siswa.',
        ]);

        $user = User::create([
            'username' => $validated['nin'],
            'password' => bcrypt('smkypc2026'),
            'role' => 'nsb',
        ]);

        $nasabah = Nasabah::create([
            'nin'       => $validated['nin'],
            'user_id' => $user->id,
            'nama'      => $validated['nama'],
            'jk'        => $validated['jk'],
            'no_hp'     => $validated['no_hp'] ?? null,
            'email'     => $validated['email'] ?? null,
            'alamat'    => $validated['alamat'] ?? null,
            'nama_ortu' => $validated['nama_ortu'] ?? null,
            'kategori'  => $validated['kategori'],
        ]);

        if ($validated['kategori'] === 'siswa') {
            $nasabah->siswa()->create([
                'nisn'        => $validated['nisn'],
                'tahun_masuk' => $validated['tahun_masuk'],
            ]);
        }

        return redirect()->route('nasabah.index')
            ->with('toast_success', [
                'title'   => 'Nasabah Ditambahkan',
                'message' => "Data nasabah \"{$nasabah->nama}\" berhasil disimpan."
            ]);
    }

    public function edit(Nasabah $nasabah)
    {
        $nasabah->load(['siswa']);
        return view('admin.nasabah.edit', compact('nasabah'));
    }

    public function update(Request $req, Nasabah $nasabah)
    {
        $validated = $req->validate([
            'nin'        => ['required', 'string', 'max:50', Rule::unique('nasabahs', 'nin')->ignore($nasabah->id)],
            'nama'       => ['required', 'string', 'max:100'],
            'jk'         => ['required', 'string', Rule::in(['L', 'P'])],
            'no_hp'      => ['nullable', 'string', 'max:20'],
            'email'      => ['nullable', 'email', 'max:100'],
            'alamat'     => ['nullable', 'string', 'max:255'],
            'nama_ortu'  => ['nullable', 'string', 'max:100'],
            'kategori'   => ['required', 'string', Rule::in(['siswa', 'umum'])],
            'nisn'       => ['nullable', 'required_if:kategori,siswa', 'string', 'max:50', Rule::unique('siswas', 'nisn')->ignore($nasabah->siswa?->id)],
            'tahun_masuk' => ['nullable', 'required_if:kategori,siswa', 'integer', 'digits:4', 'min:2000', 'max:' . (date('Y') + 1)],
        ], [
            'nin.unique'         => 'NIN sudah terdaftar, silakan gunakan NIN lain.',
            'nisn.unique'        => 'NISN sudah terdaftar, silakan gunakan NISN lain.',
            'nisn.required_if'   => 'NISN wajib diisi untuk kategori Siswa.',
            'tahun_masuk.required_if' => 'Tahun Masuk wajib diisi untuk kategori Siswa.',
        ]);

        $nasabah->update([
            'nin'       => $validated['nin'],
            'nama'      => $validated['nama'],
            'jk'        => $validated['jk'],
            'no_hp'     => $validated['no_hp'] ?? null,
            'email'     => $validated['email'] ?? null,
            'alamat'    => $validated['alamat'] ?? null,
            'nama_ortu' => $validated['nama_ortu'] ?? null,
            'kategori'  => $validated['kategori'],
        ]);

        if ($validated['kategori'] === 'siswa') {
            $nasabah->siswa()->updateOrCreate(
                [],
                [
                    'nisn'        => $validated['nisn'],
                    'tahun_masuk' => $validated['tahun_masuk'],
                ]
            );
        } else {
            if ($nasabah->siswa) {
                $nasabah->siswa->delete();
            }
        }

        return redirect()->route('nasabah.index')
            ->with('toast_success', [
                'title'   => 'Data Diperbarui',
                'message' => "Data nasabah \"{$nasabah->nama}\" berhasil diperbarui."
            ]);
    }

    public function destroy(Nasabah $nasabah)
    {
        $nama = $nasabah->nama;

        try {
            $nasabah->delete();
            $msg = "Data nasabah \"{$nama}\" berhasil dihapus.";
            $flash = 'toast_success';
            $title = 'Nasabah Dihapus';
        } catch (\Illuminate\Database\QueryException $e) {
            if (
                str_contains($e->getMessage(), 'foreign key constraint fails') ||
                str_contains($e->getMessage(), 'Integrity constraint violation')
            ) {
                $msg = "Tidak dapat menghapus \"{$nama}\" karena nasabah masih memiliki data rekening/transaksi terkait.";
                $flash = 'toast_error';
                $title = 'Gagal Menghapus';
            } else {
                $msg = "Gagal menghapus nasabah: " . $e->getMessage();
                $flash = 'toast_error';
                $title = 'Gagal Menghapus';
            }
        }

        return redirect()->route('nasabah.index')
            ->with($flash, [
                'title'   => $title,
                'message' => $msg
            ]);
    }

    public function export(Request $req)
    {
        $search = trim($req->input('q', ''));
        $kategori = $req->input('kategori', '');
        $status = $req->input('status', '');

        $query = Nasabah::with(['rekening', 'siswa']);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nin', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (in_array($kategori, ['siswa', 'umum'], true)) {
            $query->where('kategori', $kategori);
        }

        if ($status === 'aktif') {
            $query->whereHas('rekening', fn($q) => $q->where('status', true));
        } elseif ($status === 'nonaktif') {
            $query->whereDoesntHave('rekening', fn($q) => $q->where('status', true));
        } elseif ($status === 'belum') {
            $query->doesntHave('rekening');
        }

        $data = $query->orderBy('nama')->get();
        $ts = now()->format('Ymd_His');
        $filename = "nasabah_{$ts}.csv";
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $sep = ';';
        $columns = [
            'No',
            'NIN',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Kategori',
            'NISN',
            'Tahun Masuk',
            'No. HP',
            'Email',
            'Alamat',
            'Nama Orang Tua',
            'Jumlah Rekening',
            'Rekening Aktif',
            'Status',
            'Tanggal Daftar',
        ];

        return response()->stream(function () use ($data, $columns, $sep) {
            $fh = fopen('php://output', 'wb');
            fwrite($fh, "\xEF\xBB\xBF");
            $writeRow = function (array $row) use ($fh, $sep) {
                $out = [];
                foreach ($row as $val) {
                    $v = $val === null ? '' : (string) $val;
                    if (
                        str_contains($v, '"') ||
                        str_contains($v, ',') ||
                        str_contains($v, $sep) ||
                        str_contains($v, "\n") ||
                        str_contains($v, "\r")
                    ) {
                        $v = '"' . str_replace('"', '""', $v) . '"';
                    }
                    $out[] = $v;
                }
                fwrite($fh, implode($sep, $out) . "\r\n");
            };
            $writeRow($columns);
            $idx = 1;
            foreach ($data as $nsb) {
                $rekTotal = $nsb->rekening->count();
                $rekAktif = $nsb->rekening->where('status', true)->count();
                if ($rekAktif > 0) {
                    $s = 'Aktif';
                } elseif ($rekTotal > 0) {
                    $s = 'Nonaktif';
                } else {
                    $s = 'Belum Punya Rekening';
                }
                $writeRow([
                    $idx++,
                    $nsb->nin,
                    $nsb->nama,
                    $nsb->jk === 'L' ? 'Laki-laki' : ($nsb->jk === 'P' ? 'Perempuan' : ''),
                    $nsb->kategori === 'siswa' ? 'Siswa' : ($nsb->kategori === 'umum' ? 'Umum' : ($nsb->kategori ?? '')),
                    $nsb->siswa?->nisn ?? '',
                    $nsb->siswa?->tahun_masuk ?? '',
                    $nsb->no_hp ?? '',
                    $nsb->email ?? '',
                    $nsb->alamat ?? '',
                    $nsb->nama_ortu ?? '',
                    $rekTotal,
                    $rekAktif,
                    $s,
                    $nsb->created_at ? $nsb->created_at->format('d-m-Y H:i:s') : '',
                ]);
            }
            fclose($fh);
        }, 200, $headers);
    }
}
