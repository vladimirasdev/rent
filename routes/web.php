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

Route::get('/', 'HomeController@showIndex');
Route::get('home', 'HomeController@showIndex');
Route::view('/qrscanner', 'qrscanner');

Route::group(['middleware' => ['auth', 'role']], function()
{
    Route::resource('items', 'ItemsController');
    Route::get('items/status/{id}', 'ItemsController@getByStatus');
    Route::resource('routing', 'RoutingController');
    Route::get('routing/status/{id}', 'RoutingController@changeStatus');
    Route::get('routing/list/{date}', 'RoutingController@getList');
    Route::resource('category', 'CategoryController');
    Route::resource('users', 'UsersController');
    Route::resource('roles', 'RolesController');
    Route::get('item/{code}', 'ItemsController@getItemHistory');
    Route::post('search/{search?}', 'SearchController@postSearch');
});

// Authentication routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
