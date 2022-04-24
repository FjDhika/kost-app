<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/kost', 'namespace' => 'App\Api\Modules\Kost\Controllers'], function () {
    Route::group(['middleware' => ['api', 'jwt.verify', 'owner']], function () {
        Route::post('/', ['uses' => 'KostController@add']);
    });

    Route::group(['middleware' => ['api', 'jwt.verify', 'owner']], function () {
        Route::post('/update', ['uses' => 'KostController@update']);
    });

    Route::group(['middleware' => ['api', 'jwt.verify', 'owner']], function () {
        Route::post('/delete', ['uses' => 'KostController@delete']);
    });


    Route::group(['middleware' => ['api']], function () {
        Route::get('search', ['uses' => 'KostController@search']);
    });

    Route::group(['middleware' => ['api', 'jwt.verify', 'owner']], function () {
        Route::get('list', ['uses' => 'KostController@kostList']);
    });

    Route::group(['middleware' => ['api']], function () {
        Route::get('/{kost_id}', ['uses' => 'KostController@getById']);
    });
});
