<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends BaseRequest
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
        $categoryId = $this->route('category'); // Kategori ID'sini almak için

        return [
            'name' => [
                'sometimes',
                'string',
                'max:255',
                // Mevcut kategori adının kendisiyle çakışmamasını sağlamak için
                'unique:categories,name,' . $categoryId,
            ],
            'description' => 'nullable|string|max:1000',
            'parent_id' => 'nullable|exists:categories,id',
        ];
    }

    /**
     * Get the validation messages for the rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.string' => 'Kategori adı bir dize olmalıdır.',
            'name.max' => 'Kategori adı en fazla 255 karakter uzunluğunda olabilir.',
            'name.unique' => 'Bu kategori adı zaten mevcut.',
            'description.string' => 'Açıklama bir dize olmalıdır.',
            'description.max' => 'Açıklama en fazla 1000 karakter uzunluğunda olabilir.',
            'parent_id.exists' => 'Geçersiz üst kategori ID\'si.',
        ];
    }
}
