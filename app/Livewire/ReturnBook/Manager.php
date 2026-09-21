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

    public function returnDetail(int $detailId)
    {
        $detail = BorrowingDetail::with(['book', 'borrowing'])->findOrFail($detailId);

        if ($detail->status === 'returned') {
            session()->flash('error', 'Double return ditolak: sudah dikembalikan.');
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

        session()->flash('success', 'Pengembalian berhasil, stok bertambah.');
    }

    public function render()
    {
        $actives = BorrowingDetail::with(['book', 'borrowing.member'])
            ->where('status', 'borrowed')->orderBy('id', 'desc')->paginate(10);

        return view('livewire.return-book.manager', ['actives' => $actives])->layout('layouts.app');
    }
}
