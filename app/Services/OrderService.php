<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderService
{

    public function execute(array $data): Order
    {
        $lastOrder = DB::table('orders')->latest()->first();

        $nextOrderNumber = $lastOrder ? $lastOrder->order_number + 1 : 1;

        $data['order_number'] =  $nextOrderNumber;

        $data['status'] = OrderStatus::Pending;

        return Order::create($data);
    }
}
