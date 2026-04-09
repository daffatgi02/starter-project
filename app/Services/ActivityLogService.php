<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
    public static function log(
        string $event,
        ?Model $subject = null,
        ?string $description = null,
        array $properties = []
    ): ActivityLog {
        return ActivityLog::create([
            'user_id' => Auth::id(),
            'event' => $event,
            'subject_type' => $subject ? $subject->getMorphClass() : null,
            'subject_id' => $subject?->getKey(),
            'description' => $description,
            'properties' => $properties,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    public static function logAuth(string $event, User $user): void
    {
        ActivityLog::create([
            'user_id' => $user->id,
            'event' => $event,
            'subject_type' => $user->getMorphClass(),
            'subject_id' => $user->id,
            'description' => ucfirst($event) . ' event',
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
