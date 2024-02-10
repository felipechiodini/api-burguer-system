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
        'products_total',
        'delivery_fee',
        'discount',
        'total',
        'origin',
        'status'
    ];

    public function customer()
    {
        return $this->belongsTo(StoreCustomer::class, 'store_customer_id');
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'store_order_id');
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
        return $this->hasOne(OrderDelivery::class, 'store_order_id');
    }

    public function address()
    {
        return $this->hasOne(OrderAddress::class, 'store_order_id');
    }

    public function payment()
    {
        return $this->hasOne(OrderPayment::class, 'store_order_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('store', function($query) {
            $query->where((new static())->getTable() . '.user_store_id', app('currentTenant')->id);
        });
    }
}
