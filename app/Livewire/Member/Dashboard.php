<?php

namespace App\Livewire\Member;

use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $member = Auth::guard('member')->user();

        $active = Borrowing::where('member_id', $member->id)->where('status', 'borrowed');
        $overdue = (clone $active)->where('due_at', '<', now()->toDateString())->count();
        $borrowingIds = Borrowing::where('member_id', $member->id)->pluck('id');

        return view('livewire.member.dashboard', [
            'member' => $member,
            'activeCount' => (clone $active)->count(),
            'overdueCount' => $overdue,
            'historyCount' => BorrowingDetail::whereIn('borrowing_id', $borrowingIds)->where('status', 'returned')->count(),
        ])->layout('layouts.member');
    }
}
