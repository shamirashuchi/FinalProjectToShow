<?php

namespace Botble\JobBoard\Models;

use Botble\JobBoard\Enums\JobApplicationStatusEnum;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Eloquent
{
    protected $table = 'jb_applications';

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'resume',
        'cover_letter',
        'message',
        'job_id',
        'account_id',
        'status',
    ];

    protected $casts = [
        'status' => JobApplicationStatusEnum::class,
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id')->withDefault();
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id')->withDefault();
    }

    public function getFullNameAttribute(): string
    {
        if ($this->account->name) {
            return $this->account->name;
        }

        return $this->first_name . ' ' . $this->last_name;
    }

    public function getJobUrlAttribute(): string
    {
        $url = '';
        if (! $this->job->is_expired) {
            $url = $this->job->url;
        }

        return $url;
    }
}
