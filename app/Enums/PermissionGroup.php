<?php

declare(strict_types=1);

namespace App\Enums;

enum PermissionGroup: string
{
    case Users = 'users';
    case Roles = 'roles';
    case Settings = 'settings';
    case ActivityLogs = 'activity-logs';
    case Media = 'media';
}
