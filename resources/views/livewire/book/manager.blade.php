<div>
<h1 class="text-2xl font-bold mb-4">Books</h1>
<div class="bg-white p-4 rounded shadow mb-4">
    <form wire:submit="save" class="grid md:grid-cols-3 gap-2">
        <input wire:model="isbn" placeholder="ISBN *" class="border rounded px-3 py-2">
        <input wire:model="title" placeholder="Judul *" class="border rounded px-3 py-2">
        <input wire:model="author" placeholder="Penulis *" class="border rounded px-3 py-2">
        <input wire:model="publisher" placeholder="Penerbit" class="border rounded px-3 py-2">
        <input wire:model="publication_year" type="number" placeholder="Tahun" class="border rounded px-3 py-2">
        <select wire:model="category_id" class="border rounded px-3 py-2">
            <option value="">-- Kategori * --</option>
            @foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
        </select>
        <input wire:model="stock" type="number" min="0" placeholder="Stok" class="border rounded px-3 py-2">
        <input wire:model="description" placeholder="Deskripsi" class="border rounded px-3 py-2 md:col-span-2">
        <div class="flex gap-2">
            <button class="bg-slate-800 text-white px-4 py-2 rounded">{{ $editingId ? 'Update' : 'Tambah' }}</button>
            @if($editingId)<button type="button" wire:click="cancel" class="bg-gray-300 px-4 py-2 rounded">Batal</button>@endif
        </div>
    </form>
    @foreach(['isbn','title','author','category_id','stock','publication_year'] as $f)
        @error($f)<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    @endforeach
    <div class="flex gap-2 mt-3">
        <a href="/admin/books/create" class="text-sm text-blue-600 underline">/admin/books/create (same form)</a>
    </div>
</div>
<div class="bg-white p-4 rounded shadow">
    <div class="flex flex-wrap gap-2 mb-3">
        <input wire:model.live="search" placeholder="Search judul/penulis/ISBN..." class="border rounded px-3 py-2 w-full md:w-64">
        <select wire:model.live="filterCategory" class="border rounded px-3 py-2">
            <option value="">Semua kategori</option>
            @foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
        </select>
    </div>
    <div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead><tr class="border-b text-left"><th class="py-2">ISBN</th><th>Judul</th><th>Penulis</th><th>Kategori</th><th>Stok</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($books as $b)
            <tr class="border-b">
                <td class="py-2">{{ $b->isbn }}</td><td>{{ $b->title }}</td><td>{{ $b->author }}</td>
                <td>{{ $b->category->name ?? '-' }}</td><td>{{ $b->stock }}</td>
                <td class="flex gap-2 py-2">
                    <a href="/admin/books/{{ $b->id }}/edit" wire:navigate class="bg-blue-500 text-white px-2 py-1 rounded">Edit page</a>
                    <button wire:click="edit({{ $b->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Quick edit</button>
                    @if($confirmingDelete === $b->id)
                        <button wire:click="delete({{ $b->id }})" class="bg-red-600 text-white px-2 py-1 rounded">Yakin?</button>
                    @else
                        <button wire:click="$set('confirmingDelete', {{ $b->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="py-4 text-center text-gray-500">Belum ada buku.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
    <div class="mt-3">{{ $books->links() }}</div>
</div>
</div>

