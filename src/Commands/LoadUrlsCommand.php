<?php

namespace Hantu\Sitemap\Commands;

use Hantu\Sitemap\Models\Sitemap;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LoadUrlsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:load:urls {--model= : Write path to the model like App/Models/Page}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load Urls to DB';

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
        DB::beginTransaction();

        try {
            $dynamicUrlsModels = config('sitemap.dynamic_url_classes');
            $sitemapQuery = Sitemap::where('is_loaded', 1);

            if ($this->option('model')) {
                $model = str_replace('/', '\\', $this->option('model'));
                if (!in_array($model, $dynamicUrlsModels)) {
                    return $this->error('No model like this! Please make sure that you correctly wrote the path to the model (for example --model=App/Models/Pages) or such a model is added in the settings.');
                }

                $sitemapQuery = $sitemapQuery->where('model', $model);
                $dynamicUrlsModels = [
                    $model
                ];
            }

            $sitemapQuery->delete();

            $sitemapCount = Sitemap::all()->count();

            if (!$this->option('model')) {
                $staticRoutes = config('sitemap.static_routes');

                foreach ($staticRoutes as $routeName) {
                    $sitemapCount++;
                    Sitemap::updateOrCreate(['alias' => route($routeName), 'order' => $sitemapCount, 'is_loaded' => 1]);
                }
            }

            foreach ($dynamicUrlsModels as $modelName) {
                $model = new $modelName();
                if (method_exists($model, 'getUrls')) {
                    $modelUrls = $model->getUrls();
                    foreach ($modelUrls as $url) {
                        $sitemapCount++;
                        Sitemap::updateOrCreate(['alias' => $url, 'model' => $modelName, 'order' => $sitemapCount, 'is_loaded' => 1]);
                    }
                }
            }


        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        DB::commit();

        $this->line('Loading is over.' );
    }
}
