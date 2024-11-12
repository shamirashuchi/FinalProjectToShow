<?php

namespace Botble\JobBoard\Models;

use Botble\Base\Models\BaseModel;

class AccountExperience extends BaseModel
{
    protected $table = 'jb_account_experiences';

    protected $fillable = [
        'company',
        'account_id',
        'position',
        'description',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'date',
        'ended_at' => 'date',
    ];
}
