<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuPrivilegeRequest extends FormRequest
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
                'user_name' => 'required',
                'menu_name'   => 'required',
                'module_name' => 'required',
              
                   
                   
               ];
        
    }

    public function messages()
    {
        return [
            'user_name.required' => 'user nameis required',
            'menu_name.required' => 'menu name is required',
            'module_name.required' => 'module name id is required',
           
            
        ];
    }
}
