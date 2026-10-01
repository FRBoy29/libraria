<div class="space-y-6">
    {{-- Hero / identitas anggota --}}
    <section class="relative overflow-hidden rounded-xl text-white border border-[#2A3B60]" style="background: linear-gradient(to right, #1F2D4D, #1A2642, #16223B);">
        <div class="absolute -right-12 -top-12 w-80 h-80 rounded-full bg-[#4F8EF7]/10 blur-3xl pointer-events-none" aria-hidden="true"></div>
        <div class="absolute right-1/4 -bottom-20 w-64 h-64 rounded-full bg-[#D4B483]/15 blur-2xl pointer-events-none" aria-hidden="true"></div>
        <div class="relative z-10 p-6 lg:p-8 flex flex-col lg:flex-row lg:items-center gap-6 justify-between">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#16223B]/80 border border-[#D4B483]/30 text-[#D4B483] text-[11px] font-semibold tracking-wider uppercase">
                    <span class="w-2 h-2 rounded-full bg-[#D4B483] animate-pulse" aria-hidden="true"></span>Portal Pemustaka
                </div>
                <h1 class="font-poppins text-[32px] leading-[40px] font-bold tracking-tight">Halo, {{ $member->name }}</h1>
                <p class="text-[14px] text-white/85">Pantau status peminjaman dan riwayat baca Anda di sini.</p>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-[#D4B483]/20 border border-[#D4B483]/40 text-[#D4B483] font-medium text-[13px]">
                    <span class="material-symbols-outlined text-[16px]" aria-hidden="true">local_florist</span>
                    <span class="font-poppins">More Than Books. A Brighter Tomorrow.</span>
                </span>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <span class="px-4 py-3 rounded-xl bg-white/10 border border-white/15 text-center">
                    <span class="block text-[11px] text-white/60 uppercase tracking-wider">Member ID</span>
                    <span class="block font-poppins text-[20px] font-bold tracking-wider mt-0.5">{{ $member->member_code }}</span>
                </span>
                <span class="px-4 py-3 rounded-xl bg-white/10 border border-white/15 text-center">
                    <span class="block text-[11px] text-white/60 uppercase tracking-wider">Masa Aktif</span>
                    <span class="block font-poppins text-[20px] font-bold mt-0.5">{{ $member->active_until ? \Carbon\Carbon::parse($member->active_until)->format('d M Y') : '—' }}</span>
                </span>
            </div>
        </div>
    </section>

    {{-- Metrik --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="/member/borrowings" class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] transition-colors">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wide">Sedang Dipinjam</span>
                <span class="font-poppins text-[24px] leading-8 text-primary dark:text-white font-semibold mt-0.5">{{ number_format($activeCount) }}</span>
                <span class="text-[11px] text-secondary dark:text-[#9CC2FF] mt-1">{{ $activeBooks->count() }} judul buku</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] flex items-center justify-center text-secondary dark:text-[#9CC2FF]"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">auto_stories</span></span>
        </a>
        <a href="/member/borrowings" class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border {{ $overdueCount > 0 ? 'border-red-200 dark:border-[#BA1A1A]/50' : 'border-line dark:border-[#263252]' }} flex items-center justify-between hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] transition-colors">
            <div class="flex flex-col">
                <span class="text-[11px] text-error dark:text-[#FFB4AB] font-semibold uppercase tracking-wide">Terlambat</span>
                <span class="font-poppins text-[24px] leading-8 text-error dark:text-[#FFB4AB] font-semibold mt-0.5">{{ number_format($overdueCount) }}</span>
                <span class="text-[11px] text-error dark:text-[#FFB4AB] mt-1">segera dikembalikan</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-errorbox dark:bg-[#BA1A1A]/20 flex items-center justify-center text-error dark:text-[#FFB4AB]"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">timer_off</span></span>
        </a>
        <a href="/member/history" class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] transition-colors">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wide">Total Riwayat</span>
                <span class="font-poppins text-[24px] leading-8 text-primary dark:text-white font-semibold mt-0.5">{{ number_format($historyCount) }}</span>
                <span class="text-[11px] text-success flex items-center gap-0.5 mt-1 font-medium"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">check_circle</span> buku selesai</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] flex items-center justify-center text-success"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">history</span></span>
        </a>
        <a href="/member/books" class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] transition-colors">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wide">Koleksi Tersedia</span>
                <span class="font-poppins text-[24px] leading-8 text-primary dark:text-white font-semibold mt-0.5">{{ number_format($availableBooks) }}</span>
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] mt-1">{{ number_format($totalTitles) }} judul katalog</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] flex items-center justify-center text-navy dark:text-white"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">library_books</span></span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        {{-- Peminjaman aktif --}}
        <div class="lg:col-span-7 xl:col-span-8 space-y-6">
            <div class="bg-white dark:bg-[#131B2E] rounded-xl border border-line dark:border-[#263252] overflow-hidden">
                <div class="p-6 pb-4 flex items-center justify-between gap-3 border-b border-line dark:border-[#263252]">
                    <div>
                        <h2 class="font-poppins text-[24px] text-primary dark:text-white font-bold">Buku Sedang Dipinjam</h2>
                        <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">Daftar buku yang masih berada di tangan Anda</p>
                    </div>
                    <a href="/member/borrowings" class="flex items-center gap-1 text-[13px] font-semibold text-secondary dark:text-[#9CC2FF] hover:underline">
                        <span>Lihat semua</span><span class="material-symbols-outlined text-[16px]" aria-hidden="true">chevron_right</span>
                    </a>
                </div>
                @php($today = now()->toDateString())
                @if($activeCount > 0)
                    <div class="p-6 space-y-3">
                        @foreach($activeDetails as $d)
                            @php($borrowing = $d->borrowing)
                            <div class="p-3 rounded-lg bg-[#F0F3FF]/50 dark:bg-[#1A2440]/60 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="w-10 h-12 rounded-lg bg-navy text-white flex items-center justify-center font-poppins font-semibold text-[15px] flex-shrink-0" aria-hidden="true">{{ strtoupper(substr($d->book->title ?? '?', 0, 1)) }}</span>
                                    <div class="min-w-0">
                                        <span class="font-poppins text-[15px] font-semibold text-primary dark:text-white truncate block">{{ $d->book->title ?? '-' }}</span>
                                        <span class="text-[12px] text-[#45464E] dark:text-[#9AA7C2]">
                                            {{ $d->book->author ?? '-' }} • {{ $d->quantity }} eksemplar
                                            @if($borrowing) • Jatuh tempo {{ \Carbon\Carbon::parse($borrowing->due_at)->format('d M Y') }} @endif
                                        </span>
                                    </div>
                                </div>
                                @if($borrowing)
                                    @if($borrowing->due_at < $today)
                                        <span class="px-2.5 py-1 rounded-md bg-errorbox dark:bg-[#BA1A1A]/20 text-error dark:text-[#FFB4AB] text-[12px] font-semibold whitespace-nowrap">Terlambat {{ (int) \Carbon\Carbon::parse($borrowing->due_at)->diffInDays($today) }} hari</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-md bg-success/15 text-success text-[12px] font-semibold whitespace-nowrap">{{ (int) \Carbon\Carbon::parse($today)->diffInDays($borrowing->due_at) }} hari lagi</span>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                        @if($overdueCount > 0)
                            <p class="text-[12px] text-error dark:text-[#FFB4AB] flex items-center gap-1.5 pt-1"><span class="material-symbols-outlined text-[16px]" aria-hidden="true">warning</span>Ada {{ $overdueCount }} buku yang melewati batas waktu. Segera dikembalikan ke petugas.</p>
                        @elseif($dueSoonCount > 0)
                            <p class="text-[12px] text-warning flex items-center gap-1.5 pt-1"><span class="material-symbols-outlined text-[16px]" aria-hidden="true">schedule</span>{{ $dueSoonCount }} buku jatuh tempo dalam 3 hari ke depan.</p>
                        @endif
                    </div>
                @else
                    <div class="p-10 text-center">
                        <span class="material-symbols-outlined text-[40px] text-[#AE9163]" aria-hidden="true">library_books</span>
                        <p class="text-[14px] text-primary dark:text-white font-semibold mt-2">Tidak ada buku yang sedang dipinjam</p>
                        <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2] mt-1">Jelajahi katalog untuk melihat koleksi yang tersedia.</p>
                        <a href="/member/books" class="inline-flex items-center gap-1.5 mt-4 px-4 py-2.5 rounded-lg bg-secondary text-white text-[14px] font-medium hover:brightness-110"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">search</span>Lihat Katalog</a>
                    </div>
                @endif
            </div>

            {{-- Riwayat terbaru --}}
            <div class="bg-white dark:bg-[#131B2E] rounded-xl border border-line dark:border-[#263252] overflow-hidden">
                <div class="p-6 pb-4 flex items-center justify-between gap-3 border-b border-line dark:border-[#263252]">
                    <div>
                        <h2 class="font-poppins text-[24px] text-primary dark:text-white font-bold">Riwayat Terbaru</h2>
                        <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">Buku yang sudah Anda kembalikan</p>
                    </div>
                    <a href="/member/history" class="flex items-center gap-1 text-[13px] font-semibold text-secondary dark:text-[#9CC2FF] hover:underline"><span>Semua riwayat</span><span class="material-symbols-outlined text-[16px]" aria-hidden="true">chevron_right</span></a>
                </div>
                @if($returnedDetails->count() > 0)
                    <div class="p-6">
                        <div class="relative pl-6 space-y-4 before:content-[''] before:absolute before:left-2.5 before:top-2 before:bottom-2 before:w-0.5 before:bg-[#DEE8FF] dark:before:bg-[#263252]">
                            @foreach($returnedDetails as $r)
                                <div class="relative">
                                    <div class="absolute -left-6 top-1 w-3.5 h-3.5 rounded-full bg-success ring-4 ring-white dark:ring-[#131B2E]" aria-hidden="true"></div>
                                    <div class="flex flex-col">
                                        <div class="flex items-baseline justify-between gap-2">
                                            <span class="font-poppins text-[14px] font-semibold text-primary dark:text-white">{{ $r->book->title ?? '-' }}</span>
                                            <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] whitespace-nowrap">{{ $r->returned_at ? \Carbon\Carbon::parse($r->returned_at)->format('d M Y') : '-' }}</span>
                                        </div>
                                        <span class="text-[12px] text-[#45464E] dark:text-[#9AA7C2]">{{ $r->book->author ?? '' }} • {{ $r->quantity }} eksemplar</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="p-10 text-center">
                        <span class="material-symbols-outlined text-[40px] text-[#AE9163]" aria-hidden="true">history</span>
                        <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2] mt-2">Belum ada riwayat peminjaman.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Sisi kanan: kartu anggota + info --}}
        <div class="lg:col-span-5 xl:col-span-4 space-y-6">
            <div class="bg-white dark:bg-[#131B2E] rounded-xl border border-line dark:border-[#263252] p-6">
                <h2 class="font-poppins text-[16px] text-primary dark:text-white font-bold mb-4">Kartu Anggota</h2>
                <div class="relative rounded-2xl p-5 text-white overflow-hidden flex flex-col justify-between min-h-[190px]" style="background: linear-gradient(to bottom right, #1F2D4D, #1A2642, #16223B);">
                    <div class="absolute -right-10 -top-10 w-40 h-40 rounded-full bg-[#4F8EF7]/20 blur-2xl pointer-events-none" aria-hidden="true"></div>
                    <div class="relative z-10 flex items-start justify-between">
                        <img src="{{ asset('assets/logo/libraria-mark.svg') }}" alt="" class="w-8 h-8" aria-hidden="true">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $member->status === 'active' ? 'bg-success/20 text-white' : 'bg-danger/20 text-white' }}">{{ ucfirst($member->status) }}</span>
                    </div>
                    <div class="relative z-10 flex items-center gap-3 pt-3">
                        <span class="w-12 h-[3.75rem] rounded-lg bg-white/15 border border-white/25 flex items-center justify-center font-poppins font-bold text-[20px] flex-shrink-0" aria-hidden="true">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                        <div class="min-w-0">
                            <span class="font-poppins text-[16px] font-semibold truncate block">{{ $member->name }}</span>
                            <span class="text-[11px] font-mono tracking-widest text-[#D4B483]">{{ $member->member_code }}</span>
                            <span class="block text-[11px] text-white/70 truncate">{{ $member->email }}</span>
                        </div>
                    </div>
                    <div class="relative z-10 flex items-end justify-between pt-3 mt-3 border-t border-white/10">
                        <span class="text-[9px] uppercase tracking-wider text-white/60">Masa Aktif</span>
                        <span class="text-[12px] font-bold tracking-widest">{{ $member->active_until ? \Carbon\Carbon::parse($member->active_until)->format('d M Y') : '—' }}</span>
                    </div>
                </div>
                <dl class="grid grid-cols-2 gap-2 mt-4 text-[13px]">
                    <div class="bg-[#F0F3FF] dark:bg-[#1A2440] rounded-lg p-2.5">
                        <dt class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Telepon</dt>
                        <dd class="font-semibold text-primary dark:text-white truncate">{{ $member->phone ?? '—' }}</dd>
                    </div>
                    <div class="bg-[#F0F3FF] dark:bg-[#1A2440] rounded-lg p-2.5">
                        <dt class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Terdaftar</dt>
                        <dd class="font-semibold text-primary dark:text-white">{{ $member->created_at->format('M Y') }}</dd>
                    </div>
                </dl>
                <a href="/member/profile" class="w-full mt-3 py-2.5 rounded-lg bg-[#F0F3FF] dark:bg-[#1A2440] hover:bg-[#E7EEFF] dark:hover:bg-[#263252] text-[14px] font-medium text-primary dark:text-white flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]" aria-hidden="true">badge</span>Kelola Profil
                </a>
            </div>

            <div class="bg-white dark:bg-[#131B2E] rounded-xl border border-line dark:border-[#263252] p-6">
                <h2 class="font-poppins text-[16px] text-primary dark:text-white font-bold mb-2">Informasi Layanan</h2>
                <div class="space-y-2.5 text-[13px] text-[#45464E] dark:text-[#9AA7C2]">
                    <p class="flex items-start gap-2"><span class="material-symbols-outlined text-[18px] text-secondary dark:text-[#9CC2FF] shrink-0" aria-hidden="true">info</span><span>Peminjaman dan pengembalian buku diproses oleh petugas perpustakaan.</span></p>
                    <p class="flex items-start gap-2"><span class="material-symbols-outlined text-[18px] text-[#AE9163] shrink-0" aria-hidden="true">schedule</span><span>Jam layanan: <strong>08:00 – 17:00 WIB</strong></span></p>
                    <p class="flex items-start gap-2"><span class="material-symbols-outlined text-[18px] text-[#AE9163] shrink-0" aria-hidden="true">contact_support</span><span>Hubungi petugas bila Membership Anda bermasalah.</span></p>
                </div>
            </div>
        </div>
    </div>
</div>