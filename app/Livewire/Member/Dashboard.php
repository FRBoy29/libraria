<?php

namespace App\Livewire\Member;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use Illuminate\Support\Facades\Auth;
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
            ->get();

        $overdue = $activeBorrowings->filter(fn ($b) => $b->due_at < $today);
        $returnedDetails = BorrowingDetail::with('book')
            ->whereIn('borrowing_id', $borrowingIds)
            ->where('status', 'returned')
            ->orderByDesc('returned_at')
            ->limit(5)
            ->get();

        $dueSoon = $activeBorrowings
            ->filter(fn ($b) => $b->due_at >= $today && $b->due_at <= now()->addDays(3)->toDateString());

        $availableBooks = Book::sum('stock');

        return view('livewire.member.dashboard', [
            'member' => $member,
            'activeCount' => $activeBorrowings->count(),
            'activeBooks' => $activeDetails->pluck('book.title')->filter()->values(),
            'activeDetails' => $activeDetails,
            'overdueCount' => $overdue->count(),
            'overdueList' => $overdue,
            'dueSoonCount' => $dueSoon->count(),
            'historyCount' => (int) BorrowingDetail::whereIn('borrowing_id', $borrowingIds)->where('status', 'returned')->count(),
            'returnedDetails' => $returnedDetails,
            'availableBooks' => (int) $availableBooks,
            'totalTitles' => Book::count(),
        ])->layout('layouts.member', ['nav' => 'dashboard', 'overdueCount' => $overdue->count()]);
    }
}