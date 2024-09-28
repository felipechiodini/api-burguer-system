<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'value',
        'amount',
        'observation',
    ];

    public function product()
    {
        return $this->belongsTo(StoreProduct::class, 'product_id');
    }

    public function additionals()
    {
        return $this->hasMany(OrderProductAdditional::class);
    }

    public function replacements()
    {
        return $this->hasMany(OrderProductReplacement::class);
    }
}
