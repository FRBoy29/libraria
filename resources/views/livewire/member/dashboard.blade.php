<div class="space-y-6" x-data="{ cardModal: false }">
    @php($today = now()->toDateString())

    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-2xl bg-[#F0F3FF] dark:bg-[#131B2E] border border-line dark:border-[#263252] p-6 lg:p-8">
        <div class="absolute -right-24 -top-24 w-96 h-96 rounded-full bg-brand/10 blur-3xl pointer-events-none" aria-hidden="true"></div>
        <div class="absolute right-1/3 -bottom-24 w-64 h-64 rounded-full bg-gold/10 blur-2xl pointer-events-none" aria-hidden="true"></div>
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="flex flex-col gap-3 max-w-2xl">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white dark:bg-[#222A3D] text-brand dark:text-[#9CC2FF] text-[11px] tracking-wider uppercase font-semibold border border-line dark:border-transparent">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand animate-pulse" aria-hidden="true"></span>
                        Portal Pemustaka Libraria
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-gold/15 dark:bg-[#5c451e]/40 text-[#8A5A1D] dark:text-[#e3c290] text-[11px] tracking-wide">
                        <span class="material-symbols-outlined text-[14px]" aria-hidden="true">play_arrow</span>
                        <span>More Than Books. A Brighter Tomorrow.</span>
                    </span>
                </div>
                <h1 class="font-poppins text-[32px] leading-[40px] font-semibold text-navy dark:text-white tracking-tight">
                    Selamat datang kembali, <span class="text-brand dark:text-[#9CC2FF] font-bold">{{ $firstName }}!</span>
                </h1>
                <p class="text-[14px] text-[#45464E] dark:text-[#9AA7C2] leading-relaxed">
                    Kamu memiliki <span class="text-brand dark:text-[#9CC2FF] font-semibold">{{ $activeQty }} buku</span> yang sedang dipinjam.
                    @if($overdueCount > 0)
                        <span class="text-error dark:text-[#FFB4AB] font-semibold">Ada {{ $overdueCount }} yang melewati batas jatuh tempo.</span>
                    @else
                        Pastikan mengembalikan sebelum batas jatuh tempo demi ketertiban sirkulasi koleksi bersama.
                    @endif
                </p>
            </div>
            <div class="flex flex-wrap sm:flex-nowrap items-center gap-2 shrink-0">
                <a href="/member/books" class="inline-flex items-center justify-center gap-1.5 px-4 py-3 rounded-xl bg-brand dark:bg-[#508ff8] text-white dark:text-[#002f68] font-semibold text-[14px] hover:brightness-110 active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-[20px]" aria-hidden="true">add_circle</span><span>+ Jelajahi Katalog Buku</span>
                </a>
                <button type="button" @click="cardModal = true" class="inline-flex items-center justify-center gap-1.5 px-4 py-3 rounded-xl bg-[#E7EEFF] dark:bg-[#222A3D] text-navy dark:text-white font-medium text-[14px] hover:bg-[#D8E3FB] dark:hover:bg-[#2d3449] active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-[20px] text-[#8A5A1D] dark:text-[#e3c290]" aria-hidden="true">badge</span><span>Kartu Anggota Digital</span>
                </button>
            </div>
        </div>
    </div>

    {{-- KPI cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="relative overflow-hidden rounded-xl bg-[#F0F3FF] dark:bg-[#171f33] p-4 flex flex-col justify-between gap-4 border border-line dark:border-[#263252] hover:bg-[#E7EEFF] dark:hover:bg-[#222A3D] transition-colors">
            <div class="flex items-start justify-between">
                <div class="flex flex-col">
                    <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wider font-semibold">Sedang Dipinjam</span>
                    <div class="flex items-baseline gap-1.5 mt-1">
                        <span class="font-poppins text-[36px] leading-none font-bold text-navy dark:text-white">{{ $activeQty }}</span>
                        <span class="text-[14px] text-[#45464E] dark:text-[#9AA7C2] font-medium">Buku</span>
                    </div>
                </div>
                <span class="w-11 h-11 rounded-xl bg-brand/10 text-brand dark:text-[#9CC2FF] flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">menu_book</span></span>
            </div>
            <div class="flex items-center justify-between pt-1 bg-white/60 dark:bg-[#0B1326]/40 px-2.5 py-1.5 rounded-lg">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">{{ $activeCount }} transaksi aktif</span>
                <span class="text-[11px] text-brand dark:text-[#9CC2FF] font-semibold">{{ $totalTitles }} judul tersedia</span>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-xl bg-[#F0F3FF] dark:bg-[#171f33] p-4 flex flex-col justify-between gap-4 border border-line dark:border-[#263252] hover:bg-[#E7EEFF] dark:hover:bg-[#222A3D] transition-colors">
            <div class="flex items-start justify-between">
                <div class="flex flex-col">
                    <span class="text-[11px] text-secondary dark:text-[#9CC2FF] uppercase tracking-wider font-semibold">Batas Jatuh Tempo</span>
                    <div class="flex items-baseline gap-1.5 mt-1">
                        <span class="font-poppins text-[24px] leading-tight font-bold text-secondary dark:text-[#9CC2FF]">{{ $nearest ? \Carbon\Carbon::parse($nearest->due_at)->format('d M Y') : '—' }}</span>
                    </div>
                </div>
                <span class="w-11 h-11 rounded-xl bg-gold/20 text-[#8A5A1D] dark:text-[#e3c290] flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">schedule</span></span>
            </div>
            <div class="flex items-center justify-between pt-1 bg-white/60 dark:bg-[#0B1326]/40 px-2.5 py-1.5 rounded-lg">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] truncate">{{ $nearestBook ?? 'Tidak ada pinjaman' }}</span>
                @if($nearest)
                    @if($nearest->due_at < $today)
                        <span class="text-[11px] text-error dark:text-[#FFB4AB] font-semibold shrink-0">Terlambat</span>
                    @else
                        <span class="text-[11px] text-secondary dark:text-[#9CC2FF] font-semibold shrink-0">Sisa {{ $nearestDays }} hari lagi</span>
                    @endif
                @endif
            </div>
        </div>

        <div class="relative overflow-hidden rounded-xl bg-[#F0F3FF] dark:bg-[#171f33] p-4 flex flex-col justify-between gap-4 border border-line dark:border-[#263252] hover:bg-[#E7EEFF] dark:hover:bg-[#222A3D] transition-colors">
            <div class="flex items-start justify-between">
                <div class="flex flex-col">
                    <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wider font-semibold">Total Riwayat Baca</span>
                    <div class="flex items-baseline gap-1.5 mt-1">
                        <span class="font-poppins text-[36px] leading-none font-bold text-navy dark:text-white">{{ $historyQty }}</span>
                        <span class="text-[14px] text-[#45464E] dark:text-[#9AA7C2] font-medium">Buku</span>
                    </div>
                </div>
                <span class="w-11 h-11 rounded-xl bg-brand/15 text-brand dark:text-[#9CC2FF] flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">check_circle</span></span>
            </div>
            <div class="flex items-center justify-between pt-1 bg-white/60 dark:bg-[#0B1326]/40 px-2.5 py-1.5 rounded-lg">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Eksemplar telah dikembalikan</span>
                <a href="/member/history" class="text-[11px] text-brand dark:text-[#9CC2FF] font-semibold hover:underline">Lihat</a>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-xl bg-[#F0F3FF] dark:bg-[#171f33] p-4 flex flex-col justify-between gap-4 border border-line dark:border-[#263252] hover:bg-[#E7EEFF] dark:hover:bg-[#222A3D] transition-colors">
            <div class="flex items-start justify-between">
                <div class="flex flex-col">
                    <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wider font-semibold">Status Keanggotaan</span>
                    <div class="flex items-baseline gap-1.5 mt-1">
                        <span class="font-poppins text-[24px] leading-tight font-bold {{ $member->status === 'active' ? 'text-success' : 'text-error dark:text-[#FFB4AB]' }}">{{ ucfirst($member->status) }}</span>
                    </div>
                </div>
                <span class="w-11 h-11 rounded-xl bg-success/10 text-success flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">verified_user</span></span>
            </div>
            <div class="flex items-center justify-between pt-1 bg-white/60 dark:bg-[#0B1326]/40 px-2.5 py-1.5 rounded-lg">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] truncate">Berlaku s/d {{ $member->active_until ? \Carbon\Carbon::parse($member->active_until)->format('d M Y') : '—' }}</span>
                <a href="/member/profile" class="text-[11px] text-brand dark:text-[#9CC2FF] font-semibold hover:underline">Kelola</a>
            </div>
        </div>
    </div>

    {{-- Dua kolom --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <div class="lg:col-span-8 flex flex-col gap-6">
            {{-- Buku sedang dipinjam --}}
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-brand" aria-hidden="true"></span>
                        <h2 class="font-poppins text-[20px] text-navy dark:text-white font-semibold tracking-tight">Buku Sedang Dipinjam &amp; Status Pengembalian</h2>
                    </div>
                    <a href="/member/borrowings" class="text-[12px] text-brand dark:text-[#9CC2FF] hover:underline flex items-center gap-0.5 font-medium">Lihat Semua <span class="material-symbols-outlined text-[16px]" aria-hidden="true">arrow_forward</span></a>
                </div>
                @forelse($activeDetails as $d)
                    @php($b = $d->borrowing)
                    <div class="p-4 rounded-2xl bg-[#F0F3FF] dark:bg-[#171f33] border border-line dark:border-[#263252] flex flex-col md:flex-row items-start md:items-center justify-between gap-4 hover:bg-[#E7EEFF] dark:hover:bg-[#222A3D] transition-all">
                        <div class="flex items-start gap-4 min-w-0">
                            <div class="w-14 h-[4.5rem] rounded-lg overflow-hidden bg-navy text-white flex items-center justify-center shrink-0">
                                @if($d->book?->cover)
                                    <img src="{{ asset('storage/' . $d->book->cover) }}" alt="Sampul {{ $d->book->title }}" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined text-[22px]" aria-hidden="true">menu_book</span>
                                @endif
                            </div>
                            <div class="flex flex-col gap-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <span class="px-2 py-0.5 rounded-full bg-[#D8E3FB] dark:bg-[#2d3449] text-[#45464E] dark:text-[#c2c6d5] text-[11px] uppercase">{{ $d->book?->category?->name ?? 'Umum' }}</span>
                                    @if($b && $b->due_at < $today)
                                        <span class="px-2 py-0.5 rounded-full bg-errorbox dark:bg-[#93000a]/40 text-error dark:text-[#FFB4AB] text-[11px] font-semibold">Terlambat {{ (int) \Carbon\Carbon::parse($b->due_at)->diffInDays($today) }} hari</span>
                                    @elseif($b)
                                        <span class="px-2 py-0.5 rounded-full bg-brand/10 text-brand dark:text-[#9CC2FF] text-[11px] font-semibold">Sisa {{ (int) \Carbon\Carbon::parse($today)->diffInDays($b->due_at) }} hari</span>
                                    @endif
                                </div>
                                <h3 class="font-poppins text-[20px] text-navy dark:text-white font-semibold truncate leading-tight">{{ $d->book?->title ?? '-' }}</h3>
                                <span class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">{{ $d->book?->author ?? '-' }} • ISBN: {{ $d->book?->isbn ?? '-' }}</span>
                                @if($b)
                                    <div class="flex items-center gap-3 mt-1 text-[#45464E] dark:text-[#9AA7C2] text-[11px]">
                                        <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px] text-[#75777F] dark:text-[#8c909e]" aria-hidden="true">event_available</span>Pinjam: {{ \Carbon\Carbon::parse($b->borrowed_at)->format('d M Y') }}</span>
                                        <span class="text-[#75777F] dark:text-[#424753]">•</span>
                                        <span class="flex items-center gap-1 text-secondary dark:text-[#9CC2FF] font-medium"><span class="material-symbols-outlined text-[16px]" aria-hidden="true">event_busy</span>Tenggat: {{ \Carbon\Carbon::parse($b->due_at)->format('d M Y') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 w-full md:w-auto shrink-0 justify-end pt-2 md:pt-0 border-t border-line dark:border-[#263252] md:border-0">
                            <a href="/member/books/{{ $d->book_id }}" class="px-4 py-2 rounded-xl bg-brand dark:bg-[#508ff8] text-white dark:text-[#002f68] text-[12px] font-semibold hover:brightness-110 active:scale-95 transition-all">Lihat Detail</a>
                            <a href="/member/borrowings" class="p-2 rounded-xl bg-[#E7EEFF] dark:bg-[#2d3449] text-[#45464E] dark:text-[#c2c6d5] hover:text-navy dark:hover:text-white transition-all" title="Status peminjaman"><span class="material-symbols-outlined text-[20px]" aria-hidden="true">info</span></a>
                        </div>
                    </div>
                @empty
                    <div class="p-10 rounded-2xl bg-[#F0F3FF] dark:bg-[#171f33] border border-dashed border-line dark:border-[#263252] text-center">
                        <span class="material-symbols-outlined text-[40px] text-[#AE9163]" aria-hidden="true">library_books</span>
                        <p class="text-[14px] text-navy dark:text-white font-semibold mt-2">Tidak ada buku yang sedang dipinjam</p>
                        <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2] mt-1">Jelajahi katalog untuk melihat koleksi yang tersedia.</p>
                        <a href="/member/books" class="inline-flex items-center gap-1.5 mt-4 px-4 py-2.5 rounded-xl bg-brand dark:bg-[#508ff8] text-white dark:text-[#002f68] text-[14px] font-semibold hover:brightness-110"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">search</span>Lihat Katalog</a>
                    </div>
                @endforelse
            </div>

            {{-- Rekomendasi --}}
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-gold" aria-hidden="true"></span>
                        <h2 class="font-poppins text-[20px] text-navy dark:text-white font-semibold tracking-tight">Rekomendasi Pilihan Minggu Ini</h2>
                    </div>
                    <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] hidden sm:block">Judul yang paling banyak tersedia</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @forelse($recommended as $r)
                        <div class="flex flex-col justify-between p-4 rounded-2xl bg-[#F0F3FF] dark:bg-[#171f33] border border-line dark:border-[#263252] hover:bg-[#E7EEFF] dark:hover:bg-[#222A3D] transition-all group">
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="px-2 py-0.5 rounded-full bg-[#D8E3FB] dark:bg-[#2d3449] text-[#45464E] dark:text-[#c2c6d5] text-[11px] font-semibold uppercase truncate">{{ $r->category->name ?? 'Umum' }}</span>
                                    <span class="text-[11px] text-brand dark:text-[#9CC2FF] font-mono bg-brand/10 px-2 py-0.5 rounded shrink-0">Stok {{ $r->stock }}</span>
                                </div>
                                <div class="mt-1">
                                    <h4 class="font-poppins text-[20px] text-navy dark:text-white font-semibold group-hover:text-brand dark:group-hover:text-[#9CC2FF] transition-colors line-clamp-2 leading-tight">{{ $r->title }}</h4>
                                    <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2] mt-1">{{ $r->author }}</p>
                                </div>
                                @if($r->description)
                                    <p class="text-[13px] text-[#75777F] dark:text-[#8c909e] line-clamp-3">{{ $r->description }}</p>
                                @endif
                            </div>
                            <div class="mt-4 pt-3 flex items-center justify-between border-t border-line dark:border-[#263252]">
                                <span class="flex items-center gap-1.5 text-success text-[11px]">
                                    <span class="w-2 h-2 rounded-full bg-success" aria-hidden="true"></span>Tersedia ({{ $r->stock }})
                                </span>
                                <a href="/member/books/{{ $r->id }}" class="px-3 py-1.5 rounded-lg bg-[#D8E3FB] dark:bg-[#2d3449] text-navy dark:text-white hover:bg-brand hover:text-white text-[11px] font-semibold transition-all">Lihat</a>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-full text-[13px] text-[#45464E] dark:text-[#9AA7C2] py-6 text-center">Belum ada rekomendasi. Katalog sedang kosong.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Kolom kanan --}}
        <div class="lg:col-span-4 flex flex-col gap-6">
            <div class="flex flex-col gap-2">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wider font-semibold">Identitas Pemustaka</span>
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#DEE8FF] dark:from-[#222A3D] via-[#F0F3FF] dark:via-[#171f33] to-[#F8FAFC] dark:to-[#131B2E] p-4 border-l-4 border-gold">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-7 h-7 rounded-lg bg-brand text-white flex items-center justify-center"><span class="material-symbols-outlined text-[16px]" aria-hidden="true">local_library</span></span>
                            <span class="text-[11px] tracking-wider uppercase font-semibold text-[#8A5A1D] dark:text-[#e3c290]">Libraria Digital Patron</span>
                        </div>
                        <span class="text-[11px] text-[#75777F] dark:text-[#8c909e] font-mono">{{ $member->active_until ? \Carbon\Carbon::parse($member->active_until)->format('Y') : '' }}</span>
                    </div>
                    <div class="flex flex-col gap-1 mb-4">
                        <span class="font-poppins text-[20px] text-navy dark:text-white font-bold tracking-tight">{{ $member->name }}</span>
                        <div class="flex items-center gap-2 text-[#45464E] dark:text-[#9AA7C2] text-[12px]">
                            <span class="font-mono text-brand dark:text-[#9CC2FF] font-semibold">{{ $member->member_code }}</span>
                            <span>•</span>
                            <span class="truncate">{{ ucfirst($member->status) }}</span>
                        </div>
                    </div>
                    <div class="p-3 bg-white dark:bg-[#0B1326] rounded-xl flex flex-col items-center justify-center gap-2">
                        <svg class="w-full h-9 opacity-85 text-navy dark:text-white" fill="currentColor" preserveaspectratio="none" viewBox="0 0 160 30" aria-hidden="true">
                            <rect height="30" width="3" x="0"/><rect height="30" width="1" x="5"/><rect height="30" width="4" x="8"/><rect height="30" width="2" x="15"/><rect height="30" width="5" x="20"/><rect height="30" width="2" x="28"/><rect height="30" width="1" x="33"/><rect height="30" width="4" x="36"/><rect height="30" width="2" x="43"/><rect height="30" width="6" x="47"/><rect height="30" width="2" x="56"/><rect height="30" width="3" x="60"/><rect height="30" width="1" x="66"/><rect height="30" width="5" x="70"/><rect height="30" width="2" x="78"/><rect height="30" width="4" x="83"/><rect height="30" width="1" x="90"/><rect height="30" width="3" x="94"/><rect height="30" width="6" x="100"/><rect height="30" width="2" x="109"/><rect height="30" width="3" x="114"/><rect height="30" width="1" x="120"/><rect height="30" width="5" x="124"/><rect height="30" width="3" x="132"/><rect height="30" width="2" x="138"/><rect height="30" width="4" x="143"/><rect height="30" width="2" x="150"/><rect height="30" width="4" x="155"/>
                        </svg>
                        <span class="text-[11px] text-[#75777F] dark:text-[#8c909e] tracking-widest font-mono">{{ $member->member_code }}</span>
                    </div>
                    <button type="button" @click="cardModal = true" class="w-full mt-4 py-2.5 px-4 rounded-xl bg-[#D8E3FB] dark:bg-[#2d3449] hover:bg-[#DEE8FF] dark:hover:bg-[#3b465e] text-navy dark:text-white text-[12px] font-semibold flex items-center justify-center gap-2 transition-all">
                        <span class="material-symbols-outlined text-[20px] text-brand dark:text-[#9CC2FF]" aria-hidden="true">qr_code_scanner</span>
                        <span>Tampilkan Kartu Anggota</span>
                    </button>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-[#E7EEFF] dark:bg-[#222A3D]/60 border border-line dark:border-[#263252] flex flex-col gap-2">
                <div class="flex items-center gap-1.5 text-[#8A5A1D] dark:text-[#e3c290] font-poppins text-[20px] font-semibold">
                    <span class="material-symbols-outlined" aria-hidden="true">info</span>
                    <span>Informasi Pengembalian</span>
                </div>
                <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2] leading-relaxed">
                    Pengembalian buku dilakukan melalui <strong class="text-navy dark:text-white">meja sirkulasi</strong> pada jam layanan
                    <strong class="text-navy dark:text-white">08:00 – 17:00 WIB</strong>. Pengembalian diproses oleh petugas dan stok akan bertambah otomatis.
                </p>
            </div>

            <div class="flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wider font-semibold">Aktivitas Terakhir</span>
                    <span class="material-symbols-outlined text-[#75777F] dark:text-[#8c909e] text-[20px]" aria-hidden="true">history</span>
                </div>
                <div class="p-4 rounded-2xl bg-[#F0F3FF] dark:bg-[#171f33] border border-line dark:border-[#263252] flex flex-col gap-4">
                    @forelse($recent as $r)
                        <div class="flex items-start gap-2.5">
                            <div class="w-8 h-8 rounded-lg {{ $r->status === 'returned' ? 'bg-success/10 text-success' : 'bg-brand/10 text-brand dark:text-[#9CC2FF]' }} flex items-center justify-center shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-[18px]" aria-hidden="true">{{ $r->status === 'returned' ? 'assignment_turned_in' : 'bookmark_added' }}</span>
                            </div>
                            <div class="flex flex-col gap-0.5 min-w-0">
                                <span class="text-[12px] font-semibold text-navy dark:text-white truncate">{{ $r->status === 'returned' ? 'Mengembalikan ' . ($r->book->title ?? '') : 'Meminjam ' . ($r->book->title ?? '') }}</span>
                                <div class="flex items-center gap-2 text-[#45464E] dark:text-[#9AA7C2] text-[11px]">
                                    <span class="{{ $r->status === 'returned' ? 'text-success font-medium' : '' }}">{{ $r->status === 'returned' ? 'Selesai' : 'Aktif' }}</span>
                                    <span>•</span>
                                    <span>{{ $r->status === 'returned' && $r->returned_at ? \Carbon\Carbon::parse($r->returned_at)->format('d M Y') : \Carbon\Carbon::parse($r->created_at)->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2] text-center py-3">Belum ada aktivitas.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Kartu Anggota --}}
    <div x-show="cardModal" x-cloak class="fixed inset-0 z-[100] bg-[#0B1326]/80 backdrop-blur-md flex items-center justify-center p-4" @keydown.escape.window="cardModal = false" role="dialog" aria-modal="true" aria-labelledby="member-card-title">
        <div class="bg-[#F0F3FF] dark:bg-[#131B2E] rounded-2xl max-w-md w-full p-6 shadow-2xl flex flex-col gap-4 relative border border-line dark:border-[#263252]">
            <button type="button" @click="cardModal = false" class="absolute top-4 right-4 p-1.5 rounded-lg text-[#75777F] dark:text-[#8c909e] hover:text-navy dark:hover:text-white hover:bg-[#E7EEFF] dark:hover:bg-[#222A3D] transition-colors" aria-label="Tutup"><span class="material-symbols-outlined" aria-hidden="true">close</span></button>
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[#8A5A1D] dark:text-[#e3c290]" aria-hidden="true">badge</span>
                <h3 id="member-card-title" class="font-poppins text-[20px] text-navy dark:text-white font-semibold">Kartu Pemustaka Resmi</h3>
            </div>
            <div class="p-4 rounded-xl bg-white dark:bg-[#0B1326] flex flex-col items-center gap-4 text-center">
                <div class="w-48 h-48 bg-white p-3 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-full h-full text-slate-900" fill="currentColor" viewBox="0 0 100 100" aria-hidden="true">
                        <path d="M0 0h30v30H0zM5 5h20v20H5zM10 10h10v10H10zM70 0h30v30H70zM75 5h20v20H75zM80 10h10v10H80zM0 70h30v30H0zM5 75h20v20H5zM10 80h10v10H10zM35 10h10v5h-10zM50 10h10v15h-10zM35 25h10v10h-10zM50 30h15v10h-15zM10 35h15v10h-15zM70 35h10v10h-10zM85 35h10v15h-10zM35 50h10v20h-10zM50 50h10v10h-10zM65 50h25v10h-25zM15 50h10v10h-10zM50 70h20v10h-20zM35 80h10v20h-10zM50 85h15v15h-15zM75 75h10v10h-10zM90 75h10v20h-10zM75 90h10v10h-10z"/>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="font-poppins text-[20px] text-navy dark:text-white font-bold">{{ $member->name }}</span>
                    <span class="text-[13px] text-brand dark:text-[#9CC2FF] font-mono font-semibold">{{ $member->member_code }}</span>
                    <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] mt-1">Tunjukkan kode ini kepada petugas perpustakaan saat peminjaman atau pengembalian.</span>
                </div>
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" @click="cardModal = false" class="w-full py-2.5 rounded-xl bg-brand dark:bg-[#508ff8] text-white dark:text-[#002f68] text-[12px] font-semibold hover:brightness-110">Tutup</button>
            </div>
        </div>
    </div>
</div>