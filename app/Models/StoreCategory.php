<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_store_id',
        'name',
        'order'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

}
