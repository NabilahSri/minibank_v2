@extends('layouts.app')

@section('title', 'Register Virtual Account BSI')
@section('page_title', 'Register VA BSI Baru')

@section('content')
    <div class="space-y-5 sm:space-y-6 ">

        <!-- Header / Breadcrumb -->
        <div class="flex items-center gap-3">
            <a href="{{ route('tagihan.index') }}"
                class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-emerald-600 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Daftar VA
            </a>
        </div>

        <!-- Card Form -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div
                class="px-5 py-4 border-b border-slate-100 flex items-center gap-3 bg-gradient-to-r from-emerald-50 to-teal-50">
                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Pendaftaran Virtual Account BSI</h3>
                    <p class="text-[11px] text-slate-400">Daftarkan nomor rekening nasabah ke sistem API BPI MAKA & Bank BSI
                    </p>
                </div>
            </div>

            <form action="{{ route('tagihan.store') }}" method="POST" class="p-5 space-y-4">
                @csrf

                <!-- Pilih Rekening / Nasabah -->
                <div>
                    <label for="rekening_id"
                        class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Pilih Nasabah & Nomor Rekening <span class="text-rose-500">*</span>
                    </label>
                    <select name="rekening_id" id="rekening_id" data-searchable="true"
                        data-placeholder="Cari nama nasabah / nomor rekening..." required
                        class="w-full text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                        <option value="">Cari nama nasabah / nomor rekening...</option>
                        @foreach ($rekenings as $rek)
                            <option value="{{ $rek->id }}" {{ old('rekening_id') == $rek->id ? 'selected' : '' }}>
                                {{ $rek->nasabah?->nin ?? '—' }} | {{ $rek->nasabah?->nama ?? '—' }} (Rek:
                                {{ $rek->no_rek }})
                            </option>
                        @endforeach
                    </select>
                    @error('rekening_id')
                        <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tipe Pembayaran / Setoran -->
                <div class="p-4 rounded-xl border border-slate-200/80 bg-slate-50/60 space-y-3">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="open_payment" value="1" id="openPaymentCheckbox" checked
                            onchange="toggleNominalInput()"
                            class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500">
                        <div>
                            <span class="text-xs font-bold text-slate-800">Open Payment (Bebas Setor Nominal)</span>
                            <p class="text-[11px] text-slate-500">Direkomendasikan untuk setoran tabungan nasabah. Nasabah
                                dapat membayar nominal berapa saja via BSI.</p>
                        </div>
                    </label>
                </div>

                <!-- Total Nilai Tagihan (Jika Fixed Payment) -->
                <div id="nominalContainer" class="hidden">
                    <label for="total_nilai_tagihan"
                        class="block text-[11px] font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nominal Tagihan Tetap (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" name="total_nilai_tagihan" id="total_nilai_tagihan"
                        value="{{ old('total_nilai_tagihan', 0) }}" min="0" step="1000"
                        class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition"
                        placeholder="Contoh: 100000">
                    @error('total_nilai_tagihan')
                        <p class="text-rose-500 text-[11px] mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                    <a href="{{ route('tagihan.index') }}"
                        class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-600 bg-white hover:bg-slate-100 border border-slate-200 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition active:scale-[0.98]">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Register VA ke Bank BSI</span>
                    </button>
                </div>
            </form>
        </div>

    </div>

    <script>
        function toggleNominalInput() {
            const checkbox = document.getElementById('openPaymentCheckbox');
            const container = document.getElementById('nominalContainer');
            if (checkbox.checked) {
                container.classList.add('hidden');
            } else {
                container.classList.remove('hidden');
            }
        }
    </script>
@endsection
