<?php

namespace App\Http\Requests\dashboard_user\Products;

use Illuminate\Foundation\Http\FormRequest;

class validationimageProductRequest extends FormRequest
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
            'image' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'image.required' =>__('Dashboard/products.imagerequired'),
        ];
    }
}
