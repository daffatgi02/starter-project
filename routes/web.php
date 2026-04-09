<?php

declare(strict_types=1);

use App\Livewire\ActivityLogs\ActivityLogIndex;
use App\Livewire\Dashboard\DashboardIndex;
use App\Livewire\Profile\ProfileEdit;
use App\Livewire\Roles\RoleIndex;
use App\Livewire\Settings\SettingIndex;
use App\Livewire\Users\UserCreate;
use App\Livewire\Users\UserEdit;
use App\Livewire\Users\UserIndex;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardIndex::class)->name('dashboard');

    Route::get('users', UserIndex::class)->name('users.index');
    Route::get('users/create', UserCreate::class)->name('users.create');
    Route::get('users/{user}/edit', UserEdit::class)->name('users.edit');

    Route::get('roles', RoleIndex::class)->name('roles.index');

    Route::get('settings', SettingIndex::class)->name('settings.index');

    Route::get('activity-logs', ActivityLogIndex::class)->name('activity-logs.index');

    Route::get('profile', ProfileEdit::class)->name('profile.edit');
});

require __DIR__ . '/auth.php';
