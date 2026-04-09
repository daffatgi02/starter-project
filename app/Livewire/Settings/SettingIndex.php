<?php

declare(strict_types=1);

namespace App\Livewire\Settings;

use App\Services\SettingService;
use App\Traits\Livewire\HasToast;
use Livewire\Component;

class SettingIndex extends Component
{
    use HasToast;

    public array $formData = [];

    public function mount(SettingService $settingService): void
    {
        $this->authorize('view settings');

        $settings = $settingService->getGroup('general');

        foreach ($settings as $setting) {
            $this->formData[$setting->key] = $setting->value;
        }

        if (empty($this->formData)) {
            $this->formData = [
                'site_name' => config('app.name'),
                'site_description' => '',
                'maintenance_mode' => '0',
            ];
        }
    }

    public function save(SettingService $settingService): void
    {
        $this->authorize('edit settings');

        $settingService->setMany($this->formData);
        $this->dispatchSuccess('Settings saved successfully.');
    }

    public function render(): mixed
    {
        return view('livewire.settings.setting-index')
            ->layout('layouts.app');
    }
}
