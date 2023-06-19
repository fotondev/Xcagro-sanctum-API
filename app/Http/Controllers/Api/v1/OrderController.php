<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\order;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrdersListRequest;
use App\Http\Resources\orderResource;
use App\Http\Requests\StoreorderRequest;
use App\Http\Requests\UpdateorderRequest;
use App\Services\OrderService;

class OrderController extends Controller
{
    public function index(OrdersListRequest $request)
    {

        $orders = Order::query()
            ->when($request->priceFrom, function ($query) use ($request) {
                $query->where('total_price', '>=', $request->priceFrom * 100);
            })
            ->when($request->priceTo, function ($query) use ($request) {
                $query->where('total_price', '<=', $request->priceTo * 100);
            })
            ->when($request->dateFrom, function ($query) use ($request) {
                $query->where('created_at', '>=', $request->created_at);
            })
            ->when($request->dateTo, function ($query) use ($request) {
                $query->where('created_at', '<=', $request->created_at);
            })
            ->orderBy($request->sortBy ?? 'created_at', $request->sortOrder ?? 'desc')
            ->paginate($request->input('per_page', 15));

        return (OrderResource::collection($orders))
            ->response()
            ->setStatusCode(200);
    }

    public function show(Order $order)
    {
        return (new OrderResource($order))
            ->response()
            ->setStatusCode(200);
    }

    public function listByCustomer(OrdersListRequest $request, Customer $customer)
    {
        $orders = $customer->orders()
            ->orderBy('status')
            ->orderBy('created_at', 'desc')
            ->paginate($request->input('per_page', 15));

        return (OrderResource::collection($orders))
            ->response()
            ->setStatusCode(200);
    }


    public function store(StoreorderRequest $request, OrderService $service)
    {
        $order = $service->execute( $request->validated());
      
        return (new OrderResource($order))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateorderRequest $request, Order $order)
    {

        $order->update($request->validated());
        return (new OrderResource($order))
            ->response()
            ->setStatusCode(201);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
