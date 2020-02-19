<?php

use App\Http\Middleware\MobileLoginSession;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/user/register', 'ApiController@register');
Route::post('/user/social/login', 'ApiController@socialLogin');
Route::post('/user/login', 'ApiController@login');

Route::group(['middleware' => 'requestHandler'], function () {
Route::get('/get/data', 'ApiController@getData');
});

