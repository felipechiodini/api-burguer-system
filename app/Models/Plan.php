<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'foreing_id'
    ];

    public function planPrice()
    {
        return $this->hasMany(PlanPrice::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'plan_has_modules');
    }

}
