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
            "message" => ["nullable","max:8000"],
            "user-cvs" => ["exclude_if:cv-apply,false","exists:user_cvs,id"],
            "cv" => ["sometimes","bail","required","mimes:pdf,docx,doc","max:3000"],
            "userId" => ["bail","required","exists:users,id"],
            "jobId" => ["bail","required","exists:jobs,id"]
        ];
    }
}
