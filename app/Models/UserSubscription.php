<?php

namespace App\Models;

use App\Subscription\SubscriptionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_price_id',
        'canceled',
        'start_at',
        'expire_at'
    ];

    protected $casts = [
        'canceled' => 'boolean'
    ];

    protected $appends = [
        'status'
    ];

    public function planPrice()
    {
        return $this->belongsTo(PlanPrice::class);
    }

    public function getStatusAttribute()
    {
        return SubscriptionStatus::subscription($this)
            ->getStatus();
    }

}
