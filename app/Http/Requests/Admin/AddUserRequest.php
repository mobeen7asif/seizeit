<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class AddUserRequest extends FormRequest
{
    public function storableAttrs()
    {
        $sort_id = DB::table('users')->max('sort_id');
        if(!isset($sort_id)){
            $sort_id = 0;
        }else{
            $sort_id = $sort_id + 1;
        }
//        $user = DB::table('users')->where('user_type', 0)->inRandomOrder()->first();
//        if($user != null){
//            $user_pass = $user->user_pass;
//        }else{
//            $user_pass = 123456789;
//        }
        $user_pass = $this->input('first_name').$this->input('last_name');
        $storableAttrs = [
            'user_name' => $this->input('user_name'),
            'email' => $this->input('email'),
            'password' => bcrypt($user_pass),
            'first_name' => $this->input('first_name'),
            'last_name' => $this->input('last_name'),
            'phone' => $this->input('phone'),
            'user_pass' => $user_pass,
            'password_status' => 0,
            'user_type' => 0,
            'sort_id' => $sort_id
        ];
        return $storableAttrs;
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            //'images'=>'max:'.$this->maxImages,
            'user_name'=>'required|max:190',
            'first_name'=>'required|max:190',
            'last_name'=>'required|max:190',
            'email'=>'required|email|unique:users',
            'password'=>'required|max:190',
        ];
        return $rules;
    }
}
