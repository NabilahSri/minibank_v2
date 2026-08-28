<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Nasabah;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (in_array($user->role, ['adm', 'opr'])) {
            // 1. Total Kas Tabungan
            $totalSetor = Transaksi::whereHas('sandi', function ($q) {
                $q->where('jenis_transaksi', 'setor');
            })->when($user->role === 'opr', function($q) use ($user) {
                $q->whereHas('user.pegawai', fn($q2) => $q2->where('lokasi_id', $user->pegawai->lokasi_id));
            })->sum('nominal');

            $totalTarik = Transaksi::whereHas('sandi', function ($q) {
                $q->where('jenis_transaksi', 'tarik');
            })->when($user->role === 'opr', function($q) use ($user) {
                $q->whereHas('user.pegawai', fn($q2) => $q2->where('lokasi_id', $user->pegawai->lokasi_id));
            })->sum('nominal');

            $totalKas = $totalSetor - $totalTarik;

            // 2. Total Nasabah Aktif
            $totalNasabah = Nasabah::count();

            // 3. Transaksi Hari Ini
            $transaksiHariIni = Transaksi::whereDate('waktu', today())
                ->when($user->role === 'opr', function($q) use ($user) {
                    $q->whereHas('user.pegawai', fn($q2) => $q2->where('lokasi_id', $user->pegawai->lokasi_id));
                })->count();

            // 4. Transaksi Terakhir
            $transaksiTerakhir = Transaksi::with(['rekeningAsal.nasabah.siswa', 'sandi'])
                ->when($user->role === 'opr', function($q) use ($user) {
                    $q->whereHas('user.pegawai', fn($q2) => $q2->where('lokasi_id', $user->pegawai->lokasi_id));
                })
                ->orderBy('waktu', 'desc')
                ->limit(10)
                ->get();

            // 5. Rasio Setoran vs Penarikan Bulan Ini
            $now = now();
            $setoranBulanIni = Transaksi::whereMonth('waktu', $now->month)
                ->whereYear('waktu', $now->year)
                ->whereHas('sandi', fn($q) => $q->where('jenis_transaksi', 'setor'))
                ->when($user->role === 'opr', function($q) use ($user) {
                    $q->whereHas('user.pegawai', fn($q2) => $q2->where('lokasi_id', $user->pegawai->lokasi_id));
                })
                ->sum('nominal');

            $penarikanBulanIni = Transaksi::whereMonth('waktu', $now->month)
                ->whereYear('waktu', $now->year)
                ->whereHas('sandi', fn($q) => $q->where('jenis_transaksi', 'tarik'))
                ->when($user->role === 'opr', function($q) use ($user) {
                    $q->whereHas('user.pegawai', fn($q2) => $q2->where('lokasi_id', $user->pegawai->lokasi_id));
                })
                ->sum('nominal');

            $totalMutasiBulanIni = $setoranBulanIni + $penarikanBulanIni;
            $persenSetoran = $totalMutasiBulanIni > 0 ? ($setoranBulanIni / $totalMutasiBulanIni) * 100 : 0;
            $persenPenarikan = $totalMutasiBulanIni > 0 ? ($penarikanBulanIni / $totalMutasiBulanIni) * 100 : 0;

            return view('admin.dashboard', compact(
                'totalKas',
                'totalNasabah',
                'transaksiHariIni',
                'transaksiTerakhir',
                'setoranBulanIni',
                'penarikanBulanIni',
                'persenSetoran',
                'persenPenarikan'
            ));
        }

        // Dashboard Nasabah
        $nasabah = $user->nasabah;
        $rekening = $nasabah ? $nasabah->rekening()->where('status', 1)->first() : null;
        $saldo = $rekening ? $rekening->saldo : 0;

        $setorBulanIni = 0;
        $tarikBulanIni = 0;
        $totalMutasi = 0;
        $mutasiTerakhir = collect();

        if ($rekening) {
            $now = now();
            $setorBulanIni = Transaksi::where('rekening_id', $rekening->id)
                ->whereMonth('waktu', $now->month)
                ->whereYear('waktu', $now->year)
                ->whereHas('sandi', fn($q) => $q->where('jenis_transaksi', 'setor'))
                ->sum('nominal');

            $tarikBulanIni = Transaksi::where('rekening_id', $rekening->id)
                ->whereMonth('waktu', $now->month)
                ->whereYear('waktu', $now->year)
                ->whereHas('sandi', fn($q) => $q->where('jenis_transaksi', 'tarik'))
                ->sum('nominal');

            $totalMutasi = Transaksi::where(function ($q) use ($rekening) {
                $q->where('rekening_id', $rekening->id)
                    ->orWhere('rekening_tujuan_id', $rekening->id);
            })->count();

            $mutasiTerakhir = Transaksi::where(function ($q) use ($rekening) {
                $q->where('rekening_id', $rekening->id)
                    ->orWhere('rekening_tujuan_id', $rekening->id);
            })
                ->with(['sandi'])
                ->orderBy('waktu', 'desc')
                ->limit(10)
                ->get();
        }

        return view('nasabah.dashboard', compact(
            'nasabah',
            'rekening',
            'saldo',
            'setorBulanIni',
            'tarikBulanIni',
            'totalMutasi',
            'mutasiTerakhir',
        ));
    }
}
