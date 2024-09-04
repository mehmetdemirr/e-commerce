<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreProductImageRequest extends FormRequest
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

    protected function failedValidation(Validator $validator)
    {
        // Handle validation failure and prevent further processing
        throw new ValidationException(
            $validator,
            response()->json([
                'success' => false,
                'data' => null,
                'errors' => $validator->errors(),
                'message' => 'Validation failed.'
            ], 422)
        );
    }

    /**
     * Override the withValidator method to add custom validation logic.
     */
    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $images = $this->input('images', []);
            $mainImages = array_filter($images, function ($image) {
                return isset($image['is_main']) && $image['is_main'];
            });

            if (count($mainImages) > 1) {
                $validator->errors()->add('images', 'Only one image can be marked as main.');
            }
        });
    }
}
