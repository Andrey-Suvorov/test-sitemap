<?php
/**
 * Created by PhpStorm.
 * User: adminko
 * Date: 27.10.18
 * Time: 23:49
 */

namespace Hantu\Sitemap\Repositories;

use DB;
use Hantu\Sitemap\Models\Sitemap;
use Illuminate\Http\Request;

class SitemapRepository
{
    protected $request;
    public $pages = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->pages = config('sitemap.static_routes');
    }

    public function store()
    {

    }

    /**
     * Return all values related to given model in alphabetical order
     *
     * @param $model
     *
     * @return array
     */
    public function getEntities($model)
    {
        $result = [];
        $model::onlyActive()
            ->wherehas('translations', function ($query) {
                return $query
                    ->where('name', 'like', '%' . request('search') . '%')
                    ->orderBy('name');
            })
            ->get()
            ->sortBy(function ($item) {
                return $item->name;
            })
            ->map(function ($item) use (&$result) {
                $result[$item->id] = $item->name;
            });

        return $result;
    }

    /**
     * Load URL's
     *
     * @return int
     */
    public function loadUrls()
    {
        Sitemap::where('is_loaded', 1)->delete();

        $sitemapCount = Sitemap::all()->count();
        $staticRoutes = config('sitemap.static_routes');

        foreach ($staticRoutes as $routeName) {
            $sitemapCount++;
            Sitemap::updateOrCreate(['alias' => route($routeName), 'order' => $sitemapCount, 'is_loaded' => 1]);
        }

        $dynamicUrlsModels = config('sitemap.dynamic_url_classes');

        foreach ($dynamicUrlsModels as $model) {
            $model = new $model();
            if (method_exists($model, 'getUrls')) {
                $modelUrls = $model->getUrls();
                foreach ($modelUrls as $url) {
                    $sitemapCount++;
                    Sitemap::updateOrCreate(['alias' => $url, 'order' => $sitemapCount, 'is_loaded' => 1]);
                }
            }
        }
    }
}