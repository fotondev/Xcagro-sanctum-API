<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasOrders
{

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function assignOrder(Order $order)
    {
        $this->orders()->associate($order);
        $this->save();
    }
}
