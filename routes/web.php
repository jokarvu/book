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


Route::resource('user', 'AccountController');
Route::resource('dashboard', 'AdminDashboardController');
Route::get('book/latest', 'BookController@latest');
Route::get('book/popular', 'BookController@popular');
Route::resource('book', 'BookController');
Route::resource('category', 'CategoryController');
Route::resource('import', 'ImportController');
Route::resource('invoice', 'InvoiceController');
Route::put('invoice/{invoice}/status', 'InvoiceController@status');
Route::resource('role', 'RoleController');
Route::resource('supplier', 'SupplierController');
Route::get('dashboard', 'AdminDashboardController@counter');
Route::get('revenue', 'AdminDashboardController@revenue');

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::get('admin', 'AuthController@isAdmin');
    Route::get('check', 'AuthController@check');
    Route::get('current', 'AuthController@current');
    Route::get('logout', 'AuthController@logout');
});

Route::get('/login', function () {
    return view('admin');
});
Route::get('/register', function () {
    return view('admin');
});

Route::get('/admin/{vue?}', function () {
    return view('admin');
})->where('vue', '[\/\.\w\-]+');


Route::get('/{vue?}', function () {
    return view('customer');
})->where('vue', '[\/\.\w\-]+');
