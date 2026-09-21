<?php

namespace App\Livewire\Member;

use App\Models\Book;
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
        return view('livewire.member.book-detail')->layout('layouts.member');
    }
}
