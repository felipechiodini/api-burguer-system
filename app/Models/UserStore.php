<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Multitenancy\Models\Tenant as ModelsTenant;
use Illuminate\Support\Str;

class UserStore extends ModelsTenant
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'logo'
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

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function categories()
    {
        return $this->hasMany(StoreCategory::class)
            ->orderBy('order');
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

    public function link()
    {
        return "https://burguersystem.online/{$this->slug}";
    }

    public function isOpen(): Array
    {
        $dayOfWeek = Carbon::today()->dayOfWeek + 1;

        $withinSchedule = StoreSchedule::query()
            ->where('week_day', $dayOfWeek)
            ->where('start', '<=', now()->toTimeString())
            ->where('end', '>=', now()->toTimeString())
            ->first();

        $hasProgramedPause = StoreScheduledBreak::query()
            ->where('start', '<=', now()->toDateTimeString())
            ->where('end', '>=', now()->toDateTimeString())
            ->first();

        $hasEmergencyClose = StoreEmergencyClose::query()
            ->where('ends_at', '>=', now()->toDateTimeString())
            ->first();

        $schedules = StoreSchedule::query()
            ->orderBy('week_day', 'desc')
            ->get();

        $nextSchedule = null;
        foreach ($schedules as $schedule) {
            $carbon = Carbon::parse($schedule->start);

            if ($carbon->isAfter(now())) {
                $nextSchedule = $carbon;
                break;
            }
        }

        return [
            'is_open' => $withinSchedule && !$hasEmergencyClose && !$hasProgramedPause,
            'open_in' => $nextSchedule ? "Abre {$nextSchedule->format('l \à\s H:i\h')}" : null
        ];
    }

    public function isCompletedConfigured()
    {
        $checkers = collect([
            'address' => [
                'name' => 'Cadastrar Endereço da Loja',
                'router_name' => 'address.update',
                'callback' => function() {
                    return StoreAddress::query()
                        ->first() !== null;
                }
            ],
            'schedule' => [
                'name' => 'Cadastrar Horário de Atendimento',
                'router_name' => 'schedule.index',
                'callback' => function() {
                    return StoreSchedule::query()
                        ->first() !== null;
                }
            ],
        ]);

        $pendings = $checkers->map(function($checker) {
            return [
                'name' => $checker['name'],
                'router_name' => $checker['router_name'],
                'done' => $checker['callback']()
            ];
        });

        return $pendings;
    }

    public static function canUseName(String $name): Bool
    {
        return self::query()
            ->where('slug', Str::slug($name))
            ->exists();
    }

}
