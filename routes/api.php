<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('logout', 'UserController@logout');
Route::post('login', 'UserController@login');

Route::post('/user/get', function (Request $request) {
    return response()->json(Auth::user());
});

Route::middleware('auth:api')->post('/user', function (Request $request) {
    return $request->user();
});
