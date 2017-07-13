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
    Route::post('/{entryByAlias}/show', 'EntryController@show');
    Route::post('/new', 'EntryController@getNew');
});

Route::group(['prefix' => 'comments'], function() {
    Route::post('{entry}/show', 'CommentController@show');
});

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'bookmarks'], function () {
        Route::post('/', 'BookmarkController@index');
        Route::post('{entry}/store', 'BookmarkController@store');
        Route::post('{entry}/destroy', 'BookmarkController@destroy');
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

    Route::group(['prefix' => 'entry'], function () {
        Route::post('/', 'EntryController@create');
        Route::post('/store', 'EntryController@store');
        Route::post('/import', 'EntryController@import');
        Route::post('/{entry}', 'EntryController@edit');
        Route::post('/{entry}/update', 'EntryController@update');
    });

    Route::group(['prefix' => 'comments'], function () {
        Route::post('{entry}/{user}/store', 'CommentController@store');
    });

    Route::group(['prefix' => 'entry-statuses'], function () {
       Route::post('{entry}/store', 'UserEntryStatusController@store');
       Route::post('{entry}/update', 'UserEntryStatusController@update');
    });

    Route::group(['prefix' => 'videos'], function () {
       Route::post('/{entry}/{video}/bookmark', 'VideoController@bookmark');
    });

    Route::group(['prefix' => 'tags'], function () {
        Route::post('/', 'TagController@index');
        Route::post('/store', 'TagController@store');
        Route::put('/update', 'TagController@update');
        Route::delete('/{tag}/destroy', 'TagController@destroy');
    });

    Route::post('image/upload', 'ImageController@upload');
});