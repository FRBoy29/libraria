<div class="min-h-screen flex flex-col justify-between bg-[#F8FAFC] dark:bg-[#0b1326] text-[#111C2D] dark:text-[#dae2fd]">
    <header class="w-full bg-white/80 dark:bg-[#0b1326]/80 backdrop-blur-xl z-30 border-b border-[#E2E8F0] dark:border-transparent">
        <div class="w-full max-w-7xl mx-auto px-4 md:px-8 flex items-center justify-between h-16">
            <div class="flex items-center gap-2.5">
                <img src="{{ asset('assets/logo/libraria-mark.svg') }}" alt="Logo LIBRARIA" class="w-8 h-8 rounded-lg">
                <div class="flex flex-col">
                    <span class="tracking-tight leading-none font-semibold text-[1.25rem] font-[Poppins,sans-serif]">Libraria</span>
                    <span class="text-[11px] text-emerald-700 dark:text-emerald-300 tracking-widest uppercase mt-0.5">Member Portal</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <a class="inline-flex items-center gap-1.5 text-[#45464E] dark:text-[#c2c6d5] hover:text-[#111C2D] dark:hover:text-white text-[12px] font-medium" href="/">
                    <span class="material-symbols-outlined text-[1rem]" aria-hidden="true">arrow_back</span><span>Portal Publik</span>
                </a>
                <div class="h-4 w-px bg-[#E2E8F0] dark:bg-[#2d3449]"></div>
                <button type="button" onclick="toggleAuthTheme()" class="auth-theme-toggle flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#F0F3FF] dark:bg-[#131b2e] hover:bg-[#E7EEFF] dark:hover:bg-[#222a3d] text-[#45464E] dark:text-[#c2c6d5] text-[11px] transition-colors" title="Beralih Tema Gelap / Terang">
                    <span class="material-symbols-outlined text-[0.875rem] text-emerald-700 dark:text-emerald-300" data-theme-icon aria-hidden="true">dark_mode</span><span data-theme-label>Mode Gelap</span>
                </button>
            </div>
        </div>
    </header>

    <main class="flex-1 w-full max-w-7xl mx-auto px-4 md:px-8 flex flex-col items-center justify-center py-10">
        <div class="flex flex-col w-full items-center justify-center relative">
            <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-[34rem] max-w-full h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>
            <div class="absolute -bottom-16 left-1/2 -translate-x-1/2 w-80 h-48 bg-[#E3B76F]/10 rounded-full blur-3xl pointer-events-none" aria-hidden="true"></div>

            <div class="w-full max-w-[32rem] mx-auto flex flex-col">
                <div class="flex flex-col items-center text-center mb-6">
                    <div class="relative flex items-center justify-center mb-2">
                        <div class="absolute inset-0 bg-emerald-500/20 rounded-2xl blur-md scale-95" aria-hidden="true"></div>
                        <div class="relative w-16 h-16 rounded-2xl bg-white dark:bg-[#222a3d] flex items-center justify-center p-2.5 shadow-xl border border-[#E2E8F0] dark:border-transparent">
                            <img src="{{ asset('assets/logo/libraria-mark.svg') }}" alt="Logo LIBRARIA" class="w-full h-full object-contain">
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-[2rem] font-semibold tracking-tight leading-none font-[Poppins,sans-serif]">Libraria</span>
                    </div>
                    <p class="text-[12px] font-medium text-[#8A5A1D] dark:text-[#e3c290] tracking-widest uppercase mt-1">More Than Books. A Brighter Tomorrow.</p>
                </div>

                <div class="w-full bg-white dark:bg-[#171f33] rounded-xl shadow-xl overflow-hidden border border-[#E2E8F0] dark:border-transparent">
                    <div class="px-6 pt-6 pb-4 bg-[#F0F3FF] dark:bg-[#222a3d]/40">
                        <span class="text-[1.25rem] font-semibold tracking-tight font-[Poppins,sans-serif]">Portal Masuk Member</span>
                    </div>
                    <div class="p-6 flex flex-col gap-4" x-data="{ show: false }">
                        <form wire:submit="login" class="flex flex-col gap-4">
                            <div class="flex flex-col gap-1.5">
                                <div class="flex items-center justify-between">
                                    <label class="text-[12px] font-medium" for="memberCode">Member ID</label>
                                    <span class="text-[11px] text-[#75777F] dark:text-[#8c909e]">Wajib</span>
                                </div>
                                <div class="relative flex items-center">
                                    <span class="material-symbols-outlined absolute left-3.5 text-[#75777F] dark:text-[#8c909e] text-[1.25rem] pointer-events-none" aria-hidden="true">badge</span>
                                    <input wire:model="member_code" type="text" autocomplete="username" id="memberCode" placeholder="LIB-000001" class="w-full pl-11 pr-4 py-2.5 bg-[#F0F3FF] dark:bg-[#131b2e] rounded-lg placeholder:text-[#8c909e] text-[14px] focus:outline-none focus:ring-2 focus:ring-emerald-500/40">
                                </div>
                                @error('member_code')<p class="text-[12px] text-[#BA1A1A] dark:text-[#ffb4ab]">{{ $message }}</p>@enderror
                                <span class="text-[11px] text-[#45464E] dark:text-[#c2c6d5] flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[0.875rem] text-[#8A5A1D] dark:text-[#e3c290]" aria-hidden="true">info</span>
                                    Gunakan Member ID yang diberikan petugas perpustakaan.
                                </span>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[12px] font-medium" for="memberPassword">Kata Sandi</label>
                                <div class="relative flex items-center">
                                    <span class="material-symbols-outlined absolute left-3.5 text-[#75777F] dark:text-[#8c909e] text-[1.25rem] pointer-events-none" aria-hidden="true">lock</span>
                                    <input wire:model="password" :type="show ? 'text' : 'password'" autocomplete="current-password" id="memberPassword" placeholder="••••••••" class="w-full pl-11 pr-11 py-2.5 bg-[#F0F3FF] dark:bg-[#131b2e] rounded-lg placeholder:text-[#8c909e] text-[14px] focus:outline-none focus:ring-2 focus:ring-emerald-500/40">
                                    <button type="button" @click="show = !show" class="absolute right-3 text-[#75777F] dark:text-[#8c909e] hover:text-current transition-colors" title="Tampilkan / Sembunyikan Sandi" aria-label="Tampilkan atau sembunyikan kata sandi">
                                        <span class="material-symbols-outlined text-[1.25rem]" x-text="show ? 'visibility_off' : 'visibility'" aria-hidden="true">visibility</span>
                                    </button>
                                </div>
                                @error('password')<p class="text-[12px] text-[#BA1A1A] dark:text-[#ffb4ab]">{{ $message }}</p>@enderror
                            </div>
                            <button wire:loading.attr="disabled" class="w-full py-3 px-4 rounded-lg bg-emerald-700 text-white text-[14px] font-semibold hover:brightness-110 active:scale-[0.99] transition-all flex items-center justify-center gap-1.5" type="submit">
                                <span wire:loading.remove class="flex items-center gap-1.5">Masuk ke Dashboard Member <span class="material-symbols-outlined text-[1.25rem]" aria-hidden="true">arrow_forward</span></span>
                                <span wire:loading class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[1.25rem] animate-spin" aria-hidden="true">refresh</span>Memverifikasi…</span>
                            </button>
                        </form>
                        <p class="text-[12px] text-[#45464E] dark:text-[#c2c6d5] bg-[#F0F3FF] dark:bg-[#131b2e] rounded-lg px-3 py-2">Demo lokal — Member ID: <strong>M001</strong> • Password: <strong>password</strong></p>
                    </div>
                    <div class="px-6 py-4 bg-[#F8FAFC] dark:bg-[#060e20]/80 flex flex-col sm:flex-row items-center justify-between gap-1.5 text-center sm:text-left">
                        <span class="text-[11px] text-[#45464E] dark:text-[#c2c6d5] flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[1rem] text-[#8A5A1D] dark:text-[#e3c290]" aria-hidden="true">schedule</span>
                            <span>Jam Operasional: <strong>08:00 – 17:00 WIB</strong></span>
                        </span>
                        <a class="text-[11px] text-[#005BBF] dark:text-[#acc7ff] hover:underline flex items-center gap-1" href="/admin/login">
                            <span>Masuk Portal Admin</span><span class="material-symbols-outlined text-[0.875rem]" aria-hidden="true">open_in_new</span>
                        </a>
                    </div>
                </div>

                <p class="mt-4 text-[11px] text-[#45464E] dark:text-[#c2c6d5] text-center">
                    Peminjaman dan pengembalian buku diproses oleh petugas perpustakaan.
                </p>
            </div>
        </div>
    </main>

    <footer class="w-full bg-white dark:bg-[#060e20] border-t border-[#E2E8F0] dark:border-transparent">
        <div class="w-full max-w-7xl mx-auto px-4 md:px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-[#45464E] dark:text-[#c2c6d5]">
            <span class="flex items-center gap-1.5 text-[11px]"><span class="material-symbols-outlined text-[1rem] text-emerald-700 dark:text-emerald-300" aria-hidden="true">verified_user</span><span>Sistem Informasi Perpustakaan</span></span>
            <span class="text-[11px]">© 2026 LIBRARIA. Hak Cipta Dilindungi.</span>
        </div>
    </footer>
</div>