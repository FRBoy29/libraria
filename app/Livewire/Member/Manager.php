<?php

namespace App\Livewire\Member;

use App\Models\Member;
use Livewire\Component;
use Livewire\WithPagination;

class Manager extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filterStatus = '';

    public ?int $editingId = null;

    public ?int $confirmingDelete = null;

    public string $member_code = '';

    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $address = '';

    public string $status = 'active';

    protected function rules(): array
    {
        $id = $this->editingId ?? 'NULL';
        return [
            'member_code' => 'required|string|max:255|unique:members,member_code,' . $id . ',id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,' . $id . ',id',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilterStatus(): void
    {
        $this->resetPage();
    }

    public function save()
    {
        $data = $this->validate();
        $data['phone'] = $this->phone ?: null;
        $data['address'] = $this->address ?: null;

        if ($this->editingId) {
            Member::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Anggota diperbarui.');
        } else {
            Member::create($data);
            session()->flash('success', 'Anggota ditambahkan.');
        }

        $this->reset(['editingId', 'member_code', 'name', 'email', 'phone', 'address', 'status']);
        $this->status = 'active';
    }

    public function edit(int $id): void
    {
        $m = Member::findOrFail($id);
        $this->editingId = $id;
        $this->member_code = $m->member_code;
        $this->name = $m->name;
        $this->email = $m->email;
        $this->phone = $m->phone ?? '';
        $this->address = $m->address ?? '';
        $this->status = $m->status;
    }

    public function cancel(): void
    {
        $this->reset(['editingId', 'confirmingDelete', 'member_code', 'name', 'email', 'phone', 'address', 'status']);
        $this->status = 'active';
    }

    public function delete(int $id): void
    {
        Member::findOrFail($id)->delete();
        $this->confirmingDelete = null;
        session()->flash('success', 'Anggota dihapus.');
    }

    public function render()
    {
        $members = Member::when($this->search, fn ($q) => $q->where(fn ($w) => $w->where('name', 'like', "%{$this->search}%")->orWhere('member_code', 'like', "%{$this->search}%")->orWhere('email', 'like', "%{$this->search}%")))
            ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
            ->orderBy('id', 'desc')->paginate(10);

        return view('livewire.member.manager', compact('members'))->layout('layouts.app');
    }
}
