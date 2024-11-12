<?php

namespace Botble\JobBoard\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\JobBoard\Forms\DegreeTypeForm;
use Botble\JobBoard\Http\Requests\DegreeTypeRequest;
use Botble\JobBoard\Repositories\Interfaces\DegreeTypeInterface;
use Botble\JobBoard\Tables\DegreeTypeTable;
use Exception;
use Illuminate\Http\Request;

class DegreeTypeController extends BaseController
{
    protected DegreeTypeInterface $degreeTypeRepository;

    public function __construct(DegreeTypeInterface $degreeTypeRepository)
    {
        $this->degreeTypeRepository = $degreeTypeRepository;
    }

    public function index(DegreeTypeTable $table)
    {
        page_title()->setTitle(trans('plugins/job-board::degree-type.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/job-board::degree-type.create'));

        return $formBuilder->create(DegreeTypeForm::class)->renderForm();
    }

    public function store(DegreeTypeRequest $request, BaseHttpResponse $response)
    {
        if ($request->input('is_default')) {
            $this->degreeTypeRepository->getModel()->where('id', '>', 0)->update(['is_default' => 0]);
        }

        $degreeType = $this->degreeTypeRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(DEGREE_TYPE_MODULE_SCREEN_NAME, $request, $degreeType));

        return $response
            ->setPreviousUrl(route('degree-types.index'))
            ->setNextUrl(route('degree-types.edit', $degreeType->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(int $id, FormBuilder $formBuilder, Request $request)
    {
        $degreeType = $this->degreeTypeRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $degreeType));

        page_title()->setTitle(trans('plugins/job-board::degree-type.edit') . ' "' . $degreeType->name . '"');

        return $formBuilder->create(DegreeTypeForm::class, ['model' => $degreeType])->renderForm();
    }

    public function update(int $id, DegreeTypeRequest $request, BaseHttpResponse $response)
    {
        $degreeType = $this->degreeTypeRepository->findOrFail($id);

        if ($request->input('is_default')) {
            $this->degreeTypeRepository->getModel()->where('id', '!=', $id)->update(['is_default' => 0]);
        }

        $degreeType->fill($request->input());

        $this->degreeTypeRepository->createOrUpdate($degreeType);

        event(new UpdatedContentEvent(DEGREE_TYPE_MODULE_SCREEN_NAME, $request, $degreeType));

        return $response
            ->setPreviousUrl(route('degree-types.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $degreeType = $this->degreeTypeRepository->findOrFail($id);

            $this->degreeTypeRepository->delete($degreeType);

            event(new DeletedContentEvent(DEGREE_TYPE_MODULE_SCREEN_NAME, $request, $degreeType));

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
            $degreeType = $this->degreeTypeRepository->findOrFail($id);
            $this->degreeTypeRepository->delete($degreeType);
            event(new DeletedContentEvent(DEGREE_TYPE_MODULE_SCREEN_NAME, $request, $degreeType));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
