<div>
<h1 class="text-2xl font-bold mb-4">Dashboard</h1>
<div class="grid grid-cols-2 md:grid-cols-3 gap-3">
    <div class="bg-white p-4 rounded shadow"><p class="text-sm text-gray-500">Total Books (stock)</p><p class="text-2xl font-bold">{{ $totalBooks }}</p></div>
    <div class="bg-white p-4 rounded shadow"><p class="text-sm text-gray-500">Total Titles</p><p class="text-2xl font-bold">{{ $totalTitles }}</p></div>
    <div class="bg-white p-4 rounded shadow"><p class="text-sm text-gray-500">Total Members</p><p class="text-2xl font-bold">{{ $totalMembers }}</p></div>
    <div class="bg-white p-4 rounded shadow"><p class="text-sm text-gray-500">Active Borrowings</p><p class="text-2xl font-bold">{{ $activeBorrowings }}</p></div>
    <div class="bg-white p-4 rounded shadow"><p class="text-sm text-gray-500">Overdue Borrowings</p><p class="text-2xl font-bold text-red-600">{{ $overdueBorrowings }}</p></div>
    <div class="bg-white p-4 rounded shadow"><p class="text-sm text-gray-500">Returned Books</p><p class="text-2xl font-bold">{{ $returnedBooks }}</p></div>
</div>
</div>

