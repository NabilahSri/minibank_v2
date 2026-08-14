@extends('layouts.app')

@section('title', 'Transaksi Transfer Tabungan')
@section('page_title', 'Kelola Transfer Tabungan')

@section('content')
    <div class="space-y-5 sm:space-y-6">

        <!-- HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight truncate">
                    Transaksi Transfer Tabungan
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Proses pemindahan saldo antar rekening nasabah atau ke rekening lembaga/sekolah.
                </p>
            </div>
            <div
                class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
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
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-sm font-bold text-slate-800">Input Transaksi Transfer</h2>
                            <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5">Lengkapi data transfer tabungan</p>
                        </div>
                    </div>

                    <div class="p-4 sm:p-5 space-y-4">
                        <form action="{{ route('transfer.store') }}" method="POST" class="space-y-4">
                            @csrf

                            <!-- NAMA NASABAH SENDER -->
                            <div>
                                <label for="rekening_id" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Nama Nasabah (Pengirim) <span class="text-rose-500">*</span>
                                </label>
                                <select id="rekening_id" name="rekening_id" required
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition cursor-pointer font-sans">
                                    <option value="">Pilih Nasabah Pengirim...</option>
                                    @foreach ($rekenings as $rek)
                                        <option value="{{ $rek->id }}"
                                            {{ old('rekening_id') == $rek->id ? 'selected' : '' }}
                                            data-no-rek="{{ $rek->no_rek }}"
                                            data-nin="{{ $rek->nasabah?->nin ?? '-' }}"
                                            data-saldo="{{ $rek->saldo }}"
                                            data-tahun-masuk="{{ $rek->nasabah?->siswa?->tahun_masuk ?? '' }}">
                                            {{ $rek->nasabah?->nama ?? '-' }} - {{ $rek->no_rek }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rekening_id')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NOMOR REKENING SENDER (READONLY) -->
                            <div>
                                <label for="no_rek_display" class="block text-[11px] sm:text-xs font-bold text-slate-500 mb-1.5">
                                    Nomor Rekening
                                </label>
                                <input type="text" id="no_rek_display" readonly
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm font-semibold text-slate-500 rounded-xl border border-slate-200 bg-slate-50 cursor-not-allowed font-mono"
                                    value="-">
                            </div>

                            <!-- NOMOR INDUK NASABAH (READONLY) -->
                            <div>
                                <label for="nin_display" class="block text-[11px] sm:text-xs font-bold text-slate-500 mb-1.5">
                                    Nomor Induk Nasabah
                                </label>
                                <input type="text" id="nin_display" readonly
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm font-semibold text-slate-500 rounded-xl border border-slate-200 bg-slate-50 cursor-not-allowed font-mono"
                                    value="-">
                            </div>

                            <!-- SALDO SENDER (READONLY) -->
                            <div>
                                <label for="saldo_display" class="block text-[11px] sm:text-xs font-bold text-slate-500 mb-1.5">
                                    Saldo
                                </label>
                                <input type="text" id="saldo_display" readonly
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm font-bold text-emerald-600 rounded-xl border border-slate-200 bg-slate-50 cursor-not-allowed font-mono"
                                    value="Rp. -">
                            </div>

                            <!-- TUJUAN REKENING RECEIVER -->
                            <div>
                                <label for="rekening_tujuan_id" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Tujuan Rekening (Penerima) <span class="text-rose-500">*</span>
                                </label>
                                <select id="rekening_tujuan_id" name="rekening_tujuan_id" required
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition cursor-pointer font-sans">
                                    <option value="">Pilih Rekening Tujuan...</option>
                                    @foreach ($rekeningTujuans as $rek)
                                        <option value="{{ $rek->id }}"
                                            {{ old('rekening_tujuan_id') == $rek->id ? 'selected' : '' }}>
                                            {{ $rek->nasabah?->nama ?? '-' }} - {{ $rek->no_rek }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rekening_tujuan_id')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- SUB REKENING -->
                            <div id="subrekening_container" class="hidden">
                                <label for="subrekening_id" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Sub Rekening <span class="text-rose-500">*</span>
                                </label>
                                <select id="subrekening_id" name="subrekening_id"
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition cursor-pointer font-sans">
                                    <option value="">Pilih Sub Rekening...</option>
                                </select>
                                @error('subrekening_id')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NOMINAL SUBREKENING (READONLY) -->
                            <div id="sub_nominal_container" class="hidden">
                                <label for="sub_nominal_display" class="block text-[11px] sm:text-xs font-bold text-slate-500 mb-1.5">
                                    Nominal Ketetapan Sub Rekening
                                </label>
                                <input type="text" id="sub_nominal_display" readonly
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm font-semibold text-slate-500 rounded-xl border border-slate-200 bg-slate-50 cursor-not-allowed font-mono"
                                    value="-">
                            </div>

                            <!-- KETERANGAN -->
                            <div>
                                <label for="keterangan" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Keterangan
                                </label>
                                <textarea id="keterangan" name="keterangan" rows="2"
                                    class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition"
                                    placeholder="Contoh: Transfer Pembayaran SPP Bulanan">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NOMINAL TRANSFER INPUT -->
                            <div>
                                <label for="nominal_display" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Nominal Transfer (Rp) <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-xs sm:text-sm font-bold text-slate-400 font-mono">
                                        Rp
                                    </div>
                                    <input type="text" id="nominal_display"
                                        class="w-full pl-9 pr-3 py-2.5 text-xs sm:text-sm font-bold text-slate-800 rounded-xl border border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition font-mono"
                                        placeholder="Nominal Transfer"
                                        inputmode="numeric" autocomplete="off" data-currency-target="nominal" required>
                                </div>
                                <input type="hidden" name="nominal" id="nominal" value="{{ old('nominal') }}">
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
                            <h2 class="text-sm font-bold text-slate-800">Data Transaksi Transfer</h2>
                            <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5">
                                Total {{ $transaksis->total() }} data transaksi transfer
                            </p>
                        </div>
                        
                        <!-- Search Form -->
                        <form action="{{ route('transfer.index') }}" method="GET" class="relative w-full sm:w-64">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" name="q" value="{{ $search }}"
                                placeholder="Cari nama / nomor rekening..."
                                class="w-full pl-9 pr-8 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                            @if ($search !== '')
                                <a href="{{ route('transfer.index') }}"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            @endif
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-[10px] sm:text-xs" style="min-width: 750px;">
                            <thead class="bg-slate-50/80 text-slate-500 uppercase tracking-wide text-[10px] sm:text-[11px] font-bold border-b border-slate-100">
                                <tr>
                                    <th class="py-3 px-4 sm:px-5 whitespace-nowrap w-14">No</th>
                                    <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Nasabah Pengirim</th>
                                    <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Nasabah Penerima</th>
                                    <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Nominal</th>
                                    <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Keterangan</th>
                                    <th class="py-3 px-4 sm:px-5 whitespace-nowrap w-44">Waktu Transaksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @forelse ($transaksis as $i => $tx)
                                    <tr class="hover:bg-slate-50/80 transition group">
                                        <td class="py-3 px-4 sm:px-5 text-slate-400 font-semibold whitespace-nowrap">
                                            {{ $transaksis->firstItem() + $i }}
                                        </td>
                                        <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                            <p class="font-bold text-slate-800">{{ $tx->rekeningAsal?->nasabah?->nama ?? '-' }}</p>
                                            <p class="text-[10px] text-slate-500 font-mono">No Rek. {{ $tx->rekeningAsal?->no_rek ?? '-' }}</p>
                                        </td>
                                        <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                            <p class="font-bold text-slate-800">{{ $tx->rekeningTujuan?->nasabah?->nama ?? '-' }}</p>
                                            <p class="text-[10px] text-slate-500 font-mono">No Rek. {{ $tx->rekeningTujuan?->no_rek ?? '-' }}</p>
                                            @if ($tx->subrekening)
                                                <span class="inline-flex items-center mt-1 px-1.5 py-0.5 rounded text-[9px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                                    {{ $tx->subrekening->subrekening }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 sm:px-5 whitespace-nowrap font-bold font-mono text-emerald-600">
                                            Rp {{ number_format($tx->nominal, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3 px-4 sm:px-5 max-w-[150px] truncate" title="{{ $tx->keterangan }}">
                                            {{ $tx->keterangan ?? '-' }}
                                        </td>
                                        <td class="py-3 px-4 sm:px-5 whitespace-nowrap">
                                            <div class="flex items-center justify-between gap-4">
                                                <div>
                                                    <p class="font-medium text-slate-700">{{ $tx->waktu->format('d M Y H:i') }}</p>
                                                    <p class="text-[10px] text-slate-400">{{ $tx->waktu->diffForHumans() }}</p>
                                                </div>
                                                <!-- Batal Transaksi Form -->
                                                <form action="{{ route('transfer.destroy', $tx) }}" method="POST"
                                                    class="form-delete-transaksi inline-block"
                                                    data-nominal="Rp {{ number_format($tx->nominal, 0, ',', '.') }}"
                                                    data-nama="{{ $tx->rekeningAsal?->nasabah?->nama ?? '-' }}"
                                                    data-tujuan="{{ $tx->rekeningTujuan?->nasabah?->nama ?? '-' }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Batalkan Transfer"
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
                                        <td colspan="6" class="py-16 px-4 sm:px-5">
                                            <div class="text-center">
                                                <div class="w-16 h-16 mx-auto rounded-2xl bg-slate-50 text-slate-300 flex items-center justify-center mb-4 border border-slate-100">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                                    </svg>
                                                </div>
                                                <h3 class="text-sm font-bold text-slate-700 mb-1">Belum ada transaksi transfer</h3>
                                                <p class="text-xs text-slate-500 max-w-sm mx-auto">
                                                    Silakan isi form di sebelah kiri untuk mengirim transfer pertama.
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
            let rekeningChoice, rekeningTujuanChoice, subrekeningChoice;

            function initChoices() {
                rekeningChoice = new Choices('#rekening_id', {
                    searchEnabled: true,
                    shouldSort: false,
                    itemSelectText: '',
                    allowHTML: false,
                    placeholder: true,
                    placeholderValue: 'Pilih Nasabah Pengirim...'
                });

                rekeningTujuanChoice = new Choices('#rekening_tujuan_id', {
                    searchEnabled: true,
                    shouldSort: false,
                    itemSelectText: '',
                    allowHTML: false,
                    placeholder: true,
                    placeholderValue: 'Pilih Rekening Tujuan...'
                });

                subrekeningChoice = new Choices('#subrekening_id', {
                    searchEnabled: true,
                    shouldSort: false,
                    itemSelectText: '',
                    allowHTML: false,
                    placeholder: true,
                    placeholderValue: 'Pilih Sub Rekening...'
                });

                // Element selectors
                const selectAsalEl = document.getElementById('rekening_id');
                const rekeningTujuanEl = document.getElementById('rekening_tujuan_id');
                const subrekeningEl = document.getElementById('subrekening_id');
                const noRekDisplay = document.getElementById('no_rek_display');
                const ninDisplay = document.getElementById('nin_display');
                const saldoDisplay = document.getElementById('saldo_display');
                const subNominalDisplay = document.getElementById('sub_nominal_display');
                const nominalDisplay = document.getElementById('nominal_display');
                const subrekeningContainer = document.getElementById('subrekening_container');
                const subNominalContainer = document.getElementById('sub_nominal_container');

                const subrekeningMap = @json($subrekeningMapping);

                function syncSenderFields() {
                    const selected = selectAsalEl.options[selectAsalEl.selectedIndex];
                    if (selected && selected.value) {
                        noRekDisplay.value = selected.getAttribute('data-no-rek') || '-';
                        ninDisplay.value = selected.getAttribute('data-nin') || '-';
                        const saldo = parseFloat(selected.getAttribute('data-saldo') || '0');
                        saldoDisplay.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(saldo);
                    } else {
                        noRekDisplay.value = '-';
                        ninDisplay.value = '-';
                        saldoDisplay.value = 'Rp. -';
                    }
                }

                function syncSubrekeningVisibility() {
                    const selectedTujuanId = rekeningTujuanEl.value;
                    const subrekenings = subrekeningMap[selectedTujuanId] || [];

                    if (selectedTujuanId && subrekenings.length > 0) {
                        subrekeningContainer.classList.remove('hidden');
                        subNominalContainer.classList.remove('hidden');
                        subrekeningEl.setAttribute('required', 'required');
                    } else {
                        subrekeningContainer.classList.add('hidden');
                        subNominalContainer.classList.add('hidden');
                        subrekeningEl.removeAttribute('required');
                        
                        subrekeningChoice.clearStore();
                        subrekeningChoice.setChoices([{ value: '', label: 'Pilih Sub Rekening...', selected: true, disabled: true }], 'value', 'label', true);
                        subNominalDisplay.value = '-';
                    }
                }

                function updateSubrekeningChoices(selectedTujuanId, selectedSubId = null) {
                    const selectedAsal = selectAsalEl.options[selectAsalEl.selectedIndex];
                    const tahunMasuk = selectedAsal ? selectedAsal.getAttribute('data-tahun-masuk') : '';

                    const subrekenings = subrekeningMap[selectedTujuanId] || [];

                    // Filter subrekenings by matching tahun_masuk if set
                    const filteredSubrekenings = subrekenings.filter(sub => {
                        if (tahunMasuk) {
                            return String(sub.tahun) === String(tahunMasuk);
                        }
                        return true;
                    });

                    const choices = [
                        { value: '', label: 'Pilih Sub Rekening...', selected: !selectedSubId, disabled: true }
                    ];

                    filteredSubrekenings.forEach(sub => {
                        choices.push({
                            value: sub.value,
                            label: sub.label,
                            selected: sub.value === selectedSubId,
                            customProperties: {
                                nominal: sub.nominal
                            }
                        });
                    });

                    subrekeningChoice.clearStore();
                    subrekeningChoice.setChoices(choices, 'value', 'label', true);
                }

                function syncNominalValues() {
                    const activeChoice = subrekeningChoice.getValue();
                    if (activeChoice && activeChoice.value && activeChoice.customProperties) {
                        const fee = parseFloat(activeChoice.customProperties.nominal || '0');
                        subNominalDisplay.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(fee);
                        
                        // Automatically fill and format transfer nominal field
                        nominalDisplay.value = fee;
                        nominalDisplay.dispatchEvent(new Event('input'));
                    } else {
                        subNominalDisplay.value = '-';
                        nominalDisplay.value = '';
                        nominalDisplay.dispatchEvent(new Event('input'));
                    }
                }

                // Change Listeners
                selectAsalEl.addEventListener('change', function() {
                    syncSenderFields();
                    updateSubrekenChoicesAndPreserve();
                });

                rekeningTujuanEl.addEventListener('change', function(e) {
                    syncSubrekeningVisibility();
                    updateSubrekeningChoices(e.target.value);
                    syncNominalValues();
                });

                subrekeningEl.addEventListener('change', function() {
                    syncNominalValues();
                });

                function updateSubrekenChoicesAndPreserve() {
                    const currentTujuan = rekeningTujuanEl.value;
                    const currentSubVal = subrekeningEl.value;
                    syncSubrekeningVisibility();
                    if (currentTujuan) {
                        updateSubrekeningChoices(currentTujuan, currentSubVal);
                        syncNominalValues();
                    }
                }

                // Initial load synchronization
                syncSenderFields();
                syncSubrekeningVisibility();
                const initTujuan = '{{ old('rekening_tujuan_id') }}';
                const initSub = '{{ old('subrekening_id') }}';
                if (initTujuan) {
                    updateSubrekeningChoices(initTujuan, initSub);
                    syncNominalValues();
                }
            }

            function initDeleteForms() {
                const forms = document.querySelectorAll('.form-delete-transaksi');
                forms.forEach(function(form) {
                    form.addEventListener('submit', function(e) {
                        if (form.dataset.confirmed === '1') return;
                        e.preventDefault();

                        const nama = form.getAttribute('data-nama') || '';
                        const tujuan = form.getAttribute('data-tujuan') || '';
                        const nominal = form.getAttribute('data-nominal') || '';

                        function doConfirm() {
                            if (typeof window.Swal === 'undefined') {
                                setTimeout(doConfirm, 150);
                                return;
                            }

                            window.Swal.fire({
                                title: 'Batalkan Transfer?',
                                html: `<p class="text-sm text-slate-600 mt-1">Transaksi transfer sebesar <strong>${nominal}</strong> dari <strong>${nama}</strong> ke <strong>${tujuan}</strong> akan dibatalkan dan dihapus permanen.</p>`,
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

            function initAll() {
                initChoices();
                initDeleteForms();
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initAll);
            } else {
                initAll();
            }
        })();
    </script>
@endsection
