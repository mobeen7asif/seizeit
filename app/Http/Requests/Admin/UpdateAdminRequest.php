<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Request;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    public function updateAttrs()
    {
        $storableAttrs = [
            'user_name' => $this->input('user_name'),
            'email' => $this->input('email'),
            'first_name' => $this->input('first_name'),
            'last_name' => $this->input('last_name'),
            'phone' => $this->input('phone'),
            'password' => bcrypt($this->input('password')),
            'user_pass' => $this->input('password'),
        ];
        if($this->has('password') and $this->input('password') != '') {
            $storableAttrs['password'] = bcrypt($this->input('password'));
        }
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

    public function messages()
    {
        return [
            //'images.max'=>'Images should not be greater than '.$this->maxImages
        ];
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
            'first_name'=>'required|max:190',
            'last_name'=>'required|max:190',
            'user_name'=>'required|max:190',
            'email'=>'required|email|email|unique:users,email,'.$this->route()->parameter('user_id').'|max:255',
        ];
        return $rules;
    }
}
