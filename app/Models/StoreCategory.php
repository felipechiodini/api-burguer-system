<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_store_id',
        'name',
        'order'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('store', function($query) {
            $query->where('user_store_id', app('currentTenant')->id);
        });
    }
}
