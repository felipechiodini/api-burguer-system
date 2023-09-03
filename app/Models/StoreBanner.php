<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_store_id',
        'name',
        'src',
        'order',
    ];

    public function store()
    {
        return $this->belongsTo(UserStore::class);
    }

}
