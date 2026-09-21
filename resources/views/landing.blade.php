<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBRARIA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-lg bg-white p-6 rounded shadow text-center">
        <h1 class="text-3xl font-bold mb-1">LIBRARIA</h1>
        <p class="text-gray-600 mb-6">Digital Library Management System</p>
        <div class="grid md:grid-cols-2 gap-3">
            <a href="/admin/login" class="block bg-slate-800 text-white p-4 rounded hover:bg-slate-700">
                <p class="font-bold">Admin / Petugas</p>
                <p class="text-sm opacity-80">Email + Password</p>
            </a>
            <a href="/member/login" class="block bg-emerald-700 text-white p-4 rounded hover:bg-emerald-600">
                <p class="font-bold">Member</p>
                <p class="text-sm opacity-80">Member ID + Password</p>
            </a>
        </div>
    </div>
</body>
</html>
