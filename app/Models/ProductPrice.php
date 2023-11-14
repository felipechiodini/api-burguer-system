<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_product_id',
        'value',
        'start_date',
        'end_date',
    ];

    protected $dates = [
        'start_date',
        'end_date'
    ];

    public function promotions()
    {
        return $this->hasMany(ProductPricePromotion::class);
    }

}
