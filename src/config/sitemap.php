<?php
    return [
        // prefix to configurate url to sitemap
        'route_prefix' => env('BACKEND_URL', 'backend'),
        'route_as' => 'backend.',
        'filesystem_driver' => 'public',
        'route_middleware' => [],
        'locales' => [
            'en'
        ],

        'dynamic_url_classes' => [

        ],

        'static_routes' => [

        ],
    ];