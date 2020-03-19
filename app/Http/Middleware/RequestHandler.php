<?php

namespace App\Http\Middleware;

use App\Libs\Auth\Auth;
use App\LoginUser;
use App\User;
use Illuminate\Support\Facades\Validator;
use Requests\Request;
use Closure;
use App\Http\Response;

class RequestHandler
{
    use \App\Traits\Validator;

    private $response;
    private $validationMessages = [];
    public function __construct()
    {
        $this->response = new Response();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
            if(isset(getallheaders()['Authorization']) && getallheaders()['Authorization'] != ""){
                $user_session = LoginUser::where('session_id',getallheaders()['Authorization'])->first();
                if($user_session) {
                    $user = User::where('id',$user_session->user_id)->first();
                    if(!$user) {
                        return response()->json(['status' => 401, 'message' => 'Invalid Token', 'data' => []]);
                    }
                    return $next($request);
                }
                else {
                    return response()->json(['status' => 401, 'message' => 'You are not logged in', 'data' => []]);
                }


            }else{
                return response()->json(['status' => 401, 'message' => 'You are not logged in', 'data' => []]);
            }


    }

}
