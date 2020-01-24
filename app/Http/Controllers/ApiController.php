<?php

namespace App\Http\Controllers;


use App\Http\PResponse;
use App\Http\Requests\AddSpeakerRequest;
use App\Http\Requests\ChangeImageRequest;
use App\Http\Requests\UpdateContentRequest;
use App\Http\Requests\UpdateSpeakerRequest;
use App\Libs\Auth\PAuth;
use App\Libs\Helpers\Helper;
use App\Repositories\ActivitiesRepository;
use App\Repositories\EventsRepository;
use App\Repositories\NotificationsRepository;
use App\Repositories\UniRepository;
use App\Repositories\MajorRepository;
use App\Repositories\SupplementsRepository;
use App\Repositories\UsersRepository;
use App\User;
use App\Welcome;
use App\Notification;
use App\Session;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Requests\ChangePasswordRequest;
use Requests\ForgotPasswordRequest;
use Requests\GetActivitiesRequest;
use Requests\GetContentRequest;
use Requests\GetEventsRequest;
use Requests\GetNotificationsRequest;
use Requests\GetSpeakersRequest;
use Requests\GetSponsorsRequest;
use Requests\GetSupplementsRequest;
use Requests\LoginRequest;
use Requests\LogoutRequest;
use Requests\RegisterRequest;
use Requests\Request;


class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $usersRepo = null;
    public $speakerRepo = null;
    public $p_response = null;
    public $sponsorsRepo = null;
    public $activityRepo = null;
    public $eventsRepo = null;
    public $supplementRepo = null;
    public $notificationsRepo = null;
    public function __construct(NotificationsRepository $notificationsRepo, SupplementsRepository $supplementRepo, EventsRepository $eventsRepo, ActivitiesRepository $activityRepo, MajorRepository $sponsorsRepo, UsersRepository $usersRepo, UniRepository $speakerRepo)
    {
        $this->usersRepo = $usersRepo;
        $this->speakerRepo = $speakerRepo;
        $this->sponsorsRepo = $sponsorsRepo;
        $this->activityRepo = $activityRepo;
        $this->eventsRepo = $eventsRepo;
        $this->supplementRepo = $supplementRepo;
        $this->notificationsRepo = $notificationsRepo;
        $this->p_response = new PResponse();
    }
    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->usersRepo->store($request->attributes());
//            if($request->input('user_image') != null){
//                $user_image = $this->getProfileImage($request->input('user_image'), $user->id);
//                $this->usersRepo->updateWhere(['id' => $user->id],['user_image' => $user_image]);
//            }
            $loggedInUser = PAuth::login($this->usersRepo->findById($user->id),$request->input('device_id'));
            return $this->p_response->respond(['data' => $loggedInUser,
                'session_id' => $loggedInUser->session_id
            ]);
        }
        catch(\Exception $e){
            return $this->p_response->respondInternalServerError($e->getMessage());
        }
    }
    public function login(LoginRequest $request)
    {
        try {
            $user = PAuth::attempt(['email'=>$request->input('email'), 'password'=> $request->input('password')]);
            if($user != null){
                $user = PAuth::login($user,$request->input('device_id'));
                return $this->p_response->respond([
                    'data' => [
                        'user' => $user,
                        'welcome' => Welcome::find(1),
                        'events' => $this->eventsRepo->getEventDetails(),
                        'activities' => $this->activityRepo->getActivities(),
                        'majors' => $this->sponsorsRepo->getSponsors(),
                        'speakers' => $this->speakerRepo->getSpeakers()

                    ],
                    'session_id' => $user->session_id
                ]);
            }else{
                return $this->p_response->respondInvalidCredentials();
            }
        }

        catch(\Exception $e){
            return $this->p_response->respondInternalServerError($e->getMessage());
        }
    }
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            //$user = DB::table('users')->where('user_type', 0)->inRandomOrder()->first();
            $user = $this->usersRepo->findByEmail($request->input('email'));
            if($user != null){
                $length = 50;
                $token = bin2hex(random_bytes($length));
                $user->token = $token;
                $user->update();
                $viewData['id'] = $user->id;
                $viewData['token'] = $user->token;
                Mail::send('forgetpass', $viewData, function ($m) use ($user) {
                    $m->from('test@codingpixel.com', 'PFF');
                    $m->to($user->email)->subject('Forget Password');

                });
            }
            return $this->p_response->respond();
        }
        catch(\Exception $e){
            return $this->p_response->respondInternalServerError($e->getMessage());
        }
    }
    public function getSponsors(GetSponsorsRequest $request){
        try {
            $page = $request->get('page');
            $sponsors = $this->sponsorsRepo->getSponsors((isset($page))?$page:0);
            return $this->p_response->respond(['data' => $sponsors]);
        }
        catch(\Exception $e){
            return $this->p_response->respondInternalServerError($e->getMessage());
        }

    }
    public function getSpeakers(GetSpeakersRequest $request){
        try {
            $page = $request->get('page');
            $speakers = $this->speakerRepo->getSpeakers((isset($page))?$page:0);
            return $this->p_response->respond(['data' => $speakers]);
        }
        catch(\Exception $e){
            return $this->p_response->respondInternalServerError($e->getMessage());
        }
    }
    public function getActivities(GetActivitiesRequest $request){
        try {
            $page = $request->get('page');
            $activities = $this->activityRepo->getActivities((isset($page))?$page:0);
            return $this->p_response->respond(['data' => $activities]);
        }
        catch(\Exception $e){
            return $this->p_response->respondInternalServerError($e->getMessage());
        }
    }
    public function getEvents(GetEventsRequest $request){
        try {
            $page = $request->get('page');
            $events = $this->eventsRepo->getEventDetails((isset($page))?$page:0);
            return $this->p_response->respond(['data' => $events]);
        }
        catch(\Exception $e){
            return $this->p_response->respondInternalServerError($e->getMessage());
        }
    }
    public function welcomeContent(){
        try {
           $welcome = Welcome::find(1);
            return $this->p_response->respond(['data' => $welcome]);
        }
        catch(\Exception $e){
            return $this->p_response->respondInternalServerError($e->getMessage());
        }
    }
    public function logout(LogoutRequest $request){
        try {
            $this->usersRepo->updateWhere(['id' => $request->user()->id],['session_id' => '']);
            return $this->p_response->respond();
        }
        catch(\Exception $e){
            return $this->p_response->respondInternalServerError($e->getMessage());
        }
    }
    public function getAllData(GetContentRequest $request){
        try {
                return $this->p_response->respond([
                    'data' => [
                        'user' => $request->user(),
                        'welcome' => Welcome::find(1),
                        'events' => $this->eventsRepo->getEventDetails(),
                        'activities' => $this->activityRepo->getActivities(),
                        'majors' => $this->sponsorsRepo->getSponsors(),
                        'speakers' => $this->speakerRepo->getSpeakers()

                    ],
                ]);
        }
        catch(\Exception $e){
            return $this->p_response->respondInternalServerError($e->getMessage());
        }
    }
    public function getSupplements(GetSupplementsRequest $request){
        try {
            $page = $request->get('page');
            return $this->p_response->respond(['data' => $this->supplementRepo->getSupplements((isset($page))?$page:0)]);
        }
        catch(\Exception $e){
            return $this->p_response->respondInternalServerError($e->getMessage());
        }
    }

    public function getNotifications(GetNotificationsRequest $request){
        try {
            $number = $request->get('page');
            if(!isset($number)){
                $number = 0;
            }
            $skip = $number * 5;
            $notifications = Notification::with('session','session.event')->where(function($q){
                $q->where('created_at', '>=', \Carbon\Carbon::parse("-2 days"));
            })->skip($skip)->take(5)->get();

            return $this->p_response->respond([
                'data' => $notifications
            ]);
        }
        catch(\Exception $e){
            return $this->p_response->respondInternalServerError($e->getMessage());
        }
    }
    public function changePassword(ChangePasswordRequest $request){
        try {
            $new_pass = $request->input('new_password');
            $old_pass = $request->input('old_password');
            if(Hash::check($old_pass,PAuth::user()->password)){
                $this->usersRepo->updateWhere(['id' => PAuth::user()->id],['password' => bcrypt($new_pass),'user_pass' => $new_pass],
                    ['password_status' => 1]);
                return $this->p_response->respond();
            } else{
                return $this->p_response->respondInvalidCredentials(['Old password is incorrect']);}
        }
        catch(\Exception $e){
            return $this->p_response->respondInternalServerError($e->getMessage());
        }
    }

    public function transform(&$sponsors){
        foreach($sponsors as $sponsor){
            if(isset($sponsor->image)){
                $sponsor->image = url('/').$sponsor->image;
            }
        }
        return $sponsors;
    }


}
