@extends('layouts.app')

@section('title', 'Autodebet Pembayaran')
@section('page_title', 'Autodebet Pembayaran Bulanan')

@section('content')
    <div class="space-y-5 sm:space-y-6">

        <!-- Title Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight truncate">
                    Autodebet Pembayaran Bulanan
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Fitur penagihan otomatis SPP, DSP, dan iuran rutin langsung dari saldo tabungan siswa
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <!-- Open Modal Button -->
                <button type="button" id="btnOpenAddJadwal"
                    class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 focus:ring-4 focus:ring-emerald-100 transition active:scale-[0.98]">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="hidden xs:inline">Tambah Jadwal</span>
                    <span class="xs:hidden inline">Baru</span>
                </button>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <!-- Stat 1: Jadwal Aktif -->
            <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Jadwal Aktif
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        {{ number_format($totalJadwalAktif, 0, ',', '.') }}
                    </h3>
                    <span class="text-[10px] sm:text-[11px] font-medium text-emerald-600 mt-1 inline-flex items-center gap-1">
                        Jadwal siap ditarik
                    </span>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            <!-- Stat 2: Sukses Bulan Ini -->
            <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Sukses Bulan Ini
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        {{ number_format($totalBerhasilBulanIni, 0, ',', '.') }} <span class="text-xs font-normal text-slate-500">Siswa</span>
                    </h3>
                    <span class="text-[10px] sm:text-[11px] font-medium text-blue-600 mt-1 inline-flex items-center gap-1">
                        Transaksi terbayar
                    </span>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Stat 3: Nominal Ditarik -->
            <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Nominal Ditarik
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        Rp {{ number_format($totalNominalDitarikBulanIni, 0, ',', '.') }}
                    </h3>
                    <span class="text-[10px] sm:text-[11px] font-medium text-teal-600 mt-1 inline-flex items-center gap-1">
                        Total penerimaan bulanan
                    </span>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Stat 4: Saldo Kurang -->
            <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Saldo Kurang
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-rose-600 mt-1 truncate">
                        {{ number_format($totalGagalSaldoBulanIni, 0, ',', '.') }} <span class="text-xs font-normal text-slate-500">Siswa</span>
                    </h3>
                    <span class="text-[10px] sm:text-[11px] font-medium text-rose-600 mt-1 inline-flex items-center gap-1">
                        Perlu pengisian tabungan
                    </span>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Main Card with Tab Content -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            
            <!-- Tab Headers & Search Bar -->
            <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">
                <div class="flex items-center gap-1 border-b border-slate-200 xl:border-b-0 -mb-px xl:mb-0">
                    <button type="button" id="tabBtnJadwal"
                        class="px-4 py-2.5 text-xs sm:text-sm font-bold border-b-2 border-emerald-600 text-emerald-600 transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Master Jadwal Autodebet
                    </button>
                    <button type="button" id="tabBtnLogs"
                        class="px-4 py-2.5 text-xs sm:text-sm font-semibold border-b-2 border-transparent text-slate-500 hover:text-slate-700 transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Log Eksekusi ({{ date('F Y') }})
                    </button>
                </div>

                <form action="{{ route('autodebet.index') }}" method="GET"
                    class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 w-full xl:w-auto">

                    <div class="relative flex-1 sm:flex-none sm:w-72">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nasabah atau rekening..."
                            class="w-full pl-9 pr-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                    </div>

                    <div class="flex items-center gap-2 flex-wrap">
                        <button type="submit"
                            class="px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition active:scale-[0.98] whitespace-nowrap">
                            Cari
                        </button>
                        @if ($search)
                            <a href="{{ route('autodebet.index') }}"
                                class="px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 hover:bg-slate-100 transition whitespace-nowrap">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- TAB CONTENT 1: MASTER JADWAL AUTODEBET -->
            <div id="tabContentJadwal">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-[10px] sm:text-xs min-w-[750px]">
                        <thead class="bg-slate-50/80 text-slate-500 uppercase tracking-wide text-[10px] sm:text-[11px] font-bold border-b border-slate-100">
                            <tr>
                                <th class="py-3.5 px-4 sm:px-5 w-14">#</th>
                                <th class="py-3.5 px-4 sm:px-5">Rekening Siswa</th>
                                <th class="py-3.5 px-4 sm:px-5">Rekening Tujuan Sekolah</th>
                                <th class="py-3.5 px-4 sm:px-5">Jenis Tagihan</th>
                                <th class="py-3.5 px-4 sm:px-5 text-right">Biaya / Nominal</th>
                                <th class="py-3.5 px-4 sm:px-5 text-center">Tgl Penarikan</th>
                                <th class="py-3.5 px-4 sm:px-5 text-center">Status</th>
                                <th class="py-3.5 px-4 sm:px-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                            @forelse($jadwals as $index => $j)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 px-4 sm:px-5 text-slate-400 font-semibold whitespace-nowrap">
                                        {{ $jadwals->firstItem() + $index }}
                                    </td>
                                    <td class="py-3.5 px-4 sm:px-5">
                                        <p class="font-bold text-slate-800 text-xs sm:text-sm">{{ $j->rekeningAsal?->nasabah?->nama ?? '—' }}</p>
                                        <p class="text-[10px] text-slate-400 font-mono mt-0.5">Rek: {{ $j->rekeningAsal?->no_rek ?? '—' }} | NIN: {{ $j->rekeningAsal?->nasabah?->nin ?? '—' }}</p>
                                    </td>
                                    <td class="py-3.5 px-4 sm:px-5">
                                        <p class="font-bold text-slate-800 text-xs sm:text-sm">{{ $j->rekeningTujuan?->nasabah?->nama ?? 'Bendahara Sekolah' }}</p>
                                        <p class="text-[10px] text-slate-400 font-mono mt-0.5">Rek: {{ $j->rekeningTujuan?->no_rek ?? '—' }}</p>
                                    </td>
                                    <td class="py-3.5 px-4 sm:px-5">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] sm:text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                            {{ $j->subrekening?->subrekening ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 sm:px-5 text-right font-bold text-slate-900">
                                        Rp {{ number_format($j->subrekening?->nominal ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-4 sm:px-5 text-center font-semibold text-slate-800">
                                        Tgl {{ $j->tgl_penarikan }} / bulan
                                    </td>
                                    <td class="py-3.5 px-4 sm:px-5 text-center">
                                        <form action="{{ route('autodebet.toggle', $j->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold transition {{ $j->status ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $j->status ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                                {{ $j->status ? 'Aktif' : 'Nonaktif' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="py-3.5 px-4 sm:px-5 text-right">
                                        <form action="{{ route('autodebet.destroy', $j->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus jadwal autodebet ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus Jadwal"
                                                class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-rose-50 text-slate-400 hover:text-rose-600 border border-slate-200 hover:border-rose-200 flex items-center justify-center transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-10 text-center text-slate-400 font-medium">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>Belum ada jadwal autodebet yang didaftarkan.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($jadwals->hasPages())
                    <div class="px-4 py-3 sm:px-5 border-t border-slate-100 bg-slate-50/50">
                        {{ $jadwals->links() }}
                    </div>
                @endif
            </div>

            <!-- TAB CONTENT 2: LOG AUDIT EKSEKUSI -->
            <div id="tabContentLogs" class="hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-[10px] sm:text-xs min-w-[750px]">
                        <thead class="bg-slate-50/80 text-slate-500 uppercase tracking-wide text-[10px] sm:text-[11px] font-bold border-b border-slate-100">
                            <tr>
                                <th class="py-3.5 px-4 sm:px-5 w-14">#</th>
                                <th class="py-3.5 px-4 sm:px-5">Waktu Eksekusi</th>
                                <th class="py-3.5 px-4 sm:px-5">Nasabah Siswa</th>
                                <th class="py-3.5 px-4 sm:px-5">Jenis Tagihan</th>
                                <th class="py-3.5 px-4 sm:px-5 text-right">Nominal Tagihan</th>
                                <th class="py-3.5 px-4 sm:px-5 text-center">Hasil / Status</th>
                                <th class="py-3.5 px-4 sm:px-5">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                            @forelse($logs as $index => $l)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-3.5 px-4 sm:px-5 text-slate-400 font-semibold whitespace-nowrap">
                                        {{ $logs->firstItem() + $index }}
                                    </td>
                                    <td class="py-3.5 px-4 sm:px-5 text-slate-500 whitespace-nowrap">
                                        {{ $l->created_at->format('d M Y, H:i') }} WIB
                                    </td>
                                    <td class="py-3.5 px-4 sm:px-5">
                                        <p class="font-bold text-slate-800 text-xs sm:text-sm">{{ $l->rekeningAsal?->nasabah?->nama ?? '—' }}</p>
                                        <p class="text-[10px] text-slate-400 font-mono mt-0.5">Rek: {{ $l->rekeningAsal?->no_rek ?? '—' }}</p>
                                    </td>
                                    <td class="py-3.5 px-4 sm:px-5 font-bold text-slate-800">
                                        {{ $l->subrekening?->subrekening ?? '—' }}
                                    </td>
                                    <td class="py-3.5 px-4 sm:px-5 text-right font-bold text-slate-900">
                                        Rp {{ number_format($l->nominal, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 px-4 sm:px-5 text-center">
                                        @if($l->code === '00')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                SUKSES (00)
                                            </span>
                                        @elseif($l->code === '09')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                                SALDO KURANG (09)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                {{ $l->status_text }} ({{ $l->code }})
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 sm:px-5 text-xs text-slate-500 max-w-xs truncate" title="{{ $l->keterangan }}">
                                        {{ $l->keterangan ?? '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-10 text-center text-slate-400 font-medium">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                            <span>Belum ada log eksekusi autodebet untuk bulan {{ date('F Y') }}.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($logs->hasPages())
                    <div class="px-4 py-3 sm:px-5 border-t border-slate-100 bg-slate-50/50">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>

    <!-- Modal Form Tambah Jadwal Autodebet -->
    <div id="modalAutodebet"
        class="fixed inset-0 z-[80] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-2xl border border-slate-200/80 overflow-hidden transform transition-all">
            <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between gap-3 bg-gradient-to-r from-emerald-50 to-teal-50">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-sm font-bold text-slate-800 truncate">Tambah Jadwal Autodebet</h3>
                        <p class="text-[10px] sm:text-xs text-slate-500 mt-0.5">Atur penagihan bulanan otomatis dari tabungan siswa</p>
                    </div>
                </div>
                <button type="button" id="btnCloseModalAutodebet"
                    class="w-8 h-8 rounded-lg bg-white hover:bg-slate-100 text-slate-500 hover:text-slate-700 flex items-center justify-center transition border border-slate-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('autodebet.store') }}" method="POST">
                @csrf

                <div class="p-4 sm:p-5 space-y-4">
                    <!-- Pilih Rekening Nasabah -->
                    <div>
                        <label for="rekening_id" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                            Nasabah (Didebet) <span class="text-rose-500">*</span>
                        </label>
                        <select name="rekening_id" id="rekening_id" required
                            class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                            <option value="">Cari nasabah / nomor rekening...</option>
                            @foreach($rekeningNasabah as $rn)
                                <option value="{{ $rn->id }}" {{ old('rekening_id') == $rn->id ? 'selected' : '' }}>
                                    {{ $rn->nasabah?->nin ?? '—' }} | {{ $rn->nasabah?->nama ?? '—' }} ({{ ucfirst($rn->nasabah?->kategori ?? 'umum') }}) - Rek: {{ $rn->no_rek }}
                                </option>
                            @endforeach
                        </select>
                        @error('rekening_id')
                            <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pilih Rekening Tujuan Sekolah -->
                    <div>
                        <label for="rekening_tujuan_id" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                            Rekening Tujuan Sekolah (Bendahara) <span class="text-rose-500">*</span>
                        </label>
                        <select name="rekening_tujuan_id" id="rekening_tujuan_id" required
                            class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                            <option value="">Pilih rekening tujuan sekolah...</option>
                            @foreach($rekeningSekolah as $rk)
                                <option value="{{ $rk->id }}" {{ old('rekening_tujuan_id') == $rk->id ? 'selected' : '' }}>
                                    {{ $rk->nasabah?->nama ?? 'Bendahara Sekolah' }} (Rek: {{ $rk->no_rek }})
                                </option>
                            @endforeach
                        </select>
                        @error('rekening_tujuan_id')
                            <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pilih Jenis Tagihan / Subrekening -->
                    <div>
                        <label for="subrekening_id" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                            Jenis Tagihan (Subrekening) <span class="text-rose-500">*</span>
                        </label>
                        <select name="subrekening_id" id="subrekening_id" required
                            class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                            <option value="">Pilih jenis tagihan...</option>
                            @foreach($subrekenings as $sub)
                                <option value="{{ $sub->id }}" {{ old('subrekening_id') == $sub->id ? 'selected' : '' }}>
                                    {{ $sub->subrekening }} — Rp {{ number_format($sub->nominal, 0, ',', '.') }} (Thn {{ $sub->tahun_pembayaran }})
                                </option>
                            @endforeach
                        </select>
                        @error('subrekening_id')
                            <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Penarikan & Status -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="tgl_penarikan" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                Tgl Penarikan (1-31) <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" name="tgl_penarikan" id="tgl_penarikan" value="{{ old('tgl_penarikan', 10) }}" min="1" max="31" required
                                class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                        </div>
                        <div>
                            <label for="status" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                Status Jadwal <span class="text-rose-500">*</span>
                            </label>
                            <select name="status" id="status" required
                                class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                                <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('status', 1) == 0 ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="p-4 sm:p-5 border-t border-slate-100 bg-slate-50/60 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2">
                    <button type="button" id="btnBatalModalAutodebet"
                        class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-600 bg-white hover:bg-slate-100 border border-slate-200 transition active:scale-[0.98] w-full sm:w-auto">
                        Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 focus:ring-4 focus:ring-emerald-100 transition active:scale-[0.98] w-full sm:w-auto">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Simpan Jadwal</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tab & Modal Interactivity Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // TAB SWITCHING LOGIC
            const btnJadwal = document.getElementById('tabBtnJadwal');
            const btnLogs = document.getElementById('tabBtnLogs');
            const contentJadwal = document.getElementById('tabContentJadwal');
            const contentLogs = document.getElementById('tabContentLogs');

            function switchTab(tab) {
                if (tab === 'jadwal') {
                    contentJadwal.classList.remove('hidden');
                    contentLogs.classList.add('hidden');

                    btnJadwal.classList.add('border-emerald-600', 'text-emerald-600', 'font-bold');
                    btnJadwal.classList.remove('border-transparent', 'text-slate-500', 'font-semibold');

                    btnLogs.classList.remove('border-emerald-600', 'text-emerald-600', 'font-bold');
                    btnLogs.classList.add('border-transparent', 'text-slate-500', 'font-semibold');
                } else {
                    contentJadwal.classList.add('hidden');
                    contentLogs.classList.remove('hidden');

                    btnLogs.classList.add('border-emerald-600', 'text-emerald-600', 'font-bold');
                    btnLogs.classList.remove('border-transparent', 'text-slate-500', 'font-semibold');

                    btnJadwal.classList.remove('border-emerald-600', 'text-emerald-600', 'font-bold');
                    btnJadwal.classList.add('border-transparent', 'text-slate-500', 'font-semibold');
                }
            }

            if (btnJadwal) btnJadwal.addEventListener('click', function() { switchTab('jadwal'); });
            if (btnLogs) btnLogs.addEventListener('click', function() { switchTab('logs'); });

            // MODAL LOGIC
            const modal = document.getElementById('modalAutodebet');
            const btnOpen = document.getElementById('btnOpenAddJadwal');
            const btnClose = document.getElementById('btnCloseModalAutodebet');
            const btnBatal = document.getElementById('btnBatalModalAutodebet');

            function openModal() {
                if (!modal) return;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                if (!modal) return;
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }

            if (btnOpen) btnOpen.addEventListener('click', openModal);
            if (btnClose) btnClose.addEventListener('click', closeModal);
            if (btnBatal) btnBatal.addEventListener('click', closeModal);

            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) closeModal();
                });
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });

            @if($errors->any())
                openModal();
            @endif
        });
    </script>
@endsection
