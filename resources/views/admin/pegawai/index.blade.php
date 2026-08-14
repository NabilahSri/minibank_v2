@extends('layouts.app')

@section('title', 'Data Pegawai')
@section('page_title', 'Kelola Data Pegawai')

@section('content')
    <div class="space-y-5 sm:space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight truncate">
                    Data Pegawai
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Kelola seluruh data pegawai / operator / admin sistem
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('pegawai.create') }}"
                    class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 focus:ring-4 focus:ring-emerald-100 transition active:scale-[0.98]">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="hidden xs:inline">Tambah Pegawai</span>
                    <span class="xs:hidden sm:hidden inline">Baru</span>
                </a>
                <form action="{{ route('pegawai.export') }}" method="GET" class="inline-block">
                    @if ($search)
                        <input type="hidden" name="q" value="{{ $search }}">
                    @endif
                    @if ($role)
                        <input type="hidden" name="role" value="{{ $role }}">
                    @endif
                    @if ($lokasiId)
                        <input type="hidden" name="lokasi_id" value="{{ $lokasiId }}">
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
                        Total Pegawai
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        {{ number_format($totalPegawai, 0, ',', '.') }}
                    </h3>
                    <span class="text-[10px] sm:text-[11px] font-medium text-slate-500 mt-1 inline-flex items-center gap-1">
                        Admin + Operator
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
                        Administrator
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        {{ number_format($totalAdmin, 0, ',', '.') }}
                    </h3>
                    <span
                        class="text-[10px] sm:text-[11px] font-medium text-purple-600 mt-1 inline-flex items-center gap-1">
                        {{ $totalPegawai > 0 ? number_format(($totalAdmin / $totalPegawai) * 100, 1) : 0 }}% dari total
                    </span>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
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
                        Operator
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        {{ number_format($totalOperator, 0, ',', '.') }}
                    </h3>
                    <span class="text-[10px] sm:text-[11px] font-medium text-blue-600 mt-1 inline-flex items-center gap-1">
                        {{ $totalPegawai > 0 ? number_format(($totalOperator / $totalPegawai) * 100, 1) : 0 }}% dari total
                    </span>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2" />
                    </svg>
                </div>
            </div>

            <div
                class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Lokasi Kerja
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        {{ number_format($totalLokasi, 0, ',', '.') }}
                    </h3>
                    <span class="text-[10px] sm:text-[11px] font-medium text-amber-600 mt-1 inline-flex items-center gap-1">
                        Tempat / Cabang aktif
                    </span>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div
                class="p-4 sm:p-5 border-b border-slate-100 flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">
                <div class="min-w-0 w-full xl:max-w-md flex-1">
                    <h2 class="text-sm font-bold text-slate-800">Daftar Pegawai</h2>
                    <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5">
                        Total {{ $pegawais->total() }} data
                        @if ($search || $role || $lokasiId)
                            <span class="text-emerald-600 font-semibold">(terfilter)</span>
                        @endif
                    </p>
                </div>

                <form action="{{ route('pegawai.index') }}" method="GET"
                    class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 w-full xl:w-auto">

                    <div class="relative flex-1 sm:flex-none sm:w-64">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="q" value="{{ $search }}"
                            placeholder="Cari NIP / Nama / HP..."
                            class="w-full pl-9 pr-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                    </div>

                    <div class="flex items-center gap-2 flex-wrap">
                        <select name="role" data-searchable="true" data-placeholder="Semua role"
                            class="px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                            <option value="">Semua Role</option>
                            <option value="adm" {{ $role === 'adm' ? 'selected' : '' }}>Admin</option>
                            <option value="opr" {{ $role === 'opr' ? 'selected' : '' }}>Operator</option>
                        </select>
                        <select name="lokasi_id" data-searchable="true" data-placeholder="Semua lokasi"
                            class="px-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                            <option value="">Semua Lokasi</option>
                            @foreach ($lokasis as $l)
                                <option value="{{ $l->id }}" {{ $lokasiId === $l->id ? 'selected' : '' }}>
                                    {{ $l->nama_lokasi }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition active:scale-[0.98] whitespace-nowrap">
                            Filter
                        </button>
                        @if ($search || $role || $lokasiId)
                            <a href="{{ route('pegawai.index') }}"
                                class="px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 hover:bg-slate-100 transition whitespace-nowrap">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-[10px] sm:text-xs min-w-[950px]">
                    <thead
                        class="bg-slate-50/80 text-slate-500 uppercase tracking-wide text-[10px] sm:text-[11px] font-bold border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap w-14">#</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Pegawai</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">NIP</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Role</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Lokasi</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Kontak</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse ($pegawais as $i => $peg)
                            <tr class="hover:bg-slate-50/80 transition group">
                                <td class="py-3 px-4 sm:px-5 text-slate-400 font-semibold whitespace-nowrap">
                                    {{ $pegawais->firstItem() + $i }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        @php
                                            $jk = $peg->jk ?? null;
                                            $initials = strtoupper(substr($peg->nama ?? '?', 0, 1));
                                        @endphp
                                        <div
                                            class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl {{ $jk === 'P' ? 'bg-pink-50 text-pink-600 border border-pink-200/60' : ($jk === 'L' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-slate-50 text-slate-500 border border-slate-200/60') }} flex items-center justify-center font-bold text-xs sm:text-sm shrink-0">
                                            {{ $initials }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-slate-800 text-xs sm:text-sm truncate max-w-[200px]">
                                                {{ $peg->nama }}
                                            </p>
                                            <p class="text-[10px] sm:text-[11px] text-slate-400 truncate max-w-[200px]">
                                                Username: <span
                                                    class="font-mono">{{ $peg->user?->username ?? '-' }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td
                                    class="py-3 px-4 sm:px-5 whitespace-nowrap font-mono text-[10px] sm:text-xs text-slate-600">
                                    {{ $peg->nip }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                    @if ($peg->user?->role === 'adm')
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] sm:text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                            Administrator
                                        </span>
                                    @elseif($peg->user?->role === 'opr')
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] sm:text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            Operator
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[9px] sm:text-[10px] font-bold bg-slate-50 text-slate-500 border border-slate-200">
                                            Belum diatur
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                    <div class="flex items-start gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-amber-500 shrink-0 mt-0.5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <div>
                                            <span
                                                class="font-semibold text-[10px] sm:text-xs text-slate-700 block max-w-[160px] truncate">
                                                {{ $peg->lokasi?->nama_lokasi ?? 'Belum ditentukan' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap text-[10px] sm:text-xs">
                                    <div class="space-y-0.5 min-w-[150px]">
                                        @if ($peg->no_hp)
                                            <div class="flex items-center gap-1.5 text-slate-600">
                                                <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                <span class="truncate max-w-[140px]">{{ $peg->no_hp }}</span>
                                            </div>
                                        @endif
                                        @if ($peg->email)
                                            <div class="flex items-center gap-1.5 text-slate-500">
                                                <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                <span class="truncate max-w-[140px]">{{ $peg->email }}</span>
                                            </div>
                                        @endif
                                        @if (!$peg->no_hp && !$peg->email)
                                            <span class="text-slate-400 italic">-</span>
                                        @endif
                                    </div>
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
                                        <a href="{{ route('pegawai.edit', $peg) }}" title="Edit Data"
                                            class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-blue-50 text-slate-500 hover:text-blue-600 border border-slate-200 hover:border-blue-200 flex items-center justify-center transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('pegawai.destroy', $peg) }}" method="POST"
                                            class="form-delete-peg inline-block" data-nip="{{ $peg->nip }}"
                                            data-nama="{{ $peg->nama }}"
                                            data-role="{{ $peg->user?->role === 'adm' ? 'administrator' : 'operator' }}">
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
                                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2" />
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-700 mb-1">Tidak ada data pegawai</h3>
                                        <p class="text-xs text-slate-500 max-w-sm mx-auto">
                                            @if ($search || $role || $lokasiId)
                                                Pencarian atau filter yang Anda gunakan tidak menghasilkan data
                                                apapun. Silakan coba filter yang lain atau
                                                <a href="{{ route('pegawai.index') }}"
                                                    class="text-emerald-600 font-semibold hover:underline">reset
                                                    filter</a>.
                                            @else
                                                Belum ada pegawai yang terdaftar. Silakan klik "Tambah Pegawai" untuk
                                                mendaftarkan pegawai pertama.
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($pegawais->hasPages())
                <div
                    class="p-4 sm:p-5 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <p class="text-[11px] sm:text-xs text-slate-500">
                        Menampilkan <span class="font-semibold text-slate-700">{{ $pegawais->firstItem() }}</span> sampai
                        <span class="font-semibold text-slate-700">{{ $pegawais->lastItem() }}</span>
                        dari <span class="font-semibold text-slate-700">{{ $pegawais->total() }}</span> total data
                    </p>
                    <div class="flex justify-start sm:justify-end overflow-x-auto w-full sm:w-auto -mx-1">
                        {{ $pegawais->onEachSide(1)->links() }}
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
                const forms = document.querySelectorAll('.form-delete-peg');
                forms.forEach(function(form) {
                    form.addEventListener('submit', function(e) {
                        if (form.dataset.confirmed === '1') return;
                        e.preventDefault();

                        const nip = form.getAttribute('data-nip') || 'pegawai ini';
                        const nama = form.getAttribute('data-nama') || 'pegawai';
                        const role = form.getAttribute('data-role') || '';
                        const isAdmin = role === 'administrator';

                        function doConfirm() {
                            if (typeof window.Swal === 'undefined') {
                                setTimeout(doConfirm, 150);
                                return;
                            }

                            const html = isAdmin ?
                                '<div class="mt-2 p-3 rounded-xl border border-purple-200 bg-purple-50 text-left space-y-1 text-xs text-purple-700">' +
                                '<p class="font-bold text-purple-800 flex items-center gap-1">' +
                                '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>' +
                                ' PERINGATAN ADMINISTRATOR' +
                                '</p>' +
                                '<p>Pegawai dengan NIP <strong class="font-mono">' + nip +
                                '</strong> adalah seorang <strong>ADMINISTRATOR</strong> akun <strong>' +
                                nama +
                                '</strong>.</p>' +
                                '<p>Menghapus admin dapat berdampak pada akses sistem. Pastikan ada admin lain yang tersisa.</p>' +
                                '</div>' :
                                '<p class="text-sm text-slate-600 mt-1">Pegawai <strong>' + nama +
                                '</strong> (NIP: <strong class="font-mono">' + nip +
                                '</strong>) akan dihapus permanen beserta akun login-nya.</p>';

                            window.Swal.fire({
                                title: 'Hapus Pegawai?',
                                html: html,
                                icon: isAdmin ? 'warning' : 'question',
                                iconColor: isAdmin ? '#7c3aed' : '#dc2626',
                                showCancelButton: true,
                                confirmButtonText: isAdmin ? 'Tetap Hapus' : 'Ya, Hapus',
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
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initAll);
            } else {
                initAll();
            }
        })();
    </script>
@endsection
