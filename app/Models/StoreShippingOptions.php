<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreShippingOptions extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_store_id',
        'name',
        'value'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('store', function($query) {
    //         $query->where((new static())->getTable() . '.user_store_id', app('currentTenant')->id);
    //     });
    // }
}
