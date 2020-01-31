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
Route::post('/user/social_register', 'ApiController@social_register');
Route::post('/user/login', 'ApiController@login')
//    ->middleware('requestHandler:LoginRequest')
;

Route::post('user/show_user', 'ApiController@show_user')->middleware(MobileLoginSession::class);


Route::post('/logout', 'ApiController@logout')->middleware('requestHandler:LogoutRequest');

Route::get('/sponsors', 'ApiController@getSponsors')->middleware('requestHandler:GetSponsorsRequest');
Route::get('/speakers', 'ApiController@getSpeakers')->middleware('requestHandler:GetSpeakersRequest');
Route::get('/activities', 'ApiController@getActivities')->middleware('requestHandler:GetActivitiesRequest');
Route::get('/get/events', 'ApiController@getEvents')->middleware('requestHandler:GetEventsRequest');
Route::get('/supplements', 'ApiController@getSupplements')->middleware('requestHandler:GetSupplementsRequest');
Route::get('/notifications', 'ApiController@getNotifications')->middleware('requestHandler:GetNotificationsRequest');
Route::get('/get/welcome_content', 'ApiController@welcomeContent')->middleware('requestHandler:GetWelcomeRequest');

Route::get('/get/data', 'ApiController@getAllData')->middleware('requestHandler:GetContentRequest');
Route::post('/change/password', 'ApiController@changePassword')->middleware('requestHandler:ChangePasswordRequest');
Route::post('/forgot/password', 'ApiController@forgotPassword')->middleware('requestHandler:ForgotPasswordRequest');
Route::get('/crone', 'EventsController@crone');
Route::get('/session_out', 'ApiController@session_out');
Route::post('/user/social_login', 'ApiController@social_login');
