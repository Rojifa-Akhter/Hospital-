<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PabxAppointmentRequest extends FormRequest
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
            "patient_type"          => "required",
            "patient_code"          => "nullable",
            "hdn_patient_id"        => "nullable",
            "patient_salutation"    => "nullable",
            "patient_first_name"    => "nullable",
            "patient_last_name"     => "nullable",
            "appoint_date"          => "required",
            "doctor_no_fk"          => "required",
            "sex"                   => "required",
            "mobile_no"             => "required",
            "dob"                   => "required"
        ];
    }
}
