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
        Gate::define('see-agent',function(User $user, $agentSite,$userSite){
            return $user->vision >= 2 || $userSite == $agentSite;
        });
        
        Gate::define('manage-users',function(User $user){
            return $user->vision == 3;
        });
    }

    
}
