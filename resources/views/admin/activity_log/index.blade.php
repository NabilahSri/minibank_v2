@extends('layouts.app')

@section('title', 'Log Aktivitas')
@section('page_title', 'Log Aktivitas')

@section('content')
    <div class="space-y-5 sm:space-y-6">

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="min-w-0">
                <div class="flex items-center gap-2.5">
                    <div
                        class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0 border border-purple-100/80 shadow-xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                            Log Aktivitas
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                            Memantau rekam jejak aktivitas sistem secara menyeluruh
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs p-4 sm:p-5">
            <form action="{{ route('activity-log.index') }}" method="GET" class="space-y-3.5">
                <div class="flex flex-col sm:flex-row items-stretch sm:items-end gap-3">

                    <!-- Search Input -->
                    <div class="flex-1">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">
                            Pencarian
                        </label>
                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text" name="q" value="{{ $search ?? '' }}"
                                placeholder="Cari aktivitas, nama modul, atau user..."
                                class="w-full pl-9 pr-3.5 py-2 text-xs sm:text-sm rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition">
                        </div>
                    </div>

                    <!-- Submit & Reset Buttons -->
                    <div class="flex items-center gap-2 shrink-0">
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-white bg-slate-800 hover:bg-slate-900 transition shadow-xs active:scale-[0.98]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            <span>Cari</span>
                        </button>
                        <a href="{{ route('activity-log.index') }}"
                            class="inline-flex items-center justify-center px-3 py-2 rounded-xl text-xs sm:text-sm font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 transition active:scale-[0.98]"
                            title="Reset Pencarian">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Main Report Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <span class="text-xs sm:text-sm font-bold text-slate-800">
                        Riwayat Aktivitas Terbaru
                    </span>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm min-w-[850px]">
                    <thead
                        class="bg-slate-50/80 text-slate-500 uppercase tracking-wider text-[10px] sm:text-[11px] font-bold border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-4 sm:px-5">Waktu</th>
                            <th class="py-3 px-4 sm:px-5">Modul (Log Name)</th>
                            <th class="py-3 px-4 sm:px-5">Deskripsi</th>
                            <th class="py-3 px-4 sm:px-5">User</th>
                            <th class="py-3 px-4 sm:px-5">Klien (IP & Browser)</th>
                            <th class="py-3 px-4 sm:px-5">Properti (Perubahan)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse ($logs as $log)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap text-slate-500 font-mono text-xs">
                                    {{ $log->created_at->format('d/m/Y H:i:s') }}
                                    <div class="text-[10px] text-slate-400">{{ $log->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap font-bold text-slate-800">
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $log->log_name }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 sm:px-5 font-medium text-slate-800">
                                    {{ $log->description }}
                                    @if ($log->event)
                                        <span
                                            class="ml-1 px-1.5 py-0.5 text-[10px] font-bold uppercase rounded-md 
                                            @if ($log->event === 'created') bg-emerald-100 text-emerald-700 
                                            @elseif($log->event === 'updated') bg-blue-100 text-blue-700 
                                            @elseif($log->event === 'deleted') bg-rose-100 text-rose-700 
                                            @else bg-slate-100 text-slate-700 @endif">
                                            {{ $log->event }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 sm:px-5 whitespace-nowrap font-semibold">
                                    @if ($log->causer)
                                        @php
                                            $causerName =
                                                $log->causer->pegawai->nama ??
                                                ($log->causer->nasabah->nama ?? $log->causer->username);
                                        @endphp
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-600">
                                                {{ strtoupper(substr($causerName, 0, 2)) }}
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-xs">{{ $causerName }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex flex-col">
                                            <span class="text-slate-400 italic">System / Guest</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 px-4 sm:px-5">
                                    <div class="flex flex-col gap-0.5">
                                        <div class="flex items-center gap-1 text-slate-700">
                                            <svg class="w-3 h-3 text-slate-400 shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                                                </path>
                                            </svg>
                                            <span
                                                class="text-[11px] font-mono font-bold">{{ $log->properties['ip'] ?? '—' }}</span>
                                        </div>
                                        <div class="flex items-start gap-1 text-slate-500 max-w-[150px]"
                                            title="{{ $log->properties['user_agent'] ?? '' }}">
                                            <svg class="w-3 h-3 text-slate-400 mt-0.5 shrink-0" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span
                                                class="text-[10px] truncate leading-tight">{{ $log->properties['user_agent'] ?? '—' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 sm:px-5">
                                    <button type="button"
                                        onclick="showPropertiesModal({{ $log->id }}, {{ json_encode($log->properties) }})"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-[10px] font-bold text-purple-600 bg-purple-50 hover:bg-purple-100 border border-purple-200 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Lihat Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-14 text-center">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <div
                                            class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center border border-slate-200">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-slate-800">Tidak Ada Log</h3>
                                            <p class="text-xs text-slate-500 mt-0.5">
                                                Belum ada aktivitas sistem yang terekam atau ditemukan.
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($logs->hasPages())
                <div class="p-4 sm:p-5 border-t border-slate-100 bg-slate-50/50">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>

    </div>

    <!-- Modal Properti -->
    <div id="modalProperties"
        class="fixed inset-0 z-[80] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div
            class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl border border-slate-200/80 overflow-hidden transform transition-all flex flex-col max-h-[90vh]">

            <!-- Header Modal -->
            <div
                class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between gap-3 bg-gradient-to-r from-purple-50 via-pink-50 to-purple-50 shrink-0">
                <div class="flex items-center gap-3 min-w-0">
                    <div
                        class="w-10 h-10 rounded-xl bg-purple-600 text-white flex items-center justify-center shrink-0 shadow-md shadow-purple-600/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-900">Detail Aktivitas & Properti</h3>
                        <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5">Informasi lengkap data yang dikirim /
                            diubah</p>
                    </div>
                </div>
                <button type="button" onclick="closePropertiesModal()"
                    class="w-8 h-8 rounded-lg bg-white hover:bg-slate-100 text-slate-500 hover:text-slate-700 flex items-center justify-center transition border border-slate-200 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Body Modal -->
            <div class="p-4 sm:p-5 overflow-y-auto flex-1 bg-slate-50 space-y-4">

                <div id="prop_content" class="w-full text-xs font-mono">
                    <!-- Konten JSON akan diinject di sini -->
                </div>

            </div>

            <!-- Footer Modal -->
            <div class="p-4 sm:p-5 border-t border-slate-100 bg-white shrink-0 flex justify-end">
                <button type="button" onclick="closePropertiesModal()"
                    class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                    Tutup
                </button>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const modalProp = document.getElementById('modalProperties');
        const propContent = document.getElementById('prop_content');

        function showPropertiesModal(logId, properties) {
            let html = '';

            // Hapus dari properties object utama agar tidak ikut ter-render di JSON
            delete properties.ip;
            delete properties.user_agent;

            if (Object.keys(properties).length === 0) {
                html = '<div class="text-slate-400 text-center italic py-4">Tidak ada data perubahan tersimpan.</div>';
            } else if (properties.old || properties.attributes) {
                html += '<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">';

                // Data Lama
                if (properties.old) {
                    html += `
                    <div class="bg-white rounded-xl border border-rose-100 shadow-sm overflow-hidden">
                        <div class="bg-rose-50 px-3 py-2 border-b border-rose-100 text-xs font-bold text-rose-700">Data Lama (Old)</div>
                        <pre class="p-3 text-[11px] text-slate-600 overflow-x-auto">\n${JSON.stringify(properties.old, null, 2)}</pre>
                    </div>`;
                }

                // Data Baru
                if (properties.attributes) {
                    html += `
                    <div class="bg-white rounded-xl border border-emerald-100 shadow-sm overflow-hidden">
                        <div class="bg-emerald-50 px-3 py-2 border-b border-emerald-100 text-xs font-bold text-emerald-700">Data Baru (New)</div>
                        <pre class="p-3 text-[11px] text-slate-600 overflow-x-auto">\n${JSON.stringify(properties.attributes, null, 2)}</pre>
                    </div>`;
                }
                html += '</div>';
            } else {
                html = `
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="bg-slate-50 px-3 py-2 border-b border-slate-100 text-xs font-bold text-slate-700">Payload / Data Lainnya</div>
                    <pre class="p-3 text-[11px] text-slate-600 overflow-x-auto">\n${JSON.stringify(properties, null, 2)}</pre>
                </div>`;
            }

            propContent.innerHTML = html;
            modalProp.classList.remove('hidden');
            modalProp.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closePropertiesModal() {
            modalProp.classList.add('hidden');
            modalProp.classList.remove('flex');
            document.body.style.overflow = '';
        }

        // Escape untuk tutup modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modalProp.classList.contains('hidden')) {
                closePropertiesModal();
            }
        });

        // Klik background overlay untuk tutup
        modalProp.addEventListener('click', function(e) {
            if (e.target === modalProp) closePropertiesModal();
        });
    </script>
@endsection
