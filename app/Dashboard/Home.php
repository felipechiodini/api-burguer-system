<?php

namespace App\Dashboard;

use App\Models\Order;
use App\Models\UserStore;
use Illuminate\Support\Facades\DB;

class Home {

    private $store;

    private function __construct()
    {
        $this->store = UserStore::find(request()->header(UserStore::HEADER_KEY));
    }

    public static function get()
    {
        $static = new static();
        return $static->mountData();
    }

    private function mountData()
    {
        return [
            'store_status' => $this->store->open,
            'dashboard' => [
                'charts' => [
                    $this->ordersToday()
                ]
            ]
        ];
    }

    public function ordersToday()
    {
        $sql = "SELECT count(*) as quantity, DATE_FORMAT(created_at, '%d/%m/%Y') AS created_at
            from orders where user_store_id = '{$this->store->id}'
            GROUP BY DATE_FORMAT(created_at, '%d-%m-%Y') ORDER BY created_at DESC limit 10";

        $rows = collect(DB::select($sql));
        $rows->sortByDesc('created_at');

        $chartOptions = [
            'name' => 'Pedidos por dia',
            'config' => [
                'width' => 500,
                'type' => 'bar'
            ],
            'options' => [
                'labels' => $rows->pluck('created_at')
            ],
            'series' => [
                [
                    'name' => 'inscrições',
                    'data' => $rows->pluck('quantity')
                ]
            ]
        ];

        return $chartOptions;
    }

}
