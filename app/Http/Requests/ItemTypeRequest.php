<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemTypeRequest extends FormRequest
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
            'item_type_name' => 'required|string',
            'parent_type' => 'required',
            'item_serial_number' => 'required',
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
            'item_type_name.required' => 'Item Type is required',
            'parent_type.required' => 'Parent Type is required',
            'item_serial_number.required' => 'Item Serial No is required'
        ];
    }

}
