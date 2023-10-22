<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductAdditional extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_product_id',
        'product_additional_id',
        'value',
        'amount',
    ];

    public function additional()
    {
        return $this->belongsTo(ProductAdditional::class, 'product_additional_id');
    }
}
