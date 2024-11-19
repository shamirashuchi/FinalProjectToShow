<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageSystem extends Model
{
    use HasFactory;
    // Define fillable columns to allow mass assignment
    protected $fillable = [
        'channel_name',
        'sender_id',
        'receiver_id',
        'superadmin_id',
        'message',
        'event_id',
        'schedule_start_time',
        'schedule_end_time',
        'flag',
    ];
}
