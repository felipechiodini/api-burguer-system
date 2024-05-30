<?php

namespace App\Models;

use App\Events\NotificationCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    protected $dispatchesEvents = [
        'created' => NotificationCreated::class
    ];

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'read',
    ];

    protected $casts = [
        'read' => 'boolean'
    ];

}
