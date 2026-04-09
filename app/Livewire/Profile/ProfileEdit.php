<?php

declare(strict_types=1);

namespace App\Livewire\Profile;

use App\Services\UserService;
use App\Traits\Livewire\HasToast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileEdit extends Component
{
    use HasToast;
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';
    public $avatar = null;

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateProfile(UserService $userService): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
        ]);

        $userService->update(Auth::user(), [
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->dispatchSuccess('Profile updated successfully.');
    }

    public function updatePassword(): void
    {
        $this->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($this->current_password, Auth::user()->password)) {
            $this->addError('current_password', 'The current password is incorrect.');

            return;
        }

        Auth::user()->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->current_password = '';
        $this->new_password = '';
        $this->new_password_confirmation = '';
        $this->dispatchSuccess('Password updated successfully.');
    }

    public function uploadAvatar(UserService $userService): void
    {
        $this->validate([
            'avatar' => ['required', 'image', 'max:2048'],
        ]);

        $userService->uploadAvatar(Auth::user(), $this->avatar);
        $this->avatar = null;
        $this->dispatchSuccess('Avatar updated successfully.');
    }

    public function render(): mixed
    {
        return view('livewire.profile.profile-edit')
            ->layout('layouts.app');
    }
}
