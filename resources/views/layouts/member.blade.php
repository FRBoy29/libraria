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
<body class="bg-canvas dark:bg-[#0b1326] font-inter text-[14px] text-[#111C2D] dark:text-[#dae2fd] antialiased">
    @php($m = auth('member')->user())
    @php($nav = $nav ?? 'dashboard')
    <header class="sticky top-0 z-40 bg-white/95 dark:bg-[#060e20]/90 backdrop-blur-md border-b border-[#E2E8F0] dark:border-[#263252]">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 h-16 flex items-center gap-4">
            <a href="/member/dashboard" class="flex items-center gap-2.5 flex-shrink-0">
                <img src="{{ asset('assets/logo/libraria-mark.svg') }}" alt="Logo LIBRARIA" class="w-8 h-8 rounded-lg">
                <span class="flex flex-col leading-none">
                    <span class="font-poppins font-bold text-[1.15rem] text-navy dark:text-white tracking-tight">Libraria</span>
                    <span class="text-[10px] uppercase tracking-widest text-[#8A5A1D] dark:text-[#e3c290] mt-0.5">Member</span>
                </span>
            </a>
            <nav class="hidden md:flex items-center gap-1 ml-4" aria-label="Navigasi member">
                @php($links = ['dashboard' => 'Dashboard', 'books' => 'Katalog', 'borrowings' => 'Pinjaman Saya', 'history' => 'Riwayat', 'profile' => 'Profil'])
                @foreach($links as $key => $label)
                    <a href="/member/{{ $key }}" @if($nav === $key) aria-current="page" @endif class="px-3 py-2 rounded-lg text-[13px] font-medium transition-colors {{ $nav === $key ? 'bg-brand/10 text-[#005BBF] dark:bg-[#508ff8]/20 dark:text-[#9CC2FF]' : 'text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] hover:text-[#111C2D] dark:hover:text-white' }}">{{ $label }}</a>
                @endforeach
            </nav>
            <span class="flex-1"></span>
            <span id="member-service-status" data-open="true" class="hidden xl:flex items-center gap-2 px-3 py-1.5 rounded-full bg-[#F0F3FF] dark:bg-[#1A2440] border border-[#E2E8F0] dark:border-[#263252]">
                <span class="status-dot w-2 h-2 rounded-full bg-success animate-pulse" aria-hidden="true"></span>
                <span class="status-text text-[12px] font-semibold text-[#45464E] dark:text-[#9AA7C2]">Buka • 08:00 - 17:00</span>
            </span>
            <button id="member-theme-toggle" type="button" aria-label="Alihkan mode terang dan gelap" aria-pressed="false" title="Alihkan tema" class="w-9 h-9 rounded-lg bg-[#F0F3FF] dark:bg-[#1A2440] border border-[#E2E8F0] dark:border-[#263252] text-[#45464E] dark:text-[#9AA7C2] hover:text-primary dark:hover:text-white flex items-center justify-center">
                <span class="material-symbols-outlined text-[20px]" aria-hidden="true">dark_mode</span>
            </button>
            <div class="flex items-center gap-2 pl-2 border-l border-[#E2E8F0] dark:border-[#263252]">
                <span class="w-8 h-8 rounded-full bg-navy text-white flex items-center justify-center font-poppins font-semibold text-[13px]" aria-hidden="true">{{ strtoupper(substr($m?->name ?? 'M', 0, 1)) }}</span>
                <span class="hidden sm:block text-[13px] font-semibold text-primary dark:text-white max-w-[120px] truncate">{{ $m?->member_code ?? '' }}</span>
                <form method="POST" action="/member/logout">
                    @csrf
                    <button class="p-2 rounded-lg text-[#45464E] dark:text-[#9AA7C2] hover:text-error hover:bg-red-50 dark:hover:bg-[#BA1A1A]/15" title="Keluar" aria-label="Keluar">
                        <span class="material-symbols-outlined text-[20px]" aria-hidden="true">logout</span>
                    </button>
                </form>
            </div>
        </div>
        <nav class="md:hidden px-4 pb-3 flex items-center gap-1 overflow-x-auto" aria-label="Navigasi member mobile">
            @foreach($links as $key => $label)
                <a href="/member/{{ $key }}" class="px-3 py-1.5 rounded-lg text-[12px] font-medium whitespace-nowrap {{ $nav === $key ? 'bg-brand/10 text-[#005BBF] dark:bg-[#508ff8]/20 dark:text-[#9CC2FF]' : 'text-[#45464E] dark:text-[#9AA7C2]' }}">{{ $label }}</a>
            @endforeach
        </nav>
    </header>

    <main class="max-w-7xl mx-auto px-4 lg:px-8 py-6">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-2 rounded-lg mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-2 rounded-lg mb-4">{{ session('error') }}</div>
        @endif
        {{ $slot }}
    </main>

    <footer class="border-t border-[#E2E8F0] dark:border-[#263252] mt-8">
        <div class="max-w-7xl mx-auto px-4 lg:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-2 text-[12px] text-[#45464E] dark:text-[#9AA7C2]">
            <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px] text-[#8A5A1D] dark:text-[#e3c290]" aria-hidden="true">verified_user</span><span>Sistem Informasi Perpustakaan</span></span>
            <span>© 2026 LIBRARIA. Hak Cipta Dilindungi.</span>
        </div>
    </footer>

    <script>
        (function () {
            var btn = document.getElementById('member-theme-toggle');
            function isDark() { return document.documentElement.classList.contains('dark'); }
            function render() {
                var icon = btn && btn.querySelector('.material-symbols-outlined');
                if (icon) icon.textContent = isDark() ? 'light_mode' : 'dark_mode';
                if (btn) btn.setAttribute('aria-pressed', isDark() ? 'true' : 'false');
            }
            if (btn) {
                render();
                btn.addEventListener('click', function () {
                    var dark = !isDark();
                    document.documentElement.classList.toggle('dark', dark);
                    try { localStorage.setItem('libraria-member-theme', dark ? 'dark' : 'light'); } catch (e) {}
                    render();
                });
            }
            var status = document.getElementById('member-service-status');
            function tick() {
                if (!status) return;
                var d = new Date();
                var mins = d.getHours() * 60 + d.getMinutes();
                var open = mins >= 480 && mins < 1020;
                var dot = status.querySelector('.status-dot');
                var txt = status.querySelector('.status-text');
                if (dot) { dot.classList.toggle('bg-success', open); dot.classList.toggle('bg-warning', !open); }
                if (txt) txt.textContent = open ? 'Buka • 08:00 - 17:00' : 'Tutup • 08:00 - 17:00';
            }
            tick();
            window.setInterval(tick, 60000);
        })();
    </script>
    <livewire:scripts />
</body>
</html>