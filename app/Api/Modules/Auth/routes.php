<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api', 'namespace' => 'App\Api\Modules\Auth\Controllers'], function () {
    Route::group(['middleware' => ['api']], function () {
        Route::post('owner/register', ['uses' => 'AuthController@registerOwner']);
    });

    Route::group(['middleware' => ['api']], function () {
        Route::post('regular/register', ['uses' => 'AuthController@registerRegular']);
    });

    Route::group(['middleware' => ['api']], function () {
        Route::post('premium/register', ['uses' => 'AuthController@registerPremium']);
    });

    Route::group(['middleware' => ['api']], function () {
        Route::post('login', ['uses' => 'AuthController@login']);
    });
});
