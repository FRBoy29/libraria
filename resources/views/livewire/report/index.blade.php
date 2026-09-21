<div>
<h1 class="text-2xl font-bold mb-4">Reports</h1>
<div class="bg-white p-4 rounded shadow mb-4 grid md:grid-cols-5 gap-2">
    <input wire:model.live="from" type="date" class="border rounded px-3 py-2">
    <input wire:model.live="to" type="date" class="border rounded px-3 py-2">
    <select wire:model.live="status" class="border rounded px-3 py-2">
        <option value="">Semua status</option><option value="borrowed">borrowed</option><option value="returned">returned</option>
    </select>
    <select wire:model.live="member_id" class="border rounded px-3 py-2">
        <option value="">Semua member</option>
        @foreach($members as $m)<option value="{{ $m->id }}">{{ $m->name }}</option>@endforeach
    </select>
    <select wire:model.live="category_id" class="border rounded px-3 py-2">
        <option value="">Semua kategori (buku)</option>
        @foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
    </select>
</div>
<div class="grid md:grid-cols-2 gap-4">
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-bold mb-2">Laporan Peminjaman ({{ $borrowings->count() }})</h2>
        <ul class="text-sm space-y-1 max-h-96 overflow-auto">
        @forelse($borrowings as $b)<li class="border-b py-1">#{{ $b->id }} {{ $b->member->name ?? '' }} - {{ $b->borrowed_at }} - {{ $b->status }}</li>
        @empty<li class="text-gray-500">Tidak ada data.</li>@endforelse
        </ul>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-bold mb-2">Laporan Buku ({{ $books->count() }})</h2>
        <ul class="text-sm space-y-1 max-h-96 overflow-auto">
        @forelse($books as $b)<li class="border-b py-1">{{ $b->title }} - {{ $b->category->name ?? '' }} - stok {{ $b->stock }}</li>
        @empty<li class="text-gray-500">Tidak ada data.</li>@endforelse
        </ul>
    </div>
</div>
<div class="bg-white p-4 rounded shadow mt-4">
    <h2 class="font-bold mb-2">Laporan Pengembalian ({{ $returns->count() }})</h2>
    <ul class="text-sm space-y-1 max-h-96 overflow-auto">
    @forelse($returns as $r)<li class="border-b py-1">{{ $r->book->title ?? '' }} - {{ $r->borrowing->member->name ?? '' }} - {{ $r->returned_at }}</li>
    @empty<li class="text-gray-500">Tidak ada data.</li>@endforelse
    </ul>
</div>
</div>

