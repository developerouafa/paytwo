<?php

namespace App\Http\Requests\dashboard_user;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name_'.app()->getLocale() => 'required',
            'phone' => ['required', 'regex:/(0)[0-9]{6}/', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('Dashboard/users.namerequired'),
            'phone.required' =>__('Dashboard/clients_trans.phoneisrequired'),
            'phone.unique' =>__('Dashboard/clients_trans.phoneisunique'),
        ];
    }
}
