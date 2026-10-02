<?php

namespace App\Livewire\Member;

use App\Models\Borrowing;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MyBorrowings extends Component
{
    use WithPagination;

    public function render()
    {
        $me = Auth::guard('member')->user()->id;

        $borrowings = Borrowing::with(['details.book'])
            ->where('member_id', $me)
            ->where('status', 'borrowed')
            ->orderBy('due_at')
            ->paginate(10);

        $today = now()->toDateString();
        $overdue = Borrowing::where('member_id', $me)->where('status', 'borrowed')->whereDate('due_at', '<', $today)->count();

        return view('livewire.member.my-borrowings', compact('borrowings'))->layout('layouts.member', ['nav' => 'borrowings', 'overdueCount' => $overdue]);
    }
}
