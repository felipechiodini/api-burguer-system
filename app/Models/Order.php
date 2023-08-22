<?php

namespace App\Models;

use App\Order\CalculateOrderTotalValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_store_id',
        'card_id',
        'customer_id',
        'type',
        'status',
        'origin',
    ];

    protected $appends = [
        'total'
    ];

    public function getTotalAttribute()
    {
        return CalculateOrderTotalValue::order($this)->totalValue();
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function subOrders()
    {
        return $this->hasMany(SubOrder::class);
    }

    public function payment()
    {
        return $this->hasOne(OrderPayment::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('store', function($query) {
            $query->where('user_store_id', request()->header(UserStore::HEADER_KEY));
        });
    }

}
