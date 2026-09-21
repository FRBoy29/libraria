<?php

namespace App\Livewire\Member;

use App\Models\Book;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Catalog extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filterCategory = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilterCategory(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $books = Book::with('category')
            ->when($this->search, fn ($q) => $q->where(fn ($w) => $w->where('title', 'like', "%{$this->search}%")->orWhere('author', 'like', "%{$this->search}%")))
            ->when($this->filterCategory, fn ($q) => $q->where('category_id', $this->filterCategory))
            ->orderBy('title')->paginate(12);

        return view('livewire.member.catalog', [
            'books' => $books,
            'categories' => Category::orderBy('name')->get(),
        ])->layout('layouts.member');
    }
}
