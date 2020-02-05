<?php

namespace App\Http\Controllers;


use App\Http\Requests\Admin\AddUniRequest;

use App\Http\Requests\Admin\AddUserRequest;
use App\Http\Requests\Admin\ChangeImageRequest;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Http\Requests\Admin\UpdateContentRequest;
use App\Http\Requests\Admin\UpdateSpeakerRequest;
use App\Http\Requests\Admin\UpdateUniRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Major;
use App\Repositories\EventsRepository;
use App\Repositories\ImagesRepository;
use App\Repositories\MajorRepository;
use App\Repositories\UniRepository;
use App\Repositories\UsersRepository;
use App\Uni;
use App\UniMajor;
use App\User;
use App\Welcome;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;


class UsersController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $usersRepo = null;
    public $uniRepo = null;
    public $eventsRepo = null;
    public $imagesRepo = null;
    public function __construct(ImagesRepository $imagesRepo, EventsRepository $eventsRepo, UsersRepository $usersRepo, UniRepository $uniRepo)
    {
        $this->usersRepo = $usersRepo;
        $this->uniRepo = $uniRepo;
        $this->eventsRepo = $eventsRepo;
        $this->imagesRepo = $imagesRepo;
    }

    public function dashboard(){
        $users = User::all();
        return view('users.view_users',['title' => 'users','users' => $users]);
    }

    public function login($remember = 1){
        if (Auth::attempt(['password' => $_POST['password'], 'email' => $_POST['email']], $remember)) {
            if(Auth::user()->user_type == 1 || Auth::user()->user_type == 2){
                return redirect('dashboard');
            }else{
                $error_message = 'You Are not allowed to login';
                return redirect()->back()->with('error', $error_message)->withInput();
            }
        } else {
            Auth::logout();
            $error_message = 'Invalid Email or Password';
            return redirect()->back()->with('error', $error_message);

        }
    }

    public function getUni(Request $request){
     /*   $status = $request->get('sort_status');
        if(isset($status)){
            $unis = $this->uniRepo->getByNames();
            $i = 0;
            foreach($unis as $uni){
                DB::table('uni')->where('id',$uni->id)->update(['sort_id' => $i]);
                $i++;
            }
            return redirect('/uni');
        }*/
        $uni = DB::table('uni')->get();
        return view('uni.uni',['title' => 'uni','unis' => $uni]);
    }
    public function sortUni(Request $request){
        DB::table('settings')->where('id' , 1)->update(['uni_sort' => 1]);
        $uni = DB::table('uni')->orderBy('sort_id','ASC')->get();
        $item_id = $request->input('itemId');
        $item_index = $request->input('itemIndex');
        foreach($uni as $uni){
            return DB::table('uni')->where('id',$item_id)->update(['sort_id' => $item_index]);
        }
    }

    public function addUniView(){
        $major = new Major();
        $majors = (new MajorRepository($major))->getAllMojors();
        return view('uni.add_uni',['title' => 'uni','majors' => $majors]);
    }

    public function addUni(AddUniRequest $request){
        $uni_id = $this->uniRepo->store($request->storableAttrs())->id;
        /*if($uni_id) {
            $majors = [];
            foreach($request->majors as $major) {
                $temp = ['uni_id' => $uni_id,'major_id' => $major,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')];
                $majors[] = $temp;
            }
            UniMajor::insert($majors);
        }*/


        $file = $request->file('image');
        if(isset($file)){
            $public_path = '/uni/images/' . $uni_id;
            $destinationPath = public_path($public_path);
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $image = $public_path . '/' . $filename;
            $this->uniRepo->updateWhere(['id' => $uni_id],['image' => $image]);
        }

        return redirect()->back()->with('success','Uni Added Successfully');
    }

    public function showUniForm($id){
        $uni = $this->uniRepo->findById($id);
        $uni_majors = UniMajor::where('uni_id',$uni->id)->pluck('major_id')->toArray();
        $all_majors = Major::all();
        return view('uni.edit_uni',['title' => 'uni','uni' => $uni,'all_majors' => $all_majors,'uni_majors' => $uni_majors]);
    }

    public function updateUni(UpdateUniRequest $request,$id){
        $uni_id = $id;
        $this->uniRepo->updateWhere(['id' => $uni_id],$request->updateAttrs());
 /*       UniMajor::where('uni_id',$uni_id)->delete();
        $majors = [];
        foreach($request->majors as $major) {
            $temp = ['uni_id' => $uni_id,'major_id' => $major,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')];
            $majors[] = $temp;
        }
        UniMajor::insert($majors);*/
        $file = $request->file('image');
        if(isset($file)){
            $public_path = '/uni/images/' . $uni_id;
            $destinationPath = public_path($public_path);
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $image = $public_path . '/' . $filename;
            $this->uniRepo->updateWhere(['id' => $uni_id],['image' => $image]);
        }

        return redirect()->back()->with('success','Uni Updated Successfully');
    }
    public function deleteUni($id){
        $this->uniRepo->deleteById($id);
        return redirect()->back()->with('success','Uni Deleted');
    }
    public function uniDetail($id){
        $uni = $this->uniRepo->findById($id);
        return view('uni.uni_detail',['title' => 'uni','uni' => $uni]);
    }
    public function getWelcomeView(){
        $content = Welcome::find(1);
        return view('add_welcome_screen',['title' => 'welcome','content' => $content]);
    }
    public function updateContent(UpdateContentRequest $request){
        //dd($request->all());
        Welcome::where('id',1)->update(['description' => $request->input('description'),'name' => $request->input('name')]);
        $image = $request->file('image');
        $signature_image = $request->file('signature_image');
        if(isset($image)){
            $public_path = '/welcome_screen/images/' . time();
            $destinationPath = public_path($public_path);
            $filename = $image->getClientOriginalName();
            $image->move($destinationPath, $filename);
            $image = $public_path . '/' . $filename;
            Welcome::where('id',1)->update(['id' => 1,'image' => $image]);
        }
        if(isset($signature_image)){
            $public_path = '/welcome_screen/images/' . time();
            $destinationPath = public_path($public_path);
            $filename = $signature_image->getClientOriginalName();
            $signature_image->move($destinationPath, $filename);
            $signature_image = $public_path . '/' . $filename;
            Welcome::where('id',1)->update(['id' => 1,'signature' => $signature_image]);
        }

        return redirect()->back()->with('success','Content updated successfully');
    }
    public function changeUserImage(ChangeImageRequest $request)
    {
        $data = $request->file();
        $image = $data['image'];
        $public_path = '/images/' . Auth::user()->id.'_'.time();
        $destinationPath = public_path($public_path);
        $filename = $image->getClientOriginalName();
        $image->move($destinationPath, $filename);

        $base_path = $public_path . '/' . $filename;
        $this->usersRepo->updateWhere(['id' => Auth::user()->id],['image' => $base_path]);

        return json_encode($base_path);
    }



    /*---------User functions----------*/
    public function getUsers(){
        return view('users.view_users',['title' => 'users','users' => $this->usersRepo->getAllUsers()]);
    }
    public function getAdmins(){
        return view('users.view_admins',['title' => 'admins','users' => $this->usersRepo->getAdmins()]);
    }
    public function addUserView(){
        return view('users.add_user',['title' => 'users']);
    }
    public function addUser(AddUserRequest $request){
        $user = $this->usersRepo->store($request->storableAttrs());
        $viewData['password'] = $user->user_pass;

//        Mail::send('send_user_password', $viewData, function ($m) use ($user) {
//            $m->from('test@codingpixel.com', 'PFF');
//            $m->to($user->email)->subject('New Password');
//        });
        return redirect()->back()->with('success','User has been added');
    }
    public function editUserView($user_id){
        return view('users.edit_user',['title' => 'users','user' => $this->usersRepo->findById($user_id)]);
    }
    public function editAdminView($user_id){
        return view('users.edit_admin',['title' => 'admins','user' => $this->usersRepo->findById($user_id)]);
    }
    public function updateUser(UpdateUserRequest $request,$user_id){
        $user = $this->usersRepo->findById($user_id);
        if($user->user_pass == $request->input('password')){
            $viewData['password'] = $user->user_pass;
//            Mail::send('send_user_password', $viewData, function ($m) use ($user) {
//                $m->from('test@codingpixel.com', 'PFF');
//                $m->to($user->email)->subject('New Password');
//            });
        }
        $this->usersRepo->updateWhere(['id' => $user_id],$request->updateAttrs());
        return redirect()->back()->with('success','User has been updated');
    }
    public function updateAdmin(UpdateAdminRequest $request,$user_id){
        $this->usersRepo->updateWhere(['id' => $user_id],$request->updateAttrs());
        return redirect()->back()->with('success','Admin has been updated');
    }
    public function deleteUser($user_id){
        $this->usersRepo->deleteById($user_id);
        return redirect()->back()->with('success','User has been deleted');
    }
    public function deleteAdmin($user_id){
        $this->usersRepo->deleteById($user_id);
        return redirect()->back()->with('success','Admin has been deleted');
    }
    public function changePasswordView(){
        $user = DB::table('users')->where('user_type', 0)->inRandomOrder()->first();
        return view('users.user_password',['title' => 'users','user' => $user]);
    }
    public function changePassword(ChangePasswordRequest $request){
        $this->usersRepo->updateWhere(['user_type' => 0],['password' => bcrypt($request->input('password')),'user_pass' => $request->input('password')]);
        $users = $this->usersRepo->getWhere(['user_type' => 0]);
        $user1 = DB::table('users')->where('user_type', 0)->inRandomOrder()->first();
        foreach($users as $user){
            $viewData['password'] = $user1->user_pass;
            Mail::send('forgot_pass', $viewData, function ($m) use ($user) {
                $m->from('test@codingpixel.com', 'PFF');
                $m->to($user->email)->subject('New Password');
            });
        }
        return redirect()->back()->with('success','Password has been changed');
    }
//    public function changeAdminPassword(Request $request){
//        $this->usersRepo->updateWhere(['user_type' => 1],['password' => bcrypt($request->input('password')),'user_pass' => $request->input('password')]);
//        $users = $this->usersRepo->getAdmins();
//        $user1 = DB::table('users')->where('user_type', 0)->inRandomOrder()->first();
//        foreach($users as $user){
//            $viewData['password'] = $user1->user_pass;
//            Mail::send('forgot_pass', $viewData, function ($m) use ($user) {
//                $m->from('test@codingpixel.com', 'PFF');
//                $m->to($user->email)->subject('New Password');
//            });
//        }
//        return redirect()->back()->with('success','Password has been changed');
//    }
    public function deleteUnis(Request $request){
        $this->validate(request(),[
            'delete_ids' => 'required',],['delete_ids.required' => 'Select Record to Delete']);
        $this->uniRepo->deleteRecords($request->input('delete_ids'));
        return redirect()->back()->with('success','Uni deleted');
    }
    public function forgotPasswordView(){
        return view('forgot_password');
    }
    public function sendMailLink(Request $request){
        $this->validate(request(),['email' => 'required|exists:users']);
        //$this->usersRepo->updateWhere(['user_type' => 1],['password' => bcrypt('admin123')]);
        $user = User::where('email' , $request->input('email'))->where('user_type' , 1)->first();
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
            return redirect()->back()->with('success' , 'Email is sent to your account');
        }else{
            return redirect()->back()->with('error','You are not admin');
        }

    }

    public function sortUsers(Request $request){
        $users = DB::table('users')->where('user_type',0)->orderBy('sort_id','ASC')->get();
        $item_id = $request->input('itemId');
        $item_index = $request->input('itemIndex');
        foreach($users as $user){
            return DB::table('users')->where('id',$item_id)->update(['sort_id' => $item_index]);
        }
    }
    public function importUsers(Request $request){
        $this->validate(request(),[
            'users' => 'required',
        ],['users.required' => 'Select File']);

        $user = $request->file('users');
        $file_type = $user->getClientOriginalExtension();
        if($file_type != 'csv'){
            return redirect()->back()->with('error','Upload csv file');
        }
        //dd($user);
        $public_path = '/users_data';
        $destinationPath = public_path($public_path);
        $filename = $user->getClientOriginalName();
        $user->move($destinationPath, $filename);

        $base_path = env('CSV', 'public/users_data//');
        Excel::load($base_path.$filename, function($reader) {
            $users = array();
            $results = $reader->get();
            $sort_id = DB::table('users')->max('sort_id');
            if(!isset($sort_id)){
                $sort_id = 0;
            }
            $user1 = DB::table('users')->where('user_type', 0)->inRandomOrder()->first();
            if($user1 != null){
                $user_pass = $user1->user_pass;
            }else{
                $user_pass = 123456789;
            }
            foreach ($results as $result){
                if(isset($result['email'])){
                    $sort_id = $sort_id + 1;
                    $users[] = [
                        'user_name' => $result['user_name'],
                        'email' => $result['email'],
                        'password' => bcrypt($user_pass),
                        'user_pass' => $user_pass,
                        'phone' => $result['phone'],
                        'first_name' => $result['first_name'],
                        'last_name' => $result['last_name'],
                        'user_type' => 0,
                        'sort_id' => $sort_id
                    ];
                }
            }
            $users = $this->unique_multidim_array($users, 'email');
            $this->usersRepo->insertMultiple($users);

        });
        return redirect()->back()->with('success','Users Added to Database');
    }


    protected function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    public function exportUsers(){
        $users = $this->usersRepo->getAllUsers();
        $exported_array[0] = array('user_name','email');
        foreach($users as $user){
            $exported_array[] = array(
                $user['user_name'],$user['email']
            );
        }
        Excel::create('Export', function($excel) use ($exported_array) {

            $excel->sheet('users', function($sheet) use ($exported_array)
            {
                $sheet->fromArray(
                    $exported_array, null , 'A1', false , false
                );
            });
        })->export('xls');
    }

    public function getMapView(Request $request){
        $welcome = Welcome::find(1);
        return view('map',['map' => $welcome,'title' => 'map']);
    }
    public function updateMapImage(Request $request)
    {
        $this->validate(request(),[
            'map' => 'required',
        ],['map.required' => 'Select Image']);
        $image = $request->file('map');
        if (isset($image)) {
            $public_path = '/map/image';
            $destinationPath = public_path($public_path);
            $filename = $image->getClientOriginalName();
            $image->move($destinationPath, $filename);
            $image = $public_path . '/' . $filename;
            Welcome::where('id', 1)->update(['id' => 1, 'map' => $image]);
        }
        return redirect()->back()->with('success', 'Image updated successfully');
    }

    public function bulkDelete(Request $request){
        $delete_ids = $request->input('delete_ids');
        $admin_ids = $request->input('admin_ids');
        if(isset($delete_ids)){
            $this->validate(request(),[
                'delete_ids' => 'required',
            ],['delete_ids.required' => 'Select Record to Delete']);
            $this->usersRepo->deleteRecords($request->input('delete_ids'));
            return redirect()->back()->with('success','Users deleted');
        }
        if(isset($admin_ids)){
            $this->validate(request(),[
                'admin_ids' => 'required',
            ],['admin_ids.required' => 'Select Record']);
            $admin_ids = $request->input('admin_ids');
            $this->usersRepo->makeUsersAdmin($admin_ids);
            return redirect()->back()->with('success', 'Users made admin successfully');
        }
        return redirect()->back();


    }

    public function bulkAdminsDelete(Request $request){
        $delete_ids = $request->input('delete_ids');
        $admin_ids = $request->input('admin_ids');
        if(isset($delete_ids)){
            $this->validate(request(),[
                'delete_ids' => 'required',
            ],['delete_ids.required' => 'Select Record to Delete']);
            $this->usersRepo->deleteRecords($request->input('delete_ids'));
            return redirect()->back()->with('success','Admins deleted');
        }
        return redirect()->back();


    }

    public function deleteImage(Request $request){
        $id = $request->input('id');
        $table = $request->input('table');
        $col = $request->input('col_name');
        DB::table($table)->where('id' , $id)->update([$col => '']);
        return Response::json(array('success' => 1));
    }

    public function imagesView(){
        return view('splash_login_images', ['title' => 'images' , 'image' => $this->imagesRepo->getModel()->first()]);
    }

    public function updateImages(Request $request){
        $this->validate(request(),[
            'login_image' => 'image',
            'splash_image' => 'image',
            'navigation_image' => 'image',
        ]);
        $image_object = $this->imagesRepo->getModel()->first();
        $login_image = $request->file('login_image');
        $splash_image = $request->file('splash_image');
        $navigation_image = $request->file('navigation_image');
        if(isset($login_image)){
            if($image_object->login_image != ''){
                unlink(public_path($image_object->login_image));
            }
            $public_path = '/splash_images/login';
            $destinationPath = public_path($public_path);
            $extension = $login_image->getClientOriginalExtension();
            $filename = 'login.'.$extension;
            $login_image->move($destinationPath, $filename);
            $login_image = $public_path . '/' . $filename;
            $this->imagesRepo->updateWhere(['id' => $image_object->id],['login_image' => $login_image]);
        }
        if(isset($splash_image)){
            if($image_object->splash_image != '') {
                unlink(public_path($image_object->splash_image));
            }
            $public_path = '/splash_images/splash';
            $destinationPath = public_path($public_path);
            $extension = $splash_image->getClientOriginalExtension();
            $filename = 'splash.'.$extension;
            $splash_image->move($destinationPath, $filename);
            $splash_image = $public_path . '/' . $filename;
            $this->imagesRepo->updateWhere(['id' => $image_object->id],['splash_image' => $splash_image]);
        }

        if(isset($navigation_image)){
            if($image_object->navigation_image != '') {
                unlink(public_path($image_object->navigation_image));
            }
            $public_path = '/splash_images/navigation';
            $destinationPath = public_path($public_path);
            $extension = $navigation_image->getClientOriginalExtension();
            $filename = 'navigation.'.$extension;
            $navigation_image->move($destinationPath, $filename);
            $navigation_image = $public_path . '/' . $filename;
            $this->imagesRepo->updateWhere(['id' => $image_object->id],['navigation_image' => $navigation_image]);
        }

        return redirect()->back()->with('success', 'Images Update Successfully');
    }







}
