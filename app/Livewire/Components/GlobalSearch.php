<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Models\User;
use Livewire\Component;

class GlobalSearch extends Component
{
    public string $query = '';

    public array $results = [];

    public function updatedQuery(): void
    {
        if (strlen($this->query) < 2) {
            $this->results = [];

            return;
        }

        $this->search();
    }

    public function search(): void
    {
        $this->results = User::query()
            ->where('name', 'like', "%{$this->query}%")
            ->orWhere('email', 'like', "%{$this->query}%")
            ->limit(5)
            ->get()
            ->map(fn (User $user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'type' => 'User',
                'url' => route('users.index'),
            ])
            ->toArray();
    }

    public function clear(): void
    {
        $this->query = '';
        $this->results = [];
    }

    public function render(): mixed
    {
        return view('livewire.components.global-search');
    }
}
