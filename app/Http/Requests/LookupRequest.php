<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LookupRequest extends FormRequest
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
            'lookup_UID' => 'required|string',
            'lookup_name' => 'required|string',
//            'lookup_description' => 'required',
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
            'lookup_UID.required' => 'Lookup ID is required',
            'lookup_name.required' => 'Lookup Name is required',
            'lookup_description.required' => 'Lookup description is required'
        ];
    }
}
