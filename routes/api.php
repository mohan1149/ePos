<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login','App\Http\Controllers\v1\APIController@login');
Route::post('/update/avatar','App\Http\Controllers\v1\APIController@updateAvatar');
Route::post('/reset/password','App\Http\Controllers\v1\APIController@resetPassword');

Route::post('/add/branch','App\Http\Controllers\v1\APIController@addBranch');
Route::post('/all/branches','App\Http\Controllers\v1\APIController@allBranches');
Route::post('/branch/byId','App\Http\Controllers\v1\APIController@branchByID');
Route::post('/edit/branch','App\Http\Controllers\v1\APIController@editBranch');
Route::post('/delete/branch','App\Http\Controllers\v1\APIController@deleteBranch');


Route::post('/add/category','App\Http\Controllers\v1\APIController@addCategory');
Route::post('/all/categories','App\Http\Controllers\v1\APIController@allCategories');
Route::post('/all/categories-by-branch','App\Http\Controllers\v1\APIController@categoriesByBranch');
Route::post('/edit/category','App\Http\Controllers\v1\APIController@editCategory');
Route::post('/delete/category','App\Http\Controllers\v1\APIController@deleteCategory');

Route::post('/add/staff','App\Http\Controllers\v1\APIController@addStaff');
Route::post('/all/staff','App\Http\Controllers\v1\APIController@allStaff');
Route::post('/check/email','App\Http\Controllers\v1\APIController@checkEmailExistence');
Route::post('/edit/staff','App\Http\Controllers\v1\APIController@editStaff');
Route::post('/delete/staff','App\Http\Controllers\v1\APIController@deleteStaff');

Route::post('/add/product','App\Http\Controllers\v1\APIController@addProduct');
Route::post('/all/products','App\Http\Controllers\v1\APIController@allProducts');
Route::post('/delete/product','App\Http\Controllers\v1\APIController@deleteProduct');
Route::post('/edit/product','App\Http\Controllers\v1\APIController@editProduct');
Route::post('/all/products-by-branch','App\Http\Controllers\v1\APIController@productsByBranch');

Route::post('/create/order','App\Http\Controllers\v1\APIController@createOrder');
Route::post('/all/orders','App\Http\Controllers\v1\APIController@allOrders');
Route::post('/orders-by-staff','App\Http\Controllers\v1\APIController@ordersByStaff');
