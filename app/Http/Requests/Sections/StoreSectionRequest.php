<?php

namespace App\Http\Requests\Sections;

use Illuminate\Foundation\Http\FormRequest;

class StoreSectionRequest extends FormRequest
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
            'section_en' => 'required|unique:section,section->en',
            'section_ar' => 'required|unique:section,section->ar',
        ];
    }

    public function messages()
    {
        return [
            'section_en.required' =>__('sectionenrequired'),
            'section_en.unique' =>__('sectionenunique'),
            'section_ar.required' =>__('sectionenrequired'),
            'section_ar.unique' =>__('sectionenrequired'),
        ];
    }
}
