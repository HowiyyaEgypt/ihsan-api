<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Auth routes
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');

// Location routes
Route::get('locations/history', 'LocationController@history');
Route::post('locations/add', 'LocationController@add');
Route::post('locations/{location}/delete', 'LocationController@delete');

// Meals routes
Route::post('meals/donate', 'MealController@donate');
Route::get('meals/history', 'MealController@history');
Route::get('meals/{meal}/track', 'MealController@track');

// Donate delivering a meal
Route::get('meals/nearby/auto');
Route::get('meals/nearby/{location}');
Route::post('deliver/{meal}');

// Donate a money donation

// follow / unfollow someone

// update profile