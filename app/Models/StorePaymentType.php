<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorePaymentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_store_id',
        'payment_type',
    ];
}
