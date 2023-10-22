<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductReplacement extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_product_id',
        'product_replacement_id',
        'value',
    ];

    public function replacement()
    {
        return $this->belongsTo(ProductReplacement::class, 'product_replacement_id');
    }
}
