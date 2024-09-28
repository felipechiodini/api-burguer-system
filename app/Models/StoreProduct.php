<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'category_id',
        'active',
        'name',
        'image',
        'price',
        'price_from',
        'description',
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function promotion()
    {
        return $this->hasOne(ProductPromotion::class);
    }

    public function photos()
    {
        return $this->hasMany(ProductPhoto::class);
    }

    public function configuration()
    {
        return $this->hasOne(ProductConfiguration::class);
    }

    public function additionals()
    {
        return $this->hasMany(ProductAdditional::class);
    }

    public function replacements()
    {
        return $this->hasMany(ProductReplacement::class);
    }

    public function followup()
    {
        return $this->hasMany(ProductReplacement::class);
    }

    public function category()
    {
        return $this->belongsTo(StoreCategory::class, 'category_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('store', function($query) {
            $query->where((new static())->getTable() . '.store_id', app('currentTenant')->id);
        });
    }
}
