<?php

namespace App\Http\Requests\Companies;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyVoteRequest extends FormRequest
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
            "companyId" => ["bail","required","exists:companies,id"],
            "userId" => ["bail","required","exists:users,id"],
            "vote" => ["bail","required",Rule::in([1,2,3,4,5])]
        ];
    }
}
