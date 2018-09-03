<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('administrador', function($user){
            return $user->user_per_id == 1;
        });
        Gate::define('supervisao', function($user){
            if($user->user_per_id == 2 || $user->user_per_id == 1){
                return true;
            } else {
                return false;
            }
        });
        Gate::define('operador', function($user){
            if($user->user_per_id == 2 || $user->user_per_id == 1 || $user->user_per_id == 3){
                return true;
            } else {
                return false;
            }
        });
    }
}
