<?php

Route::group(['namespace' => '\Personals'], function () {
    Route::get('/', 'Ad\AdController@index');

    Route::group(["prefix" => "/ads"], function () {
        Route::redirect("/", "/", 301);
        Route::get('/write', 'Ad\AdController@write');
        Route::post('/write', 'Ad\AdController@store');
        Route::get('/{ad}/{slug?}', 'Ad\AdController@show');
    });

    Route::get('/tag/{tag}', 'Ad\AdController@showByTag');

    Route::group(["prefix" => "tags"], function () {
        Route::get('/', 'Tag\TagController@index');
    });
});
