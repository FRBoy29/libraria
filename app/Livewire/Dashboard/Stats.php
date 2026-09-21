<?php

namespace App\Livewire\Dashboard;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Member;
use Livewire\Component;

class Stats extends Component
{
    public function render()
    {
        return view('livewire.dashboard.stats', [
            'totalBooks' => Book::sum('stock'),
            'totalTitles' => Book::count(),
            'totalMembers' => Member::count(),
            'activeBorrowings' => Borrowing::where('status', 'borrowed')->count(),
            'overdueBorrowings' => Borrowing::where('status', 'borrowed')->where('due_at', '<', now())->count(),
            'returnedBooks' => BorrowingDetail::where('status', 'returned')->sum('quantity'),
        ])->layout('layouts.app');
    }
}
