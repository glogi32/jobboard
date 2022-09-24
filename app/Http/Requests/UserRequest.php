<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $userId = explode("/",\request()->requestUri)[3];

        return [
            "first-name" => ["bail","required","max:60","regex:/^[A-Z][a-zA-Z]*[\sa-zA-Z]*$/"],
            "last-name" => ["bail","required","max:60","regex:/^[A-Z][a-zA-Z]*[\sa-zA-Z]*$/"],
            "email" => ["bail","required","email","max:120",Rule::unique('users',"email")->ignore($userId)],
            "password" => ["bail","required",Password::min(8)
                                                    ->letters()
                                                    ->mixedCase()
                                                    ->numbers()],
            "phone" => ["bail","required","regex:/^[0-9]{3}[\s-]?[0-9]{1,3}[\s-]?[0-9]{0,7}$/"],
            "linkedin" => ["bail","nullable","url"],
            "github" => ["bail","nullable","url"],
            "portfolio-website" => ["bail","nullable","url"],
            "about-u" => ["bail","required","max:1500","min:10"],
            "cv" => ["bail","nullable","mimes:pdf,docx,doc","max:3000"],
            "image" => ["bail","nullable","mimes:jpeg,jpg,png","max:5000"],
            "other-docs" => ["bail","nullable","max:5"],
            "other-docs.*" => ["bail","nullable","mimes:pdf,docx,doc","max:3000"]
        ];
    }
}
