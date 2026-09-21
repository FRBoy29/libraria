<div>
    <h1 class="text-2xl font-bold mb-4">Profil</h1>
    <div class="bg-white p-4 rounded shadow mb-4 text-sm grid md:grid-cols-4 gap-2">
        <div><p class="text-gray-500">Member ID</p><p class="font-bold">{{ $member->member_code }}</p></div>
        <div><p class="text-gray-500">Nama</p><p class="font-bold">{{ $member->name }}</p></div>
        <div><p class="text-gray-500">Status</p><p class="font-bold">{{ $member->status }}</p></div>
        <div><p class="text-gray-500">Masa Aktif</p><p class="font-bold">{{ $member->active_until ?? '-' }}</p></div>
    </div>
    <div class="grid md:grid-cols-2 gap-4">
        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-bold mb-2">Data Pribadi</h2>
            <form wire:submit="saveProfile" class="space-y-2">
                <input wire:model="email" type="email" class="w-full border rounded px-3 py-2" placeholder="Email">
                @error('email')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                <input wire:model="phone" class="w-full border rounded px-3 py-2" placeholder="Nomor HP">
                <input wire:model="address" class="w-full border rounded px-3 py-2" placeholder="Alamat">
                <button class="bg-emerald-700 text-white px-4 py-2 rounded">Simpan</button>
            </form>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-bold mb-2">Ganti Password</h2>
            <form wire:submit="changePassword" class="space-y-2">
                <input wire:model="current_password" type="password" class="w-full border rounded px-3 py-2" placeholder="Password saat ini">
                @error('current_password')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                <input wire:model="new_password" type="password" class="w-full border rounded px-3 py-2" placeholder="Password baru">
                @error('new_password')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                <input wire:model="new_password_confirmation" type="password" class="w-full border rounded px-3 py-2" placeholder="Konfirmasi password baru">
                <button class="bg-slate-800 text-white px-4 py-2 rounded">Ganti</button>
            </form>
        </div>
    </div>
</div>
