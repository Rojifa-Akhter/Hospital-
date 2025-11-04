<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RadiologyItemRequest extends FormRequest
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
           'item_name' => 'required',
           'item_no_barcode'  => 'required'
        ];
    }
    public function messages(){
        return[
            'item_name.required' => 'Item Name is Required',
            'item_no_barcode.required' => 'Item Code is Required',
        ];
    }
}
