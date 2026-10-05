<?php

namespace App\Livewire\Member;

use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Activity extends Component
{
    use WithPagination;

    public string $tab = 'active';

    public string $search = '';

    public string $year = '';

    public string $statusFilter = '';

    public function setTab(string $tab): void
    {
        $this->tab = $tab === 'history' ? 'history' : 'active';
        $this->resetPage();
    }

    public function updated($property): void
    {
        if (in_array($property, ['search', 'year', 'statusFilter'], true)) {
            $this->resetPage('historyPage');
        }
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'year', 'statusFilter']);
        $this->resetPage('historyPage');
    }

    public function export(): StreamedResponse
    {
        $member = Auth::guard('member')->user();
        $rows = $this->historyQuery($member->id)->limit(500)->get();
        $name = 'riwayat-sirkulasi-' . $member->member_code . '-' . now()->format('Ymd') . '.csv';

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Judul', 'Penulis', 'ISBN', 'Tanggal Pinjam', 'Jatuh Tempo', 'Tanggal Kembali', 'Status', 'Jumlah']);
            foreach ($rows as $d) {
                $returned = $d->returned_at ? Carbon::parse($d->returned_at)->toDateString() : '';
                $due = $d->borrowing?->due_at;
                $status = $returned !== '' && $due && $returned > $due
                    ? 'Terlambat ' . Carbon::parse($due)->diffInDays($returned) . ' hari'
                    : 'Tepat waktu';
                fputcsv($out, [
                    $d->book->title ?? '-', $d->book->author ?? '-', $d->book->isbn ?? '-',
                    $d->borrowing?->borrowed_at, $due, $d->returned_at, $status, $d->quantity,
                ]);
            }
            fclose($out);
        }, $name, ['Content-Type' => 'text/csv']);
    }

    protected function historyQuery(int $memberId)
    {
        $borrowingIds = Borrowing::where('member_id', $memberId)->pluck('id');

        return BorrowingDetail::with(['book', 'borrowing'])
            ->whereIn('borrowing_id', $borrowingIds)
            ->where('status', 'returned')
            ->when($this->search, fn ($q) => $q->where(fn ($w) => $w
                ->whereHas('book', fn ($b) => $b
                    ->where('title', 'like', "%{$this->search}%")
                    ->orWhere('author', 'like', "%{$this->search}%")
                    ->orWhere('isbn', 'like', "%{$this->search}%"))))
            ->when($this->year, fn ($q) => $q->whereYear('returned_at', $this->year))
            ->when($this->statusFilter === 'ontime', fn ($q) => $q->whereRaw('DATE(returned_at) <= (select due_at from borrowings where borrowings.id = borrowing_details.borrowing_id)'))
            ->when($this->statusFilter === 'late', fn ($q) => $q->whereRaw('DATE(returned_at) > (select due_at from borrowings where borrowings.id = borrowing_details.borrowing_id)'))
            ->orderByDesc('returned_at');
    }

    public function render()
    {
        $member = Auth::guard('member')->user();
        $today = now()->toDateString();

        $activeDetails = BorrowingDetail::with(['book.category', 'borrowing'])
            ->whereIn('borrowing_id', Borrowing::where('member_id', $member->id)->pluck('id'))
            ->where('status', 'borrowed')
            ->orderBy('id', 'desc')
            ->get();

        $activeQty = (int) $activeDetails->sum('quantity');
        $activeCount = Borrowing::where('member_id', $member->id)->where('status', 'borrowed')->count();
        $overdueCount = Borrowing::where('member_id', $member->id)
            ->where('status', 'borrowed')->whereDate('due_at', '<', $today)->count();
        $historyQty = (int) BorrowingDetail::whereIn(
            'borrowing_id', Borrowing::where('member_id', $member->id)->pluck('id')
        )->where('status', 'returned')->sum('quantity');

        $nearest = Borrowing::where('member_id', $member->id)
            ->where('status', 'borrowed')->orderBy('due_at')->first();

        $history = $this->historyQuery($member->id)->paginate(8, ['*'], 'historyPage');
        $years = BorrowingDetail::whereIn(
            'borrowing_id', Borrowing::where('member_id', $member->id)->pluck('id')
        )->where('status', 'returned')->whereNotNull('returned_at')
            ->selectRaw('YEAR(returned_at) y')->distinct()->orderByDesc('y')->pluck('y');

        return view('livewire.member.activity', [
            'activeDetails' => $activeDetails,
            'activeQty' => $activeQty,
            'activeCount' => $activeCount,
            'overdueCount' => $overdueCount,
            'historyQty' => $historyQty,
            'nearest' => $nearest,
            'history' => $history,
            'years' => $years,
        ])->layout('layouts.member', ['nav' => 'activity', 'overdueCount' => $overdueCount]);
    }
}