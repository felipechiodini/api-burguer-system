<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_id',
        'cep',
        'street',
        'number',
        'district',
        'city',
        'state',
        'latitude',
        'longitude'
    ];
}
