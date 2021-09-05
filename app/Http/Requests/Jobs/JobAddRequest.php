<?php

namespace App\Http\Requests\Jobs;

use Illuminate\Foundation\Http\FormRequest;

class JobAddRequest extends FormRequest
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
            "company" => ["bail","required","exists:companies,id"],
            "title" => ["bail","required","min:5","max:80"],
            "vacancy" => ["bail","required","integer","gt:0"],
            "deadline" => ["bail","required","after:today"],
            "city" => ["bail","required","exists:cities,id"],
            "area" => ["bail","required","exists:areas,id"],
            "seniority" => ["bail","required"],
            "empStatus" => ["bail","required"],
            "description" => ["bail","required","max:3000"],
            "responsibilities" => ["bail","nullable","max:2500"],
            "education" => ["bail","nullable","max:2500"],
            "benefits" => ["bail","nullable","max:2500"],
            "tech" => ["bail","required","min:1","max:10"]
        ];
    }
}
