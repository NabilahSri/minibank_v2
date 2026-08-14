<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PegawaiController extends Controller
{
    public function index(Request $req)
    {
        $search = trim($req->input('q', ''));
        $role = $req->input('role', '');
        $lokasiId = $req->input('lokasi_id', '');

        $query = Pegawai::with(['user', 'lokasi']);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (in_array($role, ['adm', 'opr'], true)) {
            $query->whereHas('user', fn($q) => $q->where('role', $role));
        }

        if ($lokasiId !== '') {
            $query->where('lokasi_id', $lokasiId);
        }

        $pegawais = $query->latest()->paginate(10)->withQueryString();

        $totalPegawai = Pegawai::count();
        $totalAdmin = Pegawai::whereHas('user', fn($q) => $q->where('role', 'adm'))->count();
        $totalOperator = Pegawai::whereHas('user', fn($q) => $q->where('role', 'opr'))->count();
        $totalLokasi = Lokasi::count();
        $lokasis = Lokasi::orderBy('nama_lokasi')->get(['id', 'nama_lokasi']);

        return view('admin.pegawai.index', compact(
            'pegawais',
            'search',
            'role',
            'lokasiId',
            'totalPegawai',
            'totalAdmin',
            'totalOperator',
            'totalLokasi',
            'lokasis'
        ));
    }

    public function create()
    {
        $lokasis = Lokasi::orderBy('nama_lokasi')->get(['id', 'nama_lokasi']);
        return view('admin.pegawai.create', compact('lokasis'));
    }

    public function store(Request $req)
    {
        $validated = $req->validate([
            'nip'        => ['required', 'string', 'max:20', 'unique:pegawais,nip'],
            'nama'       => ['required', 'string', 'max:100'],
            'jk'         => ['required', 'string', Rule::in(['L', 'P'])],
            'role'       => ['required', 'string', Rule::in(['adm', 'opr'])],
            'lokasi_id'  => ['required', 'uuid', 'exists:lokasis,id'],
            'no_hp'      => ['nullable', 'string', 'max:20'],
            'email'      => ['nullable', 'email', 'max:100'],
            'alamat'     => ['nullable', 'string', 'max:255'],
            'username'   => ['required', 'string', 'max:50', 'unique:users,username'],
            'password'   => ['required', 'string', 'min:6', 'max:100'],
        ], [
            'nip.unique'   => 'NIP sudah terdaftar, gunakan NIP lain.',
            'username.unique' => 'Username sudah terpakai, gunakan username lain.',
            'lokasi_id.required' => 'Lokasi kerja wajib dipilih.',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'password' => bcrypt($validated['password']),
            'role'     => $validated['role'],
        ]);

        $pegawai = Pegawai::create([
            'user_id'    => $user->id,
            'lokasi_id'  => $validated['lokasi_id'],
            'nip'        => $validated['nip'],
            'nama'       => $validated['nama'],
            'jk'         => $validated['jk'],
            'no_hp'      => $validated['no_hp'] ?? null,
            'email'      => $validated['email'] ?? null,
            'alamat'     => $validated['alamat'] ?? null,
        ]);

        return redirect()->route('pegawai.index')
            ->with('toast_success', [
                'title'   => 'Pegawai Ditambahkan',
                'message' => "Data pegawai \"{$pegawai->nama}\" berhasil disimpan."
            ]);
    }

    public function edit(Pegawai $pegawai)
    {
        $pegawai->load(['user', 'lokasi']);
        $lokasis = Lokasi::orderBy('nama_lokasi')->get(['id', 'nama_lokasi']);
        return view('admin.pegawai.edit', compact('pegawai', 'lokasis'));
    }

    public function update(Request $req, Pegawai $pegawai)
    {
        $validated = $req->validate([
            'nip'        => ['required', 'string', 'max:20', Rule::unique('pegawais', 'nip')->ignore($pegawai->id)],
            'nama'       => ['required', 'string', 'max:100'],
            'jk'         => ['required', 'string', Rule::in(['L', 'P'])],
            'role'       => ['required', 'string', Rule::in(['adm', 'opr'])],
            'lokasi_id'  => ['required', 'uuid', 'exists:lokasis,id'],
            'no_hp'      => ['nullable', 'string', 'max:20'],
            'email'      => ['nullable', 'email', 'max:100'],
            'alamat'     => ['nullable', 'string', 'max:255'],
            'username'   => ['required', 'string', 'max:50', Rule::unique('users', 'username')->ignore($pegawai->user_id)],
            'password'   => ['nullable', 'string', 'min:6', 'max:100'],
        ], [
            'nip.unique'   => 'NIP sudah terdaftar, gunakan NIP lain.',
            'username.unique' => 'Username sudah terpakai, gunakan username lain.',
            'lokasi_id.required' => 'Lokasi kerja wajib dipilih.',
        ]);

        $pegawai->update([
            'lokasi_id'  => $validated['lokasi_id'],
            'nip'        => $validated['nip'],
            'nama'       => $validated['nama'],
            'jk'         => $validated['jk'],
            'no_hp'      => $validated['no_hp'] ?? null,
            'email'      => $validated['email'] ?? null,
            'alamat'     => $validated['alamat'] ?? null,
        ]);

        $userUpdate = [
            'username' => $validated['username'],
            'role'     => $validated['role'],
        ];
        if (!empty($validated['password'])) {
            $userUpdate['password'] = bcrypt($validated['password']);
        }
        $pegawai->user()->update($userUpdate);

        return redirect()->route('pegawai.index')
            ->with('toast_success', [
                'title'   => 'Data Diperbarui',
                'message' => "Data pegawai \"{$pegawai->nama}\" berhasil diperbarui."
            ]);
    }

    public function destroy(Pegawai $pegawai)
    {
        $nama = $pegawai->nama;

        try {
            $pegawai->user()->delete();
            $pegawai->delete();
            $msg = "Data pegawai \"{$nama}\" berhasil dihapus.";
            $flash = 'toast_success';
            $title = 'Pegawai Dihapus';
        } catch (\Illuminate\Database\QueryException $e) {
            if (
                str_contains($e->getMessage(), 'foreign key constraint fails') ||
                str_contains($e->getMessage(), 'Integrity constraint violation')
            ) {
                $msg = "Tidak dapat menghapus \"{$nama}\" karena pegawai masih memiliki data transaksi/rekening terkait.";
                $flash = 'toast_error';
                $title = 'Gagal Menghapus';
            } else {
                $msg = "Gagal menghapus pegawai: " . $e->getMessage();
                $flash = 'toast_error';
                $title = 'Gagal Menghapus';
            }
        }

        return redirect()->route('pegawai.index')
            ->with($flash, [
                'title'   => $title,
                'message' => $msg
            ]);
    }

    public function export(Request $req)
    {
        $search = trim($req->input('q', ''));
        $role = $req->input('role', '');
        $lokasiId = $req->input('lokasi_id', '');

        $query = Pegawai::with(['user', 'lokasi']);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('no_hp', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (in_array($role, ['adm', 'opr'], true)) {
            $query->whereHas('user', fn($q) => $q->where('role', $role));
        }

        if ($lokasiId !== '') {
            $query->where('lokasi_id', $lokasiId);
        }

        $data = $query->orderBy('nama')->get();
        $ts = now()->format('Ymd_His');
        $filename = "pegawai_{$ts}.csv";
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
            'NIP',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Role',
            'Username',
            'Lokasi Kerja',
            'No. HP',
            'Email',
            'Alamat',
            'Tanggal Bergabung',
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
            foreach ($data as $pgw) {
                $r = $pgw->user?->role ?? '';
                if ($r === 'adm') {
                    $roleLabel = 'Admin';
                } elseif ($r === 'opr') {
                    $roleLabel = 'Operator';
                } else {
                    $roleLabel = $r;
                }
                $writeRow([
                    $idx++,
                    $pgw->nip,
                    $pgw->nama,
                    $pgw->jk === 'L' ? 'Laki-laki' : ($pgw->jk === 'P' ? 'Perempuan' : ''),
                    $roleLabel,
                    $pgw->user?->username ?? '',
                    $pgw->lokasi?->nama_lokasi ?? '',
                    $pgw->no_hp ?? '',
                    $pgw->email ?? '',
                    $pgw->alamat ?? '',
                    $pgw->created_at ? $pgw->created_at->format('d-m-Y H:i:s') : '',
                ]);
            }
            fclose($fh);
        }, 200, $headers);
    }
}
