<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'name',
        'code',
        'value',
        'type',
    ];

    public static function getByCode(String $code): ?self
    {
        return self::query()
            ->whereRaw('LOWER(code) = ?', $code)
            ->first();
    }
}
