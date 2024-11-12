<?php

namespace Botble\JobBoard\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\JobBoard\Enums\JobStatusEnum;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends BaseModel
{
    protected $table = 'jb_categories';

    protected $fillable = [
        'name',
        'description',
        'order',
        'is_default',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(
            Job::class,
            'jb_jobs_categories',
            'category_id',
            'job_id'
        );
    }

    public function activeJobs(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Job::class,
                'jb_jobs_categories',
                'category_id',
                'job_id'
            )
            ->where('jb_jobs.status', JobStatusEnum::PUBLISHED)
            ->notExpired();
    }
}
