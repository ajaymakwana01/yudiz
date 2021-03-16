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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/admin')->name('admin.')->group(function () {
    Route::get('/login','Admin\AdminAuthController@index')->name('login')->middleware('guest:admin');
    Route::post('/login', 'Admin\AdminAuthController@login')->name('loginUser')->middleware('guest:admin');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/', 'Admin\AdminAuthController@dashboard')->name('dashboard');
    });

});
