<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuFeaturesRequest extends FormRequest
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
         'module_menu'   => 'required',
           'Features_id' => 'required',
           'features_name' => 'required',
            
            
        ];
    }

    public function messages()
    {
        return [
            'module_menu.required' => 'module name is required',
            'Features_id.required' => 'Features id is required',
            'features_name.required' => 'features name is required',
            
        ];
    }
}
