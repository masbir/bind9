<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::group(['domain' => env('APP_HOST')], function () {
	//views
	Route::group(['middleware' => 'auth'], function () {
		Route::get('/', 'DNSViewsController@index');
		Route::get('/views/{id}', 'DNSViewsController@view');

		//ips
		Route::post('/views/{view_id}/ips', 'DNSIPsController@create');
		Route::post('/views/{view_id}/ips/{id}', 'DNSIPsController@delete');

		//domains
		Route::post('/views/{view_id}/domains', 'DNSDomainsController@create');
		Route::post('/views/{view_id}/domains/{id}', 'DNSDomainsController@delete');

		//stats 
		Route::get('/warning/{view_id}', 'HomeController@previewWarningPage');
	});


	//Route::get('/blacklist', 'BlacklistController@edit');
	//Route::post('/blacklist', 'BlacklistController@save');

	Auth::routes();

	//Route::get('/home', 'HomeController@index');
});

Route::group(['middleware' => 'guest'], function () {
	Route::post('/stats/track', 'StatsController@track');
});
Route::any('/{url?}', 'HomeController@warningPage');