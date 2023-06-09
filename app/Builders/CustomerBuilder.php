<?php

declare(strict_types=1);

namespace App\Builders;

use App\Models\Customer;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerBuilder extends QueryBuilder
{
    public static function apply(Request $request)
    {
        $query = QueryBuilder::for(Customer::class)
            ->allowedIncludes('orders')
            ->allowedFilters(['name', 'email', 'orders.total'])
            ->allowedSorts(['name', 'email', 'created_at'])
            ->withCount('orders');


        return $query->paginate($request->input('per_page', 15));
    }
}
