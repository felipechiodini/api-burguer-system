<?php

namespace App\Dashboard;

use App\Models\Order;
use App\Models\UserStore;
use Illuminate\Support\Facades\DB;

class Home {

    private $store;

    public function __construct()
    {
        $this->store = app('currentTenant');
    }

    public function get()
    {
        return [
            'store_status' => $this->store->isOpen()
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
