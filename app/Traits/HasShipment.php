<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Shipment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasShipment
{
    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

    public function assignShipment(Shipment $shipment)
    {
        $this->shipment()->associate($shipment);
        $this->save();
    }
}
