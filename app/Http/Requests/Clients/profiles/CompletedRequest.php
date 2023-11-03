<?php

namespace App\Http\Requests\Clients\Profiles;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompletedRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', Rule::unique(Client::class)->ignore($this->user()->id)],
            'clienType' => ['required'],
            'nationalIdNumber' => ['required'],
            'address' => ['required'],
            'city' => ['required', 'string', 'max:255'],
            'postalcode' => ['required'],

        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('Dashboard/clients_trans.nameisrequired'),
            'email.required' =>__('Dashboard/users.emailrequired'),
            'email.unique' =>__('Dashboard/users.emailunique'),
            'clienType.required' =>__('Dashboard/users.requiredclientype'),
            'nationalIdNumber.required' =>__('Dashboard/users.requirednationalnumber'),
            'address.required' =>__('Dashboard/users.requiredaddress'),
            'city.required' =>__('Dashboard/users.requiredcity'),
            'postalcode.required' =>__('Dashboard/users.requiredpostalcode'),
        ];
    }
}
