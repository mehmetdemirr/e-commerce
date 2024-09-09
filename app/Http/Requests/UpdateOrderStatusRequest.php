<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusRequest extends BaseRequest
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
            'order_status' => 'required|string|in:' . implode(',', \App\Enum\OrderStatusEnum::getStatuses()),
        ];
    }

    public function messages()
    {
        return [
            'status.string' => 'Sipariş durumu geçerli bir dize olmalıdır.',
            'order_status.required' => 'Sipariş durumu belirtilmelidir.',
            'order_status.in' => 'Geçersiz sipariş durumu.',
        ];
    }
}
