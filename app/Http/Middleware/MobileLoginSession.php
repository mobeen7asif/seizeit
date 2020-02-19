<?php

namespace App\Http\Middleware;

use App\UserSession;
use Closure;

class MobileLoginSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $session =  UserSession::where('session_id',$request->session_id)->where('device_token',$request->device_token)->first();

        if($session != null)
        {
            return $next($request);
        }

        else{
          return redirect('api/session_out');
        }


    }
}
