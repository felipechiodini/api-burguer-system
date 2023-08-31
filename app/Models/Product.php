<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_store_id',
        'category_id',
        'active',
        'name',
        'description'
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function prices()
    {
        return $this->hasOne(ProductPrice::class);
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

    public function getCurrentPrice(): ?ProductPrice
    {
        // to do filter the current price
        return $this->prices()
            ->first();
    }
}
