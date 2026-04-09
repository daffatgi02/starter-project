<?php

declare(strict_types=1);

namespace App\Traits\Livewire;

trait HasConfirmDelete
{
    public ?string $confirmingDeleteId = null;

    public function confirmDelete(string $id): void
    {
        $this->confirmingDeleteId = $id;
        $this->dispatch('open-confirm-modal', itemId: $id);
    }

    public function cancelDelete(): void
    {
        $this->confirmingDeleteId = null;
    }

    public function executeDelete(): void
    {
        if ($this->confirmingDeleteId) {
            $this->performDelete($this->confirmingDeleteId);
        }

        $this->cancelDelete();
    }

    abstract protected function performDelete(string $id): void;
}
