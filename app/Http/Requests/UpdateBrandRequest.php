<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends BaseRequest
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
            'name' => 'sometimes|string|max:255|unique:brands,name,' . $this->route()->parameters['id'],
            'description' => 'nullable|string',
        ];
    }

    /**
     * Get the custom validation messages for attributes.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.string' => 'Marka adı bir metin olmalıdır.',
            'name.max' => 'Marka adı 255 karakterden uzun olamaz.',
            'name.unique' => 'Bu marka adı zaten mevcut.',
            'description.string' => 'Açıklama bir metin olmalıdır.',
        ];
    }
}
