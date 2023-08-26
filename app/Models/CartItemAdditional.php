<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItemAdditional extends Model
{
    use HasFactory;

    public function additional()
    {
        return $this->belongsTo(ProductAdditional::class);
    }
}
