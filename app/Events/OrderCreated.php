<?php

namespace App\Events;

use App\Enums\Order\Payment;
use App\Enums\Order\Status;
use App\Models\OrderPayment;
use App\Models\StoreCustomer;
use App\Models\StoreOrder;
use App\Utils\Helper;
use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $slug;

    public function __construct(
        public StoreOrder $storeOrder,
        public StoreCustomer $customer,
        public OrderPayment $payment,
        public $address
    ) {
        $this->slug = app('currentTenant')->slug;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("orders.{$this->slug}");
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->storeOrder->id,
            'total' => Helper::formatCurrency($this->storeOrder->total),
            'status' => $this->storeOrder->status,
            'status_label' => Status::getDescription($this->storeOrder->status),
            'ordered_since' => Carbon::parse($this->storeOrder->created_at)->diffForHumans(now()),
            'neighborhood' => @$this->address->neighborhood,
            'distance' => 10,
            'payment_type' => Payment::getDescription($this->payment->type),
            'customer' => [
                'name' => explode(' ', $this->customer->name)[0],
            ]
        ];
    }

}
