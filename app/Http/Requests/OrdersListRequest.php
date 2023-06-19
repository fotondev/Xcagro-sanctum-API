<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class OrdersListRequest extends FormRequest
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
            'priceFrom' => 'numeric',
            'priceTo' => 'numeric',
            'dateFrom' => 'dateTime',
            'dateTo' => 'dateTime',
            'sortBy' => Rule::in(['status', 'total_price']),
            'sortOrder' => Rule::in(['asc', 'desc']),
        ];
    }
    public function messages(): array
    {
        return  [
            'sortBy' => "The 'sortBy' parameter accepts only 'status' and 'total_price' value",
            'sortOrder' => "The 'sortOrder' parameter accepts only 'asc' or 'desc' value",
        ];
    }
}
