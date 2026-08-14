<?php

namespace App\Http\Controllers;

use App\Models\Autodebet;
use App\Models\AutodebetLog;
use App\Models\Rekening;
use App\Models\SandiTransaksi;
use App\Models\Subrekening;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AutodebetController extends Controller
{
    /**
     * Display list of Autodebet Schedules & Logs
     */
    public function index(Request $request)
    {
        $this->runAutodebetProcess();

        $search = $request->input('search');

        // 1. Query Master Jadwal Autodebet
        $queryJadwal = Autodebet::with([
            'rekeningAsal.nasabah',
            'rekeningTujuan.nasabah',
            'subrekening',
            'user'
        ])->orderBy('created_at', 'desc');

        if ($search) {
            $queryJadwal->whereHas('rekeningAsal.nasabah', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nin', 'like', "%{$search}%");
            })->orWhereHas('rekeningAsal', function ($q) use ($search) {
                $q->where('no_rek', 'like', "%{$search}%");
            })->orWhereHas('subrekening', function ($q) use ($search) {
                $q->where('subrekening', 'like', "%{$search}%");
            });
        }

        $jadwals = $queryJadwal->paginate(15, ['*'], 'jadwal_page')->withQueryString();

        // 2. Query Log Eksekusi Autodebet (Bulan Ini)
        $logs = AutodebetLog::with([
            'rekeningAsal.nasabah',
            'rekeningTujuan',
            'subrekening'
        ])->where('periode', date('Y-m'))
            ->orderBy('created_at', 'desc')
            ->paginate(15, ['*'], 'log_page')
            ->withQueryString();

        // 3. Dropdown Data untuk Modal Form Tambah Jadwal (Nasabah Siswa & Umum)
        $rekeningNasabah = Rekening::with('nasabah')
            ->where('status', 1)
            ->get();

        $rekeningSekolah = Rekening::with('nasabah')
            ->whereHas('subrekening')
            ->orWhere('status', 1)
            ->get();

        $subrekenings = Subrekening::orderBy('subrekening', 'asc')->get();

        // 4. Ringkasan Statistik Autodebet Bulan Ini
        $totalJadwalAktif = Autodebet::where('status', 1)->count();
        $totalBerhasilBulanIni = AutodebetLog::where('periode', date('Y-m'))->where('code', '00')->count();
        $totalNominalDitarikBulanIni = AutodebetLog::where('periode', date('Y-m'))->where('code', '00')->sum('nominal');
        $totalGagalSaldoBulanIni = AutodebetLog::where('periode', date('Y-m'))->where('code', '09')->count();

        return view('admin.autodebet.index', compact(
            'jadwals',
            'logs',
            'rekeningNasabah',
            'rekeningSekolah',
            'subrekenings',
            'search',
            'totalJadwalAktif',
            'totalBerhasilBulanIni',
            'totalNominalDitarikBulanIni',
            'totalGagalSaldoBulanIni'
        ));
    }

    /**
     * Store a new Autodebet schedule
     */
    public function store(Request $request)
    {
        $request->validate([
            'rekening_id'        => 'required|exists:rekenings,id',
            'rekening_tujuan_id' => 'required|exists:rekenings,id|different:rekening_id',
            'subrekening_id'     => 'required|exists:subrekenings,id',
            'tgl_penarikan'      => 'required|integer|min:1|max:31',
            'status'             => 'required|boolean',
        ], [
            'rekening_tujuan_id.different' => 'Rekening tujuan sekolah tidak boleh sama dengan rekening siswa.',
        ]);

        // Cek Duplikat Jadwal
        $exists = Autodebet::where('rekening_id', $request->rekening_id)
            ->where('rekening_tujuan_id', $request->rekening_tujuan_id)
            ->where('subrekening_id', $request->subrekening_id)
            ->exists();

        if ($exists) {
            return back()->withInput()->with('toast_error', [
                'title'   => 'Jadwal Duplikat',
                'message' => 'Jadwal autodebet untuk siswa dan jenis tagihan ini sudah ada!',
            ]);
        }

        Autodebet::create([
            'rekening_id'        => $request->rekening_id,
            'rekening_tujuan_id' => $request->rekening_tujuan_id,
            'subrekening_id'     => $request->subrekening_id,
            'user_id'            => Auth::id() ?? User::first()->id,
            'tgl_penarikan'      => $request->tgl_penarikan,
            'status'             => $request->status,
        ]);

        // Trigger otomatis penarikan jika jadwal baru memenuhi syarat penarikan hari ini
        $this->runAutodebetProcess();

        return redirect()->route('autodebet.index')->with('toast_success', [
            'title'   => 'Jadwal Disimpan',
            'message' => 'Jadwal autodebet baru berhasil didaftarkan dan langsung diproses.',
        ]);
    }

    /**
     * Toggle active/inactive status of schedule
     */
    public function toggleStatus(Autodebet $autodebet)
    {
        $autodebet->update(['status' => !$autodebet->status]);

        $statusText = $autodebet->status ? 'diaktifkan' : 'dinonaktifkan';

        if ($autodebet->status) {
            $this->runAutodebetProcess();
        }

        return back()->with('toast_success', [
            'title'   => 'Status Diperbarui',
            'message' => "Jadwal autodebet berhasil {$statusText}.",
        ]);
    }

    /**
     * Delete schedule
     */
    public function destroy(Autodebet $autodebet)
    {
        $autodebet->delete();

        return back()->with('toast_success', [
            'title'   => 'Jadwal Dihapus',
            'message' => 'Jadwal autodebet berhasil dihapus dari sistem.',
        ]);
    }

    /**
     * Manual Trigger Route (jika ingin dipicu ulang)
     */
    public function proses(Request $request)
    {
        $res = $this->runAutodebetProcess((int) ($request->input('tgl') ?? date('j')));

        $formattedTotal = number_format($res['nominal'], 0, ',', '.');

        return redirect()->route('autodebet.index')->with('toast_success', [
            'title'   => 'Proses Autodebet Selesai',
            'message' => "{$res['sukses']} Transaksi Sukses (Rp {$formattedTotal}), {$res['gagal_saldo']} Saldo Kurang, {$res['lunas']} Sudah Lunas.",
        ]);
    }

    /**
     * ⚡ MESIN EKSEKUSI PENARIKAN AUTODEBET OTOMATIS
     * Dipanggil secara otomatis setiap halaman dibuka, jadwal ditambah, maupun oleh Laravel Scheduler
     */
    public function runAutodebetProcess(?int $tgl = null): array
    {
        $tglToday = $tgl ?? (int) date('j');
        $currentMonth = date('Y-m');

        // Ambil semua jadwal aktif yang tanggal penarikannya <= hari ini
        $schedules = Autodebet::with(['rekeningAsal.nasabah', 'rekeningTujuan', 'subrekening'])
            ->where('status', 1)
            ->where('tgl_penarikan', '<=', $tglToday)
            ->get();

        if ($schedules->isEmpty()) {
            return ['sukses' => 0, 'gagal_saldo' => 0, 'lunas' => 0, 'nominal' => 0];
        }

        // Cari Sandi Autodebet (03)
        $sandiAutodebet = SandiTransaksi::where('kode', '03')
            ->orWhere('nama', 'like', '%autodebet%')
            ->first();

        if (!$sandiAutodebet) {
            return ['sukses' => 0, 'gagal_saldo' => 0, 'lunas' => 0, 'nominal' => 0];
        }

        $adminUserId = Auth::id() ?? User::where('role', 'adm')->first()?->id ?? User::first()?->id;

        $countSukses = 0;
        $countGagalSaldo = 0;
        $countLunas = 0;
        $totalNominalSukses = 0;

        foreach ($schedules as $ad) {
            $rekSiswa = $ad->rekeningAsal;
            $rekSekolah = $ad->rekeningTujuan;
            $subrek = $ad->subrekening;

            if (!$rekSiswa || !$subrek) {
                continue;
            }

            // 1. CEK ANTI-DOUBLE PER BULAN (Pemberhentian jika sudah bayar di bulan YYYY-MM ini)
            $alreadyPaidThisMonth = Transaksi::where('rekening_id', $rekSiswa->id)
                ->where('subrekening_id', $subrek->id)
                ->where('keterangan', 'autodebet')
                ->whereRaw("DATE_FORMAT(waktu, '%Y-%m') = ?", [$currentMonth])
                ->exists();

            if ($alreadyPaidThisMonth) {
                $countLunas++;
                continue;
            }



            $nominalTagihan = (float) $subrek->nominal;
            $saldoSiswa = (float) $rekSiswa->saldo;

            // 3. EKSEKUSI PEMOTONGAN OTOMATIS JIKA SALDO CUKUP
            if ($saldoSiswa >= $nominalTagihan) {
                try {
                    DB::transaction(function () use ($rekSiswa, $rekSekolah, $subrek, $sandiAutodebet, $adminUserId, $nominalTagihan, $ad, $currentMonth) {
                        $refCode = 'AD-' . date('YmdHis') . '-' . Str::random(5);

                        // Insert Transaksi Pemotongan Autodebet
                        Transaksi::create([
                            'rekening_id'        => $rekSiswa->id,
                            'rekening_tujuan_id' => $rekSekolah?->id,
                            'subrekening_id'     => $subrek->id,
                            'user_id'            => $adminUserId,
                            'sandi_id'           => $sandiAutodebet->id,
                            'via_id'             => null,
                            'nominal'            => $nominalTagihan,
                            'ref'                => $refCode,
                            'keterangan'         => 'autodebet',
                            'waktu'              => now(),
                        ]);

                        // Catat Audit Log Penarikan Berhasil
                        AutodebetLog::create([
                            'autodebet_id'       => $ad->id,
                            'rekening_id'        => $rekSiswa->id,
                            'rekening_tujuan_id' => $rekSekolah?->id,
                            'subrekening_id'     => $subrek->id,
                            'periode'            => $currentMonth,
                            'nominal'            => $nominalTagihan,
                            'code'               => '00',
                            'status_text'        => 'SUKSES',
                            'keterangan'         => "Autodebet {$subrek->subrekening} sebesar Rp " . number_format($nominalTagihan, 0, ',', '.') . " otomatis ditarik.",
                            'user_id'            => $adminUserId,
                        ]);
                    });

                    $countSukses++;
                    $totalNominalSukses += $nominalTagihan;
                } catch (\Throwable $e) {
                    Log::error('Autodebet Process Exception: ' . $e->getMessage());
                }
            } else {
                // Catat Log jika Saldo Siswa Belum Mencukupi
                $countGagalSaldo++;
                AutodebetLog::create([
                    'autodebet_id'       => $ad->id,
                    'rekening_id'        => $rekSiswa->id,
                    'rekening_tujuan_id' => $rekSekolah?->id,
                    'subrekening_id'     => $subrek->id,
                    'periode'            => $currentMonth,
                    'nominal'            => $nominalTagihan,
                    'code'               => '09',
                    'status_text'        => 'SALDO KURANG',
                    'keterangan'         => 'Saldo tabungan (Rp ' . number_format($saldoSiswa, 0, ',', '.') . ') tidak mencukupi tagihan (Rp ' . number_format($nominalTagihan, 0, ',', '.') . ')',
                    'user_id'            => $adminUserId,
                ]);
            }
        }

        return [
            'sukses'      => $countSukses,
            'gagal_saldo' => $countGagalSaldo,
            'lunas'       => $countLunas,
            'nominal'     => $totalNominalSukses,
        ];
    }
}
