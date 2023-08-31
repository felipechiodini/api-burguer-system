<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'value',
        'amount',
        'observation'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function additionals()
    {
        return $this->hasMany(CartItemAdditional::class);
    }

    public function replacements()
    {
        return $this->hasMany(CartItemReplacement::class);
    }
}
