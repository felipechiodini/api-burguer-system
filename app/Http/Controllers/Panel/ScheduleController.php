<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\StoreSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{

    public function get()
    {
        $translate = [
            1 => 'Domingo',
            2 => 'Segunda',
            3 => 'Terça',
            4 => 'Quarta',
            5 => 'Quinta',
            6 => 'Sexta',
            7 => 'Sábado',
        ];

        $schedules = StoreSchedule::query()
            ->get()
            ->map(function(StoreSchedule $storeSchedule) use(&$translate) {
                return [
                    'week_day' => $translate[$storeSchedule->week_day],
                    'start' => Carbon::parse($storeSchedule->start)->format('H:m'),
                    'end' => Carbon::parse($storeSchedule->end)->format('H:m')
                ];
            });

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

        return response()
            ->json(['message' => 'Horário salvo com sucesso!']);
    }

}
