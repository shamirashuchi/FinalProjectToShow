<?php

namespace Botble\JobBoard\Http\Controllers\Fronts;

use Assets;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\JobBoard\Http\Resources\AccountResource;
use Botble\JobBoard\Http\Resources\PackageResource;
use Botble\JobBoard\Http\Resources\TransactionResource;
use Botble\JobBoard\Models\Account;
use Botble\JobBoard\Models\Package;
use Botble\JobBoard\Repositories\Interfaces\AccountActivityLogInterface;
use Botble\JobBoard\Repositories\Interfaces\AccountInterface;
use Botble\JobBoard\Repositories\Interfaces\JobApplicationInterface;
use Botble\JobBoard\Repositories\Interfaces\JobInterface;
use Botble\JobBoard\Repositories\Interfaces\PackageInterface;
use Botble\JobBoard\Repositories\Interfaces\TransactionInterface;
use Botble\Media\Repositories\Interfaces\MediaFileInterface;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Payment\Repositories\Interfaces\PaymentInterface;
use Botble\Paypal\Services\Gateways\PayPalPaymentService;
use EmailHandler;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use JobBoardHelper;
use Language;
use SeoHelper;
use Theme;

class DashboardController extends Controller
{
    protected AccountInterface $accountRepository;

    protected AccountActivityLogInterface $activityLogRepository;

    protected MediaFileInterface $fileRepository;

    protected JobInterface $jobRepository;

    protected JobApplicationInterface $applicationRepository;

    protected PackageInterface $packageRepository;

    public function __construct(
        Repository $config,
        AccountInterface $accountRepository,
        AccountActivityLogInterface $accountActivityLogRepository,
        MediaFileInterface $fileRepository,
        JobInterface $jobRepository,
        JobApplicationInterface $applicationRepository,
        PackageInterface $packageRepository
    ) {
        $this->accountRepository = $accountRepository;
        $this->activityLogRepository = $accountActivityLogRepository;
        $this->fileRepository = $fileRepository;
        $this->jobRepository = $jobRepository;
        $this->applicationRepository = $applicationRepository;
        $this->packageRepository = $packageRepository;

        Assets::setConfig($config->get('plugins.job-board.assets'));
    }

    public function index()
    {




        /**
         * @var Account $account
         */
        $account = auth('account')->user();



        page_title()->setTitle(__('Dashboard'));
        SeoHelper::setTitle(__('Dashboard'));
        Theme::breadcrumb()
            ->add(__('Home'), route('public.index'))
            ->add(__('Dashboard'));

        $totalCompanies = $account->companies()->count();

        $totalJobs = $this->jobRepository
            ->select(['jb_jobs.id'])
            ->byAccount($account->getKey())
            ->count();

        $totalApplicants = $this->applicationRepository
            ->select(['jb_applications.id'])
            ->whereHas('job', function (Builder $query) use ($account) {
                $query->byAccount($account->getKey());
            })
            ->count();

        $expiredJobs = $this->jobRepository
            ->select([
                'jb_jobs.id',
                'jb_jobs.name',
                'jb_jobs.status',
                'jb_jobs.company_id',
                'jb_jobs.expire_date',
            ])
            ->byAccount($account->getKey())
            ->where(function ($query) {
                $query->where('jb_jobs.expire_date', '>=', now())
                    ->where('jb_jobs.expire_date', '<=', now()->addDays(30))
                    ->where('never_expired', false);
            })
            ->with('company')
            ->withCount(['applicants'])
            ->orderBy('jb_jobs.expire_date', 'asc')
            ->get();

        $newApplicants = $this->applicationRepository
            ->select([
                'jb_applications.id',
                'jb_applications.first_name',
                'jb_applications.last_name',
                'jb_applications.email',
                'jb_applications.phone',
            ])
            ->whereHas('job', function (Builder $query) use ($account) {
                $query->byAccount($account->getKey());
            })
            ->orderBy('jb_applications.created_at', 'desc')
            ->limit(10)
            ->get();

        $activities = $this->activityLogRepository->getAllLogs($account->getKey());

        $data = compact('totalJobs', 'totalCompanies', 'totalApplicants', 'expiredJobs', 'newApplicants', 'activities');

        return JobBoardHelper::view('dashboard.index', $data);
    }

    public function getPackages()
    {
        /**
         * @var Account $account
         */

        $account = auth('account')->user();

        page_title()->setTitle(__('Packages'));
        SeoHelper::setTitle(__('Packages'));

        Assets::addScriptsDirectly('vendor/core/plugins/job-board/js/components.js')
            ->usingVueJS();

        if (is_plugin_active('language')) {
            Language::setCurrentAdminLocale(Language::getCurrentLocaleCode());
        }

        $account->load(['packages']);

        $packages = $this->packageRepository
            ->select(['jb_packages.*'])
            ->where('jb_packages.status', BaseStatusEnum::PUBLISHED)
            ->orderBy('jb_packages.order', 'desc')
            ->withCount([
                'accounts' => function ($query) use ($account) {
                    $query->where('account_id', $account->getKey());
                },
            ])
            ->get();

        $paidPackages = $packages->filter(function ($package) {
            return $package->total_price > 0;
        });

        $freePackages = $packages->filter(function ($package) {
            return $package->total_price == 0;
        });

        $data = compact('paidPackages', 'freePackages', 'packages');

        return JobBoardHelper::view('dashboard.packages', $data);
    }

    public function ajaxGetPackages(PackageInterface $packageRepository, BaseHttpResponse $response)
    {
        if (!JobBoardHelper::isEnabledCreditsSystem()) {
            abort(404);
        }

        if (is_plugin_active('language')) {
            Language::setCurrentAdminLocale(Language::getCurrentLocaleCode());
        }

        $account = $this->accountRepository->findOrFail(
            auth('account')->id(),
            ['packages']
        );

        $packages = $packageRepository->advancedGet([
            'condition' => ['status' => BaseStatusEnum::PUBLISHED],
        ]);

        $packages = $packages->filter(function ($package) use ($account) {
            return $package->account_limit === null || $account->packages->where(
                'id',
                $package->id
            )->count() < $package->account_limit;
        });

        return $response->setData([
            'packages' => PackageResource::collection($packages),
            'account' => new AccountResource($account),
        ]);
    }

    public function subscribePackage(
        Request $request,
        BaseHttpResponse $response,
        TransactionInterface $transactionRepository
    ) {
        $id = $request->input('id');
        if (!JobBoardHelper::isEnabledCreditsSystem() || !$id) {
            abort(404);
        }

        $package = $this->getPackageById($id);

        $account = $this->accountRepository->findOrFail(auth('account')->id());

        if ($package->account_limit && $account->packages()->where(
            'package_id',
            $package->id
        )->count() >= $package->account_limit) {
            abort(403);
        }

        if ((float)$package->price) {
            session(['subscribed_packaged_id' => $package->id]);

            return $response
                ->setNextUrl(route('public.account.package.subscribe', $package->id))
                ->setData(['next_page' => route('public.account.package.subscribe', $package->id)]);
        }

        $this->savePayment($package, null, $transactionRepository, true);

        return $response
            ->setData(new AccountResource($account->refresh()))
            ->setMessage(trans('plugins/job-board::package.add_credit_success'));
    }

    protected function getPackageById(int $id)
    {
        $package = $this->packageRepository->getFirstBy([
            'id' => $id,
            'status' => BaseStatusEnum::PUBLISHED,
        ]);

        if (!$package) {
            abort(404);
        }

        /**
         * @var Account $account
         */
        $account = auth('account')->user();

        if ($package->account_limit) {
            $accountLimit = $account->packages()->where('package_id', $package->id)->count();
            if ($accountLimit >= $package->account_limit) {
                abort(403);
            }
        }

        return $package;
    }


    //This function is responsible for free package process
    protected function savePayment(Package $package, ?string $chargeId, TransactionInterface $transactionRepository, bool $force = false)
    {
        if (!JobBoardHelper::isEnabledCreditsSystem()) {
            abort(404);
        }

        $payment = app(PaymentInterface::class)->getFirstBy(['charge_id' => $chargeId]);

        if (!$payment && !$force) {
            return false;
        }

        /**
         * @var Account $account
         */
        $account = auth('account')->user();

        if (($payment && $payment->status == PaymentStatusEnum::COMPLETED) || $force) {
            $account->credits += $package->number_of_listings;
            $account->save();

            $account->packages()->attach($package);
        }

        $transactionRepository->createOrUpdate([
            'user_id' => 0,
            'account_id' => auth('account')->id(),
            'credits' => $package->number_of_listings,
            'payment_id' => $payment ? $payment->id : null,
        ]);

        if (!$package->total_price) {
            EmailHandler::setModule(JOB_BOARD_MODULE_SCREEN_NAME)
                ->setVariableValues([
                    'account_name' => $account->name,
                    'account_email' => $account->email,
                ])
                ->sendUsingTemplate('free-credit-claimed');
        } else {
            EmailHandler::setModule(JOB_BOARD_MODULE_SCREEN_NAME)
                ->setVariableValues([
                    'account_name' => $account->name,
                    'account_email' => $account->email,
                    'package_name' => $package->name,
                    'package_price' => format_price($package->total_price / $package->number_of_listings) . '/credit',
                    'package_discount' => ($package->percent_discount ?: 0) . '%' . ($package->percent_discount > 0 ? ' (Save ' . format_price($package->price - $package->total_price) . ')' : ''),
                    'package_total' => format_price($package->total_price) . ' for ' . $package->number_of_listings . ' credits',
                ])
                ->sendUsingTemplate('payment-received');
        }

        EmailHandler::setModule(JOB_BOARD_MODULE_SCREEN_NAME)
            ->setVariableValues([
                'account_name' => $account->name,
                'package_name' => $package->name,
                'package_price' => format_price($package->total_price / $package->number_of_listings) . '/credit',
                'package_discount' => ($package->percent_discount ?: 0) . '%' . ($package->percent_discount > 0 ? ' (Save ' . format_price($package->price - $package->total_price) . ')' : ''),
                'package_total' => format_price($package->total_price) . ' for ' . $package->number_of_listings . ' credits',
            ])
            ->sendUsingTemplate('payment-receipt', auth('account')->user()->email);

        return true;
    }

    public function getSubscribePackage(int $id)
    {
        if (!JobBoardHelper::isEnabledCreditsSystem()) {
            abort(404);
        }

        $package = $this->getPackageById($id);

        SeoHelper::setTitle(trans('plugins/job-board::package.subscribe_package', ['name' => $package->name]));

        return view('plugins/job-board::account.checkout', compact('package'));
    }

    public function getPackageSubscribeCallback(
        int $packageId,
        Request $request,
        TransactionInterface $transactionRepository,
        BaseHttpResponse $response
    ) {
        if (!JobBoardHelper::isEnabledCreditsSystem()) {
            abort(404);
        }

        $package = $this->getPackageById($packageId);

        if (is_plugin_active('paypal') && $request->input('type') == PAYPAL_PAYMENT_METHOD_NAME) {
            $validator = Validator::make($request->input(), [
                'amount' => 'required|numeric',
                'currency' => 'required',
            ]);

            if ($validator->fails()) {
                return $response->setError()->setMessage($validator->getMessageBag()->first());
            }

            $payPalService = app(PayPalPaymentService::class);

            $paymentStatus = $payPalService->getPaymentStatus($request);
            if ($paymentStatus) {
                $chargeId = session('paypal_payment_id');

                $payPalService->afterMakePayment($request->input());

                $this->savePayment($package, $chargeId, $transactionRepository);

                return $response
                    ->setNextUrl(route('public.account.packages'))
                    ->setMessage(trans('plugins/job-board::package.add_credit_success'));
            }

            return $response
                ->setError()
                ->setNextUrl(route('public.account.packages'))
                ->setMessage($payPalService->getErrorMessage());
        }

        $this->savePayment($package, $request->input('charge_id'), $transactionRepository);

        if (!$request->has('success') || $request->input('success')) {
            return $response
                ->setNextUrl(route('public.account.packages'))
                ->setMessage(session()->get('success_msg') ?: trans('plugins/job-board::package.add_credit_success'));
        }

        return $response
            ->setError()
            ->setNextUrl(route('public.account.packages'))
            ->setMessage(__('Payment failed!'));
    }

    public function ajaxGetTransactions(TransactionInterface $transactionRepository, BaseHttpResponse $response)
    {
        $transactions = $transactionRepository->advancedGet([
            'condition' => [
                'account_id' => auth('account')->id(),
            ],
            'paginate' => [
                'per_page' => 10,
                'current_paged' => 1,
            ],
            'order_by' => ['created_at' => 'DESC'],
            'with' => ['payment', 'user'],
        ]);

        return $response->setData(TransactionResource::collection($transactions))->toApiResponse();
    }
}
