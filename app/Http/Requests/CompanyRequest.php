<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'hospital_name' => 'required|string',
            'hospital_telephone1' => 'required|string',
            'hospital_email' => 'required|email',
            'hospital_group_name' => 'nullable|numeric',
            'thana' => 'nullable|numeric',
            'district' => 'nullable|numeric',
            'division' => 'nullable|numeric',
            'country' => 'nullable|numeric',
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
            'hospital_name.required' => 'Hospital Name is required',
            'hospital_telephone1.required' => 'Hospital telephone no -1 is required',
            'hospital_email.required' => 'Hospital Email is required'
        ];
    }
}
