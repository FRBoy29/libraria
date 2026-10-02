<?php

namespace App\Livewire\Member;

use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class History extends Component
{
    use WithPagination;

    public function render()
    {
        $borrowingIds = Auth::guard('member')->user()->borrowings()->pluck('id');

        $items = BorrowingDetail::with(['book', 'borrowing'])
            ->whereIn('borrowing_id', $borrowingIds)
            ->where('status', 'returned')
            ->orderBy('returned_at', 'desc')
            ->paginate(10);

        return view('livewire.member.history', ['items' => $items])->layout('layouts.member', ['nav' => 'history', 'overdueCount' => $this->overdueCount()]);
    }

    private function overdueCount(): int
    {
        return Borrowing::where('member_id', Auth::guard('member')->id())
            ->where('status', 'borrowed')
            ->whereDate('due_at', '<', now()->toDateString())
            ->count();
    }
}
