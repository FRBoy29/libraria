<?php

namespace App\Livewire\Member;

use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

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

    public function export()
    {
        $member = Auth::guard('member')->user();
        $rows = $this->historyQuery($member->id)->limit(500)->get();
        $name = 'riwayat-sirkulasi-' . $member->member_code . '-' . now()->format('Ymd') . '.pdf';

        $pdf = new \Dompdf\Dompdf(['isRemoteEnabled' => false]);
        $pdf->loadHtml(view('exports.member-history', [
            'member' => $member,
            'rows' => $rows,
            'date' => now(),
        ])->render());
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        return response()->streamDownload(
            fn () => print($pdf->output()),
            $name,
            ['Content-Type' => 'application/pdf']
        );
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
            ->pluck('returned_at')
            ->map(fn ($d) => \Carbon\Carbon::parse($d)->year)
            ->unique()->sortDesc()->values();

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