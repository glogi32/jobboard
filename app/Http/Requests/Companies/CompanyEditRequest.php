<?php

namespace App\Http\Requests\Companies;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyEditRequest extends FormRequest
{
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
            "name" => ["bail","required","max:120"],
            "email" => ["bail","required","email",Rule::unique('companies')->ignore($this->company),"max:120"],
            "phone" => ["bail","required","regex:/^[0-9]{3}[\s-]?[0-9]{3}[\s-]?[0-9]{0,7}$/"],
            "website" => ["bail","nullable","url"],
            "about-us" => ["bail","required","max:2500"],
            "city" => ["bail","required","exists:cities,id"],
            "logo" => ["bail","nullable","mimes:jpeg,jpg,png","max:5000"],
            "images" => ["nullable","max:5"],
            "images.*" => ["bail","file","mimes:jpeg,jpg,png","max:5000"]
        ];
    }
}
