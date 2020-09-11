<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Auth
Route::prefix('/auth')->group(function () {
    Route::post('/login', 'Api\V1\LoginController@login');
    Route::post('/register', 'Api\V1\LoginController@register');
    Route::middleware('auth:api')->post('/logout', 'Api\V1\LoginController@logout');
});

//Fixtures
Route::prefix('/fixtures')->group(function () {
    Route::get('/', 'Api\V1\FixtureController@index');
    Route::middleware('auth:api')->get('/{id}', 'Api\V1\FixtureController@show');
});

//Predictions
Route::prefix('/predictions')->group(function () {
    Route::middleware('auth:api')->get('/', 'Api\V1\PredictionController@index');
    Route::middleware('auth:api')->post('/', 'Api\V1\PredictionController@store');
    Route::middleware('auth:api')->put('/{id}', 'Api\V1\PredictionController@update');
});

//Rounds
Route::prefix('/rounds')->group(function () {
    Route::get('/', 'Api\V1\RoundController@index');

});
