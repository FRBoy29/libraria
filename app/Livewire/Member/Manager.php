<?php

namespace App\Livewire\Member;

use App\Models\Borrowing;
use App\Models\BorrowingDetail;
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

    public ?int $selectedId = null;

    public bool $showForm = false;

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
        $passwordRules = $this->editingId
            ? ['nullable', 'string', 'min:6']
            : ['required', 'string', 'min:6'];

        return [
            'member_code' => ['required', 'string', 'max:255', 'unique:members,member_code,' . $id . ',id'],
            'name' => ['required', 'string', 'max:255', 'regex:/^[\p{L}\s]+$/u'],
            'email' => ['required', 'email', 'unique:members,email,' . $id . ',id'],
            'password' => $passwordRules,
            'phone' => ['nullable', 'string', 'max:50', 'regex:/^[0-9\+\-\s\(\)]+$/'],
            'address' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'in:active,inactive'],
            'active_until' => ['nullable', 'date'],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.regex' => 'Nama hanya boleh berisi huruf dan spasi.',
            'phone.regex' => 'Nomor telepon hanya boleh berisi angka, spasi, tanda plus, kurung, dan tanda hubung.',
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

    public function select(int $id): void
    {
        $this->selectedId = $id;
        $this->confirmingDelete = null;
    }

    public function openCreate(): void
    {
        $this->reset(['editingId', 'member_code', 'name', 'email', 'password', 'phone', 'address', 'active_until', 'confirmingDelete']);
        $this->status = 'active';
        $this->generateCode();
        $this->showForm = true;
    }

    public function generateCode(): void
    {
        $n = (Member::max('id') ?? 0) + 1;
        do {
            $code = 'M' . str_pad((string) $n, 3, '0', STR_PAD_LEFT);
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
            $created = Member::create($data);
            $this->selectedId = $created->id;
            session()->flash('success', 'Anggota ditambahkan. Member ID: ' . $data['member_code']);
        }

        $this->reset(['editingId', 'member_code', 'name', 'email', 'password', 'phone', 'address', 'status', 'active_until']);
        $this->status = 'active';
        $this->showForm = false;
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
        $this->showForm = true;
        $this->selectedId = $id;
    }

    public function cancel(): void
    {
        $this->reset(['editingId', 'confirmingDelete', 'member_code', 'name', 'email', 'password', 'phone', 'address', 'status', 'active_until']);
        $this->status = 'active';
        $this->showForm = false;
    }

    public function delete(int $id): void
    {
        Member::findOrFail($id)->delete();
        $this->confirmingDelete = null;
        if ($this->selectedId === $id) {
            $this->selectedId = null;
        }
        session()->flash('success', 'Anggota dihapus.');
    }

    public function render()
    {
        $members = Member::when($this->search, fn ($q) => $q->where(fn ($w) => $w->where('name', 'like', "%{$this->search}%")->orWhere('member_code', 'like', "%{$this->search}%")->orWhere('email', 'like', "%{$this->search}%")))
            ->when($this->filterStatus, fn ($q) => $q->where('status', $this->filterStatus))
            ->orderBy('id', 'desc')->paginate(10);

        $totalMembers = Member::count();
        $activeMembers = Member::where('status', 'active')->count();
        $newThisMonth = Member::where('created_at', '>=', now()->startOfMonth())->count();
        $activeBorrowings = Borrowing::where('status', 'borrowed');
        $borrowingMemberIds = (clone $activeBorrowings)->distinct()->pluck('member_id');
        $borrowingBooksQty = (int) BorrowingDetail::where('status', 'borrowed')->sum('quantity');
        $overdueMemberIds = Borrowing::where('status', 'borrowed')
            ->where('due_at', '<', now()->toDateString())->distinct()->pluck('member_id');

        $selected = $this->selectedId ? Member::find($this->selectedId) : null;
        $selectedBorrows = $selected
            ? Borrowing::with('details.book')->where('member_id', $selected->id)->where('status', 'borrowed')->orderBy('due_at')->get()
            : collect();

        return view('livewire.member.manager', [
            'members' => $members,
            'totalMembers' => $totalMembers,
            'activeMembers' => $activeMembers,
            'newThisMonth' => $newThisMonth,
            'borrowingMembersCount' => $borrowingMemberIds->count(),
            'borrowingBooksQty' => $borrowingBooksQty,
            'overdueMembersCount' => $overdueMemberIds->count(),
            'selected' => $selected,
            'selectedBorrows' => $selectedBorrows,
        ])->layout('layouts.admin', [
            'active' => 'members',
            'overdueCount' => Borrowing::where('status', 'borrowed')->where('due_at', '<', now()->toDateString())->count(),
        ]);
    }
}