<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            'menu_id' => 'required|string',
            'menu_name' => 'required|string',
            'page_link' => 'required',
            'parent_menu' => 'required',

            
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
            'menu_id.required' => 'Menu ID is required',
            'menu_name.required' => 'Menu name is required',
            'page_link.required' => 'Page link is required',
            'parent_menu.required' => 'Parent menu is required',
        ];
    }
}
