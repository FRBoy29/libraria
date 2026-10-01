<?php

namespace App\Livewire\Report;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Category;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

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

    public function render()
    {
        $today = now()->toDateString();

        $borrowQuery = Borrowing::with(['member', 'details.book'])
            ->when($this->from, fn ($q) => $q->whereDate('borrowed_at', '>=', $this->from))
            ->when($this->to, fn ($q) => $q->whereDate('borrowed_at', '<=', $this->to))
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->when($this->member_id, fn ($q) => $q->where('member_id', $this->member_id))
            ->orderByDesc('id');

        $borrowings = $borrowQuery->limit(100)->get();

        $returnQuery = BorrowingDetail::with(['book', 'borrowing.member'])
            ->where('status', 'returned')
            ->when($this->from, fn ($q) => $q->whereDate('returned_at', '>=', $this->from))
            ->when($this->to, fn ($q) => $q->whereDate('returned_at', '<=', $this->to))
            ->when($this->member_id, fn ($q) => $q->whereHas('borrowing', fn ($b) => $b->where('member_id', $this->member_id)))
            ->orderByDesc('returned_at');

        $returns = $returnQuery->limit(100)->get();

        $booksQuery = Book::with('category')
            ->when($this->category_id, fn ($q) => $q->where('category_id', $this->category_id))
            ->orderBy('title');

        $books = $booksQuery->limit(100)->get();

        $members = Member::withCount('borrowings')
            ->when($this->from, fn ($q) => $q->whereHas('borrowings', fn ($b) => $b->whereDate('borrowed_at', '>=', $this->from)))
            ->when($this->to, fn ($q) => $q->whereHas('borrowings', fn ($b) => $b->whereDate('borrowed_at', '<=', $this->to)))
            ->orderByDesc('borrowings_count')->limit(100)->get();

        $summary = [
            'borrowing' => (clone $borrowQuery)->count(),
            'returned' => (clone $returnQuery)->count(),
            'members' => $members->count(),
            'titles' => (clone $booksQuery)->count(),
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