<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PateintRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pat_f_name' => 'required|string',
            // 'pat_age_y' => 'required',
            //'mobile_no' => 'required|string|max:50',
           
            // 'pat_gender' => 'required|not_in:0',
            // 'pat_religion' => 'required|not_in:0',

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
            'pat_f_name.required' => 'Patient Name is required.',
            'phone_no.required' => 'Patient Phone No is required.',
            // 'pat_age_y.required' => 'Patient Age is required.',
            // 'pat_gender.required' => 'Patient Gender is required.',
            // 'pat_religion.required' => 'Patient Religion is required.'
        ];
    }
}
