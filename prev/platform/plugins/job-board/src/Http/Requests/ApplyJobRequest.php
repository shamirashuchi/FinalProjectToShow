<?php

namespace Botble\JobBoard\Http\Requests;

use BaseHelper;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ApplyJobRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'job_type' => Rule::in(['internal', 'external']),
            'email' => 'required|email',
            'message' => 'nullable|max:1000',
        ];

        if ($this->input('job_type') === 'internal') {
            $rules = array_merge($rules, [
                'first_name' => 'required|max:120|min:2',
                'last_name' => 'required|max:120|min:2',
                'resume' => 'nullable|file',
                'cover_letter' => 'nullable|file',
                'message' => 'nullable|max:1000',
                'phone' => 'nullable|' . BaseHelper::getPhoneValidationRule(),
            ]);
        }

        if (is_plugin_active('captcha') && setting('enable_captcha') && setting('job_board_enable_recaptcha_in_apply_job', 0)) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'first_name.required' => trans('plugins/job-board::job-application.first_name.required'),
            'last_name.required' => trans('plugins/job-board::job-application.last_name.required'),
            'phone.required' => trans('plugins/job-board::job-application.phone.required'),
            'email.required' => trans('plugins/job-board::job-application.email.required'),
            'email.email' => trans('plugins/job-board::job-application.email.email'),
        ];
    }
}
