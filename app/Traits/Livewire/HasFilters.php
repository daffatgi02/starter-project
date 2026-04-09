<?php

declare(strict_types=1);

namespace App\Traits\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

trait HasFilters
{
    use WithPagination;

    public array $filters = [];

    public string $search = '';

    public int $perPage = 15;

    public function resetFilters(): void
    {
        $this->search = '';
        $this->filters = [];
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilters(): void
    {
        $this->resetPage();
    }

    public function applyFilters(Builder $query): Builder
    {
        return $query;
    }
}
