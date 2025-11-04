<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DrugDiseaseRequest extends FormRequest
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
            'drug_name' => 'required',
            'interaction_disease_name' => 'required',
            'severity_department'=> 'required'            
        ];
    }

    public function messages()
    {
        return [
            'drug_name.required' => 'Drug name is required',
            'interaction_disease_name.required' => 'Dissease name is required',
            'severity_department.required' => 'Severiaty text is required'
        ];
    }
}