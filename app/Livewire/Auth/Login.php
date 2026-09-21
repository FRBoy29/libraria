<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';

    public string $password = '';

    public function login()
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (! Auth::attempt($credentials)) {
            $this->addError('email', 'Email atau password salah.');
            return;
        }

        session()->regenerate();

        return redirect()->intended('/admin/dashboard');
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.guest');
    }
}
