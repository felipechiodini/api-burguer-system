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
            ['label' => 'Clientes', 'name' => 'customer.index', 'icon' => 'fa-solid fa-users'],
            ['label' => 'Categorias', 'name' => 'category.index', 'icon' => 'fa-solid fa-tag'],
            ['label' => 'Comandas', 'name' => 'card.index', 'icon' => 'fa-regular fa-address-card'],
            ['label' => 'Banners', 'name' => 'banner.index', 'icon' => 'fa-regular fa-images'],
            ['label' => 'Produtos', 'name' => 'product.index', 'icon' => 'fa-solid fa-bag-shopping'],


            // ['label' => 'Pedidos', 'name' => 'order.index', 'icon' => 'fa-solid fa-users'],
            // ['label' => 'Configurações', 'name' => 'configuration.index', 'icon' => 'fa-solid fa-users'],
        ];

        return response()
            ->json(compact('sidebar'));
    }

}