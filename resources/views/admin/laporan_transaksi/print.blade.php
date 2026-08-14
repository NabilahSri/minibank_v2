<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Transaksi - Mini Bank SMK YPC Tasikmalaya</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            line-height: 1.4;
            font-size: 11px;
        }

        /* Screen Action Bar */
        .no-print-bar {
            background-color: #1e293b;
            color: white;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .no-print-bar h2 {
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: #2563eb;
            color: white;
        }
        .btn-primary:hover {
            background-color: #1d4ed8;
        }

        .btn-secondary {
            background-color: #475569;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #334155;
        }

        /* Printable Sheet */
        .sheet {
            max-width: 210mm;
            margin: 24px auto;
            background: white;
            padding: 20mm;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }

        /* Letterhead / Kop Surat */
        .kop-surat {
            text-align: center;
            border-bottom: 3px double #0f172a;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }

        .kop-surat h1 {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: #0f172a;
        }

        .kop-surat p {
            font-size: 10px;
            color: #475569;
            margin-top: 2px;
        }

        .report-title {
            text-align: center;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0f172a;
            margin-bottom: 14px;
        }

        /* Metadata Grid */
        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 14px;
            font-size: 10.5px;
        }

        .meta-grid p {
            margin-bottom: 3px;
        }
        .meta-grid p:last-child {
            margin-bottom: 0;
        }

        .meta-label {
            color: #64748b;
            display: inline-block;
            width: 95px;
            font-weight: 500;
        }

        .meta-value {
            font-weight: 700;
            color: #0f172a;
        }

        /* Summary Stats Cards */
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-bottom: 16px;
            text-align: center;
        }

        .summary-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px 10px;
            background: #fafafa;
        }

        .summary-card .label {
            font-size: 9px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: 600;
            display: block;
            margin-bottom: 2px;
        }

        .summary-card .value {
            font-size: 12px;
            font-weight: 800;
        }

        .val-setor { color: #047857; }
        .val-tarik { color: #b91c1c; }
        .val-transfer { color: #1d4ed8; }
        .val-total { color: #0f172a; }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 20px;
        }

        th {
            background-color: #f1f5f9;
            color: #334155;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 9px;
            letter-spacing: 0.3px;
            padding: 7px 8px;
            border-top: 1.5px solid #0f172a;
            border-bottom: 1.5px solid #0f172a;
            text-align: left;
        }

        td {
            padding: 6px 8px;
            border-bottom: 1px dashed #cbd5e1;
            color: #1e293b;
        }

        tr:nth-child(even) td {
            background-color: #fafbfc;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .font-bold { font-weight: 700; }

        .badge-jenis {
            display: inline-block;
            font-weight: 700;
            font-size: 9px;
        }

        /* Signatures */
        .signature-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .sig-box {
            text-align: center;
            font-size: 10.5px;
        }

        .sig-space {
            height: 60px;
        }

        .sig-name {
            font-weight: 700;
            text-decoration: underline;
            color: #0f172a;
        }

        .sig-title {
            font-size: 9.5px;
            color: #64748b;
        }

        /* Print Media Styles */
        @media print {
            @page {
                size: A4 portrait;
                margin: 10mm 15mm;
            }

            body {
                background: white !important;
                color: #000 !important;
                font-size: 10px !important;
            }

            .no-print,
            .no-print-bar {
                display: none !important;
            }

            .sheet {
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }

            th {
                background-color: transparent !important;
                border-top: 2px solid #000 !important;
                border-bottom: 2px solid #000 !important;
                color: #000 !important;
            }

            td {
                border-bottom: 1px dashed #999 !important;
                color: #000 !important;
            }

            .meta-grid,
            .summary-card {
                background: transparent !important;
                border-color: #999 !important;
            }
        }
    </style>
</head>
<body>

    <!-- On-screen Action Toolbar -->
    <div class="no-print-bar">
        <h2>
            <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            <span>Pratinjau Cetak Laporan Mutasi Transaksi</span>
        </h2>
        <div style="display: flex; gap: 8px;">
            <button onclick="window.print()" class="btn btn-primary">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span>Cetak / Simpan PDF</span>
            </button>
            <button onclick="window.close()" class="btn btn-secondary">
                <span>Tutup</span>
            </button>
        </div>
    </div>

    <!-- Printable Paper Sheet -->
    <div class="sheet">

        <!-- Kop Surat -->
        <div class="kop-surat">
            <h1>MINI BANK SMK YPC TASIKMALAYA</h1>
            <p>Komplek SMK YPC Tasikmalaya, Jl. Raya Singaparna, Kec. Singaparna, Kab. Tasikmalaya, Jawa Barat</p>
        </div>

        <h2 class="report-title">
            Laporan Mutasi Transaksi
            @if ($selectedRekening)
                - {{ $selectedRekening->nasabah?->nama ?? 'Nasabah' }}
            @else
                - Semua Nasabah
            @endif
        </h2>

        <!-- Metadata Section -->
        <div class="meta-grid">
            <div>
                <p>
                    <span class="meta-label">Nama Nasabah</span>: 
                    <strong class="meta-value">{{ $selectedRekening ? ($selectedRekening->nasabah?->nama ?? '—') : 'Semua Nasabah' }}</strong>
                </p>
                @if ($selectedRekening)
                    <p>
                        <span class="meta-label">NIN / No. HP</span>: 
                        <span class="meta-value">{{ $selectedRekening->nasabah?->nin ?? '—' }} / {{ $selectedRekening->nasabah?->no_hp ?? '—' }}</span>
                    </p>
                    <p>
                        <span class="meta-label">No. Rekening</span>: 
                        <strong class="meta-value font-mono">{{ $selectedRekening->no_rek }}</strong>
                    </p>
                @else
                    <p>
                        <span class="meta-label">Cakupan</span>: 
                        <span class="meta-value">Semua Rekening & Nasabah</span>
                    </p>
                @endif
            </div>
            <div style="text-align: right;">
                <p>
                    <span class="meta-label">Periode</span>: 
                    <strong class="meta-value">
                        {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s.d {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                    </strong>
                </p>
                <p>
                    <span class="meta-label">Tanggal Cetak</span>: 
                    <span class="meta-value">{{ now()->format('d/m/Y H:i') }} WIB</span>
                </p>
                <p>
                    <span class="meta-label">Petugas</span>: 
                    <span class="meta-value">{{ auth()->user()->nama_pegawai ?? (auth()->user()->name ?? 'Operator') }}</span>
                </p>
            </div>
        </div>

        <!-- Summary Metric Cards -->
        <div class="summary-cards">
            <div class="summary-card">
                <span class="label">Total Setoran</span>
                <span class="value val-setor">Rp {{ number_format($totalSetor, 0, ',', '.') }}</span>
            </div>
            <div class="summary-card">
                <span class="label">Total Tarikan</span>
                <span class="value val-tarik">Rp {{ number_format($totalTarik, 0, ',', '.') }}</span>
            </div>
            <div class="summary-card">
                <span class="label">Total Transfer</span>
                <span class="value val-transfer">Rp {{ number_format($totalTransfer, 0, ',', '.') }}</span>
            </div>
            <div class="summary-card">
                <span class="label">Total Transaksi</span>
                <span class="value val-total">{{ count($transactions) }} Data</span>
            </div>
        </div>

        <!-- Transactions Table -->
        <table>
            <thead>
                <tr>
                    <th class="text-center" style="width: 25px;">No</th>
                    <th>Nama Nasabah</th>
                    <th>No. Rekening</th>
                    <th>Jenis</th>
                    <th class="text-right">Nominal</th>
                    <th>Keterangan</th>
                    <th>Waktu</th>
                    <th class="text-center" style="width: 45px;">Paraf</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $tx)
                    <tr>
                        <td class="text-center">{{ $tx['index'] }}</td>
                        <td class="font-bold">{{ $tx['nama_nasabah'] }}</td>
                        <td class="font-mono">{{ $tx['no_rek'] }}</td>
                        <td>
                            <span class="badge-jenis">{{ $tx['jenis_transaksi'] }}</span>
                        </td>
                        <td class="text-right font-bold font-mono">
                            Rp {{ number_format($tx['nominal'], 0, ',', '.') }}
                        </td>
                        <td>{{ $tx['keterangan'] }}</td>
                        <td>{{ $tx['waktu'] ? $tx['waktu']->format('d/m/Y H:i:s') : '—' }}</td>
                        <td class="text-center font-mono" style="font-size: 9px;">{{ $tx['paraf'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center" style="padding: 24px; color: #64748b;">
                            Tidak ada transaksi pada periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Signatures Section -->
        <div class="signature-section">
            <div class="sig-box">
                <p>Mengetahui,</p>
                <p class="sig-title">Kepala Mini Bank SMK YPC</p>
                <div class="sig-space"></div>
                <p class="sig-name">( ........................................ )</p>
                <p class="sig-title">NIP. -</p>
            </div>
            <div class="sig-box">
                <p>Tasikmalaya, {{ now()->translatedFormat('d F Y') }}</p>
                <p class="sig-title">Petugas / Teller</p>
                <div class="sig-space"></div>
                <p class="sig-name">( {{ auth()->user()->nama_pegawai ?? (auth()->user()->name ?? 'Operator') }} )</p>
                <p class="sig-title">Petugas Operasional</p>
            </div>
        </div>

    </div>

    <script>
        // Trigger print dialog automatically after page loads
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.print();
            }, 300);
        });
    </script>
</body>
</html>
