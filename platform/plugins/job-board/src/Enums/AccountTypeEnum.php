<?php

namespace Botble\JobBoard\Enums;

use Botble\Base\Supports\Enum;
use Html;
use Illuminate\Support\HtmlString;

/**
 * @method static AccountTypeEnum JOB_SEEKER()
 * @method static AccountTypeEnum EMPLOYER()
 */
class AccountTypeEnum extends Enum
{
    public const JOB_SEEKER = 'job-seeker';
    public const EMPLOYER = 'employer';
    public const CONSULTANT = 'consultant';
    public const SUPER_ADMIN = 'super-admin';

    public static $langPath = 'plugins/job-board::account.types';

    public function toHtml(): HtmlString|string
    {
        return match ($this->value) {
            self::JOB_SEEKER => Html::tag('span', self::JOB_SEEKER()->label(), ['class' => 'label-info status-label'])
                ->toHtml(),
            self::EMPLOYER => Html::tag('span', self::EMPLOYER()->label(), ['class' => 'label-success status-label'])
                ->toHtml(),
            self::CONSULTANT => Html::tag('span', self::CONSULTANT()->label(), ['class' => 'label-success status-label'])
                ->toHtml(),
            self::SUPER_ADMIN => Html::tag('span', self::SUPER_ADMIN()->label(), ['class' => 'label-warning status-label']) // Add styling for SUPER_ADMIN
                ->toHtml(),
            
            default => parent::toHtml(),
        };
    }
}
