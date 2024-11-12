<?php

namespace Botble\JobBoard\Models;

use Botble\Base\Models\BaseModel;
use Html;

class AccountActivityLog extends BaseModel
{
    protected $table = 'jb_account_activity_logs';

    protected $fillable = [
        'action',
        'user_agent',
        'reference_url',
        'reference_name',
        'ip_address',
        'account_id',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function (AccountActivityLog $model) {
            $model->user_agent = $model->user_agent ?: request()->userAgent();
            $model->ip_address = $model->ip_address ?: request()->ip();
            $model->account_id = $model->account_id ?: auth('account')->id();
            $model->reference_url = str_replace(route('public.index'), '', $model->reference_url);
        });
    }

    public function getDescription(bool $withTime = true): string
    {
        $name = $this->reference_name;
        if ($name && $this->reference_url) {
            $name = Html::link($this->reference_url, $name, ['style' => 'color: #92aa40']);
        }

        $description = trans('plugins/job-board::dashboard.actions.' . $this->action, ['name' => $name]);

        if ($withTime) {
            $time = Html::tag('span', $this->created_at->diffForHumans(), ['class' => 'small italic']);
            $description .= ' - ' . $time;
        }

        return $description;
    }
}
