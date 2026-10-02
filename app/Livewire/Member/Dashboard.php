<?php

namespace App\Livewire\Member;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $member = Auth::guard('member')->user();
        $today = now()->toDateString();

        $borrowings = Borrowing::where('member_id', $member->id)->orderByDesc('id')->get();
        $borrowingIds = $borrowings->pluck('id');

        $activeBorrowings = $borrowings->where('status', 'borrowed');
        $activeDetails = BorrowingDetail::with('book')
            ->whereIn('borrowing_id', $borrowingIds)
            ->where('status', 'borrowed')
            ->orderBy('id', 'desc')
            ->get();

        $overdue = $activeBorrowings->filter(fn ($b) => $b->due_at < $today)
            ->map(function ($b) {
                return [
                    'borrowing' => $b,
                    'lateDays' => Carbon::parse($b->due_at)->diffInDays($today),
                    'books' => $b->details()->with('book')->get(),
                ];
            })->values();

        // Grafik 6 hari terakhir: peminjaman vs pengembalian (milik member ini).
        $days = collect(range(5, 0))->map(fn ($i) => now()->subDays($i)->toDateString());
        $borrowPerDay = Borrowing::select(DB::raw('DATE(borrowed_at) d'), DB::raw('COUNT(*) c'))
            ->where('member_id', $member->id)
            ->whereIn(DB::raw('DATE(borrowed_at)'), $days)
            ->groupBy('d')->pluck('c', 'd');
        $returnPerDay = BorrowingDetail::select(DB::raw('DATE(returned_at) d'), DB::raw('COUNT(*) c'))
            ->whereIn('borrowing_id', $borrowingIds)
            ->where('status', 'returned')
            ->whereIn(DB::raw('DATE(returned_at)'), $days)
            ->groupBy('d')->pluck('c', 'd');
        $weekdayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        $chart = $days->map(fn ($d) => [
            'label' => $weekdayNames[Carbon::parse($d)->dayOfWeek],
            'borrow' => (int) ($borrowPerDay[$d] ?? 0),
            'return' => (int) ($returnPerDay[$d] ?? 0),
        ]);
        $chartMax = max(1, $chart->max('borrow'), $chart->max('return'));

        // Buku yang pernah dipinjam, urut frekuensi.
        $bookIds = BorrowingDetail::select('book_id', DB::raw('SUM(quantity) total'))
            ->whereIn('borrowing_id', $borrowingIds)
            ->groupBy('book_id')->orderByDesc('total')->limit(4)->pluck('total', 'book_id');
        $frequent = Book::with('category')->whereIn('id', $bookIds->keys())->get()
            ->map(fn ($b) => ['book' => $b, 'times' => (int) $bookIds[$b->id]])
            ->sortByDesc('times')->values();

        // Aktivitas terkini: 8 detail terakhir.
        $recent = BorrowingDetail::with(['book', 'borrowing'])
            ->whereIn('borrowing_id', $borrowingIds)
            ->orderByDesc('id')->limit(8)->get();

        $totalStock = (int) Book::sum('stock');
        $borrowedQty = (int) BorrowingDetail::where('status', 'borrowed')->sum('quantity');
        $inCirculation = $totalStock + $borrowedQty > 0
            ? round($borrowedQty / ($totalStock + $borrowedQty) * 100)
            : 0;

        return view('livewire.member.dashboard', [
            'member' => $member,
            'firstName' => strtok($member->name, ' '),
            'totalTitles' => Book::count(),
            'totalStock' => $totalStock,
            'inCirculation' => $inCirculation,
            'activeCount' => $activeBorrowings->count(),
            'activeQty' => (int) $activeDetails->sum('quantity'),
            'overdueCount' => $overdue->count(),
            'overdueList' => $overdue,
            'historyCount' => (int) BorrowingDetail::whereIn('borrowing_id', $borrowingIds)->where('status', 'returned')->sum('quantity'),
            'chart' => $chart,
            'chartMax' => $chartMax,
            'frequent' => $frequent,
            'recent' => $recent,
        ])->layout('layouts.member', ['nav' => 'dashboard', 'overdueCount' => $overdue->count()]);
    }
}