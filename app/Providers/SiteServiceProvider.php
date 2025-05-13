<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SiteApiService;

class SiteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SiteApiService::class, function () {
            return new SiteApiService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
