<?php

namespace App\Models;

use App\Traits\HasOrders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory, HasUuids, HasOrders;

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];
}
