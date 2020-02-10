<?php
/**
 * Created by PhpStorm.
 * User: SHANKS
 * Date: 4/27/2017
 * Time: 12:08 PM
 */
namespace App\Traits;
use App\User;
use App\Http\Requests\Request;


trait Validator{
    public function validate(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $request->rules(), $request->messages());
        if($validator->fails()){
            $this->validationMessages = $validator->errors()->all();
            return false;
        }
        return true;
    }
}
