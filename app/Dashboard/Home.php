<?php

namespace App\Dashboard;

use App\Models\StoreOrder;
use App\Models\StoreProduct;

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
            ->select("COUNT(*) as quantity, DATE_FORMAT(created_at, '%d/%m/%Y') AS created_at")
            ->where()
            ->groupBy('created_at')
            ->orderBy('id', 'desc')
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
