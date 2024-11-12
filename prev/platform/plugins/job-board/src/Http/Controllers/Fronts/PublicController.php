<?php

namespace Botble\JobBoard\Http\Controllers\Fronts;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Supports\Helper;
use Botble\JobBoard\Enums\AccountTypeEnum;
use Botble\JobBoard\Http\Requests\ApplyJobRequest;
use Botble\JobBoard\Models\Account;
use Botble\JobBoard\Models\AccountEducation;
use Botble\JobBoard\Models\AccountExperience;
use Botble\JobBoard\Models\Category;
use Botble\JobBoard\Models\Company;
use Botble\JobBoard\Models\Job as JobModel;
use Botble\JobBoard\Models\Tag;
use Botble\JobBoard\Repositories\Interfaces\AccountInterface;
use Botble\JobBoard\Repositories\Interfaces\AnalyticsInterface;
use Botble\JobBoard\Repositories\Interfaces\CategoryInterface;
use Botble\JobBoard\Repositories\Interfaces\CompanyInterface;
use Botble\JobBoard\Repositories\Interfaces\CurrencyInterface;
use Botble\JobBoard\Repositories\Interfaces\JobApplicationInterface;
use Botble\JobBoard\Repositories\Interfaces\JobExperienceInterface;
use Botble\JobBoard\Repositories\Interfaces\JobInterface;
use Botble\JobBoard\Repositories\Interfaces\JobSkillInterface;
use Botble\JobBoard\Repositories\Interfaces\JobTypeInterface;
use Botble\JobBoard\Repositories\Interfaces\TagInterface;
use Botble\SeoHelper\SeoOpenGraph;
use EmailHandler;
use Exception;
use GeoIp2\Database\Reader;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use JobBoardHelper;
use RvMedia;
use SeoHelper;
use SlugHelper;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Theme;

class PublicController extends Controller
{
    public function __construct(
        protected JobInterface $jobRepository,
        protected JobApplicationInterface $jobApplicationRepository
    ) {
    }

    public function getJob(string $slug, Request $request)
    {
        $slug = SlugHelper::getSlug($slug, SlugHelper::getPrefix(JobModel::class));

        if (! $slug) {
            abort(404);
        }

        $condition = ['jb_jobs.id' => $slug->reference_id] + JobBoardHelper::getJobDisplayQueryConditions();

        if (Auth::check()) {
            Arr::forget($condition, 'status');
            Arr::forget($condition, 'moderation_status');
        }
        $job = $this->jobRepository->getJobs([], [
            'condition' => $condition,
            'take' => 1,
            'with' => [],
        ]);

        if (! $job) {
            abort(404);
        }

        $job->setRelation('slugable', $slug);

        SeoHelper::setTitle($job->name)->setDescription($job->description);

        $meta = new SeoOpenGraph();
        $meta->setDescription($job->description);
        $meta->setUrl($job->url);
        $meta->setTitle($job->name);
        $meta->setType('article');

        $company = $job->company;

        $company->loadCount('jobs');

        if (! $job->hide_company && $company->logo) {
            $meta->setImage(RvMedia::getImageUrl($company->logo));
        }

        SeoHelper::setSeoOpenGraph($meta);

        Theme::breadcrumb()
            ->add(__('Home'), route('public.index'))
            ->add(__('Jobs'), JobBoardHelper::getJobsPageURL())
            ->add($job->name, $job->url);

        if (function_exists('admin_bar')) {
            admin_bar()->registerLink(__('Edit this job'), route('jobs.edit', $job->id), 'jobs.edit');
        }

        do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, JOB_MODULE_SCREEN_NAME, $job);

        $companyJobs = collect([]);

        if (! $job->hide_company && $company->id) {
            $condition = [
                ['jb_jobs.company_id', '=', $company->id],
                ['jb_jobs.id', '!=', $job->id],
                ['jb_jobs.hide_company', '=', false],
            ];

            foreach (JobBoardHelper::getJobDisplayQueryConditions() as $key => $value) {
                $condition[] = [$key, '=', $value];
            }

            $companyJobs = $this->jobRepository->getJobs(
                [],
                [
                    'condition' => $condition,
                    'take' => 5,
                    'order_by' => [
                        'jb_jobs.created_at' => 'desc',
                    ],
                ],
            );
        }

        if (! array_key_exists($job->id, session()->get('viewed_job', []))) {
            $job->increment('views');

            try {
                $ip = Helper::getIpFromThirdParty();
            } catch (Exception) {
                $ip = $request->ip();
            }

            $countries = $this->getCountries($ip);

            app(AnalyticsInterface::class)->createOrUpdate([
                'job_id' => $job->id,
                'country' => Arr::get($countries, 'countryCode'),
                'country_full' => Arr::get($countries, 'countryName'),
                'referer' => Str::limit(request()->server('HTTP_REFERER') ?? null, 250),
                'ip_address' => Str::limit($ip, 39),
                'ip_hashed' => 0,
            ]);

            session()->put('viewed_job.' . $job->id, time());
        }

        $data = compact('job', 'companyJobs', 'company');

        return Theme::scope('job-board.job', $data, 'plugins/job-board::themes.job')->render();
    }

    public function getJobs(Request $request, BaseHttpResponse $response)
    {
        if (! JobBoardHelper::jobFilterParamsValidated($request->input())) {
            return $response;
        }

        $sortBy = match ($request->input('sort_by') ?: 'oldest') {
            'newest' => [
                'jb_jobs.created_at' => 'DESC',
                'jb_jobs.is_featured' => 'DESC',
            ],
            default => [
                'jb_jobs.created_at' => 'ASC',
                'jb_jobs.is_featured' => 'DESC',
            ],
        };

        $jobs = $this->jobRepository->getJobs(
            JobBoardHelper::getJobFilters($request),
            [
                'order_by' => $sortBy,
                'paginate' => [
                    'per_page' => (int)$request->query('per_page') ?: 10,
                    'current_paged' => (int)$request->input('page'),
                ],
            ],
        );

        $total = $jobs->total();
        $jobCategories = app(CategoryInterface::class)->allBy(['status' => BaseStatusEnum::PUBLISHED]);

        if ($total) {
            $message = __('Showing :from – :to of :total results', [
                'from' => $jobs->firstItem(),
                'to' => $jobs->lastItem(),
                'total' => $jobs->total(),
            ]);
        } else {
            $message = __('No results found');
        }

        $view = Theme::getThemeNamespace('views.job-board.partials.job-items');

        if (! view()->exists($view)) {
            $view = 'plugins/job-board::themes.partials.job-items';
        }

        return $response
            ->setData(view($view, compact('jobs', 'jobCategories'))->render())
            ->setAdditional([
                'total' => $total,
                'message' => $message,
            ])
            ->setMessage($message);
    }

    public function getCompanies(Request $request, BaseHttpResponse $response)
    {
        if (! JobBoardHelper::companyFilterParamsValidated($request->input())) {
            return $response;
        }

        $requestQuery = JobBoardHelper::getCompanyFilterParams($request);

        $sortBy = match ($requestQuery['sort_by'] ?? 'oldest') {
            'newest' => [
                'jb_companies.is_featured' => 'DESC',
                'jb_companies.created_at' => 'DESC',
            ],
            default => [
                'jb_companies.is_featured' => 'DESC',
                'jb_companies.created_at' => 'ASC',
            ],
        };

        $condition = [];

        if ($requestQuery['keyword']) {
            $condition['like'] = ['jb_companies.name', 'like', $requestQuery['keyword'] . '%'];
        }

        $companies = app(CompanyInterface::class)
            ->advancedGet([
                'withCount' => [
                    'jobs' => function ($query) {
                        $query->where(JobBoardHelper::getJobDisplayQueryConditions());
                    },
                    'reviews',
                ],
                'condition' => $condition,
                'order_by' => $sortBy,
                'with' => ['slugable'],
                'withAvg' => ['reviews', 'star'],
                'paginate' => [
                    'per_page' => (int)$requestQuery['per_page'] ?: 12,
                    'current_paged' => (int)$requestQuery['page'] ?: 1,
                ],
            ]);

        $total = $companies->total();

        if ($total) {
            $message = __('Showing :from – :to of :total results', [
                'from' => $companies->firstItem(),
                'to' => $companies->lastItem(),
                'total' => $companies->total(),
            ]);
        } else {
            $message = __('No results found');
        }

        $view = Theme::getThemeNamespace('views.job-board.partials.companies');

        if (! view()->exists($view)) {
            $view = 'plugins/job-board::themes.partials.companies';
        }

        return $response
            ->setData(view($view, compact('companies'))->render())
            ->setAdditional([
                'total' => $total,
                'message' => $message,
            ])
            ->setMessage($message);
    }

    public function postApplyJob(ApplyJobRequest $request, BaseHttpResponse $response, int $id = null)
    {
        if (! auth('account')->check() && ! JobBoardHelper::isGuestApplyEnabled()) {
            throw new HttpException(422, __('Please login to apply this job!'));
        }

        try {
            if (! $id) {
                $id = $request->input('job_id');
            }

            if (! $id) {
                abort(404);
            }

            $request->merge(['account_id' => null]);

            $job = $this->jobRepository->getJobs([], [
                'condition' => ['jb_jobs.id' => $id] + JobBoardHelper::getJobDisplayQueryConditions(),
                'take' => 1,
                'with' => ['author'],
            ]);

            if (! $job) {
                abort(404);
            }

            if (($job->apply_url && $request->input('job_type') !== 'external') ||
                (! $job->apply_url && $request->input('job_type') !== 'internal')
            ) {
                return $response->setError()->setMessage(__('This job is not available for apply.'));
            }

            if (auth('account')->check()) {
                /**
                 * @var Account $account
                 */
                $account = auth('account')->user();

                if ($account->isEmployer()) {
                    return $response
                        ->setError()
                        ->setMessage(__('Employers cannot apply for the job'));
                }

                $request->merge(['account_id' => $account->getKey()]);

                if ($job->is_applied) {
                    return $response
                        ->setError()
                        ->setMessage(__('You have already applied for this job. Please wait for the employer to respond.'));
                }
            }

            $jobApplication = $this->jobApplicationRepository->getModel();

            $request->merge(['job_id' => $job->id]);

            if (! $job->apply_url) {
                if ($request->hasFile('resume')) {
                    $result = RvMedia::handleUpload($request->file('resume'), 0, 'job-applications');

                    if (! $result['error']) {
                        $file = $result['data'];
                        $request->merge(['resume' => $file->url]);
                    } else {
                        $request->merge(['resume' => null]);
                    }
                } elseif (auth('account')->check() && $resume = auth('account')->user()->resume) {
                    $request->merge(['resume' => $resume]);
                }

                if ($request->hasFile('cover_letter')) {
                    $result = RvMedia::handleUpload($request->file('cover_letter'), 0, 'job-applications');

                    if (! $result['error']) {
                        $file = $result['data'];
                        $request->merge(['cover_letter' => $file->url]);
                    } else {
                        $request->merge(['cover_letter' => null]);
                    }
                } elseif (auth('account')->check() && $coverLetter = auth('account')->user()->cover_letter) {
                    $request->merge(['cover_letter' => $coverLetter]);
                }
            } else {
                $request->merge(['resume' => null, 'cover_letter' => null]);
                $jobApplication->is_external_apply = true;
            }

            $jobApplication->fill($request->input());

            $this->jobApplicationRepository->createOrUpdate($jobApplication);

            $job->increment('number_of_applied');

            if (! $job->apply_url) {
                $emails = $job->employer_emails;

                $emailHandler = EmailHandler::setModule(JOB_BOARD_MODULE_SCREEN_NAME)
                    ->setVariableValues([
                        'job_application_name' => $jobApplication->full_name,
                        'job_application_position' => $jobApplication->job->name ?? '...',
                        'job_application_email' => $jobApplication->email ?? '...',
                        'job_application_phone' => $jobApplication->phone ?? '...',
                        'job_application_summary' => $jobApplication->message ? strip_tags($jobApplication->message) : '...',
                        'job_application_resume' => $jobApplication->resume ? RvMedia::url($jobApplication->resume) : '...',
                        'job_application_cover_letter' => $jobApplication->cover_letter ? RvMedia::url($jobApplication->cover_letter) : '...',
                    ]);

                $data = [
                    'attachments' => $jobApplication->resume ? RvMedia::getRealPath($jobApplication->resume) : '',
                ];

                if (count($emails)) {
                    $emailHandler->sendUsingTemplate('employer-new-job-application', $emails, $data);
                }

                $emailHandler->sendUsingTemplate('admin-new-job-application', null, $data);
            }

            return $response->setData(['url' => $job->apply_url])
                ->setMessage(trans('plugins/job-board::job-application.email.success'));
        } catch (Exception $exception) {
            info($exception);

            return $response
                ->setError()
                ->setMessage(trans('plugins/job-board::job-application.email.failed'));
        }
    }

    public function getJobCategory(string $slug, Request $request, CategoryInterface $categoryRepository, BaseHttpResponse $response)
    {
        $slug = SlugHelper::getSlug($slug, SlugHelper::getPrefix(Category::class));

        if (! $slug) {
            abort(404);
        }

        $condition = [
            'id' => $slug->reference_id,
            'status' => BaseStatusEnum::PUBLISHED,
        ];

        if (Auth::check()) {
            Arr::forget($condition, 'status');
            Arr::forget($condition, 'moderation_status');
        }

        $category = $categoryRepository->getFirstBy($condition);

        if (! $category) {
            abort(404);
        }

        SeoHelper::setTitle($category->name)->setDescription($category->description);

        $meta = new SeoOpenGraph();
        $meta->setDescription($category->description);
        $meta->setUrl($category->url);
        $meta->setTitle($category->name);
        $meta->setType('article');

        SeoHelper::setSeoOpenGraph($meta);

        Theme::breadcrumb()
            ->add(__('Home'), route('public.index'))
            ->add(__('Categories'), JobBoardHelper::getJobCategoriesPageURL())
            ->add($category->name, $category->url);

        if (function_exists('admin_bar')) {
            admin_bar()->registerLink(__('Edit this job category'), route('job-categories.edit', $category->id), 'job-categories.edit');
        }

        if (! JobBoardHelper::jobFilterParamsValidated($request->input())) {
            return $response->setNextUrl($category->url);
        }

        $jobs = $this->jobRepository->getJobs(
            array_merge(JobBoardHelper::getJobFilters($request), [
                'categories' => [$category->id],
            ]),
            [
                'paginate' => [
                    'per_page' => 20,
                    'current_paged' => (int)$request->input('page'),
                ],
            ]
        );

        $jobCategories = app(CategoryInterface::class)->allBy(['status' => BaseStatusEnum::PUBLISHED]);
        $jobTypes = app(JobTypeInterface::class)->allBy(['status' => BaseStatusEnum::PUBLISHED]);
        $jobExperiences = app(JobExperienceInterface::class)->allBy(['status' => BaseStatusEnum::PUBLISHED]);
        $jobSkills = app(JobSkillInterface::class)->allBy(['status' => BaseStatusEnum::PUBLISHED]);

        $jobFeaturedCategories = $jobCategories->where('is_featured')
            ->loadCount([
                'jobs' => function ($query) {
                    $query
                        ->where('jb_jobs.status', BaseStatusEnum::PUBLISHED)
                        ->notExpired();
                },
            ]);

        $data = compact(
            'category',
            'jobs',
            'jobExperiences',
            'jobTypes',
            'jobCategories',
            'jobFeaturedCategories',
            'jobSkills'
        );

        return Theme::scope('job-board.job-category', $data, 'plugins/job-board::themes.job-category')->render();
    }

    public function getJobTag(string $slug, Request $request, TagInterface $tagRepository, BaseHttpResponse $response)
    {
        $slug = SlugHelper::getSlug($slug, SlugHelper::getPrefix(Tag::class));

        if (! $slug) {
            abort(404);
        }

        $condition = [
            'id' => $slug->reference_id,
            'status' => BaseStatusEnum::PUBLISHED,
        ];

        if (Auth::check()) {
            Arr::forget($condition, 'status');
            Arr::forget($condition, 'moderation_status');
        }

        $tag = $tagRepository->getFirstBy($condition);

        if (! $tag) {
            abort(404);
        }

        SeoHelper::setTitle($tag->name)->setDescription($tag->description);

        $meta = new SeoOpenGraph();
        $meta->setDescription($tag->description);
        $meta->setUrl($tag->url);
        $meta->setTitle($tag->name);
        $meta->setType('article');

        SeoHelper::setSeoOpenGraph($meta);

        Theme::breadcrumb()
            ->add(__('Home'), route('public.index'))
            ->add($tag->name, $tag->url);

        if (function_exists('admin_bar')) {
            admin_bar()->registerLink(__('Edit this job tag'), route('job-board.tag.edit', $tag->id), 'job-board.tag.edit');
        }

        if (! JobBoardHelper::jobFilterParamsValidated($request->input())) {
            return $response->setNextUrl($tag->url);
        }

        $jobs = $this->jobRepository->getJobs(
            array_merge(JobBoardHelper::getJobFilters($request), [
                'tags' => [$tag->id],
            ]),
            [
                'paginate' => [
                    'per_page' => 20,
                    'current_paged' => (int)$request->input('page'),
                ],
            ]
        );

        $jobCategories = app(CategoryInterface::class)->allBy(['status' => BaseStatusEnum::PUBLISHED]);
        $jobTypes = app(JobTypeInterface::class)->allBy(['status' => BaseStatusEnum::PUBLISHED]);
        $jobExperiences = app(JobExperienceInterface::class)->allBy(['status' => BaseStatusEnum::PUBLISHED]);
        $jobSkills = app(JobSkillInterface::class)->allBy(['status' => BaseStatusEnum::PUBLISHED]);

        $jobFeaturedCategories = $jobCategories->where('is_featured')
            ->loadCount([
                'jobs' => function ($query) {
                    $query
                        ->where('jb_jobs.status', BaseStatusEnum::PUBLISHED)
                        ->notExpired();
                },
            ]);

        $data = compact(
            'tag',
            'jobs',
            'jobExperiences',
            'jobTypes',
            'jobCategories',
            'jobFeaturedCategories',
            'jobSkills'
        );

        return Theme::scope('job-board.job-tag', $data, 'plugins/job-board::themes.job-tag')->render();
    }

    protected function getCountries(string $ip): array
    {
        // We try to get the IP country using (or not) the anonymized IP
        // If it fails, because GeoLite2 doesn't know the IP country, we
        // will set it to Unknown
        try {
            $reader = new Reader(__DIR__ . '/../../../database/GeoLite2-Country.mmdb');
            $record = $reader->country($ip);
            $countryCode = $record->country->isoCode;
            $countryName = $record->country->name;
        } catch (Exception) {
            $countryCode = 'N/A';
            $countryName = 'Unknown';
        }

        return compact('countryCode', 'countryName');
    }

    public function getCompany(string $slug, CompanyInterface $companyRepository, BaseHttpResponse $response)
    {
        $slug = SlugHelper::getSlug($slug, SlugHelper::getPrefix(Company::class), Company::class);

        if (! $slug) {
            abort(404);
        }

        $condition = [
            'id' => $slug->reference_id,
            'status' => BaseStatusEnum::PUBLISHED,
        ];

        if (Auth::check() && request('preview')) {
            Arr::forget($condition, 'status');
        }

        $company = $companyRepository->getModel()
            ->query()
            ->where($condition)
            ->withCount([
                'jobs' => function (Builder $query) {
                    $query
                        ->where(JobBoardHelper::getJobDisplayQueryConditions())
                        ->where(['jb_jobs.hide_company' => false])
                        ->notExpired();
                },
                'reviews',
            ])
            ->withAvg('reviews', 'star')
            ->first();

        if (! $company) {
            abort(404);
        }

        $company->setRelation('reviews', $company->reviews()->paginate(10));

        $company->setRelation('slugable', $slug);

        $params = [
            'condition' => [
                    'jb_jobs.company_id' => $company->id,
                    'jb_jobs.hide_company' => false,
            ] + JobBoardHelper::getJobDisplayQueryConditions(),
            'order_by' => ['created_at' => 'DESC'],
            'paginate' => [
                'per_page' => 3,
                'current_paged' => (int)request()->query('page') ?: 1,
            ],
        ];

        $jobs = $this->jobRepository->getJobs([], $params);

        if (request()->ajax()) {
            $view = Theme::getThemeNamespace('views.job-board.partials.company-job-items');

            if (! view()->exists($view)) {
                $view = 'plugins/job-board::themes.partials.job-items';
            }

            return $response->setData(view($view, compact('jobs', 'company'))->render());
        }

        SeoHelper::setTitle($company->name)->setDescription($company->description);

        $meta = new SeoOpenGraph();
        if ($company->logo) {
            $meta->setImage(RvMedia::getImageUrl($company->logo));
        }
        $meta->setDescription($company->description);
        $meta->setUrl($company->url);
        $meta->setTitle($company->name);
        $meta->setType('article');

        SeoHelper::setSeoOpenGraph($meta);

        Helper::handleViewCount($company, 'viewed_company');

        Theme::breadcrumb()
            ->add(__('Home'), route('public.index'))
            ->add(__('Companies'), JobBoardHelper::getJobCompaniesPageURL())
            ->add($company->name, $company->url);

        do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, COMPANY_MODULE_SCREEN_NAME, $company);

        $canReviewCompany = Auth::guard('account')->check() &&
            ! Auth::guard('account')->user()->isEmployer() &&
            ! Auth::guard('account')->user()->hasReviewedCompany($company);

        return Theme::scope(
            'job-board.company',
            compact('company', 'jobs', 'canReviewCompany'),
            'plugins/job-board::themes.company'
        )->render();
    }

    public function getCandidate(string $slug, AccountInterface $accountRepository)
    {
        $slug = SlugHelper::getSlug($slug, SlugHelper::getPrefix(Account::class), Account::class);

        if (! $slug) {
            abort(404);
        }

        $condition = [
            ['id', '=', $slug->reference_id],
            ['is_public_profile', '=', 1],
            ['type', '=', AccountTypeEnum::JOB_SEEKER],
        ];

        if (setting('verify_account_email', 0)) {
            $condition[] = ['confirmed_at', '!=', null];
        }

        $candidate = $accountRepository->getModel()
            ->where($condition)
            ->firstOrFail();

        $candidate->setRelation('slugable', $slug);

        SeoHelper::setTitle($candidate->name)->setDescription($candidate->description);

        $meta = new SeoOpenGraph();
        if ($candidate->avatar_url) {
            $meta->setImage(RvMedia::getImageUrl($candidate->avatar_url));
        }
        $meta->setDescription($candidate->description);
        $meta->setUrl($candidate->url);
        $meta->setTitle($candidate->name);
        $meta->setType('article');

        SeoHelper::setSeoOpenGraph($meta);

        Helper::handleViewCount($candidate, 'viewed_account');

        Theme::breadcrumb()
            ->add(__('Home'), route('public.index'))
            ->add(__('Candidates'), JobBoardHelper::getJobCandidatesPageURL())
            ->add($candidate->name, $candidate->url);

        do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, ACCOUNT_MODULE_SCREEN_NAME, $candidate);

        $experiences = AccountExperience::where('account_id', $candidate->id)->get();
        $educations = AccountEducation::where('account_id', $candidate->id)->get();

        return Theme::scope('job-board.candidate', compact('candidate', 'experiences', 'educations'), 'plugins/job-board::themes.candidate')->render();
    }

    public function getCandidates(Request $request, BaseHttpResponse $response)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $candidates = JobBoardHelper::filterCandidates(request()->input());

        return $response->setData([
            'list' => view(Theme::getThemeNamespace('views.job-board.partials.candidate-list'), compact('candidates'))->render(),
            'total_text' => __('Showing :from-:to of :total candidate(s)', [
                'from' => $candidates->firstItem(),
                'to' => $candidates->lastItem(),
                'total' => $candidates->total(),
            ]),
        ]);
    }

    public function changeCurrency(
        Request $request,
        BaseHttpResponse $response,
        CurrencyInterface $currencyRepository,
        string $title = null
    ) {
        if (empty($title)) {
            $title = $request->input('currency');
        }

        if (! $title) {
            return $response;
        }

        $currency = $currencyRepository->getFirstBy(['title' => $title]);

        if ($currency) {
            cms_currency()->setApplicationCurrency($currency);
        }

        return $response;
    }
}
