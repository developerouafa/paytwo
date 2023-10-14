<?php

namespace App\Http\Requests\dashboard_user;

use Illuminate\Foundation\Http\FormRequest;

class receiptRequest extends FormRequest
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
            'amount' => ['required'],
            'description' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'client_id.required' => __('Dashboard/receipt_trans.nameisrequired'),
            'amount.required' =>__('Dashboard/receipt_trans.phoneisrequired'),
            'description.required' =>__('Dashboard/receipt_trans.phoneisunique'),
        ];
    }
}
