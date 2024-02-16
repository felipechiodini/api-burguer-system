<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreConfiguration;
use App\Models\StoreSchedule;
use App\Models\UserStore;
use Illuminate\Http\Request;

class StoreScheduleController extends Controller
{

    public function get()
    {
        $schedules = StoreSchedule::query()
            ->get();

        return response()
            ->json(compact('schedules'));
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

}
