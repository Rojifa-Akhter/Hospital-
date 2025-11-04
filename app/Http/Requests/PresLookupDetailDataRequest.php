<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PresLookupDetailDataRequest extends FormRequest
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
            'lookup_code' => 'required',
            'lookup_data' => 'required',
            'department'  => 'required',
                  'type'  => 'required',
            'detail_data' => 'required'    

        ];
    }
}
