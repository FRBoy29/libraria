<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBRARIA Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:FILL,GRAD,opsz,wght@0..1,-50..200,20..48,100..700" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        canvas: "#F8FAFC",
                        navy: "#1F2D4D",
                        primary: "#081837",
                        brand: "#4F8EF7",
                        secondary: "#005BBF",
                        gold: "#D4B483",
                        golddark: "#AE9163",
                        success: "#10B981",
                        warning: "#F59E0B",
                        danger: "#EF4444",
                        error: "#BA1A1A",
                        errorbox: "#FFDAD6",
                        line: "#E2E8F0",
                    },
                    fontFamily: {
                        poppins: ["Poppins", "sans-serif"],
                        inter: ["Inter", "sans-serif"],
                    },
                },
            },
        };
        try {
            if (localStorage.getItem("libraria-admin-theme") === "dark") {
                document.documentElement.classList.add("dark");
            }
        } catch (e) { /* storage unavailable */ }
    </script>
    <style>
        .material-symbols-outlined {
            font-family: "Material Symbols Outlined";
            font-weight: normal; font-style: normal; line-height: 1;
            letter-spacing: normal; text-transform: none; display: inline-block;
            white-space: nowrap; word-wrap: normal; direction: ltr;
            -webkit-font-smoothing: antialiased; text-rendering: optimizeLegibility;
            font-variation-settings: "FILL" 0, "wght" 400, "GRAD" 0, "opsz" 24;
            user-select: none;
        }
    </style>
    <livewire:styles />
</head>
<body class="bg-canvas dark:bg-[#0B1326] font-inter text-[14px] text-[#111C2D] dark:text-[#DAE2FD] antialiased">
    @php($active = $active ?? 'dashboard')
    @php($accountName = auth()->user()->name ?? 'Admin')
    @php($accountEmail = auth()->user()->email ?? '')
    <div id="sidebar-overlay" class="hidden fixed inset-0 bg-black/40 z-40 lg:hidden"></div>
    <aside id="admin-sidebar" class="fixed left-0 top-0 h-full w-[250px] bg-white dark:bg-[#131B2E] border-r border-line dark:border-[#263252] z-50 flex flex-col justify-between -translate-x-full lg:translate-x-0 transition-transform duration-200">
        <div class="flex flex-col min-h-0">
            <div class="h-16 px-6 flex items-center gap-2.5 border-b border-line dark:border-[#263252] shrink-0">
                <img src="{{ asset('assets/logo/libraria-mark.svg') }}" alt="Logo LIBRARIA" class="h-8 w-8 object-contain">
                <span class="text-navy dark:text-white font-poppins font-bold text-[20px] tracking-tight leading-none">Libraria</span>
            </div>
            <nav class="flex flex-col gap-1 p-2 mt-2 overflow-y-auto">
                <a href="/admin/dashboard" @if($active==='dashboard') aria-current="page" @endif class="flex items-center gap-2.5 px-2.5 py-2 rounded transition-colors {{ $active==='dashboard' ? 'bg-[#5694FE]/15 text-secondary dark:text-[#9CC2FF] font-semibold' : 'text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] hover:text-[#111C2D] dark:hover:text-white' }}">
                    <span class="material-symbols-outlined text-[20px]">dashboard</span><span>Dashboard</span>
                </a>
                <div class="flex flex-col pt-1">
                    <div class="flex items-center px-2.5 py-1.5 text-[#45464E] dark:text-[#9AA7C2] text-[12px] font-semibold uppercase tracking-wider">
                        <span class="material-symbols-outlined text-[20px] mr-2.5">menu_book</span><span>Koleksi</span>
                    </div>
                    <div class="pl-8 flex flex-col gap-1">
                        <a href="/admin/books" class="px-2.5 py-1.5 rounded text-[13px] transition-colors {{ $active==='books' ? 'bg-[#5694FE]/15 text-secondary dark:text-[#9CC2FF] font-semibold' : 'text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] hover:text-[#111C2D] dark:hover:text-white' }}">Semua Buku</a>
                        <a href="/admin/categories" class="px-2.5 py-1.5 rounded text-[13px] transition-colors {{ $active==='categories' ? 'bg-[#5694FE]/15 text-secondary dark:text-[#9CC2FF] font-semibold' : 'text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] hover:text-[#111C2D] dark:hover:text-white' }}">Kategori</a>
                    </div>
                </div>
                <a href="/admin/members" class="flex items-center gap-2.5 px-2.5 py-2 rounded text-[14px] transition-colors {{ $active==='members' ? 'bg-[#5694FE]/15 text-secondary dark:text-[#9CC2FF] font-semibold' : 'text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] hover:text-[#111C2D] dark:hover:text-white' }}">
                    <span class="material-symbols-outlined text-[20px]">group</span><span>Anggota</span>
                </a>
                <div class="flex flex-col pt-1">
                    <div class="flex items-center px-2.5 py-1.5 text-[#45464E] dark:text-[#9AA7C2] text-[12px] font-semibold uppercase tracking-wider">
                        <span class="material-symbols-outlined text-[20px] mr-2.5">sync_alt</span><span>Sirkulasi</span>
                    </div>
                    <div class="pl-8 flex flex-col gap-1">
                        <a href="/admin/borrowings" class="px-2.5 py-1.5 rounded text-[13px] transition-colors {{ $active==='borrowings' ? 'bg-[#5694FE]/15 text-secondary dark:text-[#9CC2FF] font-semibold' : 'text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] hover:text-[#111C2D] dark:hover:text-white' }}">Peminjaman</a>
                        <a href="/admin/returns" class="px-2.5 py-1.5 rounded text-[13px] transition-colors {{ $active==='returns' ? 'bg-[#5694FE]/15 text-secondary dark:text-[#9CC2FF] font-semibold' : 'text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] hover:text-[#111C2D] dark:hover:text-white' }}">Pengembalian</a>
                    </div>
                </div>
                <a href="/admin/reports" class="flex items-center gap-2.5 px-2.5 py-2 rounded text-[14px] transition-colors {{ $active==='reports' ? 'bg-[#5694FE]/15 text-secondary dark:text-[#9CC2FF] font-semibold' : 'text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] hover:text-[#111C2D] dark:hover:text-white' }}">
                    <span class="material-symbols-outlined text-[20px]">insert_chart</span><span>Laporan</span>
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-line dark:border-[#263252]">
            <div class="bg-[#F0F3FF] dark:bg-[#1A2440] rounded-lg p-2.5 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Panel Admin</span>
                    <span class="text-[13px] text-primary dark:text-white font-semibold">LIBRARIA</span>
                </div>
                <span class="material-symbols-outlined text-secondary text-[20px]">verified</span>
            </div>
        </div>
    </aside>

    <div class="lg:pl-[250px]">
        <header class="sticky top-0 h-16 bg-white/95 dark:bg-[#0B1326]/90 backdrop-blur-md border-b border-line dark:border-[#263252] z-40 px-4 lg:px-6 flex items-center justify-between gap-3">
            <div class="flex items-center gap-2 flex-1 min-w-0">
                <button id="sidebar-toggle" type="button" class="lg:hidden p-2 rounded-lg text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440]" aria-label="Buka menu navigasi">
                    <span class="material-symbols-outlined text-[22px]">menu</span>
                </button>
                <form action="/admin/books" method="GET" class="relative hidden sm:block w-full max-w-xl">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#75777F] text-[20px] pointer-events-none">search</span>
                    <input name="q" value="{{ request('q') }}" class="w-full h-10 pl-10 pr-4 bg-canvas dark:bg-[#131B2E] border border-line dark:border-[#263252] rounded-lg text-[13px] text-[#111C2D] dark:text-[#DAE2FD] placeholder:text-[#45464E] dark:placeholder:text-[#9AA7C2] focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/15" placeholder="Cari judul buku atau ISBN..." type="text" aria-label="Cari buku">
                </form>
            </div>
            <div class="flex items-center gap-3">
                <span class="hidden xl:flex items-center gap-2 px-3 py-1.5 rounded-full bg-[#F0F3FF] dark:bg-[#1A2440] border border-line dark:border-[#263252]" id="admin-service-status" data-open="true">
                    <span class="status-dot w-2 h-2 rounded-full bg-success animate-pulse" aria-hidden="true"></span>
                    <span class="status-text text-[12px] font-semibold text-[#45464E] dark:text-[#9AA7C2]">Buka • 08:00 - 17:00</span>
                </span>
                <a href="/admin/returns" class="relative p-2 rounded-lg text-[#45464E] dark:text-[#9AA7C2] hover:text-primary dark:hover:text-white hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440]" aria-label="Pengembalian dan keterlambatan">
                    <span class="material-symbols-outlined text-[22px]">notifications</span>
                    @if(($overdueCount ?? 0) > 0)
                        <span class="absolute top-1 right-1 flex items-center justify-center min-w-[18px] h-[18px] px-1 text-[10px] font-bold text-white bg-danger rounded-full ring-2 ring-white dark:ring-[#0B1326]" title="{{ $overdueCount }} peminjaman jatuh tempo">{{ $overdueCount }}</span>
                    @endif
                </a>
                <div class="h-6 w-px bg-line dark:bg-[#263252]"></div>
                <div class="relative" id="profile-menu-wrap">
                    <button id="profile-button" type="button" aria-haspopup="true" aria-expanded="false" aria-controls="profile-menu" class="flex items-center gap-2.5 pl-1 pr-2 py-1 rounded-xl hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] border border-transparent hover:border-line dark:hover:border-[#263252] transition-all cursor-pointer">
                        <span class="w-8 h-8 rounded-full bg-navy text-white flex items-center justify-center font-poppins font-semibold text-[13px]" aria-hidden="true">{{ strtoupper(substr($accountName, 0, 1)) }}</span>
                        <span class="hidden md:block text-[13px] font-semibold text-primary dark:text-white leading-tight max-w-[140px] truncate">{{ $accountName }}</span>
                        <span class="material-symbols-outlined text-[18px] text-[#45464E] dark:text-[#9AA7C2]" aria-hidden="true">expand_more</span>
                    </button>
                    <div id="profile-menu" hidden class="absolute right-0 top-full mt-2 w-72 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] shadow-lg z-50 overflow-hidden divide-y divide-line dark:divide-[#263252]">
                        <div class="p-4 bg-[#F0F3FF]/40 dark:bg-[#1A2440]/40">
                            <div class="font-poppins font-semibold text-[14px] text-primary dark:text-white truncate">{{ $accountName }}</div>
                            <div class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] truncate">{{ $accountEmail }}</div>
                            <div class="mt-1.5"><span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-brand/15 text-secondary dark:text-[#9CC2FF] border border-brand/20">Admin</span></div>
                        </div>
                        <div class="p-1.5 flex flex-col gap-0.5">
                            <button type="button" data-account-modal class="flex items-center gap-3 px-3 py-2 rounded-lg text-left text-[#111C2D] dark:text-[#DAE2FD] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] transition-colors cursor-pointer">
                                <span class="w-8 h-8 rounded-lg bg-brand/10 text-secondary flex items-center justify-center flex-shrink-0"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">badge</span></span>
                                <span class="flex flex-col"><span class="text-[14px] font-semibold leading-tight">Info Akun &amp; Profil</span><span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] leading-tight">Lihat identitas akun</span></span>
                            </button>
                            <button type="button" id="theme-row" class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-left text-[#111C2D] dark:text-[#DAE2FD] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] transition-colors cursor-pointer">
                                <span class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-gold/20 text-navy dark:text-gold flex items-center justify-center flex-shrink-0"><span class="material-symbols-outlined text-[18px] text-golddark dark:text-gold" aria-hidden="true">dark_mode</span></span>
                                    <span class="flex flex-col"><span class="text-[14px] font-semibold leading-tight">Ubah Tema Tampilan</span><span id="theme-status" class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] leading-tight">Mode Terang Aktif</span></span>
                                </span>
                                <span class="w-8 h-4 bg-[#D8E3FB] dark:bg-[#4F8EF7] rounded-full relative transition-colors" aria-hidden="true"><span id="theme-knob" class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full shadow-sm" style="transition: transform 0.2s;"></span></span>
                            </button>
                        </div>
                        <div class="p-1.5">
                            <form method="POST" action="/admin/logout">
                                @csrf
                                <button class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-left text-error dark:text-[#FFB4AB] hover:bg-red-50 dark:hover:bg-[#BA1A1A]/15 transition-colors cursor-pointer">
                                    <span class="w-8 h-8 rounded-lg bg-errorbox dark:bg-[#BA1A1A]/20 text-error dark:text-[#FFB4AB] flex items-center justify-center flex-shrink-0"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">logout</span></span>
                                    <span class="flex flex-col"><span class="text-[14px] font-semibold leading-tight">Keluar (Logout)</span><span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] leading-tight">Akhiri sesi kerja saat ini</span></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="p-4 lg:p-6 max-w-[1440px] mx-auto w-full">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
            @endif
            {{ $slot }}
        </main>
    </div>

    <div id="account-modal-backdrop" hidden class="fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-[100]">
        <div class="bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] rounded-2xl max-w-md w-full shadow-lg" role="dialog" aria-modal="true" aria-labelledby="account-modal-title">
            <div class="flex items-center justify-between p-4 border-b border-line dark:border-[#263252]">
                <h2 id="account-modal-title" class="font-poppins font-semibold text-[16px] text-navy dark:text-white">Info Akun</h2>
                <button type="button" id="account-modal-close" class="w-9 h-9 rounded-lg bg-[#F0F3FF] dark:bg-[#1A2440] text-[#45464E] dark:text-[#9AA7C2] hover:text-[#111C2D] dark:hover:text-white" aria-label="Tutup dialog">&times;</button>
            </div>
            <div class="p-4 space-y-3 text-[14px]">
                <div class="flex items-center gap-3">
                    <span class="w-12 h-12 rounded-full bg-navy text-white flex items-center justify-center font-poppins font-bold text-[18px]" aria-hidden="true">{{ strtoupper(substr($accountName, 0, 1)) }}</span>
                    <div>
                        <div class="font-semibold text-primary dark:text-white">{{ $accountName }}</div>
                        <div class="text-[12px] text-[#45464E] dark:text-[#9AA7C2]">{{ $accountEmail }}</div>
                    </div>
                </div>
                <dl class="grid grid-cols-3 gap-2 text-[13px]">
                    <div class="bg-[#F0F3FF] dark:bg-[#1A2440] rounded-lg p-2.5"><dt class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Peran</dt><dd class="font-semibold text-primary dark:text-white">Admin</dd></div>
                    <div class="bg-[#F0F3FF] dark:bg-[#1A2440] rounded-lg p-2.5"><dt class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Akses</dt><dd class="font-semibold text-primary dark:text-white">Penuh</dd></div>
                    <div class="bg-[#F0F3FF] dark:bg-[#1A2440] rounded-lg p-2.5"><dt class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Status</dt><dd class="font-semibold text-success">Aktif</dd></div>
                </dl>
            </div>
            <div class="p-4 border-t border-line dark:border-[#263252] text-right">
                <button type="button" id="account-modal-ok" class="px-4 py-2 rounded-lg bg-navy dark:bg-brand text-white text-[14px] font-semibold">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            /* Sidebar (mobile) */
            var toggle = document.getElementById('sidebar-toggle');
            var sidebar = document.getElementById('admin-sidebar');
            var overlay = document.getElementById('sidebar-overlay');
            function closeSidebar() {
                if (!sidebar) return;
                sidebar.classList.add('-translate-x-full');
                if (overlay) overlay.classList.add('hidden');
            }
            if (toggle && sidebar) {
                toggle.addEventListener('click', function (e) {
                    e.stopPropagation();
                    sidebar.classList.toggle('-translate-x-full');
                    if (overlay) overlay.classList.toggle('hidden');
                });
                if (overlay) overlay.addEventListener('click', closeSidebar);
            }

            /* Profile dropdown */
            var profileBtn = document.getElementById('profile-button');
            var profileMenu = document.getElementById('profile-menu');
            function menuOpen() { return !!profileMenu && profileMenu.hidden === false; }
            function openMenu() {
                if (!profileMenu || !profileBtn) return;
                profileMenu.hidden = false;
                profileBtn.setAttribute('aria-expanded', 'true');
            }
            function closeMenu() {
                if (!profileMenu || !profileBtn) return;
                profileMenu.hidden = true;
                profileBtn.setAttribute('aria-expanded', 'false');
            }
            if (profileBtn && profileMenu) {
                profileBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    if (menuOpen()) closeMenu();
                    else openMenu();
                });
                document.addEventListener('click', function (e) {
                    if (menuOpen() && !profileMenu.contains(e.target) && !profileBtn.contains(e.target)) closeMenu();
                });
            }

            /* Theme */
            var themeRow = document.getElementById('theme-row');
            var themeStatus = document.getElementById('theme-status');
            var themeKnob = document.getElementById('theme-knob');
            function isDark() { return document.documentElement.classList.contains('dark'); }
            function renderTheme() {
                if (themeStatus) themeStatus.textContent = isDark() ? 'Mode Gelap Aktif' : 'Mode Terang Aktif';
                if (themeKnob) themeKnob.style.transform = isDark() ? 'translateX(16px)' : 'none';
            }
            function setTheme(dark) {
                document.documentElement.classList.toggle('dark', dark);
                try { localStorage.setItem('libraria-admin-theme', dark ? 'dark' : 'light'); } catch (e) {}
                renderTheme();
            }
            renderTheme();
            if (themeRow) themeRow.addEventListener('click', function () { setTheme(!isDark()); });

            /* Account modal */
            var backdrop = document.getElementById('account-modal-backdrop');
            var lastFocused = null;
            function openAccountModal() {
                if (!backdrop) return;
                lastFocused = document.activeElement;
                closeMenu();
                backdrop.hidden = false;
                var ok = document.getElementById('account-modal-ok');
                if (ok) ok.focus();
            }
            function closeAccountModal() {
                if (!backdrop || backdrop.hidden) return;
                backdrop.hidden = true;
                if (lastFocused && typeof lastFocused.focus === 'function') lastFocused.focus();
            }
            window.closeAccountModal = closeAccountModal;
            document.addEventListener('click', function (e) {
                var opener = e.target.closest ? e.target.closest('[data-account-modal]') : null;
                if (opener) { openAccountModal(); return; }
                if (e.target === backdrop) closeAccountModal();
            });
            ['account-modal-close', 'account-modal-ok'].forEach(function (id) {
                var b = document.getElementById(id);
                if (b) b.addEventListener('click', closeAccountModal);
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeAccountModal();
                    if (menuOpen()) { closeMenu(); if (profileBtn) profileBtn.focus(); }
                    else closeSidebar();
                }
            });

            /* Service status follows device clock (08:00-17:00) */
            var status = document.getElementById('admin-service-status');
            function tick() {
                if (!status) return;
                var d = new Date();
                var mins = d.getHours() * 60 + d.getMinutes();
                var open = mins >= 480 && mins < 1020;
                status.setAttribute('data-open', open ? 'true' : 'false');
                var dot = status.querySelector('.status-dot');
                var txt = status.querySelector('.status-text');
                if (dot) {
                    dot.classList.toggle('bg-success', open);
                    dot.classList.toggle('bg-warning', !open);
                }
                if (txt) txt.textContent = open ? 'Buka • 08:00 - 17:00' : 'Tutup • 08:00 - 17:00';
            }
            tick();
            window.setInterval(tick, 60000);
        })();
    </script>
    <livewire:scripts />
</body>
</html>
