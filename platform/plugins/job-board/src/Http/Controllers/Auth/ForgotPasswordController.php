<?php

namespace Botble\JobBoard\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Botble\ACL\Traits\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use SeoHelper;
use Theme;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        SeoHelper::setTitle(__('Forgot Password'));

        Theme::breadcrumb()->add(__('Home'), route('public.index'))->add(__('Forgot Password'), route('public.account.register'));

        return Theme::scope('job-board.auth.passwords.email', [], 'plugins/job-board::themes.auth.passwords.email')->render();
    }

    public function broker()
    {
        return Password::broker('accounts');
    }
}
