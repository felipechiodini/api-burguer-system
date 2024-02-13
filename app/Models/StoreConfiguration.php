<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreConfiguration extends Model
{
    protected $table = 'store_configurations';

    protected $fillable = [
        'user_store_id',
        'warning',
        'minimum_order_value',
        'store_open',
    ];

    protected $casts = [
        'store_open' => 'boolean'
    ];

}
