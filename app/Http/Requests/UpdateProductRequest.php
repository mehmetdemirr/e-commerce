<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends BaseRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric',
            'quantity' => 'sometimes|integer',
        ];
    }

    /**
     * Get the custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.sometimes' => 'The name field is required when present.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            
            'description.string' => 'The description must be a string.',

            'price.sometimes' => 'The price field is required when present.',
            'price.numeric' => 'The price must be a numeric value.',

            'quantity.sometimes' => 'The quantity field is required when present.',
            'quantity.integer' => 'The quantity must be an integer.',
        ];
    }
}
