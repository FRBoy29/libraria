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
<body class="bg-canvas font-inter text-[14px] text-[#111C2D] antialiased">
    @php($active = $active ?? 'dashboard')
    <div id="sidebar-overlay" class="hidden fixed inset-0 bg-black/40 z-40 lg:hidden"></div>
    <aside id="admin-sidebar" class="fixed left-0 top-0 h-full w-[250px] bg-white border-r border-line z-50 flex flex-col justify-between -translate-x-full lg:translate-x-0 transition-transform duration-200">
        <div class="flex flex-col min-h-0">
            <div class="h-16 px-6 flex items-center gap-2.5 border-b border-line shrink-0">
                <img src="{{ asset('assets/logo/libraria-mark.svg') }}" alt="Logo LIBRARIA" class="h-8 w-8 object-contain">
                <span class="text-navy font-poppins font-bold text-[20px] tracking-tight leading-none">Libraria</span>
            </div>
            <nav class="flex flex-col gap-1 p-2 mt-2 overflow-y-auto">
                <a href="/admin/dashboard" @if($active==='dashboard') aria-current="page" @endif class="flex items-center gap-2.5 px-2.5 py-2 rounded transition-colors {{ $active==='dashboard' ? 'bg-[#5694FE]/15 text-secondary font-semibold' : 'text-[#45464E] hover:bg-[#F0F3FF] hover:text-[#111C2D]' }}">
                    <span class="material-symbols-outlined text-[20px]">dashboard</span><span>Dashboard</span>
                </a>
                <div class="flex flex-col pt-1">
                    <div class="flex items-center px-2.5 py-1.5 text-[#45464E] text-[12px] font-semibold uppercase tracking-wider">
                        <span class="material-symbols-outlined text-[20px] mr-2.5">menu_book</span><span>Koleksi</span>
                    </div>
                    <div class="pl-8 flex flex-col gap-1">
                        <a href="/admin/books" class="px-2.5 py-1.5 rounded text-[13px] transition-colors {{ $active==='books' ? 'bg-[#5694FE]/15 text-secondary font-semibold' : 'text-[#45464E] hover:bg-[#F0F3FF] hover:text-[#111C2D]' }}">Semua Buku</a>
                        <a href="/admin/categories" class="px-2.5 py-1.5 rounded text-[13px] transition-colors {{ $active==='categories' ? 'bg-[#5694FE]/15 text-secondary font-semibold' : 'text-[#45464E] hover:bg-[#F0F3FF] hover:text-[#111C2D]' }}">Kategori</a>
                    </div>
                </div>
                <a href="/admin/members" class="flex items-center gap-2.5 px-2.5 py-2 rounded text-[14px] transition-colors {{ $active==='members' ? 'bg-[#5694FE]/15 text-secondary font-semibold' : 'text-[#45464E] hover:bg-[#F0F3FF] hover:text-[#111C2D]' }}">
                    <span class="material-symbols-outlined text-[20px]">group</span><span>Anggota</span>
                </a>
                <div class="flex flex-col pt-1">
                    <div class="flex items-center px-2.5 py-1.5 text-[#45464E] text-[12px] font-semibold uppercase tracking-wider">
                        <span class="material-symbols-outlined text-[20px] mr-2.5">sync_alt</span><span>Sirkulasi</span>
                    </div>
                    <div class="pl-8 flex flex-col gap-1">
                        <a href="/admin/borrowings" class="px-2.5 py-1.5 rounded text-[13px] transition-colors {{ $active==='borrowings' ? 'bg-[#5694FE]/15 text-secondary font-semibold' : 'text-[#45464E] hover:bg-[#F0F3FF] hover:text-[#111C2D]' }}">Peminjaman</a>
                        <a href="/admin/returns" class="px-2.5 py-1.5 rounded text-[13px] transition-colors {{ $active==='returns' ? 'bg-[#5694FE]/15 text-secondary font-semibold' : 'text-[#45464E] hover:bg-[#F0F3FF] hover:text-[#111C2D]' }}">Pengembalian</a>
                    </div>
                </div>
                <a href="/admin/reports" class="flex items-center gap-2.5 px-2.5 py-2 rounded text-[14px] transition-colors {{ $active==='reports' ? 'bg-[#5694FE]/15 text-secondary font-semibold' : 'text-[#45464E] hover:bg-[#F0F3FF] hover:text-[#111C2D]' }}">
                    <span class="material-symbols-outlined text-[20px]">insert_chart</span><span>Laporan</span>
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-line">
            <div class="bg-[#F0F3FF] rounded-lg p-2.5 flex items-center justify-between">
                <div class="flex flex-col">
                    <span class="text-[11px] text-[#45464E]">Panel Admin</span>
                    <span class="text-[13px] text-primary font-semibold">LIBRARIA</span>
                </div>
                <span class="material-symbols-outlined text-secondary text-[20px]">verified</span>
            </div>
        </div>
    </aside>

    <div class="lg:pl-[250px]">
        <header class="sticky top-0 h-16 bg-white/95 backdrop-blur-md border-b border-line z-40 px-4 lg:px-6 flex items-center justify-between gap-3">
            <div class="flex items-center gap-2 flex-1 min-w-0">
                <button id="sidebar-toggle" type="button" class="lg:hidden p-2 rounded-lg text-[#45464E] hover:bg-[#F0F3FF]" aria-label="Buka menu navigasi">
                    <span class="material-symbols-outlined text-[22px]">menu</span>
                </button>
                <form action="/admin/books" method="GET" class="relative hidden sm:block w-full max-w-xl">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[#75777F] text-[20px] pointer-events-none">search</span>
                    <input name="q" value="{{ request('q') }}" class="w-full h-10 pl-10 pr-4 bg-canvas border border-line rounded-lg text-[13px] text-[#111C2D] placeholder:text-[#45464E] focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/15" placeholder="Cari judul buku atau ISBN..." type="text" aria-label="Cari buku">
                </form>
            </div>
            <div class="flex items-center gap-3">
                <a href="#layanan-info" class="hidden xl:flex items-center gap-2 px-3 py-1.5 rounded-full bg-[#F0F3FF] border border-line" id="admin-service-status" data-open="true">
                    <span class="status-dot w-2 h-2 rounded-full bg-success animate-pulse" aria-hidden="true"></span>
                    <span class="status-text text-[12px] font-semibold text-[#45464E]">Buka • 08:00 - 17:00</span>
                </a>
                <a href="/admin/returns" class="relative p-2 rounded-lg text-[#45464E] hover:text-primary hover:bg-[#F0F3FF]" aria-label="Pengembalian dan keterlambatan">
                    <span class="material-symbols-outlined text-[22px]">notifications</span>
                    @if(($overdueCount ?? 0) > 0)
                        <span class="absolute top-1 right-1 flex items-center justify-center min-w-[18px] h-[18px] px-1 text-[10px] font-bold text-white bg-danger rounded-full ring-2 ring-white" title="{{ $overdueCount }} peminjaman jatuh tempo">{{ $overdueCount }}</span>
                    @endif
                </a>
                <div class="h-6 w-px bg-line"></div>
                <div class="flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-full bg-navy text-white flex items-center justify-center font-poppins font-semibold text-[13px]" aria-hidden="true">{{ strtoupper(substr($userName ?? 'A', 0, 1)) }}</span>
                    <span class="hidden md:block text-[13px] font-semibold text-primary leading-tight max-w-[140px] truncate">{{ $userName ?? '' }}</span>
                    <form method="POST" action="/admin/logout">
                        @csrf
                        <button class="p-2 rounded-lg text-[#45464E] hover:text-error hover:bg-red-50" title="Keluar" aria-label="Keluar">
                            <span class="material-symbols-outlined text-[20px]">logout</span>
                        </button>
                    </form>
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
            var toggle = document.getElementById('sidebar-toggle');
            var sidebar = document.getElementById('admin-sidebar');
            var overlay = document.getElementById('sidebar-overlay');
            function close() {
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
                if (overlay) overlay.addEventListener('click', close);
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') close();
                });
            }
            var status = document.getElementById('admin-service-status');
            function tick() {
                if (!status) return;
                var d = new Date();
                var open = (d.getHours() * 60 + d.getMinutes()) >= 480 && (d.getHours() * 60 + d.getMinutes()) < 1020;
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
