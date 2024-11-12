<?php

namespace Botble\JobBoard\Http\Controllers;

use BaseHelper;
use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Traits\HasDeleteManyItemsTrait;
use Botble\Media\Repositories\Interfaces\MediaFileInterface;
use Botble\JobBoard\Enums\AccountTypeEnum;
use Botble\JobBoard\Forms\AccountForm;
use Botble\JobBoard\Http\Requests\AccountCreateRequest;
use Botble\JobBoard\Http\Requests\AccountEditRequest;
use Botble\JobBoard\Http\Resources\AccountResource;
use Botble\JobBoard\Repositories\Interfaces\AccountInterface;
use Botble\JobBoard\Tables\AccountTable;
use DB;
use Exception;
use Illuminate\Http\Request;

class AccountController extends BaseController
{
    use HasDeleteManyItemsTrait;

    protected AccountInterface $accountRepository;

    public function __construct(AccountInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function index(AccountTable $dataTable)
    {
        page_title()->setTitle(trans('plugins/job-board::account.name'));

        return $dataTable->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/job-board::account.create'));

        return $formBuilder
            ->create(AccountForm::class)
            ->remove('is_change_password')
            ->renderForm();
    }

    public function store(AccountCreateRequest $request, BaseHttpResponse $response)
    {
        $request->merge(['password' => bcrypt($request->input('password'))]);

        $account = $this->accountRepository->getModel();
        $account->fill($request->input());
        $account->is_featured = $request->input('is_featured', false);

        if ($request->input('avatar_image')) {
            $image = app(MediaFileInterface::class)->getFirstBy(['url' => $request->input('avatar_image')]);
            if ($image) {
                $account->avatar_id = $image->id;
            }
        }

        $account->save();

        event(new CreatedContentEvent(ACCOUNT_MODULE_SCREEN_NAME, $request, $account));

        return $response
            ->setPreviousUrl(route('accounts.index'))
            ->setNextUrl(route('accounts.edit', $account->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(int $id, Request $request, FormBuilder $formBuilder)
    {
        $account = $this->accountRepository->findOrFail($id);
        page_title()->setTitle(trans('plugins/job-board::account.edit'));

        $account->password = null;

        event(new BeforeEditContentEvent($request, $account));

        return $formBuilder
            ->create(AccountForm::class, ['model' => $account])
            ->renderForm();
    }

    public function update(int $id, AccountEditRequest $request, BaseHttpResponse $response)
    {
        if ($request->input('is_change_password') == 1) {
            $request->merge(['password' => bcrypt($request->input('password'))]);
            $data = $request->input();
        } else {
            $data = $request->except('password');
        }

        $account = $this->accountRepository->findOrFail($id);
        $account->fill($data);
        $account->is_featured = $request->input('is_featured', false);

        if ($request->input('avatar_image')) {
            $image = app(MediaFileInterface::class)->getFirstBy(['url' => $request->input('avatar_image')]);
            if ($image) {
                $account->avatar_id = $image->id;
            }
        }

        $account->save();

        event(new UpdatedContentEvent(ACCOUNT_MODULE_SCREEN_NAME, $request, $account));

        return $response
            ->setPreviousUrl(route('accounts.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $account = $this->accountRepository->findOrFail($id);
            $this->accountRepository->delete($account);
            event(new DeletedContentEvent(ACCOUNT_MODULE_SCREEN_NAME, $request, $account));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->accountRepository, ACCOUNT_MODULE_SCREEN_NAME);
    }

    public function getList(Request $request, BaseHttpResponse $response)
    {
        $keyword = BaseHelper::stringify($request->input('q'));

        if (! $keyword) {
            return $response->setData([]);
        }

        $data = $this->accountRepository->getModel()
            ->where('jb_accounts.type', AccountTypeEnum::EMPLOYER)
            ->where('jb_accounts.first_name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('jb_accounts.last_name', 'LIKE', '%' . $keyword . '%')
            ->select(['jb_accounts.id', 'jb_accounts.first_name', 'jb_accounts.last_name', 'jb_accounts.email'])
            ->take(10)
            ->get();

        return $response->setData(AccountResource::collection($data));
    }

    public function getAllEmployers()
    {
        return $this->accountRepository
            ->getModel()
            ->select(DB::raw('CONCAT(jb_accounts.first_name, " ", jb_accounts.last_name) as name'))
            ->where('type', AccountTypeEnum::EMPLOYER)
            ->pluck('name')
            ->all();
    }
}
