<?php
    return [
        // prefix to configurate url to sitemap
        'route_prefix' => env('BACKEND_URL', 'backend'),

        // config for route prefix
        'route_as' => 'backend.',

        //driver for sitemap.xml
        'filesystem_driver' => 'public',

        // routes middleware
        'route_middleware' => ['web'],

        // locales to multi-language urls
        'locales' => [
            'en'
        ],

        /**
         * to use feature your model have to use trait Sitemap
         * or release method getUrls where you return array with prepared URL's for siteMap
         */
        'dynamic_url_classes' => [

        ],

        // Route names for siteMap
        'static_routes' => [

        ],
    ];