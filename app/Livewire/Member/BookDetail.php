<?php

namespace App\Livewire\Member;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BookDetail extends Component
{
    public Book $book;

    public function mount(int $id): void
    {
        $this->book = Book::with('category')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.member.book-detail')->layout('layouts.member', ['nav' => 'books', 'overdueCount' => Borrowing::where('member_id', Auth::guard('member')->id())->where('status', 'borrowed')->whereDate('due_at', '<', now()->toDateString())->count()]);
    }
}
