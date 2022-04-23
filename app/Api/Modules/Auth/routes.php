<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api', 'namespace' => 'App\Api\Modules\Auth\Controllers'], function () {
    Route::group(['middleware' => ['api']], function () {
        Route::post('register', ['uses' => 'AuthController@register']);
    });

    Route::group(['middleware' => ['api']], function () {
        Route::post('login', ['uses' => 'AuthController@login']);
    });
});
