<?php

namespace App\Livewire\Book;

use App\Models\Book;
use App\Models\BorrowingDetail;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Manager extends Component
{
    use WithFileUploads;
    use WithPagination;

    public string $search = '';

    public string $filterCategory = '';

    public string $filterStatus = '';

    public string $filterYear = '';

    public string $view = 'table';

    public ?int $editingId = null;

    public ?int $confirmingDelete = null;

    public bool $showDrawer = false;

    public string $isbn = '';

    public string $title = '';

    public string $author = '';

    public string $publisher = '';

    public ?int $publication_year = null;

    public string $category_id = '';

    public int $stock = 0;

    public string $description = '';

    public $coverUpload = null;

    protected function rules(): array
    {
        return [
            'isbn' => 'required|string|max:255|unique:books,isbn,' . ($this->editingId ?? 'NULL') . ',id',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'coverUpload' => 'nullable|image|max:3072',
        ];
    }

    public function mount(): void
    {
        $q = request('q');
        if (is_string($q) && $q !== '') {
            $this->search = $q;
        }
    }

    public function updated($property): void
    {
        if ($property === 'coverUpload') {
            return;
        }
        if (in_array($property, ['search', 'filterCategory', 'filterStatus', 'filterYear'], true)) {
            $this->resetPage();
        }
    }

    public function setView(string $view): void
    {
        $this->view = $view === 'grid' ? 'grid' : 'table';
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'isbn', 'title', 'author', 'publisher', 'publication_year', 'category_id', 'description', 'coverUpload', 'confirmingDelete']);
        $this->stock = 1;
        $this->showDrawer = true;
    }

    public function save()
    {
        $data = $this->validate();
        $data['publication_year'] = $this->publication_year;
        $data['publisher'] = $this->publisher ?: null;
        $data['description'] = $this->description ?: null;

        $book = $this->editingId ? Book::findOrFail($this->editingId) : null;

        if ($this->coverUpload) {
            if ($book?->cover) {
                Storage::disk('public')->delete($book->cover);
            }
            $data['cover'] = $this->coverUpload->store('covers', 'public');
        }

        if ($book) {
            $book->update($data);
            session()->flash('success', 'Buku diperbarui.');
        } else {
            Book::create($data);
            session()->flash('success', 'Buku ditambahkan.');
        }

        $this->closeDrawer();
    }

    public function edit(int $id): void
    {
        $b = Book::findOrFail($id);
        $this->editingId = $id;
        $this->isbn = $b->isbn;
        $this->title = $b->title;
        $this->author = $b->author;
        $this->publisher = $b->publisher ?? '';
        $this->publication_year = $b->publication_year;
        $this->category_id = (string) $b->category_id;
        $this->stock = $b->stock;
        $this->description = $b->description ?? '';
        $this->coverUpload = null;
        $this->showDrawer = true;
    }

    public function closeDrawer(): void
    {
        $this->showDrawer = false;
        $this->reset(['editingId', 'isbn', 'title', 'author', 'publisher', 'publication_year', 'category_id', 'stock', 'description', 'coverUpload', 'confirmingDelete']);
    }

    public function delete(int $id): void
    {
        $book = Book::findOrFail($id);
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }
        $book->delete();
        $this->confirmingDelete = null;
        session()->flash('success', 'Buku dihapus.');
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'filterCategory', 'filterStatus', 'filterYear']);
        $this->resetPage();
    }

    protected function filteredQuery()
    {
        return Book::with('category')
            ->when($this->search, fn ($q) => $q->where(fn ($w) => $w->where('title', 'like', "%{$this->search}%")->orWhere('author', 'like', "%{$this->search}%")->orWhere('isbn', 'like', "%{$this->search}%")->orWhere('publisher', 'like', "%{$this->search}%")))
            ->when($this->filterCategory, fn ($q) => $q->where('category_id', $this->filterCategory))
            ->when($this->filterYear, fn ($q) => $q->where('publication_year', $this->filterYear))
            ->when($this->filterStatus === 'empty', fn ($q) => $q->where('stock', '<=', 0))
            ->when($this->filterStatus === 'available', fn ($q) => $q->where('stock', '>', 0));
    }

    public function render()
    {
        $books = $this->filteredQuery()->orderBy('id', 'desc')->paginate(8);

        $totalStock = (int) Book::sum('stock');
        $borrowedQty = (int) BorrowingDetail::where('status', 'borrowed')->sum('quantity');
        $totalCopies = $totalStock + $borrowedQty;
        $availability = $totalCopies > 0 ? round($totalStock / $totalCopies * 100, 1) : 0.0;
        $overdueBooks = (int) BorrowingDetail::where('status', 'borrowed')
            ->whereHas('borrowing', fn ($b) => $b->where('due_at', '<', now()->toDateString()))->sum('quantity');

        $categories = Category::withCount('books')->orderBy('name')->get();

        return view('livewire.book.manager', [
            'books' => $books,
            'categories' => $categories,
            'years' => Book::whereNotNull('publication_year')->distinct()->orderByDesc('publication_year')->pluck('publication_year'),
            'totalStock' => $totalStock,
            'borrowedQty' => $borrowedQty,
            'totalTitles' => Book::count(),
            'overdueBooks' => $overdueBooks,
            'availability' => $availability,
        ])->layout('layouts.admin', [
            'active' => 'books',
            'overdueCount' => \App\Models\Borrowing::where('status', 'borrowed')->where('due_at', '<', now()->toDateString())->count(),
        ]);
    }
}