<?php

namespace App\Livewire\Member;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $member = Auth::guard('member')->user();
        $today = now()->toDateString();

        $borrowings = Borrowing::with('details.book')->where('member_id', $member->id)->orderByDesc('id')->get();
        $borrowingIds = $borrowings->pluck('id');

        $activeBorrowings = $borrowings->where('status', 'borrowed');
        $activeDetails = BorrowingDetail::with(['book.category', 'borrowing'])
            ->whereIn('borrowing_id', $borrowingIds)
            ->where('status', 'borrowed')
            ->orderBy('id', 'desc')
            ->get();

        $overdueCount = $activeBorrowings->filter(fn ($b) => $b->due_at < $today)->count();

        // Batas jatuh tempo terdekat
        $nearest = $activeBorrowings->sortBy('due_at')->first();
        $nearestDays = $nearest ? (int) Carbon::parse($today)->diffInDays($nearest->due_at) : null;

        // Total riwayat baca (eksemplar sudah kembali)
        $historyQty = (int) BorrowingDetail::whereIn('borrowing_id', $borrowingIds)->where('status', 'returned')->sum('quantity');

        // Rekomendasi: judul tersedia yang belum dipinjam member ini
        $borrowedBookIds = $activeDetails->pluck('book_id')->filter()->unique();
        $recommended = Book::with('category')
            ->where('stock', '>', 0)
            ->when($borrowedBookIds->isNotEmpty(), fn ($q) => $q->whereNotIn('id', $borrowedBookIds))
            ->orderByDesc('stock')->orderBy('title')
            ->limit(3)->get();

        return view('livewire.member.dashboard', [
            'member' => $member,
            'firstName' => explode(' ', $member->name)[0],
            'activeQty' => (int) $activeDetails->sum('quantity'),
            'activeCount' => $activeBorrowings->count(),
            'activeDetails' => $activeDetails,
            'overdueCount' => $overdueCount,
            'nearest' => $nearest,
            'nearestDays' => $nearestDays,
            'nearestBook' => $nearest ? ($nearest->details()->with('book')->first()?->book?->title ?? null) : null,
            'historyQty' => $historyQty,
            'recommended' => $recommended,
            'totalTitles' => Book::count(),
        ])->layout('layouts.member', ['nav' => 'dashboard', 'overdueCount' => $overdueCount]);
    }
}