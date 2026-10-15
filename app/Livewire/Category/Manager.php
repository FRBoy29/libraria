<?php

namespace App\Livewire\Category;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Manager extends Component
{
    use WithPagination;

    public string $search = '';

    public string $view = 'grid';

    public string $name = '';

    public string $description = '';

    public ?int $editingId = null;

    public ?int $confirmingDelete = null;

    public bool $showDrawer = false;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'regex:/^[\p{L}0-9][\p{L}0-9\s\.\'\-\&]*$/u'],
            'description' => 'nullable|string|max:1000',
        ];
    }

    protected function messages(): array
    {
        return [
            'name.regex' => 'Nama kategori hanya boleh berisi huruf, angka, spasi, titik, tanda kutip, tanda hubung, dan ampersand (&).',
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function setView(string $view): void
    {
        $this->view = $view === 'table' ? 'table' : 'grid';
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'name', 'description', 'confirmingDelete']);
        $this->showDrawer = true;
    }

    public function save()
    {
        $data = $this->validate();
        $data['description'] = $this->description ?: null;

        if ($this->editingId) {
            Category::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Kategori diperbarui.');
        } else {
            Category::create($data);
            session()->flash('success', 'Kategori ditambahkan.');
        }

        $this->closeDrawer();
    }

    public function edit(int $id): void
    {
        $cat = Category::findOrFail($id);
        $this->editingId = $id;
        $this->name = $cat->name;
        $this->description = $cat->description ?? '';
        $this->showDrawer = true;
    }

    public function closeDrawer(): void
    {
        $this->showDrawer = false;
        $this->reset(['name', 'description', 'editingId', 'confirmingDelete']);
    }

    public function delete(int $id): void
    {
        $cat = Category::withCount('books')->findOrFail($id);

        // books.category_id memakai cascadeOnDelete: cek dulu agar buku tidak ikut terhapus.
        if ($cat->books_count > 0) {
            $this->confirmingDelete = null;
            session()->flash('error', "Kategori \"{$cat->name}\" masih memiliki {$cat->books_count} buku. Pindahkan atau hapus buku tersebut sebelum menghapus kategori.");

            return;
        }

        $cat->delete();
        $this->confirmingDelete = null;
        session()->flash('success', 'Kategori dihapus.');
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::withCount('books')
            ->withSum('books', 'stock')
            ->when($this->search, fn ($q) => $q->where(fn ($w) => $w->where('name', 'like', "%{$this->search}%")->orWhere('description', 'like', "%{$this->search}%")))
            ->orderBy('name')
            ->paginate(12);

        $all = Category::withCount('books')->get();

        return view('livewire.category.manager', [
            'categories' => $categories,
            'totalCategories' => $all->count(),
            'usedCategories' => $all->where('books_count', '>', 0)->count(),
            'emptyCategories' => $all->where('books_count', 0)->count(),
            'totalBooks' => Book::count(),
            'unclassified' => Book::whereNull('category_id')->count(),
        ])->layout('layouts.admin', [
            'active' => 'categories',
            'overdueCount' => DB::table('borrowings')
                ->where('status', 'borrowed')
                ->where('due_at', '<', now()->toDateString())
                ->count(),
        ]);
    }
}