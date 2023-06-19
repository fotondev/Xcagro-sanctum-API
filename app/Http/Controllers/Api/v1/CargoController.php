<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCargoRequest;
use App\Http\Resources\CargoResource;
use App\Models\Cargo;
use App\Models\Order;
use App\Services\CargoService;

class CargoController extends Controller
{

    public function index(Order $order, Request $request)
    {
        $cargos = $order->cargos()
            ->orderBy($request->sortBy ?? 'created_at', $request->sortOrder ?? 'desc')
            ->paginate($request->input('per_page', 15));

        return (CargoResource::collection($cargos))
            ->response()
            ->setStatusCode(200);
    }

    public function show(Order $order, Cargo $cargo)
    {
        return (new CargoResource($cargo))
            ->response()
            ->setStatusCode(200);
    }



    public function store(Order $order, StoreCargoRequest $request, CargoService $service)
    {
        $cargo = $service->addCargoToOrder($order, $request->validated());

        return (new CargoResource($cargo))
            ->response()
            ->setStatusCode(201);
    }
}
