<?php

namespace App\Observers;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Support\Str;

class OrderObserver
{
    public function creating(Order $order)
    {
        $order->order_number = rand(1, 100);
        $order->status = OrderStatus::Pending;
    }
}
