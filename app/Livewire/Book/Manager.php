<?php

namespace App\Livewire\Book;

use App\Models\Book;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Manager extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filterCategory = '';

    public ?int $editingId = null;

    public ?int $confirmingDelete = null;

    public string $isbn = '';

    public string $title = '';

    public string $author = '';

    public string $publisher = '';

    public ?int $publication_year = null;

    public string $category_id = '';

    public int $stock = 0;

    public string $description = '';

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
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilterCategory(): void
    {
        $this->resetPage();
    }

    public function save()
    {
        $data = $this->validate();
        $data['publication_year'] = $this->publication_year;
        $data['publisher'] = $this->publisher ?: null;
        $data['description'] = $this->description ?: null;

        if ($this->editingId) {
            Book::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Buku diperbarui.');
        } else {
            Book::create($data);
            session()->flash('success', 'Buku ditambahkan.');
        }

        $this->reset(['editingId', 'isbn', 'title', 'author', 'publisher', 'publication_year', 'category_id', 'stock', 'description']);
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
    }

    public function cancel(): void
    {
        $this->reset(['editingId', 'confirmingDelete', 'isbn', 'title', 'author', 'publisher', 'publication_year', 'category_id', 'stock', 'description']);
    }

    public function delete(int $id): void
    {
        Book::findOrFail($id)->delete();
        $this->confirmingDelete = null;
        session()->flash('success', 'Buku dihapus.');
    }

    public function render()
    {
        $books = Book::with('category')
            ->when($this->search, fn ($q) => $q->where(fn ($w) => $w->where('title', 'like', "%{$this->search}%")->orWhere('author', 'like', "%{$this->search}%")->orWhere('isbn', 'like', "%{$this->search}%")))
            ->when($this->filterCategory, fn ($q) => $q->where('category_id', $this->filterCategory))
            ->orderBy('id', 'desc')->paginate(10);

        return view('livewire.book.manager', [
            'books' => $books,
            'categories' => Category::orderBy('name')->get(),
        ])->layout('layouts.app');
    }
}
