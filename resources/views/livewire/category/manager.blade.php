<div>
<h1 class="text-2xl font-bold mb-4">Categories</h1>
<div class="bg-white p-4 rounded shadow mb-4">
    <form wire:submit="save" class="grid md:grid-cols-3 gap-2">
        <input wire:model="name" placeholder="Nama kategori" class="border rounded px-3 py-2">
        <input wire:model="description" placeholder="Deskripsi" class="border rounded px-3 py-2">
        <div class="flex gap-2">
            <button class="bg-slate-800 text-white px-4 py-2 rounded">{{ $editingId ? 'Update' : 'Tambah' }}</button>
            @if($editingId)<button type="button" wire:click="cancel" class="bg-gray-300 px-4 py-2 rounded">Batal</button>@endif
        </div>
    </form>
    @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
</div>
<div class="bg-white p-4 rounded shadow">
    <input wire:model.live="search" placeholder="Search..." class="border rounded px-3 py-2 mb-3 w-full md:w-64">
    <div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead><tr class="border-b text-left"><th class="py-2">ID</th><th>Name</th><th>Description</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($categories as $c)
            <tr class="border-b">
                <td class="py-2">{{ $c->id }}</td><td>{{ $c->name }}</td><td>{{ $c->description }}</td>
                <td class="flex gap-2 py-2">
                    <button wire:click="edit({{ $c->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                    @if($confirmingDelete === $c->id)
                        <button wire:click="delete({{ $c->id }})" class="bg-red-600 text-white px-2 py-1 rounded">Yakin?</button>
                        <button wire:click="cancel" class="bg-gray-300 px-2 py-1 rounded">Batal</button>
                    @else
                        <button wire:click="$set('confirmingDelete', {{ $c->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="py-4 text-center text-gray-500">Belum ada kategori.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
    <div class="mt-3">{{ $categories->links() }}</div>
</div>
</div>

