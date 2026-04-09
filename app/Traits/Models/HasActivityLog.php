<?php

declare(strict_types=1);

namespace App\Traits\Models;

use App\Services\ActivityLogService;

trait HasActivityLog
{
    public bool $disableActivityLog = false;

    public static function bootHasActivityLog(): void
    {
        static::created(function ($model) {
            if (! $model->disableActivityLog) {
                ActivityLogService::log('created', $model, 'Record created', [
                    'attributes' => $model->getLogAttributes(),
                ]);
            }
        });

        static::updated(function ($model) {
            if (! $model->disableActivityLog) {
                $changes = $model->getLogChanges();
                if (! empty($changes)) {
                    ActivityLogService::log('updated', $model, 'Record updated', $changes);
                }
            }
        });

        static::deleted(function ($model) {
            if (! $model->disableActivityLog) {
                ActivityLogService::log('deleted', $model, 'Record deleted', [
                    'attributes' => $model->getLogAttributes(),
                ]);
            }
        });
    }

    protected function getLogAttributes(): array
    {
        $attributes = property_exists($this, 'logAttributes')
            ? $this->logAttributes
            : [];

        if (empty($attributes)) {
            return [];
        }

        return collect($attributes)
            ->mapWithKeys(fn (string $attr) => [$attr => $this->getAttribute($attr)])
            ->toArray();
    }

    protected function getLogChanges(): array
    {
        $attributes = property_exists($this, 'logAttributes')
            ? $this->logAttributes
            : [];

        if (empty($attributes)) {
            return [];
        }

        $changes = $this->getDirty();
        $tracked = array_intersect_key($changes, array_flip($attributes));

        if (empty($tracked)) {
            return [];
        }

        return [
            'old' => collect($tracked)
                ->keys()
                ->mapWithKeys(fn (string $attr) => [$attr => $this->getOriginal($attr)])
                ->toArray(),
            'new' => $tracked,
        ];
    }
}
