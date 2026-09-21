<div>
<h1 class="text-2xl font-bold mb-4">Returns</h1>
<div class="bg-white p-4 rounded shadow">
    <div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead><tr class="border-b text-left"><th class="py-2">ID</th><th>Member</th><th>Buku</th><th>Qty</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($actives as $d)
            <tr class="border-b">
                <td class="py-2">{{ $d->id }}</td>
                <td>{{ $d->borrowing->member->name ?? '-' }}</td>
                <td>{{ $d->book->title ?? '-' }}</td>
                <td>{{ $d->quantity }}</td>
                <td><button wire:click="returnDetail({{ $d->id }})" class="bg-green-600 text-white px-3 py-1 rounded">Kembalikan</button></td>
            </tr>
        @empty
            <tr><td colspan="5" class="py-4 text-center text-gray-500">Tidak ada peminjaman aktif.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
    <div class="mt-3">{{ $actives->links() }}</div>
</div>
</div>

