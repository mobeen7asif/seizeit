<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class AddCategoryRequest extends FormRequest
{
    public function storableAttrs()
    {
        $sort_id = DB::table('categories')->max('sort_id');
        if(!isset($sort_id)){
            $sort_id = 0;
        }else{
            $sort_id = $sort_id + 1;
        }
        $storableAttrs = [
            'name' => $this->input('name'),
            'description' => $this->input('description'),
            //'url' => $this->input('url'),
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
            //'url'=> 'required|max:300',
            'name'=>'required|max:190',
            'description'=>'required|max:300',
        ];
        return $rules;
    }
}
