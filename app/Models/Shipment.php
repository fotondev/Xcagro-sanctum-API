<?php

namespace App\Models;

use App\Traits\HasCargos;
use App\Traits\HasOrders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipment extends Model
{
    use HasFactory, HasUuids, HasOrders, HasCargos;

    protected $fillable = [
        'origin',
        'destination',
        'departure_date',
        'arrival_date'
    ];

   
}
