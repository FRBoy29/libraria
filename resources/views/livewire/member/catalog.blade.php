<div class="space-y-6">
    {{-- Breadcrumb + judul --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2">
                <span class="text-[11px] uppercase tracking-wider text-secondary dark:text-[#9CC2FF] font-semibold bg-secondary/15 dark:bg-[#508ff8]/20 px-2.5 py-0.5 rounded-full">Katalog Koleksi Buku</span>
                <span class="w-1 h-1 rounded-full bg-outline dark:bg-[#424753]" aria-hidden="true"></span>
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Integrasi Terpadu</span>
            </div>
            <h1 class="font-poppins text-[32px] leading-[40px] text-navy dark:text-white font-semibold tracking-tight">Katalog Koleksi &amp; Buku Tersedia</h1>
            <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2] max-w-3xl leading-relaxed">
                Jelajahi koleksi buku perpustakaan dan periksa ketersediaannya. Peminjaman diproses oleh petugas.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2 self-start md:self-auto">
            <span class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-[#F0F3FF] dark:bg-[#131B2E] border border-line dark:border-[#263252]">
                <span class="w-2 h-2 rounded-full bg-success animate-pulse" aria-hidden="true"></span>
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Tersedia:</span>
                <span class="text-[11px] text-navy dark:text-white font-semibold">{{ number_format($availableTitles) }} Judul</span>
            </span>
        </div>
    </div>

    {{-- Konsol search & filter --}}
    <div class="bg-[#F0F3FF] dark:bg-[#131B2E] border border-line dark:border-[#263252] rounded-xl p-4 md:p-5 flex flex-col gap-4">
        <div class="relative flex items-center w-full">
            <span class="material-symbols-outlined absolute left-4 text-brand dark:text-[#9CC2FF] text-[20px] pointer-events-none" aria-hidden="true">search</span>
            <input wire:model.live="search" id="bookCatalogSearch" type="text" class="w-full h-12 pl-12 pr-12 rounded-lg bg-white dark:bg-[#060e20] border border-transparent focus:border-secondary focus:ring-2 focus:ring-secondary/20 text-[14px] text-[#111C2D] dark:text-[#DAE2FD] placeholder:text-[#75777F] dark:placeholder:text-[#8c909e]" placeholder="Cari judul buku, penulis, penerbit, atau nomor ISBN...">
            @if($search)
                <button wire:click="clearSearch" type="button" class="absolute right-3 p-1 rounded text-[#45464E] dark:text-[#9AA7C2] hover:text-navy dark:hover:text-white transition-colors" title="Bersihkan pencarian" aria-label="Bersihkan pencarian">
                    <span class="material-symbols-outlined text-[18px]" aria-hidden="true">close</span>
                </button>
            @endif
        </div>

        <div class="flex items-center gap-2 overflow-x-auto pb-1">
            <button wire:click="$set('filterCategory', '')" type="button" class="shrink-0 px-4 py-2 rounded-lg text-[12px] font-semibold whitespace-nowrap transition-all {{ $filterCategory === '' ? 'bg-brand dark:bg-[#508ff8] text-white dark:text-[#002f68] shadow-sm' : 'bg-white dark:bg-[#060e20] text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#E7EEFF] dark:hover:bg-[#222A3D]' }}">
                Semua ({{ number_format($totalTitles) }})
            </button>
            @foreach($categories as $c)
                <button wire:click="$set('filterCategory', '{{ (string) $filterCategory === (string) $c->id ? '' : $c->id }}')" type="button" class="shrink-0 px-4 py-2 rounded-lg text-[12px] font-medium whitespace-nowrap transition-colors {{ (string) $filterCategory === (string) $c->id ? 'bg-brand dark:bg-[#508ff8] text-white dark:text-[#002f68] shadow-sm' : 'bg-white dark:bg-[#060e20] text-[#45464E] dark:text-[#9AA7C2] hover:bg-[#E7EEFF] dark:hover:bg-[#222A3D]' }}">
                    {{ $c->name }} ({{ $c->books_count }})
                </button>
            @endforeach
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3 pt-1">
            <label class="flex items-center gap-2 cursor-pointer select-none">
                <button wire:click="$toggle('inStockOnly')" type="button" role="switch" aria-checked="{{ $inStockOnly ? 'true' : 'false' }}" aria-label="Hanya yang tersedia" class="relative w-9 h-5 rounded-full transition-colors {{ $inStockOnly ? 'bg-brand dark:bg-[#508ff8]' : 'bg-[#D8E3FB] dark:bg-[#2d3449]' }}">
                    <span class="absolute left-0.5 top-0.5 bg-white w-4 h-4 rounded-full transition-transform {{ $inStockOnly ? 'translate-x-4' : '' }}" aria-hidden="true"></span>
                </button>
                <span class="text-[12px] text-navy dark:text-white font-medium">Hanya yang Tersedia</span>
            </label>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-1.5">
                    <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Urutkan:</span>
                    <div class="relative">
                        <select wire:model.live="sort" class="appearance-none bg-white dark:bg-[#060e20] text-navy dark:text-white text-[11px] rounded-lg pl-2.5 pr-7 py-1.5 focus:outline-none cursor-pointer border border-line dark:border-[#263252]" aria-label="Urutkan katalog">
                            <option value="popular">Terpopuler / Paling Sering Dipinjam</option>
                            <option value="newest">Terbaru Ditambahkan</option>
                            <option value="az">Judul (A-Z)</option>
                            <option value="stock">Ketersediaan Terbanyak</option>
                        </select>
                        <span class="material-symbols-outlined text-[#75777F] dark:text-[#8c909e] pointer-events-none absolute right-1.5 top-1.5 text-[14px]" aria-hidden="true">unfold_more</span>
                    </div>
                </div>
                <div class="flex items-center bg-white dark:bg-[#060e20] border border-line dark:border-[#263252] rounded-lg p-0.5" role="group" aria-label="Tampilan">
                    <button wire:click="setView('grid')" type="button" class="p-1.5 rounded transition-all {{ $view === 'grid' ? 'bg-brand dark:bg-[#508ff8] text-white dark:text-[#002f68] shadow-sm' : 'text-[#45464E] dark:text-[#9AA7C2]' }}" title="Tampilan Kartu" aria-label="Tampilan kartu"><span class="material-symbols-outlined text-[18px] block" aria-hidden="true">grid_view</span></button>
                    <button wire:click="setView('table')" type="button" class="p-1.5 rounded transition-all {{ $view === 'table' ? 'bg-brand dark:bg-[#508ff8] text-white dark:text-[#002f68] shadow-sm' : 'text-[#45464E] dark:text-[#9AA7C2]' }}" title="Tampilan Daftar" aria-label="Tampilan daftar"><span class="material-symbols-outlined text-[18px] block" aria-hidden="true">view_list</span></button>
                </div>
            </div>
        </div>
    </div>

    {{-- Konten --}}
    @if($view === 'grid')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($books as $b)
                <article class="group bg-[#F0F3FF] dark:bg-[#171f33] border border-line dark:border-[#263252] rounded-xl p-4 flex flex-col justify-between hover:bg-[#E7EEFF] dark:hover:bg-[#222A3D] transition-all">
                    <div class="flex gap-4">
                        <div class="w-20 h-28 rounded-lg bg-navy text-white flex items-center justify-center shrink-0 overflow-hidden relative" aria-hidden="true">
                            @if($b->cover)
                                <img src="{{ asset('storage/' . $b->cover) }}" alt="" class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-[28px]">menu_book</span>
                            @endif
                        </div>
                        <div class="flex flex-col min-w-0 flex-1">
                            <span class="text-[11px] uppercase tracking-wider text-brand dark:text-[#9CC2FF] font-semibold">{{ $b->category->name ?? 'Umum' }}</span>
                            <h3 class="font-poppins text-[18px] font-semibold text-navy dark:text-white leading-snug truncate mt-0.5 group-hover:text-brand dark:group-hover:text-[#9CC2FF] transition-colors">{{ $b->title }}</h3>
                            <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2] truncate">{{ $b->author }} • {{ $b->publisher ?? 'Tanpa penerbit' }} ({{ $b->publication_year ?? '—' }})</p>
                            <div class="mt-2 flex items-center gap-1.5 text-[11px]">
                                <span class="material-symbols-outlined text-[16px] text-[#75777F] dark:text-[#8c909e]" aria-hidden="true">shelves</span>
                                <span class="text-[#45464E] dark:text-[#9AA7C2]">Stok perpustakaan</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-[11px] mt-0.5">
                                @if($b->stock > 1)
                                    <span class="w-1.5 h-1.5 rounded-full bg-success" aria-hidden="true"></span>
                                    <span class="text-success font-medium">Tersedia: {{ $b->stock }} buku</span>
                                @elseif($b->stock === 1)
                                    <span class="w-1.5 h-1.5 rounded-full bg-warning" aria-hidden="true"></span>
                                    <span class="text-warning font-medium">Tersisa 1 buku</span>
                                @else
                                    <span class="w-1.5 h-1.5 rounded-full bg-danger" aria-hidden="true"></span>
                                    <span class="text-error dark:text-[#FFB4AB] font-medium">Stok habis — hubungi petugas</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 flex items-center justify-between gap-2 border-t border-line dark:border-[#263252]">
                        <span class="font-mono text-[11px] text-[#75777F] dark:text-[#8c909e]">ISBN {{ $b->isbn }}</span>
                        <a href="/member/books/{{ $b->id }}" class="px-4 py-1.5 rounded-lg bg-[#D8E3FB] dark:bg-[#2d3449] hover:bg-brand hover:text-white dark:hover:bg-[#508ff8] dark:hover:text-[#002f68] text-navy dark:text-white text-[12px] font-semibold transition-colors">Lihat Detail</a>
                    </div>
                </article>
            @empty
                <div class="col-span-full p-10 rounded-xl bg-[#F0F3FF] dark:bg-[#131B2E] border border-dashed border-line dark:border-[#263252] text-center">
                    <span class="material-symbols-outlined text-[40px] text-[#AE9163]" aria-hidden="true">search_off</span>
                    <p class="text-[14px] text-navy dark:text-white font-semibold mt-2">Tidak ada buku yang cocok</p>
                    <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2] mt-1">Coba kata kunci atau filter lain.</p>
                    <button wire:click="clearFilters" type="button" class="mt-3 px-4 py-2 rounded-lg bg-brand dark:bg-[#508ff8] text-white dark:text-[#002f68] text-[13px] font-semibold">Reset Filter</button>
                </div>
            @endforelse
        </div>
    @else
        <div class="rounded-xl bg-[#F0F3FF] dark:bg-[#131B2E] border border-line dark:border-[#263252] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white dark:bg-[#060e20] text-[#45464E] dark:text-[#9AA7C2] text-[12px] uppercase tracking-wider border-b border-line dark:border-[#263252]">
                        <tr>
                            <th class="py-3.5 px-4 min-w-[220px]">Judul &amp; Penulis</th>
                            <th class="py-3.5 px-4">Kategori</th>
                            <th class="py-3.5 px-4">ISBN</th>
                            <th class="py-3.5 px-4 text-center">Stok</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-[14px]">
                        @forelse($books as $b)
                            <tr class="hover:bg-[#E7EEFF]/60 dark:hover:bg-[#222A3D] border-b border-line dark:border-[#263252]">
                                <td class="py-3.5 px-4">
                                    <span class="text-navy dark:text-white font-semibold block truncate">{{ $b->title }}</span>
                                    <span class="text-[12px] text-[#45464E] dark:text-[#9AA7C2]">{{ $b->author }}</span>
                                </td>
                                <td class="py-3.5 px-4"><span class="px-2 py-0.5 rounded-md bg-[#D8E3FB] dark:bg-[#2d3449] text-navy dark:text-[#c2c6d5] text-[11px]">{{ $b->category->name ?? '—' }}</span></td>
                                <td class="py-3.5 px-4 font-mono text-[12px] text-[#45464E] dark:text-[#9AA7C2]">{{ $b->isbn }}</td>
                                <td class="py-3.5 px-4 text-center font-semibold text-navy dark:text-white">{{ $b->stock }}</td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @if($b->stock > 1)
                                        <span class="text-success text-[12px] font-medium">Tersedia</span>
                                    @elseif($b->stock === 1)
                                        <span class="text-warning text-[12px] font-medium">Terakhir</span>
                                    @else
                                        <span class="text-error dark:text-[#FFB4AB] text-[12px] font-medium">Habis</span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-right"><a href="/member/books/{{ $b->id }}" class="text-[12px] text-brand dark:text-[#9CC2FF] font-semibold hover:underline">Detail</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="py-10 text-center text-[#45464E] dark:text-[#9AA7C2]">Tidak ada buku yang cocok.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div class="rounded-xl bg-[#F0F3FF] dark:bg-[#131B2E] border border-line dark:border-[#263252] p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <span class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">
            Menampilkan <strong class="text-navy dark:text-white">{{ $books->firstItem() ?? 0 }} - {{ $books->lastItem() ?? 0 }}</strong> dari <strong class="text-navy dark:text-white">{{ $books->total() }}</strong> buku
        </span>
        {{ $books->links() }}
    </div>
    <p class="text-[12px] text-[#45464E] dark:text-[#9AA7C2] flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]" aria-hidden="true">info</span>Peminjaman dan reservasi buku dilakukan melalui petugas perpustakaan.</p>
</div>