<?php

namespace App\Models;

use App\Traits\HasShipment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cargo extends Model
{
    use HasFactory, HasUuids, HasShipment;

    protected $fillable = [
        'name',
        'description',
        'weight',
        'quantity',
        'shipment_id',
        'order_id'
    ];


    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }


   

    
}
