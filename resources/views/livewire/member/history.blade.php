<div>
    <h1 class="text-2xl font-bold mb-4">Riwayat Peminjaman</h1>
    <div class="bg-white p-4 rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead><tr class="border-b text-left"><th class="py-2">Buku</th><th>Pinjam</th><th>Jatuh Tempo</th><th>Kembali</th><th>Status</th></tr></thead>
        <tbody>
        @forelse($items as $d)
            <tr class="border-b">
                <td class="py-2">{{ $d->book->title ?? '-' }}</td>
                <td>{{ $d->borrowing->borrowed_at ?? '-' }}</td>
                <td>{{ $d->borrowing->due_at ?? '-' }}</td>
                <td>{{ $d->returned_at ?? '-' }}</td>
                <td>Returned</td>
            </tr>
        @empty
            <tr><td colspan="5" class="py-4 text-center text-gray-500">Belum ada riwayat.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
    <div class="mt-3">{{ $items->links() }}</div>
</div>
