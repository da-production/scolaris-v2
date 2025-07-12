<?php

namespace App\Providers;

use App\Services\OptionSingleton;
use Illuminate\Support\ServiceProvider;

class OptionSingletonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(OptionSingleton::class, function () {
            return OptionSingleton::getInstance();
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
