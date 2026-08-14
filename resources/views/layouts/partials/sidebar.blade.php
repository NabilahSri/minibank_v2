<!-- Sidebar Overlay (Mobile Only) -->
<div id="sidebar-overlay"
    class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden hidden transition-opacity duration-300 opacity-0"
    onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside id="sidebar"
    class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-emerald-900 text-emerald-100 min-h-screen flex flex-col justify-between p-5 shrink-0 border-r border-emerald-800/60 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">

    <div
        class="absolute inset-0 opacity-10 bg-[radial-gradient(#10b981_1px,transparent_1px)] bg-size-[16px_16px] pointer-events-none">
    </div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-emerald-600/20 rounded-full blur-3xl pointer-events-none">
    </div>
    <div class="absolute top-10 right-10 w-72 h-72 bg-teal-500/10 rounded-full blur-2xl pointer-events-none"></div>

    <div class="relative z-10 flex flex-col h-full">
        <!-- Brand Logo (Konsisten dengan Login Page) -->
        <div class="flex items-center gap-3 pb-5 mb-6 border-b border-emerald-800/60">
            <div
                class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center font-bold text-emerald-300">
                YPC
            </div>
            <div>
                <h1 class="font-extrabold text-white text-base tracking-tight">MINI BANK</h1>
                <span
                    class="text-[10px] bg-emerald-500/20 text-emerald-300 font-bold px-2 py-0.5 rounded-md border border-emerald-400/30">
                    v2.0
                </span>
            </div>
        </div>

        <nav class="space-y-1.5 flex-1 overflow-y-auto pr-1">
            <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-emerald-400/60 mb-2">Utama</p>

            <a href="{{ route('dashboard.index') }}"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-xs transition duration-200 {{ request()->routeIs('dashboard*') ? 'bg-emerald-500 text-white font-semibold shadow-md shadow-emerald-500/25' : 'text-emerald-200/70 hover:bg-emerald-800/50 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Dashboard
            </a>

            @if (in_array(auth()->user()->role, ['adm', 'opr']))
                <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-emerald-400/60 pt-4 mb-2">Data Master
                </p>

                <a href="{{ route('nasabah.index') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-xs transition duration-200 {{ request()->routeIs('nasabah*') ? 'bg-emerald-500 text-white font-semibold shadow-md shadow-emerald-500/25' : 'text-emerald-200/70 hover:bg-emerald-800/50 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Nasabah
                </a>

                <a href="{{ route('rekening.index') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-xs transition duration-200 {{ request()->routeIs('rekening*') ? 'bg-emerald-500 text-white font-semibold shadow-md shadow-emerald-500/25' : 'text-emerald-200/70 hover:bg-emerald-800/50 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    Rekening
                </a>

                <!-- ADMIN ONLY ACCESS -->
                @if (auth()->user()->role === 'adm')
                    <!-- Pegawai (User Badge / ID Icon) -->
                    <a href="{{ route('pegawai.index') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-xs transition duration-200 {{ request()->routeIs('pegawai*') ? 'bg-emerald-500 text-white font-semibold shadow-md shadow-emerald-500/25' : 'text-emerald-200/70 hover:bg-emerald-800/50 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2" />
                        </svg>
                        Pegawai
                    </a>

                    <!-- Lokasi (Map Pin / Location Icon) -->
                    <a href="{{ route('lokasi.index') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-xs transition duration-200 {{ request()->routeIs('lokasi*') ? 'bg-emerald-500 text-white font-semibold shadow-md shadow-emerald-500/25' : 'text-emerald-200/70 hover:bg-emerald-800/50 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Lokasi
                    </a>
                @endif

                <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-emerald-400/60 pt-4 mb-2">Transaksi
                </p>

                <!-- Virtual Account BSI (Bank Building Icon) -->
                @if (auth()->user()->role == 'adm')
                    <a href="{{ route('tagihan.index') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-xs transition duration-200 {{ request()->routeIs('tagihan*') ? 'bg-emerald-500 text-white font-semibold shadow-md shadow-emerald-500/25' : 'text-emerald-200/70 hover:bg-emerald-800/50 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                        </svg>
                        VA Bank BSI
                    </a>
                @endif

                <!-- Setor / Tarik (Banknote / Deposit-Withdraw Icon) -->
                <a href="{{ route('transaksi.index') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-xs transition duration-200 {{ request()->routeIs('transaksi*') ? 'bg-emerald-500 text-white font-semibold shadow-md shadow-emerald-500/25' : 'text-emerald-200/70 hover:bg-emerald-800/50 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Setor / Tarik
                </a>

                <!-- Transfer (Arrows Right/Left Icon) -->
                <a href="{{ route('transfer.index') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-xs transition duration-200 {{ request()->routeIs('transfer*') ? 'bg-emerald-500 text-white font-semibold shadow-md shadow-emerald-500/25' : 'text-emerald-200/70 hover:bg-emerald-800/50 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                    Transfer
                </a>

                <!-- Auto Debet (Refresh / Schedule Icon) -->
                <a href="{{ route('autodebet.index') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-xs transition duration-200 {{ request()->routeIs('autodebet*') ? 'bg-emerald-500 text-white font-semibold shadow-md shadow-emerald-500/25' : 'text-emerald-200/70 hover:bg-emerald-800/50 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Auto Debet
                </a>
            @endif

            <!-- ADMIN ONLY CONFIGURATION PARAMETERS -->
            @if (auth()->user()->role === 'adm')
                <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-emerald-400/60 pt-4 mb-2">Parameter
                </p>

                <!-- Sandi Transaksi (Document Report Icon) -->
                <a href="{{ route('sandi.index') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-xs transition duration-200 {{ request()->routeIs('sandi*') ? 'bg-emerald-500 text-white font-semibold shadow-md shadow-emerald-500/25' : 'text-emerald-200/70 hover:bg-emerald-800/50 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Sandi Transaksi
                </a>

                <!-- Via Transaksi (Arrows / Connection Icon) -->
                <a href="{{ route('via.index') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-xs transition duration-200 {{ request()->routeIs('via*') ? 'bg-emerald-500 text-white font-semibold shadow-md shadow-emerald-500/25' : 'text-emerald-200/70 hover:bg-emerald-800/50 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                    Via Transaksi
                </a>
            @endif

            <!-- ADMIN & OPERATOR REPORTS -->
            @if (in_array(auth()->user()->role, ['adm', 'opr']))
                <p class="px-3 text-[10px] font-bold uppercase tracking-wider text-emerald-400/60 pt-4 mb-2">Laporan
                </p>

                <!-- Cetak Buku Tabungan (Printer Icon) -->
                <a href="{{ route('cetakbuku.index') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-xs transition duration-200 {{ request()->routeIs('cetakbuku*') ? 'bg-emerald-500 text-white font-semibold shadow-md shadow-emerald-500/25' : 'text-emerald-200/70 hover:bg-emerald-800/50 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Buku
                </a>

                <!-- Laporan Transaksi (Document Report Icon) -->
                <a href="{{ route('laporan.index') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-xs transition duration-200 {{ request()->routeIs('laporan*') ? 'bg-emerald-500 text-white font-semibold shadow-md shadow-emerald-500/25' : 'text-emerald-200/70 hover:bg-emerald-800/50 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Laporan Transaksi
                </a>

                <!-- Log Aktivitas (Activity/History Icon) -->
                <a href="{{ route('activity-log.index') }}"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-medium text-xs transition duration-200 {{ request()->routeIs('activity-log*') ? 'bg-emerald-500 text-white font-semibold shadow-md shadow-emerald-500/25' : 'text-emerald-200/70 hover:bg-emerald-800/50 hover:text-white' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Log Aktivitas
                </a>
            @endif

        </nav>

        <!-- User Profile Footer Sidebar -->
        <div class="pt-4 mt-auto border-t border-emerald-800/60 flex items-center justify-between px-1">
            <div class="flex items-center gap-3 min-w-0">
                <div
                    class="w-9 h-9 rounded-xl bg-emerald-800/60 border border-emerald-700/50 text-emerald-300 flex items-center justify-center font-bold text-xs shrink-0">
                    @auth
                        {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                    @else
                        ?
                    @endauth
                </div>
                <div class="text-xs min-w-0">
                    <p class="font-bold text-white leading-tight truncate">
                        @auth
                            {{ session('nama') ?? auth()->user()->username }}
                        @else
                            Guest
                        @endauth
                    </p>
                    <p class="text-[10px] text-emerald-300/60 truncate">
                        @auth
                            @php
                                $roleMap = ['adm' => 'Administrator', 'opr' => 'Operator', 'nsb' => 'Nasabah'];
                            @endphp
                            {{ $roleMap[auth()->user()->role] ?? auth()->user()->role }}
                        @else
                            —
                        @endauth
                    </p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="shrink-0">
                @csrf
                <button type="submit"
                    class="text-emerald-300/60 hover:text-rose-400 p-2 rounded-lg hover:bg-emerald-800/50 transition"
                    title="Keluar / Logout">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>
