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

Route::view('/', 'home')->name('home');
Route::get('blog', 'BlogController@index')->name('blog');
Route::get('talks', 'TalksController@index')->name('talks');
Route::get('{year}/{month}/{day}/{slug}', 'BlogController@show')->where([
    'year' => '[0-9]{4}',
    'month' => '[0-9]{2}',
    'date' => '[0-9]{2}'
]);

Route::group(['namespace' => 'Auth'], function () {
    Route::get('login', 'LoginController@showLoginForm')->name('auth.show-login');
    Route::post('login', 'LoginController@login')->name('auth.login');
    Route::post('logout', 'LoginController@logout')->name('auth.logout');
});

Route::group(['prefix' => 'dashboard', 'namespace' => 'Dashboard', 'middleware' => 'auth'], function () {
    Route::view('/', 'dashboard.show')->name('dashboard.show');

    Route::get('posts', 'PostsController@index')->name('dashboard.posts.index');
    Route::get('post/add', 'PostsController@create')->name('dashboard.posts.create');
    Route::post('posts', 'PostsController@store')->name('dashboard.posts.store');
    Route::get('post/{post}/edit', 'PostsController@edit')->name('dashboard.posts.edit');
    Route::put('post/{post}', 'PostsController@update')->name('dashboard.posts.update');

    Route::post('published-posts', 'PublishedPostsController@store')->name('dashboard.published-posts.store');
    Route::delete('published-posts', 'PublishedPostsController@destroy')->name('dashboard.published-posts.destroy');

    Route::get('talks', 'TalksController@index')->name('dashboard.talks.index');
    Route::get('talk/add', 'TalksController@create')->name('dashboard.talks.create');
    Route::post('talks', 'TalksController@store')->name('dashboard.talks.store');
    Route::get('talk/{talk}/edit', 'TalksController@edit')->name('dashboard.talks.edit');
    Route::put('talk/{talk}', 'TalksController@update')->name('dashboard.talks.update');

    Route::post('published-talks', 'PublishedTalksController@store')->name('dashboard.published-talks.store');
    Route::delete('published-talks', 'PublishedTalksController@destroy')->name('dashboard.published-talks.destroy');
});

Route::post('mailing-list/members', 'MailingListMembersController@store');