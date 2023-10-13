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
