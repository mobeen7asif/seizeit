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

Route::get('/', function () {
    if(\Illuminate\Support\Facades\Auth::check()){
        return redirect('/dashboard');
    }else{
        return redirect('/login');
    }
});

Route::get('/test', function () {
    return view('test');
});



Route::get('/login', function () {
    return view('login');
});

Route::post('/login', 'UsersController@login');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', 'UsersController@dashboard');

    Route::get('/test', 'EventsController@test');


    Route::get('/uni', 'UsersController@getUni');
    Route::get('/add/uni', 'UsersController@addUniView');
    Route::post('/add/uni', 'UsersController@addUni');
    Route::get('/update/uni/{id}', 'UsersController@showUniForm');
    Route::post('/update/uni/{id}', 'UsersController@updateUni');
    Route::get('/delete/uni/{id}', 'UsersController@deleteUni');
    Route::get('/uni/detail/{id}', 'UsersController@uniDetail');
    Route::post('/uni/bulk/delete', 'UsersController@deleteUnis');

    Route::get('/users', 'UsersController@getUsers');
    Route::get('/admins', 'UsersController@getAdmins');
    Route::get('/add/user', 'UsersController@addUserView');
    Route::post('/add/user', 'UsersController@addUser');
    Route::get('/update/user/{user_id}', 'UsersController@editUserView');
    Route::post('/update/user/{user_id}', 'UsersController@updateUser');
    Route::get('/delete/user/{user_id}', 'UsersController@deleteUser');
    Route::get('/change/password', 'UsersController@changePasswordView');
    Route::post('/change/password', 'UsersController@changePassword');

    Route::post('/user/bulk/delete', 'UsersController@bulkDelete');

    Route::get('/update/admin/{user_id}', 'UsersController@editAdminView');
    Route::post('/update/admin/{user_id}', 'UsersController@updateAdmin');
    Route::get('/delete/admin/{user_id}', 'UsersController@deleteAdmin');
    Route::post('/admin/bulk/delete', 'UsersController@bulkAdminsDelete');




    Route::get('/events', 'EventsController@getEvents');
    Route::get('/add/event', 'EventsController@addEventView');
    Route::post('/add/event', 'EventsController@addEvent');
    Route::get('/delete/event/{event_id}', 'EventsController@deleteEvent');
    Route::get('/update/event/{event_id}', 'EventsController@showEditEvent');
    Route::post('/update/event/{event_id}', 'EventsController@updateEvent');
    Route::post('/event/bulk/delete', 'EventsController@deleteEvents');
    Route::post('/change/session_text', 'EventsController@changeSessionText');


    Route::get('/view/sessions/{event_id}', 'EventsController@viewSessions');
    Route::get('/create/session/{event_id}', 'EventsController@addSessionView');
    Route::post('/create/session/{event_id}', 'EventsController@addSession');
    Route::get('/event/detail/{event_id}', 'EventsController@eventDetail');

    Route::get('/delete/session/{session_id}', 'EventsController@deleteSession');
    Route::get('/update/session/{session_id}', 'EventsController@editSessionView');
    Route::post('/update/session/{event_id}/{session_id}', 'EventsController@updateSession');
    Route::get('/session/detail/{session_id}', 'EventsController@sessionDetail');
    Route::post('/session/bulk/delete', 'EventsController@deleteSessions');


    Route::get('/sponsors', 'SponsorsController@getSponsors');
    Route::get('/add/sponsor', 'SponsorsController@showSponsorView');
    Route::post('/add/sponsor', 'SponsorsController@addSponsor');
    Route::get('/update/sponsor/{id}', 'SponsorsController@editSponsorForm');
    Route::post('/update/sponsor/{id}', 'SponsorsController@updateSponsor');
    Route::get('/delete/sponsor/{id}', 'SponsorsController@deleteSponsor');
    Route::get('/sponsor/detail/{id}', 'SponsorsController@sponsorDetail');
    Route::post('/sponsor/bulk/delete', 'SponsorsController@deleteSponsors');

    Route::get('/activities', 'ActivitiesController@getActivities');
    Route::get('/add/activity', 'ActivitiesController@showActivityView');
    Route::post('/add/activity', 'ActivitiesController@addActivity');
    Route::get('/update/activity/{id}', 'ActivitiesController@editActivityForm');
    Route::post('/update/activity/{id}', 'ActivitiesController@updateActivity');
    Route::get('/delete/activity/{id}', 'ActivitiesController@deleteActivity');
    Route::get('/activity/detail/{id}', 'ActivitiesController@activityDetail');
    Route::post('/activity/bulk/delete', 'ActivitiesController@deleteActivities');

    Route::get('/supplements', 'SupplementsController@getSupplements');
    Route::get('/add/supplement', 'SupplementsController@showSupplementView');
    Route::post('/add/supplement', 'SupplementsController@addSupplement');
    Route::get('/update/supplement/{id}', 'SupplementsController@editSupplementForm');
    Route::post('/update/supplement/{id}', 'SupplementsController@updateSupplement');
    Route::get('/delete/supplement/{id}', 'SupplementsController@deleteSupplement');
    Route::get('/supplement/detail/{id}', 'SupplementsController@supplementDetail');
    Route::post('/supplement/bulk/delete', 'SupplementsController@deleteSupplements');


    Route::get('/welcome', 'UsersController@getWelcomeView');
    Route::post('/update/welcome/content', 'UsersController@updateContent');

    Route::get('/map_image', 'UsersController@getMapView');
    Route::post('/update/map', 'UsersController@updateMapImage');

    Route::post('/add/profile_image', 'UsersController@changeUserImage');

    Route::post('/sort/users', 'UsersController@sortUsers');
    Route::post('/sort/uni', 'UsersController@sortUni');
    Route::post('/sort/sponsors', 'SponsorsController@sortSponsors');
    Route::post('/sort/activities', 'ActivitiesController@sortActivities');
    Route::post('/sort/supplements', 'SupplementsController@sortSupplements');

    Route::post('/import/users', 'UsersController@importUsers');
    Route::get('/export/users', 'UsersController@exportUsers');

    Route::post('/make/admin', 'UsersController@makeAdmin');
    Route::post('/delete/image', 'UsersController@deleteImage');
    Route::get('/images/view', 'UsersController@imagesView');
    Route::post('/update/images', 'UsersController@updateImages');



    Route::get('/logout', function() {
        \Illuminate\Support\Facades\Auth::logout();
        return redirect('/login');
    });
});
//admin forgot password
Route::get('/forgot/password', 'UsersController@forgotPasswordView');
Route::post('/send/mail_link', 'UsersController@sendMailLink');


//user forgot password
Route::get('/redirect_link', [
    'uses' => 'ForgotPasswordController@showPasswordView',
]);
Route::post('/reset_password', [
    'uses' => 'ForgotPasswordController@resetPassword',
]);
