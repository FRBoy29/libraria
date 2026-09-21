<div>
<h1 class="text-2xl font-bold mb-4">Borrowings</h1>
<div class="bg-white p-4 rounded shadow mb-4">
    <h2 class="font-bold mb-2">Buat Peminjaman</h2>
    <form wire:submit="save" class="grid md:grid-cols-3 gap-2">
        <select wire:model="member_id" class="border rounded px-3 py-2">
            <option value="">-- Pilih Member * --</option>
            @foreach($members as $m)<option value="{{ $m->id }}">{{ $m->member_code }} - {{ $m->name }}</option>@endforeach
        </select>
        <select wire:model="book_id" class="border rounded px-3 py-2">
            <option value="">-- Pilih Buku (stok > 0) * --</option>
            @foreach($books as $b)<option value="{{ $b->id }}">{{ $b->title }} ({{ $b->stock }})</option>@endforeach
        </select>
        <input wire:model="quantity" type="number" min="1" class="border rounded px-3 py-2" placeholder="Qty">
        <input wire:model="borrowed_at" type="date" class="border rounded px-3 py-2">
        <input wire:model="due_at" type="date" class="border rounded px-3 py-2">
        <div><button class="bg-slate-800 text-white px-4 py-2 rounded">Simpan</button></div>
    </form>
    @foreach(['member_id','book_id','quantity','borrowed_at','due_at'] as $f)
        @error($f)<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    @endforeach
</div>
<div class="bg-white p-4 rounded shadow">
    <div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead><tr class="border-b text-left"><th class="py-2">ID</th><th>Member</th><th>Buku</th><th>Pinjam</th><th>Jatuh tempo</th><th>Status</th></tr></thead>
        <tbody>
        @forelse($borrowings as $b)
            <tr class="border-b">
                <td class="py-2">{{ $b->id }}</td><td>{{ $b->member->name ?? '-' }}</td>
                <td>@foreach($b->details as $d){{ $d->book->title ?? '' }} ({{ $d->quantity }})<br>@endforeach</td>
                <td>{{ $b->borrowed_at }}</td><td>{{ $b->due_at }}</td><td>{{ $b->status }}</td>
            </tr>
        @empty
            <tr><td colspan="6" class="py-4 text-center text-gray-500">Belum ada peminjaman.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
    <div class="mt-3">{{ $borrowings->links() }}</div>
</div>
</div>

