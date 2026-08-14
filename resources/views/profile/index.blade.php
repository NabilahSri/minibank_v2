@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page_title', 'Profil Saya')

@section('content')
    @php
        $roleMap = [
            'adm' => 'Administrator',
            'opr' => 'Operator',
            'nsb' => 'Nasabah',
        ];
    @endphp

    <div class="space-y-5 sm:space-y-6 max-w-3xl mx-auto">

        {{-- Hero Card --}}
        <div
            class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-600 via-emerald-700 to-emerald-900 p-6 sm:p-8 text-white shadow-xl shadow-emerald-700/25">
            <div
                class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] bg-[size:16px_16px] pointer-events-none">
            </div>
            <div class="absolute -bottom-20 -right-12 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col sm:flex-row items-center sm:items-start gap-5">

                <div class="text-center sm:text-left min-w-0">
                    <p class="text-emerald-200/70 text-xs font-medium mb-0.5">
                        {{ $roleMap[$user->role] ?? $user->role }}
                    </p>
                    <h2 class="text-xl sm:text-2xl font-black tracking-tight">
                        {{ $profile?->nama ?? $user->username }}
                    </h2>
                    <p class="text-emerald-200/60 text-xs mt-1">
                        Username: <span class="font-mono font-semibold text-emerald-100">{{ $user->username }}</span>
                    </p>
                    @if ($profile?->no_hp)
                        <p class="text-emerald-200/60 text-xs mt-0.5">{{ $profile->no_hp }}</p>
                    @endif
                </div>

                <div class="sm:ml-auto shrink-0">
                    <a href="{{ route('profile.settings') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold bg-white/15 hover:bg-white/25 border border-white/20 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Profil
                    </a>
                </div>
            </div>
        </div>

        {{-- Detail Info --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="px-4 py-4 border-b border-slate-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Informasi Pribadi</h3>
                    <p class="text-[11px] text-slate-400">Data terdaftar di sistem Mini Bank</p>
                </div>
            </div>

            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                @if (in_array($user->role, ['adm', 'opr']) && $profile)
                    <div>
                        <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-1">NIP</p>
                        <p class="text-sm font-semibold text-slate-800 font-mono">{{ $profile->nip ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-1">Nama Lengkap</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $profile->nama ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-1">Jenis Kelamin</p>
                        <p class="text-sm font-semibold text-slate-800">
                            {{ $profile->jk === 'L' ? 'Laki-laki' : ($profile->jk === 'P' ? 'Perempuan' : '—') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-1">No. HP</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $profile->no_hp ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-1">Email</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $profile->email ?? '—' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-1">Alamat</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $profile->alamat ?? '—' }}</p>
                    </div>
                @elseif($user->role === 'nsb' && $profile)
                    <div>
                        <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-1">NIN</p>
                        <p class="text-sm font-semibold text-slate-800 font-mono">{{ $profile->nin ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-1">Nama Lengkap</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $profile->nama ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-1">Jenis Kelamin</p>
                        <p class="text-sm font-semibold text-slate-800">
                            {{ $profile->jk === 'L' ? 'Laki-laki' : ($profile->jk === 'P' ? 'Perempuan' : '—') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-1">No. HP</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $profile->no_hp ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-1">Email</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $profile->email ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-1">Nama Orang Tua</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $profile->nama_ortu ?? '—' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-1">Alamat</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $profile->alamat ?? '—' }}</p>
                    </div>
                @else
                    <div class="sm:col-span-2 py-8 text-center text-slate-400 text-sm">
                        Data profil belum tersedia.
                    </div>
                @endif
            </div>
        </div>

        {{-- Akun Info --}}
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="px-4 py-4 border-b border-slate-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Informasi Akun</h3>
                    <p class="text-[11px] text-slate-400">Data login dan keamanan</p>
                </div>
            </div>

            <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                <div>
                    <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-1">Username</p>
                    <p class="text-sm font-semibold text-slate-800 font-mono">{{ $user->username }}</p>
                </div>
                <div>
                    <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-1">Peran Akun</p>
                    <span
                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold {{ $user->role === 'adm' ? 'bg-rose-50 text-rose-700 border border-rose-200' : ($user->role === 'opr' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200') }}">
                        {{ $roleMap[$user->role] ?? $user->role }}
                    </span>
                </div>
                <div>
                    <p class="text-[10px] uppercase font-bold tracking-wider text-slate-400 mb-1">Password</p>
                    <p class="text-sm font-semibold text-slate-500 tracking-widest">••••••••</p>
                </div>
                <div class="flex items-end">
                    <a href="{{ route('profile.settings') }}"
                        class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 hover:text-emerald-700 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Ganti Password
                    </a>
                </div>
            </div>
        </div>

    </div>
@endsection
