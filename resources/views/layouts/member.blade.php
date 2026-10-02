<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBRARIA Member</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@600;700&family=Inter:wght@400;500;600&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:FILL,GRAD,opsz,wght@0..1,-50..200,20..48,100..700" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: "class" };
        try {
            if (localStorage.getItem("libraria-member-theme") === "dark") {
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
    @php($m = auth('member')->user())
    @php($nav = $nav ?? 'dashboard')
    @php($overdueCount = $overdueCount ?? 0)
    @php($memberLinks = ['dashboard' => 'Dashboard', 'books' => 'Katalog Buku', 'borrowings' => 'Pinjaman Saya', 'history' => 'Riwayat', 'profile' => 'Profil'])
    @php($memberIcons = ['dashboard' => 'dashboard', 'books' => 'menu_book', 'borrowings' => 'book_online', 'history' => 'history', 'profile' => 'badge'])

    <div id="member-overlay" class="hidden fixed inset-0 bg-black/40 z-40 lg:hidden"></div>
    <aside id="member-sidebar" class="fixed left-0 top-0 h-full w-[250px] bg-white dark:bg-[#131B2E] border-r border-line dark:border-[#263252] z-50 flex flex-col justify-between -translate-x-full lg:translate-x-0 transition-transform duration-200">
        <div class="flex flex-col min-h-0">
            <div class="h-16 px-4 flex items-center gap-2.5 border-b border-line dark:border-[#263252] shrink-0">
                <span class="w-9 h-9 rounded-xl bg-brand/15 dark:bg-[#508ff8]/20 text-brand dark:text-[#9CC2FF] flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[20px]" aria-hidden="true">local_library</span>
                </span>
                <div class="flex flex-col min-w-0">
                    <div class="flex items-center gap-1.5">
                        <span class="font-poppins font-semibold text-[1.05rem] text-navy dark:text-white tracking-tight">Libraria</span>
                        <span class="px-1.5 py-0.5 rounded-full bg-gold/20 text-[#8A5A1D] dark:text-[#e3c290] text-[10px] uppercase tracking-wider font-semibold">Patron</span>
                    </div>
                    <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Member Area</span>
                </div>
            </div>
            <nav class="flex flex-col gap-1 p-2 mt-2 overflow-y-auto" aria-label="Navigasi member">
                @foreach($memberLinks as $key => $label)
                    <a href="/member/{{ $key }}" @if($nav === $key) aria-current="page" @endif class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-[13px] transition-all {{ $nav === $key ? 'bg-brand/15 dark:bg-[#508ff8]/20 text-[#005BBF] dark:text-[#9CC2FF] font-semibold' : 'text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] hover:text-[#111C2D] dark:hover:text-white' }}">
                        <span class="material-symbols-outlined text-[20px]" aria-hidden="true">{{ $memberIcons[$key] }}</span><span>{{ $label }}</span>
                    </a>
                @endforeach
            </nav>
        </div>
        <div class="p-4 border-t border-line dark:border-[#263252] flex flex-col gap-3">
            <div class="bg-[#F0F3FF] dark:bg-[#1A2440] rounded-xl p-3 flex flex-col gap-1">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wider">Kartu Anggota</span>
                    <span class="px-1.5 py-0.5 rounded-full text-[10px] font-semibold {{ $m?->status === 'active' ? 'bg-success/15 text-success' : 'bg-danger/15 text-danger' }}">{{ $m ? ucfirst($m->status) : '-' }}</span>
                </div>
                <span class="text-[13px] font-mono text-secondary dark:text-[#9CC2FF] font-medium tracking-wide">{{ $m?->member_code ?? '-' }}</span>
                <span class="text-[11px] text-[#75777F] dark:text-[#8c909e]">Berlaku s/d {{ $m?->active_until ? \Carbon\Carbon::parse($m->active_until)->format('M Y') : '—' }}</span>
            </div>
            <div class="flex items-center justify-between px-1 text-[#45464E] dark:text-[#9AA7C2]">
                <a href="/member/books" class="flex items-center gap-1.5 text-[12px] hover:text-primary dark:hover:text-white transition-colors"><span class="material-symbols-outlined text-[16px]" aria-hidden="true">help</span><span>Pusat Bantuan</span></a>
                <span class="text-[11px] text-[#75777F] dark:text-[#8c909e]">LIBRARIA</span>
            </div>
        </div>
    </aside>

    <div class="lg:pl-[250px]">
        <header class="sticky top-0 z-40 bg-white/95 dark:bg-[#0B1326]/90 backdrop-blur-md border-b border-line dark:border-[#263252] px-4 lg:px-6">
            <div class="h-16 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <button id="member-nav-toggle" type="button" class="lg:hidden p-2 rounded-lg text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440]" aria-label="Buka menu navigasi">
                        <span class="material-symbols-outlined text-[22px]" aria-hidden="true">menu</span>
                    </button>
                    <form action="/member/books" method="GET" class="relative hidden sm:block w-80">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#75777F] dark:text-[#8c909e] text-[20px] pointer-events-none" aria-hidden="true">search</span>
                        <input name="q" value="{{ request('q') }}" type="text" aria-label="Cari katalog" class="w-full h-10 pl-10 pr-3 rounded-lg bg-[#F0F3FF] dark:bg-[#131B2E] border border-transparent focus:border-secondary focus:ring-2 focus:ring-secondary/15 text-[13px] text-[#111C2D] dark:text-[#DAE2FD] placeholder:text-[#75777F] dark:placeholder:text-[#8c909e]" placeholder="Cari koleksi buku, pengarang, ISBN...">
                    </form>
                    <span class="hidden xl:flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-[#F0F3FF] dark:bg-[#1A2440] border border-line dark:border-[#263252]" id="member-service-status" data-open="true">
                        <span class="status-dot w-2 h-2 rounded-full bg-success animate-pulse" aria-hidden="true"></span>
                        <span class="status-label text-[12px] font-medium text-navy dark:text-white">Perpustakaan Buka</span>
                        <span class="status-sep text-[#75777F] dark:text-[#8c909e] text-[12px]">•</span>
                        <span class="status-text text-[12px] text-[#45464E] dark:text-[#9AA7C2]">Jam Layanan 08:00 - 17:00</span>
                    </span>
                </div>
                <div class="flex items-center gap-3">
                    <a href="/member/borrowings" class="relative p-2 rounded-lg text-[#45464E] dark:text-[#9AA7C2] hover:text-primary dark:hover:text-white hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440]" aria-label="Status peminjaman saya">
                        <span class="material-symbols-outlined text-[22px]" aria-hidden="true">notifications</span>
                        @if($overdueCount > 0)
                            <span class="absolute top-1 right-1 flex items-center justify-center min-w-[18px] h-[18px] px-1 text-[10px] font-bold text-white bg-danger rounded-full ring-2 ring-white dark:ring-[#0B1326]">{{ $overdueCount }}</span>
                        @endif
                    </a>
                    <div class="h-6 w-px bg-line dark:bg-[#263252]"></div>
                    <div class="relative" id="member-profile-wrap">
                        <button id="member-profile-button" type="button" aria-haspopup="true" aria-expanded="false" aria-controls="member-profile-menu" class="flex items-center gap-2.5 p-1.5 rounded-xl hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] transition-colors cursor-pointer">
                            <span class="w-8 h-8 rounded-full bg-navy text-white flex items-center justify-center font-poppins font-semibold text-[13px]" aria-hidden="true">{{ strtoupper(substr($m?->name ?? 'M', 0, 1)) }}</span>
                            <span class="hidden md:flex flex-col text-left leading-tight">
                                <span class="text-[12px] font-semibold text-navy dark:text-white max-w-[140px] truncate">{{ $m?->name ?? '' }}</span>
                                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">{{ $m?->member_code ?? '' }}</span>
                            </span>
                            <span class="material-symbols-outlined text-[18px] text-[#75777F] dark:text-[#8c909e]" aria-hidden="true">expand_more</span>
                        </button>
                        <div id="member-profile-menu" hidden class="absolute right-0 top-full mt-2 w-64 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] shadow-lg z-50 p-1 flex flex-col gap-0.5">
                            <div class="px-3 py-2">
                                <div class="text-[12px] font-semibold text-navy dark:text-white truncate">{{ $m?->name ?? '' }}</div>
                                <div class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] truncate">{{ $m?->email ?? '' }}</div>
                            </div>
                            <div class="h-px bg-line dark:bg-[#263252] my-0.5"></div>
                            <a href="/member/profile" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[12px] text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] hover:text-navy dark:hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-[18px]" aria-hidden="true">badge</span><span>Profil Saya</span>
                            </a>
                            <button type="button" id="member-theme-row" class="flex items-center justify-between px-3 py-2 rounded-lg text-[12px] text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] hover:text-navy dark:hover:text-white transition-colors cursor-pointer">
                                <span class="flex items-center gap-2.5"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">dark_mode</span><span>Atur Tema</span></span>
                                <span class="text-[11px] px-1.5 py-0.5 rounded bg-[#E7EEFF] dark:bg-[#263252] text-navy dark:text-[#DAE2FD]" id="member-theme-status">Terang</span>
                            </button>
                            <div class="h-px bg-line dark:bg-[#263252] my-0.5"></div>
                            <form method="POST" action="/member/logout">
                                @csrf
                                <button class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-[12px] text-error dark:text-[#FFB4AB] hover:bg-red-50 dark:hover:bg-[#BA1A1A]/15 transition-colors cursor-pointer">
                                    <span class="material-symbols-outlined text-[18px]" aria-hidden="true">logout</span><span>Keluar / Logout</span>
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

    <script>
        (function () {
            /* Sidebar mobile */
            var navBtn = document.getElementById('member-nav-toggle');
            var sidebar = document.getElementById('member-sidebar');
            var overlay = document.getElementById('member-overlay');
            function closeSidebar() {
                if (!sidebar) return;
                sidebar.classList.add('-translate-x-full');
                if (overlay) overlay.classList.add('hidden');
            }
            if (navBtn && sidebar) {
                navBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    sidebar.classList.toggle('-translate-x-full');
                    if (overlay) overlay.classList.toggle('hidden');
                });
                if (overlay) overlay.addEventListener('click', closeSidebar);
            }

            /* Dropdown akun */
            var btn = document.getElementById('member-profile-button');
            var menu = document.getElementById('member-profile-menu');
            function open() { if (!menu || !btn) return; menu.hidden = false; btn.setAttribute('aria-expanded', 'true'); }
            function close() { if (!menu || !btn) return; menu.hidden = true; btn.setAttribute('aria-expanded', 'false'); }
            function isOpen() { return !!menu && menu.hidden === false; }
            if (btn && menu) {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    if (isOpen()) close(); else open();
                });
                document.addEventListener('click', function (e) {
                    if (isOpen() && !menu.contains(e.target) && !btn.contains(e.target)) close();
                });
            }

            /* Tema */
            var themeRow = document.getElementById('member-theme-row');
            var themeStatus = document.getElementById('member-theme-status');
            function isDark() { return document.documentElement.classList.contains('dark'); }
            function renderTheme() { if (themeStatus) themeStatus.textContent = isDark() ? 'Gelap' : 'Terang'; }
            function setTheme(dark) {
                document.documentElement.classList.toggle('dark', dark);
                try { localStorage.setItem('libraria-member-theme', dark ? 'dark' : 'light'); } catch (e) {}
                renderTheme();
            }
            renderTheme();
            if (themeRow) themeRow.addEventListener('click', function () { setTheme(!isDark()); });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    if (isOpen()) { close(); if (btn) btn.focus(); } else { closeSidebar(); }
                }
            });

            /* Jam layanan mengikuti jam perangkat */
            var status = document.getElementById('member-service-status');
            function tick() {
                if (!status) return;
                var d = new Date();
                var mins = d.getHours() * 60 + d.getMinutes();
                var open = mins >= 480 && mins < 1020;
                var dot = status.querySelector('.status-dot');
                var label = status.querySelector('.status-label');
                var txt = status.querySelector('.status-text');
                if (dot) { dot.classList.toggle('bg-success', open); dot.classList.toggle('bg-warning', !open); }
                if (label) label.textContent = open ? 'Perpustakaan Buka' : 'Perpustakaan Tutup';
                if (txt) txt.textContent = 'Jam Layanan 08:00 - 17:00';
            }
            tick();
            window.setInterval(tick, 60000);
        })();
    </script>
    <livewire:scripts />
</body>
</html>