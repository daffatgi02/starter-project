<?php

declare(strict_types=1);

namespace App\Traits\Livewire;

trait HasBulkActions
{
    public array $selected = [];

    public bool $selectAll = false;

    public function toggleSelectAll(): void
    {
        if ($this->selectAll) {
            $this->selected = $this->rows->pluck('id')->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function updatedSelected(): void
    {
        $this->selectAll = false;
    }

    public function clearSelection(): void
    {
        $this->selected = [];
        $this->selectAll = false;
    }

    public function getSelectedCountProperty(): int
    {
        return count($this->selected);
    }
}
