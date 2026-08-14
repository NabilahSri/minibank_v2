@extends('layouts.app')

@section('title', 'Laporan Transaksi')
@section('page_title', 'Laporan Transaksi')

@section('content')
    <div class="space-y-5 sm:space-y-6">

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="min-w-0">
                <div class="flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100/80 shadow-xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                            Laporan Transaksi
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                            Menampilkan riwayat mutasi transaksi hari ini secara otomatis
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons: Cetak & Export -->
            <div class="flex items-center flex-wrap gap-2.5">
                <!-- Cetak Laporan Button -->
                <button type="button" id="btnOpenCetakModal"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-600/20 focus:ring-4 focus:ring-blue-100 transition active:scale-[0.98]">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <span>Cetak Laporan</span>
                </button>

                <!-- Ekspor CSV Button -->
                <button type="button" id="btnOpenExportModal"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 focus:ring-4 focus:ring-emerald-100 transition active:scale-[0.98]">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Ekspor CSV</span>
                </button>
            </div>
        </div>

        <!-- Summary Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
            <!-- Total Setoran -->
            <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Setoran</span>
                    <h3 class="text-lg sm:text-xl font-extrabold text-emerald-600 mt-1">
                        Rp {{ number_format($totalSetor, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                    </svg>
                </div>
            </div>

            <!-- Total Tarikan -->
            <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Tarikan</span>
                    <h3 class="text-lg sm:text-xl font-extrabold text-rose-600 mt-1">
                        Rp {{ number_format($totalTarik, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 border border-rose-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                </div>
            </div>

            <!-- Total Transfer -->
            <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Total Transfer</span>
                    <h3 class="text-lg sm:text-xl font-extrabold text-blue-600 mt-1">
                        Rp {{ number_format($totalTransfer, 0, ',', '.') }}
                    </h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
            </div>

            <!-- Total Transaksi -->
            <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Jumlah Transaksi</span>
                    <h3 class="text-lg sm:text-xl font-extrabold text-slate-800 mt-1">
                        {{ count($transactions) }} <span class="text-xs font-semibold text-slate-400">Data</span>
                    </h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 border border-slate-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-4 sm:p-5">
            <form action="{{ route('laporan.index') }}" method="GET" class="space-y-3.5">
                <div class="flex flex-col lg:flex-row items-stretch lg:items-end gap-3">
                    
                    <!-- Search Input -->
                    <div class="flex-1">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">
                            Pencarian
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari nama nasabah, no rek, atau keterangan..."
                                class="w-full pl-9 pr-3.5 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                        </div>
                    </div>

                    <!-- Filter Nasabah -->
                    <div class="w-full lg:w-64">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">
                            Nasabah
                        </label>
                        <select name="rekening_id"
                            class="w-full py-2 px-3 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                            <option value="">Semua Nasabah</option>
                            @foreach ($rekenings as $rek)
                                <option value="{{ $rek->id }}" {{ request('rekening_id') == $rek->id ? 'selected' : '' }}>
                                    {{ $rek->nasabah?->nama ?? '—' }} ({{ $rek->no_rek }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="w-full lg:w-40">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">
                            Tanggal Mulai
                        </label>
                        <input type="date" name="start_date" id="filter_start_date" value="{{ $startDate }}"
                            class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="w-full lg:w-40">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">
                            Tanggal Selesai
                        </label>
                        <input type="date" name="end_date" id="filter_end_date" value="{{ $endDate }}"
                            class="w-full px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                    </div>

                    <!-- Submit & Reset Buttons -->
                    <div class="flex items-center gap-2 shrink-0">
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white bg-slate-800 hover:bg-slate-900 transition shadow-xs active:scale-[0.98]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            <span>Filter</span>
                        </button>
                        <a href="{{ route('laporan.index') }}"
                            class="inline-flex items-center justify-center px-3 py-2 rounded-xl text-xs sm:text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 transition active:scale-[0.98]"
                            title="Reset ke Hari Ini">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Date Range Badges -->
                <div class="flex flex-wrap items-center gap-1.5 pt-1 border-t border-slate-100">
                    <span class="text-[11px] font-semibold text-slate-400 mr-1">Rentang Cepat:</span>
                    <button type="button" onclick="setDateRange('today')"
                        class="px-2.5 py-1 rounded-lg text-[11px] font-semibold transition {{ $startDate === now()->format('Y-m-d') && $endDate === now()->format('Y-m-d') ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        Hari Ini
                    </button>
                    <button type="button" onclick="setDateRange('yesterday')"
                        class="px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition">
                        Kemarin
                    </button>
                    <button type="button" onclick="setDateRange('week')"
                        class="px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition">
                        7 Hari Terakhir
                    </button>
                    <button type="button" onclick="setDateRange('month')"
                        class="px-2.5 py-1 rounded-lg text-[11px] font-semibold bg-slate-100 text-slate-600 hover:bg-slate-200 transition">
                        Bulan Ini
                    </button>
                </div>
            </form>
        </div>

        <!-- Main Report Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <span class="text-xs sm:text-sm font-bold text-slate-800">
                        Daftar Mutasi Transaksi
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                        {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} @if($startDate !== $endDate) s.d {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }} @endif
                    </span>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm min-w-[850px]">
                    <thead class="bg-slate-50/80 text-slate-500 uppercase tracking-wider text-[10px] sm:text-[11px] font-bold border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-4 sm:px-5 w-12 text-center">No</th>
                            <th class="py-3 px-4 sm:px-5">Nama Nasabah</th>
                            <th class="py-3 px-4 sm:px-5">Nomor Rekening</th>
                            <th class="py-3 px-4 sm:px-5">Jenis Transaksi</th>
                            <th class="py-3 px-4 sm:px-5 text-right">Nominal</th>
                            <th class="py-3 px-4 sm:px-5">Keterangan</th>
                            <th class="py-3 px-4 sm:px-5">Waktu</th>
                            <th class="py-3 px-4 sm:px-5 text-center">Paraf</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse ($transactions as $tx)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3 px-4 sm:px-5 text-slate-400 font-semibold text-center whitespace-nowrap">
                                    {{ $tx['index'] }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap font-bold text-slate-800">
                                    {{ $tx['nama_nasabah'] }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap font-mono text-xs text-slate-600">
                                    {{ $tx['no_rek'] }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap font-semibold">
                                    @if ($tx['jenis_transaksi'] === 'Setoran')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            {{ $tx['jenis_transaksi'] }}
                                        </span>
                                    @elseif ($tx['jenis_transaksi'] === 'Tarikan')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            {{ $tx['jenis_transaksi'] }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            {{ $tx['jenis_transaksi'] }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap text-right font-extrabold text-slate-900 font-mono">
                                    Rp {{ number_format($tx['nominal'], 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 text-slate-600 max-w-xs truncate" title="{{ $tx['keterangan'] }}">
                                    {{ $tx['keterangan'] }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap text-slate-500 text-xs">
                                    {{ $tx['waktu'] ? $tx['waktu']->format('d/m/Y H:i:s') : '—' }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap text-center font-mono text-xs text-slate-500">
                                    {{ $tx['paraf'] }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-14 text-center">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center border border-slate-200">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-slate-800">Tidak Ada Transaksi</h3>
                                            <p class="text-xs text-slate-500 mt-0.5">
                                                Belum ada transaksi tercatat pada rentang tanggal {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}.
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- ==================== MODAL CETAK LAPORAN ==================== -->
    <div id="modalCetakLaporan" class="fixed inset-0 z-[80] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-slate-200/80 overflow-visible transform transition-all">
            <!-- Header Modal -->
            <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between gap-3 bg-gradient-to-r from-blue-50 via-indigo-50 to-blue-50 rounded-t-2xl">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-blue-600/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Cetak Laporan Transaksi</h3>
                        <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5">Pilih cakupan nasabah dan rentang tanggal untuk dicetak</p>
                    </div>
                </div>
                <button type="button" id="btnCloseCetakModal"
                    class="w-8 h-8 rounded-lg bg-white hover:bg-slate-100 text-slate-500 hover:text-slate-700 flex items-center justify-center transition border border-slate-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Form Cetak -->
            <form action="{{ route('laporan.print') }}" method="GET" target="_blank">
                <div class="p-4 sm:p-5 space-y-4">
                    <!-- Opsi Cakupan Nasabah -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Pilih Cakupan Nasabah <span class="text-rose-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 has-checked:border-blue-600 has-checked:bg-blue-50/50 has-checked:ring-1 has-checked:ring-blue-600 transition">
                                <input type="radio" name="scope_cetak" value="all" checked onchange="toggleScopeCetak(this.value)"
                                    class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-slate-300">
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-800">Semua Nasabah</p>
                                    <p class="text-[10px] text-slate-500">Cetak seluruh transaksi</p>
                                </div>
                            </label>
                            <label class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 has-checked:border-blue-600 has-checked:bg-blue-50/50 has-checked:ring-1 has-checked:ring-blue-600 transition">
                                <input type="radio" name="scope_cetak" value="specific" onchange="toggleScopeCetak(this.value)"
                                    class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-slate-300">
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-800">Nasabah Tertentu</p>
                                    <p class="text-[10px] text-slate-500">Pilih 1 nasabah spesifik</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Dropdown Pilih Nasabah (Dynamic) -->
                    <div id="containerSelectNasabahCetak" class="hidden">
                        <label for="select_rekening_cetak" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Pilih Nasabah / Rekening <span class="text-rose-500">*</span>
                        </label>
                        <select name="rekening_id" id="select_rekening_cetak" data-searchable="true"
                            data-placeholder="Ketik nama atau nomor rekening..."
                            class="w-full text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                            <option value="">Pilih Nasabah...</option>
                            @foreach ($rekenings as $rek)
                                <option value="{{ $rek->id }}">
                                    {{ $rek->nasabah?->nama ?? '—' }} | {{ $rek->nasabah?->nin ?? '—' }} (Rek: {{ $rek->no_rek }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Rentang Tanggal -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="start_date_cetak" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Tanggal Mulai <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" name="start_date" id="start_date_cetak" required value="{{ $startDate }}"
                                class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                        </div>
                        <div>
                            <label for="end_date_cetak" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Tanggal Selesai <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" name="end_date" id="end_date_cetak" required value="{{ $endDate }}"
                                class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                        </div>
                    </div>
                </div>

                <!-- Footer Modal -->
                <div class="p-4 sm:p-5 border-t border-slate-100 bg-slate-50/70 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2.5 rounded-b-2xl">
                    <button type="button" id="btnBatalCetakModal"
                        class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 bg-white hover:bg-slate-100 border border-slate-200 transition active:scale-[0.98] w-full sm:w-auto">
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-600/20 focus:ring-4 focus:ring-blue-100 transition active:scale-[0.98] w-full sm:w-auto">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        <span>Cetak Sekarang</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== MODAL EKSPOR EXCEL ==================== -->
    <div id="modalExportExcel" class="fixed inset-0 z-[80] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-slate-200/80 overflow-visible transform transition-all">
            <!-- Header Modal -->
            <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between gap-3 bg-gradient-to-r from-emerald-50 via-teal-50 to-emerald-50 rounded-t-2xl">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-emerald-600/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Ekspor Laporan Transaksi</h3>
                        <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5">Download data mutasi transaksi format CSV (.csv)</p>
                    </div>
                </div>
                <button type="button" id="btnCloseExportModal"
                    class="w-8 h-8 rounded-lg bg-white hover:bg-slate-100 text-slate-500 hover:text-slate-700 flex items-center justify-center transition border border-slate-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Form Export -->
            <form action="{{ route('laporan.export') }}" method="GET">
                <div class="p-4 sm:p-5 space-y-4">
                    <!-- Opsi Cakupan Nasabah -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Pilih Cakupan Nasabah <span class="text-rose-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 has-checked:border-emerald-600 has-checked:bg-emerald-50/50 has-checked:ring-1 has-checked:ring-emerald-600 transition">
                                <input type="radio" name="scope_export" value="all" checked onchange="toggleScopeExport(this.value)"
                                    class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-slate-300">
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-800">Semua Nasabah</p>
                                    <p class="text-[10px] text-slate-500">Ekspor seluruh transaksi</p>
                                </div>
                            </label>
                            <label class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 has-checked:border-emerald-600 has-checked:bg-emerald-50/50 has-checked:ring-1 has-checked:ring-emerald-600 transition">
                                <input type="radio" name="scope_export" value="specific" onchange="toggleScopeExport(this.value)"
                                    class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-slate-300">
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-800">Nasabah Tertentu</p>
                                    <p class="text-[10px] text-slate-500">Pilih 1 nasabah spesifik</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Dropdown Pilih Nasabah (Dynamic) -->
                    <div id="containerSelectNasabahExport" class="hidden">
                        <label for="select_rekening_export" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Pilih Nasabah / Rekening <span class="text-rose-500">*</span>
                        </label>
                        <select name="rekening_id" id="select_rekening_export" data-searchable="true"
                            data-placeholder="Ketik nama atau nomor rekening..."
                            class="w-full text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                            <option value="">Pilih Nasabah...</option>
                            @foreach ($rekenings as $rek)
                                <option value="{{ $rek->id }}">
                                    {{ $rek->nasabah?->nama ?? '—' }} | {{ $rek->nasabah?->nin ?? '—' }} (Rek: {{ $rek->no_rek }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Rentang Tanggal -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label for="start_date_export" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Tanggal Mulai <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" name="start_date" id="start_date_export" required value="{{ $startDate }}"
                                class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                        </div>
                        <div>
                            <label for="end_date_export" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                Tanggal Selesai <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" name="end_date" id="end_date_export" required value="{{ $endDate }}"
                                class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                        </div>
                    </div>
                </div>

                <!-- Footer Modal -->
                <div class="p-4 sm:p-5 border-t border-slate-100 bg-slate-50/70 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2.5 rounded-b-2xl">
                    <button type="button" id="btnBatalExportModal"
                        class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 bg-white hover:bg-slate-100 border border-slate-200 transition active:scale-[0.98] w-full sm:w-auto">
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 focus:ring-4 focus:ring-emerald-100 transition active:scale-[0.98] w-full sm:w-auto">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Unduh CSV (.csv)</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Modal Cetak Laporan
        const modalCetak = document.getElementById('modalCetakLaporan');
        const btnOpenCetak = document.getElementById('btnOpenCetakModal');
        const btnCloseCetak = document.getElementById('btnCloseCetakModal');
        const btnBatalCetak = document.getElementById('btnBatalCetakModal');
        const containerNasabahCetak = document.getElementById('containerSelectNasabahCetak');
        const selectRekeningCetak = document.getElementById('select_rekening_cetak');

        function openModalCetak() {
            if (modalCetak) {
                modalCetak.classList.remove('hidden');
                modalCetak.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModalCetak() {
            if (modalCetak) {
                modalCetak.classList.remove('flex');
                modalCetak.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        function toggleScopeCetak(value) {
            if (value === 'specific') {
                containerNasabahCetak.classList.remove('hidden');
                selectRekeningCetak.setAttribute('required', 'required');
            } else {
                containerNasabahCetak.classList.add('hidden');
                selectRekeningCetak.removeAttribute('required');
                selectRekeningCetak.value = '';
            }
        }

        if (btnOpenCetak) btnOpenCetak.addEventListener('click', openModalCetak);
        if (btnCloseCetak) btnCloseCetak.addEventListener('click', closeModalCetak);
        if (btnBatalCetak) btnBatalCetak.addEventListener('click', closeModalCetak);
        if (modalCetak) {
            modalCetak.addEventListener('click', function(e) {
                if (e.target === modalCetak) closeModalCetak();
            });
        }

        // Modal Ekspor Excel
        const modalExport = document.getElementById('modalExportExcel');
        const btnOpenExport = document.getElementById('btnOpenExportModal');
        const btnCloseExport = document.getElementById('btnCloseExportModal');
        const btnBatalExport = document.getElementById('btnBatalExportModal');
        const containerNasabahExport = document.getElementById('containerSelectNasabahExport');
        const selectRekeningExport = document.getElementById('select_rekening_export');

        function openModalExport() {
            if (modalExport) {
                modalExport.classList.remove('hidden');
                modalExport.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModalExport() {
            if (modalExport) {
                modalExport.classList.remove('flex');
                modalExport.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        function toggleScopeExport(value) {
            if (value === 'specific') {
                containerNasabahExport.classList.remove('hidden');
                selectRekeningExport.setAttribute('required', 'required');
            } else {
                containerNasabahExport.classList.add('hidden');
                selectRekeningExport.removeAttribute('required');
                selectRekeningExport.value = '';
            }
        }

        if (btnOpenExport) btnOpenExport.addEventListener('click', openModalExport);
        if (btnCloseExport) btnCloseExport.addEventListener('click', closeModalExport);
        if (btnBatalExport) btnBatalExport.addEventListener('click', closeModalExport);
        if (modalExport) {
            modalExport.addEventListener('click', function(e) {
                if (e.target === modalExport) closeModalExport();
            });
        }

        // Global Escape Key to close open modals
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModalCetak();
                closeModalExport();
            }
        });

        // Quick Date Range setter for the on-page filter bar
        function setDateRange(range) {
            const startInput = document.getElementById('filter_start_date');
            const endInput = document.getElementById('filter_end_date');
            const today = new Date();

            const formatDate = (d) => {
                const year = d.getFullYear();
                const month = String(d.getMonth() + 1).padStart(2, '0');
                const day = String(d.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            };

            if (range === 'today') {
                const todayStr = formatDate(today);
                startInput.value = todayStr;
                endInput.value = todayStr;
            } else if (range === 'yesterday') {
                const yest = new Date(today);
                yest.setDate(yest.getDate() - 1);
                const yestStr = formatDate(yest);
                startInput.value = yestStr;
                endInput.value = yestStr;
            } else if (range === 'week') {
                const weekAgo = new Date(today);
                weekAgo.setDate(weekAgo.getDate() - 6);
                startInput.value = formatDate(weekAgo);
                endInput.value = formatDate(today);
            } else if (range === 'month') {
                const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
                startInput.value = formatDate(firstDay);
                endInput.value = formatDate(today);
            }

            // Automatically submit form when quick range is clicked
            startInput.form.submit();
        }
    </script>
@endsection
