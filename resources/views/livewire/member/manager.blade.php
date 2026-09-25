<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <p class="flex items-center gap-1.5 text-secondary dark:text-[#9CC2FF] text-[12px] font-semibold uppercase tracking-wider mb-1">
                <span class="material-symbols-outlined text-[16px]" aria-hidden="true">id_card</span>
                <span>Sistem Manajemen Keanggotaan</span>
            </p>
            <h1 class="font-poppins text-[32px] leading-[40px] text-primary dark:text-white font-semibold tracking-tight">Data Anggota Perpustakaan</h1>
            <p class="text-[14px] text-[#45464E] dark:text-[#9AA7C2] max-w-2xl mt-1">Kelola kartu anggota, status keaktifan, serta sirkulasi peminjaman tiap anggota secara terintegrasi.</p>
        </div>
        <div class="flex items-center gap-2 self-start lg:self-auto">
            <a href="/admin/members/export" class="flex items-center gap-1.5 px-4 py-2.5 rounded-lg bg-white dark:bg-[#131B2E] border border-line dark:border-[#263252] text-[14px] font-medium hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440]">
                <span class="material-symbols-outlined text-[18px] text-secondary" aria-hidden="true">file_download</span><span>Export Data</span>
            </a>
            <button wire:click="openCreate" type="button" class="flex items-center gap-1.5 px-5 py-2.5 rounded-lg bg-secondary text-white text-[14px] font-medium hover:brightness-110">
                <span class="material-symbols-outlined text-[20px]" aria-hidden="true">person_add</span><span>+ Tambah Anggota Baru</span>
            </button>
        </div>
    </div>

    {{-- Form --}}
    @if($showForm)
        <div class="bg-white dark:bg-[#131B2E] rounded-xl p-6 border border-line dark:border-[#263252]">
            <h2 class="font-poppins font-semibold text-[16px] text-navy dark:text-white mb-3">{{ $editingId ? 'Edit Anggota' : 'Tambah Anggota' }}</h2>
            <form wire:submit="save" class="grid md:grid-cols-3 gap-2.5">
                <div class="flex gap-2">
                    <input wire:model="member_code" placeholder="Member Code *" class="flex-1 h-10 px-3 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[14px]">
                    <button type="button" wire:click="generateCode" class="px-3 h-10 rounded-lg bg-[#F0F3FF] dark:bg-[#1A2440] text-[13px]">Generate</button>
                </div>
                <input wire:model="name" placeholder="Nama *" class="h-10 px-3 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[14px]">
                <input wire:model="email" type="email" placeholder="Email *" class="h-10 px-3 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[14px]">
                <input wire:model="password" type="password" placeholder="{{ $editingId ? 'Password baru (kosongkan jika tidak ganti)' : 'Password awal *' }}" class="h-10 px-3 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[14px]">
                <input wire:model="phone" placeholder="Telepon" class="h-10 px-3 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[14px]">
                <input wire:model="address" placeholder="Alamat" class="h-10 px-3 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[14px]">
                <select wire:model="status" class="h-10 px-3 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[14px]">
                    <option value="active">active</option><option value="inactive">inactive</option>
                </select>
                <input wire:model="active_until" type="date" title="Masa aktif" class="h-10 px-3 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[14px]">
                <div class="flex gap-2">
                    <button class="px-4 h-10 rounded-lg bg-navy dark:bg-brand text-white text-[14px] font-semibold">{{ $editingId ? 'Update' : 'Tambah' }}</button>
                    <button type="button" wire:click="cancel" class="px-4 h-10 rounded-lg bg-[#F0F3FF] dark:bg-[#1A2440] text-[14px]">Batal</button>
                </div>
            </form>
            @foreach(['member_code','name','email','password','status','active_until'] as $f)
                @error($f)<p class="text-error dark:text-[#FFB4AB] text-[12px] mt-1">{{ $message }}</p>@enderror
            @endforeach
        </div>
    @endif

    {{-- Metrics --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 font-poppins">
        <div class="bg-white dark:bg-[#131B2E] p-4 rounded-xl border border-line dark:border-[#263252] flex items-center justify-between">
            <div>
                <span class="text-[12px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wide">Total Anggota</span>
                <div class="flex items-baseline gap-2 mt-1"><span class="text-[32px] text-primary dark:text-white font-semibold">{{ number_format($totalMembers) }}</span><span class="font-inter text-[13px] text-[#45464E] dark:text-[#9AA7C2]">orang</span></div>
                <span class="text-[11px] text-success flex items-center gap-0.5 mt-1"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">trending_up</span> +{{ $newThisMonth }} bulan ini</span>
            </div>
            <span class="w-12 h-12 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] text-primary dark:text-white flex items-center justify-center"><span class="material-symbols-outlined text-[26px]" aria-hidden="true">groups</span></span>
        </div>
        <div class="bg-white dark:bg-[#131B2E] p-4 rounded-xl border border-line dark:border-[#263252] flex items-center justify-between">
            <div>
                <span class="text-[12px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wide">Anggota Aktif</span>
                <div class="flex items-baseline gap-2 mt-1"><span class="text-[32px] text-primary dark:text-white font-semibold">{{ number_format($activeMembers) }}</span><span class="font-inter text-[13px] text-success font-medium">{{ $totalMembers ? round($activeMembers / $totalMembers * 100, 1) : 0 }}%</span></div>
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] mt-1">Masa berlaku valid</span>
            </div>
            <span class="w-12 h-12 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] text-success flex items-center justify-center"><span class="material-symbols-outlined text-[26px]" aria-hidden="true">how_to_reg</span></span>
        </div>
        <div class="bg-white dark:bg-[#131B2E] p-4 rounded-xl border border-line dark:border-[#263252] flex items-center justify-between">
            <div>
                <span class="text-[12px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wide">Sedang Meminjam</span>
                <div class="flex items-baseline gap-2 mt-1"><span class="text-[32px] text-secondary dark:text-[#9CC2FF] font-semibold">{{ number_format($borrowingMembersCount) }}</span><span class="font-inter text-[13px] text-[#45464E] dark:text-[#9AA7C2]">orang</span></div>
                <span class="text-[11px] text-secondary dark:text-[#9CC2FF] flex items-center gap-0.5 mt-1"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">menu_book</span> {{ $borrowingBooksQty }} buku beredar</span>
            </div>
            <span class="w-12 h-12 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center"><span class="material-symbols-outlined text-[26px]" aria-hidden="true">sync_alt</span></span>
        </div>
        <div class="bg-white dark:bg-[#131B2E] p-4 rounded-xl border border-line dark:border-[#263252] flex items-center justify-between">
            <div>
                <span class="text-[12px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wide">Terlambat</span>
                <div class="flex items-baseline gap-2 mt-1"><span class="text-[32px] text-danger font-semibold">{{ number_format($overdueMembersCount) }}</span><span class="font-inter text-[13px] text-[#45464E] dark:text-[#9AA7C2]">orang</span></div>
                <span class="text-[11px] text-danger flex items-center gap-0.5 mt-1"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">warning</span> Perlu follow-up</span>
            </div>
            <span class="w-12 h-12 rounded-xl bg-errorbox dark:bg-[#BA1A1A]/20 text-danger dark:text-[#FFB4AB] flex items-center justify-center"><span class="material-symbols-outlined text-[26px]" aria-hidden="true">gavel</span></span>
        </div>
    </div>

    <div class="flex flex-col xl:flex-row gap-6 items-start">
        {{-- Table section --}}
        <div class="flex-1 w-full flex flex-col gap-4 min-w-0">
            <div class="bg-white dark:bg-[#131B2E] p-4 rounded-xl border border-line dark:border-[#263252] flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="relative flex-1 max-w-lg">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[#75777F] text-[20px] pointer-events-none" aria-hidden="true">search</span>
                    <input wire:model.live="search" class="w-full h-11 pl-11 pr-4 bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] rounded-lg text-[13px]" placeholder="Cari kode anggota, nama, atau email..." type="text" aria-label="Cari anggota">
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <div class="flex items-center bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] p-1 rounded-lg">
                        @foreach(['' => 'Semua', 'active' => 'Aktif', 'inactive' => 'Nonaktif'] as $val => $label)
                            <button wire:click="$set('filterStatus', '{{ $val }}')" type="button" class="px-3 py-1.5 rounded-md text-[12px] font-semibold transition-all {{ $filterStatus === $val ? 'bg-white dark:bg-[#263252] text-primary dark:text-white shadow-sm' : 'text-[#45464E] dark:text-[#9AA7C2]' }}">{{ $label }}</button>
                        @endforeach
                    </div>
                    <button wire:click="$refresh" type="button" class="w-10 h-10 flex items-center justify-center rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[#45464E] dark:text-[#9AA7C2] hover:text-primary" title="Muat ulang tabel" aria-label="Muat ulang">
                        <span class="material-symbols-outlined text-[20px]" aria-hidden="true">sync</span>
                    </button>
                </div>
            </div>

            <div class="bg-white dark:bg-[#131B2E] rounded-xl border border-line dark:border-[#263252] overflow-hidden flex flex-col">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-[13px]">
                        <thead>
                            <tr class="bg-canvas dark:bg-[#0B1326] text-[#45464E] dark:text-[#9AA7C2] text-[12px] uppercase tracking-wider">
                                <th class="py-3.5 px-4 font-semibold">Kode Anggota</th>
                                <th class="py-3.5 px-4 font-semibold">Nama &amp; Identitas</th>
                                <th class="py-3.5 px-4 font-semibold">Terdaftar</th>
                                <th class="py-3.5 px-4 font-semibold">Sirkulasi Aktif</th>
                                <th class="py-3.5 px-4 font-semibold">Status</th>
                                <th class="py-3.5 px-4 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members as $m)
                                @php($activeBorrows = $m->borrowings()->where('status', 'borrowed')->count())
                                <tr wire:click="select({{ $m->id }})" class="cursor-pointer transition-colors {{ $selectedId === $m->id ? 'bg-brand/10' : 'hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440]' }}">
                                    <td class="py-4 px-4 font-semibold text-primary dark:text-white whitespace-nowrap">
                                        <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full {{ $m->status === 'active' ? 'bg-secondary' : 'bg-danger' }}" aria-hidden="true"></span>{{ $m->member_code }}</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-3">
                                            <span class="w-10 h-10 rounded-full bg-navy text-white flex items-center justify-center font-poppins font-semibold text-[15px] flex-shrink-0" aria-hidden="true">{{ strtoupper(substr($m->name, 0, 1)) }}</span>
                                            <div class="flex flex-col min-w-0">
                                                <span class="font-semibold text-primary dark:text-white truncate">{{ $m->name }}</span>
                                                <span class="text-[#45464E] dark:text-[#9AA7C2] text-[11px] truncate">{{ $m->email }}@if($m->phone) • {{ $m->phone }}@endif</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-[#45464E] dark:text-[#9AA7C2] whitespace-nowrap">{{ $m->created_at->format('d M Y') }}</td>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        @if($activeBorrows > 0)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-secondary/15 text-secondary dark:text-[#9CC2FF] text-[12px] font-medium"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">auto_stories</span>{{ $activeBorrows }} Buku Dipinjam</span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#F0F3FF] dark:bg-[#1A2440] text-[#45464E] dark:text-[#9AA7C2] text-[12px]"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">check</span>Bebas Pinjaman</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 whitespace-nowrap">
                                        @if($m->status === 'active')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-success/15 text-success text-[11px] font-semibold uppercase"><span class="w-1.5 h-1.5 rounded-full bg-success" aria-hidden="true"></span>Aktif</span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-danger/15 text-danger text-[11px] font-semibold uppercase"><span class="w-1.5 h-1.5 rounded-full bg-danger" aria-hidden="true"></span>Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 text-right whitespace-nowrap" wire:click.stop>
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="/admin/borrowings/create?member={{ $m->id }}" class="px-2.5 py-1 rounded-md bg-secondary text-white text-[12px] font-medium hover:brightness-110 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]" aria-hidden="true">bookmark_add</span>Pinjam</a>
                                            <button wire:click="select({{ $m->id }})" type="button" class="p-1.5 rounded-md text-[#45464E] dark:text-[#9AA7C2] hover:text-primary" title="Detail"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">visibility</span></button>
                                            <button wire:click="edit({{ $m->id }})" type="button" class="p-1.5 rounded-md text-[#45464E] dark:text-[#9AA7C2] hover:text-primary" title="Edit"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">edit</span></button>
                                            @if($confirmingDelete === $m->id)
                                                <button wire:click="delete({{ $m->id }})" type="button" class="px-2 py-1 rounded-md bg-danger text-white text-[12px]">Yakin?</button>
                                            @else
                                                <button wire:click="$set('confirmingDelete', {{ $m->id }})" type="button" class="p-1.5 rounded-md text-[#45464E] dark:text-[#9AA7C2] hover:text-error" title="Hapus"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">delete</span></button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="py-8 text-center text-[#45464E] dark:text-[#9AA7C2]">Belum ada anggota.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3.5 flex flex-col sm:flex-row items-center justify-between gap-2 border-t border-line dark:border-[#263252]">
                    <span class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">Menampilkan <span class="font-semibold text-primary dark:text-white">{{ $members->firstItem() ?? 0 }} - {{ $members->lastItem() ?? 0 }}</span> dari <span class="font-semibold text-primary dark:text-white">{{ $members->total() }}</span> anggota</span>
                    {{ $members->links() }}
                </div>
            </div>
        </div>

        {{-- Preview card --}}
        <div class="w-full xl:w-[380px] flex-shrink-0 flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary text-[20px]" aria-hidden="true">badge</span>
                    <span class="font-semibold text-primary dark:text-white">Pratinjau Kartu Anggota</span>
                </div>
            </div>
            @if($selected)
                <div class="relative w-full rounded-2xl p-6 text-white shadow-xl overflow-hidden flex flex-col justify-between min-h-[220px]" style="background: linear-gradient(to bottom right, #1F2D4D, #1A2642, #16223B);">
                    <div class="absolute -right-12 -top-12 w-48 h-48 rounded-full bg-[#4F8EF7]/20 blur-2xl pointer-events-none" aria-hidden="true"></div>
                    <div class="relative z-10 flex items-start justify-between">
                        <div class="flex items-center gap-2.5">
                            <img src="{{ asset('assets/logo/libraria-mark.svg') }}" alt="" class="w-9 h-9" aria-hidden="true">
                            <div class="flex flex-col">
                                <span class="font-poppins text-[15px] font-semibold tracking-wide">LIBRARIA</span>
                                <span class="text-[10px] text-white/70 uppercase tracking-widest">Kartu Anggota</span>
                            </div>
                        </div>
                        <span class="w-2 h-2 rounded-full {{ $selected->status === 'active' ? 'bg-success' : 'bg-danger' }}" aria-hidden="true"></span>
                    </div>
                    <div class="relative z-10 flex items-center gap-4 pt-2">
                        <span class="w-14 h-[4.5rem] rounded-lg bg-white/15 border border-white/25 text-white flex items-center justify-center font-poppins font-bold text-[24px] flex-shrink-0" aria-hidden="true">{{ strtoupper(substr($selected->name, 0, 1)) }}</span>
                        <div class="flex flex-col min-w-0 flex-1">
                            <span class="font-poppins text-[17px] font-semibold truncate">{{ $selected->name }}</span>
                            <span class="text-[12px] text-white/80 font-mono tracking-wider">{{ $selected->member_code }}</span>
                            <span class="text-[12px] text-white/70 truncate mt-0.5">{{ $selected->email }}</span>
                        </div>
                    </div>
                    <div class="relative z-10 flex items-end justify-between pt-2 border-t border-white/10">
                        <div class="flex flex-col">
                            <span class="text-[9px] text-white/60 uppercase tracking-wider">Masa Aktif</span>
                            <span class="text-[12px] font-bold tracking-widest">{{ $selected->active_until ? $selected->active_until->format('d M Y') : '-' }}</span>
                        </div>
                        <span class="text-[11px] px-2 py-0.5 rounded-full {{ $selected->status === 'active' ? 'bg-success/20 text-white' : 'bg-danger/20 text-white' }}">{{ ucfirst($selected->status) }}</span>
                    </div>
                </div>
                <div class="bg-white dark:bg-[#131B2E] p-4 rounded-xl border border-line dark:border-[#263252] flex flex-col gap-3">
                    <div class="flex items-center justify-between">
                        <span class="text-[14px] font-semibold">Tindakan Cepat</span>
                        <span class="text-[11px] px-2 py-0.5 rounded-full {{ $selected->status === 'active' ? 'bg-success/15 text-success' : 'bg-danger/15 text-danger' }} font-semibold">{{ ucfirst($selected->status) }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="/admin/borrowings/create?member={{ $selected->id }}" class="flex items-center justify-center gap-1.5 py-2 px-3 rounded-lg bg-[#F0F3FF] dark:bg-[#1A2440] hover:bg-[#E7EEFF] dark:hover:bg-[#263252] text-primary dark:text-white text-[13px] font-medium">
                            <span class="material-symbols-outlined text-[18px]" aria-hidden="true">bookmark_add</span>Pinjam
                        </a>
                        <button type="button" onclick="window.print()" class="flex items-center justify-center gap-1.5 py-2 px-3 rounded-lg bg-[#F0F3FF] dark:bg-[#1A2440] hover:bg-[#E7EEFF] dark:hover:bg-[#263252] text-primary dark:text-white text-[13px] font-medium">
                            <span class="material-symbols-outlined text-[18px]" aria-hidden="true">print</span>Cetak Kartu
                        </button>
                    </div>
                    <div class="h-px bg-line dark:bg-[#263252]"></div>
                    <span class="text-[12px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wider">Status Pinjaman Terkini</span>
                    <div class="flex flex-col gap-2">
                        @forelse($selectedBorrows as $b)
                            @foreach($b->details->where('status', 'borrowed') as $d)
                                <div class="p-2.5 rounded-lg bg-canvas dark:bg-[#0B1326] flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <span class="material-symbols-outlined text-secondary text-[20px]" aria-hidden="true">book_4</span>
                                        <div class="flex flex-col min-w-0">
                                            <span class="text-[14px] font-semibold text-primary dark:text-white truncate">{{ $d->book->title ?? '-' }}</span>
                                            <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Jatuh tempo: {{ \Carbon\Carbon::parse($b->due_at)->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                    @php($diff = (int) now()->toDateString() < $b->due_at ? \Carbon\Carbon::parse($b->due_at)->diffInDays(now()->toDateString()) : 0)
                                    @if($b->due_at < now()->toDateString())
                                        <span class="text-[11px] px-2 py-0.5 rounded bg-errorbox dark:bg-[#BA1A1A]/20 text-error dark:text-[#FFB4AB] font-semibold whitespace-nowrap">Terlambat</span>
                                    @else
                                        <span class="text-[11px] px-2 py-0.5 rounded bg-success/15 text-success font-semibold whitespace-nowrap">{{ $diff }} Hari Lagi</span>
                                    @endif
                                </div>
                            @endforeach
                        @empty
                            <div class="p-3 rounded-lg bg-canvas dark:bg-[#0B1326] text-center text-[#45464E] dark:text-[#9AA7C2] text-[13px]">Tidak ada buku yang sedang dipinjam.</div>
                        @endforelse
                    </div>
                    <a href="/admin/reports" class="w-full py-2.5 rounded-lg bg-primary dark:bg-brand text-white text-[14px] hover:brightness-110 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px]" aria-hidden="true">history</span>Buka Riwayat &amp; Laporan
                    </a>
                </div>
            @else
                <div class="bg-white dark:bg-[#131B2E] p-8 rounded-xl border border-dashed border-line dark:border-[#263252] text-center text-[13px] text-[#45464E] dark:text-[#9AA7C2]">Klik baris anggota untuk pratinjau kartu.</div>
            @endif
        </div>
    </div>
</div>
