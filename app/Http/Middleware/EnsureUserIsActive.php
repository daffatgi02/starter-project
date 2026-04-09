<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\UserStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return $next($request);
        }

        if ($request->user()->status !== UserStatus::Active) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Your account is not active.',
                ], 403);
            }

            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'Your account is not active. Please contact support.');
        }

        return $next($request);
    }
}
