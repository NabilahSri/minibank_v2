<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mini Bank') - Mini Bank YPC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 font-sans text-slate-700 antialiased min-h-screen flex overflow-hidden">

    <!-- SIDEBAR COMPONENT -->
    @include('layouts.partials.sidebar')

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col min-w-0 h-full lg:h-screen">

        <!-- HEADER COMPONENT -->
        @include('layouts.partials.header')

        <!-- PAGE CONTENT -->
        <main class="p-4 sm:p-6 lg:p-8 flex-1 overflow-y-auto">
            @yield('content')
        </main>

        <!-- FOOTER (konsisten dengan login page footer) -->
        <footer class="px-4 sm:px-6 lg:px-8 py-4 border-t border-slate-200/80 bg-white">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-400">
                <span>&copy; {{ date('Y') }} Pusdatin SMK YPC Tasikmalaya.</span>
                <span class="font-mono text-[10px]">Build v2.0.0</span>
            </div>
        </footer>

    </div>

    <!-- INTERACTIVE SCRIPTS -->
    <script>
        // Sidebar Toggle (Mobile)
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.remove('opacity-0'), 10);
                document.body.style.overflow = 'hidden';
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('opacity-0');
                setTimeout(() => overlay.classList.add('hidden'), 300);
                document.body.style.overflow = '';
            }
        }

        // User Menu Dropdown Toggle
        function toggleUserMenu() {
            const menu = document.getElementById('user-menu');
            menu.classList.toggle('hidden');
        }

        // Notif Menu Dropdown Toggle
        function toggleNotifMenu() {
            const menu = document.getElementById('notif-menu');
            menu.classList.toggle('hidden');
        }

        // Close Dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            const userWrapper = document.getElementById('user-menu-wrapper');
            const userMenu = document.getElementById('user-menu');
            if (userWrapper && !userWrapper.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
            
            const notifWrapper = document.getElementById('notif-menu-wrapper');
            const notifMenu = document.getElementById('notif-menu');
            if (notifWrapper && !notifWrapper.contains(e.target)) {
                notifMenu.classList.add('hidden');
            }
        });

        // Close sidebar and menus on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const sidebar = document.getElementById('sidebar');
                if (!sidebar.classList.contains('-translate-x-full')) {
                    toggleSidebar();
                }
                const userMenu = document.getElementById('user-menu');
                if (userMenu && !userMenu.classList.contains('hidden')) {
                    userMenu.classList.add('hidden');
                }
                const notifMenu = document.getElementById('notif-menu');
                if (notifMenu && !notifMenu.classList.contains('hidden')) {
                    notifMenu.classList.add('hidden');
                }
            }
        });

        // Auto-close sidebar when resizing to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
                overlay.classList.add('opacity-0');
                document.body.style.overflow = '';
            }
        });

        // SweetAlert2 Toast Flash Messages
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
                    showToast('error', 'Terjadi Kesalahan', @json($errMsg));
                @endforeach
            @endif
        })();
    </script>

    @yield('scripts')

</body>

</html>
