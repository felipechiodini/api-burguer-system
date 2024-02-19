<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreConfiguration extends Model
{

    protected $fillable = [
        'user_store_id',
        'warning',
        'minimum_order_value'
    ];

}
