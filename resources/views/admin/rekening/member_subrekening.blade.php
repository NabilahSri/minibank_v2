@extends('layouts.app')

@section('title', 'Kelola Member Sub Rekening')
@section('page_title', 'Kelola Member Sub Rekening')

@section('content')
    <div class="space-y-5 sm:space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="min-w-0">
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('rekening.subrekening', $rekening) }}"
                        class="inline-flex items-center gap-1 text-[11px] sm:text-xs font-semibold text-slate-500 hover:text-emerald-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali ke Kelola Sub Rekening
                    </a>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight truncate">
                    Member Sub Rekening
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Kelola member (anggota group pembayaran) untuk sub rekening <span
                        class="font-semibold text-slate-700">{{ $subrekening->subrekening }}</span>
                    pada rekening <span class="font-mono font-semibold text-slate-700">{{ $rekening->no_rek }}</span>
                </p>
            </div>
            <div
                class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
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
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-sm font-bold text-slate-800">Input Member Sub Rekening</h2>
                            <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5">Pilih nasabah untuk digabungkan</p>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5 space-y-4">
                        <div>
                            <label class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">Nama Nasabah</label>
                            <input type="text" value="{{ $rekening->nasabah?->nama ?? '-' }}" readonly
                                class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-100 text-slate-700">
                        </div>
                        <div>
                            <label class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">Nomor Rekening</label>
                            <input type="text" value="{{ $rekening->no_rek }}" readonly
                                class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-100 text-slate-700 font-mono">
                        </div>
                        <div>
                            <label class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">Nomor Induk Nasabah</label>
                            <input type="text" value="{{ $rekening->nasabah?->nin ?? '-' }}" readonly
                                class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-100 text-slate-700 font-mono">
                        </div>
                        <div>
                            <label class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">Kode Sub Rekening</label>
                            <input type="text" value="{{ $subrekening->kode_subrekening }}" readonly
                                class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-100 text-slate-700 font-mono">
                        </div>
                        <div>
                            <label class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">Sub Rekening</label>
                            <input type="text" value="{{ $subrekening->subrekening }}" readonly
                                class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-100 text-slate-700">
                        </div>

                        <form action="{{ route('rekening.subrekening.member.store', [$rekening, $subrekening]) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="rekening_id" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Member Nasabah <span class="text-rose-500">*</span>
                                </label>
                                <select id="rekening_id" name="rekening_id" required data-searchable="true"
                                    data-placeholder="Pilih member nasabah..."
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition cursor-pointer font-sans">
                                    <option value="">Pilih member nasabah...</option>
                                    @foreach ($availableRekenings as $option)
                                        <option value="{{ $option->id }}" {{ old('rekening_id') === $option->id ? 'selected' : '' }}>
                                            {{ $option->no_rek }} - {{ $option->nasabah?->nama ?? '-' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rekening_id')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 focus:ring-4 focus:ring-emerald-100 transition active:scale-[0.98]">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Member
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-5">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="min-w-0">
                            <h2 class="text-sm font-bold text-slate-800">Data Member Sub Rekening</h2>
                            <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5">
                                Total {{ $members->total() }} data member
                            </p>
                        </div>
                        
                        <!-- Search Form -->
                        <form action="{{ route('rekening.subrekening.member', [$rekening, $subrekening]) }}" method="GET" class="relative w-full sm:w-64">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" name="q" value="{{ $search }}"
                                placeholder="Cari nomor rekening / nama..."
                                class="w-full pl-9 pr-8 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                            @if ($search !== '')
                                <a href="{{ route('rekening.subrekening.member', [$rekening, $subrekening]) }}"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            @endif
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-[10px] sm:text-xs" style="min-width: 600px;">
                            <thead class="bg-slate-50/80 text-slate-500 uppercase tracking-wide text-[10px] sm:text-[11px] font-bold border-b border-slate-100">
                                <tr>
                                    <th class="py-3 px-4 sm:px-5 whitespace-nowrap w-14">No</th>
                                    <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Nomor Rekening</th>
                                    <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Nama</th>
                                    <th class="py-3 px-4 sm:px-5 whitespace-nowrap text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @forelse ($members as $i => $member)
                                    <tr class="hover:bg-slate-50/80 transition group">
                                        <td class="py-3 px-4 sm:px-5 text-slate-400 font-semibold whitespace-nowrap">
                                            {{ $members->firstItem() + $i }}
                                        </td>
                                        <td class="py-3 px-4 sm:px-5 whitespace-nowrap font-mono text-[10px] sm:text-xs text-slate-600">
                                            {{ $member->no_rek }}
                                        </td>
                                        <td class="py-3 px-4 sm:px-5 whitespace-nowrap font-bold text-slate-800">
                                            {{ $member->nasabah?->nama ?? '-' }}
                                        </td>
                                        <td class="py-3 px-4 sm:px-5 whitespace-nowrap text-right">
                                            <form action="{{ route('rekening.subrekening.member.destroy', [$rekening, $subrekening, $member]) }}"
                                                method="POST" class="form-delete-member inline-block"
                                                data-no-rek="{{ $member->no_rek }}"
                                                data-nama="{{ $member->nasabah?->nama ?? '-' }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Hapus Member"
                                                    class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-rose-50 text-slate-500 hover:text-rose-600 border border-slate-200 hover:border-rose-200 flex items-center justify-center transition">
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
                                        <td colspan="4" class="py-16 px-4 sm:px-5">
                                            <div class="text-center">
                                                <div class="w-16 h-16 mx-auto rounded-2xl bg-slate-50 text-slate-300 flex items-center justify-center mb-4 border border-slate-100">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </div>
                                                <h3 class="text-sm font-bold text-slate-700 mb-1">Belum ada member</h3>
                                                <p class="text-xs text-slate-500 max-w-sm mx-auto">
                                                    Silakan isi form di sebelah kiri untuk menambahkan member nasabah pertama ke dalam group pembayaran.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($members->hasPages())
                        <div class="px-4 py-3 sm:px-5 border-t border-slate-100 bg-slate-50/50">
                            {{ $members->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function() {
            function initAll() {
                const forms = document.querySelectorAll('.form-delete-member');
                forms.forEach(function(form) {
                    form.addEventListener('submit', function(e) {
                        if (form.dataset.confirmed === '1') return;
                        e.preventDefault();

                        const noRek = form.getAttribute('data-no-rek') || '';
                        const nama = form.getAttribute('data-nama') || '';

                        function doConfirm() {
                            if (typeof window.Swal === 'undefined') {
                                setTimeout(doConfirm, 150);
                                return;
                            }

                            window.Swal.fire({
                                title: 'Hapus Member?',
                                html: `<p class="text-sm text-slate-600 mt-1">Member <strong>${nama}</strong> (${noRek}) akan dihapus dari group pembayaran sub rekening ini.</p>`,
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
