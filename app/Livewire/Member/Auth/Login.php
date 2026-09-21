<?php

namespace App\Livewire\Member\Auth;

use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Login extends Component
{
    public string $member_code = '';

    public string $password = '';

    public function login()
    {
        $this->validate([
            'member_code' => 'required|string',
            'password' => 'required|min:6',
        ]);

        $member = Member::where('member_code', $this->member_code)->first();

        if (! $member) {
            $this->addError('member_code', 'Member ID tidak ditemukan.');

            return;
        }

        if (! $member->password || ! Hash::check($this->password, $member->password)) {
            $this->addError('password', 'Password salah.');

            return;
        }

        if (! $member->isActive()) {
            $this->addError('member_code', 'Akun member tidak aktif. Hubungi petugas.');

            return;
        }

        if ($member->isExpired()) {
            $this->addError('member_code', 'Masa aktif member telah kedaluwarsa. Hubungi petugas.');

            return;
        }

        Auth::guard('member')->login($member);
        session()->regenerate();

        return redirect()->intended('/member/dashboard');
    }

    public function render()
    {
        return view('livewire.member.auth.login')->layout('layouts.guest');
    }
}
