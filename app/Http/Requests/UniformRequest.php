<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UniformRequest extends FormRequest
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
            'serviceunit_no_fk' => 'nullable',
            'designation_no_fk' => 'required',
            'uniform_qty'       => 'required',
            'shoe_qty'          => 'required',
            'winteruniform_qty' => 'required',
            'status'            => 'required',
        ];
    }
}
