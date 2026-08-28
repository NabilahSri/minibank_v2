@extends('layouts.app')

@section('title', 'Data Nasabah')
@section('page_title', 'Kelola Data Nasabah')

@section('content')
    <div class="space-y-5 sm:space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight truncate">
                    Data Nasabah
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Kelola seluruh data nasabah, siswa & umum yang terdaftar di sistem
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('nasabah.create') }}"
                    class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 focus:ring-4 focus:ring-emerald-100 transition active:scale-[0.98]">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="hidden xs:inline">Tambah Nasabah</span>
                    <span class="xs:hidden sm:hidden inline">Baru</span>
                </a>
                <form action="{{ route('nasabah.export') }}" method="GET" class="inline-block">
                    @if ($search)
                        <input type="hidden" name="q" value="{{ $search }}">
                    @endif
                    @if ($kategori)
                        <input type="hidden" name="kategori" value="{{ $kategori }}">
                    @endif
                    @if ($status)
                        <input type="hidden" name="status" value="{{ $status }}">
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
                        Total Nasabah
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        {{ number_format($totalNasabah, 0, ',', '.') }}
                    </h3>
                    <span class="text-[10px] sm:text-[11px] font-medium text-slate-500 mt-1 inline-flex items-center gap-1">
                        Siswa + Umum
                    </span>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>

            <div
                class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Nasabah Siswa
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        {{ number_format($totalSiswa, 0, ',', '.') }}
                    </h3>
                    <span class="text-[10px] sm:text-[11px] font-medium text-blue-600 mt-1 inline-flex items-center gap-1">
                        Aktif belajar
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

            <div
                class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Nasabah Umum
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        {{ number_format($totalUmum, 0, ',', '.') }}
                    </h3>
                    <span
                        class="text-[10px] sm:text-[11px] font-medium text-violet-600 mt-1 inline-flex items-center gap-1">
                        Guru / Staf / Warga
                    </span>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>

            {{-- <div
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
                        {{ $totalNasabah > 0 ? number_format(($totalAktif / $totalNasabah) * 100, 1) : 0 }}% dari total
                    </span>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
            </div> --}}
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div
                class="p-4 sm:p-5 border-b border-slate-100 flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">
                <div class="min-w-0 w-full xl:max-w-md flex-1">
                    <h2 class="text-sm font-bold text-slate-800">Daftar Nasabah</h2>
                    <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5">
                        Total {{ $nasabahs->total() }} data
                        @if ($search || $kategori || $status)
                            <span class="text-emerald-600 font-semibold">(terfilter)</span>
                        @endif
                    </p>
                </div>

                <form action="{{ route('nasabah.index') }}" method="GET"
                    class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 w-full xl:w-auto">

                    <div class="relative flex-1 sm:flex-none sm:w-64">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="q" value="{{ $search }}"
                            placeholder="Cari nama / NIN / HP / email..."
                            class="w-full pl-9 pr-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                    </div>

                    <div class="flex items-center gap-2">
                        <select name="kategori"
                            class="px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                            <option value="">Semua Kategori</option>
                            <option value="siswa" {{ $kategori === 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="umum" {{ $kategori === 'umum' ? 'selected' : '' }}>Umum</option>
                        </select>
                        <select name="status"
                            class="px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ $status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ $status === 'nonaktif' ? 'selected' : '' }}>Nonaktif
                            </option>
                            <option value="belum" {{ $status === 'belum' ? 'selected' : '' }}>Belum Punya
                                Rekening</option>
                        </select>
                        <button type="submit"
                            class="px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition active:scale-[0.98] whitespace-nowrap">
                            Filter
                        </button>
                        @if ($search || $kategori || $status)
                            <a href="{{ route('nasabah.index') }}"
                                class="px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 hover:bg-slate-100 transition whitespace-nowrap">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-[10px] sm:text-xs min-w-[900px]">
                    <thead
                        class="bg-slate-50/80 text-slate-500 uppercase tracking-wide text-[10px] sm:text-[11px] font-bold border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap w-14">#</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Nama Nasabah</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">NIN</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Kategori</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Kontak</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Jumlah Rekening</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Status</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse ($nasabahs as $i => $nsb)
                            @php
                                $rekeningAktif = $nsb->rekening->where('status', true)->count();
                                $rekeningTotal = $nsb->rekening->count();
                                $isAktif = $rekeningAktif > 0;
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition group">
                                <td class="py-3 px-4 sm:px-5 text-slate-400 font-semibold whitespace-nowrap">
                                    {{ $nasabahs->firstItem() + $i }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl {{ $nsb->jk === 'P' ? 'bg-pink-50 text-pink-600 border border-pink-200/60' : 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' }} flex items-center justify-center font-bold text-xs sm:text-sm shrink-0">
                                            {{ strtoupper(substr($nsb->nama, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-slate-800 text-xs sm:text-sm truncate max-w-[200px]">
                                                {{ $nsb->nama }}
                                            </p>
                                            <p class="text-[10px] sm:text-[11px] text-slate-400 truncate max-w-[200px]">
                                                {{ $nsb->jk === 'L' ? 'Laki-laki' : ($nsb->jk === 'P' ? 'Perempuan' : 'Jenis kelamin tidak diisi') }}
                                                @if ($nsb->siswa && $nsb->siswa->tahun_masuk)
                                                    • Siswa {{ $nsb->siswa->tahun_masuk }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td
                                    class="py-3 px-4 sm:px-5 whitespace-nowrap font-mono text-[10px] sm:text-xs text-slate-600">
                                    {{ $nsb->nin }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                    @if ($nsb->kategori === 'siswa')
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] sm:text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            Siswa
                                        </span>
                                    @elseif($nsb->kategori === 'umum')
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
                                    @if ($nsb->no_hp || $nsb->email)
                                        <div class="space-y-0.5">
                                            @if ($nsb->no_hp)
                                                <div class="flex items-center gap-1.5 text-slate-600">
                                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                    </svg>
                                                    <span>{{ $nsb->no_hp }}</span>
                                                </div>
                                            @endif
                                            @if ($nsb->email)
                                                <div class="flex items-center gap-1.5 text-slate-500">
                                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                    <span class="max-w-[180px] truncate">{{ $nsb->email }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-slate-400 italic">Tidak ada kontak</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="inline-flex items-baseline gap-1 text-sm font-bold {{ $rekeningTotal > 0 ? 'text-slate-800' : 'text-slate-400' }}">
                                            {{ $rekeningTotal }}
                                            <span class="text-[9px] font-normal text-slate-500">rekening</span>
                                        </span>
                                        @if ($rekeningAktif > 0 && $rekeningAktif < $rekeningTotal)
                                            <span class="text-[9px] font-semibold text-emerald-600">
                                                {{ $rekeningAktif }} aktif
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                    @if ($isAktif)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[9px] sm:text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Aktif
                                        </span>
                                    @elseif($rekeningTotal > 0)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[9px] sm:text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Nonaktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[9px] sm:text-[10px] font-bold bg-slate-50 text-slate-600 border border-slate-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            Belum Punya Rekening
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap text-right">
                                    <div
                                        class="inline-flex items-center gap-1 opacity-70 group-hover:opacity-100 transition">
                                        <button type="button" title="Lihat Detail"
                                            class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-emerald-50 text-slate-500 hover:text-emerald-600 border border-slate-200 hover:border-emerald-200 flex items-center justify-center transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <a href="{{ route('nasabah.edit', $nsb) }}" title="Edit Data"
                                            class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-blue-50 text-slate-500 hover:text-blue-600 border border-slate-200 hover:border-blue-200 flex items-center justify-center transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('nasabah.reset-password', $nsb) }}" method="POST"
                                            class="form-reset-password inline-block" data-nama="{{ $nsb->nama }}">
                                            @csrf
                                            <button type="submit" title="Reset Password"
                                                class="btn-reset w-8 h-8 rounded-lg bg-slate-50 hover:bg-amber-50 text-slate-500 hover:text-amber-600 border border-slate-200 hover:border-amber-200 flex items-center justify-center transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4v-3.252l7.55-7.55A6 6 0 0117 7z" />
                                                </svg>
                                            </button>
                                        </form>
                                        <form action="{{ route('nasabah.destroy', $nsb) }}" method="POST"
                                            class="form-delete inline-block" data-nama="{{ $nsb->nama }}"
                                            data-rekening="{{ $rekeningTotal }}">
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
                                <td colspan="8" class="py-16 px-4 sm:px-5">
                                    <div class="text-center">
                                        <div
                                            class="w-16 h-16 mx-auto rounded-2xl bg-slate-50 text-slate-300 flex items-center justify-center mb-4 border border-slate-100">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-700 mb-1">Tidak ada data nasabah</h3>
                                        <p class="text-xs text-slate-500 max-w-sm mx-auto">
                                            @if ($search || $kategori || $status)
                                                Pencarian atau filter yang Anda gunakan tidak menghasilkan data
                                                apapun. Silakan coba filter yang lain atau
                                                <a href="{{ route('nasabah.index') }}"
                                                    class="text-emerald-600 font-semibold hover:underline">reset
                                                    filter</a>.
                                            @else
                                                Belum ada nasabah yang terdaftar di sistem. Silakan klik "Tambah
                                                Nasabah" untuk mendaftarkan nasabah pertama.
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($nasabahs->hasPages())
                <div
                    class="p-4 sm:p-5 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <p class="text-[11px] sm:text-xs text-slate-500">
                        Menampilkan <span class="font-semibold text-slate-700">{{ $nasabahs->firstItem() }}</span>
                        sampai
                        <span class="font-semibold text-slate-700">{{ $nasabahs->lastItem() }}</span>
                        dari <span class="font-semibold text-slate-700">{{ $nasabahs->total() }}</span>
                        total data
                    </p>
                    <div class="flex justify-start sm:justify-end overflow-x-auto w-full sm:w-auto -mx-1">
                        {{ $nasabahs->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        (function() {
            function initAll() {
                const forms = document.querySelectorAll('.form-delete');
                forms.forEach(function(form) {
                    form.addEventListener('submit', function(e) {
                        if (form.dataset.confirmed === '1') return;
                        e.preventDefault();

                        const nama = form.getAttribute('data-nama') || 'nasabah ini';
                        const rekening = parseInt(form.getAttribute('data-rekening') || '0', 10);
                        const hasRekening = rekening > 0;

                        function doConfirm() {
                            if (typeof window.Swal === 'undefined') {
                                setTimeout(doConfirm, 150);
                                return;
                            }

                            const html = hasRekening ?
                                '<div class="mt-2 p-3 rounded-xl border border-amber-200 bg-amber-50 text-left space-y-1 text-xs text-amber-700">' +
                                '<p class="font-bold text-amber-800 flex items-center gap-1">' +
                                '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>' +
                                ' PERINGATAN' +
                                '</p>' +
                                '<p>Nasabah <strong>' + nama +
                                '</strong> memiliki <strong class="underline">' + rekening +
                                ' rekening</strong> yang masih terdaftar.</p>' +
                                '<p>Menghapus nasabah bisa menyebabkan error jika masih ada data transaksi / rekening terkait.</p>' +
                                '</div>' :
                                '<p class="text-sm text-slate-600 mt-1">Data <strong>' + nama +
                                '</strong> akan dihapus permanen dari sistem.</p>';

                            window.Swal.fire({
                                title: 'Hapus Nasabah?',
                                html: html,
                                icon: hasRekening ? 'warning' : 'question',
                                iconColor: hasRekening ? '#d97706' : '#dc2626',
                                showCancelButton: true,
                                confirmButtonText: hasRekening ? 'Tetap Hapus' : 'Ya, Hapus',
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

                const formResets = document.querySelectorAll('.form-reset-password');
                formResets.forEach(function(form) {
                    form.addEventListener('submit', function(e) {
                        if (form.dataset.confirmed === '1') return;
                        e.preventDefault();

                        const nama = form.getAttribute('data-nama') || 'nasabah ini';

                        if (typeof window.Swal === 'undefined') {
                            form.dataset.confirmed = '1';
                            form.submit();
                            return;
                        }

                        window.Swal.fire({
                            title: 'Reset Password?',
                            html: '<p class="text-sm text-slate-600 mt-1">Password nasabah <strong>' + nama + '</strong> akan direset ke password default (<strong>smkypc2026</strong>).</p>',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Reset',
                            cancelButtonText: 'Batal',
                            reverseButtons: true,
                            confirmButtonColor: '#f59e0b',
                            cancelButtonColor: '#64748b',
                            allowOutsideClick: false,
                            customClass: {
                                popup: 'rounded-2xl shadow-2xl',
                                confirmButton: 'font-bold rounded-xl !px-5 !py-2.5 text-sm text-white',
                                cancelButton: 'font-bold rounded-xl !px-5 !py-2.5 text-sm'
                            }
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                form.dataset.confirmed = '1';
                                form.submit();
                            }
                        });
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
