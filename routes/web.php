<?php

Route::group(['namespace' => '\Personals'], function () {
    Route::redirect("/ads", "/", 301);
    Route::get('/', 'Ad\AdController@index');
    Route::get('/ads/write', 'Ad\AdController@write');
    Route::post('/ads/write', 'Ad\AdController@store');
});
