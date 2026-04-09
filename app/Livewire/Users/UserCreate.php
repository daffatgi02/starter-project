<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use App\Enums\UserStatus;
use App\Livewire\Base\BaseForm;
use App\Models\User;
use App\Services\UserService;

class UserCreate extends BaseForm
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $status = 'active';
    public string $role = 'user';

    public function mount(): void
    {
        $this->authorize('create', User::class);
    }

    protected function getFormRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'status' => ['required', 'in:active,inactive,suspended'],
            'role' => ['required', 'exists:roles,name'],
        ];
    }

    public function save(): void
    {
        $this->validateForm();

        app(UserService::class)->create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'status' => $this->status,
            'role' => $this->role,
        ]);

        $this->dispatchSuccess('User created successfully.');
        $this->redirect(route('users.index'));
    }

    public function render(): mixed
    {
        return view('livewire.users.user-create', [
            'statuses' => UserStatus::cases(),
            'roles' => \Spatie\Permission\Models\Role::pluck('name', 'name')->toArray(),
        ])->layout('layouts.app');
    }
}
