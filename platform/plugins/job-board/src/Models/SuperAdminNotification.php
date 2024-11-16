<?php

namespace Botble\JobBoard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperAdminNotification extends Model
{
    use HasFactory;

  
    protected $table = 'superadminnotifications';

  
    protected $fillable = [
        'type',
        'read_at',
        'notifiable_id',  // Correct field
        'notifiable_type',  // Correct field
        'updated_at',
        'created_at'
    ];

    public $incrementing = false;
    
    public $timestamps = true;
}
