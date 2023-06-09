<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'sometimes|string|max:255',
            'total_price' => 'sometimes|numeric',
            'customer_id' => 'sometimes|exists:customers,id',
            'shipment_id' => 'nullable|exists:shipments,id',
        ];
    }
}
