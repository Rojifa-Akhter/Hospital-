<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            // 'room_code' => 'required|string',
            'room_name' => 'required|string',
            // 'category_lookup' => 'required',
            'serviceunit_no_fk' => 'required',
            // 'room_capacity' => 'required|numeric',
            // 'room_size' => 'required'
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
            // 'room_code.required' => 'Room code is required',
            'room_name.required' => 'Room name is required',
            // 'category_lookup.required' => 'Room category is required',
            'serviceunit_no_fk.required' => 'Service unit is required',
            // 'room_capacity.numeric' => 'Room capacity is must be number',
            // 'room_size.required' => 'Room size is required'
        ];
    }
}
