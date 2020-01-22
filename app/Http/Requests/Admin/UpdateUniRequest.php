<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Admin\Request;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUniRequest extends FormRequest
{
    public function updateAttrs()
    {
        $storableAttrs = [
            'name' => $this->input('name'),
            'designation' => $this->input('designation'),
            'uni_detail' => $this->input('uni_detail')
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
            //'images'=>'max:'.$this->maxImages,
            'name'=>'required|max:190',
            'uni_detail'=>'required|max:300',
            //'designation'=>'required|max:190'
        ];
        return $rules;
    }
}
