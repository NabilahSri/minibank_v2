@extends('layouts.app')

@section('title', 'Edit Data Rekening')
@section('page_title', 'Edit Data Rekening')

@section('content')
    <div class="space-y-5 sm:space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="min-w-0">
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('rekening.index') }}"
                        class="inline-flex items-center gap-1 text-[11px] sm:text-xs font-semibold text-slate-500 hover:text-emerald-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali ke Daftar Rekening
                    </a>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight truncate">
                    Edit Data Rekening
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Perbarui data rekening <span
                        class="font-mono font-semibold text-slate-700">{{ $rekening->no_rek }}</span>
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

        <form id="formEditRekening" action="{{ route('rekening.update', $rekening) }}" method="POST" novalidate>
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

                <div class="lg:col-span-2 space-y-5">
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-visible">
                        <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div
                                    class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h2 class="text-sm font-bold text-slate-800">Informasi Rekening</h2>
                                    <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5">Dibuat
                                        {{ $rekening->created_at?->format('d M Y') ?? '-' }}
                                        @if ($rekening->user)
                                            • Oleh {{ $rekening->user->name }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @if ($rekening->status)
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] sm:text-[11px] font-bold bg-green-50 text-green-700 border border-green-200 shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                    AKTIF
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] sm:text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200 shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    NON-AKTIF
                                </span>
                            @endif
                        </div>
                        <div class="p-4 sm:p-5 space-y-4 sm:space-y-5">

                            <div>
                                <label for="nasabah_id"
                                    class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Nasabah <span class="text-rose-500">*</span>
                                </label>
                                <select id="nasabah_id" name="nasabah_id" required data-searchable="true"
                                    data-placeholder="Cari nasabah..."
                                    class="w-full px-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition cursor-pointer">
                                    <option value="">-- Pilih Nasabah --</option>
                                    @foreach ($nasabahs as $nsb)
                                        <option value="{{ $nsb->id }}" data-nama="{{ $nsb->nama }}"
                                            data-nin="{{ $nsb->nin }}" data-jk="{{ $nsb->jk }}"
                                            data-kategori="{{ $nsb->kategori }}"
                                            data-tahun="{{ optional($nsb->siswa)->tahun_masuk }}"
                                            {{ old('nasabah_id', $rekening->nasabah_id) === $nsb->id ? 'selected' : '' }}>
                                            [{{ strtoupper($nsb->kategori === 'siswa' ? 'Siswa' : 'Umum') }}]
                                            {{ $nsb->nama }}
                                            (NIN: {{ $nsb->nin }})
                                            @if ($nsb->siswa && $nsb->siswa->tahun_masuk)
                                                • Siswa {{ $nsb->siswa->tahun_masuk }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('nasabah_id')
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

                            <div id="nasabahPreview">
                                @php
                                    $nsb = $rekening->nasabah;
                                    $jkPreview = $nsb?->jk ?? null;
                                    $avatarBgPreview =
                                        $jkPreview === 'L'
                                            ? 'bg-emerald-100 text-emerald-700 border-emerald-200'
                                            : ($jkPreview === 'P'
                                                ? 'bg-pink-100 text-pink-700 border-pink-200'
                                                : 'bg-slate-100 text-slate-500 border-slate-200');
                                    $initialsPreview = strtoupper(substr($nsb?->nama ?? '?', 0, 1));
                                @endphp
                                <div
                                    class="p-3 sm:p-4 rounded-xl bg-linear-to-r from-blue-50 to-indigo-50 border border-blue-200/60">
                                    <div class="flex items-center gap-3">
                                        <div id="previewAvatar"
                                            class="w-12 h-12 rounded-xl flex items-center justify-center font-black text-base shrink-0 border {{ $avatarBgPreview }}">
                                            {{ $initialsPreview }}
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p id="previewNama"
                                                class="text-sm sm:text-base font-bold text-slate-800 truncate">
                                                {{ $nsb?->nama ?? '-' }}
                                            </p>
                                            <div class="flex flex-wrap items-center gap-1.5 mt-0.5">
                                                <span id="previewNin"
                                                    class="inline-flex items-center text-[10px] sm:text-[11px] font-mono text-slate-500">
                                                    NIN. {{ $nsb?->nin ?? '-' }}
                                                </span>
                                                <span id="previewKategori"
                                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-bold
                                                    {{ $nsb?->kategori === 'siswa' ? 'bg-blue-50 text-blue-700 border border-blue-200' : ($nsb?->kategori === 'umum' ? 'bg-amber-50 text-amber-700 border border-amber-200' : '') }}">
                                                    @if ($nsb?->kategori === 'siswa')
                                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                                        </svg>SISWA
                                                    @elseif ($nsb?->kategori === 'umum')
                                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>UMUM
                                                    @endif
                                                </span>
                                                @if ($nsb && $nsb->siswa && $nsb->siswa->tahun_masuk)
                                                    <span id="previewTahun"
                                                        class="inline-flex items-center text-[10px] sm:text-[11px] text-slate-500">
                                                        🎓 Masuk {{ $nsb->siswa->tahun_masuk }}
                                                    </span>
                                                @else
                                                    <span id="previewTahun" class="hidden"></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-2 border-t border-slate-100">
                                <label for="no_rek"
                                    class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Nomor Rekening <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none shrink-0"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    <input type="text" id="no_rek" name="no_rek"
                                        value="{{ old('no_rek', $rekening->no_rek) }}" maxlength="20" required
                                        class="w-full pl-9 pr-3 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition font-mono font-bold tracking-wide placeholder:text-slate-400">
                                </div>
                                @error('no_rek')
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

                            <div>
                                <div
                                    class="p-3 sm:p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-start sm:items-center justify-between gap-3">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="text-[11px] sm:text-xs font-bold text-slate-700">
                                                Status Rekening Aktif
                                            </p>
                                        </div>
                                        <p class="text-[10px] text-slate-400 mt-0.5">
                                            Nonaktifkan untuk membatasi transaksi pada rekening ini
                                        </p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                        <input type="checkbox" id="status" name="status" value="1"
                                            {{ old('status', $rekening->status ? '1' : '0') === '1' ? 'checked' : '' }}
                                            class="sr-only peer">
                                        <div
                                            class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600">
                                        </div>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div id="pinSection"
                        class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden transition-all {{ old('ganti_pin') ? '' : '' }}">
                        <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div
                                    class="w-8 h-8 rounded-lg {{ old('ganti_pin') ? 'bg-amber-50 text-amber-600' : 'bg-slate-50 text-slate-500' }} flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h2 class="text-sm font-bold text-slate-800">Ganti PIN Transaksi</h2>
                                    <p class="text-[10px] sm:text-xs text-slate-400 mt-0.5">
                                        PIN sebelumnya di-hash, hanya bisa diganti tidak bisa dilihat
                                    </p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                <input type="checkbox" id="ganti_pin" name="ganti_pin" value="1"
                                    {{ old('ganti_pin') ? 'checked' : '' }} class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500">
                                </div>
                            </label>
                        </div>
                        <div id="pinFields"
                            class="p-4 sm:p-5 grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 {{ old('ganti_pin') ? '' : 'hidden' }}">

                            <div class="sm:col-span-1">
                                <label for="pin"
                                    class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    PIN Baru <span class="text-rose-500 ganti-pin-req">*</span>
                                </label>
                                <div class="relative">
                                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none shrink-0"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    <input type="password" id="pin" name="pin" value="{{ old('pin') }}"
                                        maxlength="6" inputmode="numeric" pattern="[0-9]*"
                                        class="pin-field w-full pl-9 pr-10 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition font-mono tracking-[0.3em] text-center placeholder:tracking-normal placeholder:text-slate-400"
                                        placeholder="6 digit angka">
                                    <button type="button" id="togglePin" title="Lihat PIN"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center transition">
                                        <svg id="iconEyePin" class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                @error('pin')
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
                                <label for="pin_confirm"
                                    class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">
                                    Konfirmasi PIN Baru <span class="text-rose-500 ganti-pin-req">*</span>
                                </label>
                                <div class="relative">
                                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400 pointer-events-none shrink-0"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <input type="password" id="pin_confirm" name="pin_confirm"
                                        value="{{ old('pin_confirm') }}" maxlength="6" inputmode="numeric"
                                        pattern="[0-9]*"
                                        class="pin-field w-full pl-9 pr-10 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition font-mono tracking-[0.3em] text-center placeholder:tracking-normal placeholder:text-slate-400"
                                        placeholder="Ulangi 6 digit PIN">
                                    <button type="button" id="togglePinConfirm" title="Lihat PIN"
                                        class="absolute right-2 top-1/2 -translate-y-1/2 w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center transition">
                                        <svg id="iconEyePinConfirm" class="w-3.5 h-3.5" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                <div id="pinMatchIndicator" class="mt-1.5 hidden">
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold">
                                    </span>
                                </div>
                                @error('pin_confirm')
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
                                <div
                                    class="p-3 rounded-xl bg-amber-50 border border-amber-200/60 text-[10px] sm:text-xs text-amber-700 flex items-start gap-2">
                                    <svg class="w-4 h-4 shrink-0 mt-0.5 text-amber-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <div class="space-y-0.5">
                                        <p class="font-bold text-amber-800">PIN akan diganti permanen</p>
                                        <p>Setelah disimpan, PIN lama tidak dapat dikembalikan. Pastikan nasabah mengingat
                                            PIN barunya.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        @if (!old('ganti_pin'))
                            <div id="pinPlaceholder" class="p-4 sm:p-5">
                                <div
                                    class="p-4 rounded-xl border-2 border-dashed border-slate-200 bg-slate-50/50 text-center text-slate-400 text-[11px] sm:text-xs">
                                    <svg class="w-8 h-8 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    Aktifkan toggle <strong>"Ganti PIN"</strong> di atas untuk memasukkan PIN baru
                                </div>
                            </div>
                        @endif
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
                                    <span class="font-bold text-slate-800">Perbarui data</span>
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

                            <div
                                class="p-3 rounded-xl bg-blue-50/60 border border-blue-200/60 text-[11px] sm:text-xs space-y-1.5">
                                <div class="flex justify-between gap-3">
                                    <span class="text-slate-500">No. Rek</span>
                                    <span id="sumNoRek"
                                        class="font-mono font-bold text-slate-800 truncate max-w-[60%]">{{ $rekening->no_rek }}</span>
                                </div>
                                <div class="flex justify-between gap-3">
                                    <span class="text-slate-500">Nasabah</span>
                                    <span id="sumNama"
                                        class="font-bold text-slate-800 truncate max-w-[60%]">{{ $rekening->nasabah?->nama ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between gap-3">
                                    <span class="text-slate-500">Status</span>
                                    <span id="sumStatus"
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold {{ $rekening->status ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                        @if ($rekening->status)
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Aktif
                                        @else
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>Non-Aktif
                                        @endif
                                    </span>
                                </div>
                                <div class="flex justify-between gap-3">
                                    <span class="text-slate-500">Ganti PIN</span>
                                    <span id="sumPin"
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-50 text-slate-500 border border-slate-200">
                                        Tidak
                                    </span>
                                </div>
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
                                <a href="{{ route('rekening.index') }}"
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
                            <li>Penggantian PIN tidak bisa dibatalkan</li>
                            <li>Nonaktifkan rekening untuk menonaktifkan akses transaksi</li>
                            <li>Perubahan data tersimpan otomatis setelah dikonfirmasi</li>
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
            function updateNasabahPreview() {
                const sel = document.getElementById('nasabah_id');
                const opt = sel.options[sel.selectedIndex];
                const nama = opt && opt.value ? opt.getAttribute('data-nama') : '';
                const nin = opt ? opt.getAttribute('data-nin') : '';
                const jk = opt ? opt.getAttribute('data-jk') : '';
                const kategori = opt ? opt.getAttribute('data-kategori') : '';
                const tahun = opt ? opt.getAttribute('data-tahun') : '';
                const initial = nama ? nama.charAt(0).toUpperCase() : '?';
                const avatarBg = jk === 'L' ?
                    'bg-emerald-100 text-emerald-700 border-emerald-200' :
                    (jk === 'P' ? 'bg-pink-100 text-pink-700 border-pink-200' :
                        'bg-slate-100 text-slate-500 border-slate-200');
                const av = document.getElementById('previewAvatar');
                if (av) {
                    av.className =
                        'w-12 h-12 rounded-xl flex items-center justify-center font-black text-base shrink-0 border ' +
                        avatarBg;
                    av.textContent = initial;
                }
                const pNama = document.getElementById('previewNama');
                if (pNama) pNama.textContent = nama || '-';
                const pNin = document.getElementById('previewNin');
                if (pNin) pNin.textContent = 'NIN. ' + (nin || '-');
                const pKat = document.getElementById('previewKategori');
                if (pKat) {
                    if (kategori === 'siswa') {
                        pKat.className =
                            'inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200';
                        pKat.innerHTML =
                            '<svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/></svg>SISWA';
                    } else if (kategori === 'umum') {
                        pKat.className =
                            'inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200';
                        pKat.innerHTML =
                            '<svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>UMUM';
                    } else {
                        pKat.className = '';
                        pKat.textContent = '';
                    }
                }
                const pTh = document.getElementById('previewTahun');
                if (pTh) {
                    if (tahun && kategori === 'siswa') {
                        pTh.classList.remove('hidden');
                        pTh.textContent = '🎓 Masuk ' + tahun;
                    } else {
                        pTh.classList.add('hidden');
                    }
                }
            }

            function togglePinSection() {
                const cb = document.getElementById('ganti_pin');
                const fields = document.getElementById('pinFields');
                const placeholder = document.getElementById('pinPlaceholder');
                const reqs = document.querySelectorAll('.ganti-pin-req');
                const pinFields = document.querySelectorAll('.pin-field');
                const isChecked = cb.checked;
                if (isChecked) {
                    if (fields) fields.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                    reqs.forEach(function(r) {
                        r.textContent = '*';
                    });
                    pinFields.forEach(function(f) {
                        f.setAttribute('required', 'required');
                    });
                } else {
                    if (fields) fields.classList.add('hidden');
                    if (placeholder) placeholder.classList.remove('hidden');
                    reqs.forEach(function(r) {
                        r.textContent = '';
                    });
                    pinFields.forEach(function(f) {
                        f.removeAttribute('required');
                        f.value = '';
                    });
                    const ind = document.getElementById('pinMatchIndicator');
                    if (ind) ind.classList.add('hidden');
                }
                updateProgress();
                updateSummary();
            }

            function pinMatchCheck() {
                const cb = document.getElementById('ganti_pin');
                if (!cb.checked) {
                    const ind = document.getElementById('pinMatchIndicator');
                    if (ind) ind.classList.add('hidden');
                    return;
                }
                const pin = document.getElementById('pin').value;
                const pconf = document.getElementById('pin_confirm').value;
                const ind = document.getElementById('pinMatchIndicator');
                const span = ind ? ind.querySelector('span') : null;
                if (!ind || !span) return;
                if (!pin && !pconf) {
                    ind.classList.add('hidden');
                    return;
                }
                ind.classList.remove('hidden');
                if (pin && pconf && pin === pconf && pin.length === 6) {
                    span.className =
                        'inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-green-50 text-green-700 border border-green-200';
                    span.innerHTML =
                        '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> PIN cocok ✓';
                } else if (pin.length > 0 || pconf.length > 0) {
                    if (pin && pconf && pin !== pconf) {
                        span.className =
                            'inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200';
                        span.innerHTML =
                            '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> PIN tidak cocok';
                    } else {
                        span.className =
                            'inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-50 text-slate-500 border border-slate-200';
                        span.textContent = 'PIN harus 6 digit';
                    }
                }
            }

            function numericOnly(el) {
                if (!el) return;
                el.addEventListener('input', function() {
                    el.value = el.value.replace(/[^0-9]/g, '');
                });
                el.addEventListener('paste', function(e) {
                    try {
                        const txt = (e.clipboardData || window.clipboardData).getData('text');
                        if (txt && /[^0-9]/.test(txt)) e.preventDefault();
                    } catch (_) {}
                });
            }

            function togglePwVisibility(inputId, iconId, btn) {
                const input = document.getElementById(inputId);
                const icon = document.getElementById(iconId);
                if (!input || !icon) return;
                btn.addEventListener('click', function() {
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.innerHTML =
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
                    } else {
                        input.type = 'password';
                        icon.innerHTML =
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
                    }
                });
            }

            function updateSummary() {
                const sel = document.getElementById('nasabah_id');
                const opt = sel.options[sel.selectedIndex];
                const nama = opt && opt.value ? opt.getAttribute('data-nama') : '-';
                const nrek = document.getElementById('no_rek').value.trim();
                const isA = document.getElementById('status').checked;
                const gantiPin = document.getElementById('ganti_pin').checked;

                const sR = document.getElementById('sumNoRek');
                const sN = document.getElementById('sumNama');
                const sS = document.getElementById('sumStatus');
                const sP = document.getElementById('sumPin');

                if (sR) sR.textContent = nrek || '-';
                if (sN) sN.textContent = nama || '-';
                if (sS) {
                    if (isA) {
                        sS.className =
                            'inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-green-50 text-green-700 border border-green-200';
                        sS.innerHTML =
                            '<span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Aktif';
                    } else {
                        sS.className =
                            'inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200';
                        sS.innerHTML =
                            '<span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>Non-Aktif';
                    }
                }
                if (sP) {
                    if (gantiPin) {
                        sP.className =
                            'inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200';
                        sP.innerHTML =
                            '<span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>Ya';
                    } else {
                        sP.className =
                            'inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-50 text-slate-500 border border-slate-200';
                        sP.textContent = 'Tidak';
                    }
                }
            }

            function updateProgress() {
                const bar = document.getElementById('progressBar');
                const txt = document.getElementById('progressText');
                if (!bar || !txt) return;
                const fields = [
                    document.getElementById('nasabah_id'),
                    document.getElementById('no_rek')
                ];
                const total = fields.length;
                let filled = 0;
                if (fields[0] && fields[0].value) filled++;
                if (fields[1] && fields[1].value.trim()) filled++;

                const gantiPin = document.getElementById('ganti_pin').checked;
                if (gantiPin) {
                    const pin = document.getElementById('pin');
                    const pconf = document.getElementById('pin_confirm');
                    if (pin && pin.value.length === 6) filled++;
                    if (pconf && pconf.value.length === 6 && pin.value === pconf.value) filled++;
                    const t = total + 2;
                    const pct = t > 0 ? Math.round((Math.min(filled, t) / t) * 100) : 0;
                    bar.style.width = pct + '%';
                    txt.textContent = pct + '% terisi';
                } else {
                    const pct = total > 0 ? Math.round((Math.min(filled, total) / total) * 100) : 0;
                    bar.style.width = pct + '%';
                    txt.textContent = pct + '% terisi';
                }
            }

            function initAll() {
                const sel = document.getElementById('nasabah_id');
                if (sel) {
                    sel.addEventListener('change', function() {
                        updateNasabahPreview();
                        updateProgress();
                        updateSummary();
                    });
                }
                numericOnly(document.getElementById('pin'));
                numericOnly(document.getElementById('pin_confirm'));

                const pin = document.getElementById('pin');
                const pinC = document.getElementById('pin_confirm');
                pin.addEventListener('input', function() {
                    pinMatchCheck();
                    updateProgress();
                });
                pinC.addEventListener('input', function() {
                    pinMatchCheck();
                    updateProgress();
                });

                const gantiCb = document.getElementById('ganti_pin');
                if (gantiCb) gantiCb.addEventListener('change', togglePinSection);

                const nrek = document.getElementById('no_rek');
                if (nrek) nrek.addEventListener('input', function() {
                    updateProgress();
                    updateSummary();
                });

                const statusCb = document.getElementById('status');
                if (statusCb) statusCb.addEventListener('change', updateSummary);

                togglePwVisibility('pin', 'iconEyePin', document.getElementById('togglePin'));
                togglePwVisibility('pin_confirm', 'iconEyePinConfirm', document.getElementById('togglePinConfirm'));

                pinMatchCheck();
                togglePinSection();
                updateProgress();
                updateSummary();

                const form = document.getElementById('formEditRekening');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        if (form.dataset.confirmed === '1') return;
                        e.preventDefault();

                        function doConfirm() {
                            if (typeof window.Swal === 'undefined') {
                                setTimeout(doConfirm, 150);
                                return;
                            }
                            const selN = document.getElementById('nasabah_id');
                            const optN = selN.options[selN.selectedIndex];
                            const namaN = optN && optN.value ? optN.getAttribute('data-nama') : '-';
                            const noR = document.getElementById('no_rek').value || '-';
                            const isA = document.getElementById('status').checked;
                            const gP = document.getElementById('ganti_pin').checked;

                            window.Swal.fire({
                                title: 'Simpan Perubahan Rekening?',
                                html: '<p class="text-sm text-slate-600">Konfirmasi perubahan berikut:</p>' +
                                    '<div class="mt-3 text-left text-xs space-y-1 bg-blue-50 p-3 rounded-xl border border-blue-200">' +
                                    '<div class="flex justify-between gap-3"><span class="text-slate-500">No. Rekening</span><span class="font-mono font-bold text-slate-800">' +
                                    noR + '</span></div>' +
                                    '<div class="flex justify-between gap-3"><span class="text-slate-500">Nasabah</span><span class="font-bold text-slate-800 truncate max-w-[60%]">' +
                                    namaN + '</span></div>' +
                                    '<div class="flex justify-between gap-3"><span class="text-slate-500">Status</span><span class="font-bold ' +
                                    (isA ? 'text-green-700' : 'text-rose-700') + '">' +
                                    (isA ? '🟢 Aktif' : '⛔ Non-Aktif') + '</span></div>' +
                                    '<div class="flex justify-between gap-3"><span class="text-slate-500">Ganti PIN</span><span class="font-bold ' +
                                    (gP ? 'text-amber-700' : 'text-slate-600') + '">' +
                                    (gP ? '🔑 Ya, PIN baru' : 'Tidak') + '</span></div>' +
                                    '</div>',
                                icon: 'question',
                                iconColor: '#2563eb',
                                showCancelButton: true,
                                confirmButtonText: 'Ya, Perbarui',
                                cancelButtonText: 'Batal',
                                reverseButtons: true,
                                confirmButtonColor: '#2563eb',
                                cancelButtonColor: '#64748b',
                                allowOutsideClick: false,
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
