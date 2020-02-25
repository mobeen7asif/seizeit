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

use App\Uni;
use Illuminate\Support\Facades\Artisan;

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



Route::get('/login',function()
{
    return view('login');
})->name('login');

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

    Route::get('/uni/status/{uni_id}/{status}', function($uni_id,$status) {
        DB::table('uni')->where('id',$uni_id)->update(['status' => $status]);
        return redirect()->back()->with('success','Uni status updated');
    });


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


    Route::get('/majors', 'MajorsController@getMajors');
    Route::get('/add/major', 'MajorsController@showMajorView');
    Route::post('/add/major', 'MajorsController@addMajor');
    Route::get('/update/major/{id}', 'MajorsController@editMajorForm');
    Route::post('/update/major/{id}', 'MajorsController@updateMajor');
    Route::get('/delete/major/{id}', 'MajorsController@deleteMajor');
    Route::get('/major/detail/{id}', 'MajorsController@majorDetail');
    Route::post('/major/bulk/delete', 'MajorsController@deleteMajors');


    Route::get('/categories', 'CategoriesController@getCategories');
    Route::get('/add/category', 'CategoriesController@showCategoryView');
    Route::post('/add/category', 'CategoriesController@addCategory');
    Route::get('/update/category/{id}', 'CategoriesController@editCategoryForm');
    Route::post('/update/category/{id}', 'CategoriesController@updateCategory');
    Route::get('/delete/category/{id}', 'CategoriesController@deleteCategory');
    Route::get('/category/detail/{id}', 'CategoriesController@categoryDetail');
    Route::post('/category/bulk/delete', 'CategoriesController@deleteCategories');
    Route::get('/sub/categories/{id}', 'CategoriesController@subCategories');

    Route::get('/links', 'CategoriesController@getLinks');
    Route::get('/add/link', 'CategoriesController@showLinkView');
    Route::post('/add/link', 'CategoriesController@addLink');
    Route::get('/update/link/{id}', 'CategoriesController@editLinkForm');
    Route::post('/update/link/{id}', 'CategoriesController@updateLink');
    Route::get('/delete/link/{id}', 'CategoriesController@deleteLink');
    Route::post('/link/bulk/delete', 'CategoriesController@deleteLinks');



    Route::get('/sub/categories', 'SubCategoriesController@getSubCategories');
    Route::get('/add/sub/category/{major_id?}', 'SubCategoriesController@addSubCategoryVew');
    Route::get('/update/sub/category/{sub_id}', 'SubCategoriesController@updateSubCategoryView');
    Route::post('/update/sub/category', 'SubCategoriesController@updateSubCategory');
    Route::get('/delete/sub/category/{id}', 'SubCategoriesController@deleteSubCategory');
    Route::post('/sub/category/bulk/delete', 'SubCategoriesController@bulkDeleteSubCategory');

    Route::get('/add/custom/category', 'SubCategoriesController@addCustomCategoryView');
    Route::post('/add/custom/category', 'SubCategoriesController@addCustomCategory');

    Route::get('/get-major-category', 'SubCategoriesController@getMajorCategories');







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
    Route::post('/sort/majors', 'MajorsController@sortMajors');
    Route::post('/sort/categories', 'CategoriesController@sortCategories');


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


Route::post('/add/sub/category', 'SubCategoriesController@addSubCategory');


Route::get('/cache-clear', function() {


    $x = "Barnes &amp; Noble College is a retail environment like no other &ndash; uniquely focused on delivering outstanding customer service. Our stores can carry everything from text and trade books, technology, and school supplies to clothing, regalia, and food- everything a college student desires, their parents want, and our faculty needs.\n\nAs an Assistant Department Manger (Full-Time): Operations\u002FTrade\u002FMarketing you will support all store operations and departments in partnership with the management team. You will manage the daily activities in a Bookmaster store to assist campus or campus and general community customers with locating academic or leisure materials for purchase. You will ensure the availability of complementary products and supplies; manage promotions, book fairs, author, and faculty author events; while spending time on the sales floor training and modeling skills to ensure well stocked and visually appealing areas. There may be times where you will spend significant time outside of the store setting, engaged in sales activities such as outreach, client meetings, and presentations with the goal of obtaining sales commitments from existing and prospective clients. You must have effective presentation skills, the ability to influence audiences in formal and informal settings, and exceptional listening and communication abilities to adapt to various environments and situations. When on site in the store you will support all store operations and departments in partnership with the management team to include management of daily sales activities, maintenance of appealing displays, and providing direction and support to booksellers. You will use your rapport building and collaborative abilities to generate and sustain relationships with clients, peers, and the store team.\n\n\nExpectations:\n\nManage Trade Department &ndash; Follow daily instructions on INSIDE and complete tasks accordingly. Refresh and merchandise title selections by responding to national trends as well as campus &amp; current events and hyper-local interests.\nDepartment Liaison - Research campus events and faculty authors to establish a relationship with these contacts. Follow up with phone calls, emails and department meetings &amp; visits. Increase trade sales by asking about a department's budget and spending abilities. Develop concierge book ordering and delivery program.\nCommunity Liaison - Reach out to local elementary, middle, high and private schools for book lists sales opportunities. Annually coordinate the Giving Tree operations, including book orders, marketing and sales at each register. Work with local non-profit organizations to offer books sold.\nDrive bulk book sales and store traffic through outreach to prospective institutional, corporate, and local community groups and organizations by conducting sales calls and making presentations.\nConduct strategic and effective sales presentations with representatives of local schools, nonprofit agencies, and literary organizations to cultivate existing accounts and to generate new business.\nResearch the local community and identify business opportunities, create and implement programs to expand sales potential.\nSpecial Events- Plan, promote, and oversee the execution of store events in partnership with store management. Work across all departments to develop and execute events that drive in-store traffic and engagement.\nAssist Operations Department - Assist Operations Manager with bookseller interviews, hiring process, on-boarding paperwork and initial informational training during Rush recruiting.\nOrientation Liaison &ndash; Work with First Year Experience to coordinate training materials, donations and O-Team&rsquo;s training sessions. During UCF&rsquo;s Transfer and First Time In College orientations, create and present bookstore information to incoming students.\nSocial Media - Manage the bookstore's social media accounts. Working with the Home Office's direction for corporate vs in-store postings, create a calendar identifying days that need a post. Partner with department managers to promote store events, sales and other happenings. Recognize media trends and viral videos to create relevant content that speaks to our customers.\nMaintain a presence on the sales floor to greet customers, answer questions about general or reference books, recommend products and\u002For services, and help locate or obtain materials using ISBNs, knowledge of authors, and publications and provide daily support, direction, and guidance to booksellers..\nAbility to use department specific technology and assist in the daily operation of the store in partnership with the Store Manager, Assistant Store Manager and the management team.\nAssist with processing sales transactions involving cash, credit, or financial aid payments.\n Full-time positions require availability to work at least 30 hours on a weekly basis year round. Schedules may be set or vary to meet the needs of the store.\n\n\nPhysical Demands:\n\nFrequent movement within the store, among the community, and campus to access various departments, areas, and\u002For products.\nAbility to remain in a stationary position for extended periods.\nFrequent lifting.\nOccasional reaching, stooping, kneeling, crouching, and climbing ladders.\n\n\nQualifications:\n\n2+ years&rsquo; experience in a retail setting as a manager or buyer or experience in commercial sales or public relations is required. Graduate of the Barnes &amp; Noble College Bestseller program is a plus.\nExperience in one or more of the following fields- sales (preferably outbound sales in retail), education, marketing, fundraising and development, or public relations.\nOutstanding computer skills including proficiency with the internet, social media, Excel, Word, and PowerPoint.\nStrong presentation, written, and verbal communication skills.\nExcellent customer service and communication skills needed.\nStrong interpersonal, communication, and problem solving skills.\nValid driver&rsquo;s license and access to reliable transportation.\nAbility to work a flexible schedule including evenings, weekends, and holidays.\n\n\nBarnes &amp; Noble College is an Equal Employment Opportunity and Affirmative Action Employer committed to diversity in the workplace. Qualified applicants will receive consideration for employment without regard to race, color, religion, sex, national origin, sexual orientation, gender identity, disability or protected veteran status.";
    $x = htmlspecialchars_decode($x);

    $str = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
        return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
    }, $x);
    print_r($str);
    exit;

/*    Artisan::call('cache:clear');
    return "Cache is cleared";*/
});
