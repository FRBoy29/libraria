<div class="space-y-6">
    @php($firstName = strtok(auth()->user()->name ?? 'Admin', ' '))
    {{-- Hero --}}
    <section class="relative overflow-hidden rounded-xl text-white p-6 lg:p-8 border border-[#2A3B60]" style="background: linear-gradient(to right, #1F2D4D, #1A2642, #16223B);">
        <div class="absolute -right-12 -top-12 w-80 h-80 rounded-full bg-[#4F8EF7]/10 blur-3xl pointer-events-none" aria-hidden="true"></div>
        <div class="absolute right-1/4 -bottom-20 w-64 h-64 rounded-full bg-[#D4B483]/15 blur-2xl pointer-events-none" aria-hidden="true"></div>
        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#16223B]/80 border border-[#D4B483]/30 text-[#D4B483] text-[11px] font-semibold tracking-wider uppercase">
                    <span class="w-2 h-2 rounded-full bg-[#D4B483] animate-pulse" aria-hidden="true"></span>Panel Sirkulasi Terpadu
                </div>
                <h1 class="font-poppins text-[32px] leading-[40px] font-bold tracking-tight">Selamat bertugas kembali, {{ $firstName }}</h1>
                <p class="text-[14px] text-white/90">Sistem LIBRARIA siap mengawal kelancaran sirkulasi dan literasi hari ini.</p>
                <div class="pt-2 flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-[#D4B483]/20 border border-[#D4B483]/40 text-[#D4B483] font-medium text-[14px]">
                        <span class="material-symbols-outlined text-[16px]" aria-hidden="true">local_florist</span>
                        <span class="font-poppins">More Than Books. A Brighter Tomorrow.</span>
                    </span>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="/admin/borrowings/create" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-[#4F8EF7] text-white font-poppins font-semibold text-[14px] hover:brightness-110">
                    <span class="material-symbols-outlined text-[20px]" aria-hidden="true">add_circle</span><span>+ Catat Peminjaman</span>
                </a>
                <a href="/admin/books/create" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-white/10 text-white font-poppins font-medium text-[14px] border border-[#D4B483]/40 hover:bg-white/20">
                    <span class="material-symbols-outlined text-[20px] text-[#D4B483]" aria-hidden="true">library_add</span><span>+ Tambah Buku Baru</span>
                </a>
            </div>
        </div>
    </section>

    {{-- Stat cards --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4" aria-label="Statistik">
        <div class="bg-white rounded-xl p-4 border border-line flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[12px] text-[#45464E] uppercase tracking-wider font-semibold">Total Koleksi</span>
                <span class="w-8 h-8 rounded-lg bg-navy/10 text-navy flex items-center justify-center"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">menu_book</span></span>
            </div>
            <div class="mt-4"><div class="font-poppins text-[32px] text-navy font-bold leading-none">{{ number_format($totalTitles) }}</div><span class="text-[13px] text-[#45464E]">judul terdaftar</span></div>
            <div class="mt-3 pt-3 border-t border-line flex items-center gap-1.5 text-[11px] text-success font-medium"><span class="material-symbols-outlined text-[16px]" aria-hidden="true">trending_up</span><span>+{{ $newThisMonth }} bulan ini</span></div>
        </div>
        <div class="bg-white rounded-xl p-4 border border-line flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[12px] text-[#45464E] uppercase tracking-wider font-semibold">Buku di Rak</span>
                <span class="w-8 h-8 rounded-lg bg-brand/10 text-brand flex items-center justify-center"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">shelves</span></span>
            </div>
            <div class="mt-4"><div class="font-poppins text-[32px] text-navy font-bold leading-none">{{ number_format($availableStock) }}</div><span class="text-[13px] text-[#45464E]">eksemplar siap pinjam</span></div>
            <div class="mt-3 pt-3 border-t border-line flex items-center gap-1.5 text-[11px] text-success font-medium"><span class="inline-block w-2 h-2 rounded-full bg-success" aria-hidden="true"></span><span>{{ 100 - $inCirculation }}% ketersediaan</span></div>
        </div>
        <div class="bg-white rounded-xl p-4 border border-line flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[12px] text-[#45464E] uppercase tracking-wider font-semibold">Sedang Dipinjam</span>
                <span class="w-8 h-8 rounded-lg bg-brand/15 text-brand flex items-center justify-center"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">sync_alt</span></span>
            </div>
            <div class="mt-4"><div class="font-poppins text-[32px] text-navy font-bold leading-none">{{ number_format($borrowedQty) }}</div><span class="text-[13px] text-[#45464E]">eksemplar aktif di luar</span></div>
            <div class="mt-3 pt-3 border-t border-line flex items-center gap-1.5 text-[11px] text-brand font-medium"><span class="material-symbols-outlined text-[16px]" aria-hidden="true">timelapse</span><span>{{ $inCirculation }}% dalam peredaran</span></div>
        </div>
        <div class="bg-white rounded-xl p-4 border border-line flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[12px] text-[#45464E] uppercase tracking-wider font-semibold">Anggota Aktif</span>
                <span class="w-8 h-8 rounded-lg bg-gold/20 text-navy flex items-center justify-center"><span class="material-symbols-outlined text-[18px] text-golddark" aria-hidden="true">group</span></span>
            </div>
            <div class="mt-4"><div class="font-poppins text-[32px] text-navy font-bold leading-none">{{ number_format($activeMembers) }}</div><span class="text-[13px] text-[#45464E]">member terdaftar</span></div>
            <div class="mt-3 pt-3 border-t border-line flex items-center gap-1.5 text-[11px] text-success font-medium"><span class="material-symbols-outlined text-[16px]" aria-hidden="true">verified_user</span><span>akun aktif</span></div>
        </div>
        <div class="bg-white rounded-xl p-4 border {{ $overdueCount > 0 ? 'border-red-200' : 'border-line' }} flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[12px] text-error uppercase tracking-wider font-bold">Jatuh Tempo</span>
                <span class="w-8 h-8 rounded-lg bg-errorbox text-error flex items-center justify-center"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">warning</span></span>
            </div>
            <div class="mt-4"><div class="font-poppins text-[32px] text-error font-bold leading-none">{{ $overdueCount }}</div><span class="text-[13px] text-[#45464E]">transaksi terlambat</span></div>
            <div class="mt-3 pt-3 border-t border-line flex items-center gap-1.5 text-[11px] text-error font-semibold"><span class="material-symbols-outlined text-[16px]" aria-hidden="true">notification_important</span><span>{{ $overdueCount > 0 ? 'Perlu follow-up' : 'Nihil' }}</span></div>
        </div>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <div class="lg:col-span-7 xl:col-span-8 space-y-6">
            {{-- Chart --}}
            <div class="bg-white rounded-xl p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 gap-2 border-b border-line">
                    <div>
                        <h2 class="font-poppins text-[24px] text-navy font-bold">Aktivitas Sirkulasi Mingguan</h2>
                        <p class="text-[13px] text-[#45464E]">Perbandingan volume peminjaman versus pengembalian (6 hari terakhir)</p>
                    </div>
                    <div class="flex items-center gap-4 text-[11px]">
                        <span class="flex items-center gap-1.5 text-navy font-medium"><span class="w-3 h-3 rounded-full bg-brand" aria-hidden="true"></span> Peminjaman</span>
                        <span class="flex items-center gap-1.5 text-navy font-medium"><span class="w-3 h-3 rounded-full bg-gold" aria-hidden="true"></span> Pengembalian</span>
                    </div>
                </div>
                <div class="pt-4">
                    <div class="h-64 w-full flex items-end justify-between gap-3 px-2">
                        @foreach($chart as $i => $d)
                            <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end group cursor-default">
                                <div class="relative w-full flex items-end justify-center gap-1.5 h-48">
                                    <div class="w-4 sm:w-6 bg-brand rounded-t" style="height: {{ round($d['borrow'] / $chartMax * 100) }}%;" title="Peminjaman: {{ $d['borrow'] }}">
                                        <div class="opacity-0 group-hover:opacity-100 absolute -top-8 left-1/2 -translate-x-1/2 bg-navy text-white text-[11px] px-1.5 py-0.5 rounded pointer-events-none">{{ $d['borrow'] }}</div>
                                    </div>
                                    <div class="w-4 sm:w-6 bg-gold rounded-t" style="height: {{ round($d['return'] / $chartMax * 100) }}%;" title="Pengembalian: {{ $d['return'] }}"></div>
                                </div>
                                <span class="text-[11px] text-[#45464E] {{ $i === count($chart) - 1 ? 'text-navy font-bold' : '' }}">{{ $d['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="mt-4 pt-3 flex flex-wrap items-center justify-between text-[14px] text-[#45464E] bg-[#F0F3FF] px-3 py-2 rounded-lg border border-[#D8E3FB]">
                    <span class="flex items-center gap-1 text-[12px] text-navy"><span class="material-symbols-outlined text-[16px] text-brand" aria-hidden="true">info</span>Total {{ $chart->sum('borrow') }} peminjaman &amp; {{ $chart->sum('return') }} pengembalian pekan ini.</span>
                    <a class="text-brand font-semibold hover:underline flex items-center gap-1 text-[13px]" href="/admin/reports">Lihat Analisis Detail<span class="material-symbols-outlined text-[16px]" aria-hidden="true">arrow_forward</span></a>
                </div>
            </div>

            {{-- Popular --}}
            <div class="bg-white rounded-xl p-6">
                <div class="flex items-center justify-between pb-2">
                    <div>
                        <h2 class="font-poppins text-[24px] text-navy font-bold">Buku Terpopuler</h2>
                        <p class="text-[13px] text-[#45464E]">Koleksi dengan frekuensi peminjaman tertinggi</p>
                    </div>
                    <span class="px-2.5 py-1 rounded bg-[#DEE8FF] text-primary text-[11px]">Top {{ count($popular) }}</span>
                </div>
                <div class="space-y-3 pt-2">
                    @forelse($popular as $p)
                        <div class="p-3 rounded-lg bg-[#F0F3FF]/40 hover:bg-[#F0F3FF] transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-16 rounded overflow-hidden flex-shrink-0 bg-navy text-white flex flex-col items-center justify-center" aria-hidden="true">
                                    <span class="material-symbols-outlined text-[22px]">menu_book</span>
                                    <span class="font-poppins font-bold text-[13px]">{{ strtoupper(substr($p['book']->title, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap"><span class="text-navy font-semibold">{{ $p['book']->title }}</span><span class="px-2 py-0.5 text-[11px] rounded-full bg-[#E7EEFF] text-[#45464E]">{{ $p['book']->category->name ?? '-' }}</span></div>
                                    <p class="text-[13px] text-[#45464E]">{{ $p['book']->author }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 self-end sm:self-center">
                                <div class="text-right"><div class="font-poppins text-[20px] text-primary font-bold">{{ $p['times'] }}x</div><span class="text-[11px] text-[#45464E]">Dipinjam</span></div>
                                @if($p['book']->stock > 1)
                                    <span class="px-2.5 py-1 rounded-full text-[11px] bg-success/15 text-success font-medium flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-success" aria-hidden="true"></span> Tersedia ({{ $p['book']->stock }})</span>
                                @elseif($p['book']->stock === 1)
                                    <span class="px-2.5 py-1 rounded-full text-[11px] bg-warning/15 text-warning font-medium flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-warning" aria-hidden="true"></span> Menipis (1)</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] bg-errorbox text-error font-medium flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-error" aria-hidden="true"></span> Habis Dipinjam</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-[13px] text-[#45464E] py-4 text-center">Belum ada data peminjaman.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="lg:col-span-5 xl:col-span-4 space-y-6">
            {{-- Overdue --}}
            <div class="bg-white rounded-xl p-6">
                <div class="flex items-center justify-between pb-2">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-danger text-[22px]" aria-hidden="true">notification_important</span>
                        <h2 class="font-poppins text-[16px] text-navy font-bold">Peringatan Jatuh Tempo</h2>
                    </div>
                    <span class="px-2 py-0.5 rounded-full bg-errorbox text-error text-[11px] font-semibold">{{ $overdueCount }} Terlambat</span>
                </div>
                <p class="text-[13px] text-[#45464E] pb-2">Peminjaman melewati batas tanggal &amp; butuh follow-up.</p>
                <div class="space-y-3 pt-2">
                    @forelse($overdues->take(3) as $o)
                        <div class="p-3 rounded-lg bg-[#F0F3FF]/60 flex flex-col gap-2.5">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <div class="text-[14px] font-bold text-primary">{{ $o['borrowing']->member->name ?? '-' }}</div>
                                    <div class="text-[13px] text-[#45464E] italic">
                                        @foreach($o['borrowing']->details as $d)&lsquo;{{ $d->book->title ?? '' }}&rsquo;@if(!$loop->last), @endif@endforeach
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 rounded text-[11px] bg-errorbox text-error font-semibold whitespace-nowrap">Telat {{ $o['lateDays'] }} Hari</span>
                            </div>
                            <div class="flex items-center justify-end pt-1">
                                <a class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-success text-white text-[11px] font-medium hover:opacity-95" href="/admin/returns">
                                    <span class="material-symbols-outlined text-[15px]" aria-hidden="true">check_circle</span><span>Proses</span>
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-[13px] text-[#45464E] py-2 text-center">Tidak ada keterlambatan. Kerja bagus!</p>
                    @endforelse
                </div>
                <div class="pt-3 text-center">
                    <a class="inline-flex items-center gap-1 text-[13px] font-semibold text-secondary hover:underline" href="/admin/returns">
                        <span>Kelola Semua Keterlambatan</span><span class="material-symbols-outlined text-[16px]" aria-hidden="true">chevron_right</span>
                    </a>
                </div>
            </div>

            {{-- Recent activity --}}
            <div class="bg-white rounded-xl p-6">
                <div class="flex items-center justify-between pb-2">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary text-[22px]" aria-hidden="true">history</span>
                        <h2 class="font-poppins text-[16px] text-navy font-bold">Aktivitas Sirkulasi Terkini</h2>
                    </div>
                    <span class="w-2 h-2 rounded-full bg-success animate-pulse" aria-hidden="true"></span>
                </div>
                <div class="relative pl-6 space-y-4 pt-2 before:content-[''] before:absolute before:left-2.5 before:top-3 before:bottom-3 before:w-0.5 before:bg-[#DEE8FF]">
                    @forelse($recent as $r)
                        <div class="relative">
                            <div class="absolute -left-6 top-1 w-3.5 h-3.5 rounded-full {{ $r->status === 'returned' ? 'bg-success' : 'bg-secondary' }} ring-4 ring-white" aria-hidden="true"></div>
                            <div class="flex flex-col">
                                <div class="flex items-baseline justify-between gap-1">
                                    <span class="text-[14px] font-bold text-primary">{{ $r->borrowing->member->name ?? '-' }}</span>
                                    <span class="text-[11px] text-[#45464E]">{{ $r->status === 'returned' && $r->returned_at ? $r->returned_at->diffForHumans() : $r->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-[13px] text-[#45464E]">
                                    {{ $r->status === 'returned' ? 'Mengembalikan' : 'Meminjam' }}
                                    <span class="text-primary italic">&lsquo;{{ $r->book->title ?? '' }}&rsquo;</span>
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-[13px] text-[#45464E]">Belum ada aktivitas.</p>
                    @endforelse
                </div>
                <div class="mt-4 pt-3 text-center">
                    <a class="inline-flex items-center gap-1 text-[13px] text-primary font-semibold hover:text-secondary" href="/admin/borrowings">
                        <span>Buka Log Sirkulasi Lengkap</span><span class="material-symbols-outlined text-[16px]" aria-hidden="true">arrow_outward</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
