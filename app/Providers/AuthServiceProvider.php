<?php

namespace App\Providers;

use App\Models\Agent;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Keep the existing gate for backward compatibility
        Gate::define('see-agent',function(User $user,$site){
            return $user->vision >= 2 || $user->site == $site;
        });

        Gate::define('see-site',function(User $user){
            return $user->vision == 3;
        });

        Gate::define('manage-users',function(User $user){
            return $user->vision == 3;
        });
    }

    
}
