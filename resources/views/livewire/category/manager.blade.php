<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2">
                <span class="text-[11px] uppercase tracking-wider text-secondary dark:text-[#9CC2FF] font-semibold bg-secondary/15 dark:bg-[#508ff8]/20 px-2.5 py-0.5 rounded-full">Taksonomi Koleksi</span>
                <span class="w-1 h-1 rounded-full bg-outline dark:bg-[#424753]" aria-hidden="true"></span>
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Referensi Indeks Koleksi</span>
            </div>
            <h1 class="font-poppins text-[32px] leading-[40px] text-primary dark:text-white font-semibold tracking-tight">Kategori Buku</h1>
            <p class="text-[14px] text-[#45464E] dark:text-[#9AA7C2] max-w-2xl">Kelola kategori induk koleksi beserta jumlah judul dan eksemplar pada setiap kategori.</p>
        </div>
        <div class="flex items-center gap-2 self-start lg:self-auto">
            <button wire:click="openCreate" type="button" class="flex items-center gap-2 px-5 h-11 rounded-lg bg-secondary text-white text-[14px] font-medium hover:brightness-110">
                <span class="material-symbols-outlined text-[20px]" aria-hidden="true">add</span><span>Tambah Kategori</span>
            </button>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Total Kategori</span>
                <span class="font-poppins text-[24px] leading-8 text-primary dark:text-white font-semibold mt-0.5">{{ number_format($totalCategories) }}</span>
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] mt-1">klasifikasi aktif</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] flex items-center justify-center text-secondary dark:text-[#9CC2FF]"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">category</span></span>
        </div>
        <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Kategori Terpakai</span>
                <span class="font-poppins text-[24px] leading-8 text-primary dark:text-white font-semibold mt-0.5">{{ number_format($usedCategories) }}</span>
                <span class="text-[11px] text-success flex items-center gap-0.5 mt-1 font-medium"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">check_circle</span> punya koleksi</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] flex items-center justify-center text-navy dark:text-white"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">library_books</span></span>
        </div>
        <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Kategori Kosong</span>
                <span class="font-poppins text-[24px] leading-8 text-primary dark:text-white font-semibold mt-0.5">{{ number_format($emptyCategories) }}</span>
                <span class="text-[11px] text-warning flex items-center gap-0.5 mt-1 font-medium"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">info</span> siap diisi</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] flex items-center justify-center text-[#AE9163]"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">inventory_2</span></span>
        </div>
        <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Total Judul</span>
                <span class="font-poppins text-[24px] leading-8 text-primary dark:text-white font-semibold mt-0.5">{{ number_format($totalBooks) }}</span>
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] mt-1">{{ $unclassified }} tanpa kategori</span>
            </div>
            <span class="w-11 h-11 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] flex items-center justify-center text-secondary dark:text-[#9CC2FF]"><span class="material-symbols-outlined text-[24px]" aria-hidden="true">auto_stories</span></span>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="p-4 rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] flex flex-col lg:flex-row lg:items-center justify-between gap-3">
        <div class="relative flex-1 min-w-[240px]">
            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[#75777F] dark:text-[#8c909e] text-[20px] pointer-events-none" aria-hidden="true">search</span>
            <input wire:model.live="search" type="text" class="w-full h-11 pl-11 pr-4 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[14px] placeholder:text-[#75777F] dark:placeholder:text-[#8c909e] focus:outline-none focus:ring-2 focus:ring-secondary/20" placeholder="Cari nama atau deskripsi kategori..." aria-label="Cari kategori">
        </div>
        <div class="flex items-center gap-2">
            @if($search)
                <button wire:click="clearFilters" type="button" class="flex items-center gap-1.5 px-3 h-11 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[13px] hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440]">
                    <span class="material-symbols-outlined text-[18px]" aria-hidden="true">filter_alt_off</span>Reset
                </button>
            @endif
            <div class="flex items-center p-1 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252]" role="group" aria-label="Tampilan">
                <button wire:click="setView('grid')" type="button" class="px-2.5 py-1.5 rounded transition-all {{ $view === 'grid' ? 'bg-white dark:bg-[#263252] text-secondary dark:text-[#9CC2FF] shadow-sm' : 'text-[#45464E] dark:text-[#9AA7C2] hover:text-primary' }}" title="Tampilan Kartu" aria-label="Tampilan kartu"><span class="material-symbols-outlined text-[19px] block" aria-hidden="true">grid_view</span></button>
                <button wire:click="setView('table')" type="button" class="px-2.5 py-1.5 rounded transition-all {{ $view === 'table' ? 'bg-white dark:bg-[#263252] text-secondary dark:text-[#9CC2FF] shadow-sm' : 'text-[#45464E] dark:text-[#9AA7C2] hover:text-primary' }}" title="Tampilan Tabel" aria-label="Tampilan tabel"><span class="material-symbols-outlined text-[19px] block" aria-hidden="true">view_list</span></button>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="rounded-xl bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] overflow-hidden">
        @if($view === 'grid')
            <div class="p-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($categories as $c)
                    <article class="rounded-xl border border-line dark:border-[#263252] bg-[#F8FAFC] dark:bg-[#0B1326] p-4 flex flex-col gap-2 transition-colors hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440]">
                        <div class="flex items-start justify-between gap-2">
                            <span class="w-10 h-10 rounded-xl bg-navy/10 dark:bg-[#263252] text-navy dark:text-white flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-[20px]" aria-hidden="true">category</span>
                            </span>
                            @if($c->books_count > 0)
                                <span class="px-2.5 py-1 rounded-full bg-secondary/15 dark:bg-[#508ff8]/20 text-secondary dark:text-[#9CC2FF] text-[11px] font-semibold whitespace-nowrap">{{ $c->books_count }} judul</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-[#F0F3FF] dark:bg-[#1A2440] text-[#45464E] dark:text-[#9AA7C2] text-[11px] font-semibold whitespace-nowrap">Kosong</span>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-poppins text-[16px] font-semibold text-primary dark:text-white leading-tight">{{ $c->name }}</h3>
                            <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2] mt-0.5 line-clamp-2">{{ $c->description ?: 'Tanpa deskripsi.' }}</p>
                        </div>
                        <div class="flex items-center justify-between mt-auto pt-2">
                            <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">{{ number_format($c->books_sum_stock ?? 0) }} eksemplar</span>
                            <div class="flex items-center gap-1">
                                <a href="/admin/books?q={{ urlencode($c->name) }}" class="p-1.5 rounded-md text-[#45464E] dark:text-[#9AA7C2] hover:text-primary" title="Lihat buku"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">visibility</span></a>
                                <button wire:click="edit({{ $c->id }})" type="button" class="p-1.5 rounded-md text-[#45464E] dark:text-[#9AA7C2] hover:text-primary" title="Edit"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">edit</span></button>
                                @if($confirmingDelete === $c->id)
                                    <button wire:click="delete({{ $c->id }})" type="button" class="px-2 py-1 rounded-md bg-danger text-white text-[12px]">Yakin?</button>
                                @else
                                    <button wire:click="$set('confirmingDelete', {{ $c->id }})" type="button" class="p-1.5 rounded-md text-[#45464E] dark:text-[#9AA7C2] hover:text-error" title="Hapus"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">delete</span></button>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="col-span-full py-10 text-center text-[#45464E] dark:text-[#9AA7C2]">Belum ada kategori yang cocok.</p>
                @endforelse
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-[#F0F3FF] dark:bg-[#0B1326] text-[#45464E] dark:text-[#9AA7C2] text-[12px] uppercase tracking-wider border-b border-line dark:border-[#263252]">
                        <tr>
                            <th class="py-3.5 px-4">Kategori</th>
                            <th class="py-3.5 px-4 min-w-[240px]">Deskripsi</th>
                            <th class="py-3.5 px-4 text-center">Judul</th>
                            <th class="py-3.5 px-4 text-center">Eksemplar</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-[14px]">
                        @forelse($categories as $c)
                            <tr class="hover:bg-[#F0F3FF]/60 dark:hover:bg-[#1A2440] transition-colors border-b border-line dark:border-[#263252]">
                                <td class="py-3.5 px-4">
                                    <span class="flex items-center gap-2.5">
                                        <span class="w-8 h-8 rounded-lg bg-navy/10 dark:bg-[#263252] text-navy dark:text-white flex items-center justify-center flex-shrink-0" aria-hidden="true"><span class="material-symbols-outlined text-[18px]">category</span></span>
                                        <span class="text-primary dark:text-white font-semibold">{{ $c->name }}</span>
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-[#45464E] dark:text-[#9AA7C2]">{{ $c->description ?: '—' }}</td>
                                <td class="py-3.5 px-4 text-center font-semibold text-primary dark:text-white">{{ $c->books_count }}</td>
                                <td class="py-3.5 px-4 text-center text-[#45464E] dark:text-[#9AA7C2]">{{ number_format($c->books_sum_stock ?? 0) }}</td>
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1">
                                        <a href="/admin/books?q={{ urlencode($c->name) }}" class="p-1.5 rounded-md text-[#45464E] dark:text-[#9AA7C2] hover:text-primary" title="Lihat buku"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">visibility</span></a>
                                        <button wire:click="edit({{ $c->id }})" type="button" class="p-1.5 rounded-md text-[#45464E] dark:text-[#9AA7C2] hover:text-primary" title="Edit"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">edit</span></button>
                                        @if($confirmingDelete === $c->id)
                                            <button wire:click="delete({{ $c->id }})" type="button" class="px-2 py-1 rounded-md bg-danger text-white text-[12px]">Yakin?</button>
                                        @else
                                            <button wire:click="$set('confirmingDelete', {{ $c->id }})" type="button" class="p-1.5 rounded-md text-[#45464E] dark:text-[#9AA7C2] hover:text-error" title="Hapus"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">delete</span></button>
                                        @endif
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-10 text-center text-[#45464E] dark:text-[#9AA7C2]">Belum ada kategori yang cocok.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif

        <div class="p-4 flex flex-col sm:flex-row items-center justify-between gap-2 border-t border-line dark:border-[#263252]">
            <span class="text-[14px] text-[#45464E] dark:text-[#9AA7C2]">
                Menampilkan <span class="font-semibold text-primary dark:text-white">{{ $categories->firstItem() ?? 0 }} - {{ $categories->lastItem() ?? 0 }}</span> dari <span class="font-semibold text-primary dark:text-white">{{ $categories->total() }}</span> kategori
            </span>
            {{ $categories->links() }}
        </div>
    </div>

    {{-- Add / Edit drawer --}}
    @if($showDrawer)
        <div class="fixed inset-0 z-50" role="dialog" aria-modal="true" aria-labelledby="cat-drawer-title">
            <div class="absolute inset-0 bg-[#2d3133]/50 backdrop-blur-[2px]" wire:click="closeDrawer"></div>
            <div class="absolute right-0 top-0 h-full w-full max-w-lg bg-white dark:bg-[#131B2E] shadow-2xl flex flex-col">
                <div class="p-6 flex items-center justify-between bg-[#F0F3FF] dark:bg-[#1A2440] border-b border-line dark:border-[#263252]">
                    <div class="flex flex-col">
                        <span class="text-[11px] uppercase tracking-wider text-secondary dark:text-[#9CC2FF] font-semibold">Taksonomi Koleksi</span>
                        <h2 id="cat-drawer-title" class="font-poppins text-[20px] text-primary dark:text-white font-semibold">{{ $editingId ? 'Edit Kategori' : 'Tambah Kategori' }}</h2>
                    </div>
                    <button wire:click="closeDrawer" type="button" class="w-9 h-9 rounded-full bg-white dark:bg-[#131B2E] text-[#75777F] dark:text-[#8c909e] hover:text-primary flex items-center justify-center" aria-label="Tutup">
                        <span class="material-symbols-outlined text-[20px]" aria-hidden="true">close</span>
                    </button>
                </div>
                <form wire:submit="save" class="p-6 flex flex-col gap-4 flex-1 overflow-y-auto">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[12px] font-semibold text-primary dark:text-white">Nama Kategori <span class="text-error dark:text-[#FFB4AB]">*</span></label>
                        <input wire:model="name" class="h-11 px-3.5 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] focus:outline-none focus:ring-2 focus:ring-secondary/20" placeholder="misal: Non-Fiksi">
                        @error('name')<p class="text-[12px] text-error dark:text-[#FFB4AB]">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[12px] font-semibold text-primary dark:text-white">Deskripsi</label>
                        <textarea wire:model="description" rows="4" class="px-3.5 py-2.5 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] focus:outline-none focus:ring-2 focus:ring-secondary/20" placeholder="Ringkasan singkat kategori..."></textarea>
                        @error('description')<p class="text-[12px] text-error dark:text-[#FFB4AB]">{{ $message }}</p>@enderror
                    </div>
                </form>
                <div class="p-6 bg-[#F0F3FF] dark:bg-[#1A2440] border-t border-line dark:border-[#263252] flex items-center justify-end gap-3">
                    <button wire:click="closeDrawer" type="button" class="px-4 h-11 rounded-lg text-primary dark:text-white hover:bg-[#E7EEFF] dark:hover:bg-[#263252] text-[14px]">Batal</button>
                    <button wire:click="save" type="button" class="px-5 h-11 rounded-lg bg-secondary text-white text-[14px] font-medium hover:brightness-110 shadow-sm">{{ $editingId ? 'Simpan Perubahan' : 'Simpan Kategori' }}</button>
                </div>
            </div>
        </div>
    @endif
</div>