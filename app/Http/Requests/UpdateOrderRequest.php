<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends BaseRequest
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
            //TODO status güncelle 
            'status' => 'required|string|in:pending,completed,canceled', // Durum değerleri örnek
        ];
    }

    public function messages()
    {
        return [
            'status.required' => 'Sipariş durumu belirtilmelidir.',
            'status.in' => 'Geçersiz sipariş durumu.',
        ];
    }
}
