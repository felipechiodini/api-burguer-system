<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_delivery_id',
        'cep',
        'street',
        'number',
        'neighborhood',
        'city',
        'complement'
    ];

}
