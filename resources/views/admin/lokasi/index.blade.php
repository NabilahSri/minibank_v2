@extends('layouts.app')

@section('title', 'Data Lokasi')
@section('page_title', 'Kelola Data Lokasi')

@section('content')
    <div class="space-y-5 sm:space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight truncate">
                    Data Lokasi
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Kelola lokasi / cabang kerja untuk penempatan pegawai
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <button type="button" id="btnOpenAddLokasi"
                    class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 focus:ring-4 focus:ring-emerald-100 transition active:scale-[0.98]">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="hidden xs:inline">Tambah Lokasi</span>
                    <span class="xs:hidden sm:hidden inline">Baru</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
            <div
                class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Total Lokasi
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        {{ number_format($totalLokasi, 0, ',', '.') }}
                    </h3>
                    <span class="text-[10px] sm:text-[11px] font-medium text-slate-500 mt-1 inline-flex items-center gap-1">
                        Kantor / cabang terdaftar
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

            <div
                class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Total Pegawai
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        {{ number_format($totalPegawaiOnLokasi, 0, ',', '.') }}
                    </h3>
                    <span
                        class="text-[10px] sm:text-[11px] font-medium text-emerald-600 mt-1 inline-flex items-center gap-1">
                        Tersebar di semua lokasi
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
                class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3 sm:col-span-2 lg:col-span-1">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Rata-rata Pegawai
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        {{ $totalLokasi > 0 ? number_format($totalPegawaiOnLokasi / $totalLokasi, 1, ',', '.') : '0' }}
                    </h3>
                    <span class="text-[10px] sm:text-[11px] font-medium text-blue-600 mt-1 inline-flex items-center gap-1">
                        Pegawai per lokasi
                    </span>
                </div>
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div
                class="p-4 sm:p-5 border-b border-slate-100 flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">
                <div class="min-w-0 w-full xl:max-w-md flex-1">
                    <h2 class="text-sm font-bold text-slate-800">Daftar Lokasi</h2>
                    <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5">
                        Total {{ $lokasis->total() }} data
                        @if ($search)
                            <span class="text-emerald-600 font-semibold">(terfilter)</span>
                        @endif
                    </p>
                </div>

                <form action="{{ route('lokasi.index') }}" method="GET"
                    class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 w-full xl:w-auto">

                    <div class="relative flex-1 sm:flex-none sm:w-72">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama lokasi..."
                            class="w-full pl-9 pr-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                    </div>

                    <div class="flex items-center gap-2 flex-wrap">
                        <button type="submit"
                            class="px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition active:scale-[0.98] whitespace-nowrap">
                            Cari
                        </button>
                        @if ($search)
                            <a href="{{ route('lokasi.index') }}"
                                class="px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 hover:bg-slate-100 transition whitespace-nowrap">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-[10px] sm:text-xs min-w-[720px]">
                    <thead
                        class="bg-slate-50/80 text-slate-500 uppercase tracking-wide text-[10px] sm:text-[11px] font-bold border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap w-14">#</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Nama Lokasi</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Jumlah Pegawai</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Dibuat Pada</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse ($lokasis as $i => $lok)
                            <tr class="hover:bg-slate-50/80 transition group" data-lokasi-id="{{ $lok->id }}"
                                data-lokasi-nama="{{ $lok->nama_lokasi }}">
                                <td class="py-3 px-4 sm:px-5 text-slate-400 font-semibold whitespace-nowrap">
                                    {{ $lokasis->firstItem() + $i }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-amber-50 text-amber-600 border border-amber-200/60 flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-slate-800 text-xs sm:text-sm truncate max-w-[260px]">
                                                {{ $lok->nama_lokasi }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                    @php
                                        $jml = $lok->pegawai_count ?? 0;
                                    @endphp
                                    @if ($jml > 0)
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] sm:text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            {{ number_format($jml, 0, ',', '.') }} orang
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] sm:text-[11px] font-bold bg-slate-50 text-slate-500 border border-slate-200">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                            Belum ada pegawai
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap text-[10px] sm:text-xs text-slate-500">
                                    <div class="space-y-0.5">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>{{ \Carbon\Carbon::parse($lok->created_at)->format('d M Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-1.5 text-slate-400">
                                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ \Carbon\Carbon::parse($lok->created_at)->format('H:i') }} WIB</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap text-right">
                                    <div
                                        class="inline-flex items-center gap-1 opacity-70 group-hover:opacity-100 transition">
                                        <button type="button" title="Edit Lokasi"
                                            class="btn-edit-lok w-8 h-8 rounded-lg bg-slate-50 hover:bg-blue-50 text-slate-500 hover:text-blue-600 border border-slate-200 hover:border-blue-200 flex items-center justify-center transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('lokasi.destroy', $lok) }}" method="POST"
                                            class="form-delete-lok inline-block" data-id="{{ $lok->id }}"
                                            data-nama="{{ $lok->nama_lokasi }}" data-jml="{{ $jml }}">
                                            @csrf
                                            <button type="submit" title="Hapus Lokasi"
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
                                <td colspan="5" class="py-16 px-4 sm:px-5">
                                    <div class="text-center">
                                        <div
                                            class="w-16 h-16 mx-auto rounded-2xl bg-slate-50 text-slate-300 flex items-center justify-center mb-4 border border-slate-100">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-700 mb-1">Tidak ada data lokasi</h3>
                                        <p class="text-xs text-slate-500 max-w-sm mx-auto">
                                            @if ($search)
                                                Pencarian yang Anda gunakan tidak menghasilkan data apapun. Silakan coba
                                                kata kunci lain atau
                                                <a href="{{ route('lokasi.index') }}"
                                                    class="text-emerald-600 font-semibold hover:underline">reset
                                                    pencarian</a>.
                                            @else
                                                Belum ada lokasi / cabang kerja yang terdaftar. Silakan klik
                                                "Tambah Lokasi" untuk mendaftarkan lokasi pertama.
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($lokasis->hasPages())
                <div
                    class="p-4 sm:p-5 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <p class="text-[11px] sm:text-xs text-slate-500">
                        Menampilkan <span class="font-semibold text-slate-700">{{ $lokasis->firstItem() }}</span>
                        sampai
                        <span class="font-semibold text-slate-700">{{ $lokasis->lastItem() }}</span>
                        dari <span class="font-semibold text-slate-700">{{ $lokasis->total() }}</span> total data
                    </p>
                    <div class="flex justify-start sm:justify-end overflow-x-auto w-full sm:w-auto -mx-1">
                        {{ $lokasis->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        </div>

    </div>

    <div id="modalLokasi"
        class="fixed inset-0 z-[80] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div
            class="w-full max-w-md bg-white rounded-2xl shadow-2xl border border-slate-200/80 overflow-hidden transform transition-all">
            <div
                class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between gap-3 bg-gradient-to-r from-emerald-50 to-teal-50">
                <div class="flex items-center gap-3 min-w-0">
                    <div
                        class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg id="modalLokasiIcon" class="w-4 h-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 id="modalLokasiTitle" class="text-sm font-bold text-slate-800 truncate">Tambah Lokasi Baru
                        </h3>
                        <p id="modalLokasiSubtitle" class="text-[10px] sm:text-xs text-slate-500 mt-0.5">
                            Tambahkan lokasi kerja baru
                        </p>
                    </div>
                </div>
                <button type="button" id="btnCloseModalLokasi"
                    class="w-8 h-8 rounded-lg bg-white hover:bg-slate-100 text-slate-500 hover:text-slate-700 flex items-center justify-center transition border border-slate-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="formModalLokasi" action="{{ route('lokasi.store') }}" method="POST" novalidate>
                @csrf
                <input type="hidden" name="ajax" value="1">
                <input type="hidden" id="lokasi_method" value="POST">
                <div class="p-4 sm:p-5 space-y-4">
                    <div>
                        <label for="modal_nama_lokasi"
                            class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                            Nama Lokasi <span class="text-rose-500">*</span>
                            <span class="font-normal text-slate-400">(misal: Kantor Pusat, Cabang Surabaya)</span>
                        </label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none shrink-0"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <input type="text" id="modal_nama_lokasi" name="nama_lokasi" maxlength="100" required
                                autofocus
                                class="w-full pl-9 pr-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition placeholder:text-slate-400"
                                placeholder="cth: Kantor Cabang Surabaya">
                        </div>
                        <p id="modal_lokasi_error"
                            class="hidden text-[10px] sm:text-xs text-rose-600 mt-1.5 flex items-center gap-1">
                            <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span></span>
                        </p>
                    </div>
                </div>
                <div
                    class="p-4 sm:p-5 border-t border-slate-100 bg-slate-50/60 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2">
                    <button type="button" id="btnBatalModalLokasi"
                        class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-600 bg-white hover:bg-slate-100 border border-slate-200 transition active:scale-[0.98]">
                        Batal
                    </button>
                    <button type="submit" id="btnSubmitModalLokasi"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 focus:ring-4 focus:ring-emerald-100 transition active:scale-[0.98]">
                        <svg id="iconLoadingModalLokasi" class="w-4 h-4 shrink-0 animate-spin hidden" viewBox="0 0 24 24"
                            fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <svg id="iconCheckModalLokasi" class="w-4 h-4 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span id="txtBtnModalLokasi">Simpan Lokasi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function() {
            function showToast(type, title, message) {
                function fireToast() {
                    if (typeof window.toast !== 'undefined' && typeof window.showToast === 'function') {
                        window.showToast(type, title, message);
                        return;
                    }
                    if (typeof window.Swal !== 'undefined') {
                        const cfg = {
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true,
                            title: title,
                            text: message,
                            didOpen: function(toast) {
                                toast.addEventListener('mouseenter', window.Swal.stopTimer);
                                toast.addEventListener('mouseleave', window.Swal.resumeTimer);
                            }
                        };
                        if (type === 'success') cfg.icon = 'success';
                        else if (type === 'error') cfg.icon = 'error';
                        else if (type === 'warning') cfg.icon = 'warning';
                        else cfg.icon = 'info';
                        window.Swal.fire(cfg);
                        return;
                    }
                    setTimeout(fireToast, 150);
                }
                fireToast();
            }

            const modal = document.getElementById('modalLokasi');
            const btnOpenAdd = document.getElementById('btnOpenAddLokasi');
            const btnClose = document.getElementById('btnCloseModalLokasi');
            const btnBatal = document.getElementById('btnBatalModalLokasi');
            const form = document.getElementById('formModalLokasi');
            const methodInput = document.getElementById('lokasi_method');
            const inputNama = document.getElementById('modal_nama_lokasi');
            const errWrap = document.getElementById('modal_lokasi_error');
            const errMsg = errWrap ? errWrap.querySelector('span') : null;
            const btnSubmit = document.getElementById('btnSubmitModalLokasi');
            const iconLoading = document.getElementById('iconLoadingModalLokasi');
            const iconCheck = document.getElementById('iconCheckModalLokasi');
            const txtBtn = document.getElementById('txtBtnModalLokasi');
            const titleModal = document.getElementById('modalLokasiTitle');
            const subtitleModal = document.getElementById('modalLokasiSubtitle');
            const iconModal = document.getElementById('modalLokasiIcon');

            function openModalForAdd() {
                if (!modal) return;
                if (titleModal) titleModal.textContent = 'Tambah Lokasi Baru';
                if (subtitleModal) subtitleModal.textContent = 'Tambahkan lokasi kerja baru';
                if (iconModal) iconModal.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />';
                if (form) {
                    form.action = '{{ route('lokasi.store') }}';
                    form.dataset.editId = '';
                }
                if (methodInput) methodInput.value = 'POST';
                if (txtBtn) txtBtn.textContent = 'Simpan Lokasi';
                if (inputNama) {
                    inputNama.value = '';
                }
                openModal();
            }

            function openModalForEdit(id, nama) {
                if (!modal) return;
                if (titleModal) titleModal.textContent = 'Edit Data Lokasi';
                if (subtitleModal) subtitleModal.textContent = 'Perbarui nama lokasi yang ada';
                if (iconModal) iconModal.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />';
                if (form) {
                    form.action = '/lokasi/' + encodeURIComponent(id);
                    form.dataset.editId = id;
                }
                if (methodInput) methodInput.value = 'POST';
                if (txtBtn) txtBtn.textContent = 'Perbarui Lokasi';
                if (inputNama) {
                    inputNama.value = nama || '';
                }
                openModal();
            }

            function openModal() {
                if (!modal) return;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
                if (inputNama) {
                    setTimeout(function() {
                        inputNama.focus();
                        if (inputNama.value) inputNama.select();
                    }, 80);
                }
                hideError();
            }

            function closeModal() {
                if (!modal) return;
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
                hideError();
                setLoading(false);
            }

            function showError(msg) {
                if (errWrap) errWrap.classList.remove('hidden');
                if (errMsg) errMsg.textContent = msg;
            }

            function hideError() {
                if (errWrap) errWrap.classList.add('hidden');
                if (errMsg) errMsg.textContent = '';
            }

            function setLoading(loading) {
                if (!btnSubmit) return;
                btnSubmit.disabled = loading;
                if (loading) {
                    if (iconLoading) iconLoading.classList.remove('hidden');
                    if (iconCheck) iconCheck.classList.add('hidden');
                    btnSubmit.classList.add('opacity-70', 'cursor-not-allowed');
                } else {
                    if (iconLoading) iconLoading.classList.add('hidden');
                    if (iconCheck) iconCheck.classList.remove('hidden');
                    btnSubmit.classList.remove('opacity-70', 'cursor-not-allowed');
                }
            }

            if (btnOpenAdd) btnOpenAdd.addEventListener('click', openModalForAdd);
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

            document.querySelectorAll('.btn-edit-lok').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const tr = this.closest('tr[data-lokasi-id]');
                    if (!tr) return;
                    const id = tr.getAttribute('data-lokasi-id');
                    const nama = tr.getAttribute('data-lokasi-nama');
                    openModalForEdit(id, nama);
                });
            });

            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    hideError();
                    const nama = inputNama ? inputNama.value.trim() : '';
                    if (nama === '') {
                        showError('Nama lokasi wajib diisi.');
                        if (inputNama) inputNama.focus();
                        return;
                    }
                    if (nama.length > 100) {
                        showError('Nama lokasi maksimal 100 karakter.');
                        if (inputNama) inputNama.focus();
                        return;
                    }
                    setLoading(true);
                    const fd = new FormData(form);
                    const isEdit = !!(form.dataset.editId && form.dataset.editId !== '');
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: fd
                    }).then(function(res) {
                        if (!res.ok) {
                            return res.json().then(function(data) {
                                throw data;
                            }).catch(function(err) {
                                if (err && typeof err === 'object' && (err.errors || err
                                        .message)) throw err;
                                throw {
                                    message: 'HTTP Error ' + res.status
                                };
                            });
                        }
                        return res.json();
                    }).then(function(data) {
                        closeModal();
                        setLoading(false);
                        if (data && data.success) {
                            showToast('success', isEdit ? 'Lokasi Diperbarui' : 'Lokasi Ditambahkan',
                                data &&
                                data.message ? data.message : (isEdit ?
                                    'Lokasi berhasil diperbarui.' : 'Lokasi berhasil ditambahkan.'));
                            setTimeout(function() {
                                window.location.reload();
                            }, 400);
                        } else {
                            showToast('error', 'Gagal', data && data.message ? data.message :
                                'Terjadi kesalahan saat menyimpan.');
                        }
                    }).catch(function(err) {
                        setLoading(false);
                        let msg = err && err.message ? err.message :
                            'Gagal menyimpan lokasi. Silakan coba lagi.';
                        if (err && err.errors && err.errors.nama_lokasi && Array.isArray(err.errors
                                .nama_lokasi)) {
                            msg = err.errors.nama_lokasi[0];
                        } else if (err && err.errors && err.errors.nama_lokasi) {
                            msg = err.errors.nama_lokasi;
                        }
                        showError(msg);
                    });
                });
            }

            const delForms = document.querySelectorAll('.form-delete-lok');
            delForms.forEach(function(f) {
                f.addEventListener('submit', function(e) {
                    if (f.dataset.confirmed === '1') return;
                    e.preventDefault();
                    const nama = f.getAttribute('data-nama') || 'lokasi ini';
                    const jml = parseInt(f.getAttribute('data-jml') || '0', 10);
                    const isUsed = jml > 0;

                    function doConfirm() {
                        if (typeof window.Swal === 'undefined') {
                            setTimeout(doConfirm, 150);
                            return;
                        }
                        let html;
                        if (isUsed) {
                            html =
                                '<div class="mt-2 p-3 rounded-xl border border-amber-200 bg-amber-50 text-left space-y-1 text-xs text-amber-700">' +
                                '<p class="font-bold text-amber-800 flex items-center gap-1">' +
                                '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>' +
                                ' PERINGATAN: LOKASI TERPAKAI' +
                                '</p>' +
                                '<p>Lokasi <strong>' + nama +
                                '</strong> masih digunakan oleh <strong>' + jml +
                                ' pegawai</strong>.</p>' +
                                '<p>Menghapus lokasi ini akan gagal karena masih ada pegawai yang terdaftar. Pindahkan pegawai terlebih dahulu.</p>' +
                                '</div>';
                        } else {
                            html =
                                '<p class="text-sm text-slate-600 mt-1">Lokasi <strong>' + nama +
                                '</strong> akan dihapus permanen dari sistem.</p>';
                        }
                        window.Swal.fire({
                            title: 'Hapus Lokasi?',
                            html: html,
                            icon: isUsed ? 'warning' : 'question',
                            iconColor: isUsed ? '#f59e0b' : '#dc2626',
                            showCancelButton: true,
                            confirmButtonText: isUsed ? 'Tetap Hapus' : 'Ya, Hapus',
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
                                f.dataset.confirmed = '1';
                                f.submit();
                            }
                        });
                    }
                    doConfirm();
                });
            });
        })();
    </script>
@endsection
