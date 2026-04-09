<?php

declare(strict_types=1);

namespace App\Livewire\Dashboard;

use App\Livewire\Base\BaseStatsWidget;
use App\Models\ActivityLog;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DashboardIndex extends BaseStatsWidget
{
    protected function getStats(): array
    {
        return [
            [
                'title' => 'Total Users',
                'value' => User::count(),
                'icon' => 'users',
                'color' => 'primary',
                'change' => null,
                'changeType' => 'neutral',
            ],
            [
                'title' => 'Active Users',
                'value' => User::where('status', 'active')->count(),
                'icon' => 'check-circle',
                'color' => 'green',
                'change' => null,
                'changeType' => 'neutral',
            ],
            [
                'title' => 'Roles',
                'value' => Role::count(),
                'icon' => 'shield-check',
                'color' => 'purple',
                'change' => null,
                'changeType' => 'neutral',
            ],
            [
                'title' => 'Activity Logs',
                'value' => ActivityLog::count(),
                'icon' => 'clipboard-document-list',
                'color' => 'blue',
                'change' => null,
                'changeType' => 'neutral',
            ],
        ];
    }

    public function render(): mixed
    {
        return view('livewire.dashboard.dashboard-index', [
            'stats' => $this->getStats(),
        ])->layout('layouts.app');
    }
}
