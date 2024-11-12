<?php

namespace Botble\JobBoard\Http\Controllers;

use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\JobBoard\Forms\JobApplicationForm;
use Botble\JobBoard\Http\Requests\EditJobApplicationRequest;
use Botble\JobBoard\Repositories\Interfaces\JobApplicationInterface;
use Botble\JobBoard\Tables\JobApplicationTable;
use Exception;
use Illuminate\Http\Request;

class JobApplicationController extends BaseController
{
    protected JobApplicationInterface $jobApplicationRepository;

    public function __construct(JobApplicationInterface $jobApplicationRepository)
    {
        $this->jobApplicationRepository = $jobApplicationRepository;
    }

    public function index(JobApplicationTable $table)
    {
        
        
        page_title()->setTitle(trans('plugins/job-board::job-application.name'));

        return $table->renderTable();
    }

    public function edit(int|string $id, FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/job-board::job-application.edit'));

        $jobApplication = $this->jobApplicationRepository->findOrFail($id);

        return $formBuilder->create(JobApplicationForm::class, ['model' => $jobApplication])->renderForm();
    }

    public function update(int|string $id, EditJobApplicationRequest $request, BaseHttpResponse $response)
    {
        $jobApplication = $this->jobApplicationRepository->findOrFail($id);

        $jobApplication->fill($request->input());

        $this->jobApplicationRepository->createOrUpdate($jobApplication);

        event(new UpdatedContentEvent(JOB_APPLICATION_MODULE_SCREEN_NAME, $request, $jobApplication));

        return $response
            ->setPreviousUrl(route('job-applications.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Request $request, int $id, BaseHttpResponse $response)
    {
        try {
            $jobApplication = $this->jobApplicationRepository->findById($id);
            $this->jobApplicationRepository->delete($jobApplication);
            event(new DeletedContentEvent(JOB_APPLICATION_MODULE_SCREEN_NAME, $request, $jobApplication));

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
            $jobApplication = $this->jobApplicationRepository->findOrFail($id);
            $this->jobApplicationRepository->delete($jobApplication);
            event(new DeletedContentEvent(JOB_APPLICATION_MODULE_SCREEN_NAME, $request, $jobApplication));
        }

        return $response
            ->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
