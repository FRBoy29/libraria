<div>
    <h1 class="text-2xl font-bold mb-4">Katalog Buku</h1>
    <div class="flex flex-wrap gap-2 mb-4">
        <input wire:model.live="search" placeholder="Search judul/penulis..." class="border rounded px-3 py-2 w-full md:w-64 bg-white">
        <select wire:model.live="filterCategory" class="border rounded px-3 py-2 bg-white">
            <option value="">Semua kategori</option>
            @foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
        </select>
    </div>
    <div class="grid md:grid-cols-3 gap-3">
        @forelse($books as $b)
            <div class="bg-white p-4 rounded shadow">
                <p class="font-bold">{{ $b->title }}</p>
                <p class="text-sm text-gray-600">{{ $b->author }} • {{ $b->category->name ?? '-' }}</p>
                <p class="text-sm text-gray-500">{{ $b->publisher }} ({{ $b->publication_year }})</p>
                <p class="text-sm mt-1 font-medium {{ $b->stock > 0 ? 'text-green-700' : 'text-red-600' }}">
                    {{ $b->stock > 0 ? 'Tersedia (' . $b->stock . ')' : 'Tidak tersedia' }}
                </p>
                <a href="/member/books/{{ $b->id }}" class="text-sm text-blue-600 underline">Detail</a>
            </div>
        @empty
            <p class="text-gray-500">Tidak ada buku.</p>
        @endforelse
    </div>
    <div class="mt-4">{{ $books->links() }}</div>
</div>
