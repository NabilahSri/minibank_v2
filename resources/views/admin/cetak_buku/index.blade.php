@extends('layouts.app')

@section('title', 'Cetak Buku Tabungan')
@section('page_title', 'Cetak Buku Tabungan')

@section('content')
    <div class="space-y-5 sm:space-y-6">

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="min-w-0">
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight truncate">
                    Cetak Buku Tabungan
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Cari data nasabah dan cetak mutasi transaksi langsung ke buku tabungan
                </p>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm  p-4 sm:p-5">
            <form action="{{ route('cetakbuku.index') }}" method="GET"
                class="flex flex-col sm:flex-row items-stretch gap-2">
                <div class="flex-1 min-w-0">
                    <select name="rekening_id" id="select_rekening" data-searchable="true"
                        data-placeholder="Cari nama nasabah / nomor rekening..." required
                        class="w-full text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                        <option value="">Cari nama nasabah / nomor rekening...</option>
                        @foreach ($rekenings as $rek)
                            <option value="{{ $rek->id }}" {{ request('rekening_id') == $rek->id ? 'selected' : '' }}>
                                {{ $rek->nasabah?->nin ?? '—' }} | {{ $rek->nasabah?->nama ?? '—' }} (Rek:
                                {{ $rek->no_rek }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-stretch gap-2 shrink-0">
                    <button type="submit" title="Cari data"
                        class="w-10 sm:w-12 rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-md shadow-blue-600/10 flex items-center justify-center transition active:scale-[0.98] min-h-[42px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                    @if ($selectedRekening)
                        <button type="button" id="btnOpenPrintModal" title="Print Buku Tabungan"
                            class="w-10 sm:w-12 rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 shadow-md shadow-emerald-600/10 flex items-center justify-center transition active:scale-[0.98] min-h-[42px]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                        </button>
                    @endif
                </div>
            </form>
        </div>

        <!-- Transactions Listing -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100">
                <h2 class="text-sm font-bold text-slate-800">Laporan Transaksi</h2>
                @if ($selectedRekening)
                    <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5">
                        Menampilkan transaksi untuk nasabah <strong>{{ $selectedRekening->nasabah?->nama }}</strong>
                        (Rekening: {{ $selectedRekening->no_rek }})
                    </p>
                @else
                    <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5">
                        Silakan pilih nasabah untuk menampilkan daftar riwayat transaksi
                    </p>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-[10px] sm:text-xs min-w-[720px]">
                    <thead
                        class="bg-slate-50/80 text-slate-500 uppercase tracking-wide text-[10px] sm:text-[11px] font-bold border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap w-14">No</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Tanggal/Waktu</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap">Sandi</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap text-right">Debit</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap text-right">Kredit</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap text-right">Saldo</th>
                            <th class="py-3 px-4 sm:px-5 whitespace-nowrap text-center">Paraf</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse ($formattedTransactions as $tx)
                            <tr class="hover:bg-slate-50/80 transition group">
                                <td class="py-3 px-4 sm:px-5 text-slate-400 font-semibold whitespace-nowrap">
                                    {{ $tx['index'] }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap text-slate-600">
                                    {{ $tx['waktu'] ? $tx['waktu']->format('d/m/Y H:i:s') : '—' }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap font-mono font-semibold text-slate-800">
                                    {{ $tx['sandi'] }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap text-right font-medium text-rose-600">
                                    {{ $tx['debit'] ? number_format($tx['debit'], 0, ',', '.') : '-' }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap text-right font-medium text-emerald-600">
                                    {{ $tx['kredit'] ? number_format($tx['kredit'], 0, ',', '.') : '-' }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap text-right font-bold text-slate-800">
                                    {{ number_format($tx['saldo'], 0, ',', '.') }}
                                </td>
                                <td
                                    class="py-3 px-4 sm:px-5 whitespace-nowrap text-center font-mono text-[10px] text-slate-500">
                                    {{ $tx['paraf'] }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-16 text-center text-slate-400 font-medium">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span>Tidak ada riwayat transaksi ditemukan.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Print Modal -->
    @if ($selectedRekening)
        <div id="modalPrintBuku"
            class="fixed inset-0 z-[80] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div
                class="w-full max-w-md bg-white rounded-2xl shadow-2xl border border-slate-200/80 overflow-hidden transform transition-all">
                <div
                    class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between gap-3 bg-gradient-to-r from-emerald-50 to-teal-50">
                    <div class="flex items-center gap-3 min-w-0">
                        <div
                            class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-sm font-bold text-slate-800 truncate">PRINT BUKU TABUNGAN</h3>
                            <p class="text-[10px] sm:text-xs text-slate-500 mt-0.5">Konfigurasi baris cetak passbook</p>
                        </div>
                    </div>
                    <button type="button" id="btnClosePrintModal"
                        class="w-8 h-8 rounded-lg bg-white hover:bg-slate-100 text-slate-500 hover:text-slate-700 flex items-center justify-center transition border border-slate-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form id="formPrintBuku" novalidate>
                    <div class="p-4 sm:p-5 space-y-4">
                        <!-- Nama Nasabah (Read-Only) -->
                        <div>
                            <label class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                Nama Nasabah
                            </label>
                            <input type="text" disabled
                                value="{{ $selectedRekening->nasabah?->nin }} | {{ $selectedRekening->nasabah?->nama }}"
                                class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-100 text-slate-500 font-semibold cursor-not-allowed">
                        </div>

                        <!-- Dari Record (Select Dropdown) -->
                        <div>
                            <label for="selectDariRecord"
                                class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                Dari Record <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <select id="selectDariRecord" required
                                    class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition appearance-none">
                                    @forelse ($formattedTransactions as $tx)
                                        <option value="{{ $tx['index'] }}">Record {{ $tx['index'] }}
                                            ({{ $tx['waktu']->format('d/m/Y') }} - {{ $tx['sandi'] }})</option>
                                    @empty
                                        <option value="">Tidak ada record</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <!-- Lewat Baris Print (Text Input / skip count) -->
                        <div>
                            <label for="inputLewatBaris"
                                class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                Lewat Baris Print
                            </label>
                            <input type="text" id="inputLewatBaris" placeholder="Urutan Baris"
                                class="w-full px-3.5 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition placeholder:text-slate-400">
                            <p class="text-[10px] text-slate-400 mt-1">
                                Kosongkan atau tulis "Urutan Baris" untuk tanpa jeda, atau isi angka (cth: 3) untuk melewati
                                baris baris di atas.
                            </p>
                        </div>
                    </div>

                    <div
                        class="p-4 sm:p-5 border-t border-slate-100 bg-slate-50/60 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2">
                        <button type="button" id="btnBatalPrintModal"
                            class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-600 bg-white hover:bg-slate-100 border border-slate-200 transition active:scale-[0.98] w-full sm:w-auto">
                            Batal
                        </button>
                        <button type="submit" id="btnSubmitPrint"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-600/20 focus:ring-4 focus:ring-blue-100 transition active:scale-[0.98] w-full sm:w-auto">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>CETAK</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Hidden Printing Passbook Container -->
    <div id="print-passbook-container"></div>

    <style>
        /* Hidden from screen view */
        #print-passbook-container {
            display: none;
        }

        @media print {

            /* Hide all web elements */
            body,
            html,
            #sidebar,
            #sidebar-overlay,
            header,
            main,
            footer,
            div,
            aside,
            nav,
            form,
            button,
            h1,
            h2,
            h3,
            p,
            table,
            thead,
            tbody,
            tr,
            th,
            td {
                visibility: hidden !important;
                background: transparent !important;
                box-shadow: none !important;
            }

            /* Only show passbook elements */
            #print-passbook-container,
            #print-passbook-container * {
                visibility: visible !important;
            }

            #print-passbook-container {
                display: block !important;
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background: white !important;
                font-family: 'Courier New', Courier, monospace !important;
                font-size: 11px !important;
                color: black !important;
            }

            .passbook-row {
                display: block !important;
                height: 0.8cm !important;
                /* Customizable line height to fit physical passbook */
                position: relative !important;
                width: 100% !important;
                page-break-inside: avoid !important;
            }

            .passbook-row span {
                position: absolute !important;
                display: inline-block !important;
            }

            /* Column layout offsets matching passbook lines */
            .col-no {
                left: 0.5cm !important;
            }

            .col-date {
                left: 1.5cm !important;
            }

            .col-sandi {
                left: 4.2cm !important;
            }

            .col-debit {
                left: 5.5cm !important;
                text-align: right !important;
                width: 2.2cm !important;
            }

            .col-kredit {
                left: 8.2cm !important;
                text-align: right !important;
                width: 2.2cm !important;
            }

            .col-saldo {
                left: 11.0cm !important;
                text-align: right !important;
                width: 2.5cm !important;
            }

            .col-paraf {
                left: 14.2cm !important;
            }

            @page {
                size: auto;
                margin: 0mm;
            }
        }
    </style>
@endsection

@section('scripts')
    @if ($selectedRekening)
        <script>
            (function() {
                const modal = document.getElementById('modalPrintBuku');
                const btnOpen = document.getElementById('btnOpenPrintModal');
                const btnClose = document.getElementById('btnClosePrintModal');
                const btnBatal = document.getElementById('btnBatalPrintModal');
                const form = document.getElementById('formPrintBuku');

                function openModal() {
                    if (modal) {
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                        document.body.style.overflow = 'hidden';
                    }
                }

                function closeModal() {
                    if (modal) {
                        modal.classList.remove('flex');
                        modal.classList.add('hidden');
                        document.body.style.overflow = '';
                    }
                }

                if (btnOpen) btnOpen.addEventListener('click', openModal);
                if (btnClose) btnClose.addEventListener('click', closeModal);
                if (btnBatal) btnBatal.addEventListener('click', closeModal);

                // Close on escape
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                        closeModal();
                    }
                });

                // Form Submit (Cetak)
                if (form) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const dariRecord = parseInt(document.getElementById('selectDariRecord').value, 10);
                        const lewatiBarisVal = document.getElementById('inputLewatBaris').value.trim();
                        const lewatiBaris = lewatiBarisVal === '' || lewatiBarisVal.toLowerCase() ===
                            'urutan baris' ?
                            0 :
                            parseInt(lewatiBarisVal, 10);

                        // Parse transaction data passed from controller
                        const allTx = @json($formattedTransactions);

                        // Slice array to start from selected index
                        const printTx = allTx.slice(dariRecord - 1);

                        const printContainer = document.getElementById('print-passbook-container');
                        printContainer.innerHTML = '';

                        // Insert empty lines to align layout
                        for (let i = 0; i < lewatiBaris; i++) {
                            const spacer = document.createElement('div');
                            spacer.className = 'passbook-row spacer';
                            printContainer.appendChild(spacer);
                        }

                        // Render transaction rows
                        printTx.forEach(function(tx) {
                            const row = document.createElement('div');
                            row.className = 'passbook-row';

                            const debitText = tx.debit ? numberFormat(tx.debit) : '-';
                            const kreditText = tx.kredit ? numberFormat(tx.kredit) : '-';
                            const saldoText = numberFormat(tx.saldo);

                            // Format date into dd/mm/yyyy
                            const dateObj = new Date(tx.waktu);
                            const day = String(dateObj.getDate()).padStart(2, '0');
                            const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                            const year = dateObj.getFullYear();
                            const dateFormatted = `${day}/${month}/${year}`;

                            row.innerHTML = `
                                <span class="col-no">[${tx.index}]</span>
                                <span class="col-date">${dateFormatted}</span>
                                <span class="col-sandi">${tx.sandi}</span>
                                <span class="col-debit">${debitText}</span>
                                <span class="col-kredit">${kreditText}</span>
                                <span class="col-saldo">${saldoText}</span>
                                <span class="col-paraf">${tx.paraf}</span>
                            `;
                            printContainer.appendChild(row);
                        });

                        closeModal();

                        // Trigger Print
                        setTimeout(function() {
                            window.print();
                        }, 250);
                    });
                }

                function numberFormat(val) {
                    return Math.round(val).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }
            })();
        </script>
    @endif
@endsection
