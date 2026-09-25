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

    public function mount(): void
    {
        $this->borrowed_at = now()->format('Y-m-d');
        $this->due_at = now()->addDays(7)->format('Y-m-d');

        $preselect = request('member');
        if (is_string($preselect) && $preselect !== '' && Member::where('id', $preselect)->exists()) {
            $this->member_id = $preselect;
        }
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

        session()->flash('success', 'Peminjaman disimpan, stok berkurang.');
        $this->reset(['member_id', 'book_id', 'quantity']);
        $this->quantity = 1;
    }

    public function render()
    {
        $borrowings = Borrowing::with(['member', 'details.book'])
            ->orderBy('id', 'desc')->paginate(10);

        return view('livewire.borrowing.manager', [
            'borrowings' => $borrowings,
            'members' => Member::where('status', 'active')->orderBy('name')->get(),
            'books' => Book::where('stock', '>', 0)->orderBy('title')->get(),
        ])->layout('layouts.app');
    }
}
