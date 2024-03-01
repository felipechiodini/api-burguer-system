<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreDeliveryType extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_store_id',
        'delivery_type',
        'minutes'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
