<?php
/**
 * Created by PhpStorm.
 * User: waqas
 * Date: 3/16/2016
 * Time: 1:46 PM
 */

namespace App\Http;

use App\Libs\Auth\Auth;

class SResponse extends Response
{
    public $CUSTOM_STATUS = 0;
    public $HTTP_STATUS = 200;
    public $ERROR_MESSAGES = [];



    /**
     * @param $response
     * @param $headers
     * @return json
     * @description
     * following function accepts data from
     * controllers and return a pre-setted view.
     **/
    public function respond(array $response = [], array $headers = []){
        $response['status'] = ($this->getHttpStatus() == 200)?1:0;
        $response['message'] = (isset($response['message']))?$response['message']:(($response['status'] == 1)?config('constants.SUCCESS_MESSAGE'):config('constants.ERROR_MESSAGE'));
        $response['session_id'] = (!isset($response['session_id']))?((Auth::user() != null)?Auth::user()->session_id: ""):$response['session_id'];
        return response()->json($response, $this->getHttpStatus(), $headers);
    }

}
