<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'choice_id',
        'name',
        'value'
    ];

}
