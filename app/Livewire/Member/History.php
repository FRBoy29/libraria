<?php

namespace App\Livewire\Member;

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

        return view('livewire.member.history', ['items' => $items])->layout('layouts.member');
    }
}
