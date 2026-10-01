<?php

namespace App\Livewire\ReturnBook;

use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Manager extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filterStatus = '';

    public ?int $confirmingReturn = null;

    public function updated($property): void
    {
        if (in_array($property, ['search', 'filterStatus'], true)) {
            $this->resetPage();
        }
    }

    public function confirm(int $detailId): void
    {
        $this->confirmingReturn = $detailId;
    }

    public function cancel(): void
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

        $actives = BorrowingDetail::with(['book', 'borrowing.member'])
            ->where('status', 'borrowed')
            ->when($this->search, fn ($q) => $q->where(fn ($w) => $w->whereHas('book', fn ($b) => $b->where('title', 'like', "%{$this->search}%"))->orWhereHas('borrowing.member', fn ($m) => $m->where('name', 'like', "%{$this->search}%")->orWhere('member_code', 'like', "%{$this->search}%"))))
            ->when($this->filterStatus === 'overdue', fn ($q) => $q->whereHas('borrowing', fn ($b) => $b->where('due_at', '<', $today)))
            ->when($this->filterStatus === 'dueSoon', fn ($q) => $q->whereHas('borrowing', fn ($b) => $b->whereBetween('due_at', [$today, now()->addDays(3)->toDateString()])))
            ->orderByRaw('(select due_at from borrowings where borrowings.id = borrowing_details.borrowing_id) asc')
            ->paginate(10);

        $activeDetails = BorrowingDetail::with('borrowing')->where('status', 'borrowed')->get();

        return view('livewire.return-book.manager', [
            'actives' => $actives,
            'activeCount' => $activeDetails->count(),
            'activeQty' => (int) $activeDetails->sum('quantity'),
            'overdueCount' => $activeDetails->filter(fn ($d) => $d->borrowing && $d->borrowing->due_at < $today)->count(),
            'returnedToday' => (int) BorrowingDetail::where('status', 'returned')->whereDate('returned_at', $today)->sum('quantity'),
            'returnedTotal' => (int) BorrowingDetail::where('status', 'returned')->sum('quantity'),
        ])->layout('layouts.admin', [
            'active' => 'returns',
            'overdueCount' => $activeDetails->filter(fn ($d) => $d->borrowing && $d->borrowing->due_at < $today)->count(),
        ]);
    }
}