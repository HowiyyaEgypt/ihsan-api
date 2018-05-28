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
Route::post('signup', 'UserController@signup');
Route::post('login', 'UserController@login');

// Cities routes
Route::get('cities', 'CitiesController@allCities');

// Location routes
Route::get('locations/history', 'LocationController@history');
Route::post('locations/add', 'LocationController@add');
Route::post('locations/{location}/delete', 'LocationController@delete');

// Organizations routes
Route::post('organizations/register', 'OrganizationController@register');
Route::get('organizations/all','OrganizationController@all');
Route::get('organizations/mixed','OrganizationController@mixed');
Route::get('organizations/{organization}/view','OrganizationController@view');
Route::post('organizations/{organization}/join','OrganizationController@join');
Route::post('organizations/{organization}/leave','OrganizationController@leave');
Route::get('organizations/{organization}/location/utils','OrganizationController@location_utils');

// Kitchens routes
Route::get('kitchens/nearby/{location?}', 'KitchenController@nearby');
Route::get('kitchens/{kitchen}/view', 'KitchenController@view');
Route::get('kitchens/{organization}/today', 'KitchenController@today');
Route::get('kitchens/{organization}/upcomming', 'KitchenController@upcomming');
Route::get('kitchens/{organization}/history', 'KitchenController@history');
Route::post('kitchens/{organization}/create', 'KitchenController@create');
Route::post('kitchens/{organization}/edit/{kitchen}', 'KitchenController@edit');
Route::post('kitchens/{organization}/delete/{kitchen}', 'KitchenController@delete');

// Meals routes
Route::post('meals/donate', 'MealController@donate');
Route::get('meals/history', 'MealController@history');
Route::get('meals/{meal}/track', 'MealController@track');

// Donate delivering a meal
Route::get('meals/nearby/auto');
Route::get('meals/nearby/{location}');
Route::post('deliver/{meal}/{kitchen}','DeliveryController@pickForDelivery');
Route::post('deliver/{meal}/cancel/{delivery}','DeliveryController@cancelDelivery');
Route::post('deliver/{meal}/confirm/{delivery}','DeliveryController@confirmMealReception');

// Donate a money donation

// Tracking history
Route::get('tracking','TrackingController@all');

// follow / unfollow someone

// update profile