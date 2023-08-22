<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'waiter_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sub_order_has_products')->withPivot(['value', 'amount']);
    }

    public function total()
    {
        $total = 0;

        foreach ($this->products as $product) {
            $total = $total + ($product->pivot->value * $product->pivot->amount);
        }

        return $total;
    }

}
