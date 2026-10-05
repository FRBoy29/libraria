<div class="space-y-6">
    @php($today = now()->toDateString())

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-[12px] text-[#45464E] dark:text-[#9AA7C2]" aria-label="Breadcrumb">
        <a class="hover:text-brand dark:hover:text-[#9CC2FF] transition-colors flex items-center gap-1" href="/member/dashboard">
            <span class="material-symbols-outlined text-[16px]" aria-hidden="true">home</span><span>Beranda</span>
        </a>
        <span class="text-[#75777F] dark:text-[#424753]">/</span>
        <span>Layanan Sirkulasi</span>
        <span class="text-[#75777F] dark:text-[#424753]">/</span>
        <span class="text-brand dark:text-[#9CC2FF] font-medium">Pinjaman &amp; Riwayat Saya</span>
    </nav>

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4">
        <div class="flex flex-col gap-1 max-w-2xl">
            <div class="inline-flex items-center gap-2 self-start">
                <span class="p-1 rounded bg-[#5c451e]/15 dark:bg-[#5c451e]/40 text-[#8A5A1D] dark:text-[#e3c290]">
                    <span class="material-symbols-outlined text-[18px] block" aria-hidden="true">collections_bookmark</span>
                </span>
                <span class="text-[11px] uppercase tracking-widest text-[#8A5A1D] dark:text-[#e3c290] font-semibold">Portal Pemustaka</span>
            </div>
            <h1 class="font-poppins text-[32px] leading-[40px] text-navy dark:text-white font-semibold tracking-tight">Pinjaman Buku &amp; Riwayat Sirkulasi</h1>
            <p class="text-[14px] text-[#45464E] dark:text-[#9AA7C2]">Pantau buku yang sedang kamu pinjam serta tinjau rekam jejak pengembalian bukumu.</p>
        </div>
        <button wire:click="export" type="button" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-lg bg-[#F0F3FF] dark:bg-[#1A2440] border border-line dark:border-[#263252] hover:bg-[#E7EEFF] dark:hover:bg-[#263252] text-[14px] font-medium self-start lg:self-auto">
            <span class="material-symbols-outlined text-secondary dark:text-[#9CC2FF] text-[20px]" aria-hidden="true">file_download</span><span>Unduh Riwayat (CSV)</span>
        </button>
    </div>

    {{-- Metrik --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="p-4 rounded-xl bg-[#F0F3FF] dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wider font-medium">Sedang Dipinjam</span>
                <div class="flex items-baseline gap-1.5 mt-0.5">
                    <span class="font-poppins text-[24px] leading-8 text-navy dark:text-white font-semibold">{{ $activeQty }}</span>
                    <span class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">Buku</span>
                </div>
                <span class="text-[11px] text-brand dark:text-[#9CC2FF] mt-1 flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-brand dark:bg-[#9CC2FF]" aria-hidden="true"></span> {{ $activeCount }} transaksi aktif</span>
            </div>
            <span class="w-12 h-12 rounded-xl bg-white dark:bg-[#222A3D] flex items-center justify-center text-brand dark:text-[#9CC2FF]"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">auto_stories</span></span>
        </div>
        <div class="p-4 rounded-xl bg-[#F0F3FF] dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wider font-medium">Jatuh Tempo Terdekat</span>
                <div class="flex items-baseline gap-1.5 mt-0.5">
                    <span class="font-poppins text-[24px] leading-8 text-secondary dark:text-[#9CC2FF] font-semibold">{{ $nearest ? \Carbon\Carbon::parse($nearest->due_at)->format('d M Y') : '—' }}</span>
                </div>
                <span class="text-[11px] {{ $overdueCount > 0 ? 'text-error dark:text-[#FFB4AB]' : 'text-[#45464E] dark:text-[#9AA7C2]' }} mt-1">
                    @if($overdueCount > 0)
                        {{ $overdueCount }} buku terlambat — segera kembalikan
                    @elseif($nearest)
                        Kembalikan sebelum tanggal tersebut
                    @else
                        Tidak ada pinjaman aktif
                    @endif
                </span>
            </div>
            <span class="w-12 h-12 rounded-xl bg-gold/20 flex items-center justify-center text-[#8A5A1D] dark:text-[#e3c290]"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">schedule</span></span>
        </div>
        <div class="p-4 rounded-xl bg-[#F0F3FF] dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wider font-medium">Total Telah Dibaca</span>
                <div class="flex items-baseline gap-1.5 mt-0.5">
                    <span class="font-poppins text-[24px] leading-8 text-navy dark:text-white font-semibold">{{ $historyQty }}</span>
                    <span class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">Buku</span>
                </div>
                <span class="text-[11px] text-success flex items-center gap-1 mt-1 font-medium"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">verified_user</span> Pengembalian tuntas</span>
            </div>
            <span class="w-12 h-12 rounded-xl bg-white dark:bg-[#222A3D] flex items-center justify-center text-brand dark:text-[#9CC2FF]"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">military_tech</span></span>
        </div>
    </div>

    {{-- Tab --}}
    <div class="flex items-center gap-1 p-1.5 bg-[#F0F3FF] dark:bg-[#131B2E] border border-line dark:border-[#263252] rounded-2xl w-fit max-w-full overflow-x-auto" role="tablist" aria-label="Tab aktivitas">
        <button wire:click="setTab('active')" type="button" role="tab" aria-selected="{{ $tab === 'active' ? 'true' : 'false' }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-[12px] font-semibold transition-all whitespace-nowrap {{ $tab === 'active' ? 'bg-brand dark:bg-[#508ff8] text-white dark:text-[#002f68] shadow-md' : 'text-[#45464E] dark:text-[#9AA7C2] hover:text-navy dark:hover:text-white hover:bg-white dark:hover:bg-[#222A3D]' }}">
            <span class="material-symbols-outlined text-[18px]" aria-hidden="true">menu_book</span><span>Sedang Dipinjam</span>
            <span class="px-2 py-0.5 rounded-full {{ $tab === 'active' ? 'bg-white/25 dark:bg-[#002f68]/25' : 'bg-[#D8E3FB] dark:bg-[#2d3449] text-[#45464E] dark:text-[#c2c6d5]' }} text-[11px]">{{ $activeQty }}</span>
        </button>
        <button wire:click="setTab('history')" type="button" role="tab" aria-selected="{{ $tab === 'history' ? 'true' : 'false' }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-[12px] font-medium transition-all whitespace-nowrap {{ $tab === 'history' ? 'bg-brand dark:bg-[#508ff8] text-white dark:text-[#002f68] shadow-md' : 'text-[#45464E] dark:text-[#9AA7C2] hover:text-navy dark:hover:text-white hover:bg-white dark:hover:bg-[#222A3D]' }}">
            <span class="material-symbols-outlined text-[18px]" aria-hidden="true">history</span><span>Riwayat Pengembalian</span>
            <span class="px-2 py-0.5 rounded-full {{ $tab === 'history' ? 'bg-white/25 dark:bg-[#002f68]/25' : 'bg-[#D8E3FB] dark:bg-[#2d3449] text-[#45464E] dark:text-[#c2c6d5]' }} text-[11px]">{{ $historyQty }}</span>
        </button>
    </div>

    @if($tab === 'active')
        {{-- Daftar pinjaman aktif --}}
        <div class="flex items-center justify-between border-b border-line dark:border-[#263252] pb-2">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-brand animate-pulse" aria-hidden="true"></span>
                <h2 class="font-poppins text-[20px] text-navy dark:text-white font-semibold tracking-tight">Buku Sedang Aktif Dipinjam</h2>
                <span class="ml-2 px-2.5 py-0.5 rounded-full bg-[#F0F3FF] dark:bg-[#1A2440] border border-line dark:border-[#263252] text-brand dark:text-[#9CC2FF] text-[12px] font-medium">{{ $activeQty }} Buku</span>
            </div>
            <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] hidden sm:flex items-center gap-1"><span class="material-symbols-outlined text-[15px] text-[#75777F] dark:text-[#8c909e]" aria-hidden="true">info</span>Pengembalian diproses petugas</span>
        </div>

        <div class="grid grid-cols-1 gap-4">
            @forelse($activeDetails as $d)
                @php($b = $d->borrowing)
                @php($isOverdue = $b && $b->due_at < $today)
                @php($totalDays = $b ? max(1, (int) \Carbon\Carbon::parse($b->borrowed_at)->diffInDays($b->due_at)) : 1)
                @php($usedDays = $b ? min($totalDays, max(0, (int) \Carbon\Carbon::parse($b->borrowed_at)->diffInDays(min($today, $b->due_at)))) : 0)
                @php($pct = (int) round($usedDays / $totalDays * 100))
                <article class="p-4 md:p-5 rounded-2xl bg-[#F0F3FF] dark:bg-[#171f33] border border-line dark:border-[#263252] border-l-4 {{ $isOverdue ? '!border-l-error dark:!border-l-[#FFB4AB]' : '!border-l-brand dark:!border-l-[#508ff8]' }} flex flex-col md:flex-row gap-4 hover:bg-[#E7EEFF] dark:hover:bg-[#222A3D] transition-all">
                    <div class="w-full md:w-28 h-44 md:h-44 rounded-xl overflow-hidden shrink-0 bg-navy text-white flex items-center justify-center relative">
                        @if($d->book?->cover)
                            <img src="{{ asset('storage/' . $d->book->cover) }}" alt="Sampul {{ $d->book->title }}" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined text-[36px]" aria-hidden="true">menu_book</span>
                        @endif
                    </div>
                    <div class="flex flex-col justify-between flex-1 gap-3 min-w-0">
                        <div class="flex flex-col gap-1 min-w-0">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                @if($isOverdue)
                                    <span class="px-2.5 py-1 rounded-full bg-errorbox dark:bg-[#93000a]/40 text-error dark:text-[#FFB4AB] text-[11px] font-semibold flex items-center gap-1.5"><span class="material-symbols-outlined text-[15px]" aria-hidden="true">timer_off</span>Terlambat {{ (int) \Carbon\Carbon::parse($b->due_at)->diffInDays($today) }} hari</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full bg-success/10 text-success text-[11px] font-semibold flex items-center gap-1.5"><span class="material-symbols-outlined text-[15px]" aria-hidden="true">timer</span>Sisa {{ (int) \Carbon\Carbon::parse($today)->diffInDays($b->due_at) }} hari lagi</span>
                                @endif
                                <span class="font-mono text-[11px] text-[#75777F] dark:text-[#8c909e]">#{{ $b->id ?? '-' }}</span>
                            </div>
                            <h3 class="font-poppins text-[20px] text-navy dark:text-white font-semibold leading-snug truncate">{{ $d->book->title ?? '-' }}</h3>
                            <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2] truncate">{{ $d->book->author ?? '-' }} • {{ $d->book->publisher ?? 'Tanpa penerbit' }} ({{ $d->book->publication_year ?? '—' }})</p>
                            @if($b)
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1.5 text-[#45464E] dark:text-[#9AA7C2] text-[11px]">
                                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px] text-[#75777F] dark:text-[#8c909e]" aria-hidden="true">calendar_month</span>Dipinjam: <strong class="text-navy dark:text-white font-medium">{{ \Carbon\Carbon::parse($b->borrowed_at)->format('d M Y') }}</strong></span>
                                    <span class="text-[#75777F] dark:text-[#424753]">•</span>
                                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px] text-error dark:text-[#FFB4AB]" aria-hidden="true">event_upcoming</span>Jatuh Tempo: <strong class="text-navy dark:text-white font-medium">{{ \Carbon\Carbon::parse($b->due_at)->format('d M Y') }}</strong></span>
                                    <span class="text-[#75777F] dark:text-[#424753]">•</span>
                                    <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px] text-[#8A5A1D] dark:text-[#e3c290]" aria-hidden="true">library_books</span><span>{{ $d->quantity }} eksemplar</span></span>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col gap-1.5 p-2.5 rounded-xl bg-white dark:bg-[#0B1326] border border-line dark:border-[#263252]">
                            <div class="flex justify-between items-center text-[11px]">
                                <span class="text-[#45464E] dark:text-[#9AA7C2]">Masa pinjam terpakai: <strong class="text-navy dark:text-white">{{ $usedDays }} dari {{ $totalDays }} hari</strong></span>
                                <a href="/member/books/{{ $d->book_id }}" class="text-brand dark:text-[#9CC2FF] font-semibold hover:underline">Lihat Detail</a>
                            </div>
                            <div class="w-full h-2 rounded-full bg-[#D8E3FB] dark:bg-[#2d3449] overflow-hidden">
                                <div class="h-full {{ $isOverdue ? 'bg-error dark:bg-[#FFB4AB]' : 'bg-brand dark:bg-[#508ff8]' }} rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="p-10 rounded-2xl bg-[#F0F3FF] dark:bg-[#171f33] border border-dashed border-line dark:border-[#263252] text-center">
                    <span class="material-symbols-outlined text-[40px] text-[#AE9163]" aria-hidden="true">library_books</span>
                    <p class="text-[14px] text-navy dark:text-white font-semibold mt-2">Tidak ada buku yang sedang dipinjam</p>
                    <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2] mt-1">Jelajahi katalog untuk melihat koleksi yang tersedia.</p>
                    <a href="/member/books" class="inline-flex items-center gap-1.5 mt-4 px-4 py-2.5 rounded-xl bg-brand dark:bg-[#508ff8] text-white dark:text-[#002f68] text-[14px] font-semibold hover:brightness-110"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">search</span>Lihat Katalog</a>
                </div>
            @endforelse
        </div>

        <div class="p-4 rounded-2xl bg-[#F0F3FF] dark:bg-[#1A2440]/60 border border-line dark:border-[#263252] flex items-start gap-3">
            <span class="w-10 h-10 rounded-xl bg-brand/15 text-brand dark:text-[#9CC2FF] flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-[22px]" aria-hidden="true">lightbulb</span></span>
            <div class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">
                <span class="font-semibold text-[14px] text-navy dark:text-white">Kebijakan Pengembalian</span>
                <p>Kembalikan buku ke <span class="text-brand dark:text-[#9CC2FF] font-medium">meja sirkulasi</span> sebelum tanggal jatuh tempo pada jam layanan <span class="text-[#8A5A1D] dark:text-[#e3c290] font-medium">08:00 – 17:00 WIB</span>. Pengembalian diproses petugas dan stok bertambah otomatis.</p>
            </div>
        </div>
    @else
        {{-- Riwayat --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-gold" aria-hidden="true"></span>
                <h2 class="font-poppins text-[20px] text-navy dark:text-white font-semibold tracking-tight">Rekam Riwayat Peminjaman Buku</h2>
                <span class="ml-2 px-2.5 py-0.5 rounded-full bg-[#F0F3FF] dark:bg-[#1A2440] border border-line dark:border-[#263252] text-secondary dark:text-[#9CC2FF] text-[12px] font-medium">{{ $history->total() }} Arsip</span>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-3 text-[#75777F] dark:text-[#8c909e] text-[18px] pointer-events-none" aria-hidden="true">search</span>
                    <input wire:model.live="search" type="text" placeholder="Cari buku dalam riwayat..." aria-label="Cari riwayat" class="h-10 pl-9 pr-3 w-56 rounded-lg bg-[#F0F3FF] dark:bg-[#131B2E] border border-line dark:border-[#263252] text-[13px] focus:outline-none focus:ring-2 focus:ring-secondary/20">
                </div>
                <select wire:model.live="year" class="h-10 px-3 rounded-lg bg-[#F0F3FF] dark:bg-[#131B2E] border border-line dark:border-[#263252] text-[12px] focus:outline-none cursor-pointer" aria-label="Filter tahun">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $y)<option value="{{ $y }}">Tahun {{ $y }}</option>@endforeach
                </select>
                <select wire:model.live="statusFilter" class="h-10 px-3 rounded-lg bg-[#F0F3FF] dark:bg-[#131B2E] border border-line dark:border-[#263252] text-[12px] focus:outline-none cursor-pointer" aria-label="Filter status">
                    <option value="">Semua Status</option>
                    <option value="ontime">Tepat Waktu</option>
                    <option value="late">Terlambat</option>
                </select>
                @if($search || $year || $statusFilter)
                    <button wire:click="clearFilters" type="button" class="h-10 px-3 rounded-lg text-[12px] text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440]">Reset</button>
                @endif
            </div>
        </div>

        <div class="rounded-2xl bg-[#F0F3FF] dark:bg-[#131B2E] border border-line dark:border-[#263252] overflow-x-auto">
            <table class="w-full text-left text-[13px] min-w-[720px]">
                <thead>
                    <tr class="bg-white dark:bg-[#060e20] border-b border-line dark:border-[#263252] text-[#45464E] dark:text-[#9AA7C2] text-[11px] uppercase tracking-wider">
                        <th class="py-3.5 px-4">Buku &amp; Pengarang</th>
                        <th class="py-3.5 px-4">Tgl Pinjam</th>
                        <th class="py-3.5 px-4">Tgl Kembali</th>
                        <th class="py-3.5 px-4">Status Pengembalian</th>
                        <th class="py-3.5 px-4 text-center">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $r)
                        @php($due = $r->borrowing?->due_at)
                        @php($ret = $r->returned_at ? \Carbon\Carbon::parse($r->returned_at)->toDateString() : null)
                        @php($late = $ret && $due && $ret > $due)
                        @php($lateDays = $late ? (int) \Carbon\Carbon::parse($due)->diffInDays($ret) : 0)
                        <tr class="hover:bg-white dark:hover:bg-[#060e20] border-b border-line dark:border-[#263252]">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-12 rounded bg-navy text-white flex items-center justify-center shrink-0 overflow-hidden">
                                        @if($r->book?->cover)
                                            <img src="{{ asset('storage/' . $r->book->cover) }}" alt="" class="w-full h-full object-cover">
                                        @else
                                            <span class="material-symbols-outlined text-[18px]" aria-hidden="true">menu_book</span>
                                        @endif
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span class="font-semibold text-navy dark:text-white truncate">{{ $r->book->title ?? '-' }}</span>
                                        <span class="text-[12px] text-[#45464E] dark:text-[#9AA7C2]">{{ $r->book->author ?? '' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-[12px] text-[#45464E] dark:text-[#9AA7C2] whitespace-nowrap">{{ $r->borrowing?->borrowed_at ? \Carbon\Carbon::parse($r->borrowing->borrowed_at)->format('d M Y') : '-' }}</td>
                            <td class="py-3.5 px-4 text-[12px] text-navy dark:text-white whitespace-nowrap">{{ $r->returned_at ? \Carbon\Carbon::parse($r->returned_at)->format('d M Y') : '-' }}</td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($late)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-gold/20 text-[#8A5A1D] dark:text-[#e3c290] border border-gold/30 text-[11px] font-semibold"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">history_toggle_off</span> Terlambat {{ $lateDays }} hari</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-success/10 text-success text-[11px] font-medium"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">check_circle</span> Tepat Waktu</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center font-semibold text-navy dark:text-white">{{ $r->quantity }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-10 text-center text-[#45464E] dark:text-[#9AA7C2]">Belum ada riwayat pada filter ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4 bg-white dark:bg-[#060e20] border-t border-line dark:border-[#263252] flex flex-col sm:flex-row items-center justify-between gap-2 text-[11px] text-[#45464E] dark:text-[#9AA7C2]">
                <span>Menampilkan <strong class="text-navy dark:text-white">{{ $history->firstItem() ?? 0 }} - {{ $history->lastItem() ?? 0 }}</strong> dari <strong class="text-navy dark:text-white">{{ $history->total() }}</strong> riwayat peminjaman</span>
                {{ $history->links() }}
            </div>
        </div>
    @endif
</div>