<?php

namespace App\Http\Controllers;



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
use App\UserSession;
use App\Welcome;
use App\Notification;
use App\Session;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


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

    }



    public function social_register(Request $request)
    {

        try {


            $validator = Validator::make($request->all(), [
                'social_id' => 'required|min:2|max:50',
                'social_type' => 'required|email|unique:users',

                'device_type' => 'required',
                'device_id' => 'required',
                'device_token' => 'required',


            ]);

            if ($validator->fails()) {
                return ['status' => 400, 'message' => $validator->errors()->all()[0], 'data' => []];
            }



            $input = request()->except('password');

            $user=new User($input);



            $user->password=bcrypt(request()->password);

            $user->save();



            $user_session = new UserSession();

            $user_session->device_id= $request->device_id;
            $user_session->user_id= $user->id;
            $user_session->device_type= $request->device_type;
            $user_session->device_token= $request->device_token;
            $user_session->session_id= bcrypt($user->id);

            $user_session->save();


            $user->session_id = $user_session->session_id;





            return ['status' => "200", 'message' => 'Congragulation you are registered sucessfully', 'data' => $user];




        //    $user = $this->usersRepo->store($request->attributes());
//            if($request->input('user_image') != null){
//                $user_image = $this->getProfileImage($request->input('user_image'), $user->id);
//                $this->usersRepo->updateWhere(['id' => $user->id],['user_image' => $user_image]);
//            }
//            $loggedInUser = PAuth::login($this->usersRepo->findById($user->id),$request->input('device_id'));
//            return $this->p_response->respond(['data' => $loggedInUser,
//                'session_id' => $loggedInUser->session_id
//            ]);
        }
        catch(\Exception $e){
              return ['status' => 500, 'message' => "Some Thing Wet Wrong", 'data' => []];;
        }
    }


    public function register(Request $request)
    {

        try {


            $validator = Validator::make($request->all(), [
                'user_name' => 'required|min:2|max:50',
                'email' => 'required|email|unique:users',
                'first_name' => 'required|min:2|max:50',
                'last_name' => 'required|min:2|max:50',
                'phone' => 'required|numeric',
                'device_type' => 'required',
                'device_id' => 'required',
                'device_token' => 'required',
                'password' => 'required|min:6'

            ]);

            if ($validator->fails()) {
                return ['status' => 400, 'message' => $validator->errors()->all()[0], 'data' => []];
            }



            $input = request()->except('password');

            $user=new User($input);



            $user->password=bcrypt(request()->password);

            $user->save();



            $user_session = new UserSession();

            $user_session->device_id= $request->device_id;
            $user_session->user_id= $user->id;
            $user_session->device_type= $request->device_type;
            $user_session->device_token= $request->device_token;
            $user_session->session_id= bcrypt($user->id);

            $user_session->save();


            $user->session_id = $user_session->session_id;





            return ['status' => "200", 'message' => 'Congragulation you are registered sucessfully', 'data' => $user];




        //    $user = $this->usersRepo->store($request->attributes());
//            if($request->input('user_image') != null){
//                $user_image = $this->getProfileImage($request->input('user_image'), $user->id);
//                $this->usersRepo->updateWhere(['id' => $user->id],['user_image' => $user_image]);
//            }
//            $loggedInUser = PAuth::login($this->usersRepo->findById($user->id),$request->input('device_id'));
//            return $this->p_response->respond(['data' => $loggedInUser,
//                'session_id' => $loggedInUser->session_id
//            ]);
        }
        catch(\Exception $e){
              return ['status' => 500, 'message' => "Some Thing Wet Wrong", 'data' => []];;
        }
    }


    public function session_out()
    {
        return ['status' => 401, 'message' => "Session out please login", 'data' => []];;
    }
    public function show_user(Request $request)
    {



        try {

            $user = User::all();
            return ['status' => 200, 'message' => "all user", 'data' => ['session_id'=> $user]];

        }

        catch(\Exception $e){
          return $e;
//            return ['status' => 500, 'message' => "Some Thing Wet Wrong", 'data' => []];
        }
    }
    public function social_login(Request $request)
    {
        dd($request);

        try {
            $user = PAuth::attempt(['email'=>$request->input('email'), 'password'=> $request->input('password')]);

            if($user != null){


                $user_session=UserSession::where('device_id',$request->device_id)
                    ->where('device_token',$request->device_token)
                    ->where('user_id',$user->id)->first();

                if($user_session!= null)
                {
                    //dd('already');
                    $user_session->session_id= bcrypt($user->id);
//                dd($user_session);
                    $user_session->save();
                }
                else
                {

                   // dd('new');
                    $user_session = new UserSession();

                    $user_session->device_id= $request->device_id;
                    $user_session->user_id= $user->id;
                    $user_session->device_type= $request->device_type;
                    $user_session->device_token= $request->device_token;
                    $user_session->session_id= bcrypt($user->id);
                    $user_session->save();
                }

                return ['status' => 400, 'message' => "You are Login Successfully", 'data' => ['session_id'=> $user_session->session_id]];
            }else{
                return ['status' => 401, 'message' => "you entered wrong user name and password", 'data' => []];;
            }
        }

        catch(\Exception $e){
            return $e;
//            return ['status' => 500, 'message' => "Some Thing Wet Wrong", 'data' => []];
        }
    }


    public function login(Request $request)
    {

        try {
            $user = PAuth::attempt(['email'=>$request->input('email'), 'password'=> $request->input('password')]);

            if($user != null){


                $user_session=UserSession::where('device_id',$request->device_id)
                    ->where('device_token',$request->device_token)
                    ->where('user_id',$user->id)->first();

                if($user_session!= null)
                {
                    //dd('already');
                    $user_session->session_id= bcrypt($user->id);
//                dd($user_session);
                    $user_session->save();
                }
                else
                {

                   // dd('new');
                    $user_session = new UserSession();

                    $user_session->device_id= $request->device_id;
                    $user_session->user_id= $user->id;
                    $user_session->device_type= $request->device_type;
                    $user_session->device_token= $request->device_token;
                    $user_session->session_id= bcrypt($user->id);
                    $user_session->save();
                }

                return ['status' => 400, 'message' => "You are Login Successfully", 'data' => ['session_id'=> $user_session->session_id]];
            }else{
                return ['status' => 401, 'message' => "you entered wrong user name and password", 'data' => []];;
            }
        }

        catch(\Exception $e){
            return $e;
//            return ['status' => 500, 'message' => "Some Thing Wet Wrong", 'data' => []];
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
