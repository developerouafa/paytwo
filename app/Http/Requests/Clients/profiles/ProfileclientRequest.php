<?php

namespace App\Http\Requests\Clients\Profiles;

use Illuminate\Foundation\Http\FormRequest;

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
            // 'name' => ['string', 'max:255'],
        ];
    }
}
