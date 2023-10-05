<?php

namespace App\Http\Requests\Sections;

use Illuminate\Foundation\Http\FormRequest;

class UpdatechildrenRequest extends FormRequest
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
            'name_'.app()->getLocale() => 'required|unique:sections,name->'.app()->getLocale(),
            'section_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name_'.app()->getLocale().'.required' =>__('Dashboard/sections_trans.namechrequired'),
            'name_'.app()->getLocale().'.unique' =>__('Dashboard/sections_trans.namechunique'),
            'section_id.required' =>__('Dashboard/sections_trans.sectionidrequired'),
        ];
    }
}
