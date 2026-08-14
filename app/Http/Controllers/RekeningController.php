<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use App\Models\Nasabah;
use App\Models\Subrekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RekeningController extends Controller
{
    public function index(Request $req)
    {
        $search = trim($req->input('q', ''));
        $status = $req->input('status', '');
        $kategoriNasabah = $req->input('kategori_nasabah', '');

        $query = Rekening::with(['nasabah.siswa', 'user.pegawai']);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('no_rek', 'like', "%{$search}%")
                    ->orWhereHas('nasabah', function ($sq) use ($search) {
                        $sq->where('nama', 'like', "%{$search}%")
                            ->orWhere('nin', 'like', "%{$search}%");
                    });
            });
        }

        if ($status === 'aktif') {
            $query->where('status', true);
        } elseif ($status === 'nonaktif') {
            $query->where('status', false);
        }

        if (in_array($kategoriNasabah, ['siswa', 'umum'], true)) {
            $query->whereHas('nasabah', fn($sq) => $sq->where('kategori', $kategoriNasabah));
        }

        $rekenings = $query->latest()->paginate(10)->withQueryString();

        $totalRekening = Rekening::count();
        $totalAktif = Rekening::where('status', true)->count();
        $totalNonaktif = Rekening::where('status', false)->count();
        $totalRekSiswa = Rekening::whereHas('nasabah', fn($q) => $q->where('kategori', 'siswa'))->count();

        return view('admin.rekening.index', compact(
            'rekenings',
            'search',
            'status',
            'kategoriNasabah',
            'totalRekening',
            'totalAktif',
            'totalNonaktif',
            'totalRekSiswa'
        ));
    }

    public function create()
    {
        $nasabahs = Nasabah::with(['siswa'])
            ->orderBy('nama')
            ->get(['id', 'nin', 'nama', 'jk', 'kategori']);

        return view('admin.rekening.create', compact('nasabahs'));
    }

    public function store(Request $req)
    {
        $validated = $req->validate([
            'nasabah_id' => ['required', 'uuid', 'exists:nasabahs,id'],
            'no_rek'     => ['required', 'string', 'max:20', 'unique:rekenings,no_rek'],
            'pin'        => ['required', 'string', 'digits:6'],
            'pin_confirm' => ['required', 'string', 'same:pin'],
            'status'     => ['nullable', 'boolean'],
        ], [
            'nasabah_id.required' => 'Pilih nasabah terlebih dahulu.',
            'nasabah_id.exists'   => 'Nasabah tidak ditemukan.',
            'no_rek.unique'       => 'Nomor rekening sudah terdaftar.',
            'pin.digits'          => 'PIN harus 6 digit angka.',
            'pin_confirm.same'    => 'Konfirmasi PIN tidak cocok.',
        ]);

        $rekening = Rekening::create([
            'nasabah_id' => $validated['nasabah_id'],
            'user_id'    => Auth::user()->id,
            'no_rek'     => $validated['no_rek'],
            'pin'        => Hash::make($validated['pin']),
            'status'     => (bool) ($validated['status'] ?? true),
        ]);

        $rekening->load(['nasabah']);

        return redirect()->route('rekening.index')
            ->with('toast_success', [
                'title'   => 'Rekening Dibuat',
                'message' => "Rekening {$rekening->no_rek} atas nama \"{$rekening->nasabah->nama}\" berhasil dibuat."
            ]);
    }

    public function edit(Rekening $rekening)
    {
        $rekening->load(['nasabah.siswa', 'user']);
        $nasabahs = Nasabah::orderBy('nama')->get(['id', 'nin', 'nama', 'jk', 'kategori']);

        return view('admin.rekening.edit', compact('rekening', 'nasabahs'));
    }

    public function subrekening(Rekening $rekening)
    {
        $rekening->load(['nasabah.siswa', 'subrekening' => function ($query) {
            $query->latest();
        }]);

        return view('admin.rekening.subrekening', compact('rekening'));
    }

    public function editSubrekening(Rekening $rekening, Subrekening $subrekening)
    {
        abort_unless($subrekening->rekening_id === $rekening->id, 404);

        $rekening->load(['nasabah.siswa', 'subrekening' => function ($query) {
            $query->latest();
        }]);

        return view('admin.rekening.subrekening', compact('rekening', 'subrekening'));
    }

    public function storeSubrekening(Request $req, Rekening $rekening)
    {
        $validated = $req->validate([
            'kode_subrekening' => ['required', 'string', 'max:10'],
            'subrekening' => ['required', 'string', 'max:100'],
            'tahun_pembayaran' => ['required', 'digits:4', 'integer', 'min:2000', 'max:' . now()->addYears(5)->year],
            'kategori' => ['required', Rule::in(['umum', 'siswa'])],
            'nominal' => ['required', 'numeric', 'min:0'],
        ], [
            'kode_subrekening.required' => 'Kode sub rekening wajib diisi.',
            'subrekening.required' => 'Nama sub rekening wajib diisi.',
            'tahun_pembayaran.required' => 'Tahun pembayaran wajib diisi.',
            'kategori.required' => 'Kategori wajib dipilih.',
            'nominal.required' => 'Nominal wajib diisi.',
        ]);

        $rekening->subrekening()->create($validated);

        return redirect()->route('rekening.subrekening', $rekening)
            ->with('toast_success', [
                'title' => 'Sub Rekening Disimpan',
                'message' => 'Sub rekening baru berhasil ditambahkan ke rekening ' . $rekening->no_rek . '.',
            ]);
    }

    public function updateSubrekening(Request $req, Rekening $rekening, Subrekening $subrekening)
    {
        abort_unless($subrekening->rekening_id === $rekening->id, 404);

        $validated = $req->validate([
            'kode_subrekening' => ['required', 'string', 'max:10'],
            'subrekening' => ['required', 'string', 'max:100'],
            'tahun_pembayaran' => ['required', 'digits:4', 'integer', 'min:2000', 'max:' . now()->addYears(5)->year],
            'kategori' => ['required', Rule::in(['umum', 'siswa'])],
            'nominal' => ['required', 'numeric', 'min:0'],
        ], [
            'kode_subrekening.required' => 'Kode sub rekening wajib diisi.',
            'subrekening.required' => 'Nama sub rekening wajib diisi.',
            'tahun_pembayaran.required' => 'Tahun pembayaran wajib diisi.',
            'kategori.required' => 'Kategori wajib dipilih.',
            'nominal.required' => 'Nominal wajib diisi.',
        ]);

        $subrekening->update($validated);

        return redirect()->route('rekening.subrekening', $rekening)
            ->with('toast_success', [
                'title' => 'Sub Rekening Diperbarui',
                'message' => 'Sub rekening ' . $subrekening->kode_subrekening . ' berhasil diperbarui.',
            ]);
    }

    public function destroySubrekening(Rekening $rekening, Subrekening $subrekening)
    {
        abort_unless($subrekening->rekening_id === $rekening->id, 404);

        $nama = $subrekening->subrekening;
        $rekeningNo = $rekening->no_rek;

        $subrekening->delete();

        return redirect()->route('rekening.subrekening', $rekening)
            ->with('toast_success', [
                'title' => 'Sub Rekening Dihapus',
                'message' => "Sub rekening {$nama} pada rekening {$rekeningNo} berhasil dihapus.",
            ]);
    }

    public function memberSubrekening(Request $req, Rekening $rekening, Subrekening $subrekening)
    {
        abort_unless($subrekening->rekening_id === $rekening->id, 404);

        $search = trim($req->input('q', ''));

        $rekening->load(['nasabah.siswa']);
        $subrekening->load(['rekening']);

        $query = $subrekening->anggotaGroup()->with(['nasabah']);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('no_rek', 'like', "%{$search}%")
                    ->orWhereHas('nasabah', function ($sq) use ($search) {
                        $sq->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        $members = $query->latest()->paginate(10)->withQueryString();

        $existingMemberIds = $subrekening->anggotaGroup()->pluck('rekenings.id')->toArray();
        $availableRekenings = Rekening::with(['nasabah'])
            ->where('id', '!=', $rekening->id)
            ->whereNotIn('id', $existingMemberIds)
            ->where('status', true)
            ->get();

        // dd($availableRekenings);

        return view('admin.rekening.member_subrekening', compact('rekening', 'subrekening', 'members', 'availableRekenings', 'search'));
    }

    public function storeMemberSubrekening(Request $req, Rekening $rekening, Subrekening $subrekening)
    {
        abort_unless($subrekening->rekening_id === $rekening->id, 404);

        $validated = $req->validate([
            'rekening_id' => [
                'required',
                'uuid',
                'exists:rekenings,id',
            ]
        ], [
            'rekening_id.required' => 'Pilih member nasabah terlebih dahulu.',
            'rekening_id.exists' => 'Rekening tidak ditemukan.',
        ]);

        if ($validated['rekening_id'] === $rekening->id) {
            return redirect()->back()->withErrors(['rekening_id' => 'Rekening utama tidak dapat menjadi member diri sendiri.']);
        }

        $subrekening->anggotaGroup()->syncWithoutDetaching([$validated['rekening_id']]);

        $memberRekening = Rekening::with('nasabah')->find($validated['rekening_id']);

        return redirect()->route('rekening.subrekening.member', [$rekening, $subrekening])
            ->with('toast_success', [
                'title' => 'Member Ditambahkan',
                'message' => 'Rekening ' . $memberRekening->no_rek . ' (' . ($memberRekening->nasabah?->nama ?? '-') . ') berhasil ditambahkan sebagai member.',
            ]);
    }

    public function destroyMemberSubrekening(Rekening $rekening, Subrekening $subrekening, Rekening $memberRekening)
    {
        abort_unless($subrekening->rekening_id === $rekening->id, 404);

        $subrekening->anggotaGroup()->detach($memberRekening->id);

        return redirect()->route('rekening.subrekening.member', [$rekening, $subrekening])
            ->with('toast_success', [
                'title' => 'Member Dihapus',
                'message' => 'Member ' . ($memberRekening->nasabah?->nama ?? '-') . ' berhasil dihapus dari group pembayaran.',
            ]);
    }

    public function update(Request $req, Rekening $rekening)
    {
        $validated = $req->validate([
            'nasabah_id'  => ['required', 'uuid', 'exists:nasabahs,id'],
            'no_rek'      => ['required', 'string', 'max:20', Rule::unique('rekenings', 'no_rek')->ignore($rekening->id)],
            'status'      => ['nullable', 'boolean'],
            'ganti_pin'   => ['nullable', 'boolean'],
            'pin'         => ['nullable', 'required_if:ganti_pin,1', 'string', 'digits:6'],
            'pin_confirm' => ['nullable', 'required_if:ganti_pin,1', 'string', 'same:pin'],
        ], [
            'nasabah_id.required'   => 'Pilih nasabah terlebih dahulu.',
            'nasabah_id.exists'     => 'Nasabah tidak ditemukan.',
            'no_rek.unique'         => 'Nomor rekening sudah terdaftar.',
            'pin.required_if'       => 'PIN wajib diisi jika centang ganti PIN.',
            'pin.digits'            => 'PIN harus 6 digit angka.',
            'pin_confirm.required_if' => 'Konfirmasi PIN wajib diisi.',
            'pin_confirm.same'      => 'Konfirmasi PIN tidak cocok.',
        ]);

        $data = [
            'nasabah_id' => $validated['nasabah_id'],
            'no_rek'     => $validated['no_rek'],
            'status'     => (bool) ($validated['status'] ?? false),
        ];

        if (!empty($validated['ganti_pin']) && !empty($validated['pin'])) {
            $data['pin'] = Hash::make($validated['pin']);
        }

        $rekening->update($data);
        $rekening->load(['nasabah']);

        return redirect()->route('rekening.index')
            ->with('toast_success', [
                'title'   => 'Rekening Diperbarui',
                'message' => "Data rekening {$rekening->no_rek} atas nama \"{$rekening->nasabah->nama}\" berhasil diperbarui."
            ]);
    }

    public function destroy(Rekening $rekening)
    {
        $noRek = $rekening->no_rek;
        $nama = $rekening->nasabah?->nama ?? 'nasabah';

        try {
            $rekening->delete();
            $flash = 'toast_success';
            $title = 'Rekening Dihapus';
            $msg = "Rekening {$noRek} atas nama \"{$nama}\" berhasil dihapus.";
        } catch (\Illuminate\Database\QueryException $e) {
            if (
                str_contains($e->getMessage(), 'foreign key constraint fails') ||
                str_contains($e->getMessage(), 'Integrity constraint violation')
            ) {
                $msg = "Tidak dapat menghapus rekening {$noRek} karena masih ada subrekening/transaksi terkait.";
            } else {
                $msg = "Gagal menghapus rekening: " . $e->getMessage();
            }
            $flash = 'toast_error';
            $title = 'Gagal Menghapus';
        }

        return redirect()->route('rekening.index')
            ->with($flash, [
                'title'   => $title,
                'message' => $msg
            ]);
    }

    public function export(Request $req)
    {
        $search = trim($req->input('q', ''));
        $status = $req->input('status', '');
        $kategoriNasabah = $req->input('kategori_nasabah', '');

        $query = Rekening::with(['nasabah.siswa', 'user.pegawai']);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('no_rek', 'like', "%{$search}%")
                    ->orWhereHas('nasabah', function ($sq) use ($search) {
                        $sq->where('nama', 'like', "%{$search}%")
                            ->orWhere('nin', 'like', "%{$search}%");
                    });
            });
        }

        if ($status === 'aktif') {
            $query->where('status', true);
        } elseif ($status === 'nonaktif') {
            $query->where('status', false);
        }

        if (in_array($kategoriNasabah, ['siswa', 'umum'], true)) {
            $query->whereHas('nasabah', fn($sq) => $sq->where('kategori', $kategoriNasabah));
        }

        $data = $query->orderByDesc('created_at')->get();
        $ts = now()->format('Ymd_His');
        $filename = "rekening_{$ts}.csv";
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
            'No. Rekening',
            'NIN Nasabah',
            'Nama Nasabah',
            'Jenis Kelamin',
            'Kategori Nasabah',
            'NISN',
            'Tahun Masuk',
            'Status Rekening',
            'Dibuat Oleh',
            'Tanggal Dibuat',
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
            foreach ($data as $rek) {
                $nsb = $rek->nasabah;
                $writeRow([
                    $idx++,
                    $rek->no_rek,
                    $nsb?->nin ?? '',
                    $nsb?->nama ?? '',
                    $nsb && $nsb->jk === 'L' ? 'Laki-laki' : ($nsb && $nsb->jk === 'P' ? 'Perempuan' : ''),
                    $nsb && $nsb->kategori === 'siswa' ? 'Siswa' : ($nsb && $nsb->kategori === 'umum' ? 'Umum' : ($nsb->kategori ?? '')),
                    $nsb && $nsb->siswa ? $nsb->siswa->nisn : '',
                    $nsb && $nsb->siswa ? $nsb->siswa->tahun_masuk : '',
                    $rek->status ? 'Aktif' : 'Nonaktif',
                    $rek->user?->pegawai?->nama ?? ($rek->user?->username ?? 'sistem'),
                    $rek->created_at ? $rek->created_at->format('d-m-Y H:i:s') : '',
                ]);
            }
            fclose($fh);
        }, 200, $headers);
    }
}
