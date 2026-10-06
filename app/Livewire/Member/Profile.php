<?php

namespace App\Livewire\Member;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Profile extends Component
{
    public string $email = '';

    public string $phone = '';

    public string $address = '';

    public string $current_password = '';

    public string $new_password = '';

    public string $new_password_confirmation = '';

    public function mount(): void
    {
        $m = Auth::guard('member')->user();
        $this->email = $m->email;
        $this->phone = $m->phone ?? '';
        $this->address = $m->address ?? '';
    }

    public function saveProfile()
    {
        $data = $this->validate([
            'email' => 'required|email|unique:members,email,' . Auth::guard('member')->id(),
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
        ]);

        Auth::guard('member')->user()->update([
            'email' => $data['email'],
            'phone' => $this->phone ?: null,
            'address' => $this->address ?: null,
        ]);

        session()->flash('success', 'Profil diperbarui.');
    }

    public function changePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $member = Auth::guard('member')->user();

        if (! $member->password || ! Hash::check($this->current_password, $member->password)) {
            $this->addError('current_password', 'Password saat ini salah.');

            return;
        }

        $member->update(['password' => $this->new_password]);
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        session()->flash('success', 'Password diganti.');
    }

    public function render()
    {
        $memberId = Auth::guard('member')->id();
        $borrowingIds = \App\Models\Borrowing::where('member_id', $memberId)->pluck('id');
        $overdueCount = \App\Models\Borrowing::where('member_id', $memberId)
            ->where('status', 'borrowed')
            ->whereDate('due_at', '<', now()->toDateString())
            ->count();

        return view('livewire.member.profile', [
            'member' => Auth::guard('member')->user(),
            'activeQty' => (int) \App\Models\BorrowingDetail::whereIn('borrowing_id', $borrowingIds)->where('status', 'borrowed')->sum('quantity'),
            'historyQty' => (int) \App\Models\BorrowingDetail::whereIn('borrowing_id', $borrowingIds)->where('status', 'returned')->sum('quantity'),
            'overdueCount' => $overdueCount,
        ])->layout('layouts.member', ['nav' => 'profile', 'overdueCount' => $overdueCount]);
    }

    public function downloadCard()
    {
        $member = Auth::guard('member')->user();

        $pdf = new \Dompdf\Dompdf(['isRemoteEnabled' => false]);
        $pdf->loadHtml(view('exports.member-card', [
            'member' => $member,
            'date' => now(),
        ])->render());
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'kartu-anggota-' . $member->member_code . '.pdf',
            ['Content-Type' => 'application/pdf']
        );
    }
}
