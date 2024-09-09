<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentStatusRequest extends BaseRequest
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
            'payment_status' => 'required|string|in:' . implode(',', \App\Enum\PaymentStatusEnum::getStatuses()),
        ];
    }

    public function messages()
    {
        return [
            'payment_status.string' => 'Ödeme durumu geçerli bir dize olmalıdır.',
            'payment_status.required' => 'Ödeme durumu belirtilmelidir.',
            'payment_status.in' => 'Geçersiz ödeme durumu.',
        ];
    }
}
