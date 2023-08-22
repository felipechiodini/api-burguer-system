<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Waiter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'store_id',
        'name'
    ];

    public function subOrders()
    {
        return $this->hasMany(SubOrder::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('store', function($query) {
            $query->where('user_store_id', request()->header(UserStore::HEADER_KEY));
        });
    }

}
