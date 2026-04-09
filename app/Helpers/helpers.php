<?php

declare(strict_types=1);

namespace App\Helpers;

use Carbon\Carbon;

if (! function_exists('format_date')) {
    function format_date(Carbon|string $date, string $format = 'd M Y'): string
    {
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        return $date->format($format);
    }
}

if (! function_exists('format_datetime')) {
    function format_datetime(Carbon|string $date, string $format = 'd M Y, H:i'): string
    {
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        return $date->format($format);
    }
}

if (! function_exists('format_relative')) {
    function format_relative(Carbon|string $date): string
    {
        if (is_string($date)) {
            $date = Carbon::parse($date);
        }

        return $date->diffForHumans();
    }
}
