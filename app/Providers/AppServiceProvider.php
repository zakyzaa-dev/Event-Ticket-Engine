<?php

namespace App\Providers;

use App\Services\Implementations\AuthService;
use App\Services\Implementations\EventService;
use App\Services\Interfaces\IAuthService;
use App\Services\Interfaces\IEventService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IEventService::class, EventService::class);
        $this->app->bind(IAuthService::class, AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
