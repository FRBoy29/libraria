<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBRARIA — Sistem Informasi Perpustakaan</title>
    <meta name="description" content="LIBRARIA adalah sistem informasi perpustakaan untuk mengelola koleksi, anggota, dan sirkulasi perpustakaan.">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/logo/libraria-mark.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <script>
        // Set theme before paint to avoid flash. Full logic lives in /js/landing.js.
        try {
            var t = localStorage.getItem('libraria-theme');
            document.documentElement.setAttribute('data-theme', t === 'dark' || t === 'light' ? t : 'light');
        } catch (e) {
            document.documentElement.setAttribute('data-theme', 'light');
        }
    </script>
</head>
<body>
    @yield('content')
    <script src="{{ asset('js/landing.js') }}" defer></script>
</body>
</html>
