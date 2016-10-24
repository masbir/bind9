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

//views
Route::get('/', 'DNSViewsController@index');
Route::get('/views/{id}', 'DNSViewsController@view');

//ips
Route::post('/views/{view_id}/ips', 'DNSIPsController@create');
Route::post('/views/{view_id}/ips/{id}', 'DNSIPsController@delete');

//domains
Route::post('/views/{view_id}/domains', 'DNSDomainsController@create');
Route::post('/views/{view_id}/domains/{id}', 'DNSDomainsController@delete');

//stats 
Route::get('/stats/track', 'StatsController@track');


Route::get('/blacklist', 'BlacklistController@edit');
Route::post('/blacklist', 'BlacklistController@save');

Auth::routes();

Route::get('/home', 'HomeController@index');
