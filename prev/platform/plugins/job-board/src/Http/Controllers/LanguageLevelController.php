<?php

namespace Botble\JobBoard\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\JobBoard\Forms\LanguageLevelForm;
use Botble\JobBoard\Http\Requests\LanguageLevelRequest;
use Botble\JobBoard\Repositories\Interfaces\LanguageLevelInterface;
use Botble\JobBoard\Tables\LanguageLevelTable;
use Exception;
use Illuminate\Http\Request;

class LanguageLevelController extends BaseController
{
    protected LanguageLevelInterface $languageLevelRepository;

    public function __construct(LanguageLevelInterface $languageLevelRepository)
    {
        $this->languageLevelRepository = $languageLevelRepository;
    }

    public function index(LanguageLevelTable $table)
    {
        page_title()->setTitle(trans('plugins/job-board::language-level.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/job-board::language-level.create'));

        return $formBuilder->create(LanguageLevelForm::class)->renderForm();
    }

    public function store(LanguageLevelRequest $request, BaseHttpResponse $response)
    {
        if ($request->input('is_default')) {
            $this->languageLevelRepository->getModel()->where('id', '>', 0)->update(['is_default' => 0]);
        }

        $languageLevel = $this->languageLevelRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(LANGUAGE_LEVEL_MODULE_SCREEN_NAME, $request, $languageLevel));

        return $response
            ->setPreviousUrl(route('language-levels.index'))
            ->setNextUrl(route('language-levels.edit', $languageLevel->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(int $id, FormBuilder $formBuilder, Request $request)
    {
        $languageLevel = $this->languageLevelRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $languageLevel));

        page_title()->setTitle(trans('plugins/job-board::language-level.edit') . ' "' . $languageLevel->name . '"');

        return $formBuilder->create(LanguageLevelForm::class, ['model' => $languageLevel])->renderForm();
    }

    public function update(int $id, LanguageLevelRequest $request, BaseHttpResponse $response)
    {
        $languageLevel = $this->languageLevelRepository->findOrFail($id);

        if ($request->input('is_default')) {
            $this->languageLevelRepository->getModel()->where('id', '!=', $id)->update(['is_default' => 0]);
        }

        $languageLevel->fill($request->input());

        $this->languageLevelRepository->createOrUpdate($languageLevel);

        event(new UpdatedContentEvent(LANGUAGE_LEVEL_MODULE_SCREEN_NAME, $request, $languageLevel));

        return $response
            ->setPreviousUrl(route('language-levels.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $languageLevel = $this->languageLevelRepository->findOrFail($id);

            $this->languageLevelRepository->delete($languageLevel);

            event(new DeletedContentEvent(LANGUAGE_LEVEL_MODULE_SCREEN_NAME, $request, $languageLevel));

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
            $languageLevel = $this->languageLevelRepository->findOrFail($id);
            $this->languageLevelRepository->delete($languageLevel);
            event(new DeletedContentEvent(LANGUAGE_LEVEL_MODULE_SCREEN_NAME, $request, $languageLevel));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
