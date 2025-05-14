<?php

namespace App\Providers;

use App\Models\Agent;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

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
        Gate::define('see-agent',function(User $user, $agent){
            return $user->vision >= 2;
        });

        Gate::define('see-site',function(User $user){
            return $user->vision == 3;
        });

        Gate::define('manage-users',function(User $user){
            return $user->vision == 3;
        });
    }

    
}
