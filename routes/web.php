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
    return redirect('/web/home');
});

Auth::routes();

Route::prefix('web')->middleware(['auth'])->group(function () {
	Route::get('/home', 'Web\HomeController@index')->name('home');

	## Customer CRUD Routes ##
	Route::resource('/customers', 'Web\CustomerController');
	Route::get('/customers/inactives/list', 'Web\CustomerController@inactives');
	Route::put('/customers/{customer}/inactivate', 'Web\CustomerController@inactivate');
    Route::put('/customers/{customer}/reactivate', 'Web\CustomerController@reactivate');

    ## Artist CRUD Routes ##
	Route::resource('/artists', 'Web\ArtistController');
	Route::get('/artists/inactives/list', 'Web\ArtistController@inactives');
	Route::put('/artists/{artist}/inactivate', 'Web\ArtistController@inactivate');
    Route::put('/artists/{artist}/reactivate', 'Web\ArtistController@reactivate');

    ## Sources CRUD Routes ##
	Route::resource('/sources', 'Web\SourceController');
	Route::get('/sources/inactives/list', 'Web\SourceController@inactives');
	Route::put('/sources/{source}/inactivate', 'Web\SourceController@inactivate');
    Route::put('/sources/{source}/reactivate', 'Web\SourceController@reactivate');
});
