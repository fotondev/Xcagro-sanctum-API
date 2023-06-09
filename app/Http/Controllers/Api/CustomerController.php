<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Builders\CustomerBuilder;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = CustomerBuilder::apply($request);
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
