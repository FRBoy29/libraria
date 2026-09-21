<div>
    <h1 class="text-2xl font-bold mb-4">Halo, {{ $member->name }}</h1>
    <div class="bg-white p-4 rounded shadow mb-4 grid md:grid-cols-4 gap-2 text-sm">
        <div><p class="text-gray-500">Member ID</p><p class="font-bold">{{ $member->member_code }}</p></div>
        <div><p class="text-gray-500">Status</p><p class="font-bold">{{ $member->status }}</p></div>
        <div><p class="text-gray-500">Masa Aktif</p><p class="font-bold">{{ $member->active_until ?? '-' }}</p></div>
        <div><p class="text-gray-500">Email</p><p class="font-bold">{{ $member->email }}</p></div>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
        <div class="bg-white p-4 rounded shadow"><p class="text-sm text-gray-500">Buku Sedang Dipinjam</p><p class="text-2xl font-bold">{{ $activeCount }}</p></div>
        <div class="bg-white p-4 rounded shadow"><p class="text-sm text-gray-500">Buku Terlambat</p><p class="text-2xl font-bold text-red-600">{{ $overdueCount }}</p></div>
        <div class="bg-white p-4 rounded shadow"><p class="text-sm text-gray-500">Total Riwayat</p><p class="text-2xl font-bold">{{ $historyCount }}</p></div>
    </div>
    <p class="text-sm text-gray-500 mt-4">Peminjaman dan pengembalian hanya diproses oleh petugas di perpustakaan.</p>
</div>
