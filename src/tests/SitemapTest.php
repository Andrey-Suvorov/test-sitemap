<?php

use Tests\TestCase;
use Hantu\Sitemap\Models\Sitemap;
use Illuminate\Support\Facades\Input;

class SitemapTest extends TestCase
{
    public function testPages()
    {
        $this->get(route(config('sitemap.route_prefix') . '.sitemap.index'))->assertStatus(200);
        $this->get(route(config('sitemap.route_prefix') . '.sitemap.create'))->assertStatus(200);
    }

    public function testLoadUrls()
    {
        $this->get(route(config('sitemap.route_prefix') . '.sitemap.load.urls'))
            ->assertStatus(302)
            ->assertSessionHas('success', __('sitemap::sitemap.sitemap_loaded'));
    }

    public function testEdit()
    {
        $this->get(route(config('sitemap.route_prefix') . '.sitemap.edit', Sitemap::first()))
            ->assertStatus(200);
    }

    public function testCreate()
    {
        Input::replace([
            'alias' => 'test/link',
            'priority' => 0,
            'is_active' => 1,

        ]);

        $response = $this->call('POST', route(config('sitemap.route_prefix') . '.sitemap.store'), Input::all());

        $response->assertRedirect(route(config('sitemap.route_prefix') . '.sitemap.index'))
            ->assertSessionHas('success', __('sitemap::sitemap.sitemap_created'));
    }

    public function testFailCreate()
    {
        $row = Sitemap::where('alias', 'test/link')->first();

        Input::replace([
            'alias' => $row->alias,
            'priority' => 0,
            'is_active' => 1,

        ]);

        $response = $this->call('POST', route(config('sitemap.route_prefix') . '.sitemap.store'), Input::all());
        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'alias' => 'The alias has already been taken.'
            ]);
    }

    public function testUpdate()
    {
        $row = Sitemap::where('alias', 'test/link')->first();

        Input::replace([
            'alias' => $row->alias,
            'priority' => 9,
            'is_active' => 1,

        ]);

        $response = $this->call('PUT', route(config('sitemap.route_prefix') . '.sitemap.update', $row), Input::all());

        $response->assertRedirect(route(config('sitemap.route_prefix') . '.sitemap.index'))
            ->assertSessionHas('success', __('sitemap::sitemap.sitemap_updated'));
    }

    public function testDestroy()
    {
        $row = Sitemap::where('alias', 'test/link')->first();

        $response = $this->call('DELETE', route(config('sitemap.route_prefix') . '.sitemap.destroy', $row));

        $response->assertRedirect(route(config('sitemap.route_prefix') . '.sitemap.index'))
            ->assertSessionHas('success', __('sitemap::sitemap.sitemap_deleted'));
    }
}