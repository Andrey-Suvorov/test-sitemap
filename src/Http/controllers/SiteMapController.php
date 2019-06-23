<?php

namespace Hantu\Sitemap\Http\Controllers;

use Artisan;
use Hantu\Sitemap\Models\Sitemap;
use Hantu\Sitemap\Repositories\SitemapRepository;
use Hantu\Sitemap\Request\SitemapRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SitemapController extends Controller
{
    private $repo;

    public function __construct(Request $request)
    {
        $this->repo = new SitemapRepository($request);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sitemap = Sitemap::query()
            ->when($request->search != '', function ($query) {
                return $query->where('alias', 'like', '%' . request('search') . '%');
            });

        return view('sitemap::index', [
            'sitemap' => $sitemap->paginate(20),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sitemap::create', [
            'changefreq' => Sitemap::$changefreq,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(SitemapRequest $request)
    {
        $sitemap = new Sitemap();
        $sitemap = $this->repo->store($sitemap);

        Artisan::call('sitemap:generate');

        return redirect(
            $request->get('action') == 'continue'
                ? route(config('sitemap.route_prefix') . '.sitemap.edit', ['id' => $sitemap])
                : route(config('sitemap.route_prefix') . '.sitemap.index')
        )->with('success', __('sitemap::sitemap.sitemap_created'));
    }

    /**
     * Generate sitemap.
     *
     * @return array
     */
    public function generate()
    {
        Artisan::call('sitemap:generate');

        return redirect()
            ->route(config('sitemap.route_prefix') . '.sitemap.index')
            ->with('success', __('sitemap::sitemap.sitemap_generated'));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     *
     * @return array
     */
    public function getEntities(Request $request)
    {
        return $this->repo->getEntities($request->get('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sitemap = Sitemap::findOrFail($id);

        return view('sitemap::edit', [
            'sitemap' => $sitemap,
            'changefreq' => Sitemap::$changefreq,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SitemapRequest $request
     * @param               $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SitemapRequest $request, $id)
    {
        $sitemap = Sitemap::find($id);
        $sitemap = $this->repo->store($sitemap);

        Artisan::call('sitemap:generate');

        return redirect(
            $request->get('action') == 'continue'
                ? route(config('sitemap.route_prefix') . '.sitemap.edit', ['id' => $sitemap])
                : route(config('sitemap.route_prefix') . '.sitemap.index')
        )->with('success', __('sitemap::sitemap.sitemap_updated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Sitemap::destroy($id);
        Artisan::call('sitemap:generate');
        return redirect()->route(config('sitemap.route_prefix') . '.sitemap.index')
            ->with('success', __('sitemap::sitemap.sitemap_deleted'));
    }

    /**
     * Load additional urls
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loadUrls()
    {
        Artisan::call('sitemap:load:urls');

        return redirect()->back()
            ->with('success', __('sitemap::sitemap.sitemap_loaded'));
    }


}
