<?php

use Illuminate\Http\Request;

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


Route::post('/user/register', 'ApiController@register')->middleware('requestHandler:RegisterRequest');
Route::post('/user/login', 'ApiController@login')->middleware('requestHandler:LoginRequest');
Route::post('/logout', 'ApiController@logout')->middleware('requestHandler:LogoutRequest');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
