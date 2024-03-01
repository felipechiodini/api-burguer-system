<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDelivery extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'store_order_id',
        'type',
        'target_type',
        'target_id',
    ];

}
