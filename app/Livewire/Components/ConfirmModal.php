<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Livewire\Attributes\On;
use Livewire\Component;

class ConfirmModal extends Component
{
    public bool $isOpen = false;

    public string $confirmingId = '';

    public string $title = 'Confirm Deletion';

    public string $message = 'Are you sure you want to delete this item? This action cannot be undone.';

    public string $confirmText = 'Delete';

    #[On('open-confirm-modal')]
    public function openModal(string $itemId = '', string $title = '', string $message = '', string $confirmText = ''): void
    {
        $this->confirmingId = $itemId;

        if ($title) {
            $this->title = $title;
        }
        if ($message) {
            $this->message = $message;
        }
        if ($confirmText) {
            $this->confirmText = $confirmText;
        }

        $this->isOpen = true;
    }

    public function confirm(): void
    {
        $this->dispatch('delete-confirmed', id: $this->confirmingId);
        $this->cancel();
    }

    public function cancel(): void
    {
        $this->isOpen = false;
        $this->confirmingId = '';
        $this->title = 'Confirm Deletion';
        $this->message = 'Are you sure you want to delete this item? This action cannot be undone.';
        $this->confirmText = 'Delete';
    }

    public function render(): mixed
    {
        return view('livewire.components.confirm-modal');
    }
}
