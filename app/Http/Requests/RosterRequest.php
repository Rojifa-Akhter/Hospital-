<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RosterRequest extends FormRequest
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
            'personal_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
           

            
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
            'personal_id.required' => 'Employee name is required',
            'start_date.required' => 'From Date is required',
            'end_date.required' => 'To Date is required'
            
        ];
    }
}
