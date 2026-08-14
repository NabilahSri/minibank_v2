@extends('layouts.app')

@section('title', 'Dashboard Utama')
@section('page_title', 'Ringkasan Sistem Mini Bank')

@section('content')
    <div class="space-y-5 sm:space-y-6">

        <!-- 1. STATS CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-5">

            <!-- Total Kas Tabungan -->
            <div
                class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Kas
                        Tabungan</p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">Rp
                        {{ number_format($totalKas, 0, ',', '.') }}</h3>
                    <span
                        class="text-[10px] sm:text-[11px] font-medium text-emerald-600 inline-flex items-center gap-1 mt-1">
                        Aktif di sistem
                    </span>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Total Nasabah Siswa -->
            <div
                class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Nasabah
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">{{ $totalNasabah }} Nasabah</h3>
                    <span class="text-[10px] sm:text-[11px] font-medium text-slate-500 inline-flex items-center gap-1 mt-1">
                        Terdaftar di sistem
                    </span>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>

            <!-- Transaksi Hari Ini -->
            <div
                class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3 sm:col-span-2 lg:col-span-1">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">Transaksi Hari
                        Ini</p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">{{ $transaksiHariIni }} Transaksi
                    </h3>
                    <span
                        class="text-[10px] sm:text-[11px] font-medium text-emerald-600 inline-flex items-center gap-1 mt-1">
                        Hari ini
                    </span>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>

        </div>

        <!-- 2. MAIN CONTENT GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 sm:gap-6">

            <!-- Tabel Transaksi Terakhir (2 Kolom) -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between gap-2">
                    <div class="min-w-0">
                        <h2 class="text-sm font-bold text-slate-800 truncate">Transaksi Terakhir</h2>
                        <p class="text-[10px] sm:text-xs text-slate-400 truncate">Mutasi masuk & keluar real-time</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-[10px] sm:text-xs min-w-[400px]">
                        <thead class="bg-slate-50 text-slate-500 uppercase font-semibold border-b border-slate-100">
                            <tr>
                                <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Nasabah</th>
                                <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Tipe</th>
                                <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Nominal</th>
                                <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($transaksiTerakhir as $transaksi)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3 px-4 sm:px-5 font-semibold text-slate-800 whitespace-nowrap">
                                        {{ $transaksi->rekeningAsal->nasabah->nama ?? '-' }}
                                        @if (
                                            ($transaksi->rekeningAsal->nasabah->kategori ?? '') == 'siswa' &&
                                                ($transaksi->rekeningAsal->nasabah->siswa ?? null))
                                            <span
                                                class="text-[9px] text-slate-400 font-normal">({{ $transaksi->rekeningAsal->nasabah->siswa->jurusan }})</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                        @if ($transaksi->sandi->jenis_transaksi == 'setor')
                                            <span
                                                class="px-2 py-0.5 rounded text-[9px] sm:text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Setor</span>
                                        @elseif($transaksi->sandi->jenis_transaksi == 'tarik')
                                            <span
                                                class="px-2 py-0.5 rounded text-[9px] sm:text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">Tarik</span>
                                        @else
                                            <span
                                                class="px-2 py-0.5 rounded text-[9px] sm:text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">Transfer</span>
                                        @endif
                                    </td>
                                    @if ($transaksi->sandi->jenis_transaksi == 'setor')
                                        <td class="py-3 px-4 sm:px-5 font-semibold text-emerald-600 whitespace-nowrap">+ Rp
                                            {{ number_format($transaksi->nominal, 0, ',', '.') }}</td>
                                    @elseif($transaksi->sandi->jenis_transaksi == 'tarik')
                                        <td class="py-3 px-4 sm:px-5 font-semibold text-amber-600 whitespace-nowrap">- Rp
                                            {{ number_format($transaksi->nominal, 0, ',', '.') }}</td>
                                    @else
                                        <td class="py-3 px-4 sm:px-5 font-semibold text-blue-600 whitespace-nowrap">Rp
                                            {{ number_format($transaksi->nominal, 0, ',', '.') }}</td>
                                    @endif
                                    <td class="py-3 px-4 sm:px-5 text-slate-400 whitespace-nowrap">
                                        {{ $transaksi->waktu->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-slate-400">Belum ada transaksi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Side: Widget Progress Bar + Panel Aksi Cepat (1 Kolom) -->
            <div class="space-y-5 sm:space-y-6">

                <!-- Widget Transaksi Bulan Ini -->
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4 sm:p-5">
                    <div class="pb-3 border-b border-slate-100 mb-4">
                        <h2 class="text-sm font-bold text-slate-800">Transaksi Bulan Ini</h2>
                        <p class="text-[10px] sm:text-xs text-slate-400">Rasio perbandingan setoran & penarikan</p>
                    </div>

                    <div class="space-y-4">
                        <!-- Progress Setoran -->
                        <div>
                            <div
                                class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 text-[10px] sm:text-xs font-semibold mb-1.5">
                                <span class="text-slate-600 flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                    Setoran
                                </span>
                                <span class="text-emerald-600 font-bold whitespace-nowrap">
                                    Rp {{ number_format($setoranBulanIni, 0, ',', '.') }} <span
                                        class="text-slate-400 font-normal">({{ number_format($persenSetoran, 2, ',', '.') }}%)</span>
                                </span>
                            </div>
                            <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-500"
                                    style="width: {{ $persenSetoran }}%"></div>
                            </div>
                        </div>

                        <!-- Progress Penarikan -->
                        <div>
                            <div
                                class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 text-[10px] sm:text-xs font-semibold mb-1.5">
                                <span class="text-slate-600 flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 shrink-0"></span>
                                    Penarikan
                                </span>
                                <span class="text-amber-600 font-bold whitespace-nowrap">
                                    Rp {{ number_format($penarikanBulanIni, 0, ',', '.') }} <span
                                        class="text-slate-400 font-normal">({{ number_format($persenPenarikan, 2, ',', '.') }}%)</span>
                                </span>
                            </div>
                            <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-amber-500 h-full rounded-full transition-all duration-500"
                                    style="width: {{ $persenPenarikan }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
