<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'MainRouteController@home');
Route::get('/form', 'MainRouteController@form');
Route::get('/share/{id}', 'MainRouteController@shareDetail');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');


///////////////////////////////////////////////
/////////// Backoffice CMS
///////////////////////////////////////////////

Route::group(['middleware' => 'auth'], function () {

	
	// Registration routes...
	Route::get('auth/register', 'Auth\AuthController@getRegister');
	Route::post('auth/register', 'Auth\AuthController@postRegister');

    Route::get('panel', 'MainRouteController@panel');
    Route::get('panel/places/confirmation', 'MainRouteController@formEditConfirmation');
   	
   

    Route::get('panel/places/{id}', 'MainRouteController@places');
    Route::get('panel/places/pre/{id}', 'MainRouteController@placesPre');


	Route::get('panel/admin-list', 'MainRouteController@adminList');
	Route::get('panel/city-list', 'MainRouteController@cityList');
	Route::get('panel/logged', 'AdminRESTController@logged');

	Route::get('api/v1/panel/provinces/{id}/cities', 'PaisRESTController@getAllCities');

	
	Route::get('api/v1/panel/places/ranking', 'PlacesRESTController@getCitiRanking');
	Route::get('api/v1/panel/places/nonGeo', 'PlacesRESTController@getNonGeo');
	Route::get('api/v1/panel/places/badGeo', 'PlacesRESTController@getBadGeo');

	Route::get('api/v1/panel/places/search/{q}', 'PlacesRESTController@search');
	Route::get('api/v1/panel/places/counters', 'PlacesRESTController@counters');
	
	Route::get('api/v1/panel/places/approved/{pid}/{cid}/{bid}', 'PlacesRESTController@showApproved');
	Route::get('api/v1/panel/places/blocked', 'PlacesRESTController@showDreprecated');
	Route::get('api/v1/panel/places/pending', 'PlacesRESTController@showPending');
	

	
	Route::get('api/v1/panel/places/{id}', 'PlacesRESTController@showPanel');
	

	Route::get('api/v1/panel/pais/nombre/{nombre}', 'PaisRESTController@showByNombre');
	Route::get('api/v1/panel/provincia/nombre/{nombre}', 'ProvinciaRESTController@showByNombre');
	Route::get('api/v1/panel/partido/nombre/{nombre}', 'PartidoRESTController@showByNombre');
	Route::get('api/v1/panel/partido/panel', 'PartidoRESTController@showWithProvincia');
	Route::post('api/v1/panel/partido/update/{id}', 'PartidoRESTController@updateHabilitado');

	
	Route::post('api/v1/panel/places/{id}/update', 'PlacesRESTController@update');
	Route::post('api/v1/panel/places/{id}/approve', 'PlacesRESTController@approve');
	Route::post('api/v1/panel/places/{id}/block',  'PlacesRESTController@block');

});

 Route::resource('api-admin', 'AdminRESTController');



// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');



Route::post('api/v1/places', 'NewPlacesRESTController@store');	
Route::get('api/v1/places/all', 'PlacesRESTController@getAll');
Route::get('api/v1/places/geo/{lat}/{lng}', 'PlacesRESTController@getScalarLatLon');

Route::get('api/v1/places/{pid}/{cid}/{bid}/{service}', 'PlacesRESTController@getScalarServices');

Route::get('api/v1/places/{pid}/{cid}/{bid}', 'PlacesRESTController@getScalar');

Route::get('api/v1/countries/all', 'PaisRESTController@getAll');
Route::get('api/v1/countries/{id}/provinces', 'PaisRESTController@getProvinces');
Route::get('api/v1/provinces/{id}/cities', 'PaisRESTController@getCities');




