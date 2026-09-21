<div class="w-full max-w-md bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-1">LIBRARIA</h1>
    <p class="text-gray-600 mb-4">Admin Login</p>
    <form wire:submit="login" class="space-y-3">
        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" wire:model="email" class="w-full border rounded px-3 py-2" placeholder="admin@libraria.local">
            @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Password</label>
            <input type="password" wire:model="password" class="w-full border rounded px-3 py-2" placeholder="password">
            @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>
        <button class="w-full bg-slate-800 text-white py-2 rounded hover:bg-slate-700">Masuk</button>
    </form>
</div>
