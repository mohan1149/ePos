<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes([
	'register' => false,
]);
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
	Route::get('/add-user', 'App\Http\Controllers\UserController@addUser');
	Route::post('/add-user', 'App\Http\Controllers\UserController@storeUser');
	Route::get('/users', 'App\Http\Controllers\UserController@listUsers');
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
	Route::get('/terminal','App\Http\Controllers\v1\OrderController@terminal');
	Route::post('/create/order','App\Http\Controllers\v1\OrderController@placeOrderFromPOS');



	///
	Route::resource('/brands','App\Http\Controllers\BrandController');
	Route::get('/branches','App\Http\Controllers\v1\BranchController@getMyBranches');
	Route::get('/categories','App\Http\Controllers\v1\CategoryController@getMyCategories');
	Route::get('/products','App\Http\Controllers\v1\ProductController@getMyProducts');

	
	

});

Route::get('/barcodes','App\Http\Controllers\v1\ProductController@barcodes');