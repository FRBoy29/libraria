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
    <header class="sticky top-0 z-40 bg-white/95 dark:bg-[#0B1326]/90 backdrop-blur-md border-b border-line dark:border-[#263252] px-4 lg:px-6">
        <div class="h-16 flex items-center justify-between gap-3">
            <div class="flex items-center gap-2 flex-1 min-w-0">
                <button id="member-nav-toggle" type="button" class="lg:hidden p-2 rounded-lg text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440]" aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="member-nav">
                    <span class="material-symbols-outlined text-[22px]" aria-hidden="true">menu</span>
                </button>
                <a href="/member/dashboard" class="flex items-center gap-2.5 flex-shrink-0">
                    <img src="{{ asset('assets/logo/libraria-mark.svg') }}" alt="Logo LIBRARIA" class="w-8 h-8 rounded-lg">
                    <span class="hidden sm:flex flex-col leading-none">
                        <span class="font-poppins font-bold text-[1.15rem] text-navy dark:text-white tracking-tight">Libraria</span>
                        <span class="text-[10px] uppercase tracking-widest text-[#8A5A1D] dark:text-[#e3c290] mt-0.5">Member</span>
                    </span>
                </a>
                <form action="/member/books" method="GET" class="relative hidden sm:block w-full max-w-xl ml-2">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#75777F] dark:text-[#8c909e] text-[20px] pointer-events-none" aria-hidden="true">search</span>
                    <input name="q" value="{{ request('q') }}" type="text" aria-label="Cari katalog" class="w-full h-10 pl-10 pr-4 bg-canvas dark:bg-[#131B2E] border border-line dark:border-[#263252] rounded-lg text-[13px] text-[#111C2D] dark:text-[#DAE2FD] placeholder:text-[#45464E] dark:placeholder:text-[#9AA7C2] focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/15" placeholder="Cari judul buku atau penulis...">
                </form>
            </div>
            <div class="flex items-center gap-3">
                <span class="hidden xl:flex items-center gap-2 px-3 py-1.5 rounded-full bg-[#F0F3FF] dark:bg-[#1A2440] border border-line dark:border-[#263252]" id="member-service-status" data-open="true">
                    <span class="status-dot w-2 h-2 rounded-full bg-success animate-pulse" aria-hidden="true"></span>
                    <span class="status-text text-[12px] font-semibold text-[#45464E] dark:text-[#9AA7C2]">Jam Operasional 08:00 - 17:00</span>
                </span>
                <a href="/member/borrowings" class="relative p-2 rounded-lg text-[#45464E] dark:text-[#9AA7C2] hover:text-primary dark:hover:text-white hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440]" aria-label="Status peminjaman saya">
                    <span class="material-symbols-outlined text-[22px]" aria-hidden="true">notifications</span>
                    @if($overdueCount > 0)
                        <span class="absolute top-1 right-1 flex items-center justify-center min-w-[18px] h-[18px] px-1 text-[10px] font-bold text-white bg-danger rounded-full ring-2 ring-white dark:ring-[#0B1326]" title="{{ $overdueCount }} peminjaman terlambat">{{ $overdueCount }}</span>
                    @endif
                </a>
                <div class="h-6 w-px bg-line dark:bg-[#263252]"></div>
                <div class="relative" id="member-profile-wrap">
                    <button id="member-profile-button" type="button" aria-haspopup="true" aria-expanded="false" aria-controls="member-profile-menu" class="flex items-center gap-2.5 pl-1 pr-2 py-1 rounded-xl hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] border border-transparent hover:border-line dark:hover:border-[#263252] transition-all cursor-pointer">
                        <span class="w-8 h-8 rounded-full bg-navy text-white flex items-center justify-center font-poppins font-semibold text-[13px]" aria-hidden="true">{{ strtoupper(substr($m?->name ?? 'M', 0, 1)) }}</span>
                        <span class="hidden md:block text-[13px] font-semibold text-primary dark:text-white leading-tight max-w-[140px] truncate">{{ $m?->name ?? '' }}</span>
                        <span class="material-symbols-outlined text-[18px] text-[#45464E] dark:text-[#9AA7C2]" aria-hidden="true">expand_more</span>
                    </button>
                    <div id="member-profile-menu" hidden class="absolute right-0 top-full mt-2 w-72 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] shadow-lg z-50 overflow-hidden divide-y divide-line dark:divide-[#263252]">
                        <div class="p-4 bg-[#F0F3FF]/40 dark:bg-[#1A2440]/40 flex items-center gap-3">
                            <span class="w-10 h-10 rounded-full bg-navy text-white flex items-center justify-center font-poppins font-semibold text-[15px] flex-shrink-0" aria-hidden="true">{{ strtoupper(substr($m?->name ?? 'M', 0, 1)) }}</span>
                            <div class="min-w-0">
                                <div class="font-poppins font-semibold text-[14px] text-primary dark:text-white truncate">{{ $m?->name ?? '' }}</div>
                                <div class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] truncate">{{ $m?->member_code ?? '' }} • {{ $m?->email ?? '' }}</div>
                                <div class="mt-1"><span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-brand/15 text-secondary dark:text-[#9CC2FF] border border-brand/20">Member</span></div>
                            </div>
                        </div>
                        <div class="p-1.5 flex flex-col gap-0.5">
                            <a href="/member/profile" class="flex items-center gap-3 px-3 py-2 rounded-lg text-left text-[#111C2D] dark:text-[#DAE2FD] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] transition-colors cursor-pointer">
                                <span class="w-8 h-8 rounded-lg bg-brand/10 text-secondary flex items-center justify-center flex-shrink-0"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">badge</span></span>
                                <span class="flex flex-col"><span class="text-[14px] font-semibold leading-tight">Info Akun &amp; Profil</span><span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] leading-tight">Ubah email, telepon &amp; kata sandi</span></span>
                            </a>
                            <button type="button" id="member-theme-row" class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-left text-[#111C2D] dark:text-[#DAE2FD] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] transition-colors cursor-pointer">
                                <span class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-lg bg-gold/20 text-navy dark:text-gold flex items-center justify-center flex-shrink-0"><span class="material-symbols-outlined text-[18px] text-golddark dark:text-gold" aria-hidden="true">dark_mode</span></span>
                                    <span class="flex flex-col"><span class="text-[14px] font-semibold leading-tight">Ubah Tema Tampilan</span><span id="member-theme-status" class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] leading-tight">Mode Terang Aktif</span></span>
                                </span>
                                <span class="w-8 h-4 bg-[#D8E3FB] dark:bg-[#4F8EF7] rounded-full relative transition-colors" aria-hidden="true"><span id="member-theme-knob" class="absolute top-0.5 left-0.5 w-3 h-3 bg-white rounded-full shadow-sm" style="transition: transform 0.2s;"></span></span>
                            </button>
                        </div>
                        <div class="p-1.5">
                            <form method="POST" action="/member/logout">
                                @csrf
                                <button class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-left text-error dark:text-[#FFB4AB] hover:bg-red-50 dark:hover:bg-[#BA1A1A]/15 transition-colors cursor-pointer">
                                    <span class="w-8 h-8 rounded-lg bg-errorbox dark:bg-[#BA1A1A]/20 text-error dark:text-[#FFB4AB] flex items-center justify-center flex-shrink-0"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">logout</span></span>
                                    <span class="flex flex-col"><span class="text-[14px] font-semibold leading-tight">Keluar (Logout)</span><span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] leading-tight">Akhiri sesi peminjaman saat ini</span></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Navigasi member --}}
        <nav id="member-nav" class="flex items-center gap-1 pb-2 overflow-x-auto" aria-label="Navigasi member">
            @php($links = ['dashboard' => 'Dashboard', 'books' => 'Katalog', 'borrowings' => 'Pinjaman Saya', 'history' => 'Riwayat', 'profile' => 'Profil'])
            @foreach($links as $key => $label)
                <a href="/member/{{ $key }}" @if($nav === $key) aria-current="page" @endif class="px-3 py-2 rounded-lg text-[13px] font-medium whitespace-nowrap transition-colors {{ $nav === $key ? 'bg-brand/10 text-[#005BBF] dark:bg-[#508ff8]/20 dark:text-[#9CC2FF]' : 'text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] hover:text-[#111C2D] dark:hover:text-white' }}">{{ $label }}</a>
            @endforeach
        </nav>
    </header>

    <main class="max-w-[1440px] mx-auto px-4 lg:px-6 py-6">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
        @endif
        {{ $slot }}
    </main>

    <footer class="max-w-[1440px] mx-auto px-4 lg:px-6 py-5 flex flex-col sm:flex-row items-center justify-between gap-2 text-[12px] text-[#45464E] dark:text-[#9AA7C2] border-t border-line dark:border-[#263252]">
        <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px] text-[#8A5A1D] dark:text-[#e3c290]" aria-hidden="true">verified_user</span><span>Sistem Informasi Perpustakaan</span></span>
        <span>© 2026 LIBRARIA. Hak Cipta Dilindungi.</span>
    </footer>

    <script>
        (function () {
            /* Navigasi mobile */
            var navBtn = document.getElementById('member-nav-toggle');
            var nav = document.getElementById('member-nav');
            if (navBtn && nav) {
                navBtn.addEventListener('click', function () {
                    var hidden = nav.classList.toggle('hidden');
                    navBtn.setAttribute('aria-expanded', hidden ? 'false' : 'true');
                });
                if (window.matchMedia('(min-width: 1024px)').matches) nav.classList.remove('hidden');
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
            var themeKnob = document.getElementById('member-theme-knob');
            function isDark() { return document.documentElement.classList.contains('dark'); }
            function renderTheme() {
                if (themeStatus) themeStatus.textContent = isDark() ? 'Mode Gelap Aktif' : 'Mode Terang Aktif';
                if (themeKnob) themeKnob.style.transform = isDark() ? 'translateX(16px)' : 'none';
            }
            function setTheme(dark) {
                document.documentElement.classList.toggle('dark', dark);
                try { localStorage.setItem('libraria-member-theme', dark ? 'dark' : 'light'); } catch (e) {}
                renderTheme();
            }
            renderTheme();
            if (themeRow) themeRow.addEventListener('click', function () { setTheme(!isDark()); });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && isOpen()) { close(); if (btn) btn.focus(); }
            });

            /* Jam operasional mengikuti jam perangkat */
            var status = document.getElementById('member-service-status');
            function tick() {
                if (!status) return;
                var d = new Date();
                var mins = d.getHours() * 60 + d.getMinutes();
                var isOpenNow = mins >= 480 && mins < 1020;
                var dot = status.querySelector('.status-dot');
                var txt = status.querySelector('.status-text');
                if (dot) { dot.classList.toggle('bg-success', isOpenNow); dot.classList.toggle('bg-warning', !isOpenNow); }
                if (txt) txt.textContent = isOpenNow ? 'Jam Operasional 08:00 - 17:00' : 'Di Luar Jam Operasional';
            }
            tick();
            window.setInterval(tick, 60000);
        })();
    </script>
    <livewire:scripts />
</body>
</html>