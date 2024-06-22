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

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

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
        $this->app->singleton('visitors', function () {
            return new Visitors;
        });
    }
}
