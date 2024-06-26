<?php

namespace App\Http\Requests\dashboard_user\Sections;

use Illuminate\Foundation\Http\FormRequest;

class StorechildrenRequest extends FormRequest
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
            'name_en' => 'required|unique:sections,name->en',
            'name_ar' => 'required|unique:sections,name->ar',
            'section_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name_en.required' =>__('Dashboard/sections_trans.nameenrequired'),
            'name_en.unique' =>__('Dashboard/sections_trans.nameenunique'),
            'name_ar.required' =>__('Dashboard/sections_trans.namearrequired'),
            'name_ar.unique' =>__('Dashboard/sections_trans.namearunique'),
            'section_id.required' =>__('Dashboard/sections_trans.sectionidrequired'),
        ];
    }
}
