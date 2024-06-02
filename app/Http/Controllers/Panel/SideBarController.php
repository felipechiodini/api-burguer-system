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
            ['label' => 'Loja', 'name' => 'store.show', 'icon' => 'fa-solid fa-store'],
            ['label' => 'Gerenciador de Pedidos', 'name' => 'order.manager', 'icon' => 'fa-solid fa-list-check'],
            ['label' => 'Pedidos', 'name' => 'order.index', 'icon' => 'fa-solid fa-cart-shopping'],
            ['label' => 'Clientes', 'name' => 'customer.index', 'icon' => 'fa-solid fa-users'],
            ['label' => 'Categorias', 'name' => 'category.index', 'icon' => 'fa-solid fa-tag'],
            ['label' => 'Endereço', 'name' => 'address.index', 'icon' => 'fa-solid fa-house'],
            ['label' => 'Comandas', 'name' => 'card.index', 'icon' => 'fa-regular fa-address-card'],
            ['label' => 'Banners', 'name' => 'banner.index', 'icon' => 'fa-regular fa-images'],
            ['label' => 'Produtos', 'name' => 'product.index', 'icon' => 'fa-solid fa-bag-shopping'],
            ['label' => 'Horários', 'name' => 'schedule.index', 'icon' => 'fa-regular fa-clock'],
            ['label' => 'Entrega', 'name' => 'delivery.index', 'icon' => 'fa-solid fa-truck'],
            ['label' => 'Pagamento', 'name' => 'payment.index', 'icon' => 'fa-regular fa-credit-card'],
            ['label' => 'Configurações', 'name' => 'configuration.index', 'icon' => 'fa-solid fa-gear'],
        ];

        return response()
            ->json(compact('sidebar'));
    }

}
