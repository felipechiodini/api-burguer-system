<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_store_id',
        'store_customer_id',
        'store_coupon_id',
        'origin',
        'status'
    ];

    public function customer()
    {
        return $this->belongsTo(StoreCustomer::class);
    }

    public function products()
    {
        return $this->hasMany(StoreProduct::class);
    }

    public function additionals()
    {
        return $this->hasManyThrough(ProductAdditional::class, OrderProductAdditional::class);
    }

    public function replacements()
    {
        return $this->hasManyThrough(ProductReplacement::class, OrderProductReplacement::class);
    }

    public function delivery()
    {
        return $this->hasOne(OrderDelivery::class);
    }

    public function payment()
    {
        return $this->hasOne(OrderPayment::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
