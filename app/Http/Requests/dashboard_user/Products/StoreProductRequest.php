<?php

namespace App\Http\Requests\dashboard_user\Products;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name_en' => 'required|unique:products,name->en',
            'name_ar' => 'required|unique:products,name->ar',
            'price' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name_en.required' =>__('Dashboard/products.nameenrequired'),
            'name_en.unique' =>__('Dashboard/products.nameenunique'),
            'name_ar.required' =>__('Dashboard/products.namearrequired'),
            'name_ar.unique' =>__('Dashboard/products.namearunique'),
            'price.required' =>__('Dashboard/products.pricerequired'),
        ];
    }
}
