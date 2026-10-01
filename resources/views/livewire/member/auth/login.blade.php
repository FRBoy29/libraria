<div class="min-h-screen flex items-center justify-center p-4 bg-[#F8FAFC] dark:bg-[#0b1326]">
    <div class="w-full max-w-md bg-white dark:bg-[#171f33] border border-[#E2E8F0] dark:border-transparent text-[#111C2D] dark:text-[#dae2fd] p-6 rounded-xl shadow-xl">
        <div class="flex items-center justify-between mb-1">
            <h1 class="text-2xl font-semibold font-[Poppins,sans-serif]">LIBRARIA</h1>
            <button type="button" onclick="toggleAuthTheme()" class="auth-theme-toggle flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#F0F3FF] dark:bg-[#131b2e] text-[#45464E] dark:text-[#c2c6d5] text-[11px]" title="Beralih Tema Gelap / Terang">
                <span class="material-symbols-outlined text-[0.875rem]" data-theme-icon aria-hidden="true">dark_mode</span><span data-theme-label>Mode Gelap</span>
            </button>
        </div>
        <p class="text-[#45464E] dark:text-[#c2c6d5] mb-4">Member Login</p>
        <form wire:submit="login" class="space-y-3">
            <div>
                <label class="block text-sm font-medium">Member ID</label>
                <input type="text" wire:model="member_code" class="w-full border border-[#E2E8F0] dark:border-transparent bg-white dark:bg-[#131b2e] rounded-lg px-3 py-2" placeholder="LIB-000123">
                @error('member_code') <p class="text-[#BA1A1A] dark:text-[#ffb4ab] text-sm">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Password</label>
                <input type="password" wire:model="password" class="w-full border border-[#E2E8F0] dark:border-transparent bg-white dark:bg-[#131b2e] rounded-lg px-3 py-2" placeholder="********">
                @error('password') <p class="text-[#BA1A1A] dark:text-[#ffb4ab] text-sm">{{ $message }}</p> @enderror
            </div>
            <button class="w-full bg-emerald-700 text-white py-2 rounded-lg hover:bg-emerald-600 font-semibold">Masuk</button>
        </form>
        <p class="text-xs text-[#45464E] dark:text-[#c2c6d5] mt-3">Akun dibuat oleh petugas. Hubungi admin jika belum punya Member ID.</p>
        <a class="text-[11px] text-[#005BBF] dark:text-[#acc7ff] hover:underline flex items-center gap-1 mt-2" href="/admin/login">
            <span>Masuk Portal Admin</span><span class="material-symbols-outlined text-[0.875rem]" aria-hidden="true">open_in_new</span>
        </a>
    </div>
</div>
