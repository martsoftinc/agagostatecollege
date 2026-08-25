<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;




class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
       \App\Models\LessonPlan::class => \App\Policies\LessonPlanPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Register the admin guard
        Auth::extend('admin', function ($app, $name, array $config) {
            return new \App\Guards\AdminGuard(
                Auth::createUserProvider($config['provider']),
                $app->make('request')
            );
        });
     
        // Register the user guard
        Auth::extend('user', function ($app, $name, array $config) {
            return new \App\Guards\ModeratorGuard(
                Auth::createUserProvider($config['provider']),
                $app->make('request')
            );
        });


                // Register the user guard
        Auth::extend('teacher', function ($app, $name, array $config) {
            return new \App\Guards\ModeratorGuard(
                Auth::createUserProvider($config['provider']),
                $app->make('request')
            );
        });

         // Register the user guard
        Auth::extend('verify', function ($app, $name, array $config) {
            return new \App\Guards\ModeratorGuard(
                Auth::createUserProvider($config['provider']),
                $app->make('request')
            );
        });

        

        
    }

}