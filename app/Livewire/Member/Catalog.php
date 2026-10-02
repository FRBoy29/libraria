<?php

namespace App\Livewire\Member;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Catalog extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filterCategory = '';

    public function mount(): void
    {
        $q = request('q');
        if (is_string($q) && $q !== '') {
            $this->search = $q;
        }
    }

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
        ])->layout('layouts.member', ['nav' => 'books', 'overdueCount' => $this->overdueCount()]);
    }

    private function overdueCount(): int
    {
        return Borrowing::where('member_id', Auth::guard('member')->id())
            ->where('status', 'borrowed')
            ->whereDate('due_at', '<', now()->toDateString())
            ->count();
    }
}
