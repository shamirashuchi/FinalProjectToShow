<?php

namespace Botble\JobBoard\Models;

use Botble\Base\Models\BaseModel;
use Botble\Base\Supports\Avatar;
use Botble\JobBoard\Enums\AccountTypeEnum;
use Botble\JobBoard\Notifications\ConfirmEmailNotification;
use Botble\JobBoard\Notifications\ResetPasswordNotification;
use Botble\Media\Models\MediaFile;
use Exception;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use JobBoardHelper;
use Laravel\Sanctum\HasApiTokens;
use RvMedia;

class Account extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use MustVerifyEmail;
    use HasApiTokens;
    use Notifiable;

    protected $table = 'jb_accounts';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'avatar_id',
        'dob',
        'phone',
        'description',
        'gender',
        'package_id',
        'type',
        'credits',
        'resume',
        'address',
        'bio',
        'is_public_profile',
        'available_for_hiring',
        'country_id',
        'state_id',
        'city_id',
        'cover_letter',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'type' => AccountTypeEnum::class,
        'dob' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new ConfirmEmailNotification());
    }

    public function avatar(): BelongsTo
    {
        return $this->belongsTo(MediaFile::class)->withDefault();
    }

    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => ucfirst($value),
        );
    }

    protected function lastName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => ucfirst($value),
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->first_name . ' ' . $this->last_name,
        );
    }

    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->avatar->url) {
                    return RvMedia::url($this->avatar->url);
                }

                try {
                    return (new Avatar())->create($this->name)->toBase64();
                } catch (Exception) {
                    return RvMedia::getDefaultImage();
                }
            },
        );
    }

    protected function avatarThumbUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->avatar->url) {
                    return RvMedia::getImageUrl($this->avatar->url, 'thumb');
                }

                try {
                    return (new Avatar())->create($this->name)->toBase64();
                } catch (Exception) {
                    return RvMedia::getDefaultImage();
                }
            },
        );
    }

    protected function credits(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (! JobBoardHelper::isEnabledCreditsSystem()) {
                    return 0;
                }

                return $value ?: 0;
            }
        );
    }

    protected function resumeUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->resume ? RvMedia::url($this->resume) : ''
        );
    }

    protected function resumeName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->resume ? basename($this->resume_url) : ''
        );
    }

    public function canPost(): bool
    {
        return $this->credits > 0 || ! JobBoardHelper::isEnabledCreditsSystem();
    }

    public function isEmployer(): bool
    {
        return $this->type == AccountTypeEnum::EMPLOYER;
    }

    public function isJobSeeker(): bool
    {
        return $this->type == AccountTypeEnum::JOB_SEEKER;
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'jb_companies_accounts', 'account_id', 'company_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'account_id');
    }

    public function educations(): HasMany
    {
        return $this->hasMany(AccountEducation::class, 'account_id');
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(AccountExperience::class, 'account_id');
    }

    public function jobs(): MorphMany
    {
        return $this->morphMany(Job::class, 'author');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'account_id');
    }

    public function applicants(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'account_id')
            ->whereIn('job_id', $this->jobs()->pluck('id')->all());
    }

    public function savedJobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'jb_saved_jobs', 'account_id', 'job_id');
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'jb_account_packages', 'account_id', 'package_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function completedCompanyProfile(): bool
    {
        foreach ($this->companies()->get() as $company) {
            if ($company->completedProfile()) {
                return true;
            }
        }

        return false;
    }

    public function canReviewCompany(): bool
    {
        return $this->isJobSeeker();
    }

    public function hasReviewedCompany(Company $company): bool
    {
        return $this->reviews()->where('company_id', $company->id)->exists();
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Account $account) {
            $account->companies()->detach();
            $account->transactions()->delete();
            $account->applications()->delete();
            $account->reviews()->delete();
            $account->savedJobs()->detach();
            $account->packages()->detach();
        });
    }
}
