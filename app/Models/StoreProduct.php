<?php

namespace App\Models;

use App\Cart\ActiveProduct;
use App\Utils\Helper;
use DB;
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

        if ($modelPrice === null) return null;

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
        (new ActiveProduct($this))
            ->active();
    }

}
