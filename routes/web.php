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

Route::get('/', 'HomePageController@show');

Route::get('about', 'AboutPageController@show');

Route::group(['namespace' => 'Auth'], function () {
    Route::get('login', 'LoginController@showLoginForm')->name('auth.show-login');
    Route::post('login', 'LoginController@login')->name('auth.login');
    Route::post('logout', 'LoginController@logout')->name('auth.logout');
});

Route::group([
    'middleware' => 'auth', 'prefix' => 'dashboard', 'namespace' => 'Dashboard'
], function () {
    Route::get('/', 'DashboardController');
    Route::get('posts', 'PostsController@index');
    Route::get('posts/new', 'PostsController@create');
    Route::post('posts', 'PostsController@store');
});

Route::get('{year}/{month}/{day}/{title}', 'BlogController@show')->where([
    'year' => '[0-9]{4}', 'month' => '[0-9]{2}', 'date' => '[0-9]{2}'
]);