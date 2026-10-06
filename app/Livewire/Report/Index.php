<?php

namespace App\Livewire\Report;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Category;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Index extends Component
{
    public string $from = '';

    public string $to = '';

    public string $status = '';

    public string $member_id = '';

    public string $category_id = '';

    public string $tab = 'borrowing';

    public function clearFilters(): void
    {
        $this->reset(['from', 'to', 'status', 'member_id', 'category_id']);
    }

    protected function borrowQuery()
    {
        return Borrowing::with(['member', 'details.book'])
            ->when($this->from, fn ($q) => $q->whereDate('borrowed_at', '>=', $this->from))
            ->when($this->to, fn ($q) => $q->whereDate('borrowed_at', '<=', $this->to))
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->when($this->member_id, fn ($q) => $q->where('member_id', $this->member_id))
            ->orderByDesc('id');
    }

    protected function returnQuery()
    {
        return BorrowingDetail::with(['book', 'borrowing.member'])
            ->where('status', 'returned')
            ->when($this->from, fn ($q) => $q->whereDate('returned_at', '>=', $this->from))
            ->when($this->to, fn ($q) => $q->whereDate('returned_at', '<=', $this->to))
            ->when($this->member_id, fn ($q) => $q->whereHas('borrowing', fn ($b) => $b->where('member_id', $this->member_id)))
            ->orderByDesc('returned_at');
    }

    protected function booksQuery()
    {
        return Book::with('category')
            ->when($this->category_id, fn ($q) => $q->where('category_id', $this->category_id))
            ->orderBy('title');
    }

    protected function membersQuery()
    {
        return Member::withCount('borrowings')
            ->when($this->from, fn ($q) => $q->whereHas('borrowings', fn ($b) => $b->whereDate('borrowed_at', '>=', $this->from)))
            ->when($this->to, fn ($q) => $q->whereHas('borrowings', fn ($b) => $b->whereDate('borrowed_at', '<=', $this->to)))
            ->orderByDesc('borrowings_count');
    }

    public function exportExcel()
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->removeSheetByIndex(0);

        $fill = function (string $title, array $headings, iterable $rows, callable $map, string $lastCol) use ($spreadsheet) {
            $sheet = $spreadsheet->createSheet();
            $sheet->setTitle($title);
            $sheet->fromArray([$headings], null, 'A1', true);
            $i = 2;
            foreach ($rows as $row) {
                $sheet->fromArray([$map($row)], null, 'A' . $i, true);
                $i++;
            }
            foreach (range('A', $lastCol) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
        };

        $fill('Peminjaman', ['ID', 'Anggota', 'Member Code', 'Buku', 'Tgl Pinjam', 'Jatuh Tempo', 'Status'],
            $this->borrowQuery()->limit(500)->get(),
            fn ($b) => [
                $b->id, $b->member->name ?? '', $b->member->member_code ?? '',
                $b->details->map(fn ($d) => ($d->book->title ?? '') . ' x' . $d->quantity)->implode('; '),
                (string) $b->borrowed_at, (string) $b->due_at, $b->status,
            ], 'G');

        $fill('Pengembalian', ['Judul', 'Penulis', 'Anggota', 'Qty', 'Tgl Kembali'],
            $this->returnQuery()->limit(500)->get(),
            fn ($d) => [
                $d->book->title ?? '', $d->book->author ?? '',
                $d->borrowing->member->name ?? '', $d->quantity,
                $d->returned_at ? (string) $d->returned_at : '',
            ], 'E');

        $fill('Buku', ['ISBN', 'Judul', 'Penulis', 'Penerbit', 'Tahun', 'Kategori', 'Stok'],
            $this->booksQuery()->limit(500)->get(),
            fn ($b) => [
                $b->isbn, $b->title, $b->author, $b->publisher,
                $b->publication_year, $b->category->name ?? '', $b->stock,
            ], 'G');

        $fill('Anggota', ['Member Code', 'Nama', 'Email', 'Status', 'Total Peminjaman'],
            $this->membersQuery()->limit(500)->get(),
            fn ($m) => [$m->member_code, $m->name, $m->email, $m->status, $m->borrowings_count], 'E');

        $spreadsheet->setActiveSheetIndex(0);

        return response()->streamDownload(function () use ($spreadsheet) {
            (new Xlsx($spreadsheet))->save('php://output');
        }, 'laporan-perpustakaan-' . now()->format('Ymd') . '.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function render()
    {
        $today = now()->toDateString();

        $borrowings = $this->borrowQuery()->limit(100)->get();

        $returns = $this->returnQuery()->limit(100)->get();

        $books = $this->booksQuery()->limit(100)->get();

        $members = $this->membersQuery()->limit(100)->get();

        $summary = [
            'borrowing' => $this->borrowQuery()->count(),
            'returned' => $this->returnQuery()->count(),
            'members' => $this->membersQuery()->count(),
            'titles' => $this->booksQuery()->count(),
            'overdue' => Borrowing::where('status', 'borrowed')->whereDate('due_at', '<', $today)->count(),
        ];

        // 7 hari terakhir untuk sparkline
        $days = collect(range(6, 0))->map(fn ($i) => now()->subDays($i)->toDateString());
        $perDay = Borrowing::select(DB::raw('DATE(borrowed_at) d'), DB::raw('COUNT(*) c'))
            ->whereIn(DB::raw('DATE(borrowed_at)'), $days)->groupBy('d')->pluck('c', 'd');
        $trend = $days->map(fn ($d) => (int) ($perDay[$d] ?? 0));
        $trendMax = max(1, $trend->max());

        return view('livewire.report.index', [
            'borrowings' => $borrowings,
            'returns' => $returns,
            'books' => $books,
            'members' => $members,
            'summary' => $summary,
            'trend' => $trend,
            'trendMax' => $trendMax,
            'categories' => Category::orderBy('name')->get(),
            'memberOptions' => Member::orderBy('name')->get(),
        ])->layout('layouts.admin', [
            'active' => 'reports',
            'overdueCount' => Borrowing::where('status', 'borrowed')->whereDate('due_at', '<', $today)->count(),
        ]);
    }
}