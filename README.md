# Laravel SiteMap

It's a test package for Laravel that implements site map functionality.

## Installing

```
composer require hantu/sitemap
```

After updating composer, add the service provider to the providers array in config/app.php

```
Hantu\Sitemap\Providers\SiteMapServiceProvider::class
```

Publish migrations and css-styles:

```
php artisan vendor:publish --tag=sitemap-migrations
php artisan vendor:publish --tag=sitemap-styles
```

## Optional Features

```
        // prefix to configurate url to sitemap
        'route_prefix' => env('BACKEND_URL', 'backend'),

        // config for route prefix
        'route_as' => 'backend.',

        //driver for sitemap.xml
        'filesystem_driver' => 'public',

        // routes middleware
        'route_middleware' => ['web'],

        /**
         * to use feature your model have to use trait Sitemap
         * or release method getUrls where you return array with prepared URL's for siteMap
         * and add class to this array as in the example below 
         */
        'dynamic_url_classes' => [
            \App\Models\Pages::class
        ],

        // Route names for siteMap
        'static_routes' => [

        ],
```

## How to use?

```
<?php

class Pages extends Model
{
    use Sitemap;
}
```

You can specify column name and base Url. Just add parameter to your model:

```
    public $columnName = 'alias';

    public $baseUrl = null;
```

Or override the methods:

```
    public function getUrls() : array
    {
        return $urls;
    }

    public function makeUrl($baseUrl, $item) : string
    {
        return $url
    }
```

To upload URLs to the database you can use the interface button by the link: {yourAppUrl}/backend/sitemap
or use command:

```
    php artisan sitemap:load:urls 
```

When you need to rewrite the URLs of a specific model, you can use the option --model=App/Models/Pages

```
    php artisan sitemap:load:urls --model=App/Models/Pages
```

To create a sitemap, use the command:

```
    php artisan sitemap:generate
```

Or you can use the interface button.

## What we can publish?

```
php artisan vendor:publish --tag=sitemap-config
php artisan vendor:publish --tag=sitemap-lang
php artisan vendor:publish --tag=sitemap-migrations
php artisan vendor:publish --tag=sitemap-styles
php artisan vendor:publish --tag=sitemap-views
```

### Instructions

Other configuration instructions are in the configuration file.