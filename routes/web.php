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
});

Route::resource('login', 'LoginController', ['only' => ['index', 'store']]);


// Matches The "/transaction/XXX" URL
Route::prefix('transaction')->middleware(['checkauth'])->group(function () {

	Route::get('report', ['uses'=>'Transaction\ReportController@index']);
	Route::post('report', ['uses'=>'Transaction\ReportController@store']);

	Route::get('list', ['uses'=>'Transaction\ListController@index', 'as'=>'transactionListController']);
	Route::post('list', ['uses'=>'Transaction\ListController@store']);

	Route::get('/{transactionId}', 'Transaction\DetailController@show');

});

Route::middleware(['checkauth'])->group(function () {

	Route::get('merchant/{transactionId}', 'MerchantDetailController@show');
	Route::get('client/{transactionId}', 'ClientDetailController@show');

});

Route::any('/', function () {
	return view('pages.home');
});
