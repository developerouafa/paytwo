<?php

namespace App\Http\Requests\dashboard_user;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => ['required'],
            'credit' => ['required'],
            'description' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'client_id.required' => __('Dashboard/payment_trans.nameisrequired'),
            'credit.required' =>__('Dashboard/payment_trans.amountisrequired'),
            'description.required' =>__('Dashboard/payment_trans.descisunique'),
        ];
    }
}
