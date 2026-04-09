<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Livewire\Attributes\On;
use Livewire\Component;

class FlashToast extends Component
{
    public array $toasts = [];

    #[On('toast')]
    public function addToast(string $type, string $message): void
    {
        $id = uniqid('toast_');

        $this->toasts[] = [
            'id' => $id,
            'type' => $type,
            'message' => $message,
        ];

        $this->dispatch('toast-added', id: $id);
    }

    public function removeToast(string $id): void
    {
        $this->toasts = array_values(
            array_filter($this->toasts, fn (array $toast) => $toast['id'] !== $id)
        );
    }

    public function render(): mixed
    {
        return view('livewire.components.flash-toast');
    }
}
