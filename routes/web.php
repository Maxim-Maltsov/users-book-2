<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('profile/{id}', 'UserController@profile' )->name('profile');

 
Route::prefix('edit')->group(function () {
    
    Route::match(['get', 'post'], 'info/{id}', 'UserController@editInfo');
    Route::match(['get', 'post'], 'security/{id}', 'UserController@editSecurity');
    Route::match(['get', 'post'], 'status/{id}', 'UserController@editStatus');
    Route::match(['get', 'post'], 'avatar/{id}', 'UserController@editAvatar');
    Route::get('delete-user/{id}', 'UserController@deleteUser');
});

Route::match(['get', 'post'], 'create-user', 'UserController@createUser')->middleware('admin')->name('create');
