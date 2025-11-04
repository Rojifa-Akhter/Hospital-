<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorScheduleRequest extends FormRequest
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
            'doctor_speciality' => 'required|not_in:0',
            'doctor_name' => 'required|not_in:0',
            'from_date' => 'required',
            'to_date' => 'required',
            'shift_type' => 'required|not_in:0',
            'shift_start_time' => 'required',
            'shift_end_time' => 'required',

            
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
            'doctor_speciality.required' => 'Speciality is required',
            'doctor_speciality.not_in' => 'Speciality is required',
            'doctor_name.required' => 'Doctor name is required',
            'doctor_name.not_in' => 'Doctor name is required',
            'to_date.required' => 'Schedule to date is required',
            'from_date.required' => 'Schedule from date is required',
            'shift_type.required' => 'Shift type is required',
            'shift_type.not_in' => 'Shift type is required',
            'shift_start_time.required' => 'Shift start time is required',
            'shift_end_time.required' => 'Shift end time is required',
        ];
    }
}
