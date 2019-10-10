<?php




Route::namespace('\Api\Http\Controllers')->prefix('api')->group(function(){

    Route::post('register', 'Auth\RegisterController@register');
    Route::post('login', 'Auth\LoginController@login');

    Route::group([
        'middleware' => ['auth:api', 'api']
    ], function () {


        Route::apiResource('category', 'CategoryController');
        Route::apiResource('meal', 'MealController');
        Route::apiResource('order', 'OrderController');
        Route::apiResource('dinner', 'DinnerController');


    });

});
