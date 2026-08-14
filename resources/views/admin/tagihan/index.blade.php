@extends('layouts.app')

@section('title', 'Virtual Account BSI')
@section('page_title', 'Virtual Account BSI (BPI MAKA)')

@section('content')
<div class="space-y-5 sm:space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                Virtual Account BSI
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Kelola pendaftaran VA Bank Syariah Indonesia & notifikasi pembayaran otomatis
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('tagihan.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition active:scale-[0.98]">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span>Register VA Baru</span>
            </a>
        </div>
    </div>

    <!-- Main Container -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        
        <!-- Search & Filter -->
        <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <form action="{{ route('tagihan.index') }}" method="GET" class="relative flex-1 max-w-md">
                <input type="text" name="search" value="{{ $search }}"
                    placeholder="Cari nama nasabah, no invoice, atau nomor VA..."
                    class="w-full pl-10 pr-4 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </form>
            <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-bold border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    API Production BSI Active
                </span>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm min-w-[750px]">
                <thead class="bg-slate-50/80 text-slate-500 uppercase tracking-wide text-[10px] sm:text-[11px] font-bold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-4 sm:px-5 w-12 text-center">No</th>
                        <th class="py-3.5 px-4 sm:px-5">Nomor Invoice</th>
                        <th class="py-3.5 px-4 sm:px-5">Nomor VA (Rekening)</th>
                        <th class="py-3.5 px-4 sm:px-5">Nama Nasabah</th>
                        <th class="py-3.5 px-4 sm:px-5 text-right">Nominal Tagihan</th>
                        <th class="py-3.5 px-4 sm:px-5 text-center">Status VA</th>
                        <th class="py-3.5 px-4 sm:px-5 text-center">Tanggal</th>
                        <th class="py-3.5 px-4 sm:px-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse($tagihans as $index => $t)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3.5 px-4 sm:px-5 text-center text-slate-400 font-mono text-xs">
                                {{ $tagihans->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4 sm:px-5 font-mono text-xs text-slate-900 font-bold">
                                {{ $t->nomor_pembayaran }}
                            </td>
                            <td class="py-3.5 px-4 sm:px-5 font-mono text-xs text-emerald-700 font-bold">
                                {{ $t->nomor_induk }}
                            </td>
                            <td class="py-3.5 px-4 sm:px-5 font-semibold text-slate-800">
                                {{ $t->nama }}
                            </td>
                            <td class="py-3.5 px-4 sm:px-5 text-right font-bold text-slate-900">
                                @if($t->total_nilai_tagihan > 0)
                                    Rp {{ number_format($t->total_nilai_tagihan, 0, ',', '.') }}
                                @else
                                    <span class="text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded text-[11px] font-bold">Bebas Setor (Open)</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 sm:px-5 text-center">
                                @if($t->is_tagihan_aktif)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        Aktif / Registered
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        Selesai / Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 sm:px-5 text-center text-slate-500 text-xs">
                                {{ $t->tanggal ? $t->tanggal->format('d/m/Y') : '—' }}
                            </td>
                            <td class="py-3.5 px-4 sm:px-5 text-center">
                                @if($t->is_tagihan_aktif)
                                    <form action="{{ route('tagihan.cancel', $t->id) }}" method="POST" onsubmit="return confirm('Batalkan VA BSI ini?')">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1 rounded-lg text-[11px] font-bold text-rose-600 hover:bg-rose-50 border border-rose-200 transition">
                                            Batalkan VA
                                        </button>
                                    </form>
                                @else
                                    <span class="text-slate-300 text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span>Belum ada Virtual Account yang terdaftar.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tagihans->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                {{ $tagihans->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
