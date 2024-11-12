<?php

namespace Botble\JobBoard\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Botble\ACL\Traits\RegistersUsers;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\JobBoard\Enums\AccountTypeEnum;
use Botble\JobBoard\Http\Requests\RegisterRequest;
use Botble\JobBoard\Repositories\Interfaces\AccountInterface;
use EmailHandler;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use JsValidator;
use SeoHelper;
use Theme;
use URL;







//new

use Botble\JobBoard\Forms\CompanyForm;
use Botble\JobBoard\Http\Requests\AjaxCompanyRequest;
use Botble\JobBoard\Http\Requests\CompanyRequest;
use Botble\JobBoard\Http\Resources\CompanyResource;
use Botble\JobBoard\Repositories\Interfaces\CompanyInterface;
use Botble\JobBoard\Services\StoreCompanyAccountService;
use Botble\JobBoard\Tables\CompanyTable;

use Illuminate\Support\Facades\DB;



class RegisterController extends Controller
{



    use RegistersUsers;

    protected string $redirectTo = '/';

    protected AccountInterface $accountRepository;

    protected CompanyInterface $companyRepository;

    public function __construct(AccountInterface $accountRepository, CompanyInterface $companyRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->companyRepository = $companyRepository;
    }

    public function showRegistrationForm()
    {
        SeoHelper::setTitle(__('Register'));

        Theme::breadcrumb()->add(__('Home'), route('public.index'))
            ->add(__('Register'), route('public.account.register'));

        Theme::asset()->container('footer')
            ->add('js-validation', 'vendor/core/core/js-validation/js/js-validation.js', ['jquery']);
        Theme::asset()->container('footer')->writeContent(
            'js-validation-scripts',
            JsValidator::formRequest(RegisterRequest::class),
            ['jquery']
        );

        if (! session()->has('url.intended')) {
            session(['url.intended' => url()->previous()]);
        }

        return Theme::scope('job-board.auth.register', [], 'plugins/job-board::themes.auth.register')->render();
    }



    public function showRegistrationForm2()
    {
        SeoHelper::setTitle(__('Register'));

        Theme::breadcrumb()->add(__('Home'), route('public.index'))
            ->add(__('Register'), route('public.account.register'));

        // Theme::asset()->container('footer')
        //     ->add('js-validation', 'vendor/core/core/js-validation/js/js-validation.js', ['jquery']);
        // Theme::asset()->container('footer')->writeContent(
        //     'js-validation-scripts',
        //     JsValidator::formRequest(RegisterRequest::class),
        //     ['jquery']
        // );

        if (! session()->has('url.intended')) {
            session(['url.intended' => url()->previous()]);
        }

        return Theme::scope('job-board.auth.register2', [], 'plugins/job-board::themes.auth.register2')->render();
    }


    public function showRegistrationForm3()
    {
        SeoHelper::setTitle(__('Register'));

        Theme::breadcrumb()->add(__('Home'), route('public.index'))
            ->add(__('Register'), route('public.account.register'));

        Theme::asset()->container('footer')
            ->add('js-validation', 'vendor/core/core/js-validation/js/js-validation.js', ['jquery']);
        Theme::asset()->container('footer')->writeContent(
            'js-validation-scripts',
            JsValidator::formRequest(RegisterRequest::class),
            ['jquery']
        );

        if (! session()->has('url.intended')) {
            session(['url.intended' => url()->previous()]);
        }

        return Theme::scope('job-board.auth.register3', [], 'plugins/job-board::themes.auth.register3')->render();
    }




    public function confirm(
        $email,
        Request $request,
        BaseHttpResponse $response,
        AccountInterface $accountRepository
    ) {
        if (! URL::hasValidSignature($request)) {
            abort(404);
        }

        $account = $accountRepository->getFirstBy(['email' => $email]);

        if (! $account) {
            abort(404);
        }

        $account->confirmed_at = now();
        $this->accountRepository->createOrUpdate($account);

        $this->guard()->login($account);

        return $response
            ->setNextUrl(route('public.account.dashboard'))
            ->setMessage(trans('plugins/job-board::account.confirmation_successful'));
    }

    protected function guard()
    {
        return auth('account');
    }

    public function resendConfirmation(
        Request $request,
        AccountInterface $accountRepository,
        BaseHttpResponse $response
    ) {
        $account = $accountRepository->getFirstBy(['email' => $request->input('email')]);
        if (! $account) {
            return $response
                ->setError()
                ->setMessage(__('Cannot find this account!'));
        }

        try {
            $account->sendEmailVerificationNotification();
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }

        return $response
            ->setMessage(trans('plugins/job-board::account.confirmation_resent'));
    }

    public function register(Request $request, BaseHttpResponse $response)
    {
        if ($request->input('is_employer') && setting('job_board_enabled_register_as_employer')) {
            $request->merge(['type' => AccountTypeEnum::EMPLOYER]);
        } else {
            $request->merge(['type' => AccountTypeEnum::JOB_SEEKER]);
        }

        $this->validator($request->input())->validate();

        $account = $this->create($request->input());
        event(new Registered($account));

        $request->merge(['slug' => $account->name, 'is_slug_editable' => 1]);

        event(new CreatedContentEvent(ACCOUNT_MODULE_SCREEN_NAME, $request, $account));

        EmailHandler::setModule(JOB_BOARD_MODULE_SCREEN_NAME)
            ->setVariableValues([
                'account_type' => Str::lower($account->type->label()),
                'account_name' => $account->name,
                'account_email' => $account->email,
            ])
            ->sendUsingTemplate('account-registered', setting('email_from_address'));

        if (setting('verify_account_email', 0)) {
            $account->sendEmailVerificationNotification();

            return $this->registered($request, $account)
                ?: $response->setNextUrl($this->redirectPath())->setMessage(
                    trans('plugins/job-board::account.confirmation_info')
                );
        }

        $this->guard()->login($account);

        return $this->registered($request, $account)
            ?: $response->setNextUrl($this->redirectPath());
    }




    public function register2(Request $request, BaseHttpResponse $response)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => [
                'required',
                'string',
                'max:255'
            ],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8', 'same:password'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $request->merge(['type' => AccountTypeEnum::EMPLOYER]);

        //$request->merge(['type' => 'employer']);


        $this->validator($request->input())->validate();

        $account = $this->create($request->input());
        event(new Registered($account));

        $request->merge(['slug' => $account->name, 'is_slug_editable' => 1]);

        event(new CreatedContentEvent(ACCOUNT_MODULE_SCREEN_NAME, $request, $account));

        EmailHandler::setModule(JOB_BOARD_MODULE_SCREEN_NAME)
            ->setVariableValues([
                'account_type' => Str::lower($account->type->label()),
                'account_name' => $account->name,
                'account_email' => $account->email,
            ])
            ->sendUsingTemplate('account-registered', setting('email_from_address'));

        if (setting('verify_account_email', 0)) {
            $account->sendEmailVerificationNotification();

            return $this->registered($request, $account)
                ?: $response->setNextUrl($this->redirectPath())->setMessage(
                    trans('plugins/job-board::account.confirmation_info')
                );
        }



        // put the company regiustration code here

        //$company = $this->companyRepository->createOrUpdate(['name' => $request->input('first_name')]);





        $companyData = [
            'name' => $request->input('first_name'),
            'email' => $request->input('email'),
        ];

        $company = $this->companyRepository->createOrUpdate($companyData);








        event(new CreatedContentEvent(COMPANY_MODULE_SCREEN_NAME, $request, $company));

        //return $response->setData(new CompanyResource($company));

        // company code end





        $this->guard()->login($account);




        // insert the many to many table
        // Get the IDs of the last inserted account and company
        $accountId = $account->id;
        $companyId = $company->id;

        // Insert the IDs into the jb_companies_accounts table
        DB::table('jb_companies_accounts')->insert([
            'account_id' => $accountId,
            'company_id' => $companyId,
        ]);






        // company new
        return $response->setData(new CompanyResource($company));


        //return $this->registered($request, $account) ?: $response->setNextUrl($this->redirectPath());
    }








    public function register2_main(Request $request, BaseHttpResponse $response)
    {

        $request->merge(['type' => AccountTypeEnum::EMPLOYER]);

        //$request->merge(['type' => 'employer']);


        $this->validator($request->input())->validate();

        $account = $this->create($request->input());
        event(new Registered($account));

        $request->merge(['slug' => $account->name, 'is_slug_editable' => 1]);

        event(new CreatedContentEvent(ACCOUNT_MODULE_SCREEN_NAME, $request, $account));

        EmailHandler::setModule(JOB_BOARD_MODULE_SCREEN_NAME)
            ->setVariableValues([
                'account_type' => Str::lower($account->type->label()),
                'account_name' => $account->name,
                'account_email' => $account->email,
            ])
            ->sendUsingTemplate('account-registered', setting('email_from_address'));

        if (setting('verify_account_email', 0)) {
            $account->sendEmailVerificationNotification();

            return $this->registered($request, $account)
                ?: $response->setNextUrl($this->redirectPath())->setMessage(
                    trans('plugins/job-board::account.confirmation_info')
                );
        }

        $this->guard()->login($account);

        return $this->registered($request, $account)
            ?: $response->setNextUrl($this->redirectPath());
    }





















    public function register3(Request $request, BaseHttpResponse $response)
    {

        $request->merge(['type' => AccountTypeEnum::CONSULTANT]);

        //$request->merge(['type' => 'consultant']);

        $this->validator($request->input())->validate();

        $account = $this->create($request->input());
        event(new Registered($account));

        $request->merge(['slug' => $account->name, 'is_slug_editable' => 1]);

        event(new CreatedContentEvent(ACCOUNT_MODULE_SCREEN_NAME, $request, $account));

        EmailHandler::setModule(JOB_BOARD_MODULE_SCREEN_NAME)
            ->setVariableValues([
                'account_type' => Str::lower($account->type->label()),
                'account_name' => $account->name,
                'account_email' => $account->email,
            ])
            ->sendUsingTemplate('account-registered', setting('email_from_address'));

        if (setting('verify_account_email', 0)) {
            $account->sendEmailVerificationNotification();

            return $this->registered($request, $account)
                ?: $response->setNextUrl($this->redirectPath())->setMessage(
                    trans('plugins/job-board::account.confirmation_info')
                );
        }

        $this->guard()->login($account);

        return $this->registered($request, $account)
            ?: $response->setNextUrl($this->redirectPath());
    }






    protected function create(array $data)
    {
        return $this->accountRepository->create([
            'type' => $data['type'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function validator(array $data)
    {
        $rules = [
            'first_name' => 'required|max:120|min:2',
            'last_name' => 'required|max:120|min:2',
            'email' => 'required|max:60|min:6|email|unique:jb_accounts',
            'password' => 'required|min:6|confirmed',
        ];

        if (is_plugin_active('captcha') && setting('enable_captcha') && setting(
            'job_board_enable_recaptcha_in_register_page',
            0
        )) {
            $rules += ['g-recaptcha-response' => 'required|captcha'];
        }

        if (request()->has('agree_terms_and_policy')) {
            $rules['agree_terms_and_policy'] = 'accepted:1';
        }

        $attributes = [
            'first_name' => __('First Name'),
            'last_name' => __('Last Name'),
            'email' => __('Email'),
            'password' => __('Password'),
            'g-recaptcha-response' => __('Captcha'),
            'agree_terms_and_policy' => __('Term and Policy'),
        ];

        return Validator::make($data, $rules, [
            'g-recaptcha-response.required' => __('Captcha Verification Failed!'),
            'g-recaptcha-response.captcha' => __('Captcha Verification Failed!'),
        ], $attributes);
    }
}
