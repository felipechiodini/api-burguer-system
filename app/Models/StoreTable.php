<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_store_id',
        'identification'
    ];

    public function getIdentification()
    {
        return 'dwadas';
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('store', function($query) {
            $query->where((new static())->getTable() . '.user_store_id', app('currentTenant')->id);
        });
    }

}
