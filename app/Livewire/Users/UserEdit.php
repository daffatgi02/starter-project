<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use App\Enums\UserStatus;
use App\Livewire\Base\BaseForm;
use App\Models\User;
use App\Services\UserService;

class UserEdit extends BaseForm
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $status = 'active';
    public string $role = 'user';

    public function mount(User $user): void
    {
        $this->authorize('update', $user);

        $this->modelId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->status = $user->status->value;
        $this->role = $user->roles->first()?->name ?? 'user';
    }

    protected function getFormRules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', "unique:users,email,{$this->modelId}"],
            'status' => ['required', 'in:active,inactive,suspended'],
            'role' => ['required', 'exists:roles,name'],
        ];

        if ($this->password) {
            $rules['password'] = ['string', 'min:8', 'confirmed'];
        }

        return $rules;
    }

    public function save(): void
    {
        $this->validateForm();

        $user = User::findOrFail($this->modelId);

        app(UserService::class)->update($user, [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password ?: null,
            'status' => $this->status,
            'role' => $this->role,
        ]);

        $this->dispatchSuccess('User updated successfully.');
        $this->redirect(route('users.index'));
    }

    public function render(): mixed
    {
        return view('livewire.users.user-edit', [
            'statuses' => UserStatus::cases(),
            'roles' => \Spatie\Permission\Models\Role::pluck('name', 'name')->toArray(),
        ])->layout('layouts.app');
    }
}
