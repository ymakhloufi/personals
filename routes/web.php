<?php

Route::get('sitemap', 'App\Http\Controllers\SitemapController@sitemap')->name('sitemap');
Route::get('robots.txt', 'App\Http\Controllers\SitemapController@robots')->name('robots');

Route::group(['namespace' => '\Personals'], function () {
    Route::get('/', 'Ad\AdController@index')->name('index');

    Route::group(["prefix" => "/ads"], function () {
        Route::redirect("/", "/", 301);
        Route::get("search", 'Ad\AdController@search')->name('ad.search');
        Route::get('/write', 'Ad\AdController@write')->name('ad.write');
        Route::post('/write', 'Ad\AdController@store');
        Route::get('/{ad}/publish/{token}', 'Ad\AdController@publish')->name('ad.publish');
        Route::post('/{ad}/reply', 'Ad\AdController@reply')->name('ad.reply');
        Route::get('/{ad}/{slug?}', 'Ad\AdController@show')->name('ad.show');
    });

    Route::get('/tag/{tag}', 'Ad\AdController@showByTag')->name('tag.show');
});


$this->get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'App\Http\Controllers\Auth\LoginController@login');
$this->get('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
