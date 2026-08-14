<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Rekening;
use App\Models\Tagihan;
use App\Services\BpiService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagihanController extends Controller
{
    protected BpiService $bpiService;

    public function __construct(BpiService $bpiService)
    {
        $this->bpiService = $bpiService;
    }

    /**
     * Display listing of VA Tagihan
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Tagihan::orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nomor_pembayaran', 'like', "%{$search}%")
                  ->orWhere('nomor_induk', 'like', "%{$search}%");
            });
        }

        $tagihans = $query->paginate(15)->withQueryString();

        return view('admin.tagihan.index', compact('tagihans', 'search'));
    }

    /**
     * Form Register Tagihan / VA Baru
     */
    public function create()
    {
        $rekenings = Rekening::with('nasabah')->where('status', 1)->get();
        return view('admin.tagihan.create', compact('rekenings'));
    }

    /**
     * Store & Register VA to BPI BSI Server
     */
    public function store(Request $request)
    {
        $request->validate([
            'rekening_id'          => 'required|exists:rekenings,id',
            'open_payment'         => 'nullable|boolean',
            'total_nilai_tagihan' => 'nullable|numeric|min:0',
        ]);

        $rekening = Rekening::with('nasabah')->findOrFail($request->rekening_id);
        $nasabah = $rekening->nasabah;

        $invoiceNumber = 'TAB/' . date('Ym') . '/' . Str::random(6);
        $vaNumber = $rekening->no_rek;
        $isOpenPayment = (bool) $request->input('open_payment', true);
        $amount = $isOpenPayment ? 0 : (float) $request->input('total_nilai_tagihan', 0);

        // BPI Register Payload
        $payload = [
            'number'         => $invoiceNumber,
            'va'             => $vaNumber,
            'date'           => date('Y-m-d'),
            'amount'         => $amount,
            'name'           => $nasabah->nama ?? 'Nasabah Mini Bank',
            'email'          => $nasabah->email ?? '-',
            'address'        => $nasabah->alamat ?? 'Tasikmalaya',
            'openPayment'    => $isOpenPayment,
            'sequenceNumber' => 1,
            'items'          => [
                [
                    'description' => 'Tabungan Nasabah',
                    'unitPrice'   => (int) $amount,
                    'qty'         => 1,
                    'amount'      => (int) $amount,
                ]
            ],
            'attributes'     => []
        ];

        // Call BPI API
        $bpiResult = $this->bpiService->registerVa($payload);

        $code = $bpiResult['code'] ?? '99';

        if ($code !== '00' && $code !== '08') { // 08 = Already Registered
            return back()->withInput()->with('toast_error', [
                'title'   => 'Gagal Register BPI',
                'message' => $bpiResult['message'] ?? 'Terjadi kesalahan pada server BPI BSI.',
            ]);
        }

        // Simpan ke DB Lokal
        Tagihan::create([
            'nomor_pembayaran'       => $invoiceNumber,
            'nomor_induk'            => $vaNumber,
            'nama'                   => $nasabah->nama ?? 'Nasabah Mini Bank',
            'is_tagihan_aktif'       => true,
            'tanggal'                => date('Y-m-d'),
            'total_nilai_tagihan'   => $amount,
            'pembayaran_atau_voucher' => 'PEMBAYARAN',
        ]);

        return redirect()->route('tagihan.index')->with('toast_success', [
            'title'   => 'Virtual Account Registered',
            'message' => "VA BSI ({$vaNumber}) berhasil didaftarkan ke BPI!",
        ]);
    }

    /**
     * Cancel VA Tagihan
     */
    public function cancel(Tagihan $tagihan)
    {
        $payload = [
            'va'     => $tagihan->nomor_induk,
            'number' => $tagihan->nomor_pembayaran,
        ];

        $bpiResult = $this->bpiService->cancelVa($payload);

        $tagihan->update(['is_tagihan_aktif' => false]);

        return back()->with('toast_success', [
            'title'   => 'Tagihan Dibatalkan',
            'message' => 'Status VA berhasil dinonaktifkan.',
        ]);
    }
}
