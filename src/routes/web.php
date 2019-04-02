<?php
//dd('asdasdasd', config('sitemap.route_prefix'));
    Route::group(['namespace' => 'Hantu\Sitemap\Http\controllers', /*'middleware' => ['web'],*/ 'prefix' => config('sitemap.route_prefix'), 'as' => config('sitemap.route_as')], function () {
        Route::get('sitemap', 'SiteMapController@index')->name('sitemap.index');
        //SEO-Sitemap
        Route::resource('sitemap', 'SiteMapController')->except(['show']);
        Route::get('sitemap/entities', 'SiteMapController@getEntities')->name('sitemap.getEntities');
        Route::get('sitemap/generate', 'SiteMapController@generate')->name('sitemap.generate');
//        Route::post('contact', 'ContactFormController@sendMail')->name('contact');
    });