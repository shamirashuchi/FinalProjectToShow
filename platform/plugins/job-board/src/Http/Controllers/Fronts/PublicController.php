<?php

namespace Botble\JobBoard\Http\Controllers\Fronts;

use Theme;
use RvMedia;
use Exception;
use SeoHelper;
use SlugHelper;
use EmailHandler;
use JobBoardHelper;
use GeoIp2\Database\Reader;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Botble\JobBoard\Models\Tag;
use Botble\Base\Supports\Helper;
use Botble\Media\Models\MediaFile;
use Botble\SeoHelper\SeoOpenGraph;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Botble\JobBoard\Models\Account;
use Botble\JobBoard\Models\Event;
use Botble\JobBoard\Models\Company;
use Botble\JobBoard\Models\Category;
use Botble\Media\Models\MediaFolder;
use Illuminate\Support\Facades\Auth;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\JobBoard\Enums\JobStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Botble\JobBoard\Enums\AccountTypeEnum;
use Botble\JobBoard\Models\Job as JobModel;
use Botble\Media\Services\ThumbnailService;
use Botble\JobBoard\Models\AccountEducation;
use Botble\JobBoard\Models\AccountExperience;
use Botble\JobBoard\Models\ConsultantPackage;
use Botble\Media\Http\Resources\FileResource;
use Botble\Media\Http\Resources\FolderResource;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\JobBoard\Http\Requests\ApplyJobRequest;
use Botble\JobBoard\Models\ConsultantReview;
use Botble\JobBoard\Repositories\Interfaces\JobInterface;
use Botble\JobBoard\Repositories\Interfaces\TagInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Botble\Media\Repositories\Interfaces\MediaFileInterface;
use Botble\JobBoard\Repositories\Interfaces\AccountInterface;

use Botble\JobBoard\Repositories\Interfaces\CompanyInterface;



use Botble\JobBoard\Repositories\Interfaces\JobTypeInterface;
use Botble\JobBoard\Repositories\Interfaces\CategoryInterface;
use Botble\JobBoard\Repositories\Interfaces\CurrencyInterface;
use Botble\JobBoard\Repositories\Interfaces\JobSkillInterface;
use Botble\Media\Repositories\Interfaces\MediaFolderInterface;
use Botble\JobBoard\Repositories\Interfaces\AnalyticsInterface;
use Botble\Media\Repositories\Interfaces\MediaSettingInterface;
use Botble\JobBoard\Repositories\Interfaces\JobExperienceInterface;
use Botble\JobBoard\Repositories\Interfaces\JobApplicationInterface;
use Botble\JobBoard\Notifications\AppointmentBooked;


class PublicController extends Controller
{
    public function __construct(
        protected MediaFileInterface $fileRepository,
        protected JobInterface $jobRepository,
        protected JobApplicationInterface $jobApplicationRepository
    ) {}

    public function consultantReviewDelete(BaseHttpResponse $response, $id)
    {
        $consultantReview = ConsultantReview::find($id);

        if ($consultantReview) {
            $consultantReview->delete();
            return redirect()->back()->with('success', 'Post created successfully');
        } else {
            return redirect()->back()->with('error', 'Review not found.');
        }
    }

    public function getJob(string $slug, Request $request)
    {
        $slug = SlugHelper::getSlug($slug, SlugHelper::getPrefix(JobModel::class));

        if (!$slug) {
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

        if (!$job) {
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

        if (!$job->hide_company && $company->logo) {
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

        if (!$job->hide_company && $company->id) {
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

        if (!array_key_exists($job->id, session()->get('viewed_job', []))) {
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

        $job->loadMissing('customFields');


        //dd($job->apply_url);


        return Theme::scope(
            'job-board.job',
            compact('job', 'companyJobs', 'company'),
            'plugins/job-board::themes.job'
        )->render();
    }

    public function getJobs(Request $request, BaseHttpResponse $response)
    {
        if (!JobBoardHelper::jobFilterParamsValidated($request->input())) {
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

        if (!view()->exists($view)) {
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


        if (!JobBoardHelper::companyFilterParamsValidated($request->input())) {
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

        if (!view()->exists($view)) {
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
        if (!auth('account')->check() && !JobBoardHelper::isGuestApplyEnabled()) {
            throw new HttpException(422, __('Please login to apply this job!'));
        }

        try {
            if (!$id) {
                $id = $request->input('job_id');
            }

            if (!$id) {
                abort(404);
            }

            $request->merge(['account_id' => null]);

            $job = $this->jobRepository->getJobs([], [
                'condition' => ['jb_jobs.id' => $id] + JobBoardHelper::getJobDisplayQueryConditions(),
                'take' => 1,
                'with' => ['author'],
            ]);

            if (!$job) {
                abort(404);
            }

            if (($job->apply_url && $request->input('job_type') !== 'external') ||
                (!$job->apply_url && $request->input('job_type') !== 'internal')
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

            if (!$job->apply_url) {
                if ($request->hasFile('resume')) {
                    $result = RvMedia::handleUpload($request->file('resume'), 0, 'job-applications');

                    if (!$result['error']) {
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

                    if (!$result['error']) {
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

            if (!$job->apply_url) {
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

    public function getJobCategory(
        string $slug,
        Request $request,
        CategoryInterface $categoryRepository,
        BaseHttpResponse $response
    ) {
        $slug = SlugHelper::getSlug($slug, SlugHelper::getPrefix(Category::class));

        if (!$slug) {
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

        if (!$category) {
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
            admin_bar()->registerLink(
                __('Edit this job category'),
                route('job-categories.edit', $category->id),
                'job-categories.edit'
            );
        }

        if (!JobBoardHelper::jobFilterParamsValidated($request->input())) {
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
                        ->where('jb_jobs.status', JobStatusEnum::PUBLISHED)
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

        if (!$slug) {
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

        if (!$tag) {
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
            admin_bar()->registerLink(
                __('Edit this job tag'),
                route('job-board.tag.edit', $tag->id),
                'job-board.tag.edit'
            );
        }

        if (!JobBoardHelper::jobFilterParamsValidated($request->input())) {
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
                        ->where('jb_jobs.status', JobStatusEnum::PUBLISHED)
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
        $slug = SlugHelper::getSlug($slug, SlugHelper::getPrefix(Company::class));

        if (!$slug) {
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

        if (!$company) {
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

            if (!view()->exists($view)) {
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
            !Auth::guard('account')->user()->isEmployer() &&
            !Auth::guard('account')->user()->hasReviewedCompany($company);



        // Get company id from company array
        $companyid = $company->id;

        // Use the $company->id and query the table jb_companies_accounts

        // from jb_companies_accounts get account_id

        // query jb_accounts table using account_id where jb_accounts.id = account_id

        // put the verified table from the result inside $checkverification variable


        $company = Company::find($companyid);



        $companyAccount = $company->accounts()->first(); // Get the first company account

        //dd($companyAccount->toArray());


        //$account = Account::find($companyAccount->account_id); // Get the associated account



        $checkverification = $companyAccount?->verified; // Get the verified column value


        if ($checkverification == "yes") {
            $verified = "yes";
        } else {
            $verified = "no";
        }



        return Theme::scope(
            'job-board.company',
            compact('company', 'jobs', 'canReviewCompany', 'verified'),
            'plugins/job-board::themes.company'
        )->render();
    }

    public function getCandidate(string $slug, AccountInterface $accountRepository)
    {
        $slug = SlugHelper::getSlug($slug, SlugHelper::getPrefix(Account::class));

        if (!$slug) {
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

        //$verified = "no";

        $checkverification = $candidate->verified;

        if ($checkverification == "yes") {
            $verified = "yes";
        } else {
            $verified = "no";
        }


        return Theme::scope(
            'job-board.candidate',
            compact('candidate', 'experiences', 'educations', 'verified'),
            'plugins/job-board::themes.candidate'
        )->render();



        //dd("suck!");


    }

    public function getCandidates(Request $request, BaseHttpResponse $response)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $candidates = JobBoardHelper::filterCandidates(request()->input());

        return $response->setData([
            'list' => view(
                Theme::getThemeNamespace('views.job-board.partials.candidate-list'),
                compact('candidates')
            )->render(),
            'total_text' => __('Showing :from-:to of :total candidate(s)', [
                'from' => $candidates->firstItem(),
                'to' => $candidates->lastItem(),
                'total' => $candidates->total(),
            ]),
        ]);
    }


    public function consultants()
    {
        // dd(auth('account')->user());
        //return view('supervisor.opsreview');

        $consultants = Account::where('type', '=', 'consultant')
            ->with('consultantReviews')
            ->get();


        //$file = $this->fileRepository->findOrFail(206);
        // dd($consultants);



        return Theme::scope(
            'job-board.consultants',
            ['consultants' => $consultants], // Pass the $consultants array to the view
            'plugins/job-board::themes.consultants'
        )->render();



        /*return Theme::scope(
            'job-board.consultants',
            [],
            'plugins/job-board::themes.consultants'
        )->render();*/
    }


    public function consultantdetails(Request $request, $id)
    {
        $auth = auth('account')->user()->id;
        $consultantdetails = Account::where(['type' => 'consultant', 'id' => $id])
            ->with(['consultantReviews.reviewer', 'consultantPackages' => function ($query) {
                $query->where('status', 'published');
            }])->first();


            // dd($auth);
            $jobseekerdetails = Account::where([
                'id' =>  $auth,
            ])->first();
        
// dd($jobseekerdetails->credits);
// $balance = DB::table('jb_transactions')
//     ->where('account_id', $auth)
//     ->sum('credits');
// dd($balance);
        // If avatar exists, get the URL
        if ($consultantdetails && $consultantdetails->avatar_id) {
            $consultantdetails->avatar_url = RvMedia::url($consultantdetails->avatar_id);
        } else {
            // Optional: Provide a default avatar URL
            $consultantdetails->avatar_url = RvMedia::url('path/to/default-avatar.png');
        }
       
        $event = Event::where('consultant_id', $id)
        ->where('date', '>=', now()->startOfDay())  // Ensure the event date is today or in the future
        ->when(now()->isToday(), function ($query) {
            // Convert the current time to 12-hour AM/PM format (e.g., 3:55 PM)
            $currentTime = now('America/New_York')->format('g:i A');
            // Compare start_time (stored as 12-hour AM/PM) with the current time
            $query->where('start_time', '>=', $currentTime); 
        })
        ->get();
       

        $currentTime = now('America/New_York')->format('g:i A');
       


       
        return Theme::scope(
            'job-board.consultantdetails',
            ['consultantdetails' => $consultantdetails,
            'events' => $event,
            'jobseekerdetails' => $jobseekerdetails],
            'plugins/job-board::themes.consultantdetails'
        )->render();
    }


    
    public function appointment(Request $request, $id)
    {
      
        $eventId = $id;
        $eventDate = $request->input('event_date');
        $auth = auth('account')->user()->id;
        $jobseekerdetails = Account::where([
            'id' =>  $auth,
        ])->first();
        if ($jobseekerdetails && $jobseekerdetails->credits > 0) {
        
            $jobseekerdetails->credits -= 1;
        
            
            $jobseekerdetails->save();
            
        }


        $event = Event::where('id',  $eventId)->first();
        // dd($event);
        $superadmindetails = Account::where([
            'type' =>  'superadmin',
            'first_name' => 'Ali'
        ])->first();

        if($event && $superadmindetails){
                 $event->superadmin_id = $superadmindetails->id;
                 $event->user_id = $auth;
                 $event->save();
        }
    //              $type = 'appointment_booked';  // or the specific type you want to use
    // $readAt = null;                // or a specific timestamp if needed
    // $notifiableId = $superadmindetails->id; // Use the actual superadmin ID
    // $eventId = $event->id;        // Replace with the actual event ID
    // $eventDate = $event->date;    // Replace with the actual event date

    // // Instantiate the notification with all required parameters
    // $notification = new AppointmentBooked($type, $readAt, $notifiableId, $eventId, $eventDate);

    // // Send the notification
    // $superadmindetails->notify($notification);

    //     }
        
        
        // dd($event);
        // You can also return a response to the client
        return response()->json([
            'message' => 'Appointment booked successfully!',
            'event_id' => $eventId,
            'event_date' => $eventDate,
            'event'  => $event,
            'superadmindetails' => $superadmindetails,
        ]);
    }


    public function consultantReviewed(Request $request, $id)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'rating' => 'required|numeric|min:1|max:5',
            'note' => 'nullable',
        ]);

        // Handle validation failure
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }
        // Find the consultant by ID
        $consultant = Account::where('type', 'consultant')->with('consultantReviews')->findOrFail($id);
        $authId = auth('account')->id();
        if ($authId) {
            // Create the review
            $consultant->consultantReviews()->create([
                'reviewer_id' => auth('account')->id(),
                'rating' => $request->input('rating'),
                'note' => $request->input('note')
            ]);
            // Return a JSON success response
            return response()->json([
                'status' => 'success',
                'message' => 'Review submitted successfully.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'errors' => 'Something went wrong!'
            ], 422);
        }
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

        if (!$title) {
            return $response;
        }

        $currency = $currencyRepository->getFirstBy(['title' => $title]);

        if ($currency) {
            cms_currency()->setApplicationCurrency($currency);
        }

        return $response;
    }
}
