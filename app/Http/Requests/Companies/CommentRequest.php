<?php

namespace App\Http\Requests\Companies;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            "message" => ["bail","required","min:2","max:500"],
            "userId" => ["bail","required","exists:users,id"],
            "companyId" => ["bail","required","exists:companies,id"]
        ];
    }
}
