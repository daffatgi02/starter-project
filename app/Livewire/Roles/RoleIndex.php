<?php

declare(strict_types=1);

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleIndex extends Component
{
    public array $editingRole = [];
    public array $editingPermissions = [];
    public ?string $editingRoleId = null;

    public function mount(): void
    {
        $this->authorize('viewAny', \App\Models\User::class);
    }

    public function editRole(string $id): void
    {
        $role = Role::with('permissions')->findOrFail($id);
        $this->editingRoleId = $id;
        $this->editingRole = ['name' => $role->name];
        $this->editingPermissions = $role->permissions->pluck('name')->toArray();
    }

    public function updateRole(): void
    {
        $this->authorize('edit roles');

        $role = Role::findOrFail($this->editingRoleId);
        $role->syncPermissions($this->editingPermissions);

        $this->editingRoleId = null;
        $this->dispatch('toast', type: 'success', message: 'Permissions updated.');
    }

    public function cancelEdit(): void
    {
        $this->editingRoleId = null;
    }

    public function render(): mixed
    {
        return view('livewire.roles.role-index', [
            'roles' => Role::with('permissions')->get(),
            'allPermissions' => Permission::all()->groupBy(function ($p) {
                return explode(' ', $p->name)[1] ?? 'other';
            }),
        ])->layout('layouts.app');
    }
}
