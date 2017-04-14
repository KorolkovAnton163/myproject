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

Route::get('logout', 'UserController@logout');

Route::get('/{vue_capture?}', 'HomeController@index')
    ->where('vue_capture', '[\/\w\.-]*');

Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');

Route::group(['prefix' => 'entries'], function () {
    Route::post('/', 'EntryController@index');
    Route::post('/{entry}/show', 'EntryController@show');
});

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'bookmarks'], function () {
        Route::post('/', 'EntryController@bookmarks');
        Route::post('{entry}/store', 'EntryController@bookmarkStore');
        Route::post('{entry}/destroy', 'EntryController@bookmarkDestroy');
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::post('/', 'RoleController@index');
        Route::post('/update', 'RoleController@update');
        Route::post('/store', 'RoleController@store');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::post('/', 'UserController@getUsers');
        Route::post('/{user}/update', 'UserController@update');
    });
});