<header
    class="bg-white border-b border-slate-200/80 py-3 px-4 sm:px-6 lg:px-8 flex items-center justify-between shadow-sm sticky top-0 z-30">
    <div class="flex items-center gap-3 sm:gap-4">
        <!-- Hamburger Menu Button (Mobile Only) -->
        <button onclick="toggleSidebar()"
            class="lg:hidden p-2 rounded-lg hover:bg-slate-100 text-slate-600 hover:text-slate-800 transition"
            aria-label="Toggle menu">
            <svg id="menu-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <div>
            <h1 class="text-sm sm:text-base font-bold text-slate-800 tracking-tight truncate max-w-50 sm:max-w-none">
                @yield('page_title', 'Dashboard')</h1>
        </div>
    </div>

    <div class="flex items-center gap-2 sm:gap-3">
        <!-- Live Status Pill (Identik dengan badge Emerald di Login) -->
        <span
            class="hidden sm:inline-flex px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Sistem Online
        </span>

        <!-- Notifications Icon -->
        <div class="relative" id="notif-menu-wrapper">
            <button onclick="toggleNotifMenu()" class="relative p-2 rounded-lg hover:bg-slate-100 text-slate-500 hover:text-slate-700 transition"
                aria-label="Notifications">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                @php $hasNewNotif = \App\Models\Notif::whereDate('time_notif', today())->exists(); @endphp
                @if($hasNewNotif)
                <span class="absolute top-1 right-1 w-2 h-2 bg-rose-500 rounded-full animate-pulse"></span>
                @endif
            </button>

            <!-- Dropdown Notif -->
            <div id="notif-menu"
                class="absolute right-0 mt-2 w-72 sm:w-80 bg-white rounded-xl shadow-xl border border-slate-200/80 hidden origin-top-right transition z-50">
                <div class="px-4 py-3 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 rounded-t-xl">
                    <p class="text-sm font-bold text-slate-800">Notifikasi</p>
                </div>
                <div class="max-h-80 overflow-y-auto">
                    @php 
                        $latestNotifs = \App\Models\Notif::orderBy('time_notif', 'desc')->take(5)->get();
                    @endphp
                    @forelse($latestNotifs as $notif)
                    <div class="px-4 py-3 border-b border-slate-50 hover:bg-slate-50 transition cursor-pointer">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-semibold text-slate-800 truncate">{{ $notif->message ?? 'Pembayaran Masuk' }}</p>
                                <p class="text-[10px] text-slate-500 truncate">Rp {{ number_format($notif->amount, 0, ',', '.') }} - {{ $notif->name }}</p>
                                <p class="text-[9px] text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($notif->time_notif)->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="px-4 py-6 text-center">
                        <p class="text-xs text-slate-500">Belum ada notifikasi.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- User Profile Dropdown Trigger -->
        <div class="relative" id="user-menu-wrapper">
            @php
                $roleMap = ['adm' => 'Administrator', 'opr' => 'Operator', 'nsb' => 'Nasabah'];
            @endphp
            <button onclick="toggleUserMenu()"
                class="flex items-center gap-2 sm:gap-3 p-1.5 sm:p-2 rounded-xl hover:bg-slate-100 transition group">
                <div
                    class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 flex items-center justify-center font-bold text-xs sm:text-sm">
                    @auth
                        {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                    @else
                        ?
                    @endauth
                </div>
                <div class="hidden sm:block text-left min-w-0">
                    <p class="text-xs font-bold text-slate-800 leading-tight truncate max-w-37.5">
                        @auth {{ session('nama') ?? auth()->user()->username }}
                        @else
                        Guest @endauth
                    </p>
                    <p class="text-[10px] text-slate-400 truncate max-w-37.5">
                        @auth {{ $roleMap[auth()->user()->role] ?? auth()->user()->role }}
                        @else
                            —
                        @endauth
                    </p>
                </div>
                <svg class="hidden sm:block w-4 h-4 text-slate-400 group-hover:text-slate-600 transition shrink-0"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- User Dropdown Menu -->
            <div id="user-menu"
                class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-slate-200/80 py-2 hidden origin-top-right transition z-50">
                <div class="px-4 py-3 border-b border-slate-100 sm:hidden">
                    <p class="text-sm font-bold text-slate-800 truncate">@auth
                            {{ session('nama') ?? auth()->user()->username }}
                        @else
                        Guest @endauth
                    </p>
                    <p class="text-xs text-slate-400 truncate">@auth
                            {{ $roleMap[auth()->user()->role] ?? auth()->user()->role }}
                        @else
                        — @endauth
                    </p>
                </div>
                <a href="{{ route('profile.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 text-xs text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profil Saya
                </a>
                <a href="{{ route('profile.settings') }}"
                    class="flex items-center gap-3 px-4 py-2.5 text-xs text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Pengaturan Akun
                </a>
                <div class="my-1 border-t border-slate-100"></div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-2.5 text-xs text-rose-600 hover:bg-rose-50 transition text-left">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar / Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
