<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrantSuRequest extends FormRequest
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
            'grantuser_user'   => ['required'|'not_in:0'],
            'grantuser_department'  => ['required']
        ];
    }

    public function messages()
    {
        return [
            'grantuser_user.required' => 'Speciality is required',
            'grantuser_user.not_in' => 'User Name Cannot be null',
        ];
    }

}
