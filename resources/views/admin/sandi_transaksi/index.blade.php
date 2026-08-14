@extends('layouts.app')

@section('title', 'Data Sandi Transaksi')
@section('page_title', 'Kelola Sandi Transaksi')

@section('content')
    <div class="space-y-5 sm:space-y-6">

        <!-- Title Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight truncate">
                    Data Sandi Transaksi
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Kelola sandi dan jenis transaksi perbankan
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <button type="button" id="btnOpenAddSandi"
                    class="inline-flex items-center gap-2 px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 focus:ring-4 focus:ring-emerald-100 transition active:scale-[0.98]">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="hidden xs:inline">Tambah Sandi</span>
                    <span class="xs:hidden sm:hidden inline">Baru</span>
                </button>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <!-- Total Sandi -->
            <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Total Sandi
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        {{ number_format($totalSandi, 0, ',', '.') }}
                    </h3>
                    <span class="text-[10px] sm:text-[11px] font-medium text-slate-500 mt-1 inline-flex items-center gap-1">
                        Sandi transaksi aktif
                    </span>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>

            <!-- Setor -->
            <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Sandi Setor
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        {{ number_format($totalSetor, 0, ',', '.') }}
                    </h3>
                    <span class="text-[10px] sm:text-[11px] font-medium text-emerald-600 mt-1 inline-flex items-center gap-1">
                        Transaksi setoran tunai
                    </span>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v16m8-8H4" />
                    </svg>
                </div>
            </div>

            <!-- Tarik -->
            <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Sandi Tarik
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        {{ number_format($totalTarik, 0, ',', '.') }}
                    </h3>
                    <span class="text-[10px] sm:text-[11px] font-medium text-amber-600 mt-1 inline-flex items-center gap-1">
                        Transaksi penarikan tunai
                    </span>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 12H4" />
                    </svg>
                </div>
            </div>

            <!-- Transfer -->
            <div class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[10px] sm:text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Sandi Transfer
                    </p>
                    <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-1 truncate">
                        {{ number_format($totalTransfer, 0, ',', '.') }}
                    </h3>
                    <span class="text-[10px] sm:text-[11px] font-medium text-blue-600 mt-1 inline-flex items-center gap-1">
                        Transaksi transfer dana
                    </span>
                </div>
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col xl:flex-row xl:items-center xl:justify-between gap-3">
                <div class="min-w-0 w-full xl:max-w-md flex-1">
                    <h2 class="text-sm font-bold text-slate-800">Daftar Sandi Transaksi</h2>
                    <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5">
                        Total {{ $sandis->total() }} data
                        @if ($search)
                            <span class="text-emerald-600 font-semibold">(terfilter)</span>
                        @endif
                    </p>
                </div>

                <form action="{{ route('sandi.index') }}" method="GET"
                    class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 w-full xl:w-auto">

                    <div class="relative flex-1 sm:flex-none sm:w-72">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari kode, nama, atau jenis..."
                            class="w-full pl-9 pr-3 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                    </div>

                    <div class="flex items-center gap-2 flex-wrap">
                        <button type="submit"
                            class="px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 shadow-sm transition active:scale-[0.98] whitespace-nowrap">
                            Cari
                        </button>
                        @if ($search)
                            <a href="{{ route('sandi.index') }}"
                                class="px-3 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 hover:bg-slate-100 transition whitespace-nowrap">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-[10px] sm:text-xs min-w-[640px]">
                    <thead class="bg-slate-50/80 text-slate-500 uppercase tracking-wide text-[10px] sm:text-[11px] font-bold border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap w-14">#</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap w-32">Kode Sandi</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Nama Sandi</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap w-40">Jenis Transaksi</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap w-40">Jumlah Transaksi</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Dibuat Pada</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap text-right w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse ($sandis as $i => $sandi)
                            <tr class="hover:bg-slate-50/80 transition group" 
                                data-sandi-id="{{ $sandi->id }}"
                                data-sandi-kode="{{ $sandi->kode }}"
                                data-sandi-nama="{{ $sandi->nama }}"
                                data-sandi-jenis="{{ $sandi->jenis_transaksi }}">
                                <td class="py-3 px-4 sm:px-5 text-slate-400 font-semibold whitespace-nowrap">
                                    {{ $sandis->firstItem() + $i }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap font-mono font-semibold text-slate-800">
                                    {{ $sandi->kode }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                    <span class="font-bold text-slate-800 text-xs sm:text-sm">
                                        {{ $sandi->nama }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                    @if ($sandi->jenis_transaksi === 'setor')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] sm:text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            Setor
                                        </span>
                                    @elseif ($sandi->jenis_transaksi === 'tarik')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] sm:text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            Tarik
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] sm:text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                            Transfer
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                    @php $jml = $sandi->transaksi_count ?? 0; @endphp
                                    @if ($jml > 0)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                            {{ number_format($jml, 0, ',', '.') }} Transaksi
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-[10px]">0</span>
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
                                            <span>{{ $sandi->created_at ? \Carbon\Carbon::parse($sandi->created_at)->format('d M Y') : '—' }}</span>
                                        </div>
                                        <div class="flex items-center gap-1.5 text-slate-400">
                                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ $sandi->created_at ? \Carbon\Carbon::parse($sandi->created_at)->format('H:i') . ' WIB' : '—' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap text-right">
                                    <div class="inline-flex items-center gap-1 opacity-70 group-hover:opacity-100 transition">
                                        <button type="button" title="Edit Sandi"
                                            class="btn-edit-sandi w-8 h-8 rounded-lg bg-slate-50 hover:bg-blue-50 text-slate-500 hover:text-blue-600 border border-slate-200 hover:border-blue-200 flex items-center justify-center transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('sandi.destroy', $sandi->id) }}" method="POST"
                                            class="form-delete-sandi inline-block" 
                                            data-nama="{{ $sandi->nama }}" 
                                            data-jml="{{ $jml }}">
                                            @csrf
                                            <button type="submit" title="Hapus Sandi"
                                                class="btn-delete w-8 h-8 rounded-lg bg-slate-50 hover:bg-rose-50 text-slate-500 hover:text-rose-600 border border-slate-200 hover:border-rose-200 flex items-center justify-center transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                <td colspan="7" class="py-8 text-center text-slate-400 font-medium">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <span>Tidak ada data sandi transaksi ditemukan.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($sandis->hasPages())
                <div class="px-4 py-3 sm:px-5 border-t border-slate-100 bg-slate-50/50">
                    {{ $sandis->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Form (Add & Edit) -->
    <div id="modalSandi"
        class="fixed inset-0 z-[80] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl border border-slate-200/80 overflow-hidden transform transition-all">
            <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between gap-3 bg-gradient-to-r from-emerald-50 to-teal-50">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg id="iconModal" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 id="titleModal" class="text-sm font-bold text-slate-800 truncate">Tambah Sandi Transaksi</h3>
                        <p id="subtitleModal" class="text-[10px] sm:text-xs text-slate-500 mt-0.5">Tambahkan kode sandi transaksi baru</p>
                    </div>
                </div>
                <button type="button" id="btnCloseModal"
                    class="w-8 h-8 rounded-lg bg-white hover:bg-slate-100 text-slate-500 hover:text-slate-700 flex items-center justify-center transition border border-slate-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="formSandi" action="{{ route('sandi.store') }}" method="POST" novalidate>
                @csrf
                <input type="hidden" name="ajax" value="1">
                <input type="hidden" name="_method" id="methodInput" value="POST">
                
                <div class="p-4 sm:p-5 space-y-4">
                    <!-- Error Alert Inside Modal -->
                    <div id="errWrap" class="p-3 rounded-xl border border-rose-200 bg-rose-50 flex items-start gap-2.5 text-rose-700 text-xs hidden">
                        <svg class="w-3.5 h-3.5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span id="errMsg" class="font-medium leading-normal flex-1"></span>
                    </div>

                    <!-- Input Kode -->
                    <div>
                        <label for="inputKode" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                            Kode Sandi <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="kode" id="inputKode" required placeholder="cth: 01"
                                class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition placeholder:text-slate-400">
                        </div>
                    </div>

                    <!-- Input Nama -->
                    <div>
                        <label for="inputNama" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                            Nama Sandi Transaksi <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="nama" id="inputNama" required placeholder="cth: Setoran Tunai"
                                class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition placeholder:text-slate-400">
                        </div>
                    </div>

                    <!-- Select Jenis Transaksi -->
                    <div>
                        <label for="selectJenis" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                            Jenis Transaksi <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="jenis_transaksi" id="selectJenis" required
                                class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition appearance-none">
                                <option value="setor">Setor</option>
                                <option value="tarik">Tarik</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="p-4 sm:p-5 border-t border-slate-100 bg-slate-50/60 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2">
                    <button type="button" id="btnBatalModal"
                        class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-600 bg-white hover:bg-slate-100 border border-slate-200 transition active:scale-[0.98] w-full sm:w-auto">
                        Batal
                    </button>
                    <button type="submit" id="btnSubmitModal"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 focus:ring-4 focus:ring-emerald-100 transition active:scale-[0.98] w-full sm:w-auto">
                        <svg id="iconLoading" class="w-4 h-4 shrink-0 animate-spin hidden" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <svg id="iconCheck" class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span id="txtBtnSubmit">Simpan Sandi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        (function() {
            function showToast(type, title, message) {
                function fireToast() {
                    if (typeof window.toast !== 'undefined' && typeof window.toast[type] === 'function') {
                        window.toast[type](title, message);
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

            const modal = document.getElementById('modalSandi');
            const form = document.getElementById('formSandi');
            const titleModal = document.getElementById('titleModal');
            const subtitleModal = document.getElementById('subtitleModal');
            const iconModal = document.getElementById('iconModal');
            const methodInput = document.getElementById('methodInput');
            const txtBtn = document.getElementById('txtBtnSubmit');
            const inputKode = document.getElementById('inputKode');
            const inputNama = document.getElementById('inputNama');
            const selectJenis = document.getElementById('selectJenis');
            const btnOpenAdd = document.getElementById('btnOpenAddSandi');
            const btnClose = document.getElementById('btnCloseModal');
            const btnBatal = document.getElementById('btnBatalModal');
            const errWrap = document.getElementById('errWrap');
            const errMsg = document.getElementById('errMsg');
            const btnSubmit = document.getElementById('btnSubmitModal');
            const iconLoading = document.getElementById('iconLoading');
            const iconCheck = document.getElementById('iconCheck');

            function openModalForAdd() {
                if (!modal) return;
                if (titleModal) titleModal.textContent = 'Tambah Sandi Transaksi';
                if (subtitleModal) subtitleModal.textContent = 'Tambahkan kode sandi transaksi baru';
                if (iconModal) iconModal.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />';
                if (form) {
                    form.action = '{{ route('sandi.store') }}';
                    form.dataset.editId = '';
                }
                if (methodInput) methodInput.value = 'POST';
                if (txtBtn) txtBtn.textContent = 'Simpan Sandi';
                if (inputKode) inputKode.value = '';
                if (inputNama) inputNama.value = '';
                if (selectJenis) selectJenis.value = 'setor';
                openModal();
            }

            function openModalForEdit(id, kode, nama, jenis) {
                if (!modal) return;
                if (titleModal) titleModal.textContent = 'Edit Sandi Transaksi';
                if (subtitleModal) subtitleModal.textContent = 'Perbarui informasi sandi transaksi';
                if (iconModal) iconModal.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />';
                if (form) {
                    form.action = '/sandi-transaksi/' + encodeURIComponent(id);
                    form.dataset.editId = id;
                }
                if (methodInput) methodInput.value = 'POST';
                if (txtBtn) txtBtn.textContent = 'Perbarui Sandi';
                if (inputKode) inputKode.value = kode || '';
                if (inputNama) inputNama.value = nama || '';
                if (selectJenis) selectJenis.value = jenis || 'setor';
                openModal();
            }

            function openModal() {
                if (!modal) return;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
                if (inputKode) {
                    setTimeout(function() {
                        inputKode.focus();
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

            document.querySelectorAll('.btn-edit-sandi').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const tr = this.closest('tr[data-sandi-id]');
                    if (!tr) return;
                    const id = tr.getAttribute('data-sandi-id');
                    const kode = tr.getAttribute('data-sandi-kode');
                    const nama = tr.getAttribute('data-sandi-nama');
                    const jenis = tr.getAttribute('data-sandi-jenis');
                    openModalForEdit(id, kode, nama, jenis);
                });
            });

            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    hideError();
                    
                    const kode = inputKode ? inputKode.value.trim() : '';
                    const nama = inputNama ? inputNama.value.trim() : '';
                    if (kode === '') {
                        showError('Kode sandi wajib diisi.');
                        if (inputKode) inputKode.focus();
                        return;
                    }
                    if (nama === '') {
                        showError('Nama sandi wajib diisi.');
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
                                if (err && typeof err === 'object' && (err.errors || err.message)) throw err;
                                throw { message: 'HTTP Error ' + res.status };
                            });
                        }
                        return res.json();
                    }).then(function(data) {
                        closeModal();
                        setLoading(false);
                        if (data && data.success) {
                            showToast('success', isEdit ? 'Sandi Diperbarui' : 'Sandi Ditambahkan',
                                data.message || (isEdit ? 'Sandi transaksi berhasil diperbarui.' : 'Sandi transaksi berhasil ditambahkan.'));
                            setTimeout(function() {
                                window.location.reload();
                            }, 400);
                        } else {
                            showToast('error', 'Gagal', data.message || 'Terjadi kesalahan saat menyimpan.');
                        }
                    }).catch(function(err) {
                        setLoading(false);
                        let msg = err && err.message ? err.message : 'Gagal menyimpan sandi transaksi. Silakan coba lagi.';
                        if (err && err.errors) {
                            if (err.errors.kode) {
                                msg = err.errors.kode[0];
                            } else if (err.errors.nama) {
                                msg = err.errors.nama[0];
                            } else if (err.errors.jenis_transaksi) {
                                msg = err.errors.jenis_transaksi[0];
                            }
                        }
                        showError(msg);
                    });
                });
            }

            const delForms = document.querySelectorAll('.form-delete-sandi');
            delForms.forEach(function(f) {
                f.addEventListener('submit', function(e) {
                    if (f.dataset.confirmed === '1') return;
                    e.preventDefault();
                    const nama = f.getAttribute('data-nama') || 'sandi ini';
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
                                ' PERINGATAN: SANDI DIGUNAKAN' +
                                '</p>' +
                                '<p>Sandi transaksi <strong>' + nama +
                                '</strong> masih digunakan oleh <strong>' + jml +
                                ' riwayat transaksi</strong>.</p>' +
                                '<p>Menghapus sandi ini akan gagal. Hapus atau pindahkan data transaksi terkait terlebih dahulu.</p>' +
                                '</div>';
                        } else {
                            html =
                                '<p class="text-sm text-slate-600 mt-1">Sandi transaksi <strong>' + nama +
                                '</strong> akan dihapus permanen dari sistem.</p>';
                        }
                        window.Swal.fire({
                            title: 'Hapus Sandi Transaksi?',
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
