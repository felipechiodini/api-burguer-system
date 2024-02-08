<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SideBarController extends Controller
{

    public function get(Request $request)
    {
        $sidebar = [
            ['label' => 'Dashboard', 'name' => 'dashboard.index', 'icon' => 'fa-solid fa-gauge'],
            ['label' => 'Gerenciador de Pedidos', 'name' => 'order.manager', 'icon' => 'fa-solid fa-clock'],
            ['label' => 'Clientes', 'name' => 'customer.index', 'icon' => 'fa-solid fa-users'],
            ['label' => 'Categorias', 'name' => 'category.index', 'icon' => 'fa-solid fa-tag'],

            ['label' => 'Cardápio', 'icon' => 'fa-solid fa-tag', 'childrens' => [
                ['name' => 'Banners', 'icon' => 'fa-solid fa-tag' ],
                ['name' => 'Cores', 'icon' => 'fa-solid fa-tag' ],
                ['name' => 'Produtos', 'icon' => 'fa-solid fa-tag' ],
                ['name' => 'Categorias', 'icon' => 'fa-solid fa-tag' ]
            ]],

            ['label' => 'Comandas', 'name' => 'card.index', 'icon' => 'fa-regular fa-address-card'],
            ['label' => 'Banners', 'name' => 'banner.index', 'icon' => 'fa-regular fa-images'],
            ['label' => 'Produtos', 'name' => 'product.index', 'icon' => 'fa-solid fa-bag-shopping'],
            ['label' => 'Horários', 'name' => 'schedule.index', 'icon' => 'fa-solid fa-clock'],


            // ['label' => 'Pedidos', 'name' => 'order.index', 'icon' => 'fa-solid fa-users'],
            // ['label' => 'Configurações', 'name' => 'configuration.index', 'icon' => 'fa-solid fa-users'],
        ];

        $store = app('currentTenant');

        return response()
            ->json(compact('sidebar', 'store'));
    }

}
