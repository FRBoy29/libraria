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

    public string $password = '';

    public string $phone = '';

    public string $address = '';

    public string $status = 'active';

    public string $active_until = '';

    protected function rules(): array
    {
        $id = $this->editingId ?? 'NULL';
        $passwordRule = $this->editingId ? 'nullable|min:6' : 'required|min:6';

        return [
            'member_code' => 'required|string|max:255|unique:members,member_code,' . $id . ',id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,' . $id . ',id',
            'password' => $passwordRule,
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'active_until' => 'nullable|date',
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

    public function generateCode(): void
    {
        $n = (Member::max('id') ?? 0) + 1;
        do {
            $code = 'LIB-' . str_pad((string) $n, 6, '0', STR_PAD_LEFT);
            $n++;
        } while (Member::where('member_code', $code)->exists());

        $this->member_code = $code;
    }

    public function save()
    {
        $data = $this->validate();
        $data['phone'] = $this->phone ?: null;
        $data['address'] = $this->address ?: null;
        $data['active_until'] = $this->active_until ?: null;

        if ($this->editingId) {
            if ($this->password === '') {
                unset($data['password']);
            }
            Member::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Anggota diperbarui.');
        } else {
            Member::create($data);
            session()->flash('success', 'Anggota ditambahkan. Member ID: ' . $data['member_code']);
        }

        $this->reset(['editingId', 'member_code', 'name', 'email', 'password', 'phone', 'address', 'status', 'active_until']);
        $this->status = 'active';
    }

    public function edit(int $id): void
    {
        $m = Member::findOrFail($id);
        $this->editingId = $id;
        $this->member_code = $m->member_code;
        $this->name = $m->name;
        $this->email = $m->email;
        $this->password = '';
        $this->phone = $m->phone ?? '';
        $this->address = $m->address ?? '';
        $this->status = $m->status;
        $this->active_until = $m->active_until ? $m->active_until->format('Y-m-d') : '';
    }

    public function cancel(): void
    {
        $this->reset(['editingId', 'confirmingDelete', 'member_code', 'name', 'email', 'password', 'phone', 'address', 'status', 'active_until']);
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
