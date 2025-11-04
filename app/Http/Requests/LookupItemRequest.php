<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LookupItemRequest extends FormRequest
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
            'lookup_no' => 'required',
            'lookup_list_name' => 'required',
            'lookup_serial' => 'required'
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
            'lookup_no.required' => 'Lookup No is required',
            'lookup_list_name.required' => 'Lookup data name is required',
            'lookup_serial.required' => 'Lookup serial no is required'
        ];
    }
}
