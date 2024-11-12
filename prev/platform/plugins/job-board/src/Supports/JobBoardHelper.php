<?php

namespace Botble\JobBoard\Supports;

use BaseHelper;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\JobBoard\Enums\AccountTypeEnum;
use Botble\JobBoard\Enums\ModerationStatusEnum;
use Botble\JobBoard\Repositories\Interfaces\AccountInterface;
use Botble\Page\Models\Page;
use Botble\Page\Repositories\Interfaces\PageInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Theme;

class JobBoardHelper
{
    protected ?string $jobsPageURL = null;

    protected ?string $jobCategoriesPageURL = null;

    protected ?string $jobCandidatesPageURL = null;

    protected ?string $jobCompaniesPageURL = null;

    public function isGuestApplyEnabled(): bool
    {
        return setting('job_board_enable_guest_apply', 1) == 1;
    }

    public function isRegisterEnabled(): bool
    {
        return setting('job_board_enabled_register', 1) == 1;
    }

    public function jobExpiredDays(): int
    {
        $days = (int)setting('job_expired_after_days');

        if ($days > 0) {
            return $days;
        }

        return 45;
    }

    public function isEnabledCreditsSystem(): bool
    {
        return setting('job_board_enable_credits_system', 1) == 1;
    }

    public function isEnabledJobApproval(): bool
    {
        return setting('job_board_enable_post_approval', 1) == 1;
    }

    public function getThousandSeparatorForInputMask(): string
    {
        return ',';
    }

    public function getDecimalSeparatorForInputMask(): string
    {
        return '.';
    }

    public function getJobDisplayQueryConditions(): array
    {
        return [
            'jb_jobs.moderation_status' => ModerationStatusEnum::APPROVED,
            'jb_jobs.status' => BaseStatusEnum::PUBLISHED,
        ];
    }

    public function postedDateRanges(): array
    {
        return [
            'last_hour' => [
                'name' => __('Last hour'),
                'end' => now()->subHour(),
            ],
            'last_24_hours' => [
                'name' => __('Last 24 hours'),
                'end' => now()->subDay(),
            ],
            'last_7_days' => [
                'name' => __('Last 7 days'),
                'end' => now()->subWeek(),
            ],
            'last_14_days' => [
                'name' => __('Last 14 days'),
                'end' => now()->subWeeks(2),
            ],
            'last_1_month' => [
                'name' => __('Last 1 month'),
                'end' => now()->subMonth(),
            ],
        ];
    }

    public function getAssetVersion(): string
    {
        return '1.1.0';
    }

    public function viewPath(string $view): string
    {
        $themeView = Theme::getThemeNamespace(Theme::getConfig('containerDir.view') . '.job-board.' . $view);

        if (view()->exists($themeView)) {
            return $themeView;
        }

        return 'plugins/job-board::themes.' . $view;
    }

    public function view(string $view, array $data = []): Factory|View|Application
    {
        return view($this->viewPath($view), $data);
    }

    public function scope(string $view, array $data = [])
    {
        $path = Theme::getThemeNamespace(Theme::getConfig('containerDir.view') . '.job-board.' . $view);

        if (view()->exists($path)) {
            return Theme::scope('job-board.' . $view, $data)->render();
        }

        return view('plugins/job-board::themes.' . $view, $data)->render();
    }

    protected function getPage($pageId): ?Page
    {
        if (! $pageId) {
            return null;
        }

        return app(PageInterface::class)->getFirstBy([
            'id' => $pageId,
            'status' => BaseStatusEnum::PUBLISHED,
        ], ['id', 'name'], ['slugable']);
    }

    public function getJobsPageURL(): ?string
    {
        if ($this->jobsPageURL) {
            return $this->jobsPageURL;
        }

        $page = $this->getPage(theme_option('job_list_page_id'));

        $this->jobsPageURL = $page?->url;

        return $this->jobsPageURL;
    }

    public function getJobCategoriesPageURL(): ?string
    {
        if ($this->jobCategoriesPageURL) {
            return $this->jobCategoriesPageURL;
        }

        $page = $this->getPage(theme_option('job_categories_page_id'));

        $this->jobCategoriesPageURL = $page?->url;

        return $this->jobCategoriesPageURL;
    }

    public function getJobCompaniesPageURL(): ?string
    {
        if ($this->jobCompaniesPageURL) {
            return $this->jobCompaniesPageURL;
        }

        $page = $this->getPage(theme_option('job_companies_page_id'));

        $this->jobCompaniesPageURL = $page?->url;

        return $this->jobCompaniesPageURL;
    }

    public function getJobCandidatesPageURL(): ?string
    {
        if ($this->jobCandidatesPageURL) {
            return $this->jobCandidatesPageURL;
        }

        $page = $this->getPage(theme_option('job_candidates_page_id'));

        $this->jobCandidatesPageURL = $page?->url;

        return $this->jobCandidatesPageURL;
    }

    public function getJobFilters(Request $request): array
    {
        return [
            'keyword' => BaseHelper::stringify($request->input('keyword')),
            'city_id' => (int)$request->input('city_id'),
            'location' => BaseHelper::stringify($request->input('location')),
            'categories' => (array)$request->input('job_categories', []),
            'tags' => (array)$request->input('job_tags', []),
            'types' => (array)$request->input('job_types', []),
            'experiences' => (array)$request->input('job_experiences', []),
            'skills' => (array)$request->input('job_skills', []),
            'offered_salary_from' => BaseHelper::stringify($request->input('offered_salary_from')),
            'offered_salary_to' => BaseHelper::stringify($request->input('offered_salary_to')),
            'date_posted' => BaseHelper::stringify($request->input('date_posted')),
            'per_page' => (int) $request->query('per_page'),
            'page' => (int) $request->query('page', 1),
        ];
    }

    public function jobFilterParamsValidated(array $params): bool
    {
        $validator = Validator::make($params, [
            'keyword' => 'nullable|string|max:255',
            'location' => 'nullable|string',
            'city_id' => 'nullable|numeric',
            'categories' => 'nullable|array',
            'job_tags' => 'nullable|array',
            'types' => 'nullable|array',
            'experiences' => 'nullable|array',
            'skills' => 'nullable|array',
            'offered_salary_from' => 'nullable|numeric',
            'offered_salary_to' => 'nullable|numeric',
            'date_posted' => 'nullable|string',
            'per_page' => 'nullable|numeric',
        ]);

        return ! $validator->fails();
    }

    public function getCompanyFilterParams(Request $request): array
    {
        return [
            'per_page' => (int)$request->query('per_page'),
            'keyword' => BaseHelper::stringify($request->query('keyword')),
            'sort_by' => (int)$request->query('sort_by'),
            'page' => (int)$request->query('page', 1),
        ];
    }

    public function companyFilterParamsValidated(array $params): bool
    {
        $validator = Validator::make($params, [
            'per_page' => 'nullable|numeric',
            'keyword' => 'nullable|string',
            'sort_by' => 'nullable|string|in:newest,oldest',
            'page' => 'nullable|numeric',
        ]);

        return ! $validator->fails();
    }

    public function filterCandidates(array $params): Paginator
    {
        $data = Validator::validate($params, [
            'keyword' => ['nullable', 'alpha', 'max:1'],
            'per_page' => ['nullable', 'numeric'],
            'sort_by' => ['nullable', Rule::in($this->getSortByParams())],
            'page' => ['nullable', 'numeric'],
        ]);

        $sortBy = match ($data['sort_by'] ?? 'newest') {
            'oldest' => [
                'is_featured' => 'DESC',
                'created_at' => 'ASC',
            ],
            default => [
                'is_featured' => 'DESC',
                'created_at' => 'DESC',
            ],
        };

        $conditions = [
            'is_public_profile' => 1,
            'type' => AccountTypeEnum::JOB_SEEKER,
        ];

        $with = [
            'avatar',
            'slugable',
        ];

        if (is_plugin_active('location')) {
            $with = array_merge($with, [
                'country',
                'state',
            ]);
        }

        if (! empty($data['keyword'])) {
            $conditions[] = ['jb_accounts.first_name', 'like', $data['keyword'] . '%'];
        }

        return app(AccountInterface::class)
            ->advancedGet([
                'condition' => $conditions,
                'with' => $with,
                'order_by' => $sortBy,
                'paginate' => [
                    'per_page' => $data['per_page'] ?? 12,
                    'current_paged' => $data['page'] ?? 1,
                ],
            ]);
    }

    public function getSortByParams(): array
    {
        return [
            'newest',
            'oldest',
        ];
    }

    public function getPerPageParams(): array
    {
        return [12, 24, 36];
    }
}
