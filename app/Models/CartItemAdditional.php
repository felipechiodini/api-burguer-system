<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItemAdditional extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_item_id',
        'product_additional_id',
        'amount'
    ];

    public function additional()
    {
        return $this->belongsTo(ProductAdditional::class, 'product_additional_id');
    }
}
