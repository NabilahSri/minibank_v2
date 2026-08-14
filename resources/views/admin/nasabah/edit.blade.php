@extends('layouts.app')

@section('title', 'Edit Data Nasabah')
@section('page_title', 'Edit Data Nasabah')

@section('content')
    <div class="space-y-5 sm:space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="min-w-0">
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('nasabah.index') }}"
                        class="inline-flex items-center gap-1 text-[11px] sm:text-xs font-semibold text-slate-500 hover:text-emerald-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali ke Daftar Nasabah
                    </a>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight truncate">
                    Edit Data Nasabah
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Perbarui informasi nasabah <span class="font-semibold text-slate-700">{{ $nasabah->nama }}</span>
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

        <form id="formEditNasabah" action="{{ route('nasabah.update', $nasabah) }}" method="POST" novalidate>
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
                                <h2 class="text-sm font-bold text-slate-800">Data Diri Nasabah</h2>
                                <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5">Informasi pribadi nasabah</p>
                            </div>
                        </div>
                        <div class="p-4 sm:p-5 grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">

                            <div class="sm:col-span-1">
                                <label for="nin" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    NIN <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" id="nin" name="nin" value="{{ old('nin', $nasabah->nin) }}"
                                    maxlength="50" required
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition font-mono placeholder:text-slate-400"
                                    placeholder="cth: 2026001001">
                                @error('nin')
                                    <p class="text-[10px] sm:text-xs text-rose-600 mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                                @error('nin')
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
                                <label for="kategori" class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Kategori Nasabah <span class="text-rose-500">*</span>
                                </label>
                                <select id="kategori" name="kategori" required data-searchable="true"
                                    data-placeholder="Pilih kategori..."
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition cursor-pointer">
                                    @error('kategori')
                                        <p class="text-[10px] sm:text-xs text-rose-600 mt-1 flex items-center gap-1">
                                            <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="siswa"
                                        {{ old('kategori', $nasabah->kategori) === 'siswa' ? 'selected' : '' }}>Siswa
                                    </option>
                                    <option value="umum"
                                        {{ old('kategori', $nasabah->kategori) === 'umum' ? 'selected' : '' }}>Umum (Guru /
                                        Staf / Warga)</option>
                                </select>
                                @error('kategori')
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
                                    value="{{ old('nama', $nasabah->nama) }}" maxlength="100" required
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition placeholder:text-slate-400"
                                    placeholder="cth: Nabilah Rahmawati">
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
                                            {{ old('jk', $nasabah->jk) === 'L' ? 'checked' : '' }} required
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
                                            {{ old('jk', $nasabah->jk) === 'P' ? 'checked' : '' }} class="peer sr-only">
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
                                        value="{{ old('no_hp', $nasabah->no_hp) }}" maxlength="20"
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

                            <div class="sm:col-span-2">
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
                                        value="{{ old('email', $nasabah->email) }}" maxlength="100"
                                        class="w-full pl-9 pr-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition placeholder:text-slate-400"
                                        placeholder="cth: nasabah@email.com">
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
                                    placeholder="cth: Jl. Pendidikan No. 123, Surabaya">{{ old('alamat', $nasabah->alamat) }}</textarea>
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

                            <div class="sm:col-span-2">
                                <label for="nama_ortu"
                                    class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Nama Orang Tua / Wali
                                    <span class="font-normal text-slate-400">(opsional, untuk siswa)</span>
                                </label>
                                <input type="text" id="nama_ortu" name="nama_ortu"
                                    value="{{ old('nama_ortu', $nasabah->nama_ortu) }}" maxlength="100"
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition placeholder:text-slate-400"
                                    placeholder="cth: Bapak Ahmad Zaini">
                                @error('nama_ortu')
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

                    <div id="boxDataSiswa"
                        class="bg-white rounded-2xl border border-blue-200/60 shadow-sm overflow-hidden transition-all duration-300 {{ old('kategori', $nasabah->kategori) === 'siswa' ? '' : 'hidden' }}">
                        <div class="p-4 sm:p-5 border-b border-blue-100 bg-blue-50/60 flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <h2 class="text-sm font-bold text-blue-800">Data Khusus Siswa</h2>
                                <p class="text-[10px] sm:text-xs text-blue-600/70 mt-0.5">Wajib diisi jika kategori = Siswa
                                </p>
                            </div>
                            <span
                                class="ml-auto inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-blue-100 text-blue-700 text-[10px] font-bold border border-blue-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                                REQUIRED
                            </span>
                        </div>
                        <div class="p-4 sm:p-5 grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                            <div class="sm:col-span-1">
                                <label for="nisn"
                                    class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    NISN <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" id="nisn" name="nisn"
                                    value="{{ old('nisn', optional($nasabah->siswa)->nisn) }}" maxlength="50"
                                    class="nisn-input w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition font-mono placeholder:text-slate-400"
                                    placeholder="cth: 0012345678">
                                @error('nisn')
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
                                <label for="tahun_masuk"
                                    class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Tahun Masuk <span class="text-rose-500">*</span>
                                </label>
                                <input type="number" id="tahun_masuk" name="tahun_masuk"
                                    value="{{ old('tahun_masuk', optional($nasabah->siswa)->tahun_masuk) }}"
                                    min="2000" max="{{ date('Y') + 1 }}" step="1"
                                    class="tahun-masuk-input w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition font-mono placeholder:text-slate-400"
                                    placeholder="cth: {{ date('Y') }}">
                                @error('tahun_masuk')
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
                                <a href="{{ route('nasabah.index') }}"
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
                            <li>Jika kategori diubah dari Siswa → Umum, data NISN/Jurusan akan terhapus</li>
                            <li>NIN harus tetap unik antar nasabah</li>
                            <li>Perubahan data akan langsung tersimpan setelah dikonfirmasi</li>
                        </ul>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        (function() {
            function toggleBoxSiswa() {
                const sel = document.getElementById('kategori');
                const box = document.getElementById('boxDataSiswa');
                if (!sel || !box) return;
                const isSiswa = sel.value === 'siswa';

                if (isSiswa) {
                    box.classList.remove('hidden');
                    try {
                        box.style.display = '';
                    } catch (_) {}
                } else {
                    box.classList.add('hidden');
                    try {
                        box.style.display = 'none';
                    } catch (_) {}
                }

                const toggleReq = function(el, required) {
                    if (!el) return;
                    if (required) el.setAttribute('required', 'required');
                    else el.removeAttribute('required');
                };
                toggleReq(document.getElementById('nisn'), isSiswa);
                toggleReq(document.getElementById('tahun_masuk'), isSiswa);
            }

            function initAll() {
                const selKat = document.getElementById('kategori');
                if (selKat) {
                    selKat.addEventListener('change', toggleBoxSiswa);
                    toggleBoxSiswa();
                }

                const bar = document.getElementById('progressBar');
                const txt = document.getElementById('progressText');

                function countRequiredFields() {
                    return document.querySelectorAll(
                        '#formEditNasabah input[required], #formEditNasabah select[required], #formEditNasabah textarea[required]'
                    );
                }

                function updateProgress() {
                    const requiredFields = countRequiredFields();
                    const total = requiredFields.length;
                    if (!bar || !txt) return;
                    let filled = 0;
                    let radioChecked = {};
                    requiredFields.forEach(function(f) {
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

                const allFields = document.querySelectorAll(
                    '#formEditNasabah input, #formEditNasabah select, #formEditNasabah textarea');
                allFields.forEach(function(el) {
                    el.addEventListener('input', updateProgress);
                    el.addEventListener('change', function() {
                        if (el.id === 'kategori') toggleBoxSiswa();
                        setTimeout(updateProgress, 50);
                    });
                });
                updateProgress();

                const formEdit = document.getElementById('formEditNasabah');
                if (formEdit) {
                    formEdit.addEventListener('submit', function(e) {
                        if (formEdit.dataset.confirmed === '1') return;
                        e.preventDefault();

                        function doConfirm() {
                            if (typeof window.Swal === 'undefined') {
                                setTimeout(doConfirm, 150);
                                return;
                            }
                            window.Swal.fire({
                                title: 'Simpan Perubahan?',
                                html: '<p class="text-sm text-slate-600">Konfirmasi untuk memperbarui data nasabah berikut:</p>' +
                                    '<div class="mt-3 text-left text-xs space-y-1 bg-blue-50 p-3 rounded-xl border border-blue-200">' +
                                    '<div class="flex justify-between gap-3"><span class="text-slate-500">Nama</span><span class="font-bold text-slate-800 truncate max-w-[60%]">' +
                                    (document.getElementById('nama').value || '-') + '</span></div>' +
                                    '<div class="flex justify-between gap-3"><span class="text-slate-500">NIN</span><span class="font-mono font-bold text-slate-800">' +
                                    (document.getElementById('nin').value || '-') + '</span></div>' +
                                    '<div class="flex justify-between gap-3"><span class="text-slate-500">Kategori</span><span class="font-bold text-slate-800">' +
                                    (document.getElementById('kategori').value === 'siswa' ? 'Siswa' : (
                                        document.getElementById('kategori').value === 'umum' ?
                                        'Umum' : '-')) + '</span></div>' +
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
                                    formEdit.dataset.confirmed = '1';
                                    formEdit.submit();
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
