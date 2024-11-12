<?php

namespace Botble\JobBoard\Http\Requests;

use Botble\JobBoard\Models\Company;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class AjaxReviewRequest extends Request
{
    public function rules(): array
    {
        return [
            'company_id' => ['required', Rule::exists(Company::class, 'id')],
        ];
    }
}
