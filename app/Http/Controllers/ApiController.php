<?php

namespace App\Http\Controllers;



use App\Category;
use App\Libs\Auth\PAuth;
use App\Libs\Helpers\Helper;
use App\Major;
use App\Repositories\ActivitiesRepository;
use App\Repositories\EventsRepository;
use App\Repositories\NotificationsRepository;
use App\Repositories\UniRepository;
use App\Repositories\MajorRepository;
use App\Repositories\SupplementsRepository;
use App\Repositories\UsersRepository;
use App\SubCategory;
use App\Uni;
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



    public function socialLogin(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'social_id' => 'required|min:2|max:300',
                'social_type' => 'required',
                'device_type' => 'required',
                'device_id' => 'required',
                'device_token' => 'required',


            ]);

            if ($validator->fails()) {
                return ['status' => 400, 'message' => $validator->errors()->all()[0], 'data' => []];
            }

            $user = User::where(['social_id' => $request->social_id,'social_type' => $request->social_type])->first();
            $input = $request->only('first_name', 'last_name','social_id','social_type','email');
            if(!$user) {
                $check_pre_user = User::where('email',$request->email)->first();
                if($check_pre_user) {
                    $check_pre_user->update($input);
                }
                else {
                    $user = User::create($input);
                }

            }
            else {
                 User::where('id',$user->id)->update($input);
                 $user = User::find($user->id);
            }


            $user_session=UserSession::where('device_id',$request->device_id)
                ->where('device_token',$request->device_token)
                ->where('user_id',$user->id)->first();

            if($user_session!= null)
            {
                //dd('already');
                $user_session->session_id= bcrypt($user->id);
//                dd($user_session);
                $user_session->save();
                $user->session_id = $user_session->session_id;
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
                $user->session_id = $user_session->session_id;
            }

            return ['status' => 200, 'data' => [
                'user' => $user,
                'unis' => Uni::all(),
                'majors' => Major::all()
            ],'message' => 'User Logged in'];

        }
        catch(\Exception $e){
            dd($e->getLine());
              return ['status' => 500, 'message' => "Something went wrong", 'data' => []];
        }
    }


    public function register(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'user_name' => 'min:2|max:50',
                'email' => 'required|email|unique:users',
                'first_name' => 'required|min:2|max:50',
                'last_name' => 'required|min:2|max:50',
                'device_type' => 'required',
                'device_id' => 'required',
                'device_token' => 'required',
                'password' => 'required|min:6'

            ]);

            if ($validator->fails()) {
                return ['status' => 400, 'message' => $validator->errors()->all()[0], 'data' => []];
            }

            $input = request()->only('first_name','last_name','email','user_name');

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
            return ['status' => 200, 'data' => [
                'user' => $user,
                'unis' => Uni::all(),
                'majors' => Major::all()
            ],'message' => 'User registered'];

        }
        catch(\Exception $e){
            dd($e->getMessage());
              return ['status' => 500, 'message' => "Something went wrong", 'data' => []];
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



    public function login(Request $request)
    {

        try {
            $user = PAuth::attempt(['email'=>$request->input('email'), 'password'=> $request->input('password')]);

            if($user != null)
            {
                $user_session=UserSession::where('device_id',$request->device_id)
                    ->where('device_token',$request->device_token)
                    ->where('user_id',$user->id)->first();

                if($user_session!= null)
                {
                    //dd('already');
                    $user_session->session_id= bcrypt($user->id);
//                dd($user_session);
                    $user_session->save();
                    $user->session_id = $user_session->session_id;
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

                    $user->session_id = $user_session->session_id;
                }

                return ['status' => 200, 'data' => [
                    'user' => $user,
                    'unis' => Uni::all(),
                    'majors' => Major::all()
                ],'message' => 'User Logged in'];
            }else{
                return ['status' => 401, 'message' => "Invalid email or password", 'data' => []];
            }
        }

        catch(\Exception $e){
            return $e;
//            return ['status' => 500, 'message' => "Some Thing Wet Wrong", 'data' => []];
        }
    }

    public function getData(Request $request) {
        $data = SubCategory::with('uni','major','category')->where([
            'uni_id' => $request->uni_id,
            'major_id' => $request->major_id,
            'category_id' => $request->category_id
        ])->get();
        return ['status' => true, 'data' => $data];
    }







}
