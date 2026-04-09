<?php

declare(strict_types=1);

namespace App\Livewire\Users;

use App\Enums\UserStatus;
use App\Livewire\Base\BaseDataTable;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

class UserIndex extends BaseDataTable
{
    public function mount(): void
    {
        $this->authorize('viewAny', User::class);
    }

    protected function getQuery(): Builder
    {
        return User::query()
            ->with('roles')
            ->withCount('activityLogs');
    }

    public function applyFilters(Builder $query): Builder
    {
        if ($this->search) {
            $query->where(function (Builder $q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%");
            });
        }

        if (! empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (! empty($this->filters['role'])) {
            $query->role($this->filters['role']);
        }

        return $query;
    }

    #[On('delete-confirmed')]
    public function handleDeleteConfirmed(string $id): void
    {
        $this->executeDeleteById($id);
    }

    protected function executeDeleteById(string $id): void
    {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);

        app(UserService::class)->delete($user);
        $this->dispatchSuccess('User deleted successfully.');
    }

    protected function performDelete(string $id): void
    {
        $this->executeDeleteById($id);
    }

    public function bulkDelete(): void
    {
        $users = User::whereIn('id', $this->selected)->get();

        foreach ($users as $user) {
            if (auth()->id() !== $user->id) {
                app(UserService::class)->delete($user);
            }
        }

        $this->clearSelection();
        $this->dispatchSuccess('Selected users deleted.');
    }

    protected function getView(): string
    {
        return 'livewire.users.user-index';
    }

    public function render(): mixed
    {
        return view($this->getView(), [
            'rows' => $this->rows,
            'statuses' => UserStatus::cases(),
            'roles' => \Spatie\Permission\Models\Role::pluck('name', 'name')->toArray(),
        ])->layout('layouts.app');
    }
}
