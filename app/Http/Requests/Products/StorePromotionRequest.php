<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class StorePromotionRequest extends FormRequest
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
            'price' => 'required|between:1,99999999999999',
            'start_time' => 'required',
            'end_time' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'price.required' =>__('Dashboard/products.priceisrequired'),
            'price.between' =>__('Dashboard/products.priceislow'),
            'start_time.required' =>__('Dashboard/products.start_timerequired'),
            'end_time.required' =>__('Dashboard/products.end_timerequired'),
        ];
    }
}
