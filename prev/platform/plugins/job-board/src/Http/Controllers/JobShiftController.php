<?php

namespace Botble\JobBoard\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\JobBoard\Forms\JobShiftForm;
use Botble\JobBoard\Http\Requests\JobShiftRequest;
use Botble\JobBoard\Repositories\Interfaces\JobShiftInterface;
use Botble\JobBoard\Tables\JobShiftTable;
use Exception;
use Illuminate\Http\Request;

class JobShiftController extends BaseController
{
    protected JobShiftInterface $jobShiftRepository;

    public function __construct(JobShiftInterface $jobShiftRepository)
    {
        $this->jobShiftRepository = $jobShiftRepository;
    }

    public function index(JobShiftTable $table)
    {
        page_title()->setTitle(trans('plugins/job-board::job-shift.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/job-board::job-shift.create'));

        return $formBuilder->create(JobShiftForm::class)->renderForm();
    }

    public function store(JobShiftRequest $request, BaseHttpResponse $response)
    {
        if ($request->input('is_default')) {
            $this->jobShiftRepository->getModel()->where('id', '>', 0)->update(['is_default' => 0]);
        }

        $jobShift = $this->jobShiftRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(JOB_SHIFT_MODULE_SCREEN_NAME, $request, $jobShift));

        return $response
            ->setPreviousUrl(route('job-shifts.index'))
            ->setNextUrl(route('job-shifts.edit', $jobShift->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(int $id, FormBuilder $formBuilder, Request $request)
    {
        $jobShift = $this->jobShiftRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $jobShift));

        page_title()->setTitle(trans('plugins/job-board::job-shift.edit') . ' "' . $jobShift->name . '"');

        return $formBuilder->create(JobShiftForm::class, ['model' => $jobShift])->renderForm();
    }

    public function update(int $id, JobShiftRequest $request, BaseHttpResponse $response)
    {
        $jobShift = $this->jobShiftRepository->findOrFail($id);

        if ($request->input('is_default')) {
            $this->jobShiftRepository->getModel()->where('id', '!=', $id)->update(['is_default' => 0]);
        }

        $jobShift->fill($request->input());

        $this->jobShiftRepository->createOrUpdate($jobShift);

        event(new UpdatedContentEvent(JOB_SHIFT_MODULE_SCREEN_NAME, $request, $jobShift));

        return $response
            ->setPreviousUrl(route('job-shifts.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $jobShift = $this->jobShiftRepository->findOrFail($id);

            $this->jobShiftRepository->delete($jobShift);

            event(new DeletedContentEvent(JOB_SHIFT_MODULE_SCREEN_NAME, $request, $jobShift));

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
            $jobShift = $this->jobShiftRepository->findOrFail($id);
            $this->jobShiftRepository->delete($jobShift);
            event(new DeletedContentEvent(JOB_SHIFT_MODULE_SCREEN_NAME, $request, $jobShift));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
