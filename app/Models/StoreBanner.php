<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'name',
        'src',
        'order',
    ];

    public function store()
    {
        return $this->belongsTo(UserStore::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('store', function($query) {
            $query->where((new static())->getTable() . '.store_id', app('currentTenant')->id);
        });
    }

}
