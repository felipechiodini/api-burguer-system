<?php

namespace App\Models;

use App\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_id'
    ];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function additem(Product $product, Int $amount = 1, ?String $observation = null)
    {
        return $this->items()
            ->create([
                'product_id' => $product->model->id,
                'value' => $product->getPrice(),
                'amount' => $amount,
                'observation' => $observation
            ]);
    }

    public function addCoupon(Coupon $coupon)
    {
        return $this->update([
            'coupon_id' => $coupon->id
        ]);
    }

    public function getSubtotal()
    {
        $total = 0;

        foreach ($this->items() as $item) {
            $total += $item->value * $item->amount;
        }

        return $total;
    }

    public function serialize()
    {
        return [
            'subtotal' => $this->getSubtotal(),
            'shipping' => 5,
            'discount' => 0,
            'total' => 105,
        ];
    }
}
