<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StatusRequest extends BaseRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                // Aynı isimde başka bir status var mı kontrolü
                Rule::unique('order_statuses')->ignore($this->route('status'))
            ],
            'description' => 'nullable|string'
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
            'name.required' => 'Durum adı zorunludur.',
            'name.string' => 'Durum adı geçerli bir metin olmalıdır.',
            'name.max' => 'Durum adı en fazla 255 karakter uzunluğunda olabilir.',
            'name.unique' => 'Bu isimde bir durum zaten mevcut.', 
            'description.string' => 'Açıklama geçerli bir metin olmalıdır.'
        ];
    }
}
