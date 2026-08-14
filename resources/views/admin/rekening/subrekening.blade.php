@extends('layouts.app')

@section('title', 'Kelola Sub Rekening')
@section('page_title', 'Kelola Sub Rekening')

@section('content')
    <div class="space-y-5 sm:space-y-6">
        @php
            $isEditing = isset($subrekening) && $subrekening;
        @endphp

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="min-w-0">
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('rekening.index') }}"
                        class="inline-flex items-center gap-1 text-[11px] sm:text-xs font-semibold text-slate-500 hover:text-emerald-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali ke Daftar Rekening
                    </a>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight truncate">
                    Sub Rekening
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Tambahkan dan kelola sub rekening untuk <span
                        class="font-mono font-semibold text-slate-700">{{ $rekening->no_rek }}</span>
                    atas nama {{ $rekening->nasabah?->nama ?? '-' }}
                </p>
            </div>
            <div
                class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6M9 8h6M5 4h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z" />
                </svg>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div class="lg:col-span-1 space-y-5">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm sticky top-4 z-20">
                    <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-sm font-bold text-slate-800">Input Sub Rekening</h2>
                            <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5">Data rekening sudah otomatis terisi</p>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5 space-y-4">
                        <div>
                            <label class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">Nama Nasabah</label>
                            <input type="text" value="{{ $rekening->nasabah?->nama ?? '-' }}" readonly
                                class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-100 text-slate-700">
                        </div>
                        <div>
                            <label class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">Nomor
                                Rekening</label>
                            <input type="text" value="{{ $rekening->no_rek }}" readonly
                                class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-100 text-slate-700 font-mono">
                        </div>
                        <div>
                            <label class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">Nomor Induk
                                Nasabah</label>
                            <input type="text" value="{{ $rekening->nasabah?->nin ?? '-' }}" readonly
                                class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-100 text-slate-700 font-mono">
                        </div>

                        <form
                            action="{{ $isEditing ? route('rekening.subrekening.update', [$rekening, $subrekening]) : route('rekening.subrekening.store', $rekening) }}"
                            method="POST" class="space-y-4">
                            @csrf
                            @if ($isEditing)
                                <div
                                    class="p-3 rounded-xl bg-amber-50 border border-amber-200 text-[10px] sm:text-xs text-amber-700 flex items-start gap-2">
                                    <svg class="w-4 h-4 shrink-0 mt-0.5 text-amber-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <p class="font-bold text-amber-800">Mode edit aktif</p>
                                        <p>Perubahan akan menyimpan data sub rekening yang sedang dipilih.</p>
                                    </div>
                                </div>
                            @endif
                            <div>
                                <label for="kode_subrekening"
                                    class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Kode Sub Rekening <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" id="kode_subrekening" name="kode_subrekening"
                                    value="{{ old('kode_subrekening', $subrekening?->kode_subrekening ?? '') }}"
                                    maxlength="10" required
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition font-mono"
                                    placeholder="Contoh: spp1">
                                @error('kode_subrekening')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="subrekening"
                                    class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Sub Rekening <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" id="subrekening" name="subrekening"
                                    value="{{ old('subrekening', $subrekening?->subrekening ?? '') }}" maxlength="100"
                                    required
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition"
                                    placeholder="Contoh: SPP">
                                @error('subrekening')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="tahun_pembayaran"
                                        class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                        Tahun Pembayaran <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="number" id="tahun_pembayaran" name="tahun_pembayaran"
                                        value="{{ old('tahun_pembayaran', $subrekening?->tahun_pembayaran ?? date('Y')) }}"
                                        min="2000" max="{{ date('Y') + 5 }}" required
                                        class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                                    @error('tahun_pembayaran')
                                        <p class="text-[10px] sm:text-xs text-rose-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="kategori"
                                        class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                        Kategori <span class="text-rose-500">*</span>
                                    </label>
                                    <select id="kategori" name="kategori" required data-searchable="true"
                                        data-placeholder="Cari kategori..."
                                        class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition cursor-pointer">
                                        <option value="siswa"
                                            {{ old('kategori', $subrekening?->kategori ?? $rekening->nasabah?->kategori) === 'siswa' ? 'selected' : '' }}>
                                            Siswa</option>
                                        <option value="umum"
                                            {{ old('kategori', $subrekening?->kategori ?? $rekening->nasabah?->kategori) === 'umum' ? 'selected' : '' }}>
                                            Umum</option>
                                    </select>
                                    @error('kategori')
                                        <p class="text-[10px] sm:text-xs text-rose-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="nominal"
                                    class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Nominal <span class="text-rose-500">*</span>
                                </label>
                                <input type="hidden" name="nominal" id="nominal_value" value="{{ old('nominal', $isEditing ? $subrekening->nominal : '') }}">
                                <input type="text" id="nominal_display"
                                    value="{{ old('nominal') ? 'Rp ' . number_format((int) old('nominal'), 0, ',', '.') : ($isEditing ? 'Rp ' . number_format((int) $subrekening->nominal, 0, ',', '.') : '') }}"
                                    inputmode="numeric" autocomplete="off" data-currency-target="nominal" required
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition font-mono"
                                    placeholder="Rp 170.000">
                                @error('nominal')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 focus:ring-4 focus:ring-emerald-100 transition active:scale-[0.98]">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                {{ $isEditing ? 'Update Sub Rekening' : 'Simpan Sub Rekening' }}
                            </button>
                            @if ($isEditing)
                                <a href="{{ route('rekening.subrekening', $rekening) }}"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-600 bg-slate-50 hover:bg-slate-100 border border-slate-200 transition active:scale-[0.98]">
                                    Batal Edit
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <h2 class="text-sm font-bold text-slate-800">Data Sub Rekening</h2>
                            <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5">
                                Total {{ $rekening->subrekening->count() }} data sub rekening
                            </p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-[10px] sm:text-xs" style="min-width: 860px;">
                            <thead
                                class="bg-slate-50/80 text-slate-500 uppercase tracking-wide text-[10px] sm:text-[11px] font-bold border-b border-slate-100">
                                <tr>
                                    <th class="py-3 px-4 sm:px-5 whitespace-nowrap w-14">No</th>
                                    <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Nomor Rekening</th>
                                    <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Sub Rekening</th>
                                    <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Nominal</th>
                                    <th class="py-3 px-4 sm:px-5 whitespace-nowrap text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @forelse ($rekening->subrekening as $i => $subrekening)
                                    <tr class="hover:bg-slate-50/80 transition group">
                                        <td class="py-3 px-4 sm:px-5 text-slate-400 font-semibold whitespace-nowrap">
                                            {{ $i + 1 }}</td>
                                        <td
                                            class="py-3 px-4 sm:px-5 whitespace-nowrap font-mono text-[10px] sm:text-xs text-slate-600">
                                            No Rek. {{ $rekening->no_rek }}
                                        </td>
                                        <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                            <div class="space-y-0.5">
                                                <p class="font-bold text-slate-800">Kode:
                                                    {{ $subrekening->kode_subrekening }}</p>
                                                <p class="text-slate-600">Nama Sub: {{ $subrekening->subrekening }}</p>
                                                <p class="text-slate-500">Tahun: {{ $subrekening->tahun_pembayaran }} •
                                                    {{ ucfirst($subrekening->kategori) }}</p>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 sm:px-5 whitespace-nowrap font-semibold text-slate-700">
                                            {{ number_format($subrekening->nominal, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-4 sm:px-5 whitespace-nowrap text-right">
                                            <div
                                                class="inline-flex items-center gap-1 opacity-70 group-hover:opacity-100 transition">
                                                <a href="{{ route('rekening.subrekening.edit', [$rekening, $subrekening]) }}"
                                                    class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-blue-50 text-slate-500 hover:text-blue-600 border border-slate-200 hover:border-blue-200 flex items-center justify-center transition"
                                                    title="Edit Sub Rekening">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('rekening.subrekening.member', [$rekening, $subrekening]) }}"
                                                    class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-emerald-50 text-slate-500 hover:text-emerald-600 border border-slate-200 hover:border-emerald-200 flex items-center justify-center transition"
                                                    title="Kelola Member Sub Rekening">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </a>
                                                <form
                                                    action="{{ route('rekening.subrekening.destroy', [$rekening, $subrekening]) }}"
                                                    method="POST" class="form-delete-subrekening inline-block"
                                                    data-kode="{{ $subrekening->kode_subrekening }}"
                                                    data-nama="{{ $subrekening->subrekening }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-rose-50 text-slate-500 hover:text-rose-600 border border-slate-200 hover:border-rose-200 flex items-center justify-center transition"
                                                        title="Hapus">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
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
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1.5"
                                                            d="M9 12h6m-6 4h6M9 8h6M5 4h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z" />
                                                    </svg>
                                                </div>
                                                <h3 class="text-sm font-bold text-slate-700 mb-1">Belum ada sub rekening
                                                </h3>
                                                <p class="text-xs text-slate-500 max-w-sm mx-auto">
                                                    Silakan isi form di sebelah kiri untuk menambahkan sub rekening pertama.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function() {
            function initAll() {
                const forms = document.querySelectorAll('.form-delete-subrekening');
                forms.forEach(function(form) {
                    form.addEventListener('submit', function(e) {
                        if (form.dataset.confirmed === '1') return;
                        e.preventDefault();

                        const kode = form.getAttribute('data-kode') || '';
                        const nama = form.getAttribute('data-nama') || '';

                        function doConfirm() {
                            if (typeof window.Swal === 'undefined') {
                                setTimeout(doConfirm, 150);
                                return;
                            }

                            window.Swal.fire({
                                title: 'Hapus Sub Rekening?',
                                html: `<p class="text-sm text-slate-600 mt-1">Sub rekening <strong>${nama}</strong> (${kode}) akan dihapus secara permanen dari sistem.</p>`,
                                icon: 'warning',
                                iconColor: '#dc2626',
                                showCancelButton: true,
                                confirmButtonText: 'Ya, Hapus',
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
