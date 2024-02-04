<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDelivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_order_id',
        'type',
        'observation'
    ];

    public function address()
    {
        return $this->hasOne(DeliveryAddress::class, 'delivery_id');
    }
}
