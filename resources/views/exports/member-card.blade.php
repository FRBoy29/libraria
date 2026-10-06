<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kartu Anggota</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #111; }
        .card { border: 2px solid #1F2D4D; border-radius: 12px; padding: 28px; max-width: 520px; }
        .brand { font-size: 22px; font-weight: bold; color: #1F2D4D; letter-spacing: 2px; }
        .sub { font-size: 10px; letter-spacing: 3px; color: #888; }
        .name { font-size: 20px; font-weight: bold; margin-top: 18px; }
        .code { font-size: 14px; color: #005BBF; font-weight: bold; margin-top: 4px; }
        .row { margin-top: 14px; font-size: 12px; color: #444; }
        .row strong { color: #111; }
        .foot { margin-top: 22px; font-size: 10px; color: #888; }
    </style>
</head>
<body>
    <div class="card">
        <div class="brand">LIBRARIA</div>
        <div class="sub">KARTU ANGGOTA</div>
        <div class="name">{{ $member->name }}</div>
        <div class="code">{{ $member->member_code }}</div>
        <div class="row">{{ $member->email }}</div>
        <div class="row"><strong>Status:</strong> {{ ucfirst($member->status) }} &nbsp; <strong>Masa aktif:</strong> {{ $member->active_until ? \Carbon\Carbon::parse($member->active_until)->format('d M Y') : '-' }}</div>
        <div class="foot">Dicetak: {{ $date->format('d M Y H:i') }} &bull; Tunjukkan kartu ini kepada petugas perpustakaan.</div>
    </div>
</body>
</html>
