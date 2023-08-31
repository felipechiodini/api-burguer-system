<?php

namespace App\Cart;

use App\Discount\DiscountInterface;
use App\Models\Cart as ModelsCart;
use App\Models\Order;
use App\Product\Additional;
use App\Product\Product;
use App\Product\Replacement;
use Illuminate\Support\Facades\Cache;

class Cart {

    public $model;
    public $items;
    public $discount;
    public $payment;
    public $address;

    public function __construct(ModelsCart $cart)
    {
        $this->model = $cart;
        $this->items = collect([]);
    }

    public static function load($id): self
    {
        if (Cache::has($id)) return Cache::get($id);

        $cart = ModelsCart::find($id);
        $dioawjdiow = new static($cart);

        foreach ($cart->items as $item) {
            $product = new Product($item->product);

            foreach ($item->additionals as $additional) {
                $product->addAdditional(new Additional($additional->additional, $additional->amount));
            }

            foreach ($item->replacements as $replacement) {
                $product->addReplacement(new Replacement($replacement));
            }

            $dioawjdiow->addItem(new CartItem($product, $item->amount));
        }

        return $dioawjdiow;
    }

    public function save()
    {
        Cache::set($this->model->id, $this, now()->endOfDay());

        //logica para salvar no banco
    }

    public function getShippingPrice()
    {
        return 10;
    }

    public function getSubtotal()
    {
        $price = 0;

        foreach ($this->items as $item) {
            $price += $item->getPrice();
        }

        return $price;
    }

    public function getDiscount()
    {
        if ($this->hasDiscount()) {
            if ($this->discount->getType() === 'percent') {
                return ($this->discount->getValue() / 100) * $this->getSubtotal();
            } else {
                return $this->discount->getValue();
            }
        }

        return 0;
    }

    public function getTotal()
    {
        return $this->getSubtotal() + $this->getShippingPrice() - $this->getDiscount();
    }

    public function addDiscount(DiscountInterface $discount)
    {
        $this->discount = $discount;
    }

    public function addAddress($address)
    {
        $this->address = $address;
    }

    public function addPayment($payment)
    {
        $this->payment = $payment;
    }

    public function addItem(CartItem $cartitem)
    {
        $this->items->push($cartitem);
        return $this;
    }

    public function removeItem($id)
    {


    }

    public function hasDiscount(): bool
    {
        return $this->discount !== null;
    }

    public function finish()
    {
        $order = Order::query()
            ->create([
                'dwad' => 'dwads',
            ]);

        $order->payment()
            ->create([
                'dwa' => 'dwa'
            ]);
    }
}
