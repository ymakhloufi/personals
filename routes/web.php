<?php

Route::group(['namespace' => '\Personals'], function () {
    Route::get('/', 'Ad\AdController@index');

    Route::group(["prefix" => "/ads"], function () {
        Route::redirect("/", "/", 301);
        Route::get('/write', 'Ad\AdController@write');
        Route::post('/write', 'Ad\AdController@store');
        Route::get('/{ad}/publish/{token}', 'Ad\AdController@publish')->name('ad.publish');
        Route::get('/{ad}/{slug?}', 'Ad\AdController@show')->name('ad.show');
    });

    Route::get('/tag/{tag}', 'Ad\AdController@showByTag')->name('tag.show');
});
