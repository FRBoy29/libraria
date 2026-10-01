<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2">
                <span class="text-[11px] uppercase tracking-wider text-secondary dark:text-[#9CC2FF] font-semibold bg-secondary/15 dark:bg-[#508ff8]/20 px-2.5 py-0.5 rounded-full">Katalog Induk Terintegrasi</span>
                <span class="w-1 h-1 rounded-full bg-outline dark:bg-[#424753]" aria-hidden="true"></span>
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Klasifikasi DDC 23</span>
            </div>
            <h1 class="font-poppins text-[32px] leading-[40px] text-primary dark:text-white font-semibold tracking-tight">Koleksi Buku Perpustakaan</h1>
            <p class="text-[14px] text-[#45464E] dark:text-[#9AA7C2] max-w-2xl">Kelola data katalog, ISBN, kategori, stok fisik, dan status ketersediaan buku secara komprehensif dan akurat.</p>
        </div>
        <div class="flex items-center gap-2 self-start lg:self-auto">
            <a href="/admin/books/export" class="flex items-center gap-2 px-4 h-11 rounded-lg bg-[#F0F3FF] dark:bg-[#1A2440] hover:bg-[#E7EEFF] dark:hover:bg-[#263252] text-[14px] font-medium">
                <span class="material-symbols-outlined text-[19px]" aria-hidden="true">file_download</span><span>Ekspor / Cetak</span>
            </a>
            <button wire:click="openCreate" type="button" class="flex items-center gap-2 px-5 h-11 rounded-lg bg-secondary text-white text-[14px] font-medium hover:brightness-110">
                <span class="material-symbols-outlined text-[20px]" aria-hidden="true">add</span><span>Tambah Buku Baru</span>
            </button>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Total Eksemplar</span>
                <span class="font-poppins text-[24px] leading-8 text-primary dark:text-white font-semibold mt-0.5">{{ number_format($totalStock) }}</span>
                <span class="text-[11px] text-success flex items-center gap-0.5 mt-1 font-medium"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">arrow_upward</span> {{ $totalStock + $borrowedQty }} total</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] flex items-center justify-center text-secondary dark:text-[#9CC2FF]"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">library_books</span></span>
        </div>
        <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Judul Terdaftar</span>
                <span class="font-poppins text-[24px] leading-8 text-primary dark:text-white font-semibold mt-0.5">{{ number_format($totalTitles) }}</span>
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] mt-1">{{ count($categories) }} Kategori Aktif</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] flex items-center justify-center text-navy dark:text-white"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">auto_stories</span></span>
        </div>
        <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Buku Dipinjam</span>
                <span class="font-poppins text-[24px] leading-8 text-primary dark:text-white font-semibold mt-0.5">{{ number_format($borrowedQty) }}</span>
                <span class="text-[11px] text-warning flex items-center gap-0.5 mt-1 font-medium"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">schedule</span> {{ $overdueBooks }} jatuh tempo</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] flex items-center justify-center text-[#AE9163]"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">sync_alt</span></span>
        </div>
        <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Tingkat Ketersediaan</span>
                <span class="font-poppins text-[24px] leading-8 text-primary dark:text-white font-semibold mt-0.5">{{ $availability }}%</span>
                <div class="w-24 bg-[#E7EEFF] dark:bg-[#263252] h-1.5 rounded-full mt-2 overflow-hidden">
                    <div class="bg-success h-full rounded-full" style="width: {{ $availability }}%"></div>
                </div>
            </div>
            <span class="w-11 h-11 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] flex items-center justify-center text-success"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">verified</span></span>
        </div>
    </div>

    {{-- Controls --}}
    <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex flex-col gap-4">
        <div class="flex flex-col lg:flex-row items-stretch lg:items-center gap-2 justify-between">
            <div class="relative flex-1 min-w-[280px]">
                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[#75777F] dark:text-[#8c909e] text-[20px] pointer-events-none" aria-hidden="true">search</span>
                <input wire:model.live="search" type="text" class="w-full h-11 pl-11 pr-4 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[14px] placeholder:text-[#75777F] dark:placeholder:text-[#8c909e] focus:outline-none focus:ring-2 focus:ring-secondary/20" placeholder="Cari berdasarkan judul buku, penulis, penerbit, atau ISBN..." aria-label="Cari buku">
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <div class="relative">
                    <select wire:model.live="filterCategory" class="appearance-none h-11 pl-3.5 pr-8 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[14px] focus:outline-none cursor-pointer">
                        <option value="">Kategori: Semua</option>
                        @foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-[#75777F] dark:text-[#8c909e] text-[18px] pointer-events-none" aria-hidden="true">expand_more</span>
                </div>
                <div class="relative">
                    <select wire:model.live="filterStatus" class="appearance-none h-11 pl-3.5 pr-8 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[14px] focus:outline-none cursor-pointer">
                        <option value="">Status: Semua</option>
                        <option value="available">Tersedia</option>
                        <option value="empty">Stok Habis</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-[#75777F] dark:text-[#8c909e] text-[18px] pointer-events-none" aria-hidden="true">expand_more</span>
                </div>
                <div class="relative">
                    <select wire:model.live="filterYear" class="appearance-none h-11 pl-3.5 pr-8 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[14px] focus:outline-none cursor-pointer">
                        <option value="">Tahun Terbit</option>
                        @foreach($years as $y)<option value="{{ $y }}">{{ $y }}</option>@endforeach
                    </select>
                    <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-[#75777F] dark:text-[#8c909e] text-[18px] pointer-events-none" aria-hidden="true">calendar_today</span>
                </div>
                @if($search || $filterCategory || $filterStatus || $filterYear)
                    <button wire:click="clearFilters" type="button" class="flex items-center gap-1.5 px-3 h-11 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[13px] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440]" title="Reset filter">
                        <span class="material-symbols-outlined text-[18px]" aria-hidden="true">filter_alt_off</span>Reset
                    </button>
                @endif
                <div class="flex items-center p-1 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] ml-auto" role="group" aria-label="Tampilan">
                    <button wire:click="setView('grid')" type="button" class="px-2.5 py-1.5 rounded transition-all {{ $view === 'grid' ? 'bg-white dark:bg-[#263252] text-secondary dark:text-[#9CC2FF] shadow-sm' : 'text-[#45464E] dark:text-[#9AA7C2] hover:text-primary' }}" title="Tampilan Kartu" aria-label="Tampilan kartu"><span class="material-symbols-outlined text-[19px] block" aria-hidden="true">grid_view</span></button>
                    <button wire:click="setView('table')" type="button" class="px-2.5 py-1.5 rounded transition-all {{ $view === 'table' ? 'bg-white dark:bg-[#263252] text-secondary dark:text-[#9CC2FF] shadow-sm' : 'text-[#45464E] dark:text-[#9AA7C2] hover:text-primary' }}" title="Tampilan Tabel" aria-label="Tampilan tabel"><span class="material-symbols-outlined text-[19px] block" aria-hidden="true">view_list</span></button>
                </div>
            </div>
        </div>
        {{-- Category chips --}}
        <div class="flex items-center gap-2 overflow-x-auto">
            <button wire:click="$set('filterCategory', '')" type="button" class="shrink-0 px-3.5 py-1.5 rounded-full text-[13px] font-medium transition-all {{ $filterCategory === '' ? 'bg-primary dark:bg-[#263252] text-white dark:text-white shadow-sm' : 'bg-[#F0F3FF] dark:bg-[#1A2440] text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#E7EEFF] dark:hover:bg-[#263252]' }}">Semua <span class="ml-1 opacity-80 font-normal">{{ $totalTitles }}</span></button>
            @foreach($categories as $c)
                <button wire:click="$set('filterCategory', '{{ $filterCategory === (string) $c->id ? '' : $c->id }}')" type="button" class="shrink-0 px-3.5 py-1.5 rounded-full text-[13px] font-medium transition-all {{ (string) $filterCategory === (string) $c->id ? 'bg-primary dark:bg-[#263252] text-white dark:text-white shadow-sm' : 'bg-[#F0F3FF] dark:bg-[#1A2440] text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#E7EEFF] dark:hover:bg-[#263252]' }}">{{ $c->name }} <span class="ml-1 text-[#75777F] dark:text-[#8c909e] font-normal">{{ $c->books_count }}</span></button>
            @endforeach
        </div>
    </div>

    {{-- Content --}}
    <div class="rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] overflow-hidden">
        @if($view === 'table')
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-[#F0F3FF] dark:bg-[#0B1326] text-[#45464E] dark:text-[#9AA7C2] text-[12px] uppercase tracking-wider border-b border-line dark:border-[#263252]">
                        <tr>
                            <th class="py-3.5 px-4 min-w-[240px]">Judul Buku &amp; Penulis</th>
                            <th class="py-3.5 px-4 min-w-[170px]">ISBN / Barcode</th>
                            <th class="py-3.5 px-4">Kategori</th>
                            <th class="py-3.5 px-4 text-center">Stok</th>
                            <th class="py-3.5 px-4 min-w-[160px]">Status</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-[14px]">
                        @forelse($books as $b)
                            <tr class="hover:bg-[#F0F3FF]/60 dark:hover:bg-[#1A2440] transition-colors border-b border-line dark:border-[#263252]">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        @if($b->cover)
                                            <img src="{{ asset('storage/' . $b->cover) }}" alt="Sampul {{ $b->title }}" class="w-9 h-12 rounded object-cover flex-shrink-0">
                                        @else
                                            <span class="w-9 h-12 rounded bg-navy text-white flex items-center justify-center font-poppins font-semibold text-[15px] flex-shrink-0" aria-hidden="true">{{ strtoupper(substr($b->title, 0, 1)) }}</span>
                                        @endif
                                        <div class="flex flex-col min-w-0">
                                            <span class="text-primary dark:text-white font-semibold truncate">{{ $b->title }}</span>
                                            <span class="text-[#45464E] dark:text-[#9AA7C2] text-[11px] mt-0.5 truncate">{{ $b->author }} <span class="text-[#75777F] dark:text-[#424753]">•</span> {{ $b->publisher ?? 'Tanpa penerbit' }} ({{ $b->publication_year ?? '—' }})</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="flex items-center gap-1.5 font-mono text-[#45464E] dark:text-[#9AA7C2] text-[11px]"><span class="material-symbols-outlined text-[15px] text-[#75777F] dark:text-[#8c909e]" aria-hidden="true">barcode</span>{{ $b->isbn }}</span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-1 rounded-md bg-navy/90 dark:bg-[#263252] text-[#eff1f3] dark:text-[#DAE2FD] text-[11px] font-medium">{{ $b->category->name ?? '—' }}</span>
                                </td>
                                <td class="py-3.5 px-4 text-center font-semibold text-primary dark:text-white">{{ $b->stock }}</td>
                                <td class="py-3.5 px-4">
                                    @if($b->stock <= 0)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-errorbox dark:bg-[#BA1A1A]/20 text-error dark:text-[#FFB4AB] text-[12px] font-medium"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">inventory_2</span>Stok Habis</span>
                                    @elseif($b->stock <= 3)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-warning/15 text-warning text-[12px] font-medium"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">warning</span>Menipis ({{ $b->stock }})</span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-success/15 text-success text-[12px] font-medium"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">check_circle</span>Tersedia ({{ $b->stock }})</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1">
                                        <a href="/admin/borrowings/create?book={{ $b->id }}" class="px-2.5 py-1 rounded-md bg-secondary text-white text-[12px] font-medium hover:brightness-110 flex items-center gap-1" title="Pinjamkan buku ini"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">bookmark_add</span>Pinjam</a>
                                        <button wire:click="edit({{ $b->id }})" type="button" class="p-1.5 rounded-md text-[#45464E] dark:text-[#9AA7C2] hover:text-primary" title="Edit Data"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">edit</span></button>
                                        @if($confirmingDelete === $b->id)
                                            <button wire:click="delete({{ $b->id }})" type="button" class="px-2 py-1 rounded-md bg-danger text-white text-[12px]">Yakin?</button>
                                        @else
                                            <button wire:click="$set('confirmingDelete', {{ $b->id }})" type="button" class="p-1.5 rounded-md text-[#45464E] dark:text-[#9AA7C2] hover:text-error" title="Hapus Buku"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">delete</span></button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="py-10 text-center text-[#45464E] dark:text-[#9AA7C2]">Tidak ada buku yang cocok dengan filter.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse($books as $b)
                    <article class="rounded-xl border border-line dark:border-[#263252] overflow-hidden bg-white dark:bg-[#0B1326] flex flex-col">
                        <div class="h-40 bg-[#F0F3FF] dark:bg-[#171f33] flex items-center justify-center">
                            @if($b->cover)
                                <img src="{{ asset('storage/' . $b->cover) }}" alt="Sampul {{ $b->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-[40px] text-navy dark:text-white" aria-hidden="true">menu_book</span>
                            @endif
                        </div>
                        <div class="p-3 flex flex-col gap-1.5 flex-1">
                            <span class="text-primary dark:text-white font-semibold text-[14px] leading-tight line-clamp-2">{{ $b->title }}</span>
                            <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">{{ $b->author }}</span>
                            <span class="font-mono text-[11px] text-[#75777F] dark:text-[#8c909e]">{{ $b->isbn }}</span>
                            <div class="flex items-center justify-between mt-auto pt-2">
                                <span class="px-2 py-0.5 rounded-md bg-navy/90 dark:bg-[#263252] text-[#eff1f3] dark:text-[#DAE2FD] text-[11px]">{{ $b->category->name ?? '—' }}</span>
                                <span class="text-[12px] font-semibold {{ $b->stock > 0 ? 'text-success' : 'text-error dark:text-[#FFB4AB]' }}">Stok {{ $b->stock }}</span>
                            </div>
                            <div class="flex items-center gap-1 pt-1">
                                <button wire:click="edit({{ $b->id }})" type="button" class="flex-1 px-2 py-1.5 rounded-md bg-[#F0F3FF] dark:bg-[#1A2440] text-[12px] hover:bg-[#E7EEFF] dark:hover:bg-[#263252]">Edit</button>
                                <a href="/admin/borrowings/create?book={{ $b->id }}" class="px-2 py-1.5 rounded-md bg-secondary text-white text-[12px]">Pinjam</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="col-span-full py-10 text-center text-[#45464E] dark:text-[#9AA7C2]">Tidak ada buku yang cocok dengan filter.</p>
                @endforelse
            </div>
        @endif

        <div class="p-4 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-line dark:border-[#263252]">
            <span class="text-[14px] text-[#45464E] dark:text-[#9AA7C2]">
                Menampilkan <span class="font-semibold text-primary dark:text-white">{{ $books->firstItem() ?? 0 }} - {{ $books->lastItem() ?? 0 }}</span> dari <span class="font-semibold text-primary dark:text-white">{{ $books->total() }}</span> buku
            </span>
            {{ $books->links() }}
        </div>
    </div>

    {{-- Add / Edit drawer --}}
    @if($showDrawer)
        <div class="fixed inset-0 z-50" role="dialog" aria-modal="true" aria-labelledby="drawer-title">
            <div class="absolute inset-0 bg-[#2d3133]/50 backdrop-blur-[2px]" wire:click="closeDrawer"></div>
            <div class="absolute right-0 top-0 h-full w-full max-w-lg bg-white dark:bg-[#131B2E] shadow-2xl flex flex-col">
                <div class="p-6 flex items-center justify-between bg-[#F0F3FF] dark:bg-[#1A2440] border-b border-line dark:border-[#263252]">
                    <div class="flex flex-col">
                        <span class="text-[11px] uppercase tracking-wider text-secondary dark:text-[#9CC2FF] font-semibold">Formulir Pengadaan</span>
                        <h2 id="drawer-title" class="font-poppins text-[20px] text-primary dark:text-white font-semibold">{{ $editingId ? 'Edit Koleksi' : 'Tambah Koleksi Baru' }}</h2>
                    </div>
                    <button wire:click="closeDrawer" type="button" class="w-9 h-9 rounded-full bg-white dark:bg-[#131B2E] text-[#75777F] dark:text-[#8c909e] hover:text-primary flex items-center justify-center" aria-label="Tutup">
                        <span class="material-symbols-outlined text-[20px]" aria-hidden="true">close</span>
                    </button>
                </div>
                <form wire:submit="save" class="p-6 flex flex-col gap-4 flex-1 overflow-y-auto">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[12px] font-semibold text-primary dark:text-white">Judul Buku <span class="text-error dark:text-[#FFB4AB]">*</span></label>
                        <input wire:model="title" class="h-11 px-3.5 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] focus:outline-none focus:ring-2 focus:ring-secondary/20" placeholder="Masukkan judul lengkap buku...">
                        @error('title')<p class="text-[12px] text-error dark:text-[#FFB4AB]">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[12px] font-semibold text-primary dark:text-white">Nomor ISBN <span class="text-error dark:text-[#FFB4AB]">*</span></label>
                            <input wire:model="isbn" class="h-11 px-3.5 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] font-mono text-[14px] focus:outline-none focus:ring-2 focus:ring-secondary/20" placeholder="978-...">
                            @error('isbn')<p class="text-[12px] text-error dark:text-[#FFB4AB]">{{ $message }}</p>@enderror
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[12px] font-semibold text-primary dark:text-white">Kategori <span class="text-error dark:text-[#FFB4AB]">*</span></label>
                            <select wire:model="category_id" class="h-11 px-3 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] focus:outline-none">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                            </select>
                            @error('category_id')<p class="text-[12px] text-error dark:text-[#FFB4AB]">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[12px] font-semibold text-primary dark:text-white">Nama Penulis <span class="text-error dark:text-[#FFB4AB]">*</span></label>
                        <input wire:model="author" class="h-11 px-3.5 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] focus:outline-none focus:ring-2 focus:ring-secondary/20" placeholder="Nama penulis...">
                        @error('author')<p class="text-[12px] text-error dark:text-[#FFB4AB]">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[12px] font-semibold text-primary dark:text-white">Penerbit</label>
                            <input wire:model="publisher" class="h-11 px-3.5 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] focus:outline-none focus:ring-2 focus:ring-secondary/20" placeholder="Nama penerbit...">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[12px] font-semibold text-primary dark:text-white">Tahun Terbit</label>
                            <input wire:model="publication_year" type="number" min="1900" max="2099" class="h-11 px-3.5 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] focus:outline-none focus:ring-2 focus:ring-secondary/20" placeholder="2024">
                            @error('publication_year')<p class="text-[12px] text-error dark:text-[#FFB4AB]">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[12px] font-semibold text-primary dark:text-white">Jumlah Eksemplar <span class="text-error dark:text-[#FFB4AB]">*</span></label>
                            <input wire:model="stock" type="number" min="0" class="h-11 px-3.5 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] focus:outline-none focus:ring-2 focus:ring-secondary/20">
                            @error('stock')<p class="text-[12px] text-error dark:text-[#FFB4AB]">{{ $message }}</p>@enderror
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[12px] font-semibold text-primary dark:text-white">Deskripsi</label>
                            <input wire:model="description" class="h-11 px-3.5 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] focus:outline-none focus:ring-2 focus:ring-secondary/20" placeholder="Ringkasan singkat...">
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[12px] font-semibold text-primary dark:text-white">Unggah Berkas Sampul Buku</label>
                        <label class="rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] p-4 flex flex-col items-center justify-center text-center cursor-pointer hover:bg-[#E7EEFF] dark:hover:bg-[#263252] transition-colors">
                            <span class="material-symbols-outlined text-[32px] text-secondary dark:text-[#9CC2FF]" aria-hidden="true">add_photo_alternate</span>
                            <span class="text-[14px] text-primary dark:text-white font-medium mt-1">{{ $coverUpload ? $coverUpload->getClientOriginalName() : 'Seret berkas ke sini atau telusuri' }}</span>
                            <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Maksimal 3MB (JPG, PNG, WEBP)</span>
                            <input type="file" wire:model="coverUpload" accept="image/*" class="hidden">
                        </label>
                        @if($coverUpload)<img src="{{ $coverUpload->temporaryUrl() }}" alt="Pratinjau sampul" class="max-h-40 rounded-lg self-center">@endif
                        @error('coverUpload')<p class="text-[12px] text-error dark:text-[#FFB4AB]">{{ $message }}</p>@enderror
                    </div>
                </form>
                <div class="p-6 bg-[#F0F3FF] dark:bg-[#1A2440] border-t border-line dark:border-[#263252] flex items-center justify-end gap-3">
                    <button wire:click="closeDrawer" type="button" class="px-4 h-11 rounded-lg text-primary dark:text-white hover:bg-[#E7EEFF] dark:hover:bg-[#263252] text-[14px]">Batal</button>
                    <button wire:click="save" type="button" class="px-5 h-11 rounded-lg bg-secondary text-white text-[14px] font-medium hover:brightness-110 shadow-sm">{{ $editingId ? 'Simpan Perubahan' : 'Simpan Koleksi' }}</button>
                </div>
            </div>
        </div>
    @endif
</div>