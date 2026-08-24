@extends('layouts.app')

@section('title', 'Data Rekening')
@section('page_title', 'Kelola Data Rekening')

@section('content')
    <div class="space-y-5 sm:space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight truncate">
                    Data Rekening
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Kelola seluruh data rekening nasabah yang terdaftar di sistem
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('rekening.create') }}"
                    class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 focus:ring-4 focus:ring-emerald-100 transition active:scale-[0.98]">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="hidden xs:inline">Tambah Rekening</span>
                    <span class="xs:hidden sm:hidden inline">Baru</span>
                </a>
                <form action="{{ route('rekening.export') }}" method="GET" class="inline-block">
                    @if ($search)
                        <input type="hidden" name="q" value="{{ $search }}">
                    @endif
                    @if ($status)
                        <input type="hidden" name="status" value="{{ $status }}">
                    @endif
                    @if ($kategoriNasabah)
                        <input type="hidden" name="kategori_nasabah" value="{{ $kategoriNasabah }}">
                    @endif
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 shadow-sm transition active:scale-[0.98]">
                        <svg class="w-4 h-4 shrink-0 text-emerald-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="hidden sm:inline">Export Excel</span>
                        <span class="sm:hidden">Export</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <div
                class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Total Rekening
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        {{ number_format($totalRekening, 0, ',', '.') }}
                    </h3>
                    <span class="text-[10px] sm:text-[11px] font-medium text-slate-500 mt-1 inline-flex items-center gap-1">
                        Siswa + Umum
                    </span>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
            </div>

            <div
                class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Rekening Aktif
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        {{ number_format($totalAktif, 0, ',', '.') }}
                    </h3>
                    <span
                        class="text-[10px] sm:text-[11px] font-medium text-emerald-600 mt-1 inline-flex items-center gap-1">
                        {{ $totalRekening > 0 ? number_format(($totalAktif / $totalRekening) * 100, 1) : 0 }}% dari total
                    </span>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
            </div>

            <div
                class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Rekening Nonaktif
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        {{ number_format($totalNonaktif, 0, ',', '.') }}
                    </h3>
                    <span class="text-[10px] sm:text-[11px] font-medium text-rose-600 mt-1 inline-flex items-center gap-1">
                        {{ $totalRekening > 0 ? number_format(($totalNonaktif / $totalRekening) * 100, 1) : 0 }}% dari total
                    </span>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
            </div>

            <div
                class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Rek. Siswa
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        {{ number_format($totalRekSiswa, 0, ',', '.') }}
                    </h3>
                    <span class="text-[10px] sm:text-[11px] font-medium text-blue-600 mt-1 inline-flex items-center gap-1">
                        {{ $totalRekening > 0 ? number_format(($totalRekSiswa / $totalRekening) * 100, 1) : 0 }}% dari
                        total
                    </span>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div
                class="p-4 sm:p-5 border-b border-slate-100 flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">
                <div class="min-w-0 w-full xl:max-w-md flex-1">
                    <h2 class="text-sm font-bold text-slate-800">Daftar Rekening</h2>
                    <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5">
                        Total {{ $rekenings->total() }} data
                        @if ($search || $status || $kategoriNasabah)
                            <span class="text-emerald-600 font-semibold">(terfilter)</span>
                        @endif
                    </p>
                </div>

                <form action="{{ route('rekening.index') }}" method="GET"
                    class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 w-full xl:w-auto">

                    <div class="relative flex-1 sm:flex-none sm:w-64">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="q" value="{{ $search }}"
                            placeholder="Cari No. Rek / Nama / NIN..."
                            class="w-full pl-9 pr-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                    </div>

                    <div class="flex items-center gap-2">
                        <select name="status" data-searchable="true" data-placeholder="Semua status"
                            class="px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ $status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ $status === 'nonaktif' ? 'selected' : '' }}>Nonaktif
                            </option>
                        </select>
                        <select name="kategori_nasabah" data-searchable="true" data-placeholder="Semua kategori"
                            class="px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                            <option value="">Semua Kategori</option>
                            <option value="siswa" {{ $kategoriNasabah === 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="umum" {{ $kategoriNasabah === 'umum' ? 'selected' : '' }}>Umum</option>
                        </select>
                        <button type="submit"
                            class="px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition active:scale-[0.98] whitespace-nowrap">
                            Filter
                        </button>
                        @if ($search || $status || $kategoriNasabah)
                            <a href="{{ route('rekening.index') }}"
                                class="px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 hover:bg-slate-100 transition whitespace-nowrap">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-[10px] sm:text-xs" style="min-width: 900px;">
                    <thead
                        class="bg-slate-50/80 text-slate-500 uppercase tracking-wide text-[10px] sm:text-[11px] font-bold border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap w-14">#</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Nasabah</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">No. Rekening</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Kategori</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Dibuat</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Status</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse ($rekenings as $i => $rek)
                            <tr class="hover:bg-slate-50/80 transition group">
                                <td class="py-3 px-4 sm:px-5 text-slate-400 font-semibold whitespace-nowrap">
                                    {{ $rekenings->firstItem() + $i }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        @php
                                            $jk = $rek->nasabah?->jk ?? null;
                                            $initials = strtoupper(substr($rek->nasabah?->nama ?? '?', 0, 1));
                                        @endphp
                                        <div
                                            class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl {{ $jk === 'P' ? 'bg-pink-50 text-pink-600 border border-pink-200/60' : ($jk === 'L' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-slate-50 text-slate-500 border border-slate-200/60') }} flex items-center justify-center font-bold text-xs sm:text-sm shrink-0">
                                            {{ $initials }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-slate-800 text-xs sm:text-sm truncate max-w-50">
                                                {{ $rek->nasabah?->nama ?? 'Nasabah tidak ditemukan' }}
                                            </p>
                                            <p class="text-[10px] sm:text-[11px] text-slate-400 truncate max-w-50">
                                                NIN. {{ $rek->nasabah?->nin ?? '-' }}
                                                @if ($rek->nasabah && $rek->nasabah->siswa && $rek->nasabah->siswa->tahun_masuk)
                                                    • Siswa {{ $rek->nasabah->siswa->tahun_masuk }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td
                                    class="py-3 px-4 sm:px-5 whitespace-nowrap font-mono text-[10px] sm:text-xs text-slate-600">
                                    {{ $rek->no_rek }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                    @if ($rek->nasabah?->kategori === 'siswa')
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] sm:text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            Siswa
                                        </span>
                                    @elseif($rek->nasabah?->kategori === 'umum')
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] sm:text-[10px] font-bold bg-violet-50 text-violet-700 border border-violet-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-violet-500"></span>
                                            Umum
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] sm:text-[10px] font-bold bg-slate-50 text-slate-500 border border-slate-200">
                                            Belum diatur
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap text-[10px] sm:text-xs">
                                    @if ($rek->created_at)
                                        <div class="space-y-0.5">
                                            <div class="flex items-center gap-1.5 text-slate-600">
                                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span>{{ $rek->created_at->format('d M Y') }}</span>
                                            </div>
                                            <div class="flex items-center gap-1.5 text-slate-500">
                                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <span
                                                    class="max-w-45 truncate">{{ $rek->user->pegawai->nama ?? 'sistem' }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-slate-400 italic">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                    @if ($rek->status)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[9px] sm:text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[9px] sm:text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap text-right">
                                    <div
                                        class="inline-flex items-center gap-1 opacity-70 group-hover:opacity-100 transition">
                                        <button type="button" title="Cetak Sampul"
                                            class="btn-print-cover w-8 h-8 rounded-lg bg-slate-50 hover:bg-indigo-50 text-slate-500 hover:text-indigo-600 border border-slate-200 hover:border-indigo-200 flex items-center justify-center transition"
                                            data-no-rek="{{ $rek->no_rek }}"
                                            data-nama="{{ $rek->nasabah?->nama ?? '-' }}"
                                            data-ortu="{{ $rek->nasabah?->nama_ortu ?? '-' }}"
                                            data-alamat="{{ $rek->nasabah?->alamat ?? '-' }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                        </button>
                                        <a href="{{ route('rekening.subrekening', $rek) }}" title="Sub Rekening"
                                            class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-emerald-50 text-slate-500 hover:text-emerald-600 border border-slate-200 hover:border-emerald-200 flex items-center justify-center transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6M9 8h6M5 4h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('rekening.edit', $rek) }}" title="Edit Data"
                                            class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-blue-50 text-slate-500 hover:text-blue-600 border border-slate-200 hover:border-blue-200 flex items-center justify-center transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('rekening.destroy', $rek) }}" method="POST"
                                            class="form-delete-rek inline-block" data-no-rek="{{ $rek->no_rek }}"
                                            data-nama="{{ $rek->nasabah?->nama ?? '-' }}"
                                            data-status="{{ $rek->status ? 'aktif' : 'nonaktif' }}">
                                            @csrf
                                            <button type="submit" title="Hapus"
                                                class="btn-delete w-8 h-8 rounded-lg bg-slate-50 hover:bg-rose-50 text-slate-500 hover:text-rose-600 border border-slate-200 hover:border-rose-200 flex items-center justify-center transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-16 px-4 sm:px-5">
                                    <div class="text-center">
                                        <div
                                            class="w-16 h-16 mx-auto rounded-2xl bg-slate-50 text-slate-300 flex items-center justify-center mb-4 border border-slate-100">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-700 mb-1">Tidak ada data rekening</h3>
                                        <p class="text-xs text-slate-500 max-w-sm mx-auto">
                                            @if ($search || $status || $kategoriNasabah)
                                                Pencarian atau filter yang Anda gunakan tidak menghasilkan data
                                                apapun. Silakan coba filter yang lain atau
                                                <a href="{{ route('rekening.index') }}"
                                                    class="text-emerald-600 font-semibold hover:underline">reset
                                                    filter</a>.
                                            @else
                                                Belum ada rekening yang terdaftar di sistem. Silakan klik "Tambah
                                                Rekening" untuk mendaftarkan rekening pertama.
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($rekenings->hasPages())
                <div
                    class="p-4 sm:p-5 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <p class="text-[11px] sm:text-xs text-slate-500">
                        Menampilkan <span class="font-semibold text-slate-700">{{ $rekenings->firstItem() }}</span>
                        sampai
                        <span class="font-semibold text-slate-700">{{ $rekenings->lastItem() }}</span>
                        dari <span class="font-semibold text-slate-700">{{ $rekenings->total() }}</span>
                        total data
                    </p>
                    <div class="flex justify-start sm:justify-end overflow-x-auto w-full sm:w-auto -mx-1">
                        {{ $rekenings->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        </div>

    </div>

    <!-- Hidden Printing Cover Container -->
    <div id="print-cover-container">
        <div class="cover-row" id="cover-no-rek"></div>
        <div class="cover-row" id="cover-nama"></div>
        <div class="cover-row" id="cover-ortu">-</div>
        <div class="cover-row" id="cover-alamat"></div>
    </div>

    <style>
        /* Hidden from screen view */
        #print-cover-container {
            display: none;
        }

        @media print {

            /* Hide the web app UI completely from layout so it doesn't leave blank pages */
            #sidebar,
            #sidebar-overlay,
            header,
            footer,
            .space-y-5,
            .space-y-6,
            form {
                display: none !important;
            }

            body,
            html {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Only show cover elements */
            #print-cover-container {
                display: block !important;
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
                font-family: 'Courier New', Courier, monospace !important;
                font-size: 12px !important;
                /* Sesuaikan ukuran font cover */
                color: black !important;
                line-height: 2 !important;
                /* Jarak antar baris */
            }

            .cover-row {
                display: block !important;
                width: 100% !important;
                white-space: nowrap !important;
                overflow: hidden !important;
                text-overflow: ellipsis !important;
            }

            #cover-no-rek {
                margin-bottom: 13px !important;
                /* Jarak dari no rek ke nama */
            }

            #cover-nama {
                margin-bottom: 13px !important;
                /* Jarak dari nama ke ortu */
            }

            #cover-ortu {
                margin-bottom: 8px !important;
                /* Jarak dari ortu ke alamat */
            }

            @page {
                margin-left: 2in;
                /* Sesuai contoh gambar jarak kirinya jauh */
                margin-top: 0.5in;
                /* Sesuai contoh gambar jarak atasnya lumayan jauh */
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        (function() {
            function initAll() {
                const forms = document.querySelectorAll('.form-delete-rek');
                forms.forEach(function(form) {
                    form.addEventListener('submit', function(e) {
                        if (form.dataset.confirmed === '1') return;
                        e.preventDefault();

                        const noRek = form.getAttribute('data-no-rek') || 'rekening ini';
                        const nama = form.getAttribute('data-nama') || 'nasabah';
                        const status = form.getAttribute('data-status') || '';
                        const isAktif = status === 'aktif';

                        function doConfirm() {
                            if (typeof window.Swal === 'undefined') {
                                setTimeout(doConfirm, 150);
                                return;
                            }

                            const html = isAktif ?
                                '<div class="mt-2 p-3 rounded-xl border border-amber-200 bg-amber-50 text-left space-y-1 text-xs text-amber-700">' +
                                '<p class="font-bold text-amber-800 flex items-center gap-1">' +
                                '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>' +
                                ' PERINGATAN' +
                                '</p>' +
                                '<p>Rekening <strong class="font-mono">' + noRek +
                                '</strong> masih <strong>AKTIF</strong> dan terdaftar atas nama <strong>' +
                                nama + '</strong>.</p>' +
                                '<p>Pastikan tidak ada transaksi / subrekening yang masih aktif sebelum menghapus.</p>' +
                                '</div>' :
                                '<p class="text-sm text-slate-600 mt-1">Rekening <strong class="font-mono">' +
                                noRek + '</strong> milik <strong>' + nama +
                                '</strong> akan dihapus permanen dari sistem.</p>';

                            window.Swal.fire({
                                title: 'Hapus Rekening?',
                                html: html,
                                icon: isAktif ? 'warning' : 'question',
                                iconColor: isAktif ? '#d97706' : '#dc2626',
                                showCancelButton: true,
                                confirmButtonText: isAktif ? 'Tetap Hapus' : 'Ya, Hapus',
                                cancelButtonText: 'Batal',
                                reverseButtons: true,
                                confirmButtonColor: '#dc2626',
                                cancelButtonColor: '#64748b',
                                allowOutsideClick: false,
                                customClass: {
                                    popup: 'rounded-2xl shadow-2xl',
                                    confirmButton: 'font-bold rounded-xl !px-5 !py-2.5 text-sm',
                                    cancelButton: 'font-bold rounded-xl !px-5 !py-2.5 text-sm'
                                }
                            }).then(function(result) {
                                if (result.isConfirmed) {
                                    form.dataset.confirmed = '1';
                                    form.submit();
                                }
                            });
                        }
                        doConfirm();
                    });
                });

                // Print Cover Logic
                const printBtns = document.querySelectorAll('.btn-print-cover');
                const coverNoRek = document.getElementById('cover-no-rek');
                const coverNama = document.getElementById('cover-nama');
                // const coverOrtu = document.getElementById('cover-ortu'); // Ortu hardcoded to '-' according to user request
                const coverAlamat = document.getElementById('cover-alamat');

                printBtns.forEach(function(btn) {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const noRek = btn.getAttribute('data-no-rek') || '';
                        const nama = btn.getAttribute('data-nama') || '';
                        const alamat = btn.getAttribute('data-alamat') || '';

                        // Populate the hidden container
                        coverNoRek.innerText = noRek;
                        coverNama.innerText = nama.toUpperCase();
                        // coverOrtu.innerText = '-';
                        coverAlamat.innerText = alamat;

                        // Trigger print
                        window.print();
                    });
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initAll);
            } else {
                initAll();
            }
        })();
    </script>
@endsection
