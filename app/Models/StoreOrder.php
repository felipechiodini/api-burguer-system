<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'customer_id',
        'coupon_id',
        'products_total',
        'delivery_fee',
        'discount',
        'delivery',
        'total',
        'origin',
        'status'
    ];

    public function store()
    {
        return $this->belongsTo(UserStore::class);
    }

    public function customer()
    {
        return $this->belongsTo(StoreCustomer::class, 'customer_id');
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
            $query->where((new static())->getTable() . '.store_id', app('currentTenant')->id);
        });
    }
}
