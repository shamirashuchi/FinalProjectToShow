<?php

namespace Botble\JobBoard\Http\Requests;

use Botble\JobBoard\Enums\AccountTypeEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class RegisterRequest extends Request
{
    public function rules(): array
    {
        $rules = [
            'type' => 'required|' . Rule::in(AccountTypeEnum::values()),
            'first_name' => 'required|max:120|min:2',
            'last_name' => 'required|max:120|min:2',
            'email' => 'required|max:60|min:6|email|unique:jb_accounts',
            'password' => 'required|min:6|confirmed',
        ];

        if (setting('enable_captcha') && is_plugin_active('captcha')) {
            $rules += [
                'g-recaptcha-response' => 'required|captcha',
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'g-recaptcha-response.required' => trans('plugins/contact::contact.g-recaptcha-response.required'),
            'g-recaptcha-response.captcha' => trans('plugins/contact::contact.g-recaptcha-response.captcha'),
        ];
    }
}
