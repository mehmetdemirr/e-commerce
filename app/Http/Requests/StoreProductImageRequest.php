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
            'images.*.file' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048', // Dosya türleri ve boyutu
            'images.*.is_main' => 'nullable|boolean'
        ];
    }

    /**
     * Get the validation messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'product_id.required' => 'Product ID is required.',
            'product_id.exists' => 'The specified product does not exist.',
            'images.required' => 'At least one image is required.',
            'images.array' => 'Images must be an array.',
            'images.*.file.required' => 'Image file is required.',
            'images.*.file.file' => 'Each image must be a file.',
            'images.*.file.mimes' => 'Each image must be a file of type: jpeg, png, jpg, gif.',
            'images.*.file.max' => 'Each image may not be greater than 2MB.',
            'images.*.is_main.boolean' => 'Is main must be a boolean value.',
        ];
    }
}
