<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreDelivery extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_store_id',
        'active',
        'type',
        'minutes'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('store', function($query) {
            $query->where((new static())->getTable() . '.user_store_id', app('currentTenant')->id);
        });
    }

}
