@extends('layouts.app')

@section('title', 'Edit Data Pegawai')
@section('page_title', 'Edit Data Pegawai')

@section('content')
    <div class="space-y-5 sm:space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="min-w-0">
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('pegawai.index') }}"
                        class="inline-flex items-center gap-1 text-[11px] sm:text-xs font-semibold text-slate-500 hover:text-emerald-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali ke Daftar Pegawai
                    </a>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight truncate">
                    Edit Data Pegawai
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Perbarui informasi pegawai <span class="font-semibold text-slate-700">{{ $pegawai->nama }}</span>
                </p>
            </div>
            <div
                class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100">
                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
        </div>

        <form id="formEditPegawai" action="{{ route('pegawai.update', $pegawai) }}" method="POST" novalidate>
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

                <div class="lg:col-span-2 space-y-5">
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-visible">
                        <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h2 class="text-sm font-bold text-slate-800">Data Diri Pegawai</h2>
                                <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5">Informasi pribadi pegawai</p>
                            </div>
                        </div>
                        <div class="p-4 sm:p-5 grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">

                            <div class="sm:col-span-1">
                                <label for="nip" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    NIP <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none shrink-0"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0" />
                                    </svg>
                                    <input type="text" id="nip" name="nip"
                                        value="{{ old('nip', $pegawai->nip) }}" maxlength="20" required
                                        class="w-full pl-9 pr-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition font-mono placeholder:text-slate-400"
                                        placeholder="cth: 2026001">
                                </div>
                                @error('nip')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="sm:col-span-1">
                                <label for="lokasi_id"
                                    class="text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5 flex items-center justify-between gap-2">
                                    <span>Lokasi Kerja <span class="text-rose-500">*</span></span>
                                    <button type="button" id="btnQuickAddLokasiEdit"
                                        class="inline-flex items-center gap-1 text-[10px] sm:text-[11px] font-bold text-emerald-600 hover:text-emerald-700 transition">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                        Tambah Lokasi
                                    </button>
                                </label>
                                <select id="lokasi_id" name="lokasi_id" required data-searchable="true"
                                    data-placeholder="Cari lokasi..."
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition cursor-pointer">
                                    <option value="">-- Pilih Lokasi --</option>
                                    @foreach ($lokasis as $l)
                                        <option value="{{ $l->id }}"
                                            {{ old('lokasi_id', $pegawai->lokasi_id) === $l->id ? 'selected' : '' }}>
                                            {{ $l->nama_lokasi }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('lokasi_id')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="nama" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Nama Lengkap <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" id="nama" name="nama"
                                    value="{{ old('nama', $pegawai->nama) }}" maxlength="100" required
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition placeholder:text-slate-400"
                                    placeholder="cth: Siti Nurhaliza, S.Pd">
                                @error('nama')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="sm:col-span-1">
                                <label class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Jenis Kelamin <span class="text-rose-500">*</span>
                                </label>
                                <div class="grid grid-cols-2 gap-2 sm:gap-3">
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="jk" value="L"
                                            {{ old('jk', $pegawai->jk) === 'L' ? 'checked' : '' }} required
                                            class="peer sr-only">
                                        <div
                                            class="px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-xs sm:text-sm font-semibold text-slate-600 text-center transition peer-checked:bg-emerald-50 peer-checked:border-emerald-400 peer-checked:text-emerald-700 peer-hover:bg-slate-50">
                                            <span class="inline-flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                Laki-laki
                                            </span>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="jk" value="P"
                                            {{ old('jk', $pegawai->jk) === 'P' ? 'checked' : '' }} class="peer sr-only">
                                        <div
                                            class="px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50/50 text-xs sm:text-sm font-semibold text-slate-600 text-center transition peer-checked:bg-pink-50 peer-checked:border-pink-400 peer-checked:text-pink-700 peer-hover:bg-slate-50">
                                            <span class="inline-flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                Perempuan
                                            </span>
                                        </div>
                                    </label>
                                </div>
                                @error('jk')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1.5 flex items-center gap-1">
                                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="sm:col-span-1">
                                <label for="role"
                                    class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Role Akses <span class="text-rose-500">*</span>
                                </label>
                                <select id="role" name="role" required data-searchable="true"
                                    data-placeholder="Pilih role..."
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition cursor-pointer">
                                    <option value="">-- Pilih Role --</option>
                                    <option value="opr"
                                        {{ old('role', $pegawai->user?->role) === 'opr' ? 'selected' : '' }}>Operator
                                        (Petugas Layanan)</option>
                                    <option value="adm"
                                        {{ old('role', $pegawai->user?->role) === 'adm' ? 'selected' : '' }}>
                                        Administrator (Full Akses)</option>
                                </select>
                                @error('role')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="sm:col-span-1">
                                <label for="no_hp"
                                    class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    No. Handphone
                                </label>
                                <div class="relative">
                                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none shrink-0"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <input type="tel" id="no_hp" name="no_hp"
                                        value="{{ old('no_hp', $pegawai->no_hp) }}" maxlength="20"
                                        class="w-full pl-9 pr-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition placeholder:text-slate-400"
                                        placeholder="cth: 081234567890">
                                </div>
                                @error('no_hp')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="sm:col-span-1">
                                <label for="email"
                                    class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Alamat Email
                                </label>
                                <div class="relative">
                                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none shrink-0"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <input type="email" id="email" name="email"
                                        value="{{ old('email', $pegawai->email) }}" maxlength="100"
                                        class="w-full pl-9 pr-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition placeholder:text-slate-400"
                                        placeholder="cth: pegawai@sekolah.sch.id">
                                </div>
                                @error('email')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="alamat"
                                    class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Alamat Lengkap
                                </label>
                                <textarea id="alamat" name="alamat" rows="2" maxlength="255"
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition placeholder:text-slate-400 resize-none"
                                    placeholder="cth: Jl. Pendidikan No. 123, Surabaya">{{ old('alamat', $pegawai->alamat) }}</textarea>
                                @error('alamat')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-purple-200/60 shadow-sm overflow-hidden">
                        <div class="p-4 sm:p-5 border-b border-purple-100 bg-purple-50/60 flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h2 class="text-sm font-bold text-purple-800">Akun Login</h2>
                                <p class="text-[10px] sm:text-xs text-purple-600/70 mt-0.5">Kredensial akses sistem
                                </p>
                            </div>
                            <span
                                class="ml-auto inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-purple-100 text-purple-700 text-[10px] font-bold border border-purple-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                KOSONGKAN JIKA TIDAK DIUBAH
                            </span>
                        </div>
                        <div class="p-4 sm:p-5 grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            <div class="sm:col-span-1">
                                <label for="username"
                                    class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Username <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none shrink-0"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <input type="text" id="username" name="username"
                                        value="{{ old('username', $pegawai->user?->username) }}" maxlength="50" required
                                        class="w-full pl-9 pr-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition placeholder:text-slate-400"
                                        placeholder="cth: sitinurhaliza">
                                </div>
                                @error('username')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="sm:col-span-1">
                                <label for="password"
                                    class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Password
                                    <span class="font-normal text-slate-400">(opsional, min. 6 karakter)</span>
                                </label>
                                <div class="relative">
                                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none shrink-0"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    <input type="password" id="password" name="password" maxlength="100"
                                        class="w-full pl-9 pr-10 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition placeholder:text-slate-400"
                                        placeholder="Kosongkan bila password tidak diubah">
                                    <button type="button" id="togglePw" title="Tampilkan/sembunyikan password"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 w-7 h-7 rounded-lg bg-slate-100 hover:bg-emerald-100 text-slate-500 hover:text-emerald-600 flex items-center justify-center transition">
                                        <svg id="iconEyePw" class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>

                <div class="lg:col-span-1 space-y-5">
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden sticky top-4">
                        <div class="p-4 sm:p-5 border-b border-slate-100">
                            <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                Ringkasan & Aksi
                            </h2>
                        </div>
                        <div class="p-4 sm:p-5 space-y-4">
                            <div class="space-y-2.5">
                                <div class="flex items-center justify-between text-[11px] sm:text-xs">
                                    <span class="text-slate-500 font-medium">Progress Pengisian</span>
                                    <span class="font-bold text-slate-800">Data diperbarui</span>
                                </div>
                                <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                                    <div id="progressBar"
                                        class="h-full bg-linear-to-r from-blue-400 to-blue-600 w-0 transition-all duration-300 ease-out">
                                    </div>
                                </div>
                                <p id="progressText"
                                    class="text-[10px] sm:text-[11px] text-slate-400 text-right font-semibold">
                                    0% terisi
                                </p>
                            </div>
                            <div class="pt-2 border-t border-slate-100 space-y-2.5">
                                <button type="submit" id="btnSubmitEdit"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-600/20 focus:ring-4 focus:ring-blue-100 transition active:scale-[0.98]">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Simpan Perubahan
                                </button>
                                <a href="{{ route('pegawai.index') }}"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-600 bg-slate-50 hover:bg-slate-100 border border-slate-200 transition active:scale-[0.98]">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Batal
                                </a>
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-4 rounded-2xl bg-amber-50 border border-amber-200/60 text-[10px] sm:text-xs text-amber-700 space-y-1.5">
                        <p class="font-bold text-amber-800 flex items-center gap-1.5">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Catatan Penting
                        </p>
                        <ul class="space-y-1 list-disc list-inside text-amber-700/90">
                            <li>Password boleh dikosongkan = password tidak diubah</li>
                            <li>NIP & Username harus tetap unik antar pegawai</li>
                            <li>Perubahan role akan berdampak pada akses menu pegawai</li>
                            <li>Perubahan data langsung tersimpan setelah dikonfirmasi</li>
                        </ul>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <div id="modalQuickAddLokasiEdit"
        class="fixed inset-0 z-80 hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div
            class="w-full max-w-md bg-white rounded-2xl shadow-2xl border border-slate-200/80 overflow-hidden transform transition-all">
            <div
                class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between gap-3 bg-linear-to-r from-emerald-50 to-teal-50">
                <div class="flex items-center gap-3 min-w-0">
                    <div
                        class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-sm font-bold text-slate-800 truncate">Tambah Lokasi Baru</h3>
                        <p class="text-[10px] sm:text-xs text-slate-500 mt-0.5">Tambahkan lokasi kerja baru dengan
                            cepat</p>
                    </div>
                </div>
                <button type="button" id="btnCloseModalLokasiEdit"
                    class="w-8 h-8 rounded-lg bg-white hover:bg-slate-100 text-slate-500 hover:text-slate-700 flex items-center justify-center transition border border-slate-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="formQuickAddLokasiEdit" action="{{ route('lokasi.store') }}" method="POST" novalidate>
                @csrf
                <input type="hidden" name="ajax" value="1">
                <div class="p-4 sm:p-5 space-y-4">
                    <div>
                        <label for="quick_nama_lokasi_edit"
                            class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                            Nama Lokasi <span class="text-rose-500">*</span>
                            <span class="font-normal text-slate-400">(misal: Kantor Pusat, Cabang Surabaya)</span>
                        </label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none shrink-0"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <input type="text" id="quick_nama_lokasi_edit" name="nama_lokasi" maxlength="100"
                                required autofocus
                                class="w-full pl-9 pr-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition placeholder:text-slate-400"
                                placeholder="cth: Kantor Cabang Surabaya">
                        </div>
                        <div id="quick_lokasi_error_edit" class="hidden text-[10px] sm:text-xs text-rose-600 mt-1.5">
                            <span class="inline-flex items-center gap-1">
                                <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div
                    class="p-4 sm:p-5 border-t border-slate-100 bg-slate-50/60 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2">
                    <button type="button" id="btnBatalLokasiEdit"
                        class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-600 bg-white hover:bg-slate-100 border border-slate-200 transition active:scale-[0.98]">
                        Batal
                    </button>
                    <button type="submit" id="btnSubmitLokasiEdit"
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 focus:ring-4 focus:ring-emerald-100 transition active:scale-[0.98]">
                        <svg id="iconLoadingLokasiEdit" class="w-4 h-4 shrink-0 animate-spin hidden" viewBox="0 0 24 24"
                            fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <svg id="iconCheckLokasiEdit" class="w-4 h-4 shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span id="txtBtnLokasiEdit">Simpan Lokasi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function() {
            function togglePwVisibility(inputId, iconId, btn) {
                const inp = document.getElementById(inputId);
                const ic = document.getElementById(iconId);
                if (!inp || !ic) return;
                btn.addEventListener('click', function() {
                    const isPw = inp.type === 'password';
                    inp.type = isPw ? 'text' : 'password';
                    ic.innerHTML = isPw ?
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />' :
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
                });
            }

            function updateProgress() {
                const bar = document.getElementById('progressBar');
                const txt = document.getElementById('progressText');
                const fields = document.querySelectorAll(
                    '#formEditPegawai input[required], #formEditPegawai select[required], #formEditPegawai textarea[required]'
                );
                const total = fields.length;
                if (!bar || !txt) return;
                let filled = 0;
                let radioChecked = {};
                fields.forEach(function(f) {
                    if (f.type === 'radio') {
                        if (!radioChecked[f.name]) {
                            if (document.querySelector('input[name="' + f.name + '"]:checked')) {
                                radioChecked[f.name] = true;
                                filled++;
                            }
                        }
                    } else if (f.value && String(f.value).trim() !== '') {
                        filled++;
                    }
                });
                const pct = total > 0 ? Math.round((Math.min(filled, total) / total) * 100) : 0;
                bar.style.width = pct + '%';
                txt.textContent = pct + '% terisi';
            }

            function initQuickAddLokasi() {
                const modal = document.getElementById('modalQuickAddLokasiEdit');
                const btnOpen = document.getElementById('btnQuickAddLokasiEdit');
                const btnClose = document.getElementById('btnCloseModalLokasiEdit');
                const btnBatal = document.getElementById('btnBatalLokasiEdit');
                const form = document.getElementById('formQuickAddLokasiEdit');
                const input = document.getElementById('quick_nama_lokasi_edit');
                const errWrap = document.getElementById('quick_lokasi_error_edit');
                const errMsg = errWrap ? errWrap.querySelector('span') : null;
                const btnSubmit = document.getElementById('btnSubmitLokasiEdit');
                const iconLoading = document.getElementById('iconLoadingLokasiEdit');
                const iconCheck = document.getElementById('iconCheckLokasiEdit');
                const txtBtn = document.getElementById('txtBtnLokasiEdit');
                const selectLokasi = document.getElementById('lokasi_id');

                function openModal() {
                    if (!modal) return;
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    document.body.style.overflow = 'hidden';
                    if (input) {
                        input.value = '';
                        setTimeout(function() {
                            input.focus();
                        }, 80);
                    }
                    hideError();
                }

                function closeModal() {
                    if (!modal) return;
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.body.style.overflow = '';
                    hideError();
                }

                function showError(msg) {
                    if (errWrap) errWrap.classList.remove('hidden');
                    if (errMsg) errMsg.textContent = msg;
                }

                function hideError() {
                    if (errWrap) errWrap.classList.add('hidden');
                    if (errMsg) errMsg.textContent = '';
                }

                function setLoading(loading) {
                    if (!btnSubmit) return;
                    btnSubmit.disabled = loading;
                    if (loading) {
                        if (iconLoading) iconLoading.classList.remove('hidden');
                        if (iconCheck) iconCheck.classList.add('hidden');
                        if (txtBtn) txtBtn.textContent = 'Menyimpan...';
                        btnSubmit.classList.add('opacity-70', 'cursor-not-allowed');
                    } else {
                        if (iconLoading) iconLoading.classList.add('hidden');
                        if (iconCheck) iconCheck.classList.remove('hidden');
                        if (txtBtn) txtBtn.textContent = 'Simpan Lokasi';
                        btnSubmit.classList.remove('opacity-70', 'cursor-not-allowed');
                    }
                }

                function showToast(type, title, message) {
                    function fireToast() {
                        if (typeof window.toast !== 'undefined' && typeof window.showToast === 'function') {
                            window.showToast(type, title, message);
                            return;
                        }
                        if (typeof window.Swal !== 'undefined') {
                            const cfg = {
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2500,
                                timerProgressBar: true,
                                title: title,
                                text: message,
                                didOpen: function(toast) {
                                    toast.addEventListener('mouseenter', window.Swal.stopTimer);
                                    toast.addEventListener('mouseleave', window.Swal.resumeTimer);
                                }
                            };
                            if (type === 'success') cfg.icon = 'success';
                            else if (type === 'error') cfg.icon = 'error';
                            else if (type === 'warning') cfg.icon = 'warning';
                            else cfg.icon = 'info';
                            window.Swal.fire(cfg);
                            return;
                        }
                        setTimeout(fireToast, 150);
                    }
                    fireToast();
                }

                if (btnOpen) btnOpen.addEventListener('click', openModal);
                if (btnClose) btnClose.addEventListener('click', closeModal);
                if (btnBatal) btnBatal.addEventListener('click', closeModal);
                if (modal) {
                    modal.addEventListener('click', function(e) {
                        if (e.target === modal) closeModal();
                    });
                }
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                        closeModal();
                    }
                });

                if (form) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        hideError();
                        const nama = input ? input.value.trim() : '';
                        if (nama === '') {
                            showError('Nama lokasi wajib diisi.');
                            if (input) input.focus();
                            return;
                        }
                        if (nama.length > 100) {
                            showError('Nama lokasi maksimal 100 karakter.');
                            if (input) input.focus();
                            return;
                        }
                        setLoading(true);
                        const fd = new FormData(form);
                        fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: fd
                        }).then(function(res) {
                            if (!res.ok) {
                                return res.json().then(function(data) {
                                    throw data;
                                }).catch(function(err) {
                                    if (err && typeof err === 'object' && (err.errors || err
                                            .message)) throw err;
                                    throw {
                                        message: 'HTTP Error ' + res.status
                                    };
                                });
                            }
                            return res.json();
                        }).then(function(data) {
                            if (data && data.success && selectLokasi) {
                                const opt = document.createElement('option');
                                opt.value = data.id;
                                opt.textContent = data.nama;
                                opt.selected = true;
                                selectLokasi.insertBefore(opt, selectLokasi.firstChild.nextSibling);
                                selectLokasi.value = data.id;
                                selectLokasi.dispatchEvent(new Event('change', {
                                    bubbles: true
                                }));
                            }
                            closeModal();
                            setLoading(false);
                            showToast('success', data && data.title ? data.title : 'Berhasil', data &&
                                data.message ?
                                data.message : 'Lokasi berhasil ditambahkan.');
                        }).catch(function(err) {
                            setLoading(false);
                            let msg = err && err.message ? err.message :
                                'Gagal menyimpan lokasi. Silakan coba lagi.';
                            if (err && err.errors && err.errors.nama_lokasi && Array.isArray(err.errors
                                    .nama_lokasi)) {
                                msg = err.errors.nama_lokasi[0];
                            } else if (err && err.errors && err.errors.nama_lokasi) {
                                msg = err.errors.nama_lokasi;
                            }
                            showError(msg);
                        });
                    });
                }
            }

            function initAll() {
                togglePwVisibility('password', 'iconEyePw', document.getElementById('togglePw'));
                initQuickAddLokasi();

                const all = document.querySelectorAll(
                    '#formEditPegawai input, #formEditPegawai select, #formEditPegawai textarea'
                );
                all.forEach(function(el) {
                    el.addEventListener('input', updateProgress);
                    el.addEventListener('change', updateProgress);
                });
                updateProgress();

                const form = document.getElementById('formEditPegawai');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        if (form.dataset.confirmed === '1') return;
                        e.preventDefault();

                        function doConfirm() {
                            if (typeof window.Swal === 'undefined') {
                                setTimeout(doConfirm, 150);
                                return;
                            }
                            const roleEl = document.getElementById('role');
                            const roleText = roleEl.value === 'adm' ? 'Administrator' : (roleEl.value ===
                                'opr' ? 'Operator' : '-');
                            window.Swal.fire({
                                title: 'Simpan Perubahan?',
                                html: '<p class="text-sm text-slate-600">Konfirmasi untuk memperbarui data pegawai berikut:</p>' +
                                    '<div class="mt-3 text-left text-xs space-y-1 bg-blue-50 p-3 rounded-xl border border-blue-200">' +
                                    '<div class="flex justify-between gap-3"><span class="text-slate-500">Nama</span><span class="font-bold text-slate-800 truncate max-w-[60%]">' +
                                    (document.getElementById('nama').value || '-') + '</span></div>' +
                                    '<div class="flex justify-between gap-3"><span class="text-slate-500">NIP</span><span class="font-mono font-bold text-slate-800">' +
                                    (document.getElementById('nip').value || '-') + '</span></div>' +
                                    '<div class="flex justify-between gap-3"><span class="text-slate-500">Role</span><span class="font-bold text-slate-800">' +
                                    roleText + '</span></div>' +
                                    '<div class="flex justify-between gap-3"><span class="text-slate-500">Username</span><span class="font-mono font-bold text-slate-800">' +
                                    (document.getElementById('username').value || '-') +
                                    '</span></div>' +
                                    '</div>',
                                icon: 'question',
                                iconColor: '#2563eb',
                                showCancelButton: true,
                                confirmButtonText: 'Ya, Perbarui',
                                cancelButtonText: 'Batal',
                                reverseButtons: true,
                                confirmButtonColor: '#2563eb',
                                cancelButtonColor: '#64748b',
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
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initAll);
            } else {
                initAll();
            }
        })();
    </script>
@endsection
