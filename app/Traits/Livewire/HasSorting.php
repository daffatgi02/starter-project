<?php

declare(strict_types=1);

namespace App\Traits\Livewire;

use Illuminate\Database\Eloquent\Builder;

trait HasSorting
{
    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'desc';
        }
    }

    public function applySorting(Builder $query): Builder
    {
        return $query->orderBy($this->sortField, $this->sortDirection);
    }
}
