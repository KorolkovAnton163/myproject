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

Route::get('/{vue_capture?}', function () {
    return view('master');
})->where('vue_capture', '[\/\w\.-]*');

Route::post('/user/get', 'UserController@getUser');
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');

Route::group(['middleware' => 'auth'], function () {
    Route::post('logout', 'UserController@logout');

    Route::group(['prefix' => 'roles'], function () {
        Route::post('/', 'RoleController@index');
        Route::post('/update', 'RoleController@update');
        Route::post('/store', 'RoleController@store');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::post('/{user}/update', 'UserController@update');
    });
});