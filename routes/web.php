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

    ## Account CRUD Routes ##
	Route::resource('/accounts', 'Web\AccountController');
	Route::get('/accounts/inactives/list', 'Web\AccountController@inactives');
	Route::put('/accounts/{account}/inactivate', 'Web\AccountController@inactivate');
    Route::put('/accounts/{account}/reactivate', 'Web\AccountController@reactivate');

    ## Service CRUD Routes ##
    Route::resource('/services', 'Web\ServiceController');
	Route::get('/services/inactives/list', 'Web\ServiceController@inactives');
	Route::put('/services/{service}/inactivate', 'Web\ServiceController@inactivate');
    Route::put('/services/{service}/reactivate', 'Web\ServiceController@reactivate');

    ## Payment Methods CRUD Routes ##
	Route::resource('/payment-methods', 'Web\PaymentMethodController');
	Route::get('/payment-methods/inactives/list', 'Web\PaymentMethodController@inactives');
	Route::put('/payment-methods/{payment_method}/inactivate', 'Web\PaymentMethodController@inactivate');
	Route::put('/payment-methods/{payment_method}/reactivate', 'Web\PaymentMethodController@reactivate');
	
	## Jobs CRUD Routes ##
	Route::get('/customer/{customer}/job/create', 'Web\JobController@create');
	Route::resource('/jobs', 'Web\JobController')->except('create');

	## Expenses CRUD Routes ##
	Route::resource('/expenses', 'Web\ExpenseController');

	## Reports Routes ##
	Route::get('/reports', 'Web\ReportController@index');

	
});
