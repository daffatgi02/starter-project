<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    public function boot(): void
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        Model::shouldBeStrict(! app()->isProduction());
        Paginator::useTailwind();

        // Multi-timezone hook: will read auth()->user()->timezone if set
        // date_default_timezone_set(auth()->user()?->timezone ?? config('app.timezone'));
    }
}
