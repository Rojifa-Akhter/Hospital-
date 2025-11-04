<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PathologyItemSetupRequest extends FormRequest
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
         'exam_setup_item_id' => 'required',
         'exam_item_name' => 'required',
     ];
 }
 public function messages()
    {
        return [
            'exam_setup_item_id.required' => 'Item I is required',
            'exam_item_name.required' => 'Item Name is required',
        ];
    }
}
