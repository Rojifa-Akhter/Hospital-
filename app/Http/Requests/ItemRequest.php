<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'item_name' => 'required|string',
            'item_type' => 'required|not_in:0',
            'item_sales_price' => 'required|numeric',
            'service_unit' => [
                Rule::requiredIf(function () {
                    return $this->input('item_type') === 'RAD';
                }),
            ],
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'item_code.required' => 'Item Code is required',
            'item_name.required' => 'Item Name is required',
            'item_type.required' => 'Item Type is required',
            // 'item_short_name.required' => 'Item Short Name is required',
            'item_sales_price.required' => 'Item Sales Price is required',
            'service_unit.required' => 'Service unit is required when item type is RAD.',
        ];
    }

}
