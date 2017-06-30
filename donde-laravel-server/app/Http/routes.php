<?php
// header("Access-Control-Allow-Origin: *");

// Route::get('/campus-party', function () {
// 	return redirect("https://docs.google.com/presentation/d/13xZeBTG2YHdglTB8bLnFImeSmoafrn1AGv5q2WKxu6k/edit#slide=id.p"); });

Route::get('/test', function () {
	return redirect("/#/como-buscas/prueba/"); });

Route::get('/phpHelp', function () {
	return view("test"); });

	Route::get('/contador', function () {
		return File::get(public_path() . '/public/contador/index.html');
});

Route::get('api/v2/evaluacion/getallquestionsresponses', 'QuestionController@getAllQuestionsResponses'); //Obtiene todas las preguntas y respuestas para evaluacion
Route::get('api/v2/service/getAllServices', 'ServiceController@getAllServices');
Route::get('api/v2/service/getPlaceServices/{placeId}', 'ServiceController@getPlaceServices');

Route::get('api/v2/evaluacion/stats/{countryName}', 'EvaluationRESTController@stats'); //donde-contador
//test methods api
Route::get('api/v2/evaluacion/cantidad/{id}', 'EvaluationRESTController@countEvaluations');
Route::get('api/v2/evaluacion/promedio/{id}', 'EvaluationRESTController@getPlaceAverageVote');
Route::get('api/v2/evaluacion/comentarios/{id}', 'EvaluationRESTController@showEvaluations');
Route::get('api/v2/evaluacion/promedioReal/{id}', 'EvaluationRESTController@getPlaceAverageVoteReal');

// Route::get('api/v2/evaluacion/votationCopy/{id}', 'EvaluationRESTController@getCopies');
Route::post('api/v2/evaluacion/votar', 'EvaluationRESTController@store');
Route::post('api/v2/evaluacion', 'EvaluationRESTController@store');

//panel
Route::get('api/v2/evaluacion/panel/comentarios/{id}', 'EvaluationRESTController@showPanelEvaluations');//para la tabla
Route::get('api/v2/evaluacion/panel/notificacion/{id}', 'EvaluationRESTController@countAllEvaluations'); //nitification badge
Route::post('api/v2/evaluacion/panel/{id}/block', 'EvaluationRESTController@block');
Route::post('api/v2/evaluacion/panel/{id}/approve', 'EvaluationRESTController@approve');


Route::resource('votar', 'EvaluationRESTController');

Route::get('api/v1/panel/places/{id}', 'PlacesRESTController@showPanel');
Route::get('api/v1/places2/{id}', 'PlacesRESTController@showPanel');



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


Route::get('/listado-paises', 'PaisRESTController@showCountries');
Route::get('/listagem-paises', 'PaisRESTController@showCountries');
Route::get('/country-list', 'PaisRESTController@showCountries');

Route::get('pais/{pais}/provincia', 'ProvincesRESTController@showProvinces');
Route::get('country/{pais}/state', 'ProvincesRESTController@showProvinces');


Route::get('pais/{pais}/provincia/{provincia}/partido', 'PartidoRESTController@showCounty');
Route::get('pais/{pais}/provincia/{provincia}/cidade', 'PartidoRESTController@showCounty');
Route::get('country/{pais}/state/{provincia}/city', 'PartidoRESTController@showCounty');


Route::get('pais/{pais}/provincia/{provincia}/partido/{partido}/servicio', 'SeoController@showServices');
Route::get('pais/{pais}/provincia/{provincia}/cidade/{partido}/serviço', 'SeoController@showServices');
Route::get('country/{pais}/state/{provincia}/city/{partido}/service', 'SeoController@showServices');


Route::get('pais/{pais}/provincia/{provincia}/partido/{partido}/servicio/{code}', 'PlacesRESTController@showAll');
Route::get('pais/{pais}/provincia/{provincia}/cidade/{partido}/serviço/{code}', 'PlacesRESTController@showAll');
Route::get('country/{pais}/state/{provincia}/city/{partido}/service/{code}', 'PlacesRESTController@showAll');






// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');


///////////////////////////////////////////////
/////////// Backoffice CMS
///////////////////////////////////////////////

Route::group(['middleware' => 'auth'], function () {

Route::get('/api/v1panel/cleardb', 'ImportadorController@cleardb'); // <------------------- limpia base de datos
Route::get('/api/v1panel/getservermode', 'ImportadorController@getServerMode'); // <------------------- devuelve .env.mode
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

//------------------------------------------------------------------------------
	//IMPORTADOR
	Route::get('panel/importer', 'ImportadorController@index'); //index con 2 opciones (imp y exp)
	Route::get('panel/importer/export', 'ImportadorController@exportar');
	Route::get('panel/importer/muestra', 'ImportadorController@exportarMuestra');
	Route::get('panel/importer/picker', 'ImportadorController@picker');


	//get export errors dowload links
	Route::get('panel/importer/nuevo', 'ImportadorController@exportNuevos'); //preview/places
	Route::get('panel/importer/repetido', 'ImportadorController@exportReptidos'); //preview/places
	Route::get('panel/importer/incompleto', 'ImportadorController@exportInompletos'); //preview/places
	Route::get('panel/importer/unificar', 'ImportadorController@exportUnificar'); //preview/places
	Route::get('panel/importer/bc', 'ImportadorController@exportBC'); //preview/places
	Route::get('panel/importer/actualizar', 'ImportadorController@exportActualizar'); //preview/places
	Route::get('panel/importer/sin-actualizar', 'ImportadorController@exportBadActualizar'); //preview/places

	Route::post('panel/importer/preview', 'ImportadorController@importCsv'); //preview/places
	Route::post('panel/importer/confirm', 'ImportadorController@confirmAdd'); //preview/confirmation
	Route::post('panel/importer/preview-ng', 'ImportadorController@preAddNoGeo'); //preview/places
	Route::post('panel/importer/confirm-ng', 'ImportadorController@confirmAddNoGeo'); //preview/confirmation
	Route::post('panel/importer/results', 'ImportadorController@posAdd'); //preview/results
	Route::post('panel/importer/results-id', 'ImportadorController@confirmAddWhitId'); //preview/results
	Route::get('panel/importer/results-id', 'ImportadorController@confirmAddWhitId'); //preview/results
	Route::get('panel/importer/results', 'ImportadorController@posAdd'); //preview/results

	//panel-exportar-frontEnd
	Route::get('panel/importer/front-export/{pid}/{cid}/{bid}', 'ImportadorController@exportarPanelFormed');//para la busqueda de places
	Route::get('panel/importer/front-export/{search}', 'ImportadorController@exportarPanelSearch');//para la busqueda de places

	Route::get('panel/importer/front-export-eval/{pid}/{cid}/{bid}', 'ImportadorController@exportarPanelEvalFormed');//para la busqueda de places
	Route::post('panel/importer/activePlacesEvaluationsExport', 'ImportadorController@activePlacesEvaluationsExport');//exportar evluacion lugares activos con filtro por servicios servicio
	Route::get('panel/importer/front-export-eval/{search}', 'ImportadorController@exportarPanelEvalSearch');//para la busqueda de places
  Route::post('panel/importer/activePlacesExport', 'ImportadorController@activePlacesExport');//exportar lugares activos
	Route::post('panel/importer/evaluationsExportFilterByService', 'ImportadorController@evaluationsExportFilterByService');//exportar evluacion lugares activos con filtro por servicios servicio
	Route::get('panel/importer/eval-export/{id}', 'ImportadorController@exportarEvaluaciones');//para las evaluaciones

	Route::get('panel/importer/eval-service-export/{id}', 'ImportadorController@exportarEvaluacionesPorServicios');//para las evaluaciones

	//todas las evaluaciones
	Route::get('panel/importer/full-eval-export', 'ImportadorController@exportarEvaluacionesFull');//todas las evaluaciones de todos los lugares




	Route::resource('panel/importer', 'ImportadorController');

//------------------------------------------------------------------------------------------

	//mail de confirmacion
	Route::get('confirmation-email', 'MainRouteController@sendConfirmation');
//------------------------------------------------------------------------------------------


	Route::get('api/v1/panel/provinces/{id}/cities', 'PaisRESTController@getAllCities');


	Route::get('api/v1panelplaces/ranking', 'PlacesRESTController@getCitiRanking');
	Route::get('api/v1panelplaces/nonGeo', 'PlacesRESTController@getNonGeo');
	Route::get('api/v1panelplaces/badGeo', 'PlacesRESTController@getBadGeo');

	Route::get('api/v1/panel/places/search/{q}', 'PlacesRESTController@search');
	Route::get('api/v1/panel/places/counters', 'PlacesRESTController@counters');
	Route::get('api/v2/panel/places/counters', 'PlacesRESTController@counters');

//van aca
	// Route::get('api/v1/panel/places/{id}', 'PlacesRESTController@showPanel');
	Route::get('api/v1/panel/places/approved/{pid}/{cid}/{bid}', 'PlacesRESTController@showApproved');
	Route::get('api/v1/panel/places/blocked', 'PlacesRESTController@showDreprecated');
	//Route::get('api/v1/panel/places/pending', 'PlacesRESTController@showPending');

	// Route::get('api/v1/places2/{id}', 'PlacesRESTController@showPanel');
	Route::get('api/v1/places/approved/{pid}/{cid}/{bid}', 'PlacesRESTController@showApproved');
	Route::get('api/v1/places/blocked', 'PlacesRESTController@showDreprecated');
	Route::get('api/v1panelplaces/pending', 'PlacesRESTController@showPending');
	Route::get('api/v1/places/tagsimportaciones', 'PlaceLogController@getall');
	Route::get('panel/tagsimportaciones/{tagId}', 'PlaceLogController@exportplacesfilterbytag');


	// Route::get('api/v1/panel/places/{id}', 'PlacesRESTController@showPanel');


	Route::get('api/v1/panel/pais/nombre/{nombre}', 'PaisRESTController@showByNombre');
	Route::get('api/v1/panel/provincia/nombre/{nombre}', 'ProvincesRESTController@showByNombre');
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

Route::post('api/v1/places/all/autocomplete', 'PlacesRESTController@getAllAutocomplete');

Route::get('api/v1/places/{pid}/{cid}/{bid}/{service}', 'PlacesRESTController@getScalarServices');

Route::get('api/v1/places/{pid}/{cid}/{bid}', 'PlacesRESTController@getScalar');

Route::get('api/v1/countries/all', 'PaisRESTController@getAll');
Route::get('api/v1/countries/{id}/provinces', 'PaisRESTController@getProvinces');
Route::get('api/v1/provinces/{id}/cities', 'PaisRESTController@getCities');

//ordenar places por comentarios
Route::get('api/v2/places/comments/{id}', 'PlacesRESTController@getBestRatedPlaces');

Route::resource('seo', 'SeoController');
// Route::get('seo/index2', 'SeoController@index2');
