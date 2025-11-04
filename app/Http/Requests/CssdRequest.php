<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CssdRequest extends FormRequest
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
            "serviceunit_no_fk" => "required|numeric|exists:SYSC_SERVICEUNIT,SERVICEUNIT_NO_PK",
            "req_date"          => "required|date",
            "item_no_fk"        => "required|array",
            "item_no_fk.*"      => "required|numeric|exists:SYSC_SERVICEITEM,ITEM_NO_PK",
            "item_qty"          => "required|array",
            "item_qty.*"        => "required|numeric|min:0",
            "item_remarks"      => "required|array",
            "item_remarks.*"    => "nullable",
            "remarks"           => "nullable",
        ];
    }
}
