<div class="w-full max-w-md bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-1">LIBRARIA</h1>
    <p class="text-gray-600 mb-4">Member Login</p>
    <form wire:submit="login" class="space-y-3">
        <div>
            <label class="block text-sm font-medium">Member ID</label>
            <input type="text" wire:model="member_code" class="w-full border rounded px-3 py-2" placeholder="LIB-000123">
            @error('member_code') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Password</label>
            <input type="password" wire:model="password" class="w-full border rounded px-3 py-2" placeholder="********">
            @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>
        <button class="w-full bg-emerald-700 text-white py-2 rounded hover:bg-emerald-600">Masuk</button>
    </form>
    <p class="text-xs text-gray-500 mt-3">Akun dibuat oleh petugas. Hubungi admin jika belum punya Member ID.</p>
</div>
