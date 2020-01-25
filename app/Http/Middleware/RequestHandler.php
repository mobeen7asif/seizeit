<?php

namespace App\Http\Middleware;

use App\Libs\Auth\Auth;
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
    public function handle($request, Closure $next, $customRequest = "")
    {
            if(isset(getallheaders()['Authorization']) && getallheaders()['Authorization'] != ""){




            }else{
                return ['status' => 401, 'message' => 'You are not logged in', 'data' => []];
            }

        return $next($request);
    }

}
