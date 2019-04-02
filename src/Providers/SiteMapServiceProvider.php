<?php

namespace Hantu\Sitemap\Providers;

use Hantu\Sitemap\Commands\SiteMapGeneratorCommand;
use Illuminate\Support\ServiceProvider;

class SiteMapServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'sitemap');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../config/sitemap.php' => config_path('sitemap.php'),
        ], 'sitemap-config');


        $this->publishes([
            __DIR__.'/../database/migrations' => base_path('database/migrations'),
        ], 'sitemap-migrations');

        $this->commands([
            SiteMapGeneratorCommand::class
        ]);


        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/sitemap'),
        ], 'sitemap-views');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/sitemap.php', 'sitemap'
        );
    }
}