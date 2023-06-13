<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

class CustomerController extends Controller
{

    public function index(Request $request)
    {

        $customers = Customer::query()
            ->leftJoin('orders', 'customers.id', '=', 'orders.customer_id')
            ->select('customers.*', DB::raw('COUNT(orders.id) as total_orders'))
            ->groupBy('customers.id')
            ->orderBy($request->sortBy ?? 'created_at', $request->sortOrder ?? 'asc')
            ->paginate();

        return (CustomerResource::collection($customers))
            ->response()
            ->setStatusCode(200);
    }

    public function show(Customer $customer)
    {
        return (new CustomerResource($customer))
            ->response()
            ->setStatusCode(200);
    }

    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->validated());

        return (new CustomerResource($customer))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {

        $customer->update($request->validated());
        return (new CustomerResource($customer))
            ->response()
            ->setStatusCode(201);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(null, 204);
    }
}
