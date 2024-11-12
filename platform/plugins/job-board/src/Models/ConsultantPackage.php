<?php

namespace Botble\JobBoard\Models;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ConsultantPackage extends BaseModel
{
    protected $table = 'jb_consultant_packages';

    protected $fillable = [
        'name',
        'consultant_id',
        'credits',
        'description',
        'currency_id',
        'order',
        'total_hours',
        'calendly_event_uri',
        'is_booked',
        'date',
        'start_time',
        'end_time',
        'region',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function consultant(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'consultant_id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class)->withDefault();
    }

    public function accounts(): BelongsToMany
    {
        return $this->belongsToMany(Account::class, 'jb_account_packages', 'package_id', 'account_id');
    }

    public function getTotalPriceAttribute(): float
    {
        return $this->price - ($this->price * $this->percent_save / 100);
    }

    public function getPriceTextAttribute(): string
    {
        return format_price($this->price, $this->currency);
    }

    public function getPricePerJobTextAttribute(): string
    {
        return __(':price / per job', ['price' => format_price($this->price / $this->number_of_listings, $this->currency)]);
    }

    public function getNumberJobsFreeAttribute(): string
    {
        return __('Free :number job(s)', ['number' => $this->number_of_listings]);
    }

    public function getPriceTextWithSaleOffAttribute(): string
    {
        return __(':price Total :percentage_sale', ['price' => $this->price_text, 'percentage_sale' => $this->percent_save_text]);
    }

    public function getPercentSaveTextAttribute(): string
    {
        $text = '';

        if ($this->percent_save) {
            $text .= ' ' . __('(save :percentage %)', ['percentage' => $this->percent_save]);
        }

        return $text;
    }

    public function isPurchased(): bool
    {
        return $this->account_limit && $this->accounts_count >= $this->account_limit;
    }
}
