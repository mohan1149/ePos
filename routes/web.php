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
	
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
	
	
	Route::get('/terminal','App\Http\Controllers\v1\OrderController@terminal');
	Route::post('/create/order','App\Http\Controllers\v1\OrderController@placeOrderFromPOS');



	///  for Control Panel
	Route::get('/add-admin', 'App\Http\Controllers\UserController@addAdmin');
	Route::post('/add-admin', 'App\Http\Controllers\UserController@storeAdmin');
	Route::get('/admins', 'App\Http\Controllers\UserController@getAdmins');
	Route::resource('/brands','App\Http\Controllers\BrandController');
	Route::get('/branches','App\Http\Controllers\v1\BranchController@getMyBranches');
	Route::get('/branches/create','App\Http\Controllers\v1\BranchController@createBranch');
	Route::post('/branches/create','App\Http\Controllers\v1\BranchController@storeBranch');
	Route::get('/branches/{id}/edit','App\Http\Controllers\v1\BranchController@editBranch');
	Route::post('/branches/{id}/edit','App\Http\Controllers\v1\BranchController@updateBranch');
	Route::get('/categories','App\Http\Controllers\v1\CategoryController@getMyCategories');
	Route::get('/categories/create','App\Http\Controllers\v1\CategoryController@createCategory');
	Route::post('/categories/create','App\Http\Controllers\v1\CategoryController@storeCategory');
	Route::get('/categories/{id}/edit','App\Http\Controllers\v1\CategoryController@editCategory');
	Route::post('/categories/{id}/edit','App\Http\Controllers\v1\CategoryController@updateCategory');
	Route::get('/products','App\Http\Controllers\v1\ProductController@getMyProducts');
	Route::get('/products/create','App\Http\Controllers\v1\ProductController@createProduct');
	Route::post('/products/create','App\Http\Controllers\v1\ProductController@storeProduct');
	Route::get('/products/{id}/edit','App\Http\Controllers\v1\ProductController@editMyProduct');
	Route::post('/products/{id}/edit','App\Http\Controllers\v1\ProductController@updateMyProduct');
	Route::get('/products/{id}/media','App\Http\Controllers\v1\ProductController@getProductMedia');
	Route::post('/products/{id}/media','App\Http\Controllers\v1\ProductController@updateProductMedia');
	Route::get('/sliders','App\Http\Controllers\v1\SliderController@getSliders');
	Route::get('/sliders/create','App\Http\Controllers\v1\SliderController@addSlider');
	Route::post('/sliders/create','App\Http\Controllers\v1\SliderController@storeSlider');
	Route::get('/sliders/{id}/edit','App\Http\Controllers\v1\SliderController@editSlider');
	Route::post('/sliders/{id}/edit','App\Http\Controllers\v1\SliderController@updateSlider');
	Route::resource('/promotions', 'App\Http\Controllers\PromotionController');
	Route::get('/tags/create', 'App\Http\Controllers\TagsController@create');
	Route::get('/tags', 'App\Http\Controllers\TagsController@index');
	Route::post('/tags', 'App\Http\Controllers\TagsController@store');
	Route::get('/tags/{id}/edit', 'App\Http\Controllers\TagsController@edit');
	Route::post('/tags/{id}/update', 'App\Http\Controllers\TagsController@update');
	Route::resource('/users','App\Http\Controllers\UserController');
	Route::resource('/sales','App\Http\Controllers\v1\OrderController');
	Route::get('/services','App\Http\Controllers\v1\ServiceController@listServices');
	Route::get('/services/create','App\Http\Controllers\v1\ServiceController@create');
	Route::post('/services/create','App\Http\Controllers\v1\ServiceController@store');
	Route::get('/services/{id}/edit','App\Http\Controllers\v1\ServiceController@edit');
	Route::post('/services/{id}/edit','App\Http\Controllers\v1\ServiceController@updateService');
	Route::get('/orders','App\Http\Controllers\v1\OrderController@getOrders');
	Route::get('/orders/{id}','App\Http\Controllers\v1\OrderController@viewOrder');


	

});

Route::get('/barcodes','App\Http\Controllers\v1\ProductController@barcodes');