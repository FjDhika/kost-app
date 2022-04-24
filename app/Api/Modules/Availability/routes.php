<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api', 'namespace' => 'App\Api\Modules\Availability\Controllers'], function () {
    Route::group(['middleware' => ['api', 'jwt.verify', 'user']], function () {
        Route::post('avail/ask', ['uses' => 'AvailabilityController@askAvailability']);
    });

    Route::group(['middleware' => ['api', 'jwt.verify', 'owner']], function () {
        Route::post('avail/answer', ['uses' => 'AvailabilityController@answerAvailability']);
    });

    Route::group(['middleware' => ['api', 'jwt.verify', 'owner']], function () {
        Route::get('avail/owner', ['uses' => 'AvailabilityController@getAvailabilityByOwnerId']);
    });

    Route::group(['middleware' => ['api', 'jwt.verify', 'user']], function () {
        Route::get('avail/user', ['uses' => 'AvailabilityController@getAvailabilityByUserId']);
    });

    Route::group(['middleware' => ['api', 'jwt.verify']], function () {
        Route::get('avail/{availability_id}', ['uses' => 'AvailabilityController@getAvailabilityById']);
    });
});
