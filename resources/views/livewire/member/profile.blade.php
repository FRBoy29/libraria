<div class="space-y-6" x-data="{ cardModal: false }">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2">
                <span class="text-[11px] text-secondary dark:text-[#9CC2FF] tracking-widest uppercase font-semibold">ID Akun &amp; Keanggotaan</span>
                <span class="w-1.5 h-1.5 rounded-full bg-secondary dark:bg-[#9CC2FF]" aria-hidden="true"></span>
                <span class="font-mono text-[12px] text-[#45464E] dark:text-[#9AA7C2]">{{ $member->member_code }}</span>
            </div>
            <h1 class="font-poppins text-[32px] leading-[40px] text-navy dark:text-white font-semibold tracking-tight">Profil Pemustaka</h1>
            <p class="text-[14px] text-[#45464E] dark:text-[#9AA7C2] max-w-2xl">Kelola identitas, kata sandi, dan kartu anggota digital Anda dalam repositori terpadu Libraria.</p>
        </div>
        <div class="flex items-center gap-2">
            <div class="px-3 py-1.5 rounded-full bg-[#F0F3FF] dark:bg-[#1A2440] border border-line dark:border-[#263252] flex items-center gap-1.5">
                <span class="material-symbols-outlined text-secondary dark:text-[#9CC2FF] text-[16px]" aria-hidden="true">verified</span>
                <span class="text-[12px] text-navy dark:text-white font-medium">Anggota Terverifikasi</span>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" class="flex items-center justify-between p-4 bg-[#F0F3FF] dark:bg-[#1A2440] border border-line dark:border-[#263252] rounded-xl">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-full bg-success/15 text-success flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">check_circle</span></span>
                <span class="text-[14px] text-navy dark:text-white font-medium">{{ session('success') }}</span>
            </div>
            <button type="button" @click="show = false" class="p-1.5 text-[#45464E] dark:text-[#9AA7C2] hover:text-navy dark:hover:text-white rounded-lg" aria-label="Tutup notifikasi"><span class="material-symbols-outlined text-[18px]" aria-hidden="true">close</span></button>
        </div>
    @endif

    {{-- Kartu + ringkasan --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
        <div class="lg:col-span-7 flex flex-col justify-between p-6 rounded-xl bg-gradient-to-br from-[#DEE8FF] dark:from-[#222A3D] via-[#F0F3FF] dark:via-[#171f33] to-[#F8FAFC] dark:to-[#131B2E] border border-line dark:border-[#263252] relative overflow-hidden">
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-brand/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
            <div class="absolute -left-12 -bottom-12 w-48 h-48 bg-gold/10 rounded-full blur-2xl pointer-events-none" aria-hidden="true"></div>
            <div class="relative z-10 flex flex-col gap-4">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="w-10 h-10 rounded-lg bg-white dark:bg-[#0B1326] flex items-center justify-center text-brand dark:text-[#9CC2FF] shadow-sm"><span class="material-symbols-outlined text-[20px]" aria-hidden="true">badge</span></span>
                        <div>
                            <span class="block text-[11px] text-[#8A5A1D] dark:text-[#e3c290] uppercase tracking-wider">Identitas Pemustaka Digital</span>
                            <h2 class="font-poppins text-[20px] text-navy dark:text-white font-semibold">Kartu Anggota Digital</h2>
                        </div>
                    </div>
                    <span class="flex items-center gap-1.5 px-2.5 py-1 rounded-full {{ $member->status === 'active' ? 'bg-success/15 text-success' : 'bg-errorbox dark:bg-[#BA1A1A]/20 text-error dark:text-[#FFB4AB]' }} text-[11px] font-semibold uppercase tracking-wider">
                        <span class="w-1.5 h-1.5 rounded-full {{ $member->status === 'active' ? 'bg-success animate-pulse' : 'bg-error' }}" aria-hidden="true"></span>{{ ucfirst($member->status) }}
                    </span>
                </div>
                <div class="relative w-full rounded-2xl p-6 text-white shadow-xl overflow-hidden flex flex-col justify-between min-h-[220px]" style="background: linear-gradient(to bottom right, #1F2D4D, #1A2642, #16223B);">
                    <div class="absolute -right-12 -top-12 w-48 h-48 rounded-full bg-[#4F8EF7]/20 blur-2xl pointer-events-none" aria-hidden="true"></div>
                    <div class="relative z-10 flex items-start justify-between">
                        <div class="flex items-center gap-2.5">
                            <img src="{{ asset('assets/logo/libraria-mark.svg') }}" alt="Logo LIBRARIA" class="w-9 h-9">
                            <div class="flex flex-col">
                                <span class="font-poppins font-semibold text-[15px] tracking-wide">LIBRARIA</span>
                                <span class="text-[10px] text-white/70 uppercase tracking-widest">Kartu Anggota</span>
                            </div>
                        </div>
                        <span class="w-2 h-2 rounded-full {{ $member->status === 'active' ? 'bg-success' : 'bg-danger' }}" aria-label="Status {{ $member->status }}"></span>
                    </div>
                    <div class="relative z-10 flex items-center gap-4 pt-2">
                        <span class="w-14 h-[4.5rem] rounded-lg bg-white/15 border border-white/25 text-white flex items-center justify-center font-poppins font-bold text-[24px] flex-shrink-0" aria-hidden="true">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                        <div class="flex flex-col min-w-0 flex-1">
                            <span class="font-poppins font-semibold text-[17px] truncate">{{ $member->name }}</span>
                            <span class="text-[12px] text-white/80 font-mono tracking-wider">{{ $member->member_code }}</span>
                            <span class="text-[12px] text-white/70 truncate mt-0.5">{{ $member->email }}</span>
                        </div>
                    </div>
                    <div class="relative z-10 flex items-end justify-between pt-2 border-t border-white/10">
                        <div class="flex flex-col">
                            <span class="text-[9px] text-white/60 uppercase tracking-wider">Masa Aktif</span>
                            <span class="text-[12px] font-bold tracking-widest">{{ $member->active_until ? \Carbon\Carbon::parse($member->active_until)->format('d M Y') : '—' }}</span>
                        </div>
                        <span class="text-[11px] px-2 py-0.5 rounded-full {{ $member->status === 'active' ? 'bg-success/20 text-white' : 'bg-danger/20 text-white' }}">{{ ucfirst($member->status) }}</span>
                    </div>
                </div>
            </div>
            <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">Tunjukkan kartu ini kepada petugas saat peminjaman atau pengembalian buku fisik.</p>
            <div class="pt-3 flex flex-wrap items-center gap-2">
                <button type="button" @click="cardModal = true" class="flex items-center gap-1.5 px-5 py-2.5 rounded-lg bg-brand dark:bg-[#508ff8] text-white dark:text-[#002f68] text-[14px] font-medium hover:brightness-110 transition-all">
                    <span class="material-symbols-outlined text-[18px]" aria-hidden="true">qr_code_scanner</span><span>Tampilkan Kartu Anggota</span>
                </button>
                <button wire:click="downloadCard" type="button" class="flex items-center gap-1.5 px-4 py-2.5 rounded-lg bg-[#F0F3FF] dark:bg-[#1A2440] border border-line dark:border-[#263252] hover:bg-[#E7EEFF] dark:hover:bg-[#263252] text-[14px] font-medium transition-colors">
                    <span class="material-symbols-outlined text-[18px]" aria-hidden="true">download</span><span>Unduh Format PDF</span>
                </button>
            </div>
        </div>

        <div class="lg:col-span-5 flex flex-col gap-4">
            <div class="p-5 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] border border-line dark:border-[#263252] flex flex-col justify-between gap-4">
                <div class="flex items-center justify-between">
                    <span class="text-[11px] text-[#8A5A1D] dark:text-[#e3c290] uppercase tracking-wider">Aktivitas Pemustaka</span>
                    <a href="/member/activity" class="text-[11px] text-brand dark:text-[#9CC2FF] font-semibold hover:underline">Lihat aktivitas</a>
                </div>
                <div class="grid grid-cols-3 gap-2 text-center">
                    <div class="p-3 rounded-lg bg-white dark:bg-[#0B1326] border border-line dark:border-[#263252]">
                        <p class="font-poppins text-[22px] font-bold text-navy dark:text-white">{{ $activeQty }}</p>
                        <p class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Dipinjam</p>
                    </div>
                    <div class="p-3 rounded-lg bg-white dark:bg-[#0B1326] border border-line dark:border-[#263252]">
                        <p class="font-poppins text-[22px] font-bold text-navy dark:text-white">{{ $historyQty }}</p>
                        <p class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Selesai</p>
                    </div>
                    <div class="p-3 rounded-lg bg-white dark:bg-[#0B1326] border border-line dark:border-[#263252]">
                        <p class="font-poppins text-[22px] font-bold {{ $overdueCount > 0 ? 'text-error dark:text-[#FFB4AB]' : 'text-navy dark:text-white' }}">{{ $overdueCount }}</p>
                        <p class="text-[11px] text-[#45464E] dark:text-[#9AA7C2]">Terlambat</p>
                    </div>
                </div>
                <a href="/member/books" class="flex items-center justify-center gap-1.5 w-full py-2.5 rounded-lg bg-brand dark:bg-[#508ff8] text-white dark:text-[#002f68] text-[13px] font-semibold hover:brightness-110 transition-all">
                    <span class="material-symbols-outlined text-[18px]" aria-hidden="true">search</span>Jelajahi Katalog
                </a>
            </div>
            <div class="p-4 rounded-lg bg-[#F0F3FF] dark:bg-[#1A2440] border border-line dark:border-[#263252] flex items-start gap-2.5">
                <span class="material-symbols-outlined text-[20px] text-[#8A5A1D] dark:text-[#e3c290] shrink-0" aria-hidden="true">info</span>
                <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2] leading-relaxed">Peminjaman dan pengembalian buku diproses oleh petugas pada jam layanan <strong>08:00 – 17:00 WIB</strong>.</p>
            </div>
        </div>
    </div>

    {{-- Strip info --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-4 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] border border-line dark:border-[#263252] flex items-center gap-3">
            <span class="w-12 h-12 rounded-lg bg-white dark:bg-[#0B1326] flex items-center justify-center text-brand dark:text-[#9CC2FF] shrink-0"><span class="material-symbols-outlined text-[20px]" aria-hidden="true">pin</span></span>
            <div class="flex flex-col min-w-0">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wider">Member ID</span>
                <span class="font-mono text-[13px] text-navy dark:text-white font-medium truncate">{{ $member->member_code }}</span>
            </div>
        </div>
        <div class="p-4 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] border border-line dark:border-[#263252] flex items-center gap-3">
            <span class="w-12 h-12 rounded-lg bg-white dark:bg-[#0B1326] flex items-center justify-center text-[#8A5A1D] dark:text-[#e3c290] shrink-0"><span class="material-symbols-outlined text-[20px]" aria-hidden="true">person</span></span>
            <div class="flex flex-col min-w-0">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wider">Nama Lengkap</span>
                <span class="text-[14px] text-navy dark:text-white font-medium truncate">{{ $member->name }}</span>
            </div>
        </div>
        <div class="p-4 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] border border-line dark:border-[#263252] flex items-center gap-3">
            <span class="w-12 h-12 rounded-lg bg-white dark:bg-[#0B1326] flex items-center justify-center text-brand dark:text-[#9CC2FF] shrink-0"><span class="material-symbols-outlined text-[20px]" aria-hidden="true">check_box</span></span>
            <div class="flex flex-col min-w-0">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wider">Status Akun</span>
                <span class="flex items-center gap-1.5 text-[14px] text-brand dark:text-[#9CC2FF] font-medium"><span class="w-2 h-2 rounded-full {{ $member->status === 'active' ? 'bg-success' : 'bg-error' }}" aria-hidden="true"></span>{{ $member->status === 'active' ? 'Aktif Penuh' : ucfirst($member->status) }}</span>
            </div>
        </div>
        <div class="p-4 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] border border-line dark:border-[#263252] flex items-center gap-3">
            <span class="w-12 h-12 rounded-lg bg-white dark:bg-[#0B1326] flex items-center justify-center text-[#8A5A1D] dark:text-[#e3c290] shrink-0"><span class="material-symbols-outlined text-[20px]" aria-hidden="true">event_available</span></span>
            <div class="flex flex-col min-w-0">
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] uppercase tracking-wider">Masa Aktif</span>
                <span class="font-mono text-[13px] text-navy dark:text-white font-medium truncate">{{ $member->active_until ? \Carbon\Carbon::parse($member->active_until)->format('d M Y') : '—' }}</span>
            </div>
        </div>
    </div>

    {{-- Form & Password --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start" x-data="{ showCurrent: false, showNew: false, showConfirm: false }">
        <div class="p-6 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] border border-line dark:border-[#263252] flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-brand dark:text-[#9CC2FF] text-[20px]" aria-hidden="true">badge</span>
                    <h2 class="font-poppins text-[20px] text-navy dark:text-white font-semibold">Data Pribadi</h2>
                </div>
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] uppercase">Sirkulasi Umum</span>
            </div>
            <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">Perbarui informasi kontak agar staf dapat mengabarkan ketersediaan buku dan pengingat tanggal jatuh tempo.</p>
            <form wire:submit="saveProfile" class="flex flex-col gap-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-[12px] text-navy dark:text-white uppercase tracking-wider font-medium" for="email">Alamat Surel (Email)</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3.5 text-[#45464E] dark:text-[#9AA7C2] text-[18px] pointer-events-none" aria-hidden="true">mail</span>
                        <input wire:model="email" type="email" id="email" class="w-full bg-white dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] text-navy dark:text-[#DAE2FD] pl-10 pr-3 h-11 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary/20">
                    </div>
                    @error('email')<p class="text-error dark:text-[#FFB4AB] text-[12px]">{{ $message }}</p>@enderror
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-[12px] text-navy dark:text-white uppercase tracking-wider font-medium" for="phone">Nomor Handphone / WhatsApp</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3.5 text-[#45464E] dark:text-[#9AA7C2] text-[18px] pointer-events-none" aria-hidden="true">call</span>
                        <input wire:model="phone" type="tel" id="phone" class="w-full bg-white dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] text-navy dark:text-[#DAE2FD] pl-10 pr-3 h-11 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary/20">
                    </div>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-[12px] text-navy dark:text-white uppercase tracking-wider font-medium" for="address">Alamat Domisili Tetap</label>
                    <div class="relative flex">
                        <span class="material-symbols-outlined absolute left-3.5 top-3 text-[#45464E] dark:text-[#9AA7C2] text-[18px] pointer-events-none" aria-hidden="true">home</span>
                        <textarea wire:model="address" id="address" rows="3" class="w-full bg-white dark:bg-[#0B1326] border border-line dark:border-[#263252] text-[14px] text-navy dark:text-[#DAE2FD] pl-10 pr-3 py-2.5 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary/20 resize-none"></textarea>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button class="flex items-center gap-1.5 px-5 py-2.5 rounded-lg bg-brand dark:bg-[#508ff8] text-white dark:text-[#002f68] text-[14px] font-medium hover:brightness-110 transition-all">
                        <span class="material-symbols-outlined text-[18px]" aria-hidden="true">save</span><span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>

        <div class="p-6 rounded-xl bg-[#F0F3FF] dark:bg-[#1A2440] border border-line dark:border-[#263252] flex flex-col gap-4" x-data="{ score: 0, label: '' }">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[#8A5A1D] dark:text-[#e3c290] text-[20px]" aria-hidden="true">lock_reset</span>
                    <h2 class="font-poppins text-[20px] text-navy dark:text-white font-semibold">Ganti Password</h2>
                </div>
                <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] uppercase">Autentikasi</span>
            </div>
            <p class="text-[13px] text-[#45464E] dark:text-[#9AA7C2]">Gunakan kombinasi minimal 8 karakter dengan huruf kapital, angka, dan simbol untuk mengamankan akses katalog Anda.</p>
            <form wire:submit="changePassword" class="flex flex-col gap-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-[12px] text-navy dark:text-white uppercase tracking-wider font-medium" for="current_password">Password Saat Ini</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3.5 text-[#45464E] dark:text-[#9AA7C2] text-[18px] pointer-events-none" aria-hidden="true">key</span>
                        <input wire:model="current_password" :type="showCurrent ? 'text' : 'password'" id="current_password" placeholder="••••••••" class="w-full bg-white dark:bg-[#0B1326] border border-line dark:border-[#263252] placeholder-[#75777F] dark:placeholder-[#8c909e] text-[14px] text-navy dark:text-[#DAE2FD] pl-10 pr-10 h-11 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary/20">
                        <button type="button" @click="showCurrent = !showCurrent" class="absolute right-3 text-[#45464E] dark:text-[#9AA7C2] hover:text-navy dark:hover:text-white" aria-label="Tampilkan atau sembunyikan password"><span class="material-symbols-outlined text-[18px]" x-text="showCurrent ? 'visibility_off' : 'visibility'" aria-hidden="true">visibility</span></button>
                    </div>
                    @error('current_password')<p class="text-error dark:text-[#FFB4AB] text-[12px]">{{ $message }}</p>@enderror
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-[12px] text-navy dark:text-white uppercase tracking-wider font-medium" for="new_password">Password Baru</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3.5 text-[#45464E] dark:text-[#9AA7C2] text-[18px] pointer-events-none" aria-hidden="true">lock</span>
                        <input wire:model="new_password" :type="showNew ? 'text' : 'password'" id="new_password" placeholder="Minimal 8 karakter" class="w-full bg-white dark:bg-[#0B1326] border border-line dark:border-[#263252] placeholder-[#75777F] dark:placeholder-[#8c909e] text-[14px] text-navy dark:text-[#DAE2FD] pl-10 pr-10 h-11 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary/20" @input="score = $event.target.value.length === 0 ? 0 : ($event.target.value.length < 8 ? 1 : (/[A-Z]/.test($event.target.value) && /[0-9]/.test($event.target.value) ? 4 : 2)); label = ['Kosong', 'Lemah', 'Cukup', '', 'Kuat'][score] ?? ''">
                        <button type="button" @click="showNew = !showNew" class="absolute right-3 text-[#45464E] dark:text-[#9AA7C2] hover:text-navy dark:hover:text-white" aria-label="Tampilkan atau sembunyikan password"><span class="material-symbols-outlined text-[18px]" x-text="showNew ? 'visibility_off' : 'visibility'" aria-hidden="true">visibility</span></button>
                    </div>
                    <div class="flex items-center gap-1.5 pt-1">
                        <template x-for="i in [1,2,3,4]" :key="i">
                            <div class="h-1 flex-1 rounded-full transition-colors" :class="score >= i ? (score >= 4 ? 'bg-brand dark:bg-[#508ff8]' : (score >= 2 ? 'bg-gold' : 'bg-error')) : 'bg-[#D8E3FB] dark:bg-[#2d3449]'"></div>
                        </template>
                        <span class="text-[11px] text-[#45464E] dark:text-[#9AA7C2] ml-1" x-text="label"></span>
                    </div>
                    @error('new_password')<p class="text-error dark:text-[#FFB4AB] text-[12px]">{{ $message }}</p>@enderror
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-[12px] text-navy dark:text-white uppercase tracking-wider font-medium" for="new_password_confirmation">Konfirmasi Password Baru</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3.5 text-[#45464E] dark:text-[#9AA7C2] text-[18px] pointer-events-none" aria-hidden="true">done_all</span>
                        <input wire:model="new_password_confirmation" :type="showConfirm ? 'text' : 'password'" id="new_password_confirmation" placeholder="Ulangi password baru" class="w-full bg-white dark:bg-[#0B1326] border border-line dark:border-[#263252] placeholder-[#75777F] dark:placeholder-[#8c909e] text-[14px] text-navy dark:text-[#DAE2FD] pl-10 pr-10 h-11 rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary/20">
                        <button type="button" @click="showConfirm = !showConfirm" class="absolute right-3 text-[#45464E] dark:text-[#9AA7C2] hover:text-navy dark:hover:text-white" aria-label="Tampilkan atau sembunyikan password"><span class="material-symbols-outlined text-[18px]" x-text="showConfirm ? 'visibility_off' : 'visibility'" aria-hidden="true">visibility</span></button>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button class="flex items-center gap-1.5 px-5 py-2.5 rounded-lg bg-[#F0F3FF] dark:bg-[#060e20] border border-line dark:border-[#263252] hover:bg-[#E7EEFF] dark:hover:bg-[#222A3D] text-[14px] font-medium transition-colors">
                        <span class="material-symbols-outlined text-[18px]" aria-hidden="true">shield</span><span>Ganti Password</span>
                    </button>
                </div>
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