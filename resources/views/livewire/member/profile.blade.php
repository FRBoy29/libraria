<div class="space-y-6" x-data="{ cardModal: false }">
    <div>
        <h1 class="font-poppins text-[24px] text-navy dark:text-white font-bold">Profil Pemustaka</h1>
        <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">Kelola identitas, kata sandi, dan kartu anggota digital Anda.</p>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-2 rounded-lg text-[13px]">{{ session('success') }}</div>
    @endif

    {{-- Kartu Anggota Digital --}}
    <div class="bg-white dark:bg-[#131B2E] rounded-xl p-6 border border-line dark:border-[#263252]">
        <div class="flex items-center justify-between pb-2">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary text-[22px]" aria-hidden="true">badge</span>
                <h2 class="font-poppins text-[16px] text-navy dark:text-white font-bold">Kartu Anggota Digital</h2>
            </div>
            <span class="px-2 py-0.5 rounded-full text-[11px] {{ $member->status === 'active' ? 'bg-success/15 text-success' : 'bg-errorbox text-error' }} font-semibold">{{ ucfirst($member->status) }}</span>
        </div>
        <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2] pb-2">Tunjukkan kepada petugas saat peminjaman/pengembalian.</p>
        <div class="pt-2">
            <div class="p-5 rounded-2xl text-white" style="background: linear-gradient(135deg, #1c2547 0%, #101a33 100%);">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-2.5">
                        <img src="{{ asset('assets/logo/libraria-mark.svg') }}" alt="Logo LIBRARIA" class="w-9 h-9">
                        <div class="flex flex-col leading-tight">
                            <span class="font-poppins font-bold text-[17px] tracking-wide">LIBRARIA</span>
                            <span class="text-[10px] tracking-[0.22em] text-white/50 font-medium">KARTU ANGGOTA</span>
                        </div>
                    </div>
                    <span class="w-2.5 h-2.5 rounded-full mt-1 {{ $member->status === 'active' ? 'bg-success' : 'bg-danger' }}" aria-label="Status {{ $member->status }}"></span>
                </div>
                <div class="flex items-center gap-4 mt-5">
                    <span class="w-14 h-14 rounded-lg bg-[#9aa0b0] text-[#1a2340] flex items-center justify-center font-poppins font-bold text-[26px] shrink-0" aria-hidden="true">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                    <div class="flex flex-col min-w-0">
                        <span class="font-poppins font-bold text-[19px] truncate">{{ $member->name }}</span>
                        <span class="font-mono text-[12px] text-white/55">{{ $member->member_code }}</span>
                        <span class="text-[12px] text-white/55 truncate">{{ $member->email }}</span>
                    </div>
                </div>
                <div class="border-t border-white/10 mt-5 pt-3 flex items-end justify-between">
                    <div class="flex flex-col">
                        <span class="text-[10px] tracking-[0.2em] text-white/50 font-medium">MASA AKTIF</span>
                        <span class="font-poppins font-bold text-[15px] mt-0.5">{{ $member->active_until ? \Carbon\Carbon::parse($member->active_until)->format('d M Y') : '—' }}</span>
                    </div>
                    <span class="px-3 py-1 rounded-full text-[11px] font-semibold {{ $member->status === 'active' ? 'bg-success/25 text-[#4ade80]' : 'bg-danger/25 text-[#f87171]' }}">{{ ucfirst($member->status) }}</span>
                </div>
            </div>
            <button type="button" @click="cardModal = true" class="w-full mt-4 py-2.5 px-4 rounded-lg bg-[#D8E3FB] dark:bg-[#2d3449] hover:bg-[#DEE8FF] dark:hover:bg-[#3b465e] text-navy dark:text-white text-[12px] font-semibold flex items-center justify-center gap-2 transition-all">
                <span class="material-symbols-outlined text-[20px] text-brand dark:text-[#9CC2FF]" aria-hidden="true">qr_code_scanner</span>
                <span>Tampilkan Kartu Anggota</span>
            </button>
        </div>
    </div>

    {{-- Info singkat keanggotaan --}}
    <div class="bg-white dark:bg-[#131B2E] rounded-xl p-6 border border-line dark:border-[#263252] grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div>
            <p class="text-[12px] text-[#45464E] dark:text-[#9AA7C2] font-semibold uppercase tracking-wider">Member ID</p>
            <p class="font-poppins font-bold text-navy dark:text-white mt-1">{{ $member->member_code }}</p>
        </div>
        <div>
            <p class="text-[12px] text-[#45464E] dark:text-[#9AA7C2] font-semibold uppercase tracking-wider">Nama</p>
            <p class="font-poppins font-bold text-navy dark:text-white mt-1">{{ $member->name }}</p>
        </div>
        <div>
            <p class="text-[12px] text-[#45464E] dark:text-[#9AA7C2] font-semibold uppercase tracking-wider">Status</p>
            <p class="font-poppins font-bold {{ $member->status === 'active' ? 'text-success' : 'text-error' }} mt-1">{{ ucfirst($member->status) }}</p>
        </div>
        <div>
            <p class="text-[12px] text-[#45464E] dark:text-[#9AA7C2] font-semibold uppercase tracking-wider">Masa Aktif</p>
            <p class="font-poppins font-bold text-navy dark:text-white mt-1">{{ $member->active_until ? \Carbon\Carbon::parse($member->active_until)->format('d M Y') : '—' }}</p>
        </div>
    </div>

    {{-- Form & Password --}}
    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-[#131B2E] rounded-xl p-6 border border-line dark:border-[#263252]">
            <h2 class="font-poppins text-[16px] text-navy dark:text-white font-bold mb-4">Data Pribadi</h2>
            <form wire:submit="saveProfile" class="space-y-3">
                <div>
                    <label class="text-[12px] text-[#45464E] dark:text-[#9AA7C2] font-semibold">Email</label>
                    <input wire:model="email" type="email" class="w-full mt-1 h-10 px-3 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[13px] text-navy dark:text-[#DAE2FD] focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/15" placeholder="Email">
                    @error('email')<p class="text-error dark:text-[#FFB4AB] text-[12px] mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-[12px] text-[#45464E] dark:text-[#9AA7C2] font-semibold">Nomor HP</label>
                    <input wire:model="phone" class="w-full mt-1 h-10 px-3 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[13px] text-navy dark:text-[#DAE2FD] focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/15" placeholder="Nomor HP">
                </div>
                <div>
                    <label class="text-[12px] text-[#45464E] dark:text-[#9AA7C2] font-semibold">Alamat</label>
                    <textarea wire:model="address" rows="2" class="w-full mt-1 px-3 py-2 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[13px] text-navy dark:text-[#DAE2FD] focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/15" placeholder="Alamat"></textarea>
                </div>
                <button class="w-full h-10 rounded-lg bg-brand dark:bg-[#508ff8] text-white dark:text-[#002f68] text-[13px] font-semibold hover:brightness-110 transition">Simpan Perubahan</button>
            </form>
        </div>
        <div class="bg-white dark:bg-[#131B2E] rounded-xl p-6 border border-line dark:border-[#263252]">
            <h2 class="font-poppins text-[16px] text-navy dark:text-white font-bold mb-4">Ganti Password</h2>
            <form wire:submit="changePassword" class="space-y-3">
                <div>
                    <label class="text-[12px] text-[#45464E] dark:text-[#9AA7C2] font-semibold">Password Saat Ini</label>
                    <input wire:model="current_password" type="password" class="w-full mt-1 h-10 px-3 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[13px] text-navy dark:text-[#DAE2FD] focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/15" placeholder="Password saat ini">
                    @error('current_password')<p class="text-error dark:text-[#FFB4AB] text-[12px] mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-[12px] text-[#45464E] dark:text-[#9AA7C2] font-semibold">Password Baru</label>
                    <input wire:model="new_password" type="password" class="w-full mt-1 h-10 px-3 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[13px] text-navy dark:text-[#DAE2FD] focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/15" placeholder="Password baru">
                    @error('new_password')<p class="text-error dark:text-[#FFB4AB] text-[12px] mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-[12px] text-[#45464E] dark:text-[#9AA7C2] font-semibold">Konfirmasi Password Baru</label>
                    <input wire:model="new_password_confirmation" type="password" class="w-full mt-1 h-10 px-3 rounded-lg bg-canvas dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[13px] text-navy dark:text-[#DAE2FD] focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/15" placeholder="Konfirmasi password baru">
                </div>
                <button class="w-full h-10 rounded-lg bg-navy dark:bg-brand text-white text-[13px] font-semibold hover:brightness-110 transition">Ganti Password</button>
            </form>
        </div>
    </div>

    {{-- Modal Kartu Anggota --}}
    <div x-show="cardModal" x-cloak class="fixed inset-0 z-[100] bg-[#0B1326]/80 backdrop-blur-md flex items-center justify-center p-4" @keydown.escape.window="cardModal = false" role="dialog" aria-modal="true" aria-labelledby="member-card-title">
        <div class="bg-white dark:bg-[#131B2E] rounded-xl max-w-md w-full p-6 shadow-2xl flex flex-col gap-4 relative border border-line dark:border-[#263252]">
            <button type="button" @click="cardModal = false" class="absolute top-4 right-4 p-1.5 rounded-lg text-[#75777F] dark:text-[#8c909e] hover:text-navy dark:hover:text-white hover:bg-[#F0F3FF] dark:hover:bg-[#1A2440] transition-colors" aria-label="Tutup"><span class="material-symbols-outlined" aria-hidden="true">close</span></button>
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-golddark dark:text-gold" aria-hidden="true">badge</span>
                <h3 id="member-card-title" class="font-poppins text-[20px] text-navy dark:text-white font-semibold">Kartu Pemustaka Resmi</h3>
            </div>
            <div class="p-4 rounded-xl bg-[#F0F3FF] dark:bg-[#0B1326] flex flex-col items-center gap-4 text-center">
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
                <button type="button" @click="cardModal = false" class="w-full py-2.5 rounded-lg bg-brand dark:bg-[#508ff8] text-white dark:text-[#002f68] text-[12px] font-semibold hover:brightness-110">Tutup</button>
            </div>
        </div>
    </div>
</div>
