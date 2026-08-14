<?php

namespace App\Http\Controllers;

use App\Models\Rekening;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $rekenings = Rekening::with('nasabah')
            ->where('status', true)
            ->get()
            ->sortBy(function ($r) {
                return $r->nasabah?->nama ?? '';
            });

        // Default to today's date if not provided
        $startDate = $request->input('start_date', Carbon::today()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::today()->format('Y-m-d'));
        $rekeningId = $request->input('rekening_id');
        $search = trim($request->input('q', ''));

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        $query = Transaksi::with(['rekeningAsal.nasabah', 'rekeningTujuan.nasabah', 'sandi', 'user'])
            ->whereBetween('waktu', [$start, $end])
            ->orderBy('waktu', 'desc')
            ->orderBy('created_at', 'desc');

        if ($rekeningId && $rekeningId !== 'all') {
            $query->where(function ($q) use ($rekeningId) {
                $q->where('rekening_id', $rekeningId)
                  ->orWhere('rekening_tujuan_id', $rekeningId);
            });
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->whereHas('rekeningAsal.nasabah', function ($sq) use ($search) {
                    $sq->where('nama', 'like', "%{$search}%")
                       ->orWhere('nin', 'like', "%{$search}%");
                })->orWhereHas('rekeningAsal', function ($sq) use ($search) {
                    $sq->where('no_rek', 'like', "%{$search}%");
                })->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $transactionsRaw = $query->get();

        $selectedRekening = null;
        if ($rekeningId && $rekeningId !== 'all') {
            $selectedRekening = Rekening::with('nasabah')->find($rekeningId);
        }

        $transactions = [];
        $totalSetor = 0;
        $totalTarik = 0;
        $totalTransfer = 0;

        foreach ($transactionsRaw as $index => $tx) {
            $isSetor = $tx->sandi?->jenis_transaksi === 'setor';
            $isTarik = $tx->sandi?->jenis_transaksi === 'tarik';
            $isTransfer = $tx->sandi?->jenis_transaksi === 'transfer';

            $nominal = (float) $tx->nominal;
            $jenisStr = 'Transfer';

            if ($isSetor) {
                $totalSetor += $nominal;
                $jenisStr = 'Setoran';
            } elseif ($isTarik) {
                $totalTarik += $nominal;
                $jenisStr = 'Tarikan';
            } elseif ($isTransfer) {
                $totalTransfer += $nominal;
                $jenisStr = 'Transfer';
            }

            $namaNasabah = $tx->rekeningAsal?->nasabah?->nama ?? '—';
            $noRek = $tx->rekeningAsal?->no_rek ?? '—';

            if ($selectedRekening && $tx->rekening_tujuan_id == $selectedRekening->id && $tx->rekening_id != $selectedRekening->id) {
                $namaNasabah = ($tx->rekeningTujuan?->nasabah?->nama ?? '—') . ' (Dari: ' . ($tx->rekeningAsal?->nasabah?->nama ?? '—') . ')';
                $noRek = $tx->rekeningTujuan?->no_rek ?? '—';
            }

            $paraf = $tx->user ? substr(str_replace('-', '', $tx->user->id), -4) : '—';

            $transactions[] = [
                'index' => $index + 1,
                'nama_nasabah' => $namaNasabah,
                'no_rek' => $noRek,
                'jenis_transaksi' => $jenisStr,
                'nominal' => $nominal,
                'keterangan' => $tx->keterangan ?? '—',
                'waktu' => $tx->waktu,
                'paraf' => $paraf,
            ];
        }

        return view('admin.laporan_transaksi.index', compact(
            'rekenings',
            'selectedRekening',
            'rekeningId',
            'transactions',
            'totalSetor',
            'totalTarik',
            'totalTransfer',
            'startDate',
            'endDate',
            'search'
        ));
    }

    public function print(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::today()->format('Y-m-d'));
        $rekeningId = $request->input('rekening_id');

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        $query = Transaksi::with(['rekeningAsal.nasabah', 'rekeningTujuan.nasabah', 'sandi', 'user'])
            ->whereBetween('waktu', [$start, $end])
            ->orderBy('waktu', 'asc')
            ->orderBy('created_at', 'asc');

        if ($rekeningId && $rekeningId !== 'all') {
            $query->where(function ($q) use ($rekeningId) {
                $q->where('rekening_id', $rekeningId)
                  ->orWhere('rekening_tujuan_id', $rekeningId);
            });
        }

        $transactionsRaw = $query->get();

        $selectedRekening = null;
        if ($rekeningId && $rekeningId !== 'all') {
            $selectedRekening = Rekening::with('nasabah')->find($rekeningId);
        }

        $transactions = [];
        $totalSetor = 0;
        $totalTarik = 0;
        $totalTransfer = 0;

        foreach ($transactionsRaw as $index => $tx) {
            $isSetor = $tx->sandi?->jenis_transaksi === 'setor';
            $isTarik = $tx->sandi?->jenis_transaksi === 'tarik';
            $isTransfer = $tx->sandi?->jenis_transaksi === 'transfer';

            $nominal = (float) $tx->nominal;
            $jenisStr = 'Transfer';

            if ($isSetor) {
                $totalSetor += $nominal;
                $jenisStr = 'Setoran';
            } elseif ($isTarik) {
                $totalTarik += $nominal;
                $jenisStr = 'Tarikan';
            } elseif ($isTransfer) {
                $totalTransfer += $nominal;
                $jenisStr = 'Transfer';
            }

            $namaNasabah = $tx->rekeningAsal?->nasabah?->nama ?? '—';
            $noRek = $tx->rekeningAsal?->no_rek ?? '—';

            if ($selectedRekening && $tx->rekening_tujuan_id == $selectedRekening->id && $tx->rekening_id != $selectedRekening->id) {
                $namaNasabah = ($tx->rekeningTujuan?->nasabah?->nama ?? '—') . ' (Dari: ' . ($tx->rekeningAsal?->nasabah?->nama ?? '—') . ')';
                $noRek = $tx->rekeningTujuan?->no_rek ?? '—';
            }

            $paraf = $tx->user ? substr(str_replace('-', '', $tx->user->id), -4) : '—';

            $transactions[] = [
                'index' => $index + 1,
                'nama_nasabah' => $namaNasabah,
                'no_rek' => $noRek,
                'jenis_transaksi' => $jenisStr,
                'nominal' => $nominal,
                'keterangan' => $tx->keterangan ?? '—',
                'waktu' => $tx->waktu,
                'paraf' => $paraf,
            ];
        }

        return view('admin.laporan_transaksi.print', compact(
            'selectedRekening',
            'rekeningId',
            'transactions',
            'totalSetor',
            'totalTarik',
            'totalTransfer',
            'startDate',
            'endDate'
        ));
    }

    public function export(Request $request)
    {
        $rekeningId = $request->input('rekening_id');
        $startDate = $request->input('start_date', Carbon::today()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::today()->format('Y-m-d'));

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        $query = Transaksi::with(['rekeningAsal.nasabah', 'rekeningTujuan.nasabah', 'sandi', 'user'])
            ->whereBetween('waktu', [$start, $end])
            ->orderBy('waktu', 'asc')
            ->orderBy('created_at', 'asc');

        $selectedRekening = null;
        $filenamePrefix = 'laporan_transaksi_semua';

        if ($rekeningId && $rekeningId !== 'all') {
            $query->where(function ($q) use ($rekeningId) {
                $q->where('rekening_id', $rekeningId)
                  ->orWhere('rekening_tujuan_id', $rekeningId);
            });
            $selectedRekening = Rekening::with('nasabah')->find($rekeningId);
            if ($selectedRekening) {
                $ninSafe = preg_replace('/[^A-Za-z0-9_-]/', '_', $selectedRekening->nasabah?->nin ?? 'nasabah');
                $filenamePrefix = "laporan_transaksi_{$ninSafe}";
            }
        }

        $transactionsRaw = $query->get();

        $ts = now()->format('Ymd_His');
        $filename = "{$filenamePrefix}_{$ts}.csv";

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $sep = ';';
        $columns = [
            'No',
            'Nama Nasabah',
            'Nomor Rekening',
            'Jenis Transaksi',
            'Nominal',
            'Keterangan',
            'Waktu',
            'Paraf'
        ];

        $totalSetor = 0;
        $totalTarik = 0;
        $totalTransfer = 0;
        $rows = [];

        foreach ($transactionsRaw as $index => $tx) {
            $isSetor = $tx->sandi?->jenis_transaksi === 'setor';
            $isTarik = $tx->sandi?->jenis_transaksi === 'tarik';
            $isTransfer = $tx->sandi?->jenis_transaksi === 'transfer';
            
            $nominal = (float) $tx->nominal;
            $jenisStr = 'Transfer';
            
            if ($isSetor) {
                $totalSetor += $nominal;
                $jenisStr = 'Setoran';
            } elseif ($isTarik) {
                $totalTarik += $nominal;
                $jenisStr = 'Tarikan';
            } elseif ($isTransfer) {
                $totalTransfer += $nominal;
                $jenisStr = 'Transfer';
            }

            $namaNasabah = $tx->rekeningAsal?->nasabah?->nama ?? '—';
            $noRek = $tx->rekeningAsal?->no_rek ?? '—';

            if ($selectedRekening && $tx->rekening_tujuan_id == $selectedRekening->id && $tx->rekening_id != $selectedRekening->id) {
                $namaNasabah = ($tx->rekeningTujuan?->nasabah?->nama ?? '—') . ' (Dari: ' . ($tx->rekeningAsal?->nasabah?->nama ?? '—') . ')';
                $noRek = $tx->rekeningTujuan?->no_rek ?? '—';
            }

            $paraf = $tx->user ? substr(str_replace('-', '', $tx->user->id), -4) : '—';

            $rows[] = [
                $index + 1,
                $namaNasabah,
                $noRek,
                $jenisStr,
                $nominal,
                $tx->keterangan ?? '—',
                $tx->waktu ? $tx->waktu->format('d/m/Y H:i:s') : '—',
                $paraf
            ];
        }

        return response()->stream(function () use ($rows, $columns, $sep, $totalSetor, $totalTarik, $totalTransfer) {
            $fh = fopen('php://output', 'wb');
            fwrite($fh, "\xEF\xBB\xBF"); // UTF-8 BOM
            
            $writeRow = function (array $row) use ($fh, $sep) {
                $out = [];
                foreach ($row as $val) {
                    $v = $val === null ? '' : (string) $val;
                    if (
                        str_contains($v, '"') ||
                        str_contains($v, ',') ||
                        str_contains($v, $sep) ||
                        str_contains($v, "\n") ||
                        str_contains($v, "\r")
                    ) {
                        $v = '"' . str_replace('"', '""', $v) . '"';
                    }
                    $out[] = $v;
                }
                fwrite($fh, implode($sep, $out) . "\r\n");
            };

            // Write Header
            $writeRow($columns);

            // Write Data Rows
            foreach ($rows as $row) {
                $writeRow($row);
            }

            // Write Summaries
            $writeRow([]);
            $writeRow(['Ringkasan Laporan', '', '', '', '', '', '', '']);
            $writeRow(['Total Setoran', 'Rp ' . number_format($totalSetor, 0, ',', '.'), '', '', '', '', '', '']);
            $writeRow(['Total Tarikan', 'Rp ' . number_format($totalTarik, 0, ',', '.'), '', '', '', '', '', '']);
            $writeRow(['Total Transfer', 'Rp ' . number_format($totalTransfer, 0, ',', '.'), '', '', '', '', '', '']);

            fclose($fh);
        }, 200, $headers);
    }
}
