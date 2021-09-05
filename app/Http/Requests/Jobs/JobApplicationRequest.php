<?php

namespace App\Http\Requests\Jobs;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobApplicationRequest extends FormRequest
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
            "first-name" => ["bail","required","max:60","regex:/^[A-Z][a-zA-Z]*[\sa-zA-Z]*$/"],
            "last-name" => ["bail","required","max:60","regex:/^[A-Z][a-zA-Z]*[\sa-zA-Z]*$/"],
            "email" => ["bail","required","email","max:120"],
            "phone" => ["bail","required","regex:/^[0-9]{3}[\s-]?[0-9]{3}[\s-]?[0-9]{0,7}$/"],
            "linkedin" => ["bail","nullable","url"],
            "github" => ["bail","nullable","url"],
            "portfolio-website" => ["bail","nullable","url"],
            "message" => ["nullable","max:8000"],
            "cvId" => ["exclude_if:cv-apply,false","exists:user_cvs,id"],
            "cv" => ["sometimes","bail","required","mimes:pdf,docx,doc","max:3000"],
            "userId" => ["bail","required","exists:users,id"],
            "jobId" => ["bail","required","exists:jobs,id"]
        ];
    }
}
