<?php

namespace App\Utils;

use App\Discount\Discount;
use App\Models\Cart as ModelsCart;
use App\Models\CartItem;
use App\Models\Order;

class Cart {

    public $model;

    public function __construct(ModelsCart $cart)
    {
        $this->model = $cart;
    }

    public function getValue()
    {
        $value = 0;

        foreach ($this->model->items as $item) {
            $value += ($item->value * $item->amount);
        }

        return $value;
    }

    public function addDiscount(Discount $discount)
    {
        //
    }

    public function finish()
    {

        Order::query()
            ->create([
                'customer_id' => 'dad'
            ]);

    }

    public function add($itemId, $amount = 1)
    {
        $item = Item::make($itemId);

        if ($item->hasStock() === false)
            throw new \Exception("Produto sem estoque");

        CartItem::query()
            ->create([
                'cart_id' => $this->model->id,
                'value' => $item->getValue(),
                'amount' => $amount
            ]);
    }

    public function get()
    {
        $total = $this->getValue();
        $discount = 20;

        return [
            'sub_total' => $total,
            'discount' => $total - $discount,
            'total' => $total
        ];
    }

    public function getCustomer()
    {
        //
    }
}
