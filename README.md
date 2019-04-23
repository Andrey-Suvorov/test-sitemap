# Laravel SiteMap

It's a test package for Laravel that implements site map functionality.

## Installing

```
composer require hantu/sitemap
```

Publish migrations and css-styles:

```
php artisan vendor:publish --tag=sitemap-migrations
php artisan vendor:publish --tag=sitemap-styles
```

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