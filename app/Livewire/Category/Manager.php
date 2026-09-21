<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Manager extends Component
{
    use WithPagination;

    public string $search = '';

    public string $name = '';

    public string $description = '';

    public ?int $editingId = null;

    public ?int $confirmingDelete = null;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            Category::findOrFail($this->editingId)->update([
                'name' => $this->name, 'description' => $this->description,
            ]);
            session()->flash('success', 'Kategori diperbarui.');
        } else {
            Category::create(['name' => $this->name, 'description' => $this->description]);
            session()->flash('success', 'Kategori ditambahkan.');
        }

        $this->reset(['name', 'description', 'editingId']);
    }

    public function edit(int $id): void
    {
        $cat = Category::findOrFail($id);
        $this->editingId = $id;
        $this->name = $cat->name;
        $this->description = $cat->description ?? '';
    }

    public function cancel(): void
    {
        $this->reset(['name', 'description', 'editingId', 'confirmingDelete']);
    }

    public function delete(int $id): void
    {
        Category::findOrFail($id)->delete();
        $this->confirmingDelete = null;
        session()->flash('success', 'Kategori dihapus.');
    }

    public function render()
    {
        $categories = Category::where('name', 'like', "%{$this->search}%")
            ->orderBy('id', 'desc')->paginate(10);

        return view('livewire.category.manager', compact('categories'))->layout('layouts.app');
    }
}
