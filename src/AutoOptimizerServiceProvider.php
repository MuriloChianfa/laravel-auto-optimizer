<?php

declare(strict_types=1);

namespace MuriloChianfa\LaravelAutoOptimizer;

use Illuminate\Support\ServiceProvider;
use MuriloChianfa\LaravelAutoOptimizer\AutoOptimizer;

/**
 * Provide a basic package configuration.
 *
 * @method boot
 * @method register
 */
final class AutoOptimizerServiceProvider extends ServiceProvider
{
    const PACKAGE_CONFIG = 'config/auto-optimizer.php';
    const CONFIG_PATH = __DIR__ . '/../' . self::PACKAGE_CONFIG;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                self::CONFIG_PATH => base_path(self::PACKAGE_CONFIG),
            ], 'config');
        }

        AutoOptimizer::handle();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(self::CONFIG_PATH, 'auto-optimizer');
    }
}
