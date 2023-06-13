<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CustomersListRequest extends FormRequest
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
            'sortBy' => Rule::in(['name', 'email', 'total_orders']),
            'sortOrder' => Rule::in(['asc', 'desc']),
        ];
    }

    public function messages(): array
    {
        return  [
            'sortBy' => "The 'sortBy' parameter accepts only 'name', 'email' or 'total_orders' value",
            'sortOrder' => "The 'sortOrder' parameter accepts only 'asc' or 'desc' value",
        ];
    }
}
