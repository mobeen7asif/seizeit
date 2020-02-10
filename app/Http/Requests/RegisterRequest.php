<?php

namespace App\Http\Requests;

use App\Libs\Auth\Auth;
use App\User;
use Illuminate\Foundation\Http\FormRequest;


class RegisterRequest extends Request
{

    public function __construct(){
        parent::__construct();
        $this->authenticatable = false;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
//    public function transform()
//    {
//        return [
//            'user_type'=>intval($this->input('user_type')),
//        ];
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            'email'=>'required | unique:users',
            'password' =>'required | max:15 | min:6',
//            'user_image' => 'required | mimes:jpeg,jpg,png | max:1000',
            'device_type' => 'String|max:100',
            'device_id' => 'required',
            'device_token' => 'required'
        ];
    }

    public function attributes(){


        $user = array(
            'email' => $this->input('email'),
            'first_name' => $this->input('first_name'),
            'last_name' => $this->input('last_name'),
            'password' => bcrypt($this->input('password')),
        );
        return $user;
    }

}
