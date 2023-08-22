<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComboOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'combo_id',
        'product_id',
        'order'
    ];

    public function combo()
    {
        return $this->belongsTo(Combo::class);
    }
}
