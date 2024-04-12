<?php

namespace App\Providers;

use Ably\AblyRest;
use Illuminate\Support\ServiceProvider;

class AblyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(AblyRest::class, function ($app){
            return new AblyRest(config('services.ably.key'));
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
