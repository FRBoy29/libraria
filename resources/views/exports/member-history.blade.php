<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Riwayat Sirkulasi</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #111; }
        h1 { font-size: 18px; margin: 0 0 4px; }
        .meta { margin-bottom: 12px; color: #444; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 5px 6px; text-align: left; }
        th { background: #1F2D4D; color: #fff; }
    </style>
</head>
<body>
    <h1>LIBRARIA — Riwayat Sirkulasi</h1>
    <div class="meta">
        {{ $member->name }} ({{ $member->member_code }}) &bull; {{ $member->email }}<br>
        Dicetak: {{ $date->format('d M Y H:i') }} &bull; {{ count($rows) }} transaksi
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tgl Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Qty</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $i => $d)
                @php($due = $d->borrowing?->due_at)
                @php($ret = $d->returned_at ? \Carbon\Carbon::parse($d->returned_at)->toDateString() : '')
                @php($late = $ret !== '' && $due && $ret > $due)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $d->book->title ?? '-' }}</td>
                    <td>{{ $d->book->author ?? '-' }}</td>
                    <td>{{ $d->borrowing?->borrowed_at }}</td>
                    <td>{{ $due }}</td>
                    <td>{{ $ret !== '' ? $ret : '-' }}</td>
                    <td>{{ $late ? 'Terlambat ' . \Carbon\Carbon::parse($due)->diffInDays($ret) . ' hari' : 'Tepat waktu' }}</td>
                    <td>{{ $d->quantity }}</td>
                </tr>
            @empty
                <tr><td colspan="8">Belum ada riwayat.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
