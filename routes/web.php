<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AutodebetController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\SandiTransaksiController;
use App\Http\Controllers\ViaTransaksiController;
use App\Http\Controllers\CetakBukuController;
use App\Http\Controllers\LaporanTransaksiController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Webhook Callback BSI / BPI MAKA (Publik, tanpa auth, CSRF dieksklusi)
Route::post('/payment/notif', [PaymentController::class, 'notif'])->name('payment.notif');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Profil & Pengaturan Akun
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profil/pengaturan', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::put('/profil', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Admin & Operator Access Only
    Route::middleware('role:adm,opr')->group(function () {
        // Tagihan Virtual Account BSI
        Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
        Route::get('/tagihan/create', [TagihanController::class, 'create'])->name('tagihan.create');
        Route::post('/tagihan', [TagihanController::class, 'store'])->name('tagihan.store');
        Route::post('/tagihan/{tagihan}/cancel', [TagihanController::class, 'cancel'])->name('tagihan.cancel');
        // Nasabah
        Route::get('/nasabah', [NasabahController::class, 'index'])->name('nasabah.index');
        Route::get('/nasabah/export', [NasabahController::class, 'export'])->name('nasabah.export');
        Route::get('/nasabah/create', [NasabahController::class, 'create'])->name('nasabah.create');
        Route::post('/nasabah', [NasabahController::class, 'store'])->name('nasabah.store');
        Route::get('/nasabah/{nasabah}/edit', [NasabahController::class, 'edit'])->name('nasabah.edit');
        Route::post('/nasabah/{nasabah}', [NasabahController::class, 'update'])->name('nasabah.update');
        Route::post('/nasabah/{nasabah}/destroy', [NasabahController::class, 'destroy'])->name('nasabah.destroy');
        Route::post('/nasabah/{nasabah}/reset-password', [NasabahController::class, 'resetPassword'])->name('nasabah.reset-password');

        // Rekening
        Route::get('/rekening', [RekeningController::class, 'index'])->name('rekening.index');
        Route::get('/rekening/export', [RekeningController::class, 'export'])->name('rekening.export');
        Route::get('/rekening/create', [RekeningController::class, 'create'])->name('rekening.create');
        Route::post('/rekening', [RekeningController::class, 'store'])->name('rekening.store');
        Route::get('/rekening/{rekening}/subrekening', [RekeningController::class, 'subrekening'])->name('rekening.subrekening');
        Route::post('/rekening/{rekening}/subrekening', [RekeningController::class, 'storeSubrekening'])->name('rekening.subrekening.store');
        Route::get('/rekening/{rekening}/subrekening/{subrekening}/edit', [RekeningController::class, 'editSubrekening'])->name('rekening.subrekening.edit');
        Route::post('/rekening/{rekening}/subrekening/{subrekening}', [RekeningController::class, 'updateSubrekening'])->name('rekening.subrekening.update');
        Route::delete('/rekening/{rekening}/subrekening/{subrekening}', [RekeningController::class, 'destroySubrekening'])->name('rekening.subrekening.destroy');
        Route::get('/rekening/{rekening}/subrekening/{subrekening}/member', [RekeningController::class, 'memberSubrekening'])->name('rekening.subrekening.member');
        Route::post('/rekening/{rekening}/subrekening/{subrekening}/member', [RekeningController::class, 'storeMemberSubrekening'])->name('rekening.subrekening.member.store');
        Route::delete('/rekening/{rekening}/subrekening/{subrekening}/member/{memberRekening}', [RekeningController::class, 'destroyMemberSubrekening'])->name('rekening.subrekening.member.destroy');
        Route::get('/rekening/{rekening}/edit', [RekeningController::class, 'edit'])->name('rekening.edit');
        Route::post('/rekening/{rekening}', [RekeningController::class, 'update'])->name('rekening.update');
        Route::post('/rekening/{rekening}/destroy', [RekeningController::class, 'destroy'])->name('rekening.destroy');

        // Transaksi
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');

        // Autodebet
        Route::get('/autodebet', [AutodebetController::class, 'index'])->name('autodebet.index');
        Route::post('/autodebet', [AutodebetController::class, 'store'])->name('autodebet.store');
        Route::post('/autodebet/{autodebet}/toggle', [AutodebetController::class, 'toggleStatus'])->name('autodebet.toggle');
        Route::post('/autodebet/proses', [AutodebetController::class, 'proses'])->name('autodebet.proses');
        Route::delete('/autodebet/{autodebet}', [AutodebetController::class, 'destroy'])->name('autodebet.destroy');

        // Transfer
        Route::get('/transfer', [TransferController::class, 'index'])->name('transfer.index');
        Route::post('/transfer', [TransferController::class, 'store'])->name('transfer.store');
        Route::delete('/transfer/{transaksi}', [TransferController::class, 'destroy'])->name('transfer.destroy');

        // Cetak Buku Tabungan & Laporan Transaksi
        Route::get('/cetak-buku', [CetakBukuController::class, 'index'])->name('cetakbuku.index');
        Route::get('/laporan-transaksi', [LaporanTransaksiController::class, 'index'])->name('laporan.index');
        Route::get('/laporan-transaksi/print', [LaporanTransaksiController::class, 'print'])->name('laporan.print');
        Route::get('/laporan-transaksi/export', [LaporanTransaksiController::class, 'export'])->name('laporan.export');
    });

    // Admin Access Only
    Route::middleware('role:adm')->group(function () {
        // Pegawai
        Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
        Route::get('/pegawai/export', [PegawaiController::class, 'export'])->name('pegawai.export');
        Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
        Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
        Route::get('/pegawai/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::post('/pegawai/{pegawai}', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::post('/pegawai/{pegawai}/destroy', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');

        // Lokasi
        Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi.index');
        Route::post('/lokasi', [LokasiController::class, 'store'])->name('lokasi.store');
        Route::post('/lokasi/{lokasi}', [LokasiController::class, 'update'])->name('lokasi.update');
        Route::post('/lokasi/{lokasi}/destroy', [LokasiController::class, 'destroy'])->name('lokasi.destroy');

        // Sandi Transaksi
        Route::get('/sandi-transaksi', [SandiTransaksiController::class, 'index'])->name('sandi.index');
        Route::post('/sandi-transaksi', [SandiTransaksiController::class, 'store'])->name('sandi.store');
        Route::post('/sandi-transaksi/{sandi}', [SandiTransaksiController::class, 'update'])->name('sandi.update');
        Route::post('/sandi-transaksi/{sandi}/destroy', [SandiTransaksiController::class, 'destroy'])->name('sandi.destroy');

        // Via Transaksi
        Route::get('/via-transaksi', [ViaTransaksiController::class, 'index'])->name('via.index');
        Route::post('/via-transaksi', [ViaTransaksiController::class, 'store'])->name('via.store');
        Route::post('/via-transaksi/{via}', [ViaTransaksiController::class, 'update'])->name('via.update');
        Route::post('/via-transaksi/{via}/destroy', [ViaTransaksiController::class, 'destroy'])->name('via.destroy');

        // Log Aktivitas
        Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');
    });
});
