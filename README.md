<h1 align="center">Laravel Auto Optimizer</h1>

Automatically run Laravel optimizer commands based on specific environments.
After installing the package, the Laravel optimizer commands will be automatically executed when your application runs in specific environments. This helps ensure optimal performance and responsiveness in production environments.

![Banner](banner.svg)

## Features

- **Automatic Optimization**: Laravel optimizer commands are automatically executed when your application runs in specific environments, ensuring optimal performance.

- **Customizable Environments**: Easily configure the environments in which the optimizer commands should run, allowing flexibility for various project setups.

- **Easy to use Configuration**: The package comes with sensible defaults, making it ready to use without extensive setup.

## Installation

You can install the package via Composer:

```bash
composer require murilochianfa/laravel-auto-optimizer
```

Next, publish the configuration file:

```bash
php artisan vendor:publish --provider="MuriloChianfa\LaravelAutoOptimizer\AutoOptimizerServiceProvider"
```

### Dependencies

- *Laravel 10.0 or higher.*
- *PHP 8.2 or higher.*

## Configuration

Open the generated configuration file (config/laravel-auto-optimizer.php) and set up the environments and commands to optimize your Laravel application:

```php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Caches the optimizer runs through across environments
    |--------------------------------------------------------------------------
    |
    | Notice: use this only in production environments, you
    | can revert the cache manually running config:clear.
    |
    | Default: "false"
    |
    */

    'cache' => env('APP_PRODUCTION_READY', false),

    /*
    |--------------------------------------------------------------------------
    | Environments to auto optimize
    |--------------------------------------------------------------------------
    |
    | Define what environments are able to auto optimize caches.
    |
    | Default: "production"
    |
    */

    'optimize' => [
        'commands' => [
            'optimize',
            'view:cache',
            'event:cache',
            'route:cache',
            'config:cache',
            'storage:link',
        ],
        'environments' => [
            'production',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Environments to clear all the caches
    |--------------------------------------------------------------------------
    |
    | Define what environments is not allowed to be cached.
    |
    | Default: "local", "testing"
    |
    */

    'clear' => [
        'commands' => [
            'view:clear',
            'cache:clear',
            'event:clear',
            'route:clear',
            'config:clear',
            'clear-compiled',
            'optimize:clear',
            'schedule:clear-cache',
        ],
        'environments' => [
            'local',
            'testing',
        ],
    ],

];
```

## Commitment to Quality
During package development, try as best as possible to embrace good design and
development practices to try to ensure that this package is as good as it can
be. The checklist for package development includes:

-   ✅ Be fully PSR4 and PSR12 compliant.
-   ✅ Have no PHPCS warnings throughout all code.
-   ✅ Include comprehensive documentation in README.md.

### Testing

``` bash
composer style
```

### Security

If you discover any security related issues, please email murilo.chianfa@outlook.com instead of using the issue tracker.

## Credits

- [Murilo Chianfa](https://github.com/MuriloChianfa)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
