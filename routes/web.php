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
Route::resource('user', 'AccountController');
Route::resource('dashboard', 'AdminDashboardController');
Route::resource('book', 'BookController');
Route::resource('category', 'CategoryController');
Route::resource('import', 'ImportController');
Route::resource('invoice', 'InvoiceController');
Route::resource('role', 'RoleController');
Route::resource('supplier', 'SupplierController');

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::get('admin', 'AuthController@isAdmin');
    Route::get('check', 'AuthController@check');
    Route::get('current', 'AuthController@current');
    Route::get('logout', 'AuthController@logout');
});

Route::get('/{vue?}', function () {
    return view('admin');
})->where('vue', '[\/\.\w\-]+');