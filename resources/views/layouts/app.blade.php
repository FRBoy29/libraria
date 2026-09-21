<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBRARIA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <livewire:styles />
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-slate-800 text-white px-4 py-3 flex flex-wrap gap-2 items-center">
        <a href="/admin/dashboard" class="font-bold text-lg mr-4">LIBRARIA</a>
        <a href="/admin/dashboard" class="px-2 py-1 hover:bg-slate-700 rounded">Dashboard</a>
        <a href="/admin/categories" class="px-2 py-1 hover:bg-slate-700 rounded">Categories</a>
        <a href="/admin/books" class="px-2 py-1 hover:bg-slate-700 rounded">Books</a>
        <a href="/admin/members" class="px-2 py-1 hover:bg-slate-700 rounded">Members</a>
        <a href="/admin/borrowings" class="px-2 py-1 hover:bg-slate-700 rounded">Borrowings</a>
        <a href="/admin/returns" class="px-2 py-1 hover:bg-slate-700 rounded">Returns</a>
        <a href="/admin/reports" class="px-2 py-1 hover:bg-slate-700 rounded">Reports</a>
        <form method="POST" action="/logout" class="ml-auto">
            @csrf
            <button class="px-3 py-1 bg-red-600 rounded hover:bg-red-700">Logout ({{ auth()->user()->name ?? '' }})</button>
        </form>
    </nav>
    <main class="p-4 max-w-6xl mx-auto">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
        @endif
        {{ $slot }}
    </main>
    <livewire:scripts />
</body>
</html>
