<?php

namespace App\Http\Controllers\Api;

use App\Models\order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\orderResource;
use App\Http\Requests\StoreorderRequest;
use App\Http\Requests\UpdateorderRequest;
use App\Models\Customer;

class orderController extends Controller
{
    public function index(Request $request)
    {

        $orders = order::all();
        return (orderResource::collection($orders))
            ->response()
            ->setStatusCode(200);
    }

    public function show(Customer $customer, Order $order)
    {
        return (new orderResource($order))
            ->response()
            ->setStatusCode(200);
    }

    public function listByCustomer(Request $request, Customer $customer)
    {
        $orders = order::query()
            ->where('customer_id', $customer->id)
            ->with('customer', 'shipment')
            ->paginate($request->input('per_page', 10));

        return (orderResource::collection($orders))
            ->response()
            ->setStatusCode(200);
    }

    // public function showByCustomer(Request $request, Customer $customer, order $order)
    // {
    //     $order = order::query()
    //         ->where('customer_id', $customer->id)
    //         ->with('customer', 'shipment')
    //         ->paginate($request->input('per_page', 10));

    //     return (new orderResource($order))
    //         ->response()
    //         ->setStatusCode(200);
    // }

    public function store(StoreorderRequest $request)
    {
        $order = order::create($request->validated());
        return (new orderResource($order))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateorderRequest $request, order $order)
    {

        $order->update($request->validated());
        return (new orderResource($order))
            ->response()
            ->setStatusCode(201);
    }

    public function destroy(order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
