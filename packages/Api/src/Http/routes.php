<?php

Route::namespace('\Api\Http\Controllers')->prefix('api')->group(function(){

    Route::post('register', 'Auth\RegisterController@register');
    Route::post('login', 'Auth\LoginController@login');

    Route::group([
        'middleware' => ['auth:api' ]
    ], function () {



        Route::apiResource('order', 'OrderController');

        Route::post('change-password', 'UserController@changePassword');
        Route::get('my-rating', 'UserController@myRating');
        Route::put('user', 'UserController@update');
        Route::get('user', 'UserController@getInfo');

        Route::apiResource('category', 'CategoryController');
        Route::apiResource('meal', 'MealController');
        Route::apiResource('dinner', 'DinnerController');
        Route::apiResource('address', 'AddressController');
    });

});
