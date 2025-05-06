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
        Gate::define('see-agent',function(User $user,Agent $agent){
            return $user->vision == 2 || $user->site == $agent->site;
        });

        Gate::define('see-site',function(User $user){
            return $user->vision == 3;
        });

        Gate::define('manage-users',function(User $user){
            return $user->vision == 3;
        });
    }

    
}
