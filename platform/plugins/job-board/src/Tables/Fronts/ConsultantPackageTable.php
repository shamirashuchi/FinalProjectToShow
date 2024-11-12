<?php

namespace Botble\JobBoard\Tables\Fronts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use BaseHelper;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\JobBoard\Repositories\Interfaces\ConsultantPackageInterface;
use Botble\Table\Abstracts\TableAbstract;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use JobBoardHelper;
use Yajra\DataTables\Services\DataTable;

class ConsultantPackageTable extends DataTable
{
    // protected $hasActions = true;
    // protected $hasFilter = true;
    protected $hasCheckbox = false;
    // protected $hasOperations = false;


    public function __construct(DataTables $table, UrlGenerator $urlGenerator, ConsultantPackageInterface $packageRepository)
    {
        parent::__construct($table, $urlGenerator);
        $this->repository = $packageRepository;

        // if (Auth::user() && !Auth::user()->hasAnyPermission(['accounts.edit', 'accounts.destroy'])) {
        //     $this->hasOperations = false;
        //     $this->hasActions = false;
        // }
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                if (Auth::user() && !Auth::user()->hasPermission('accounts.edit')) {
                    return e($item->name);
                }
                return Html::link(route('accounts.edit', $item->id), e($item->name))->toHtml();
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn(
                'status',
                function ($item) {
                    return $item->status->toHtml();
                }
            )
            ->addColumn('operations', function ($item) {
                return view(JobBoardHelper::viewPath('dashboard.table.actions'), [
                    'edit' => 'public.account.companies.edit',
                    'delete' => 'public.account.companies.destroy',
                    'item' => $item,
                ])->render();
            });

        $response = $this->toJson($data);
        \Log::info($response);

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $query = $this->repository->getModel()->select([
            'id',
            'name',
            'created_at',
            'status',
        ]);

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'name' => [
                'name' => 'name',
                'title' => trans('core/base::tables.name'),
                'class' => 'text-start',
            ],
            'created_at' => [
                'name' => 'created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'status' => [
                'name' => 'status',
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('public.account.consultant-packages.create'));
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('public.account.consultant-packages.deletes'), 'public.account.consultant-packages.destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title' => trans('core/base::tables.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'status' => [
                'title' => trans('core/base::tables.status'),
                'type' => 'select',
                'choices' => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type' => 'datePicker',
            ],
        ];
    }
}
