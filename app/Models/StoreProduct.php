<?php

namespace App\Models;

use App\Utils\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_store_id',
        'store_category_id',
        'active',
        'name',
        'price_from',
        'price_to',
        'description'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

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
        return $this->belongsTo(StoreCategory::class, 'store_category_id');
    }

    public function getCurrentPrice()
    {
        $now = now();

        $modelPrice = $this->prices()
            ->where('start_date', '<', $now)
            ->where('end_date', '>', $now)
            ->first();

        $modelPromotion = $this->promotion()
            ->where('start_date', '<', $now)
            ->where('end_date', '>', $now)
            ->first();

        if ($modelPromotion) {
            return (object) [
                'current' => $modelPrice->value - Helper::calculatePercentDiscount($modelPrice->value, $modelPromotion->value),
                'previous' => $modelPrice->value
            ];
        }

        return (object) [
            'current' => $modelPrice->value,
            'previous' => null
        ];
    }

    public function active()
    {
        $errors = collect([]);

        if ($this->prices->count() < 0) {
            $errors->push('O produto precisa de ao menos um preço');
        }

        if ($this->product->photos()->count() === 0) {
            $errors->push('É necessário que o produto tenha uma foto');
        }

        if ($this->product->category() === null) {
            $errors->push('O produto não possue categoria');
        }

        if ($errors->count() > 0) {
            return $errors;
        }

        $this->update(['active' => true]);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('store', function($query) {
            $query->where((new static())->getTable() . '.user_store_id', app('currentTenant')->id);
        });
    }

}
