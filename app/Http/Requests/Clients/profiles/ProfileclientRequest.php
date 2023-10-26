<?php

namespace App\Http\Requests\Clients\Profiles;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileclientRequest extends FormRequest
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
            'phone' => ['required', 'regex:/(0)[0-9]{6}/', Rule::unique(Client::class)->ignore($this->user()->id)],
            'email' => ['required', Rule::unique(Client::class)->ignore($this->user()->email)],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('Dashboard/clients_trans.nameisrequired'),
            'phone.required' =>__('Dashboard/clients_trans.phoneisrequired'),
            'phone.unique' =>__('Dashboard/clients_trans.phoneisunique'),
            'email.required' =>__('Dashboard/users.emailrequired'),
            'email.unique' =>__('Dashboard/users.emailunique'),
        ];
    }
}
