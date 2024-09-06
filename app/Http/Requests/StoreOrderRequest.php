<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'cart_items' => 'required|array|min:1', // Sepette en az bir ürün olmalı
            'cart_items.*.product_id' => 'required|exists:products,id', // Her ürün var olmalı
            'cart_items.*.quantity' => 'required|integer|min:1', // Ürün adedi 1 veya daha fazla olmalı
        ];
    }

    public function messages()
    {
        return [
            'cart_items.required' => 'Sepetinizde en az bir ürün bulunmalıdır.',
            'cart_items.array' => 'Geçersiz ürün verisi.',
            'cart_items.min' => 'Sepetinizde en az bir ürün bulunmalıdır.',
            'cart_items.*.product_id.required' => 'Bir ürün seçmek zorundasınız.',
            'cart_items.*.product_id.exists' => 'Seçilen ürün mevcut değil.',
            'cart_items.*.quantity.required' => 'Ürün miktarı belirtilmelidir.',
            'cart_items.*.quantity.integer' => 'Ürün miktarı sayısal olmalıdır.',
            'cart_items.*.quantity.min' => 'Ürün miktarı en az 1 olmalıdır.'
        ];
    }
}
