<?php

namespace Botble\JobBoard\Http\Requests;

use Botble\JobBoard\Models\Company;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class StoreReviewRequest extends Request
{
    public function rules(): array
    {
        return [
            'company_id' => ['required', Rule::exists(Company::class, 'id')],
            'star' => 'required|numeric|min:1|max:5',
            'review' => 'required|min:6|max:1000',
        ];
    }
}
