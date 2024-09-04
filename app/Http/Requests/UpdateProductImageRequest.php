<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UpdateProductImageRequest extends BaseRequest
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
            'images' => 'required|array',
            'images.*.id' => 'required|exists:product_images,id',
            'images.*.image_url' => 'required|url',
            'images.*.is_main' => 'nullable|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'images.required' => 'At least one image is required.',
            'images.array' => 'Images must be an array.',
            'images.*.id.required' => 'Image ID is required.',
            'images.*.id.exists' => 'The specified image does not exist.',
            'images.*.image_url.required' => 'Image URL is required.',
            'images.*.image_url.url' => 'Image URL must be a valid URL.',
            'images.*.is_main.boolean' => 'Is main must be a boolean value.',
        ];
    }
}
