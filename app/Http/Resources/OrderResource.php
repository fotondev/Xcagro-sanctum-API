<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{

    public static $wrap = 'orders';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'attributes' => [
                'id' => $this->id,
                'order_number' => $this->orderStatus,
                'status' => $this->status,
                'total_price' => $this->total_price,
                'customer_id' => $this->customer_id,
                'shipment_id' => $this->shipment_id,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'customer' => [
                    'data' => [
                        'id' => $this->customer->id
                    ],
                ]
            ],
            'links' => [
                'self' => route('order.show', $this->id)
            ]

        ];
    }

    public function with(Request $request)
    {
        return [
            'status' => 'succes',
        ];
    }

    public function withResponse(Request $request, JsonResponse $response)
    {
        $response->header('Accept', 'application/json');
        $response->header('Version', 'v1');
    }
}
