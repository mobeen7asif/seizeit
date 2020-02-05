<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class AddMajorRequest extends FormRequest
{
    public function storableAttrs()
    {
        $sort_id = DB::table('majors')->max('sort_id');
        if(!isset($sort_id)){
            $sort_id = 0;
        }else{
            $sort_id = $sort_id + 1;
        }
        $storableAttrs = [
            'name' => $this->input('name'),
            'description' => $this->input('description'),
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
            //'categories'=>'required',
            'name'=>'required|max:190',
            'description'=>'required|max:300',
        ];
        return $rules;
    }
}
