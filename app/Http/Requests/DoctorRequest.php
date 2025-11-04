<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
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
            'doctor_first_name' => 'required|string',
            // 'doctor_last_name' => 'required|string',
          //  'doctor_marital_status' => 'required',
            //'doctor_gender' => 'required',
            //'doctor_religion' => 'required',
            //'doctor_date_of_birth' => 'required',
            //doctor_last_name' => 'required',

           // 'doctor_mobilze' => 'required|string|max:50',
            // 'doctor_email' => 'required|email|unique:hrms_personnel,EMAIL,'. $this->id. ',person_no_pk',
            // 'doctor_passport_no' => 'required',
            //'doctor_email' => 'required|email'
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
            'doctor_first_name.required' => 'Employee Name is required.',
            // 'doctor_last_name.required' => 'Doctor Last is required.',
           // 'doctor_marital_status.required' => 'Matrital Status is required.',
         //   'doctor_mobile.required' => 'Doctor Phone is required.'
            // 'doctor_email.required' => 'Doctor Email is required.',
            // 'doctor_passport_no.required' => 'Doctor Passport is required.',
            //'doctor_email.required' => 'Doctor Email is required.'
        ];
    }
}
