<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class CargoResource extends JsonResource
{
    public static $wrap = 'cargos';
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
                'name' => $this->name,
                'description' => $this->description,
                'weight' => $this->weight,
                'quantity' => $this->quantity,
                'order_id' => $this->order_id,
                'shipment_id' => $this->shipment_id,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'order' => [
                    'data' => [
                        'id' => $this->order->id
                    ],
                ],
                'shipment' => [
                    'data' => [
                        'id' => $this->shipment->id ?? null
                    ]
                ],
            ],
            'links' => [
                'self' => route('cargo.show', $this->id)
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
