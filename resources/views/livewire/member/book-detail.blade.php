<div>
    <a href="/member/books" class="text-sm text-blue-600 underline">&larr; Kembali ke katalog</a>
    <h1 class="text-2xl font-bold mt-2">{{ $book->title }}</h1>
    <div class="bg-white p-4 rounded shadow mt-3 text-sm space-y-1">
        <p><span class="text-gray-500">ISBN:</span> {{ $book->isbn }}</p>
        <p><span class="text-gray-500">Penulis:</span> {{ $book->author }}</p>
        <p><span class="text-gray-500">Penerbit:</span> {{ $book->publisher ?? '-' }}</p>
        <p><span class="text-gray-500">Tahun:</span> {{ $book->publication_year ?? '-' }}</p>
        <p><span class="text-gray-500">Kategori:</span> {{ $book->category->name ?? '-' }}</p>
        <p><span class="text-gray-500">Deskripsi:</span> {{ $book->description ?? '-' }}</p>
        <p class="font-medium {{ $book->stock > 0 ? 'text-green-700' : 'text-red-600' }}">
            {{ $book->stock > 0 ? 'Tersedia (' . $book->stock . ')' : 'Tidak tersedia' }}
        </p>
    </div>
    <p class="text-sm text-gray-500 mt-3">Untuk meminjam, hubungi petugas di perpustakaan.</p>
</div>
