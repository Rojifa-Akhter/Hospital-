<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemTypeWorkflowRequest extends FormRequest
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
            "WORKFLOW_NO_PK"            => 'nullable',
            "workflow_code"             => 'required',
            "workflow_name"             => 'required',
            "service_point_su_no_fk"    => 'required',
            "service_billing_ind"       => 'nullable',
            "pharmacy_billing_ind"      => "nullable",
            "emergency_billing_ind"     => "nullable",
            "daycare_billing_ind"       => "nullable",
            "ot_billing_ind"            => "nullable",
            "carpark_billing_ind"       => "nullable",
            "cafeteria_billing_ind"     => "nullable",
            "optical_shop_billing_ind"  => "nullable",
            "workflow_desc"             => 'required',
            "au_entry_at"               => 'nullable',
            "au_entry_by"               => 'nullable',
            "au_entry_hospital_pk_no"   => 'nullable',
            "AU_ENTRY_SESSION"          => 'nullable',
            "status"                    => 'nullable',
        ];
    }
}
