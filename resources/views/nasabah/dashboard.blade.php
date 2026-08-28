@extends('layouts.app')

@section('title', 'Dashboard Nasabah')
@section('page_title', 'Dashboard Tabungan Saya')

@section('content')
    <div class="space-y-5 sm:space-y-6">

        <!-- 1. SALDO UTAMA CARD -->
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 via-emerald-700 to-emerald-900 p-5 sm:p-7 text-white shadow-xl shadow-emerald-700/25">
            <!-- Background Pattern -->
            <div
                class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] bg-[size:16px_16px] pointer-events-none">
            </div>
            <div class="absolute -bottom-24 -right-16 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-3 min-w-0">
                        <div
                            class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-white/15 border border-white/20 flex items-center justify-center font-bold text-white shrink-0">
                            @auth {{ strtoupper(substr(auth()->user()->username, 0, 1)) }} @endauth
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-emerald-100/70">Selamat datang kembali,</p>
                            <h3 class="font-bold text-base sm:text-lg truncate">
                                {{ session('nama') ?? (auth()->user()->username ?? 'Nasabah') }}</h3>
                        </div>
                    </div>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-500/30 border border-emerald-400/30 text-emerald-100 shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                        Aktif
                    </span>
                </div>

                <div class="space-y-1">
                    <p class="text-[11px] sm:text-xs uppercase tracking-wider text-emerald-100/60 font-semibold">Saldo
                        Tabungan</p>
                    <div class="flex items-baseline gap-2 sm:gap-3">
                        <span class="text-2xl sm:text-4xl font-black tracking-tight" id="saldoDisplay">••••••••</span>
                        <button onclick="toggleSaldo()" id="toggleSaldoBtn"
                            class="text-emerald-100/70 hover:text-white transition" title="Tampilkan/Sembunyikan saldo">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                id="iconEye">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-[10px] sm:text-xs text-emerald-100/50">No. Rekening: {{ $rekening->no_rek ?? '-' }} |
                        NIN: {{ $nasabah->nin ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- 2. STATS RINGKAS -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Setor Bulan Ini</p>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                    </div>
                </div>
                <p class="text-lg sm:text-xl font-bold text-slate-900">Rp {{ number_format($setorBulanIni, 0, ',', '.') }}
                </p>
                <span class="text-[10px] text-emerald-600 font-medium">Bulan ini</span>
            </div>
            <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Tarik Bulan Ini</p>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                    </div>
                </div>
                <p class="text-lg sm:text-xl font-bold text-slate-900">Rp {{ number_format($tarikBulanIni, 0, ',', '.') }}
                </p>
                <span class="text-[10px] text-amber-600 font-medium">Bulan ini</span>
            </div>
            <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Total Mutasi</p>
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 0-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <p class="text-lg sm:text-xl font-bold text-slate-900">{{ $totalMutasi }} Kali</p>
                <span class="text-[10px] text-slate-500 font-medium">Transaksi</span>
            </div>
        </div>

        <!-- 3. MUTASI TERAKHIR -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between gap-2">
                <div class="min-w-0">
                    <h2 class="text-sm font-bold text-slate-800 truncate">Mutasi Transaksi Terakhir</h2>
                    <p class="text-[10px] sm:text-xs text-slate-400 truncate">Riwayat setoran & penarikan terbaru</p>
                </div>
                <a href="#"
                    class="text-[10px] sm:text-xs font-semibold text-emerald-600 hover:underline whitespace-nowrap shrink-0">Lihat
                    Semua →</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse ($mutasiTerakhir as $transaksi)
                    @php
                        $isIncoming = false;
                        if ($transaksi->sandi->jenis_transaksi == 'setor') {
                            $isIncoming = true;
                        } elseif (
                            $transaksi->sandi->jenis_transaksi == 'transfer' &&
                            $transaksi->rekening_tujuan_id == ($rekening->id ?? '')
                        ) {
                            $isIncoming = true;
                        }
                    @endphp
                    <div class="p-4 sm:px-5 flex items-center gap-3 sm:gap-4 hover:bg-slate-50/80 transition">
                        <div
                            class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl {{ $isIncoming ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }} flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if ($isIncoming)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                @endif
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs sm:text-sm font-semibold text-slate-800 truncate">
                                @if ($transaksi->sandi->jenis_transaksi == 'setor')
                                    Setoran Tunai
                                @elseif($transaksi->sandi->jenis_transaksi == 'tarik')
                                    Penarikan Tunai
                                @else
                                    {{ $isIncoming ? 'Transfer Masuk' : 'Transfer Keluar' }}
                                @endif
                            </p>
                            <p class="text-[10px] sm:text-xs text-slate-400 truncate">
                                {{ $transaksi->waktu->isoFormat('dddd, D MMMM Y — HH:mm') }}
                            </p>
                        </div>
                        <div class="text-right shrink-0">
                            <p
                                class="text-xs sm:text-sm font-bold {{ $isIncoming ? 'text-emerald-600' : 'text-amber-600' }}">
                                {{ $isIncoming ? '+' : '-' }} Rp {{ number_format($transaksi->nominal, 0, ',', '.') }}
                            </p>
                            <p class="text-[9px] sm:text-[10px] text-slate-400">Berhasil</p>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-slate-400 text-xs">Belum ada mutasi transaksi</div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- MODAL OVERLAY PERMANEN -->
    <div class="fixed inset-0 z-[9999] bg-slate-900/60 backdrop-blur-md flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-3xl p-7 sm:p-9 shadow-2xl relative overflow-hidden">
            <!-- Dekorasi Background -->
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-white pointer-events-none"></div>
            
            <div class="relative z-10 text-center">
                <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-5 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
                
                <h2 class="text-2xl font-extrabold text-slate-800 mb-3 tracking-tight">Pindah ke Aplikasi Mobile</h2>
                
                <div class="text-sm text-slate-600 space-y-3 mb-7 text-left leading-relaxed">
                    <p>Mulai saat ini, seluruh aktivitas perbankan Nasabah dialihkan sepenuhnya ke <strong>Aplikasi Mobile Minibank</strong>.</p>
                    <p>Silakan unduh aplikasi kami di Google Play Store untuk dapat melanjutkan transaksi dan mengecek saldo tabungan Anda.</p>
                </div>
                
                <a href="#" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl w-full transition-all shadow-lg shadow-emerald-600/30">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.523 15.3414C17.523 17.5147 19.309 18.212 19.3374 18.225C19.3175 18.8687 18.847 19.9961 18.0645 21.1444C17.3855 22.1388 16.6666 23.1188 15.5492 23.1387C14.4507 23.1587 14.103 22.4827 12.8631 22.4827C11.6232 22.4827 11.2355 23.1188 10.1966 23.1587C9.11796 23.1975 8.2796 22.0989 7.579 21.0845C6.1416 18.9912 5.06409 15.7001 6.54133 13.1257C7.27218 11.849 8.54955 11.0253 9.94828 11.0054C11.0071 10.9854 12.0063 11.7225 12.6657 11.7225C13.3252 11.7225 14.5441 10.8256 15.823 10.9654C16.3625 10.9854 17.8812 11.1852 18.8603 12.6237C18.7804 12.6837 17.523 13.4228 17.523 15.3414ZM14.9398 8.86745C15.5393 8.14856 15.9388 7.17066 15.8291 6.17291C14.9698 6.21287 13.911 6.75121 13.2917 7.46914C12.7523 8.08726 12.2727 9.08522 12.4026 10.0631C13.3617 10.143 14.3408 9.58418 14.9398 8.86745Z"></path>
                    </svg>
                    Download di Play Store
                </a>
                
                <form action="{{ route('logout') }}" method="POST" class="mt-5 block">
                    @csrf
                    <button type="submit" class="text-xs text-slate-400 hover:text-rose-500 font-semibold underline transition-colors">Keluar dari Web</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let saldoVisible = false;
        const saldoAsli = 'Rp {{ number_format($saldo, 0, ',', '.') }}';

        function toggleSaldo() {
            saldoVisible = !saldoVisible;
            document.getElementById('saldoDisplay').textContent = saldoVisible ? saldoAsli : '••••••••';
            const icon = document.getElementById('iconEye');
            if (saldoVisible) {
                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
            } else {
                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
        }
    </script>
@endsection
