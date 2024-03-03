<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorePayment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_store_id',
        'active',
        'type'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('store', function($query) {
            $query->where((new static())->getTable() . '.user_store_id', app('currentTenant')->id);
        });
    }

}
