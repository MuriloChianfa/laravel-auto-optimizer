<?php

declare(strict_types=1);

namespace MuriloChianfa\LaravelAutoOptimizer;

use Artisan;
use Illuminate\Support\Facades\Storage;

/**
 * Main functions for auto optimizer.
 *
 * @method handle
 */
final class AutoOptimizer
{
    /** @var string LOCK_FILE Lock file to controll the auto optimizer execution. */
    const LOCK_FILE = 'auto-optimizer.lock';

    /** @var string LOCK_PATH Path to file of auto optimizer for specific environment. */
    const LOCK_PATH = 'auto-optimizer.';

    /** @var string $lock The lock file of specific environment. */
    private static $lock;

    /**
     * Load all commands to block.
     *
     * @return void
     * @static
     */
    public static function handle(): void
    {
        if (Storage::exists(self::LOCK_FILE)) {
            return;
        }

        if (config('auto-optimizer.cache')) {
            self::$lock = self::LOCK_PATH . config('app.env');

            if (Storage::exists(self::$lock)) {
                return;
            }
        }

        Storage::put(self::LOCK_FILE, now());

        Artisan::call('config:clear');
        self::$lock = self::LOCK_PATH . config('app.env');

        if (Storage::exists(self::$lock)) {
            if (config('app.env') === 'production') {
                Artisan::call('config:cache');
            }

            Storage::delete(self::LOCK_FILE);
            return;
        }

        self::clearLockEnvironments();

        if (in_array(config('app.env'), config('auto-optimizer.clear.environments'))) {
            $commands = array_values(config('auto-optimizer.clear.commands'));

            // Runs a second time to clear compileds too
            self::run($commands);
        }

        if (in_array(config('app.env'), config('auto-optimizer.optimize.environments'))) {
            $commands = array_values(config('auto-optimizer.optimize.commands'));
        }

        self::run($commands);
        self::lock();
        Storage::delete(self::LOCK_FILE);
    }

    /**
     * Execute environment commands.
     *
     * @param array $commands
     * @return void
     * @static
     */
    private static function run(array $commands): void
    {
        foreach ($commands as $command) {
            Artisan::call($command);
        }
    }

    /**
     * Lock environment from auto optimiztion flood.
     *
     * @return void
     * @static
     */
    private static function lock(): void
    {
        Storage::put('auto-optimizer.' . config('app.env'), now());
    }

    /**
     * Clear auto optimization locks for all configured environments.
     *
     * @return void
     * @static
     */
    private static function clearLockEnvironments(): void
    {
        foreach (self::allEnvironments() as $environment) {
            Storage::delete(self::LOCK_PATH . $environment);
        }
    }

    /**
     * Gets all environments for auto optimizations.
     *
     * @return array
     * @static
     */
    private static function allEnvironments(): array
    {
        return [
            ...array_values(config('auto-optimizer.clear.environments')),
            ...array_values(config('auto-optimizer.optimize.environments')),
        ];
    }
}
