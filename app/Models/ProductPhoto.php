<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_product_id',
        'src',
        'order'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

}
