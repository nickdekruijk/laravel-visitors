<?php

namespace NickDeKruijk\LaravelVisitors;

use Illuminate\Support\Facades\Blade;

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

        Blade::directive('trackvisit', function () {
            return '<script>laravel_visitors = {route:"<?php echo route(\'laravel-visitors.post\') ?>",csrf:"<?php echo csrf_token() ?>"}</script>';
        });

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
    }
}
