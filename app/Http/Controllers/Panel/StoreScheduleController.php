<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreConfiguration;
use App\Models\StoreSchedule;
use App\Models\UserStore;
use Illuminate\Http\Request;

class StoreScheduleController extends Controller
{

    public function get(Request $request)
    {
        $schedules = StoreSchedule::where('user_store_id', $request->header(UserStore::HEADER_KEY))
            ->get();

        return response()->json($schedules);
    }

    public function createOrUpdate(Request $request)
    {
        foreach ($request->all() as $schedule) {
            StoreSchedule::updateOrCreate([
                'week_day' => $schedule['week_day']
            ],[
                'closed' => $schedule['closed'],
                'open_at' => $schedule['open_at'],
                'close_at' => $schedule['close_at']
            ]);
        }

        return response()->json(['message' => 'Horário salvo com sucesso!']);
    }

    public function forceStoreOpen()
    {
        StoreConfiguration::first()->update([
            'force_store_open' => true,
            'force_store_close' => false,
        ]);

        return response()->json(['message' => 'Loja aberta']);
    }

    public function forceStoreClose()
    {
        StoreConfiguration::first()->update([
            'force_store_open' => false,
            'force_store_close' => true,
        ]);

        return response()->json(['message' => 'Loja fechada']);
    }

}
