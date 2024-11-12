<?php

namespace Botble\JobBoard\Http\Requests;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CompanyRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'slug' => 'required',
            'facebook' => 'nullable|max:200',
            'twitter' => 'nullable|max:200',
            'linkedin' => 'nullable|max:200',
            'instagram' => 'nullable|max:200',
            'status' => Rule::in(BaseStatusEnum::values()),
        ];
    }
}
