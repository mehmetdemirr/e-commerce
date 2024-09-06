<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartItemRequest extends BaseRequest
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
    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Ürün seçmek zorundasınız.',
            'product_id.exists' => 'Seçilen ürün bulunamadı.',
            'quantity.required' => 'Ürün adedi belirtilmelidir.',
            'quantity.integer' => 'Ürün adedi bir sayı olmalıdır.',
            'quantity.min' => 'Ürün adedi en az 1 olmalıdır.'
        ];
    }
}
