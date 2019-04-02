<?php
/**
 * Created by PhpStorm.
 * User: adminko
 * Date: 27.10.18
 * Time: 23:49
 */

namespace Hantu\Sitemap\Repositories;

use DB;
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
     * Generate full site sitemap in database
     *
     * @return int
     */
    public function generate()
    {
        DB::table('sitemap')->truncate();
        $i = 0;
        foreach ($this->pages as $page) {
            Sitemap::create([
                'alias' => route($page),
                'is_active' => true,
            ]);
            $i++;
        }

        return $i;
    }
}