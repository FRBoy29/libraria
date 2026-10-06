<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2">
                <span class="text-[11px] uppercase tracking-wider text-secondary dark:text-[#9CC2FF] font-semibold bg-secondary/15 dark:bg-[#508ff8]/20 px-2.5 py-0.5 rounded-full">Analitik Data</span>
                <span class="w-1 h-1 rounded-full bg-outline dark:bg-[#424753]" aria-hidden="true"></span>
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Rekapitulasi Perpustakaan</span>
            </div>
            <h1 class="font-poppins text-[32px] leading-[40px] text-primary dark:text-white font-semibold tracking-tight">Laporan Perpustakaan</h1>
            <p class="text-[14px] text-[#45464E] dark:text-[#9AA7C2] max-w-2xl">Analisis data peminjaman, pengembalian, anggota, dan koleksi berdasarkan filter yang dipilih.</p>
        </div>
        @if($from || $to || $status || $member_id || $category_id)
            <button wire:click="clearFilters" type="button" class="flex items-center gap-2 px-4 h-11 rounded-lg bg-[#F0F3FF] dark:bg-[#1A2440] hover:bg-[#E7EEFF] dark:hover:bg-[#263252] text-[14px] font-medium self-start lg:self-auto">
                <span class="material-symbols-outlined text-[19px]" aria-hidden="true">filter_alt_off</span>Reset Filter
            </button>
        @endif
        <button wire:click="exportExcel" type="button" class="flex items-center gap-2 px-4 h-11 rounded-lg bg-secondary text-white text-[14px] font-medium hover:brightness-110 self-start lg:self-auto">
            <span class="material-symbols-outlined text-[19px]" aria-hidden="true">file_download</span>Ekspor Excel
        </button>
    </div>

    {{-- Filters --}}
    <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
        <div class="flex flex-col gap-1">
            <label class="text-[11px] font-semibold text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wide">Dari Tanggal</label>
            <input wire:model.live="from" type="date" class="h-11 px-3 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] focus:outline-none focus:ring-2 focus:ring-secondary/20">
        </div>
        <div class="flex flex-col gap-1">
            <label class="text-[11px] font-semibold text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wide">Sampai Tanggal</label>
            <input wire:model.live="to" type="date" class="h-11 px-3 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] focus:outline-none focus:ring-2 focus:ring-secondary/20">
        </div>
        <div class="flex flex-col gap-1">
            <label class="text-[11px] font-semibold text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wide">Status</label>
            <select wire:model.live="status" class="h-11 px-3 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] focus:outline-none">
                <option value="">Semua status</option>
                <option value="borrowed">Dipinjam</option>
                <option value="returned">Dikembalikan</option>
            </select>
        </div>
        <div class="flex flex-col gap-1">
            <label class="text-[11px] font-semibold text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wide">Anggota</label>
            <select wire:model.live="member_id" class="h-11 px-3 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] focus:outline-none">
                <option value="">Semua anggota</option>
                @foreach($memberOptions as $m)<option value="{{ $m->id }}">{{ $m->member_code }} — {{ $m->name }}</option>@endforeach
            </select>
        </div>
        <div class="flex flex-col gap-1">
            <label class="text-[11px] font-semibold text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wide">Kategori Buku</label>
            <select wire:model.live="category_id" class="h-11 px-3 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] focus:outline-none">
                <option value="">Semua kategori</option>
                @foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
            </select>
        </div>
    </div>

    {{-- Summary --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Peminjaman</span>
                <span class="font-poppins text-[24px] leading-8 text-primary dark:text-white font-semibold mt-0.5">{{ number_format($summary['borrowing']) }}</span>
                <span class="text-[11px] text-secondary dark:text-[#9CC2FF] mt-1">transaksi</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] flex items-center justify-center text-secondary dark:text-[#9CC2FF]"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">bookmark_add</span></span>
        </div>
        <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Pengembalian</span>
                <span class="font-poppins text-[24px] leading-8 text-primary dark:text-white font-semibold mt-0.5">{{ number_format($summary['returned']) }}</span>
                <span class="text-[11px] text-success flex items-center gap-0.5 mt-1 font-medium"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">check_circle</span> transaksi</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] flex items-center justify-center text-success"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">assignment_return</span></span>
        </div>
        <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Anggota Terlibat</span>
                <span class="font-poppins text-[24px] leading-8 text-primary dark:text-white font-semibold mt-0.5">{{ number_format($summary['members']) }}</span>
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] mt-1">orang</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] flex items-center justify-center text-navy dark:text-white"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">group</span></span>
        </div>
        <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border {{ $summary['overdue'] > 0 ? 'border-red-200 dark:border-[#BA1A1A]/50' : 'border-line dark:border-[#263252]' }} flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-error dark:text-[#FFB4AB] font-semibold uppercase tracking-wide">Total Terlambat</span>
                <span class="font-poppins text-[24px] leading-8 text-error dark:text-[#FFB4AB] font-semibold mt-0.5">{{ number_format($summary['overdue']) }}</span>
                <span class="text-[11px] text-error dark:text-[#FFB4AB] mt-1">seluruh periode</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-errorbox dark:bg-[#BA1A1A]/20 flex items-center justify-center text-error dark:text-[#FFB4AB]"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">warning</span></span>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="flex items-center gap-1 bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] p-1.5 rounded-xl w-fit max-w-full overflow-x-auto">
        @foreach(['borrowing' => 'Laporan Peminjaman', 'returning' => 'Laporan Pengembalian', 'books' => 'Laporan Buku', 'members' => 'Laporan Anggota'] as $val => $label)
            <button wire:click="$set('tab', '{{ $val }}')" type="button" class="px-3.5 py-2 rounded-lg text-[13px] font-semibold whitespace-nowrap transition-all {{ $tab === $val ? 'bg-secondary text-white shadow-sm' : 'text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440]' }}">{{ $label }}</button>
        @endforeach
    </div>

    {{-- Tables --}}
    <div class="rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] overflow-hidden">
        <div class="overflow-x-auto">
            @if($tab === 'borrowing')
                <table class="w-full text-left">
                    <thead class="bg-[#F0F3FF] dark:bg-[#0B1326] text-[#45464E] dark:text-[#9AA7C2] text-[12px] uppercase tracking-wider border-b border-line dark:border-[#263252]">
                        <tr><th class="py-3.5 px-4 w-16">ID</th><th class="py-3.5 px-4">Anggota</th><th class="py-3.5 px-4 min-w-[200px]">Buku</th><th class="py-3.5 px-4">Tanggal Pinjam</th><th class="py-3.5 px-4">Jatuh Tempo</th><th class="py-3.5 px-4">Status</th></tr>
                    </thead>
                    <tbody class="text-[14px]">
                        @forelse($borrowings as $b)
                            <tr class="hover:bg-[#F0F3FF]/60 dark:hover:bg-[#1A2440] border-b border-line dark:border-[#263252]">
                                <td class="py-3.5 px-4 font-mono text-[13px] text-[#45464E] dark:text-[#9AA7C2]">#{{ $b->id }}</td>
                                <td class="py-3.5 px-4"><span class="text-primary dark:text-white font-semibold">{{ $b->member->name ?? '-' }}</span><span class="block text-[11px] text-[#45464E] dark:text-[#9AA7C2]">{{ $b->member->member_code ?? '' }}</span></td>
                                <td class="py-3.5 px-4">@foreach($b->details as $d)<span class="block truncate">{{ $d->book->title ?? '-' }} ×{{ $d->quantity }}</span>@endforeach</td>
                                <td class="py-3.5 px-4 whitespace-nowrap text-[#45464E] dark:text-[#9AA7C2]">{{ \Carbon\Carbon::parse($b->borrowed_at)->format('d M Y') }}</td>
                                <td class="py-3.5 px-4 whitespace-nowrap text-[#45464E] dark:text-[#9AA7C2]">{{ \Carbon\Carbon::parse($b->due_at)->format('d M Y') }}</td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @if($b->status === 'returned')
                                        <span class="px-2.5 py-1 rounded-md bg-success/15 text-success text-[12px] font-medium">Dikembalikan</span>
                                    @elseif($b->due_at < now()->toDateString())
                                        <span class="px-2.5 py-1 rounded-md bg-errorbox dark:bg-[#BA1A1A]/20 text-error dark:text-[#FFB4AB] text-[12px] font-medium">Terlambat</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-md bg-secondary/15 dark:bg-[#508ff8]/20 text-secondary dark:text-[#9CC2FF] text-[12px] font-medium">Dipinjam</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="py-10 text-center text-[#45464E] dark:text-[#9AA7C2]">Tidak ada data peminjaman pada filter ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            @elseif($tab === 'returning')
                <table class="w-full text-left">
                    <thead class="bg-[#F0F3FF] dark:bg-[#0B1326] text-[#45464E] dark:text-[#9AA7C2] text-[12px] uppercase tracking-wider border-b border-line dark:border-[#263252]">
                        <tr><th class="py-3.5 px-4 min-w-[200px]">Buku</th><th class="py-3.5 px-4">Anggota</th><th class="py-3.5 px-4 text-center">Qty</th><th class="py-3.5 px-4">Tanggal Kembali</th></tr>
                    </thead>
                    <tbody class="text-[14px]">
                        @forelse($returns as $r)
                            <tr class="hover:bg-[#F0F3FF]/60 dark:hover:bg-[#1A2440] border-b border-line dark:border-[#263252]">
                                <td class="py-3.5 px-4 text-primary dark:text-white font-semibold">{{ $r->book->title ?? '-' }}</td>
                                <td class="py-3.5 px-4">{{ $r->borrowing->member->name ?? '-' }}</td>
                                <td class="py-3.5 px-4 text-center">{{ $r->quantity }}</td>
                                <td class="py-3.5 px-4 whitespace-nowrap text-[#45464E] dark:text-[#9AA7C2]">{{ $r->returned_at ? \Carbon\Carbon::parse($r->returned_at)->format('d M Y H:i') : '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-10 text-center text-[#45464E] dark:text-[#9AA7C2]">Belum ada data pengembalian.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            @elseif($tab === 'books')
                <table class="w-full text-left">
                    <thead class="bg-[#F0F3FF] dark:bg-[#0B1326] text-[#45464E] dark:text-[#9AA7C2] text-[12px] uppercase tracking-wider border-b border-line dark:border-[#263252]">
                        <tr><th class="py-3.5 px-4 min-w-[220px]">Judul</th><th class="py-3.5 px-4">Penulis</th><th class="py-3.5 px-4">Kategori</th><th class="py-3.5 px-4 text-center">Stok</th><th class="py-3.5 px-4 text-center">Dipinjam</th></tr>
                    </thead>
                    <tbody class="text-[14px]">
                        @forelse($books as $b)
                            @php($loan = \App\Models\BorrowingDetail::where('book_id', $b->id)->where('status', 'borrowed')->sum('quantity'))
                            <tr class="hover:bg-[#F0F3FF]/60 dark:hover:bg-[#1A2440] border-b border-line dark:border-[#263252]">
                                <td class="py-3.5 px-4 text-primary dark:text-white font-semibold">{{ $b->title }}</td>
                                <td class="py-3.5 px-4 text-[#45464E] dark:text-[#9AA7C2]">{{ $b->author }}</td>
                                <td class="py-3.5 px-4"><span class="px-2 py-0.5 rounded-md bg-navy/90 dark:bg-[#263252] text-[#eff1f3] dark:text-[#DAE2FD] text-[11px]">{{ $b->category->name ?? '—' }}</span></td>
                                <td class="py-3.5 px-4 text-center font-semibold text-primary dark:text-white">{{ $b->stock }}</td>
                                <td class="py-3.5 px-4 text-center text-[#45464E] dark:text-[#9AA7C2]">{{ $loan }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-10 text-center text-[#45464E] dark:text-[#9AA7C2]">Tidak ada buku pada filter ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            @else
                <table class="w-full text-left">
                    <thead class="bg-[#F0F3FF] dark:bg-[#0B1326] text-[#45464E] dark:text-[#9AA7C2] text-[12px] uppercase tracking-wider border-b border-line dark:border-[#263252]">
                        <tr><th class="py-3.5 px-4">Member Code</th><th class="py-3.5 px-4">Nama</th><th class="py-3.5 px-4">Kontak</th><th class="py-3.5 px-4">Status</th><th class="py-3.5 px-4 text-center">Total Peminjaman</th></tr>
                    </thead>
                    <tbody class="text-[14px]">
                        @forelse($members as $m)
                            <tr class="hover:bg-[#F0F3FF]/60 dark:hover:bg-[#1A2440] border-b border-line dark:border-[#263252]">
                                <td class="py-3.5 px-4 font-mono text-[13px] text-[#45464E] dark:text-[#9AA7C2]">{{ $m->member_code }}</td>
                                <td class="py-3.5 px-4 text-primary dark:text-white font-semibold">{{ $m->name }}</td>
                                <td class="py-3.5 px-4 text-[#45464E] dark:text-[#9AA7C2]">{{ $m->email }}</td>
                                <td class="py-3.5 px-4">
                                    @if($m->status === 'active')
                                        <span class="px-2.5 py-1 rounded-md bg-success/15 text-success text-[12px] font-medium">Aktif</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-md bg-danger/15 text-danger text-[12px] font-medium">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center font-semibold text-primary dark:text-white">{{ $m->borrowings_count }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-10 text-center text-[#45464E] dark:text-[#9AA7C2]">Tidak ada anggota pada filter ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            @endif
        </div>
        <div class="p-4 text-[12px] text-[#45464E] dark:text-[#9AA7C2] border-t border-line dark:border-[#263252] flex items-center justify-between flex-wrap gap-2">
            <span>Maksimal 100 baris ditampilkan per laporan.</span>
            <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]" aria-hidden="true">info</span>Filter tanggal/status/anggota berlaku pada tab peminjaman, pengembalian, dan anggota.</span>
        </div>
    </div>

    {{-- Trend --}}
    <div class="bg-white dark:bg-[#131B2E] rounded-xl p-6 border border-line dark:border-[#263252]">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 gap-2 border-b border-line dark:border-[#263252]">
            <div>
                <h2 class="font-poppins text-[24px] text-primary dark:text-white font-bold">Tren Peminjaman Mingguan</h2>
                <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">Volume peminjaman 7 hari terakhir</p>
            </div>
            <div class="flex items-center gap-1.5 text-[12px] font-medium text-primary dark:text-white"><span class="w-3 h-3 rounded-full bg-brand" aria-hidden="true"></span> Peminjaman</div>
        </div>
        <div class="pt-4">
            <div class="h-48 w-full flex items-end justify-between gap-2 px-2">
                @foreach($trend as $i => $v)
                    <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end group">
                        <div class="relative w-full flex items-end justify-center h-36">
                            <div class="w-6 sm:w-8 bg-brand rounded-t group-hover:brightness-110 transition-all" style="height: {{ $v > 0 ? max(4, round($v / $trendMax * 100)) : 2 }}%" title="{{ $v }} peminjaman">
                                <div class="opacity-0 group-hover:opacity-100 absolute -top-7 left-1/2 -translate-x-1/2 bg-navy text-white text-[11px] px-1.5 py-0.5 rounded pointer-events-none">{{ $v }}</div>
                            </div>
                        </div>
                        <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">{{ now()->subDays(6 - $i)->format('D') }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>