<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddMemoryDescriptionRequest;
use App\Http\Requests\ArtistTypeRequest;
use App\Http\Requests\ArtistWorksRequest;
use App\Http\Requests\EditMemoryRequest;
use App\Repositories\ArtistsRepository;
use App\Repositories\ArtistWorksRepository;
use App\Repositories\MemoriesRepository;

use App\Repositories\UsersRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ForgotPasswordController extends Controller
{
	private $usersRepo = null;

	public function __construct(UsersRepository $usersRepo)
	{
		$this->usersRepo = $usersRepo;
	}

    public function showPasswordView()
    {
        $id = $_GET['user'];
        $token = $_GET['token'];
        $user = User::where('token', $token)->first();
        if ($user == null) {
            return view('expired_link');
        }
        $data = array(
            'id'  => $id,
            'token'   => $token
        );
        return view('new_pass',$data);
    }
    public function resetPassword(Request $request)
    {
        $this->validate($request , ['password' => 'required|min:6']);
        $pass = $_POST['password'];
        $id = $_POST['id'];
        $token = $_POST['token'];
        $user = $this->usersRepo->findById($id);
        if($user->token == $token)
        {
            $this->usersRepo->updateWhere(['id' => $id],['password' => bcrypt($pass),'user_pass' => $pass ,
                'password_status' => 1 ,
                'token' => '']);
            return view('password_success');
        }
        else{
            return redirect()->back()->with('error','Access Denied');
        }
    }


}
