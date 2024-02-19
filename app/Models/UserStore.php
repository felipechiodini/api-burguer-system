<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Multitenancy\Models\Tenant as ModelsTenant;

class UserStore extends ModelsTenant
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'database'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function address()
    {
        return $this->hasOne(StoreAddress::class);
    }

    public function customers()
    {
        return $this->hasMany(StoreCustomer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function waiters()
    {
        return $this->hasMany(Waiter::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function categories()
    {
        return $this->hasMany(StoreCategory::class)
            ->orderBy('order');
    }

    public function shippingOptions()
    {
        return $this->hasMany(StoreShippingOptions::class);
    }

    public function products()
    {
        return $this->hasMany(StoreProduct::class);
    }

    public function banners()
    {
        return $this->hasMany(StoreBanner::class);
    }

    public function configuration()
    {
        return $this->hasOne(StoreConfiguration::class);
    }

    public function paymentOptions()
    {
        return $this->belongsToMany(PaymentType::class, StorePaymentType::class);
    }

    public function deliveryOptions()
    {
        return $this->belongsToMany(DeliveryType::class, StoreDeliveryType::class)->withPivot('minutes');
    }

    public function isOpen(): Bool
    {
        $dayOfWeek = Carbon::today()->dayOfWeek + 1;

        $withinSchedule = StoreSchedule::query()
            ->where('week_day', $dayOfWeek)
            ->where('start', '<=', now()->toTimeString())
            ->where('end', '>=', now()->toTimeString())
            ->exists();

        $hasProgramedPause = StoreScheduledBreak::query()
            ->where('start', '<=', now()->toDateTimeString())
            ->where('end', '>=', now()->toDateTimeString())
            ->exists();

        $hasEmergencyClose = StoreEmergencyClose::query()
            ->where('ends_at', '>=', now()->toDateTimeString())
            ->exists();

        return $withinSchedule === true &&
            $hasEmergencyClose === false &&
            $hasProgramedPause === false;
    }

}
