<?php

namespace App\Http\Controllers;



use App\Category;
use App\Libs\Auth\Auth;
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
use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Requests\ForgotPasswordRequest;
use function foo\func;


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
            $input['user_type'] = 0;
            if(!$user) {
                $check_pre_user = User::where('email',$request->email)->first();
                if($check_pre_user) {
                    $check_pre_user->update($input);
                }
                else {
                    $user = User::create($input);

                }
                $user = User::where('email',$request->email)->first();
                $viewData['first_name'] = $user->first_name;
                $viewData['last_name'] = $user->last_name;
                //send welcome email
                Mail::send('welcome_email', $viewData, function ($m) use ($user) {
                    $m->from('noreply@joinseizeit.com', 'SeizeIt');
                    $m->to($user->email)->subject('Thank you!');

                });

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
            ],'message' => 'User Logged in'];

        }
        catch(\Exception $e){
              return ['status' => 500, 'message' => $e->getMessage(), 'data' => []];
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
            $input['user_type'] = 0;
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

            $viewData['first_name'] = $user->first_name;
            $viewData['last_name'] = $user->last_name;
            //send welcome email
            Mail::send('welcome_email', $viewData, function ($m) use ($user) {
                $m->from('noreply@joinseizeit.com', 'SeizeIt');
                $m->to($user->email)->subject('Thank you!');

            });

            return ['status' => 200, 'data' => [
                'user' => $user,
            ],'message' => 'User registered'];

        }
        catch(\Exception $e){
              return ['status' => 500, 'message' => $e->getMessage(), 'data' => []];
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
                ],'message' => 'User Logged in'];
            }else{
                return ['status' => 401, 'message' => "Invalid email or password", 'data' => []];
            }
        }

        catch(\Exception $e){
            return ['status' => 500, 'message' => $e->getMessage(), 'data' => []];
        }
    }

    public function getData(Request $request) {
        $page = $request->page;
        $page = !empty($page) ? $page : 1;
        $data = SubCategory::with('uni','major','category')->where([
            'uni_id' => $request->uni_id,
            'major_id' => $request->major_id,
            'category_id' => $request->category_id
        ])->offset($page*10-10)->limit(10)->get();

        return ['status' => 200, 'data' => $data,'page' => (count($data) >= 10) ? $page+1:null];
    }

    public function getDetail(Request $request) {

        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:sub_categories,id',
            ]);

            if ($validator->fails()) {
                return ['status' => 400, 'message' => $validator->errors()->all()[0], 'data' => []];
            }

            $data = SubCategory::with('uni', 'major', 'category')->where([
                'id' => $request->id,
            ])->first();

            $data->description = isset($data->description) ? $this->removeSpecialChars($data->description) : $data->description;
            $data->summary = isset($data->summary) ? $this->removeSpecialChars($data->summary) : $data->summary;


            return ['status' => 200, 'message' => 'Data found', 'data' => $data];
        } catch(\Exception $e) {
            return ['status' => 500, 'data' => [], 'message' => $e->getMessage()];
        }
    }
    public function removeSpecialChars($data_str) {
        $str = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
        }, htmlspecialchars_decode($data_str));
        return str_replace('\n',' ',$str);

    }

    public function getUniMajors(Request $request) {
        try {

            $uni = Uni::where('status',1)->orderBy('name','ASC')->get();
            $uni = $uni->map(function($data) {
                if(!empty($data->image)) {
                    $data->image =  url('/').$data->image;
                }
                else {
                    $data->image =  '';
                }
                return $data;

            });

            return ['status' => true, 'message' => 'Data found', 'data' => [
                'uni' => $uni,
                'majors' => Major::orderBy('name','ASC')->get()
            ]];
        }
        catch(\Exception $e) {
            return ['status' => 500, 'data' => [], 'message' => $e->getMessage()];
        }
    }
    public function getCategories(Request $request) {
        try {
            $categories = Category::all();
            $categories = $categories->map(function($category) {
                if(!empty($category->image)) {
                    $category->image =  url('/').$category->image;
                }
                else {
                    $category->image =  '';
                }
                return $category;

            });
            return ['status' => 200, 'message' => 'Data found', 'data' => $categories];
        }
        catch(\Exception $e) {
            return ['status' => 500, 'data' => [], 'message' => $e->getMessage()];
        }
    }


    public function forgotPassword(Request $request)
    {
        try {
            $user = $this->usersRepo->findByEmail($request->input('email'));
            if($user != null){
                $length = 50;
                $token = bin2hex(random_bytes($length));
                $user->token = $token;
                $user->update();
                $viewData['id'] = $user->id;
                $viewData['token'] = $user->token;
                Mail::send('forgetpass', $viewData, function ($m) use ($user) {
                    $m->from('noreply@joinseizeit.com', 'SeizeIt');
                    $m->to($user->email)->subject('Forget Password');

                });
                return ['status' => 200,'message' => 'Email is send to your account','data' => []];
            }
            return ['status' => 404,'message' => 'This user does not exist','data' => []];

        }
        catch(\Exception $e){
            return ['status' => 500,'message' => $e->getMessage(),'data' => []];
        }
    }
    public function feedback(Request $request) {

        try {
            $validator = Validator::make($request->all(), [
                'rating' => 'required',
                'message' => 'required'
            ]);

            if ($validator->fails()) {
                return ['status' => 400, 'message' => $validator->errors()->all()[0], 'data' => []];
            }
            $user = Auth::user();
            $request->request->add(['first_name' => $user->first_name,'last_name' => $user->last_name]);
            $requestData = $request->all();
            $viewData['rating'] = $requestData['rating'];
            $viewData['feedback'] = $requestData['message'];
            $viewData['first_name'] = $user->first_name;
            $viewData['last_name'] = $user->last_name;
            Mail::send('feedback', $viewData, function ($m) use($user) {
                $m->from('admin@seizeit.com', 'SeizeIt');
                $m->to('joinseizeit@outlook.com')->subject('User Feedback');

            });

            return ['status' => 200, 'message' => 'Feedback is submitted', 'data' => []];
        } catch(\Exception $e) {
            return ['status' => 500, 'data' => [], 'message' => $e->getMessage()];
        }
    }


    public function removeUScript(Request $request) {
        set_time_limit(0);
        $count = 0;
        $not_found = 0;
        try {
            //get correct data
            $prod_data = DB::table('sub_categories')->where('uni_id',51)->get();
            foreach($prod_data as $data) {
                $record = DB::table('correct_data')->where('title',$data->title)->first();
                if($record) {
                    if(isset($record->summary) and $record->summary != "") {
                        DB::table('sub_categories')->where('id',$data->id)->update(['summary' => $record->summary]);
                    }
                    if(isset($record->description) and $record->description != "") {
                        DB::table('sub_categories')->where('id',$data->id)->update(['description' => $record->description]);
                    }
                }
                else {
                    $not_found++;
                }
                $count++;
            }
            return ['total_count' => $count, 'not_found' => $not_found];
        }
        catch(\Exception $e) {
            Log::info('removeUScript',['message' => $e->getMessage(),'line' => $e->getLine()]);
        }
    }
    public function expiredLinks(Request $request) {

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', 'https://www.indeed.com/rc/clk?jk=385c775ea9ca7b8b&fccid=f7b21cff2d75be8f&vjs=3');
            $page_data = $response->getBody()->getContents();
            dd($page_data);
        }
        catch(\Exception $e) {
            if($e->getCode() == 404) {
                dd("sada");
            }
            dd($e->getCode());
        }






        Log::info('comman_work',['comman_work' => 'working']);
        ///usr/local/bin/php /home/r3t7d120d89b/public_html/admin/artisan schedule:run >> /dev/null 2>&1
        set_time_limit(0);
        try {
            $insert_record = DB::table('record_status')->orderBy('insert_id','DESC')->first();
            if($insert_record) {
                $id = $insert_record->insert_id;
            }
            else {
                $rec = DB::table('sub_categories')->where('link', 'like', '%indeed.com%')->first();
                $id = $rec->id;
            }
            /*            $id = $request->input('id');
                        $arr = [];
                        if($id == 0) {
                            $rec = DB::table('sub_categories')->where('link', 'like', '%indeed.com%')->first();
                            $id = $rec->id;
                        }*/
            $search = "This job has expired on Indeed";
            $prod_data = DB::table('sub_categories')->where('link', 'like', '%indeed.com%')
                ->take(100)->where('id' ,'>', $id)->get();
            if($prod_data->count() > 0) {
                Log::info('data finished',['data finished' => 'data finished']);
            }
            foreach($prod_data as $data) {
                DB::table('record_status')->insert(['insert_id' => $data->id]);
                if(isset($data->link) and $data->link != "") {
                    try {
                        $client = new \GuzzleHttp\Client();
                        $response = $client->request('GET', $data->link);
                        $page_data = $response->getBody()->getContents();
                        if(preg_match("/{$search}/i", $page_data)) {
                            echo "<pre>";
                            echo $data->link."<br>";
                            DB::table('sub_categories')->where('id',$data->id)->update(['is_active' => 0]);
                            $arr[] = $data->link;
                        }

                        /*$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
                        //Basically adding headers to the request
                        $context = stream_context_create($opts);
                        $page_data = file_get_contents($data->link,false,$context);*/
                        //$page_data = file_get_contents($data->link);
                    }
                    catch (\Exception $e) {
                        Log::info('failed_records',['message' => $e->getMessage(),'line' => $e->getLine()]);
                        continue;
                    }
                }
            }
            $record_status = DB::table('record_status')->orderBy('insert_id','DESC')->first();
            return ['inserd_id' => $record_status->insert_id];
        }
        catch(\Exception $e) {
            Log::info('expiredLinks',['message' => $e->getMessage(),'line' => $e->getLine()]);
        }
        //$data = file_get_contents('https://www.indeed.com/viewjob?jk=e5fa1aa7fef745fc&from=serp&vjs=3');
    }







}
