<?php

namespace App\Dashboard;

use App\Models\StoreOrder;

class Home {

    private $store;

    public function __construct()
    {
        $this->store = app('currentTenant');
    }

    public function get()
    {
        return [
            'store_status' => $this->store->isOpen(),
            'charts' => [
                $this->ordersToday(),
            ]
        ];
    }

    public function ordersToday()
    {
        $rows = StoreOrder::query()
            ->selectRaw('COUNT(*) as quantity')
            ->selectRaw("DATE_FORMAT(created_at, '%d/%m/%Y') as date")
            ->select('created_at')
            ->where('user_store_id', '=', 2)
            ->groupBy('created_at')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $options = [
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

        return $options;
    }

}
