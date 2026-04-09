<?php

declare(strict_types=1);

namespace App\Livewire\ActivityLogs;

use App\Models\ActivityLog;
use App\Traits\Livewire\HasFilters;
use App\Traits\Livewire\HasSorting;
use Livewire\Component;

class ActivityLogIndex extends Component
{
    use HasFilters;
    use HasSorting;

    public function mount(): void
    {
        $this->authorize('view activity-logs');
    }

    public function render(): mixed
    {
        $query = ActivityLog::query()->with('user');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('event', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%")
                  ->orWhereHas('user', fn ($uq) => $uq->where('name', 'like', "%{$this->search}%"));
            });
        }

        $query = $this->applySorting($query);

        return view('livewire.activity-logs.activity-log-index', [
            'logs' => $query->paginate($this->perPage),
        ])->layout('layouts.app');
    }
}
