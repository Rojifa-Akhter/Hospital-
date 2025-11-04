<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemTypeWorkflow extends Model
{
    protected $table        = 'SYSC_ITEMTYPE_WORKFLOW';
    protected $primaryKey   = 'WORKFLOW_NO_PK';
    public $sequence        = 'sysc_itemworkflow_seq';

    protected $guarded      = ['WORKFLOW_NO_PK'];

    const CREATED_AT        = 'AU_ENTRY_AT';
    const UPDATED_AT        = 'AU_UPDATE_AT';

    protected $fillable = [
        "workflow_code",
        "workflow_name",
        "service_point_su_no_fk",
        "service_billing_ind",
        "pharmacy_billing_ind",
        "emergency_billing_ind",
        "daycare_billing_ind",
        "ot_billing_ind",
        "carpark_billing_ind",
        "cafeteria_billing_ind",
        "optical_shop_billing_ind",
        "workflow_desc",
        "au_entry_at",
        "au_entry_by",
        "au_entry_hospital_pk_no",
        "AU_ENTRY_SESSION"
    ];

}
