<?php

namespace App\Livewire\Report;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Category;
use App\Models\Member;
use Livewire\Component;

class Index extends Component
{
    public string $from = '';

    public string $to = '';

    public string $status = '';

    public string $member_id = '';

    public string $category_id = '';

    public function render()
    {
        $borrowings = Borrowing::with(['member', 'details.book'])
            ->when($this->from, fn ($q) => $q->where('borrowed_at', '>=', $this->from))
            ->when($this->to, fn ($q) => $q->where('borrowed_at', '<=', $this->to))
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->when($this->member_id, fn ($q) => $q->where('member_id', $this->member_id))
            ->orderBy('id', 'desc')->limit(100)->get();

        $books = Book::with('category')
            ->when($this->category_id, fn ($q) => $q->where('category_id', $this->category_id))
            ->orderBy('title')->limit(100)->get();

        $returns = BorrowingDetail::with(['book', 'borrowing.member'])
            ->where('status', 'returned')->orderBy('returned_at', 'desc')->limit(100)->get();

        return view('livewire.report.index', [
            'borrowings' => $borrowings,
            'books' => $books,
            'returns' => $returns,
            'members' => Member::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
        ])->layout('layouts.app');
    }
}
