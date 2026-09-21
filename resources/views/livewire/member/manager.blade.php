<div>
<h1 class="text-2xl font-bold mb-4">Members</h1>
<div class="bg-white p-4 rounded shadow mb-4">
    <form wire:submit="save" class="grid md:grid-cols-3 gap-2">
        <div class="flex gap-2">
            <input wire:model="member_code" placeholder="Member Code *" class="border rounded px-3 py-2 flex-1">
            <button type="button" wire:click="generateCode" class="bg-gray-200 px-3 py-2 rounded text-sm">Generate</button>
        </div>
        <input wire:model="name" placeholder="Name *" class="border rounded px-3 py-2">
        <input wire:model="email" type="email" placeholder="Email *" class="border rounded px-3 py-2">
        <input wire:model="password" type="password" placeholder="{{ $editingId ? 'Password baru (kosongkan jika tidak ganti)' : 'Password awal *' }}" class="border rounded px-3 py-2">
        <input wire:model="phone" placeholder="Phone" class="border rounded px-3 py-2">
        <input wire:model="address" placeholder="Address" class="border rounded px-3 py-2">
        <select wire:model="status" class="border rounded px-3 py-2">
            <option value="active">active</option><option value="inactive">inactive</option>
        </select>
        <input wire:model="active_until" type="date" class="border rounded px-3 py-2" title="Masa aktif">
        <div class="flex gap-2">
            <button class="bg-slate-800 text-white px-4 py-2 rounded">{{ $editingId ? 'Update' : 'Tambah' }}</button>
            @if($editingId)<button type="button" wire:click="cancel" class="bg-gray-300 px-4 py-2 rounded">Batal</button>@endif
        </div>
    </form>
    @foreach(['member_code','name','email','password','status','active_until'] as $f)
        @error($f)<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    @endforeach
</div>
<div class="bg-white p-4 rounded shadow">
    <div class="flex flex-wrap gap-2 mb-3">
        <input wire:model.live="search" placeholder="Search..." class="border rounded px-3 py-2 w-full md:w-64">
        <select wire:model.live="filterStatus" class="border rounded px-3 py-2">
            <option value="">Semua status</option><option value="active">active</option><option value="inactive">inactive</option>
        </select>
    </div>
    <div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead><tr class="border-b text-left"><th class="py-2">Code</th><th>Name</th><th>Email</th><th>Status</th><th>Aktif s/d</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($members as $m)
            <tr class="border-b">
                <td class="py-2">{{ $m->member_code }}</td><td>{{ $m->name }}</td><td>{{ $m->email }}</td><td>{{ $m->status }}</td><td>{{ $m->active_until ?? '-' }}</td>
                <td class="flex gap-2 py-2">
                    <button wire:click="edit({{ $m->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                    @if($confirmingDelete === $m->id)
                        <button wire:click="delete({{ $m->id }})" class="bg-red-600 text-white px-2 py-1 rounded">Yakin?</button>
                    @else
                        <button wire:click="$set('confirmingDelete', {{ $m->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="py-4 text-center text-gray-500">Belum ada anggota.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
    <div class="mt-3">{{ $members->links() }}</div>
</div>
</div>

