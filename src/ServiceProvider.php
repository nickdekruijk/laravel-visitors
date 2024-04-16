<?php

namespace NickDeKruijk\LaravelVisitors;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/visitors.php' => config_path('visitors.php'),
        ], 'config');

        if (config('visitors.migrations')) {
            $this->loadMigrationsFrom(__DIR__ . '/../migrations');
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'visitors');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/visitors.php', 'visitors');

        // Register the main class to use with the facade
        $this->app->singleton('visitors', function () {
            return new Visitors;
        });
    }
}
