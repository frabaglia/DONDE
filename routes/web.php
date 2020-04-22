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
    return view('home');
});

Route::get('/test', function () {
    return redirect("/#/como-buscas/prueba/");
});

Route::get('/phpHelp', function () {
    return view("test");
});

Route::get('/contador', function () {
    return File::get(public_path() . '/public/contador/index.html');
});


Route::get('api/v2/countries/ranking', '\App\Http\Controllers\PlacesRESTController@getCountryRanking');
Route::get('api/v2/getiletag/{idPais}', '\App\Http\Controllers\ServiceController@getIleTag'); //devuelve el tag para el json i18n correspondiente al idPais
Route::get('changelang/{lang}', '\App\Http\Controllers\SeoController@changeLang'); //cambia el lenguaje de la app
Route::get('api/v2/evaluacion/getallquestionsresponses', '\App\Http\Controllers\QuestionController@getAllQuestionsResponses'); //Obtiene todas las preguntas y respuestas para evaluacion
Route::get('api/v2/service/getAllServices', '\App\Http\Controllers\ServiceController@getAllServices');
Route::get('api/v2/service/getPlaceServices/{placeId}', '\App\Http\Controllers\ServiceController@getPlaceServices');

Route::get('api/v2/evaluacion/stats/{countryName}', '\App\Http\Controllers\EvaluationRESTController@stats'); //donde-contador
//test methods api
Route::get('api/v2/evaluacion/cantidad/{id}', '\App\Http\Controllers\EvaluationRESTController@countEvaluations');
Route::get('api/v2/evaluacion/promedio/{id}', '\App\Http\Controllers\EvaluationRESTController@getPlaceAverageVote');
Route::get('api/v2/evaluacion/comentarios/{id}', '\App\Http\Controllers\EvaluationRESTController@showEvaluations');
Route::get('api/v2/evaluacion/promedioReal/{id}', '\App\Http\Controllers\EvaluationRESTController@getPlaceAverageVoteReal');

// Route::get('api/v2/evaluacion/votationCopy/{id}', '\App\Http\Controllers\EvaluationRESTController@getCopies');
Route::post('api/v2/evaluacion/votar', '\App\Http\Controllers\EvaluationRESTController@store');
Route::post('api/v2/evaluacion', '\App\Http\Controllers\EvaluationRESTController@store');

Route::resource('votar', '\App\Http\Controllers\EvaluationRESTController');

Route::get('api/v1/panel/places/{id}', '\App\Http\Controllers\PlacesRESTController@showPanel');
Route::get('api/v1/places2/{id}', '\App\Http\Controllers\PlacesRESTController@showPanel');



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

Route::get('/', '\App\Http\Controllers\MainRouteController@home');
Route::get('/home', '\App\Http\Controllers\MainRouteController@home');
Route::get('/form', '\App\Http\Controllers\MainRouteController@form');
Route::get('/terms', '\App\Http\Controllers\MainRouteController@terms');
Route::get('/share/{id}', '\App\Http\Controllers\MainRouteController@shareDetail');

Route::group(['middleware' => \App\Http\Middleware\CheckLang::class], function () {

    Route::get('/listado-paises', '\App\Http\Controllers\PaisRESTController@showCountries');
    Route::get('/listado-detalle', '\App\Http\Controllers\PaisRESTController@showCountriesDetail');
    Route::get('pais/{pais}/provincia', '\App\Http\Controllers\ProvincesRESTController@showProvinces');
    Route::get('pais/{pais}/provincia/{provincia}/partido', '\App\Http\Controllers\PartidoRESTController@showCounty');
    Route::get('pais/{pais}/provincia/{provincia}/partido/{partido}/ciudad', '\App\Http\Controllers\CiudadRESTController@showCity');
    Route::get('pais/{pais}/provincia/{provincia}/partido/{partido}/ciudad/{ciudad}/servicio', '\App\Http\Controllers\SeoController@showServices');
    Route::get('pais/{pais}/provincia/{provincia}/partido/{partido}/ciudad/{ciudad}/servicio/{code}', '\App\Http\Controllers\PlacesRESTController@showAll');

    Route::get('pais/{id}/province', '\App\Http\Controllers\ProvincesRESTController@showProvincesByIdPais');
    Route::get('provincia/{id}/partido', '\App\Http\Controllers\PartidoRESTController@showPartidosByIdProvincia');
    Route::get('partido/{id}/ciudad', '\App\Http\Controllers\CiudadRESTController@showCitiesByIdPartido');

    Route::get('api/v2/places/getall', '\App\Http\Controllers\PlacesRESTController@getAllPlaces');
    Route::get('api/v2/places/getApproved', '\App\Http\Controllers\PlacesRESTController@getApproved');
    Route::get('api/v2/places/{id}', '\App\Http\Controllers\PlacesRESTController@getPlaceById');
    Route::get('api/v2/places/byname/{name}', '\App\Http\Controllers\PlacesRESTController@getPlaceByName');
    Route::get('api/v2/places/getAllApproved', '\App\Http\Controllers\PlacesRESTController@getAllApproved');
    Route::get('api/v2/pais/getall', '\App\Http\Controllers\PlacesRESTController@getAllPaises');
    Route::get('api/v2/provincia/getall', '\App\Http\Controllers\PlacesRESTController@getAllProvincias');
    Route::get('api/v2/partido/getall', '\App\Http\Controllers\PlacesRESTController@getAllPartidos');
    Route::get('api/v2/evaluation/getall', '\App\Http\Controllers\EvaluationRESTController@getAllEvaluations');
    Route::get('api/v2/evaluation/getall/{paisId}/{pciaId}/{partyId}/{cityId}', '\App\Http\Controllers\EvaluationRESTController@getAllByCity');
    Route::get('api/v2/evaluation/{id}', '\App\Http\Controllers\EvaluationRESTController@removeEvaluation');

});




///////////////////////////////////////////////
/////////// Backoffice CMS
///////////////////////////////////////////////

Route::group(['middleware' => ['auth','CheckAdmin']], function () {
    Route::post('/api/v2/usercountries/{userId}', '\App\Http\Controllers\AdminRESTController@saveUserCountries');
    Route::get('/api/v2/usercountries/{idUser}', '\App\Http\Controllers\AdminRESTController@userCountries');
		// Registration routes...
		Route::get('auth/register', '\App\Http\Controllers\Auth\AuthController@getRegister');
		Route::post('auth/register', '\App\Http\Controllers\Auth\AuthController@postRegister');
});


Route::group(['middleware' => 'auth'], function () {


    //panel
    Route::get('api/v2/evaluacion/panel/comentarios/{id}', '\App\Http\Controllers\EvaluationRESTController@showPanelEvaluations');//para la tabla
    Route::get('api/v2/evaluacion/panel/notificacion/{id}', '\App\Http\Controllers\EvaluationRESTController@countAllEvaluations'); //nitification badge
    Route::post('api/v2/evaluacion/panel/{id}/block', '\App\Http\Controllers\EvaluationRESTController@block');
    Route::post('api/v2/evaluacion/panel/{id}/approve', '\App\Http\Controllers\EvaluationRESTController@approve');
    Route::post('api/v2/evaluacion/panel/comentarios/{id}/{response}', '\App\Http\Controllers\EvaluationRESTController@replyEvaluation');//reply




    Route::get('/api/v1panel/cleardb', '\App\Http\Controllers\ImportadorController@cleardb'); // <------------------- limpia base de datos
    Route::get('/api/v1panel/getservermode', '\App\Http\Controllers\ImportadorController@getServerMode'); // <------------------- devuelve .env.mode

    Route::get('panel', '\App\Http\Controllers\MainRouteController@panel');
    Route::get('panel/places/confirmation', '\App\Http\Controllers\MainRouteController@formEditConfirmation');


    Route::get('panel/places/{id}', '\App\Http\Controllers\MainRouteController@places');
    Route::get('panel/places/pre/{id}', '\App\Http\Controllers\MainRouteController@placesPre');

    Route::get('panel/user-countries', '\App\Http\Controllers\MainRouteController@userCountries');
    Route::get('panel/admin-list', '\App\Http\Controllers\MainRouteController@adminList');
    Route::get('panel/city-list', '\App\Http\Controllers\MainRouteController@cityList');
    Route::get('panel/logged', '\App\Http\Controllers\AdminRESTController@logged');

//------------------------------------------------------------------------------
    //IMPORTADOR
    Route::get('panel/importer', '\App\Http\Controllers\ImportadorController@index'); //index con 2 opciones (imp y exp)
    Route::get('panel/importer/export', '\App\Http\Controllers\ImportadorController@exportar');
    Route::get('panel/importer/muestra', '\App\Http\Controllers\ImportadorController@exportarMuestra');
    Route::get('panel/importer/picker', '\App\Http\Controllers\ImportadorController@picker');


    //get export errors dowload links
    Route::get('panel/importer/nuevo', '\App\Http\Controllers\ImportadorController@exportNuevos'); //preview/places
    Route::get('panel/importer/repetido', '\App\Http\Controllers\ImportadorController@exportReptidos'); //preview/places
    Route::get('panel/importer/incompleto', '\App\Http\Controllers\ImportadorController@exportInompletos'); //preview/places
    Route::get('panel/importer/unificar', '\App\Http\Controllers\ImportadorController@exportUnificar'); //preview/places
    Route::get('panel/importer/bc', '\App\Http\Controllers\ImportadorController@exportBC'); //preview/places
    Route::get('panel/importer/actualizar', '\App\Http\Controllers\ImportadorController@exportActualizar'); //preview/places
    Route::get('panel/importer/sin-actualizar', '\App\Http\Controllers\ImportadorController@exportBadActualizar'); //preview/places

    Route::post('panel/importer/preview', '\App\Http\Controllers\ImportadorController@importCsv'); //preview/places
    Route::post('panel/importer/confirm', '\App\Http\Controllers\ImportadorController@confirmAdd'); //preview/confirmation
    Route::post('panel/importer/preview-ng', '\App\Http\Controllers\ImportadorController@preAddNoGeo'); //preview/places
    Route::post('panel/importer/confirm-ng', '\App\Http\Controllers\ImportadorController@confirmAddNoGeo'); //preview/confirmation
    Route::post('panel/importer/results', '\App\Http\Controllers\ImportadorController@posAdd'); //preview/results
    Route::post('panel/importer/results-id', '\App\Http\Controllers\ImportadorController@confirmAddWhitId'); //preview/results
    Route::get('panel/importer/results-id', '\App\Http\Controllers\ImportadorController@confirmAddWhitId'); //preview/results
    Route::get('panel/importer/results', '\App\Http\Controllers\ImportadorController@posAdd'); //preview/results

    //panel-exportar-frontEnd
    Route::get('panel/importer/front-export/{pid}/{cid}/{bid}', '\App\Http\Controllers\ImportadorController@exportarPanelFormed');//para la busqueda de places

    // For places search - Second export button
    Route::get('panel/importer/front-export/{pid}/{bid}/{did}/{cid}', '\App\Http\Controllers\ImportadorController@exportarPanelFormedCity');

    Route::get('panel/importer/front-export/{search}', '\App\Http\Controllers\ImportadorController@exportarPanelSearch');//para la busqueda de places

    Route::get('panel/importer/front-export-eval/{pid}/{cid}/{bid}', '\App\Http\Controllers\ImportadorController@exportarPanelEvalFormed');//para la busqueda de places

    Route::post('panel/importer/activePlacesEvaluationsExport', '\App\Http\Controllers\ImportadorController@activePlacesEvaluationsExport');//exportar evluacion lugares activos con filtro por servicios servicio

    Route::post('panel/importer/filteredEvaluations', '\App\Http\Controllers\ImportadorController@getFilteredEvaluations');//exportar evluacion lugares activos con filtro por servicios servicio

    Route::get('panel/importer/front-export-eval/{search}', '\App\Http\Controllers\ImportadorController@exportarPanelEvalSearch');//para la busqueda de places
  Route::post('panel/importer/activePlacesExport', '\App\Http\Controllers\ImportadorController@activePlacesExport');//exportar lugares activos
    Route::post('panel/importer/evaluationsExportFilterByService', '\App\Http\Controllers\ImportadorController@evaluationsExportFilterByService');//exportar evluacion lugares activos con filtro por servicios servicio
    Route::get('panel/importer/eval-export/{id}', '\App\Http\Controllers\ImportadorController@exportarEvaluaciones');//para las evaluaciones

    Route::get('panel/importer/eval-service-export/{id}', '\App\Http\Controllers\ImportadorController@exportarEvaluacionesPorServicios');//para las evaluaciones

    //todas las evaluaciones
    Route::get('panel/importer/full-eval-export/{lang}', '\App\Http\Controllers\ImportadorController@exportarEvaluacionesFull');//todas las evaluaciones de todos los lugares

    Route::resource('panel/importer', '\App\Http\Controllers\ImportadorController');

//------------------------------------------------------------------------------------------

    //mail de confirmacion
    Route::get('confirmation-email', '\App\Http\Controllers\MainRouteController@sendConfirmation');
//------------------------------------------------------------------------------------------


    Route::get('api/v1/panel/provinces/{id}/cities', '\App\Http\Controllers\PaisRESTController@getAllCities');

    Route::get('api/v1panelplaces/ranking', '\App\Http\Controllers\PlacesRESTController@getCitiRanking');
    Route::get('api/v1panelplaces/nonGeo', '\App\Http\Controllers\PlacesRESTController@getNonGeo');
    Route::get('api/v1panelplaces/nongeofilterbyuser', '\App\Http\Controllers\PlacesRESTController@getNonGeoFilterByUser');
    Route::get('api/v1panelplaces/badGeo', '\App\Http\Controllers\PlacesRESTController@getBadGeo');
    Route::get('api/v1panelplaces/badgeofilterbyuser', '\App\Http\Controllers\PlacesRESTController@getBadGeoFilterByUser');

    Route::get('api/v1/panel/places/searchfilterbyuser/{q}', '\App\Http\Controllers\PlacesRESTController@searchFilterByUser');
    Route::get('api/v1/panel/places/search/{q}', '\App\Http\Controllers\PlacesRESTController@search');
    Route::get('api/v1/panel/places/counters', '\App\Http\Controllers\PlacesRESTController@counters');
    Route::get('api/v2/panel/places/counters', '\App\Http\Controllers\PlacesRESTController@counters');
    Route::get('api/v2/panel/places/countersfilterbyuser', '\App\Http\Controllers\PlacesRESTController@countersFilterByUser');

//van aca
    // Route::get('api/v1/panel/places/{id}', '\App\Http\Controllers\PlacesRESTController@showPanel');
    Route::get('api/v1/panel/places/approved/{pid}/{cid}/{bid}', '\App\Http\Controllers\PlacesRESTController@showApproved');
    Route::get('api/v1/panel/places/blocked', '\App\Http\Controllers\PlacesRESTController@showDreprecated');
    //Route::get('api/v1/panel/places/pending', '\App\Http\Controllers\PlacesRESTController@showPending');

    // Route::get('api/v1/places2/{id}', '\App\Http\Controllers\PlacesRESTController@showPanel');
    Route::get('api/v1/places/approved', '\App\Http\Controllers\PlacesRESTController@getAllApproved');
    Route::get('api/v1/places/approved/{pid}/{cid}', '\App\Http\Controllers\PlacesRESTController@showApprovedActiveByState');
    Route::get('api/v1/places/approved/{pid}/{cid}/{did}', '\App\Http\Controllers\PlacesRESTController@showApprovedActiveByDepartment');
    Route::get('api/v1/places/approved/{pid}/{cid}/{did}/{bid}', '\App\Http\Controllers\PlacesRESTController@showApprovedActive');
    Route::get('api/v1/places/blocked', '\App\Http\Controllers\PlacesRESTController@showDreprecated');
    Route::get('api/v1/places/blockedfilterbyuser', '\App\Http\Controllers\PlacesRESTController@showDreprecatedFilterByUser');
    Route::get('api/v1panelplaces/pending', '\App\Http\Controllers\PlacesRESTController@showPending');
    Route::get('api/v1panelplaces/pendingfilterbyuser', '\App\Http\Controllers\PlacesRESTController@showPendingFilterByUser');
    Route::get('api/v1/places/tagsimportaciones', '\App\Http\Controllers\PlaceLogController@getall');
    Route::get('panel/tagsimportaciones/{tagId}', '\App\Http\Controllers\PlaceLogController@exportplacesfilterbytag');


    // Route::get('api/v1/panel/places/{id}', '\App\Http\Controllers\PlacesRESTController@showPanel');


    Route::get('api/v1/panel/pais/nombre/{nombre}', '\App\Http\Controllers\PaisRESTController@showByNombre');
    Route::get('api/v1/panel/provincia/nombre/{nombre}', '\App\Http\Controllers\ProvincesRESTController@showByNombre');
    Route::get('api/v1/panel/partido/nombre/{nombre}', '\App\Http\Controllers\PartidoRESTController@showByNombre');
    Route::get('api/v1/panel/partido/panel', '\App\Http\Controllers\PartidoRESTController@showWithProvincia');
    Route::post('api/v1/panel/partido/update/{id}', '\App\Http\Controllers\PartidoRESTController@updateHabilitado');

    Route::get('api/v1/panel/ciudad/panel', '\App\Http\Controllers\CiudadRESTController@showCities');
    Route::post('api/v1/panel/ciudad/update/{id}', '\App\Http\Controllers\CiudadRESTController@updateHabilitado');

    Route::post('api/v1/panel/places/{id}/update', '\App\Http\Controllers\PlacesRESTController@update');
    Route::post('api/v1/panel/places/{id}/approve', '\App\Http\Controllers\PlacesRESTController@approve');
    Route::post('api/v1/panel/places/{id}/block', '\App\Http\Controllers\PlacesRESTController@block');
});

 Route::resource('api-admin', '\App\Http\Controllers\AdminRESTController');



// Password reset link request routes...
Route::get('password/email', '\App\Http\Controllers\Auth\PasswordController@getEmail');
Route::post('password/email', '\App\Http\Controllers\Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', '\App\Http\Controllers\Auth\PasswordController@getReset');
Route::post('password/reset', '\App\Http\Controllers\Auth\PasswordController@postReset');



Route::post('api/v1/places', '\App\Http\Controllers\NewPlacesRESTController@store');

//Route::get('api/v1/places/all', '\App\Http\Controllers\PlacesRESTController@getAll');
Route::get('api/v1/places/geo/{lat}/{lng}', '\App\Http\Controllers\PlacesRESTController@getScalarLatLon');

// Modified autocomplete in order to support search by cities
Route::post('api/v1/places/all/autocomplete', '\App\Http\Controllers\PlacesRESTController@getAllAutocomplete');

Route::get('api/v1/places/all/autocomplete', '\App\Http\Controllers\PlacesRESTController@listAllAutocomplete');

Route::get('api/v1/cities/all/autocomplete', '\App\Http\Controllers\PlacesRESTController@citiesAllAutocomplete');


Route::post('api/v1/places/all/autocompletename', '\App\Http\Controllers\PlacesRESTController@getAllAutocompleteName');
Route::get('api/v1/places/all/autocompletename', '\App\Http\Controllers\PlacesRESTController@listAllAutocompleteName');

Route::get('api/v1/places/search/{name}/{service}', '\App\Http\Controllers\PlacesRESTController@getPlacesByName');
// Modified route in order to suppport cities
Route::get('api/v1/places/{pid}/{cid}/{bid}/{lid}/{service}', '\App\Http\Controllers\PlacesRESTController@getScalarServicesByCity');

// List all the enabled places that belong to a party
Route::get('api/v1/places/{pid}/{service}', '\App\Http\Controllers\PlacesRESTController@getpPlacesByParty');

// Check if this route is still useful
Route::get('api/v1/places/{pid}/{cid}/{bid}/{service}', '\App\Http\Controllers\PlacesRESTController@getScalarServices');

Route::get('api/v1/single/service/{code}', '\App\Http\Controllers\ServiceController@getServiceByCode');

Route::get('api/v1/places/{pid}/{cid}/{bid}', '\App\Http\Controllers\PlacesRESTController@getScalar');

Route::get('api/v1/countries/byuser', '\App\Http\Controllers\PaisRESTController@getCountriesByUser');
Route::get('api/v1/countries/all', '\App\Http\Controllers\PaisRESTController@getAll');
Route::get('api/v1/countries/{id}/provinces', '\App\Http\Controllers\PaisRESTController@getProvinces');

Route::get('api/v1/provinces/{id}/partidos', '\App\Http\Controllers\PaisRESTController@getPartidos');

Route::get('api/v1/parties/{id}/cities', '\App\Http\Controllers\PaisRESTController@getCitiesByParty');

Route::get('api/v1/provinces/{id}/cities', '\App\Http\Controllers\PaisRESTController@getCities');

//ordenar places por comentarios
Route::get('api/v2/places/comments/{id}', '\App\Http\Controllers\PlacesRESTController@getBestRatedPlaces');

Route::resource('seo', '\App\Http\Controllers\SeoController');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
