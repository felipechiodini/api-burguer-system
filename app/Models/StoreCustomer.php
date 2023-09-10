<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreCustomer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_store_id',
        'name',
        'document',
        'cellphone'
    ];

}
