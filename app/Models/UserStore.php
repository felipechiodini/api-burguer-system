<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStore extends Model
{
    use HasFactory;

    public const HEADER_KEY = 'x-store-uuid';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'slug'
    ];

    protected $appends = [
        'open'
    ];

    public function customers()
    {
        return $this->hasMany(Customer::class);
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
        return $this->hasMany(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function banners()
    {
        return $this->hasMany(StoreBanner::class);
    }

    public function configuration()
    {
        return $this->hasOne(StoreConfiguration::class);
    }

    public function address()
    {
        return $this->hasOne(StoreAddress::class);
    }

    public function paymentTypes()
    {
        return $this->belongsToMany(PaymentType::class, UserStorePaymentType::class);
    }

    public function deliveryOptions()
    {
        return $this->belongsToMany(DeliveryOptions::class, UserStoreDeliveryOptions::class);
    }

    public function getOpenAttribute()
    {
        $storeSchedule = StoreSchedule::where('week_day', now()->dayOfWeek)
            ->where('user_store_id', $this->id)
            ->first();

        if ($storeSchedule->closed === true) return false;
        if (now()->isBetween($storeSchedule->open_at, $storeSchedule->close_at)) return true;
        return false;
    }

    protected static function boot()
    {
        parent::boot();

        if (auth()->user()) { // this is for dont break the seeder
            static::addGlobalScope('user', function($query) {
                $query->where('user_id', auth()->user()->id);
            });
        }
    }

}
