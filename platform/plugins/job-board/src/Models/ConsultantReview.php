<?php

namespace Botble\JobBoard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConsultantReview extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $fillable = ['reviewer_id', 'reviewed_user_id', 'note', 'rating'];

    /**
     * Get the reviewer that owns the ConsultantReview
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'reviewer_id');
    }

    /**
     * Get the reviewed that owns the ConsultantReview
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reviewed(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'reviewed_user_id');
    }
}
