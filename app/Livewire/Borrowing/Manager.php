<?php

namespace App\Livewire\Borrowing;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Manager extends Component
{
    use WithPagination;

    public string $member_id = '';

    public string $book_id = '';

    public int $quantity = 1;

    public string $borrowed_at = '';

    public string $due_at = '';

    public string $search = '';

    public string $filterStatus = '';

    public bool $showDrawer = false;

    public function mount(): void
    {
        $this->borrowed_at = now()->format('Y-m-d');
        $this->due_at = now()->addDays(7)->format('Y-m-d');

        $preselect = request('member');
        if (is_string($preselect) && $preselect !== '' && Member::where('id', $preselect)->exists()) {
            $this->member_id = $preselect;
        }

        $prebook = request('book');
        if (is_string($prebook) && $prebook !== '' && Book::where('id', $prebook)->exists()) {
            $this->book_id = $prebook;
        }

        if ($this->member_id || $this->book_id) {
            $this->showDrawer = true;
        }
    }

    public function updated($property): void
    {
        if (in_array($property, ['search', 'filterStatus'], true)) {
            $this->resetPage();
        }
    }

    public function openCreate(): void
    {
        $this->reset(['member_id', 'book_id', 'quantity']);
        $this->quantity = 1;
        $this->borrowed_at = now()->format('Y-m-d');
        $this->due_at = now()->addDays(7)->format('Y-m-d');
        $this->showDrawer = true;
    }

    public function save()
    {
        $this->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
            'borrowed_at' => 'required|date',
            'due_at' => 'required|date|after_or_equal:borrowed_at',
        ]);

        $member = Member::findOrFail($this->member_id);

        if (! $member->isActive() || $member->isExpired()) {
            $this->addError('member_id', 'Anggota tidak aktif atau masa aktifnya sudah kedaluwarsa.');

            return;
        }

        $book = Book::findOrFail($this->book_id);

        if ($book->stock < $this->quantity) {
            $this->addError('book_id', 'Stok tidak mencukupi (sisa: ' . $book->stock . ').');

            return;
        }

        DB::transaction(function () use ($book) {
            $borrowing = Borrowing::create([
                'member_id' => $this->member_id,
                'borrowed_at' => $this->borrowed_at,
                'due_at' => $this->due_at,
                'status' => 'borrowed',
            ]);
            BorrowingDetail::create([
                'borrowing_id' => $borrowing->id,
                'book_id' => $book->id,
                'quantity' => $this->quantity,
                'status' => 'borrowed',
            ]);
            $book->decrement('stock', $this->quantity);
        });

        session()->flash('success', 'Peminjaman dicatat. Stok berkurang ' . $this->quantity . ' eksemplar.');
        $this->showDrawer = false;
        $this->reset(['member_id', 'book_id', 'quantity']);
        $this->quantity = 1;
    }

    public function closeDrawer(): void
    {
        $this->showDrawer = false;
        $this->reset(['member_id', 'book_id', 'quantity']);
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'filterStatus']);
        $this->resetPage();
    }

    public function render()
    {
        $today = now()->toDateString();

        $borrowings = Borrowing::with(['member', 'details.book'])
            ->when($this->search, fn ($q) => $q->where(fn ($w) => $w->whereHas('member', fn ($m) => $m->where('name', 'like', "%{$this->search}%")->orWhere('member_code', 'like', "%{$this->search}%"))->orWhereHas('details', fn ($d) => $d->whereHas('book', fn ($b) => $b->where('title', 'like', "%{$this->search}%")))))
            ->when($this->filterStatus === 'borrowed', fn ($q) => $q->where('status', 'borrowed'))
            ->when($this->filterStatus === 'returned', fn ($q) => $q->where('status', 'returned'))
            ->when($this->filterStatus === 'overdue', fn ($q) => $q->where('status', 'borrowed')->where('due_at', '<', $today))
            ->orderBy('id', 'desc')->paginate(10);

        $activeBorrowings = Borrowing::where('status', 'borrowed');

        return view('livewire.borrowing.manager', [
            'borrowings' => $borrowings,
            'members' => Member::where('status', 'active')->orderBy('name')->get(),
            'books' => Book::where('stock', '>', 0)->orderBy('title')->get(),
            'activeCount' => (clone $activeBorrowings)->count(),
            'overdueCount' => (clone $activeBorrowings)->where('due_at', '<', $today)->count(),
            'borrowedQty' => (int) BorrowingDetail::where('status', 'borrowed')->sum('quantity'),
            'returnedToday' => BorrowingDetail::where('status', 'returned')->whereDate('returned_at', $today)->sum('quantity'),
        ])->layout('layouts.admin', [
            'active' => 'borrowings',
            'overdueCount' => (clone $activeBorrowings)->where('due_at', '<', $today)->count(),
        ]);
    }
}