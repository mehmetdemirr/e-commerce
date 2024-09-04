<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends BaseRequest
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
            'parent_id' => 'nullable|exists:categories,id', // parent_id'nin geçerli bir kategori ID'si olup olmadığını kontrol eder
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Kategori adı gereklidir.',
            'name.string' => 'Kategori adı bir string olmalıdır.',
            'name.max' => 'Kategori adı en fazla 255 karakter uzunluğunda olabilir.',
            'parent_id.exists' => 'Geçersiz üst kategori ID\'si.',
        ];
    }
}
