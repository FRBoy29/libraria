<?php

namespace App\Livewire\Circulation;

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

    // Form peminjaman
    public string $member_id = '';

    public string $book_id = '';

    public int $quantity = 1;

    public string $borrowed_at = '';

    public string $due_at = '';

    public bool $showDrawer = false;

    // Daftar & filter
    public string $search = '';

    public string $filterStatus = '';

    public ?int $confirmingReturn = null;

    public function mount(): void
    {
        $this->borrowed_at = now()->format('Y-m-d');
        $this->due_at = now()->addDays(7)->format('Y-m-d');

        $premember = request('member');
        if (is_string($premember) && $premember !== '' && Member::where('id', $premember)->exists()) {
            $this->member_id = $premember;
        }

        $prebook = request('book');
        if (is_string($prebook) && $prebook !== '' && Book::where('id', $prebook)->exists()) {
            $this->book_id = $prebook;
        }

        if (request('create') !== null || $this->member_id !== '' || $this->book_id !== '') {
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

    public function closeDrawer(): void
    {
        $this->showDrawer = false;
        $this->reset(['member_id', 'book_id', 'quantity']);
        $this->quantity = 1;
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
        $this->closeDrawer();
    }

    public function confirmReturn(int $detailId): void
    {
        $this->confirmingReturn = $detailId;
    }

    public function cancelReturn(): void
    {
        $this->confirmingReturn = null;
    }

    public function returnDetail(int $detailId)
    {
        $detail = BorrowingDetail::with(['book', 'borrowing'])->findOrFail($detailId);

        if ($detail->status === 'returned') {
            $this->confirmingReturn = null;
            session()->flash('error', 'Pengembalian ditolak: buku sudah pernah dikembalikan.');

            return;
        }

        DB::transaction(function () use ($detail) {
            $detail->update(['status' => 'returned', 'returned_at' => now()]);
            $detail->book->increment('stock', $detail->quantity);

            $borrowing = $detail->borrowing;
            if ($borrowing->details()->where('status', 'borrowed')->count() === 0) {
                $borrowing->update(['status' => 'returned']);
            }
        });

        $this->confirmingReturn = null;
        session()->flash('success', 'Pengembalian diproses. Stok bertambah ' . $detail->quantity . ' eksemplar.');
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

        $active = Borrowing::where('status', 'borrowed');
        $overdueCount = (clone $active)->where('due_at', '<', $today)->count();

        return view('livewire.circulation.manager', [
            'borrowings' => $borrowings,
            'members' => Member::where('status', 'active')->orderBy('name')->get(),
            'books' => Book::where('stock', '>', 0)->orderBy('title')->get(),
            'activeCount' => (clone $active)->count(),
            'overdueCount' => $overdueCount,
            'borrowedQty' => (int) BorrowingDetail::where('status', 'borrowed')->sum('quantity'),
            'returnedToday' => BorrowingDetail::where('status', 'returned')->whereDate('returned_at', $today)->sum('quantity'),
            'returnedTotal' => (int) BorrowingDetail::where('status', 'returned')->sum('quantity'),
        ])->layout('layouts.admin', [
            'active' => 'circulations',
            'overdueCount' => $overdueCount,
        ]);
    }
}