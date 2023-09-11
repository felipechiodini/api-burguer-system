<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreConfiguration extends Model
{

    protected $table = 'store_configurations';

    protected $fillable = [
        'user_store_id',
        'warning',
        'allow_withdrawal',
        'withdrawal_time',
        'delivery_time',
        'minimum_order_value',
        'delivery_price_per_km',
        'force_store_open',
        'force_store_close'
    ];

    protected $casts = [
        'allow_withdrawal' => 'boolean',
        'force_store_open' => 'boolean',
        'force_store_close' => 'boolean'
    ];

}
