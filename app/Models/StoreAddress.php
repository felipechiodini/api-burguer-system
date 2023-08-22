<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_store_id',
        'cep',
        'street',
        'number',
        'district',
        'city',
        'state',
        'latitude',
        'longitude'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('store', function($query) {
            $query->where('user_store_id', request()->header(UserStore::HEADER_KEY));
        });
    }

}
