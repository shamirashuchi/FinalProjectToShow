<?php

namespace Botble\JobBoard\Http\Controllers;

use Assets;
use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\JobBoard\Enums\ModerationStatusEnum;
use Botble\JobBoard\Events\JobPublishedEvent;
use Botble\JobBoard\Forms\JobForm;
use Botble\JobBoard\Http\Requests\ExpireJobsRequest;
use Botble\JobBoard\Http\Requests\JobRequest;
use Botble\JobBoard\Models\Account;
use Botble\JobBoard\Repositories\Interfaces\AnalyticsInterface;
use Botble\JobBoard\Repositories\Interfaces\JobInterface;
use Botble\JobBoard\Services\StoreTagService;
use Botble\JobBoard\Tables\JobTable;
use Exception;
use Illuminate\Http\Request;
use JobBoardHelper;

class JobController extends BaseController
{
    protected JobInterface $jobRepository;

    protected AnalyticsInterface $analyticsRepository;

    public function __construct(JobInterface $jobRepository, AnalyticsInterface $analyticsRepository)
    {
        $this->jobRepository = $jobRepository;
        $this->analyticsRepository = $analyticsRepository;
    }

    public function index(JobTable $table)
    {
        page_title()->setTitle(trans('plugins/job-board::job.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/job-board::job.create'));

        return $formBuilder->create(JobForm::class)->renderForm();
    }

    public function store(JobRequest $request, BaseHttpResponse $response, StoreTagService $storeTagService)
    {
        $request->merge([
            'expire_date' => now()->addDays(JobBoardHelper::jobExpiredDays()),
            'author_type' => Account::class,
        ]);

        if (! $request->has('employer_colleagues')) {
            $request->merge(['employer_colleagues' => []]);
        }

        $job = $this->jobRepository->getModel();
        $job = $job->fill($request->input());
        $job->moderation_status = $request->input('moderation_status');
        $job->never_expired = $request->input('never_expired');
        $job->save();

        $job->skills()->sync($request->input('skills', []));
        $job->jobTypes()->sync($request->input('jobTypes', []));
        $job->categories()->sync($request->input('categories', []));

        event(new CreatedContentEvent(JOB_MODULE_SCREEN_NAME, $request, $job));

        if ($job->moderation_status == ModerationStatusEnum::APPROVED) {
            event(new JobPublishedEvent($job));
        }

        $storeTagService->execute($request, $job);

        return $response
            ->setPreviousUrl(route('jobs.index'))
            ->setNextUrl(route('jobs.edit', $job->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(int $id, FormBuilder $formBuilder, Request $request)
    {
        $job = $this->jobRepository->findOrFail($id, ['skills']);

        event(new BeforeEditContentEvent($request, $job));

        page_title()->setTitle(trans('plugins/job-board::job.edit') . ' "' . $job->name . '"');

        return $formBuilder->create(JobForm::class, ['model' => $job])->renderForm();
    }

    public function update(int $id, JobRequest $request, BaseHttpResponse $response, StoreTagService $storeTagService)
    {
        $job = $this->jobRepository->findOrFail($id);

        if (! $request->has('employer_colleagues')) {
            $request->merge(['employer_colleagues' => []]);
        }

        $moderationStatus = $job->moderation_status;

        $job->fill($request->except(['expire_date']));
        $job->moderation_status = $request->input('moderation_status');
        $job->never_expired = $request->input('never_expired');

        $this->jobRepository->createOrUpdate($job);

        $job->skills()->sync($request->input('skills', []));
        $job->jobTypes()->sync($request->input('jobTypes', []));
        $job->categories()->sync($request->input('categories', []));

        event(new UpdatedContentEvent(JOB_MODULE_SCREEN_NAME, $request, $job));

        if ($moderationStatus != ModerationStatusEnum::APPROVED && $request->input(
            'moderation_status'
        ) == ModerationStatusEnum::APPROVED) {
            event(new JobPublishedEvent($job));
        }

        $storeTagService->execute($request, $job);

        return $response
            ->setPreviousUrl(route('jobs.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $job = $this->jobRepository->findOrFail($id);

            $this->jobRepository->delete($job);

            event(new DeletedContentEvent(JOB_MODULE_SCREEN_NAME, $request, $job));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $job = $this->jobRepository->findOrFail($id);
            $this->jobRepository->delete($job);
            event(new DeletedContentEvent(JOB_MODULE_SCREEN_NAME, $request, $job));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }

    public function analytics(int $id)
    {
        $job = $this->jobRepository->findOrFail($id);
        $job->loadCount([
            'savedJobs',
            'applicants',
        ]);
        Assets::addScripts(['counterup', 'equal-height'])
            ->addStylesDirectly('vendor/core/core/dashboard/css/dashboard.css');

        $numberSaved = $job->saved_jobs_count;
        $applicants = $job->applicants_count;
        $viewsToday = $this->analyticsRepository->getTodayViews($job->id);
        $referrers = $this->analyticsRepository->getReferrers($job->id);
        $countries = $this->analyticsRepository->getCountriesViews($job->id);

        page_title()->setTitle(__('Analytics for job ":name"', ['name' => $job->name]));

        $data = compact('job', 'viewsToday', 'numberSaved', 'applicants', 'referrers', 'countries');

        return view('plugins/job-board::analytics', $data);
    }

    public function expireJobs(ExpireJobsRequest $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');

        if (! $ids || ! is_array($ids)) {
            return $response;
        }

        $this->jobRepository->update(
            [
                ['id', 'IN', $ids],
            ],
            [
                'never_expired' => false,
                'expire_date' => now(),
            ]
        );

        return $response;
    }
}
