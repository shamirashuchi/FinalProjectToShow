<?php

namespace Botble\JobBoard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Add 'start_time' and 'end_time' to the fillable array
    protected $fillable = [
        'start_time',
        'end_time',
        'day',
        'date',
        'consultant_id'
        // Add any other fields you want to mass-assign
    ];
}

