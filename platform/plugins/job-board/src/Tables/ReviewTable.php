<?php

namespace Botble\JobBoard\Tables;

use BaseHelper;
use Botble\JobBoard\Repositories\Interfaces\ReviewInterface;
use Botble\Table\Abstracts\TableAbstract;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class ReviewTable extends TableAbstract
{
    protected $hasActions = true;

    protected $hasFilter = true;

    public function __construct(DataTables $table, UrlGenerator $urlGenerator, ReviewInterface $repository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $repository;
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('company_id', function ($item) {
                return Html::link(route('companies.edit', $item->company->id), BaseHelper::clean($item->company->name))->toHtml();
            })
            ->editColumn('account_id', function ($item) {
                return Html::link(route('accounts.edit', $item->account->id), BaseHelper::clean($item->account->name))->toHtml();
            })
            ->editColumn('star', function ($item) {
                return view('plugins/job-board::reviews.partials.rating', ['star' => $item->star])->render();
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('status', function ($item) {
                return BaseHelper::clean($item->status->toHtml());
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->addColumn('operations', function ($item) {
                return view('plugins/job-board::reviews.partials.actions', compact('item'))->render();
            });

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $query = $this->repository->getModel()
            ->select([
                'id',
                'star',
                'review',
                'company_id',
                'account_id',
                'status',
                'created_at',
            ])
            ->with(['account', 'company']);

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            'id' => [
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
                'class' => 'text-start',
            ],
            'company_id' => [
                'title' => trans('plugins/job-board::review.company'),
                'class' => 'text-start',
            ],
            'account_id' => [
                'title' => trans('plugins/job-board::review.user'),
                'class' => 'text-start',
            ],
            'star' => [
                'title' => trans('plugins/job-board::review.star'),
                'class' => 'text-center',
            ],
            'review' => [
                'title' => trans('plugins/job-board::review.review'),
                'class' => 'text-start',
            ],
            'status' => [
                'title' => trans('plugins/job-board::review.status'),
                'class' => 'text-center',
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'width' => '70px',
                'class' => 'text-start',
            ],
        ];
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('reviews.deletes'), 'reviews.destroy', parent::bulkActions());
    }
}
