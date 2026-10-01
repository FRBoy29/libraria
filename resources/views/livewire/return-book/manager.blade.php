<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2">
                <span class="text-[11px] uppercase tracking-wider text-secondary dark:text-[#9CC2FF] font-semibold bg-secondary/15 dark:bg-[#508ff8]/20 px-2.5 py-0.5 rounded-full">Sirkulasi Terpadu</span>
                <span class="w-1 h-1 rounded-full bg-outline dark:bg-[#424753]" aria-hidden="true"></span>
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Modul Pengembalian</span>
            </div>
            <h1 class="font-poppins text-[32px] leading-[40px] text-primary dark:text-white font-semibold tracking-tight">Pengembalian Buku</h1>
            <p class="text-[14px] text-[#45464E] dark:text-[#9AA7C2] max-w-2xl">Proses pengembalian buku yang masih dipinjam. Stok bertambah dan status transaksi diperbarui otomatis.</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Sedang Dipinjam</span>
                <span class="font-poppins text-[24px] leading-8 text-primary dark:text-white font-semibold mt-0.5">{{ number_format($activeCount) }}</span>
                <span class="text-[11px] text-secondary dark:text-[#9CC2FF] mt-1">{{ $activeQty }} eksemplar</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] flex items-center justify-center text-secondary dark:text-[#9CC2FF]"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">sync_alt</span></span>
        </div>
        <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border {{ $overdueCount > 0 ? 'border-red-200 dark:border-[#BA1A1A]/50' : 'border-line dark:border-[#263252]' }} flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-error dark:text-[#FFB4AB] font-semibold uppercase tracking-wide">Terlambat</span>
                <span class="font-poppins text-[24px] leading-8 text-error dark:text-[#FFB4AB] font-semibold mt-0.5">{{ number_format($overdueCount) }}</span>
                <span class="text-[11px] text-error dark:text-[#FFB4AB] mt-1">prioritas tinggi</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-errorbox dark:bg-[#BA1A1A]/20 flex items-center justify-center text-error dark:text-[#FFB4AB]"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">timer_off</span></span>
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
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Total Dikembalikan</span>
                <span class="font-poppins text-[24px] leading-8 text-primary dark:text-white font-semibold mt-0.5">{{ number_format($returnedTotal) }}</span>
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] mt-1">sejak sistem aktif</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] flex items-center justify-center text-navy dark:text-white"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">history</span></span>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex flex-col lg:flex-row lg:items-center justify-between gap-3">
        <div class="relative flex-1 min-w-[240px]">
            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[#75777F] dark:text-[#8c909e] text-[20px] pointer-events-none" aria-hidden="true">search</span>
            <input wire:model.live="search" type="text" class="w-full h-11 pl-11 pr-4 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[14px] placeholder:text-[#75777F] dark:placeholder:text-[#8c909e] focus:outline-none focus:ring-2 focus:ring-secondary/20" placeholder="Cari judul buku atau nama anggota..." aria-label="Cari pengembalian">
        </div>
        <div class="flex items-center gap-2">
            @if($search || $filterStatus)
                <button wire:click="clearFilters" type="button" class="flex items-center gap-1.5 px-3 h-11 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[13px] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440]"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">filter_alt_off</span>Reset</button>
            @endif
            <div class="flex items-center bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] p-1 rounded-lg">
                @foreach(['' => 'Semua', 'overdue' => 'Terlambat', 'dueSoon' => 'Jatuh Tempo ≤ 3 Hari'] as $val => $label)
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
                        <th class="py-3.5 px-4 min-w-[220px]">Buku</th>
                        <th class="py-3.5 px-4 min-w-[160px]">Anggota</th>
                        <th class="py-3.5 px-4 text-center">Qty</th>
                        <th class="py-3.5 px-4">Jatuh Tempo</th>
                        <th class="py-3.5 px-4 min-w-[150px]">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-[14px]">
                    @php($today = now()->toDateString())
                    @forelse($actives as $d)
                        <tr class="hover:bg-[#F0F3FF]/60 dark:hover:bg-[#1A2440] transition-colors border-b border-line dark:border-[#263252]">
                            <td class="py-3.5 px-4">
                                <span class="flex items-center gap-2.5">
                                    <span class="w-8 h-8 rounded-lg bg-navy/10 dark:bg-[#263252] text-navy dark:text-white flex items-center justify-center flex-shrink-0" aria-hidden="true"><span class="material-symbols-outlined text-[18px]">menu_book</span></span>
                                    <span class="text-primary dark:text-white font-semibold">{{ $d->book->title ?? '-' }}</span>
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="text-primary dark:text-white block truncate">{{ $d->borrowing->member->name ?? '-' }}</span>
                                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">{{ $d->borrowing->member->member_code ?? '-' }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-center font-semibold text-primary dark:text-white">{{ $d->quantity }}</td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-[#45464E] dark:text-[#9AA7C2]">{{ \Carbon\Carbon::parse($d->borrowing->due_at)->format('d M Y') }}</td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($d->borrowing->due_at < $today)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-errorbox dark:bg-[#BA1A1A]/20 text-error dark:text-[#FFB4AB] text-[12px] font-medium"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">timer_off</span>Terlambat {{ (int) \Carbon\Carbon::parse($d->borrowing->due_at)->diffInDays($today) }} hari</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-secondary/15 dark:bg-[#508ff8]/20 text-secondary dark:text-[#9CC2FF] text-[12px] font-medium"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">schedule</span>{{ (int) \Carbon\Carbon::parse($today)->diffInDays($d->borrowing->due_at) }} hari lagi</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                @if($confirmingReturn === $d->id)
                                    <span class="inline-flex items-center gap-1.5">
                                        <button wire:click="returnDetail({{ $d->id }})" type="button" class="px-2.5 py-1 rounded-md bg-danger text-white text-[12px] font-medium">Ya, proses</button>
                                        <button wire:click="cancel" type="button" class="px-2.5 py-1 rounded-md bg-[#F0F3FF] dark:bg-[#1A2440] text-[12px]">Batal</button>
                                    </span>
                                @else
                                    <button wire:click="confirm({{ $d->id }})" type="button" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-success text-white text-[12px] font-medium hover:opacity-90"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">assignment_return</span>Kembalikan</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-10 text-center text-[#45464E] dark:text-[#9AA7C2]">Tidak ada buku yang sedang dipinjam. Kerja bagus!</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 flex flex-col sm:flex-row items-center justify-between gap-2 border-t border-line dark:border-[#263252]">
            <span class="text-[14px] text-[#45464E] dark:text-[#9AA7C2]">Menampilkan <span class="font-semibold text-primary dark:text-white">{{ $actives->firstItem() ?? 0 }} - {{ $actives->lastItem() ?? 0 }}</span> dari <span class="font-semibold text-primary dark:text-white">{{ $actives->total() }}</span> buku aktif</span>
            {{ $actives->links() }}
        </div>
    </div>
</div>