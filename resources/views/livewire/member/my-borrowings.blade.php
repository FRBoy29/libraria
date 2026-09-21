<div>
    <h1 class="text-2xl font-bold mb-4">Peminjaman Saya</h1>
    <div class="bg-white p-4 rounded shadow overflow-x-auto">
    <table class="w-full text-sm">
        <thead><tr class="border-b text-left"><th class="py-2">Buku</th><th>Pinjam</th><th>Jatuh Tempo</th><th>Status</th></tr></thead>
        <tbody>
        @forelse($borrowings as $b)
            @foreach($b->details->where('status', 'borrowed') as $d)
            <tr class="border-b">
                <td class="py-2">{{ $d->book->title ?? '-' }}</td>
                <td>{{ $b->borrowed_at }}</td>
                <td>{{ $b->due_at }}</td>
                <td>
                    @if($b->due_at < now()->toDateString())
                        <span class="text-red-600 font-medium">Overdue</span>
                    @else
                        <span class="text-green-700 font-medium">Active</span>
                    @endif
                </td>
            </tr>
            @endforeach
        @empty
            <tr><td colspan="4" class="py-4 text-center text-gray-500">Tidak ada peminjaman aktif.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
    <div class="mt-3">{{ $borrowings->links() }}</div>
</div>
