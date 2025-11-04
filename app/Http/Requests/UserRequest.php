<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'user_full_name' => 'required|string|max:100',
            // 'user_email' => 'required|email|unique:wsec_user,email,'. $this->id. ',user_no_pk',
            // 'user_email' => 'required|email|unique:wsec_user,email,'. $this->id. ',user_no_pk',
            
            // 'user_email' => 'required|email|unique:wsec_user,email',
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
            'user_full_name.required' => 'User Full Name is required'
        ];
    }
}
