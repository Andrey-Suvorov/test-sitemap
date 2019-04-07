<?php

namespace Hantu\Sitemap\Commands;

use App;
use Hantu\Sitemap\Helpers\SitemapHelper;
use Hantu\Sitemap\Models\Sitemap;
use Illuminate\Console\Command;
use Storage;

class SiteMapGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap.xml file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Throwable
     */
    public function handle()
    {
        SitemapHelper::loadUrls();

        $pages = Sitemap::onlyActive()
            ->get(['alias', 'lastmod', 'priority', 'changefreq'])
            ->toArray();
        $sitemap = '';
        $bar = $this->output->createProgressBar(count($pages));

        $bar->start();
        foreach ($pages as $page) {
            foreach (config('sitemap.locales') as $lang) {
                $page = array_merge($page, ['locale' => $lang]);
                $sitemap .= view('sitemap::url', $page)->render();
            }
            $bar->advance();
        }
        $bar->finish();
        $this->info("\n");
        Storage::disk(config('sitemap.filesystem_driver', 'public'))
            ->put('sitemap.xml', '<?xml version="1.0" encoding="UTF-8"?>'.
                view('sitemap::sitemap', [
                    'sitemap' => $sitemap,
                    'locale' => config('app.locale'),
                ])->render());

    }
}
