<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_store_id',
        'week_day',
        'open_at',
        'close_at',
        'closed'
    ];

    protected $casts = [
        'closed' => 'boolean'
    ];

}
