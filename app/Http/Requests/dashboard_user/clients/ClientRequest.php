<?php

namespace App\Http\Requests\dashboard_user\clients;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
        // validations
        return [
            'name' => 'required',
            'phone' => 'required|unique:clients,phone|regex:/(0)[0-9]{6}/',
        ];
    }

    public function messages()
    {
        return [
            'name' => __('Dashboard/clients_trans.nameisrequired'),
            'phone.required' =>__('Dashboard/clients_trans.phoneisrequired'),
            'phone.unique' =>__('Dashboard/clients_trans.phoneisunique'),
        ];
    }
}
