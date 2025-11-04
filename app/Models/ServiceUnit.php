<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceUnit extends Model
{
    protected $table        = 'sysc_serviceunit';
    protected $primaryKey   = 'serviceunit_no_pk';
    public $sequence        = 'sysc_serviceunit_no_pk_seq';


    protected $guarded = ['serviceunit_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = [
        'serviceunit_code', 'serviceunit_no_parent_fk', 'serviceunit_name', 'report_header', 'serviceunit_hod_person_no_fk', 'clinical_ind', 'status', 'au_entry_by', 'cash_counter_ind', 'pharmacy_ind', 'cash_counter_ind', 'duty_area_ind', 'external_hosp_su_ind', 'med_store_ind', 'au_entry_hospital_pk_no',
        'radiology_ind',
        'pathology_ind', 'ipd_ind',
        'ot_ind', 'lp_ind',
        'hospital_store_ind', 'dental_ind',
        'eye_ind', 'physio_ind', 'hs_pos_ind', 'sl_no','fin_mapping_ind', "main_store_ind",
        "sub_store_ind", "asset_ind", "asset_sub_store_ind", "emergency_daycare_ind_txt", "hr_unit_ind", "hr_dept_ind", "hk_ind","serviceunit_no_pk"
    ];
}
