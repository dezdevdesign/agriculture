<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

// Authentication Routes...
Route::get('login', function() {
	return redirect('/');
})->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware('auth')->group(function() {
	// Home Routes...
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('/api/getHarvestChart', 'HomeController@getHarvestChart');
	Route::get('/api/getHarvested', 'HomeController@getHarvested');
	Route::get('/api/getProduction', 'HomeController@getProduction');
	Route::get('/api/getYield', 'HomeController@getYield');
	Route::get('/api/checkCause', 'HomeController@checkCause');
	Route::get('/api/getWateringChart', 'HomeController@getWateringChart');
	Route::get('/api/getSoilTypeChart', 'HomeController@getSoilTypeChart');
	Route::get('/api/getBadReasonChart', 'HomeController@getBadReasonChart');
	Route::get('/api/getMonthlyYield', 'HomeController@getMonthlyYield');
	Route::get('/api/getYearlyYield', 'HomeController@getYearlyYield');

	Route::get('/beta', 'HomeController@beta');
	
	// Address Routes...
	Route::get('/api/loadMunicipalities', function() {
		return DB::table('cities')
       	->select('id', 'text')
       	->get();
   	});

   	Route::get('/api/loadBarangays/{city_id}', function($city_id) {
		return DB::table('barangays')
       	->select('id', 'text')
       	->where('city_id', '=', $city_id)
       	->get();
   	});

	// Map Routes...
	Route::get('/maps', 'MapsController@index')->name('maps');
	Route::post('/maps', 'MapsController@store');
	Route::get('/api/loadMaps', 'MapsController@loadMaps');
	Route::get('/api/loadLotSelect', 'MapsController@loadLotSelect');
	Route::get('/api/getLotCenter', 'MapsController@getLotCenter');
	Route::put('/maps/{map}', 'MapsController@update');

	// Cropping Routes...
	Route::get('/croppings/add', 'CroppingsController@index')->name('croppings');
	Route::post('/croppings/add', 'CroppingsController@store');
	Route::get('/croppings/list', 'CroppingsController@list');
	Route::get('/croppings/harvests', 'CroppingsController@harvests');
	Route::get('/api/getCroppings', 'CroppingsController@getCroppings');

	// Harvest Routes...
	Route::get('/api/getHarvests', 'HarvestsController@getHarvests');

	// Farmer Routes...
	Route::get('/farmers', 'FarmersController@index')->name('farmers');
	Route::post('/farmers', 'FarmersController@store');
	Route::get('/farmers/{farmer}/edit', 'FarmersController@edit');
	Route::put('/farmers/{farmer}', 'FarmersController@update');
	Route::get('/api/getFarmers', 'FarmersController@getFarmers');

	// Crop Routes...
	Route::get('/crops', 'CropsController@index')->name('crops');
	Route::post('/crops', 'CropsController@store');
	Route::get('/crops/{crop}/edit', 'CropsController@edit');
	Route::put('/crops/{crop}', 'CropsController@update');
	Route::get('/api/getCrops', 'CropsController@getCrops');

	// User Routes....
	Route::get('/users', 'UsersController@index')->name('users');
	Route::post('/users', 'UsersController@store');
	Route::get('/users/{user}/edit', 'UsersController@edit');
	Route::put('/users/{user}', 'UsersController@update');
});