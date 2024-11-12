<?php

namespace Botble\Team\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class Team extends BaseModel
{
    protected $table = 'teams';

    protected $fillable = [
        'name',
        'title',
        'photo',
        'location',
        'socials',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}
