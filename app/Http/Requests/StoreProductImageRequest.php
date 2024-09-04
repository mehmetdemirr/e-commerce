<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreProductImageRequest extends BaseRequest
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
            'product_id' => 'required|exists:products,id',
            'images' => 'required|array',
            'images.*.image_url' => 'required|url',
            'images.*.is_main' => 'nullable|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Product ID is required.',
            'product_id.exists' => 'The specified product does not exist.',
            'images.required' => 'At least one image is required.',
            'images.array' => 'Images must be an array.',
            'images.*.image_url.required' => 'Image URL is required.',
            'images.*.image_url.url' => 'Image URL must be a valid URL.',
            'images.*.is_main.boolean' => 'Is main must be a boolean value.',
        ];
    }
}
