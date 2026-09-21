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
            'new_password' => 'required|min:6|confirmed',
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
        return view('livewire.member.profile', [
            'member' => Auth::guard('member')->user(),
        ])->layout('layouts.member');
    }
}
