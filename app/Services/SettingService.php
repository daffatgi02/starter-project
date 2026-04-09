<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    public function get(string $key, mixed $default = null): mixed
    {
        $cacheKey = "settings.{$key}";

        return Cache::store('array')->remember($cacheKey, 60, function () use ($key, $default) {
            return Setting::get($key, $default);
        });
    }

    public function set(string $key, mixed $value): void
    {
        Setting::set($key, $value);
        Cache::store('array')->forget("settings.{$key}");
    }

    public function getGroup(string $group): Collection
    {
        return Setting::where('group', $group)->get();
    }

    public function setMany(array $settings): void
    {
        foreach ($settings as $key => $value) {
            $this->set($key, $value);
        }
    }
}
