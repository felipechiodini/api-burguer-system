<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPricePromotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_price_id',
        'value',
        'start_date',
        'end_date',
    ];

    protected $dates = [
        'start_date',
        'end_date'
    ];

}
