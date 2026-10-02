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

    public bool $inStockOnly = false;

    public string $sort = 'az';

    public string $view = 'grid';

    public function mount(): void
    {
        $q = request('q');
        if (is_string($q) && $q !== '') {
            $this->search = $q;
        }
    }

    public function updated($property): void
    {
        if (in_array($property, ['search', 'filterCategory', 'inStockOnly', 'sort'], true)) {
            $this->resetPage();
        }
    }

    public function setView(string $view): void
    {
        $this->view = $view === 'table' ? 'table' : 'grid';
    }

    public function clearSearch(): void
    {
        $this->search = '';
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'filterCategory', 'sort']);
        $this->inStockOnly = false;
        $this->resetPage();
    }

    protected function baseQuery()
    {
        return Book::with(['category'])
            ->withSum(['borrowingDetails as total_borrowed' => fn ($q) => $q], 'quantity')
            ->when($this->search, fn ($q) => $q->where(fn ($w) => $w
                ->where('title', 'like', "%{$this->search}%")
                ->orWhere('author', 'like', "%{$this->search}%")
                ->orWhere('publisher', 'like', "%{$this->search}%")
                ->orWhere('isbn', 'like', "%{$this->search}%")))
            ->when($this->filterCategory, fn ($q) => $q->where('category_id', $this->filterCategory))
            ->when($this->inStockOnly, fn ($q) => $q->where('stock', '>', 0));
    }

    public function render()
    {
        $query = match ($this->sort) {
            'newest' => $this->baseQuery()->orderByDesc('id'),
            'stock' => $this->baseQuery()->orderByDesc('stock'),
            'popular' => $this->baseQuery()->orderByDesc('total_borrowed'),
            default => $this->baseQuery()->orderBy('title'),
        };

        $books = $query->paginate(8);
        $categories = Category::withCount('books')->orderBy('name')->get();

        return view('livewire.member.catalog', [
            'books' => $books,
            'categories' => $categories,
            'availableTitles' => Book::where('stock', '>', 0)->count(),
            'totalTitles' => Book::count(),
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