<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Cargo;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;

class CargoService
{

    public function addCargoToOrder(Order $order, array $data): Cargo
    {
        $data['order_id'] = $order->id;
        $cargo = Cargo::create($data);
        $order->assignCargo($cargo);

        return $cargo;
    }

    public function provideShipmentForOrder(Order $order, array $data): Shipment
    {
        $shipment = new Shipment($data);

        DB::transaction(function () use ($order, $shipment) {
            $order->shipment()->attach($shipment->id);
            $order->cargos()->update(['shipment_id' => $shipment->id]);
        });
        return $shipment;
    }
}
