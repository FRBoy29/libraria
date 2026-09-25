<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public string $name = '';

    public string $email = '';

    public string $current_password = '';

    public string $new_password = '';

    public string $new_password_confirmation = '';

    public $photoUpload = null;

    public function mount(): void
    {
        $user = Auth::guard('web')->user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function saveProfile()
    {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::guard('web')->id(),
        ]);

        Auth::guard('web')->user()->update($data);
        session()->flash('success', 'Profil diperbarui.');
    }

    public function savePhoto()
    {
        $this->validate([
            'photoUpload' => 'required|image|max:2048',
        ]);

        $user = Auth::guard('web')->user();

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->update([
            'photo' => $this->photoUpload->store('photos', 'public'),
        ]);
        $this->reset('photoUpload');
        session()->flash('success', 'Foto profil diperbarui.');
    }

    public function removePhoto()
    {
        $user = Auth::guard('web')->user();

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
            $user->update(['photo' => null]);
            session()->flash('success', 'Foto profil dihapus.');
        }
    }

    public function changePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::guard('web')->user();

        if (! Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Password saat ini salah.');

            return;
        }

        $user->update(['password' => $this->new_password]);
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        session()->flash('success', 'Password diganti.');
    }

    public function render()
    {
        return view('livewire.admin.profile', [
            'user' => Auth::guard('web')->user()->fresh(),
        ])->layout('layouts.admin', [
            'active' => '',
            'overdueCount' => \App\Models\Borrowing::where('status', 'borrowed')->where('due_at', '<', now()->toDateString())->count(),
        ]);
    }
}
