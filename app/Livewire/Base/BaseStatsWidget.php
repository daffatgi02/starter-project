<?php

declare(strict_types=1);

namespace App\Livewire\Base;

use Livewire\Component;

abstract class BaseStatsWidget extends Component
{
    /** @return array<int, array{title: string, value: string|int, icon: string, change: string|null, changeType: string, color: string}> */
    abstract protected function getStats(): array;

    public function render(): mixed
    {
        return view('livewire.base.stats-widget', [
            'stats' => $this->getStats(),
        ]);
    }
}
