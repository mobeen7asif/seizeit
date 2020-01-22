<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function forbiddenResponse()
    {
        return parent::forbiddenResponse();
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
        return [
            //
        ];
    }


    public function all()
    {
        return array_replace_recursive(
            parent::all(),
            $this->route()->parameters()
        );
    }
}
