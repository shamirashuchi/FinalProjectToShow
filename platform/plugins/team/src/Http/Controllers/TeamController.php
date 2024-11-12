<?php

namespace Botble\Team\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Team\Forms\TeamForm;
use Botble\Team\Http\Requests\TeamRequest;
use Botble\Team\Repositories\Interfaces\TeamInterface;
use Botble\Team\Tables\TeamTable;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeamController extends BaseController
{
    /**
     * @var TeamInterface
     */
    protected $teamRepository;

    /**
     * @param TeamInterface $teamRepository
     */
    public function __construct(TeamInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    /**
     * @param TeamTable $table
     * @return Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse|View
     */
    public function index(TeamTable $table)
    {
        page_title()->setTitle(trans('plugins/team::team.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/team::team.create'));

        return $formBuilder->create(TeamForm::class)->renderForm();
    }

    /**
     * @param TeamRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(TeamRequest $request, BaseHttpResponse $response)
    {
        $data = $request->input();
        $data['socials'] = json_encode($request->input('socials'));

        $team = $this->teamRepository->createOrUpdate($data);

        event(new CreatedContentEvent(TEAM_MODULE_SCREEN_NAME, $request, $team));

        return $response
            ->setPreviousUrl(route('team.index'))
            ->setNextUrl(route('team.edit', $team->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $team = $this->teamRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $team));

        page_title()->setTitle(trans('plugins/team::team.edit') . ' "' . $team->name . '"');

        return $formBuilder->create(TeamForm::class, ['model' => $team])->renderForm();
    }

    /**
     * @param int $id
     * @param TeamRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, TeamRequest $request, BaseHttpResponse $response)
    {
        $team = $this->teamRepository->findOrFail($id);

        $team->fill($request->input());

        $team = $this->teamRepository->createOrUpdate($team);

        event(new UpdatedContentEvent(TEAM_MODULE_SCREEN_NAME, $request, $team));

        return $response
            ->setPreviousUrl(route('team.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $team = $this->teamRepository->findOrFail($id);

            $this->teamRepository->delete($team);

            event(new DeletedContentEvent(TEAM_MODULE_SCREEN_NAME, $request, $team));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $team = $this->teamRepository->findOrFail($id);
            $this->teamRepository->delete($team);
            event(new DeletedContentEvent(TEAM_MODULE_SCREEN_NAME, $request, $team));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
