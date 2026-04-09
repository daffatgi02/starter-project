<?php

declare(strict_types=1);

namespace App\Traits\Livewire;

trait HasToast
{
    public function dispatchSuccess(string $message): void
    {
        $this->dispatch('toast', type: 'success', message: $message);
    }

    public function dispatchError(string $message): void
    {
        $this->dispatch('toast', type: 'error', message: $message);
    }

    public function dispatchWarning(string $message): void
    {
        $this->dispatch('toast', type: 'warning', message: $message);
    }

    public function dispatchInfo(string $message): void
    {
        $this->dispatch('toast', type: 'info', message: $message);
    }
}
