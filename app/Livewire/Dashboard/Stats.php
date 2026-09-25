<?php

namespace App\Livewire\Dashboard;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Member;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Stats extends Component
{
    public function render()
    {
        $today = now()->toDateString();

        $totalTitles = Book::count();
        $availableStock = (int) Book::sum('stock');
        $borrowedQty = (int) BorrowingDetail::where('status', 'borrowed')->sum('quantity');
        $activeMembers = Member::where('status', 'active')->count();
        $newThisMonth = Book::where('created_at', '>=', now()->startOfMonth())->count();

        $overdues = Borrowing::with(['member', 'details.book'])
            ->where('status', 'borrowed')
            ->where('due_at', '<', $today)
            ->orderBy('due_at')
            ->get()
            ->map(fn ($b) => [
                'borrowing' => $b,
                'lateDays' => Carbon::parse($b->due_at)->diffInDays($today),
            ]);
        $overdueCount = $overdues->count();

        // Grafik 6 hari terakhir: peminjaman vs pengembalian.
        $days = collect(range(5, 0))->map(fn ($i) => now()->subDays($i)->toDateString());
        $borrowPerDay = Borrowing::select(DB::raw('DATE(created_at) d'), DB::raw('COUNT(*) c'))
            ->whereIn(DB::raw('DATE(created_at)'), $days)
            ->groupBy('d')->pluck('c', 'd');
        $returnPerDay = BorrowingDetail::select(DB::raw('DATE(returned_at) d'), DB::raw('COUNT(*) c'))
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

        // Buku terpopuler: total qty dipinjam.
        $popularIds = BorrowingDetail::select('book_id', DB::raw('SUM(quantity) total'))
            ->groupBy('book_id')->orderByDesc('total')->limit(4)->pluck('total', 'book_id');
        $popular = Book::with('category')->whereIn('id', $popularIds->keys())->get()
            ->map(fn ($b) => ['book' => $b, 'times' => (int) $popularIds[$b->id]])
            ->sortByDesc('times')->values();

        // Aktivitas terkini: 8 detail terakhir (pinjam + kembali).
        $recent = BorrowingDetail::with(['book', 'borrowing.member'])
            ->orderByDesc('id')->limit(8)->get();

        $inCirculation = $availableStock + $borrowedQty > 0
            ? round($borrowedQty / ($availableStock + $borrowedQty) * 100)
            : 0;

        return view('livewire.dashboard.stats', compact(
            'totalTitles', 'availableStock', 'borrowedQty', 'activeMembers',
            'newThisMonth', 'overdueCount', 'overdues', 'chart', 'chartMax',
            'popular', 'recent', 'inCirculation'
        ))->layout('layouts.admin', [
            'active' => 'dashboard',
            'overdueCount' => $overdueCount,
            'userName' => auth()->user()->name,
        ]);
    }
}
