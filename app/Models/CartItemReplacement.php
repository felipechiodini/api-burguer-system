<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItemReplacement extends Model
{
    use HasFactory;

    public function replacement()
    {
        return $this->belongsTo(ProductReplacement::class);
    }
}
