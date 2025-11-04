<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradeRequest extends FormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'grade_name' => 'required|string',
            'gross_salary' => 'required|string',
            'basic_salary' => 'required',
            'house_rent' => 'required|not_in:0',
            'conveyance_allow' => 'required',
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
            'grade_name.required' => 'Grade Name is required',
            'gross_salary.required' => 'Gross Salary is required',
            'basic_salary.required' => 'Basic Salary is required',
            'house_rent.required' => 'House Rent is required',
            'conveyance_allow.required' => 'Conveyance allowance is required'
        ];
    }
}
