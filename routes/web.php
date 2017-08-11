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
	Route::get('report', ['uses'=>'Transactions\ReportController@index', 'as'=>'transactionReportController']);
	Route::get('list', ['uses'=>'Transactions\ListController@index', 'as'=>'transactionListController']);
});

//Route::resource('login', 'EFT\LoginController', ['only' => ['index', 'store']]);


//Route::get('/login', function () {
//	return view('welcome');
//
//});
//Route::post('/login', function () {
//	return view('welcome');
//});


/*
//gruplu middleware ile prefixli
Route::middleware(['first', 'second'])->group(function () {
	Route::get('/', function () {
		// Uses first & second Middleware
	});

	Route::get('user/profile', function () {
		// Uses first & second Middleware
	});
});
//buda prefixli, login olduktan sonra buraya girecek
Route::prefix('admin')->group(function () {
	Route::get('users', function () {
		// Matches The "/admin/users" URL
	});
});
Route::prefix('report')->group(function () {
	Route::get('transactions', function () {
		// Matches The "/report/transactions" URL
	});
});
*/
