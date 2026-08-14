<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - YPC Mini Bank v2.0</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 font-sans antialiased text-slate-800">

    <div class="min-h-screen flex flex-col-reverse lg:flex-row">

        <!-- BAGIAN KIRI (DESKTOP) / BAWAH (MOBILE): BRANDING & VISUAL -->
        <div
            class="relative flex-1 bg-emerald-900 text-white flex flex-col justify-between p-6 sm:p-8 lg:p-12 overflow-hidden lg:min-h-screen">

            <!-- Pattern Hiasan Background -->
            <div
                class="absolute inset-0 opacity-10 bg-[radial-gradient(#10b981_1px,transparent_1px)] bg-[size:16px_16px]">
            </div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-emerald-600/30 rounded-full blur-3xl"></div>
            <div class="absolute top-10 right-10 w-72 h-72 bg-teal-500/20 rounded-full blur-2xl"></div>

            <!-- Header Logo + Badge v2.0 -->
            <div class="relative z-10 flex items-center space-x-3 lg:block">
                <div
                    class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center font-bold text-emerald-300">
                    YPC
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-bold text-lg tracking-wide text-emerald-100">MINI BANK</span>
                    <span
                        class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-emerald-500/30 text-emerald-300 border border-emerald-400/30">
                        v2.0
                    </span>
                </div>
            </div>

            <!-- Content Middle (Hidden di Mobile, ditampilkan di atas form) -->
            <div class="relative z-10 my-auto py-6 lg:py-8 max-w-lg hidden lg:block">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium bg-emerald-800/80 text-emerald-300 border border-emerald-700/50 mb-4">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Sistem Perbankan Digital v2.0
                </span>
                <h1 class="text-3xl lg:text-4xl font-extrabold tracking-tight text-white mb-4 leading-tight">
                    Kelola Tabungan & Transaksi Lebih Transparan
                </h1>
                <p class="text-emerald-100/80 text-sm md:text-base leading-relaxed">
                    Platform layanan keuangan terintegrasi untuk siswa dan staf SMK YPC Tasikmalaya.
                </p>
            </div>

            <!-- Footer -->
            <div
                class="relative z-10 text-xs text-emerald-300/60 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 mt-6 lg:mt-0">
                <span>&copy; {{ date('Y') }} Pusdatin SMK YPC Tasikmalaya.</span>
                <span class="font-mono text-[10px] opacity-75">Build v2.0.0</span>
            </div>
        </div>

        <!-- BAGIAN KANAN (DESKTOP) / ATAS (MOBILE): FORM LOGIN -->
        <div class="flex-1 flex items-center justify-center p-5 sm:p-8 lg:p-16 bg-white min-h-[60vh] lg:min-h-screen">
            <div class="w-full max-w-md space-y-6">

                <!-- Mobile Branding Text (Hanya tampil di mobile) -->
                <div class="lg:hidden text-center mb-8">
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[11px] font-medium bg-emerald-500/10 text-emerald-600 border border-emerald-500/20 mb-4">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Sistem Perbankan Digital v2.0
                    </span>
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 mb-2 leading-tight">
                        Kelola Tabungan Lebih Transparan
                    </h1>
                    <p class="text-slate-500 text-sm">
                        Platform layanan keuangan terintegrasi SMK YPC Tasikmalaya.
                    </p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Masuk ke Akun</h2>
                    <p class="text-sm text-slate-500 mt-1">Masukkan kredensial Anda untuk mengakses sistem</p>
                </div>

                <!-- Alert Error - DIPINDAHKAN KE SWEETALERT2 TOAST -->

                <form class="space-y-5" action="{{ route('login.submit') }}" method="POST">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-500 mb-1.5">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}" required
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('username') || $errors->has('login_gagal') ? 'border-rose-300 focus:ring-rose-500 focus:border-rose-500' : 'border-slate-200 focus:ring-emerald-500 focus:border-emerald-500' }} transition text-sm bg-slate-50/50 focus:bg-white"
                            placeholder="Masukkan username">
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-semibold uppercase text-slate-500">Password</label>
                            <a href="#" class="text-xs font-semibold text-emerald-600 hover:underline">Lupa
                                Password?</a>
                        </div>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition text-sm bg-slate-50/50 focus:bg-white"
                            placeholder="••••••••">
                    </div>

                    <div class="flex items-center justify-between text-sm pt-1">
                        <label class="flex items-center gap-2 text-slate-600 text-xs cursor-pointer">
                            <input type="checkbox" name="remember"
                                class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                            Ingat sesi saya
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full py-3.5 px-4 rounded-xl text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-100 shadow-lg shadow-emerald-600/20 transition duration-150 active:scale-[0.98]">
                        Masuk Sistem
                    </button>
                </form>

            </div>
        </div>

    </div>

    <!-- SweetAlert2 Toast Flash Messages -->
    <script>
        (function() {
            function showToast(type, title, text) {
                function fire() {
                    if (window.toast && typeof window.toast[type] === 'function') {
                        window.toast[type](title, text || '');
                    }
                }
                if (window.toast) {
                    setTimeout(fire, 250);
                } else {
                    let tries = 0;
                    const iv = setInterval(() => {
                        tries++;
                        if (window.toast || tries > 40) {
                            clearInterval(iv);
                            if (window.toast) fire();
                        }
                    }, 75);
                }
            }

            @if (session('toast_success'))
                showToast('success', @json(session('toast_success')['title'] ?? 'Berhasil'), @json(session('toast_success')['message'] ?? ''));
            @endif

            @if (session('toast_error'))
                showToast('error', @json(session('toast_error')['title'] ?? 'Error'), @json(session('toast_error')['message'] ?? ''));
            @endif

            @if (session('toast_warning'))
                showToast('warning', @json(session('toast_warning')['title'] ?? 'Perhatian'), @json(session('toast_warning')['message'] ?? ''));
            @endif

            @if (session('toast_info'))
                showToast('info', @json(session('toast_info')['title'] ?? 'Info'), @json(session('toast_info')['message'] ?? ''));
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $errMsg)
                    showToast('error', 'Login Gagal', @json($errMsg));
                @endforeach
            @endif
        })();
    </script>

</body>

</html>
