<div class="space-y-6">
    @php($today = now()->toDateString())

    {{-- Hero --}}
    <section class="relative overflow-hidden rounded-xl text-white p-6 lg:p-8 border border-[#2A3B60]" style="background: linear-gradient(to right, #1F2D4D, #1A2642, #16223B);">
        <div class="absolute -right-12 -top-12 w-80 h-80 rounded-full bg-[#4F8EF7]/10 blur-3xl pointer-events-none" aria-hidden="true"></div>
        <div class="absolute right-1/4 -bottom-20 w-64 h-64 rounded-full bg-[#D4B483]/15 blur-2xl pointer-events-none" aria-hidden="true"></div>
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#16223B]/80 border border-[#D4B483]/30 text-[#D4B483] text-[11px] font-semibold tracking-wider uppercase">
                    <span class="w-2 h-2 rounded-full bg-[#D4B483] animate-pulse" aria-hidden="true"></span>Portal Pemustaka Libraria
                </div>
                <h1 class="font-poppins text-[32px] leading-[40px] font-bold tracking-tight">Selamat datang kembali, {{ $firstName }}</h1>
                <p class="text-[14px] text-white/90">
                    @if($activeQty > 0)
                        Kamu memiliki <span class="text-[#D4B483] font-semibold">{{ $activeQty }} buku</span> yang sedang dipinjam.
                        @if($overdueCount > 0)
                            <span class="text-[#FFB4AB] font-semibold">Ada {{ $overdueCount }} yang melewati batas jatuh tempo.</span>
                        @endif
                        Pastikan mengembalikan sebelum batas jatuh tempo demi ketertiban sirkulasi koleksi bersama.
                    @else
                        Kamu tidak memiliki buku yang sedang dipinjam. Silahkan meminjam buku yang tersedia. Pastikan mengembalikan sebelum batas jatuh tempo demi ketertiban sirkulasi koleksi bersama.
                    @endif
                </p>
                <div class="pt-2 flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-[#D4B483]/20 border border-[#D4B483]/40 text-[#D4B483] font-medium text-[14px]">
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">local_florist</span>
                        <span class="font-poppins">More Than Books. A Brighter Tomorrow.</span>
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- Stat cards --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4" aria-label="Statistik">
        <div class="bg-white dark:bg-[#131B2E] rounded-xl p-4 border border-line dark:border-[#263252] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[12px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wider font-semibold">Sedang Dipinjam</span>
                <span class="w-8 h-8 rounded-lg bg-brand/10 text-brand dark:text-[#9CC2FF] flex items-center justify-center"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">menu_book</span></span>
            </div>
            <div class="mt-4"><div class="font-poppins text-[32px] text-navy dark:text-white font-bold leading-none">{{ $activeQty }}</div><span class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">{{ $activeCount }} transaksi aktif</span></div>
            <div class="mt-3 pt-3 border-t border-line dark:border-[#263252]"><a href="/member/books" class="inline-flex items-center gap-1.5 text-[11px] text-brand dark:text-[#9CC2FF] font-medium hover:underline"><span class="material-symbols-outlined text-[16px]" aria-hidden="true">library_books</span><span>{{ $totalTitles }} judul tersedia</span></a></div>
        </div>
        <div class="bg-white dark:bg-[#131B2E] rounded-xl p-4 border {{ $overdueCount > 0 ? 'border-red-200 dark:border-[#BA1A1A]/50' : 'border-line dark:border-[#263252]' }} flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[12px] {{ $overdueCount > 0 ? 'text-error dark:text-[#FFB4AB]' : 'text-[#45464E] dark:text-[#9AA7C2]' }} uppercase tracking-wider {{ $overdueCount > 0 ? 'font-bold' : 'font-semibold' }}">Jatuh Tempo</span>
                <span class="w-8 h-8 rounded-lg {{ $overdueCount > 0 ? 'bg-errorbox dark:bg-[#BA1A1A]/20 text-error dark:text-[#FFB4AB]' : 'bg-gold/20 text-[#8A5A1D] dark:text-[#e3c290]' }} flex items-center justify-center"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">schedule</span></span>
            </div>
            <div class="mt-4"><div class="font-poppins text-[24px] {{ $overdueCount > 0 ? 'text-error dark:text-[#FFB4AB]' : 'text-navy dark:text-white' }} font-bold leading-tight">{{ $nearest ? \Carbon\Carbon::parse($nearest->due_at)->format('d M Y') : '—' }}</div><span class="text-[13px] text-[#45464E] dark:text-[#9AA7C2] truncate">{{ $nearestBook ?? 'Tidak ada pinjaman' }}</span></div>
            <div class="mt-3 pt-3 border-t border-line dark:border-[#263252] flex items-center gap-1.5 text-[11px] {{ $overdueCount > 0 ? 'text-error dark:text-[#FFB4AB] font-semibold' : 'text-secondary dark:text-[#9CC2FF] font-medium' }}">
                <span class="material-symbols-outlined text-[16px]" aria-hidden="true">{{ $overdueCount > 0 ? 'notification_important' : 'event_available' }}</span>
                @if($nearest)
                    <span>{{ $nearest->due_at < $today ? 'Terlambat' : 'Sisa ' . $nearestDays . ' hari lagi' }}</span>
                @else
                    <span>Nihil</span>
                @endif
            </div>
        </div>
        <div class="bg-white dark:bg-[#131B2E] rounded-xl p-4 border border-line dark:border-[#263252] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[12px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wider font-semibold">Total Riwayat Pinjam</span>
                <span class="w-8 h-8 rounded-lg bg-success/15 text-success flex items-center justify-center"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">check_circle</span></span>
            </div>
            <div class="mt-4"><div class="font-poppins text-[32px] text-navy dark:text-white font-bold leading-none">{{ $historyQty }}</div><span class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">buku telah dikembalikan</span></div>
            <div class="mt-3 pt-3 border-t border-line dark:border-[#263252] flex items-center gap-1.5 text-[11px] text-success font-medium"><span class="material-symbols-outlined text-[16px]" aria-hidden="true">history</span><a href="/member/activity" class="hover:underline">Lihat riwayat</a></div>
        </div>
        <div class="bg-white dark:bg-[#131B2E] rounded-xl p-4 border border-line dark:border-[#263252] flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[12px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wider font-semibold">Status Keanggotaan</span>
                <span class="w-8 h-8 rounded-lg bg-gold/20 text-[#8A5A1D] dark:text-[#e3c290] flex items-center justify-center"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">verified_user</span></span>
            </div>
            <div class="mt-4"><div class="font-poppins text-[24px] {{ $member->status === 'active' ? 'text-success' : 'text-error dark:text-[#FFB4AB]' }} font-bold leading-tight">{{ ucfirst($member->status) }}</div><span class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">Berlaku s/d {{ $member->active_until ? \Carbon\Carbon::parse($member->active_until)->format('d M Y') : '—' }}</span></div>
            <div class="mt-3 pt-3 border-t border-line dark:border-[#263252] flex items-center gap-1.5 text-[11px] text-brand dark:text-[#9CC2FF] font-medium"><span class="material-symbols-outlined text-[16px]" aria-hidden="true">badge</span><a href="/member/profile" class="hover:underline">Kelola profil</a></div>
        </div>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
        {{-- Buku sedang dipinjam --}}
            <div class="bg-white dark:bg-[#131B2E] rounded-xl p-6 border border-line dark:border-[#263252]">
                <div class="flex items-center justify-between pb-4 border-b border-line dark:border-[#263252]">
                    <div>
                        <h2 class="font-poppins text-[24px] text-navy dark:text-white font-bold">Buku Sedang Dipinjam</h2>
                        <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">Status pengembalian &amp; batas waktu</p>
                    </div>
                    <a href="/member/activity" class="text-[13px] font-semibold text-brand dark:text-[#9CC2FF] hover:underline flex items-center gap-1">Lihat Semua<span class="material-symbols-outlined text-[16px]" aria-hidden="true">arrow_forward</span></a>
                </div>
                <div class="space-y-3 pt-4">
                    @forelse($activeDetails as $d)
                        @php($b = $d->borrowing)
                        <div class="p-3 rounded-lg bg-[#F0F3FF]/40 dark:bg-[#1A2440]/50 hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-16 rounded overflow-hidden flex-shrink-0 bg-navy text-white flex flex-col items-center justify-center" aria-hidden="true">
                                    @if($d->book?->cover)
                                        <img src="{{ asset('storage/' . $d->book->cover) }}" alt="Sampul {{ $d->book->title }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="material-symbols-outlined text-[22px]">menu_book</span>
                                        <span class="font-poppins font-bold text-[13px]">{{ strtoupper(substr($d->book?->title ?? 'B', 0, 1)) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-navy dark:text-white font-semibold">{{ $d->book?->title ?? '-' }}</span>
                                        <span class="px-2 py-0.5 text-[11px] rounded-full bg-[#E7EEFF] dark:bg-[#263252] text-[#45464E] dark:text-[#C6D2E8]">{{ $d->book?->category?->name ?? 'Umum' }}</span>
                                        @if($b && $b->due_at < $today)
                                            <span class="px-2 py-0.5 rounded-full text-[11px] bg-errorbox dark:bg-[#BA1A1A]/20 text-error dark:text-[#FFB4AB] font-semibold">Terlambat {{ (int) \Carbon\Carbon::parse($b->due_at)->diffInDays($today) }} hari</span>
                                        @elseif($b)
                                            <span class="px-2 py-0.5 rounded-full text-[11px] bg-brand/10 text-brand dark:text-[#9CC2FF] font-semibold">Sisa {{ (int) \Carbon\Carbon::parse($today)->diffInDays($b->due_at) }} hari</span>
                                        @endif
                                    </div>
                                    <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">{{ $d->book?->author ?? '-' }} • ISBN: {{ $d->book?->isbn ?? '-' }}</p>
                                    @if($b)
                                        <div class="flex items-center gap-3 mt-1 text-[11px] text-[#45464E] dark:text-[#9AA7C2]">
                                            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px] text-[#75777F] dark:text-[#8c909e]" aria-hidden="true">event_available</span>Pinjam: {{ \Carbon\Carbon::parse($b->borrowed_at)->format('d M Y') }}</span>
                                            <span class="text-[#75777F] dark:text-[#424753]">•</span>
                                            <span class="flex items-center gap-1 text-secondary dark:text-[#9CC2FF] font-medium"><span class="material-symbols-outlined text-[16px]" aria-hidden="true">event_busy</span>Tenggat: {{ \Carbon\Carbon::parse($b->due_at)->format('d M Y') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5 self-end sm:self-center shrink-0">
                                <a href="/member/books/{{ $d->book_id }}" class="px-3 py-1.5 rounded-lg bg-brand dark:bg-[#508ff8] text-white dark:text-[#002f68] text-[12px] font-semibold hover:brightness-110">Lihat Detail</a>
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center">
                            <span class="material-symbols-outlined text-[40px] text-[#AE9163]" aria-hidden="true">library_books</span>
                            <p class="text-[14px] text-navy dark:text-white font-semibold mt-2">Tidak ada buku yang sedang dipinjam</p>
                            <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2] mt-1">Jelajahi katalog untuk melihat koleksi yang tersedia.</p>
                            <a href="/member/books" class="inline-flex items-center gap-1.5 mt-4 px-4 py-2.5 rounded-lg bg-brand dark:bg-[#508ff8] text-white dark:text-[#002f68] text-[14px] font-semibold hover:brightness-110"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">search</span>Lihat Katalog</a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Rekomendasi --}}
            <div class="bg-white dark:bg-[#131B2E] rounded-xl p-6 border border-line dark:border-[#263252]">
                <div class="flex items-center justify-between pb-2">
                    <div>
                        <h2 class="font-poppins text-[24px] text-navy dark:text-white font-bold">Rekomendasi Pilihan</h2>
                        <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">Judul dengan ketersediaan stok terbanyak</p>
                    </div>
                    <span class="px-2.5 py-1 rounded bg-[#DEE8FF] dark:bg-[#263252] text-primary dark:text-[#C6D2E8] text-[11px]">Top {{ count($recommended) }}</span>
                </div>
                <div class="space-y-3 pt-2">
                    @forelse($recommended as $r)
                        <div class="p-3 rounded-lg bg-[#F0F3FF]/40 dark:bg-[#1A2440]/50 hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-16 rounded overflow-hidden flex-shrink-0 bg-navy text-white flex flex-col items-center justify-center" aria-hidden="true">
                                    <span class="material-symbols-outlined text-[22px]">menu_book</span>
                                    <span class="font-poppins font-bold text-[13px]">{{ strtoupper(substr($r->title, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap"><span class="text-navy dark:text-white font-semibold">{{ $r->title }}</span><span class="px-2 py-0.5 text-[11px] rounded-full bg-[#E7EEFF] dark:bg-[#263252] text-[#45464E] dark:text-[#C6D2E8]">{{ $r->category->name ?? '-' }}</span></div>
                                    <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">{{ $r->author }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 self-end sm:self-center">
                                <div class="text-right"><div class="font-poppins text-[20px] text-primary dark:text-white font-bold">{{ $r->stock }}</div><span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Stok</span></div>
                                @if($r->stock > 1)
                                    <span class="px-2.5 py-1 rounded-full text-[11px] bg-success/15 text-success font-medium flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-success" aria-hidden="true"></span> Tersedia</span>
                                @elseif($r->stock === 1)
                                    <span class="px-2.5 py-1 rounded-full text-[11px] bg-warning/15 text-warning font-medium flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-warning" aria-hidden="true"></span> Menipis</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] bg-errorbox dark:bg-[#BA1A1A]/20 text-error dark:text-[#FFB4AB] font-medium flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-error" aria-hidden="true"></span> Habis</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2] py-4 text-center">Belum ada rekomendasi. Katalog sedang kosong.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
