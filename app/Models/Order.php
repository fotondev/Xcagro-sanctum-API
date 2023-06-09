<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Traits\HasCargos;
use App\Traits\HasShipment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, HasUuids, HasShipment, HasCargos;

    protected $fillable = [
        'order_number',
        'status',
        'total_price',
        'customer_id',
        'shipment_id'
    ];


    protected $casts = [
        'status' => OrderStatus::class,
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function totalPrice()
    {
        return $this->total_price / 100;
    }
}
