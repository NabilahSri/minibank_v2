@extends('layouts.app')

@section('title', 'Transaksi Setor/Tarik Tabungan')
@section('page_title', 'Transaksi Setor/Tarik Tabungan')

@section('content')
    <div class="space-y-5 sm:space-y-6">
        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight truncate">
                    Transaksi Setor / Tarik
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Lakukan setoran tunai atau penarikan saldo nasabah secara instan.
                </p>
            </div>
            <div
                class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <!-- INPUT COLUMN -->
            <div class="lg:col-span-1 space-y-5">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm sticky top-4 z-20">
                    <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-sm font-bold text-slate-800">Input Transaksi</h2>
                            <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5">Isi data transaksi dengan teliti</p>
                        </div>
                    </div>
                    
                    <div class="p-4 sm:p-5 space-y-4">
                        <form action="{{ route('transaksi.store') }}" method="POST" class="space-y-4">
                            @csrf
                            
                            <!-- NAMA NASABAH -->
                            <div>
                                <label for="rekening_id" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Nama Nasabah <span class="text-rose-500">*</span>
                                </label>
                                <select id="rekening_id" name="rekening_id" required data-searchable="true"
                                    data-placeholder="Pilih Nasabah..."
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition cursor-pointer font-sans">
                                    <option value="">Pilih Nasabah...</option>
                                    @foreach ($rekenings as $rek)
                                        <option value="{{ $rek->id }}"
                                            {{ old('rekening_id') == $rek->id ? 'selected' : '' }}
                                            data-no-rek="{{ $rek->no_rek }}"
                                            data-nin="{{ $rek->nasabah?->nin ?? '-' }}"
                                            data-saldo="{{ $rek->saldo }}"
                                            data-nama="{{ $rek->nasabah?->nama ?? '-' }}">
                                            {{ $rek->nasabah?->nama ?? '-' }} - {{ $rek->no_rek }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rekening_id')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NOMOR REKENING -->
                            <div>
                                <label class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">Nomor Rekening</label>
                                <input type="text" id="no_rek_display" value="-" readonly
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-100 text-slate-700 font-mono">
                            </div>

                            <!-- NOMOR INDUK NASABAH -->
                            <div>
                                <label class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">Nomor Induk Nasabah</label>
                                <input type="text" id="nin_display" value="-" readonly
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-100 text-slate-700 font-mono">
                            </div>

                            <!-- SALDO -->
                            <div>
                                <label class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">Saldo</label>
                                <input type="text" id="saldo_display" value="Rp. -" readonly
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-100 text-slate-700 font-mono font-semibold">
                            </div>

                            <!-- JENIS TRANSAKSI -->
                            <div>
                                <label for="jenis_transaksi" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Jenis Transaksi <span class="text-rose-500">*</span>
                                </label>
                                <select id="jenis_transaksi" name="jenis_transaksi" required
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition cursor-pointer">
                                    <option value="setor" {{ old('jenis_transaksi') === 'setor' ? 'selected' : '' }}>Setoran</option>
                                    <option value="tarik" {{ old('jenis_transaksi') === 'tarik' ? 'selected' : '' }}>Penarikan</option>
                                </select>
                                @error('jenis_transaksi')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- PIN INPUT (Hidden for Deposit, shown for Withdrawal) -->
                            <div id="pin_container" class="hidden transition-all duration-300">
                                <label for="pin" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Masukkan PIN untuk penarikan <span class="text-rose-500">*</span>
                                </label>
                                <input type="password" id="pin" name="pin" maxlength="6" inputmode="numeric" placeholder="••••••"
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition font-mono text-center tracking-[0.5em] text-lg">
                                @error('pin')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NOMINAL -->
                            <div>
                                <label for="nominal" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Nominal <span class="text-rose-500">*</span>
                                </label>
                                <input type="hidden" name="nominal" id="nominal_value" value="{{ old('nominal') }}">
                                <input type="text" id="nominal_display"
                                    value="{{ old('nominal') ? 'Rp ' . number_format((int) old('nominal'), 0, ',', '.') : '' }}"
                                    inputmode="numeric" autocomplete="off" data-currency-target="nominal" required
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition font-mono"
                                    placeholder="Rp 100.000">
                                @error('nominal')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 focus:ring-4 focus:ring-emerald-100 transition active:scale-[0.98]">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Proses
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- TABLE COLUMN -->
            <div class="lg:col-span-2 space-y-5">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="min-w-0">
                            <h2 class="text-sm font-bold text-slate-800">Data Transaksi Setor/Tarik</h2>
                            <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5">
                                Total {{ $transaksis->total() }} data transaksi
                            </p>
                        </div>
                        
                        <!-- Search Form -->
                        <form action="{{ route('transaksi.index') }}" method="GET" class="relative w-full sm:w-64">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" name="q" value="{{ $search }}"
                                placeholder="Cari nama / nomor rekening..."
                                class="w-full pl-9 pr-8 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                            @if ($search !== '')
                                <a href="{{ route('transaksi.index') }}"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            @endif
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-[10px] sm:text-xs" style="min-width: 650px;">
                            <thead class="bg-slate-50/80 text-slate-500 uppercase tracking-wide text-[10px] sm:text-[11px] font-bold border-b border-slate-100">
                                <tr>
                                    <th class="py-3 px-4 sm:px-5 whitespace-nowrap w-14">No</th>
                                    <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Nama Nasabah</th>
                                    <th class="py-3 px-4 sm:px-5 whitespace-nowrap w-28">Jenis Transaksi</th>
                                    <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Nominal</th>
                                    <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Waktu Transaksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @forelse ($transaksis as $i => $tx)
                                    @php
                                        $isSetor = $tx->sandi?->jenis_transaksi === 'setor';
                                    @endphp
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="py-3 px-4 sm:px-5 text-slate-400 font-semibold whitespace-nowrap">
                                            {{ $transaksis->firstItem() + $i }}
                                        </td>
                                        <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                            <p class="font-bold text-slate-800">{{ $tx->rekeningAsal?->nasabah?->nama ?? '-' }}</p>
                                            <p class="text-[10px] text-slate-500 font-mono">No Rek. {{ $tx->rekeningAsal?->no_rek ?? '-' }}</p>
                                        </td>
                                        <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                            @if ($isSetor)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                    Setoran
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                    Penarikan
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 sm:px-5 whitespace-nowrap font-bold font-mono {{ $isSetor ? 'text-emerald-600' : 'text-amber-600' }}">
                                            {{ $isSetor ? '+' : '-' }} Rp {{ number_format($tx->nominal, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                            <div class="flex items-center justify-between gap-4">
                                                <div>
                                                    <p class="font-medium text-slate-700">{{ $tx->waktu->format('d M Y H:i') }}</p>
                                                    <p class="text-[10px] text-slate-400">{{ $tx->waktu->diffForHumans() }}</p>
                                                </div>
                                                <!-- Batal Transaksi Form -->
                                                <form action="{{ route('transaksi.destroy', $tx) }}" method="POST"
                                                    class="form-delete-transaksi inline-block"
                                                    data-nominal="Rp {{ number_format($tx->nominal, 0, ',', '.') }}"
                                                    data-nama="{{ $tx->rekeningAsal?->nasabah?->nama ?? '-' }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Batalkan Transaksi"
                                                        class="w-8 h-8 rounded-lg bg-slate-50 hover:bg-rose-50 text-slate-500 hover:text-rose-600 border border-slate-200 hover:border-rose-200 flex items-center justify-center transition">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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
                                                <div class="w-16 h-16 mx-auto rounded-2xl bg-slate-50 text-slate-300 flex items-center justify-center mb-4 border border-slate-100">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </div>
                                                <h3 class="text-sm font-bold text-slate-700 mb-1">Belum ada transaksi</h3>
                                                <p class="text-xs text-slate-500 max-w-sm mx-auto">
                                                    Silakan isi form di sebelah kiri untuk memproses transaksi setor / tarik pertama.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($transaksis->hasPages())
                        <div class="px-4 py-3 sm:px-5 border-t border-slate-100 bg-slate-50/50">
                            {{ $transaksis->links() }}
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
            const selectEl = document.getElementById('rekening_id');
            const jenisTransaksiEl = document.getElementById('jenis_transaksi');
            const pinContainer = document.getElementById('pin_container');
            const pinInput = document.getElementById('pin');

            function syncFields() {
                const selected = selectEl.options[selectEl.selectedIndex];
                if (selected && selected.value) {
                    document.getElementById('no_rek_display').value = selected.getAttribute('data-no-rek') || '-';
                    document.getElementById('nin_display').value = selected.getAttribute('data-nin') || '-';
                    
                    const saldo = parseFloat(selected.getAttribute('data-saldo') || '0');
                    document.getElementById('saldo_display').value = 'Rp ' + new Intl.NumberFormat('id-ID').format(saldo);
                } else {
                    document.getElementById('no_rek_display').value = '-';
                    document.getElementById('nin_display').value = '-';
                    document.getElementById('saldo_display').value = 'Rp. -';
                }
            }

            function syncPinVisibility() {
                if (jenisTransaksiEl.value === 'tarik') {
                    pinContainer.classList.remove('hidden');
                    pinInput.setAttribute('required', 'required');
                } else {
                    pinContainer.classList.add('hidden');
                    pinInput.removeAttribute('required');
                    pinInput.value = '';
                }
            }

            // SweetAlert confirmation for cancelling transactions
            function initDeleteForms() {
                const deleteForms = document.querySelectorAll('.form-delete-transaksi');
                deleteForms.forEach(function(form) {
                    form.addEventListener('submit', function(e) {
                        if (form.dataset.confirmed === '1') return;
                        e.preventDefault();

                        const nominal = form.getAttribute('data-nominal') || '';
                        const nama = form.getAttribute('data-nama') || '';

                        function doConfirm() {
                            if (typeof window.Swal === 'undefined') {
                                setTimeout(doConfirm, 150);
                                return;
                            }

                            window.Swal.fire({
                                title: 'Batalkan Transaksi?',
                                html: `<p class="text-sm text-slate-600 mt-1">Transaksi sebesar <strong>${nominal}</strong> atas nama <strong>${nama}</strong> akan dibatalkan dan dihapus permanen.</p>`,
                                icon: 'warning',
                                iconColor: '#dc2626',
                                showCancelButton: true,
                                confirmButtonText: 'Ya, Batalkan',
                                cancelButtonText: 'Tutup',
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

            selectEl.addEventListener('change', syncFields);
            jenisTransaksiEl.addEventListener('change', syncPinVisibility);

            // Run initial sync on load (to preserve old values if validation fails)
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => {
                    syncFields();
                    syncPinVisibility();
                    initDeleteForms();
                });
            } else {
                syncFields();
                syncPinVisibility();
                initDeleteForms();
            }
        })();
    </script>
@endsection
