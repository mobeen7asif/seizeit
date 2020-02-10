<?php

namespace App\Http\Middleware;

use App\Libs\Auth\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Request;
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
        $requestClass = "App\Http\Requests\\".$customRequest;
        /** @var Request $customRequest */
        $customRequest = new $requestClass();

        if($customRequest->authenticatable){
            if(isset(getallheaders()['Authorization']) && getallheaders()['Authorization'] != ""){
                if(!Auth::authenticateWithToken(getallheaders()['Authorization']))
                    return $this->response->respondAuthenticationFailed();
            }else{
                return $this->response->respondAuthenticationFailed();
            }
        }

        if(!$customRequest->authorize())
            return $this->response->respondOwnershipConstraintViolation();
        if(!$this->validate($customRequest))
            return $this->response->respondValidationFails($this->validationMessages);

        return $next($request);
    }

}
