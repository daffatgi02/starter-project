<?php

declare(strict_types=1);

namespace App\Livewire\Base;

use App\Traits\Livewire\HasToast;
use Livewire\Component;

abstract class BaseModal extends Component
{
    use HasToast;

    public bool $isOpen = false;

    public function open(mixed ...$params): void
    {
        $this->isOpen = true;
        $this->onOpen(...$params);
    }

    public function close(): void
    {
        $this->isOpen = false;
        $this->onClose();
    }

    protected function onOpen(mixed ...$params): void
    {
        // Override in subclass
    }

    protected function onClose(): void
    {
        // Override in subclass
    }
}
