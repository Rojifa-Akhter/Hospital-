<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UniformWorklistRequest extends FormRequest
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
            'item_no_fk'    => 'required|array',
            'qty'           => 'required|array',
            'remarks'       => 'nullable',
            'person_no_fk'  => 'required|exists:hrms_personnel,person_no_pk'
        ];
    }
}
