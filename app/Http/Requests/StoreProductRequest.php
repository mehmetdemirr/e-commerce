<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends BaseRequest 
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'sku' => 'required|string|max:50|unique:products,sku',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'discount' => 'nullable|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive,draft',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The product name is required.',
            'name.string' => 'The product name must be a string.',
            'name.max' => 'The product name may not be greater than 255 characters.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a number.',
            'price.min' => 'The price must be at least 0.',
            'quantity.required' => 'The quantity is required.',
            'quantity.integer' => 'The quantity must be an integer.',
            'quantity.min' => 'The quantity must be at least 1.',
            'sku.required' => 'The SKU is required.',
            'sku.string' => 'The SKU must be a string.',
            'sku.max' => 'The SKU may not be greater than 50 characters.',
            'sku.unique' => 'The SKU must be unique.',
            'category_id.required' => 'The category is required.',
            'category_id.exists' => 'The selected category is invalid.',
            'brand_id.exists' => 'The selected brand is invalid.',
            'discount.numeric' => 'The discount must be a number.',
            'discount.min' => 'The discount must be at least 0.',
            'shipping_cost.numeric' => 'The shipping cost must be a number.',
            'shipping_cost.min' => 'The shipping cost must be at least 0.',
            'weight.numeric' => 'The weight must be a number.',
            'weight.min' => 'The weight must be at least 0.',
            'dimensions.string' => 'The dimensions must be a string.',
            'dimensions.max' => 'The dimensions may not be greater than 100 characters.',
            'status.required' => 'The status is required.',
            'status.in' => 'The status must be one of the following: active, inactive, or draft.',
        ];
    }
}
