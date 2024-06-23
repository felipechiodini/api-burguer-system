<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductChoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'required'
    ];

    protected $casts = [
        'required' => 'boolean'
    ];

}
