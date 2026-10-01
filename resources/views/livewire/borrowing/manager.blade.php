<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2">
                <span class="text-[11px] uppercase tracking-wider text-secondary dark:text-[#9CC2FF] font-semibold bg-secondary/15 dark:bg-[#508ff8]/20 px-2.5 py-0.5 rounded-full">Sirkulasi Terpadu</span>
                <span class="w-1 h-1 rounded-full bg-outline dark:bg-[#424753]" aria-hidden="true"></span>
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Modul Peminjaman</span>
            </div>
            <h1 class="font-poppins text-[32px] leading-[40px] text-primary dark:text-white font-semibold tracking-tight">Peminjaman Buku</h1>
            <p class="text-[14px] text-[#45464E] dark:text-[#9AA7C2] max-w-2xl">Catat transaksi peminjaman anggota, cek ketersediaan stok, dan pantau batas pengembalian.</p>
        </div>
        <div class="flex items-center gap-2 self-start lg:self-auto">
            <button wire:click="openCreate" type="button" class="flex items-center gap-2 px-5 h-11 rounded-lg bg-secondary text-white text-[14px] font-medium hover:brightness-110">
                <span class="material-symbols-outlined text-[20px]" aria-hidden="true">add_circle</span><span>Catat Peminjaman</span>
            </button>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Transaksi Aktif</span>
                <span class="font-poppins text-[24px] leading-8 text-primary dark:text-white font-semibold mt-0.5">{{ number_format($activeCount) }}</span>
                <span class="text-[11px] text-secondary dark:text-[#9CC2FF] mt-1">{{ $borrowedQty }} eksemplar keluar</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] flex items-center justify-center text-secondary dark:text-[#9CC2FF]"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">sync_alt</span></span>
        </div>
        <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border {{ $overdueCount > 0 ? 'border-red-200 dark:border-[#BA1A1A]/50' : 'border-line dark:border-[#263252]' }} flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-error dark:text-[#FFB4AB] font-semibold uppercase tracking-wide">Jatuh Tempo</span>
                <span class="font-poppins text-[24px] leading-8 text-error dark:text-[#FFB4AB] font-semibold mt-0.5">{{ number_format($overdueCount) }}</span>
                <span class="text-[11px] text-error dark:text-[#FFB4AB] mt-1">perlu follow-up</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-errorbox dark:bg-[#BA1A1A]/20 flex items-center justify-center text-error dark:text-[#FFB4AB]"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">warning</span></span>
        </div>
        <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Dikembalikan Hari Ini</span>
                <span class="font-poppins text-[24px] leading-8 text-primary dark:text-white font-semibold mt-0.5">{{ number_format($returnedToday) }}</span>
                <span class="text-[11px] text-success flex items-center gap-0.5 mt-1 font-medium"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">check_circle</span> eksemplar</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] flex items-center justify-center text-success"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">assignment_return</span></span>
        </div>
        <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Anggota Peminjam</span>
                <span class="font-poppins text-[24px] leading-8 text-primary dark:text-white font-semibold mt-0.5">{{ number_format($members->count()) }}</span>
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] mt-1">aktif &amp; layak</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] flex items-center justify-center text-navy dark:text-white"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">group</span></span>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex flex-col lg:flex-row lg:items-center justify-between gap-3">
        <div class="relative flex-1 min-w-[240px]">
            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[#75777F] dark:text-[#8c909e] text-[20px] pointer-events-none" aria-hidden="true">search</span>
            <input wire:model.live="search" type="text" class="w-full h-11 pl-11 pr-4 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[14px] placeholder:text-[#75777F] dark:placeholder:text-[#8c909e] focus:outline-none focus:ring-2 focus:ring-secondary/20" placeholder="Cari anggota atau judul buku..." aria-label="Cari peminjaman">
        </div>
        <div class="flex items-center gap-2">
            @if($search || $filterStatus)
                <button wire:click="clearFilters" type="button" class="flex items-center gap-1.5 px-3 h-11 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[13px] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440]"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">filter_alt_off</span>Reset</button>
            @endif
            <div class="flex items-center bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] p-1 rounded-lg">
                @foreach(['' => 'Semua', 'borrowed' => 'Aktif', 'overdue' => 'Terlambat', 'returned' => 'Selesai'] as $val => $label)
                    <button wire:click="$set('filterStatus', '{{ $val }}')" type="button" class="px-3 py-1.5 rounded-md text-[12px] font-semibold transition-all {{ $filterStatus === $val ? 'bg-white dark:bg-[#263252] text-primary dark:text-white shadow-sm' : 'text-[#45464E] dark:text-[#9AA7C2]' }}">{{ $label }}</button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-[#F0F3FF] dark:bg-[#0B1326] text-[#45464E] dark:text-[#9AA7C2] text-[12px] uppercase tracking-wider border-b border-line dark:border-[#263252]">
                    <tr>
                        <th class="py-3.5 px-4 w-16">ID</th>
                        <th class="py-3.5 px-4 min-w-[180px]">Anggota</th>
                        <th class="py-3.5 px-4 min-w-[220px]">Buku</th>
                        <th class="py-3.5 px-4">Pinjam</th>
                        <th class="py-3.5 px-4">Jatuh Tempo</th>
                        <th class="py-3.5 px-4 min-w-[150px]">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-[14px]">
                    @php($today = now()->toDateString())
                    @forelse($borrowings as $b)
                        <tr class="hover:bg-[#F0F3FF]/60 dark:hover:bg-[#1A2440] transition-colors border-b border-line dark:border-[#263252]">
                            <td class="py-3.5 px-4 font-mono text-[13px] text-[#45464E] dark:text-[#9AA7C2]">#{{ $b->id }}</td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-8 h-8 rounded-full bg-navy text-white flex items-center justify-center font-poppins font-semibold text-[13px] flex-shrink-0" aria-hidden="true">{{ strtoupper(substr($b->member->name ?? '?', 0, 1)) }}</span>
                                    <div class="min-w-0">
                                        <span class="text-primary dark:text-white font-semibold truncate block">{{ $b->member->name ?? '-' }}</span>
                                        <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">{{ $b->member->member_code ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                @foreach($b->details as $d)
                                    <span class="block truncate">{{ $d->book->title ?? '-' }} <span class="text-[#45464E] dark:text-[#9AA7C2]">×{{ $d->quantity }}</span></span>
                                @endforeach
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-[#45464E] dark:text-[#9AA7C2]">{{ \Carbon\Carbon::parse($b->borrowed_at)->format('d M Y') }}</td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-[#45464E] dark:text-[#9AA7C2]">{{ \Carbon\Carbon::parse($b->due_at)->format('d M Y') }}</td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($b->status === 'returned')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-success/15 text-success text-[12px] font-medium"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">check_circle</span>Selesai</span>
                                @elseif($b->due_at < $today)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-errorbox dark:bg-[#BA1A1A]/20 text-error dark:text-[#FFB4AB] text-[12px] font-medium"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">timer_off</span>Terlambat {{ (int) \Carbon\Carbon::parse($b->due_at)->diffInDays($today) }} hari</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-secondary/15 dark:bg-[#508ff8]/20 text-secondary dark:text-[#9CC2FF] text-[12px] font-medium"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">schedule</span>{{ (int) \Carbon\Carbon::parse($today)->diffInDays($b->due_at) }} hari lagi</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                @if($b->status === 'borrowed')
                                    <a href="/admin/returns" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-success text-white text-[12px] font-medium hover:opacity-90"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">assignment_return</span>Kembalikan</a>
                                @else
                                    <span class="text-[12px] text-[#75777F] dark:text-[#8c909e]">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="py-10 text-center text-[#45464E] dark:text-[#9AA7C2]">Belum ada transaksi peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 flex flex-col sm:flex-row items-center justify-between gap-2 border-t border-line dark:border-[#263252]">
            <span class="text-[14px] text-[#45464E] dark:text-[#9AA7C2]">Menampilkan <span class="font-semibold text-primary dark:text-white">{{ $borrowings->firstItem() ?? 0 }} - {{ $borrowings->lastItem() ?? 0 }}</span> dari <span class="font-semibold text-primary dark:text-white">{{ $borrowings->total() }}</span> transaksi</span>
            {{ $borrowings->links() }}
        </div>
    </div>

    {{-- Create drawer --}}
    @if($showDrawer)
        <div class="fixed inset-0 z-50" role="dialog" aria-modal="true" aria-labelledby="borrow-drawer-title">
            <div class="absolute inset-0 bg-[#2d3133]/50 backdrop-blur-[2px]" wire:click="closeDrawer"></div>
            <div class="absolute right-0 top-0 h-full w-full max-w-lg bg-white dark:bg-[#131B2E] shadow-2xl flex flex-col">
                <div class="p-6 flex items-center justify-between bg-[#F0F3FF] dark:bg-[#1A2440] border-b border-line dark:border-[#263252]">
                    <div class="flex flex-col">
                        <span class="text-[11px] uppercase tracking-wider text-secondary dark:text-[#9CC2FF] font-semibold">Formulir Sirkulasi</span>
                        <h2 id="borrow-drawer-title" class="font-poppins text-[20px] text-primary dark:text-white font-semibold">Catat Peminjaman</h2>
                    </div>
                    <button wire:click="closeDrawer" type="button" class="w-9 h-9 rounded-full bg-white dark:bg-[#131B2E] text-[#75777F] dark:text-[#8c909e] hover:text-primary flex items-center justify-center" aria-label="Tutup"><span class="material-symbols-outlined text-[20px]" aria-hidden="true">close</span></button>
                </div>
                <form wire:submit="save" class="p-6 flex flex-col gap-4 flex-1 overflow-y-auto">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[12px] font-semibold text-primary dark:text-white">Anggota <span class="text-error dark:text-[#FFB4AB]">*</span></label>
                        <select wire:model="member_id" class="h-11 px-3 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] focus:outline-none focus:ring-2 focus:ring-secondary/20">
                            <option value="">Pilih anggota...</option>
                            @foreach($members as $m)<option value="{{ $m->id }}">{{ $m->member_code }} — {{ $m->name }}</option>@endforeach
                        </select>
                        @error('member_id')<p class="text-[12px] text-error dark:text-[#FFB4AB]">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[12px] font-semibold text-primary dark:text-white">Buku <span class="text-error dark:text-[#FFB4AB]">*</span></label>
                        <select wire:model="book_id" class="h-11 px-3 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] focus:outline-none focus:ring-2 focus:ring-secondary/20">
                            <option value="">Pilih buku...</option>
                            @foreach($books as $b)<option value="{{ $b->id }}">{{ $b->title }} (stok {{ $b->stock }})</option>@endforeach
                        </select>
                        @error('book_id')<p class="text-[12px] text-error dark:text-[#FFB4AB]">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[12px] font-semibold text-primary dark:text-white">Jumlah <span class="text-error dark:text-[#FFB4AB]">*</span></label>
                            <input wire:model="quantity" type="number" min="1" class="h-11 px-3.5 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] focus:outline-none focus:ring-2 focus:ring-secondary/20">
                            @error('quantity')<p class="text-[12px] text-error dark:text-[#FFB4AB]">{{ $message }}</p>@enderror
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[12px] font-semibold text-primary dark:text-white">Tanggal Pinjam <span class="text-error dark:text-[#FFB4AB]">*</span></label>
                            <input wire:model="borrowed_at" type="date" class="h-11 px-3.5 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] focus:outline-none focus:ring-2 focus:ring-secondary/20">
                            @error('borrowed_at')<p class="text-[12px] text-error dark:text-[#FFB4AB]">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[12px] font-semibold text-primary dark:text-white">Tanggal Kembali <span class="text-error dark:text-[#FFB4AB]">*</span></label>
                        <input wire:model="due_at" type="date" class="h-11 px-3.5 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] focus:outline-none focus:ring-2 focus:ring-secondary/20">
                        @error('due_at')<p class="text-[12px] text-error dark:text-[#FFB4AB]">{{ $message }}</p>@enderror
                    </div>
                </form>
                <div class="p-6 bg-[#F0F3FF] dark:bg-[#1A2440] border-t border-line dark:border-[#263252] flex items-center justify-end gap-3">
                    <button wire:click="closeDrawer" type="button" class="px-4 h-11 rounded-lg text-primary dark:text-white hover:bg-[#E7EEFF] dark:hover:bg-[#263252] text-[14px]">Batal</button>
                    <button wire:click="save" type="button" class="px-5 h-11 rounded-lg bg-secondary text-white text-[14px] font-medium hover:brightness-110 shadow-sm">Simpan Peminjaman</button>
                </div>
            </div>
        </div>
    @endif
</div>