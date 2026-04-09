<?php

declare(strict_types=1);

namespace App\Livewire\Base;

use App\Traits\Livewire\HasToast;
use Livewire\Component;

abstract class BaseForm extends Component
{
    use HasToast;

    public ?string $modelId = null;

    public function getIsEditingProperty(): bool
    {
        return $this->modelId !== null;
    }

    abstract protected function getFormRules(): array;

    abstract public function save(): void;

    public function resetForm(): void
    {
        $this->reset();
        $this->resetValidation();
    }

    protected function validateForm(): void
    {
        $this->validate($this->getFormRules());
    }
}
