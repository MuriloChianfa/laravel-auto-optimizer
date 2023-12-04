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
    | Default: "true"
    |
    */

    'cache' => env('APP_PRODUCTION_READY', true),

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
