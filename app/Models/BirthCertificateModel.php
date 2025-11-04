<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BirthCertificateModel extends Model
{
    protected $table        = 'ipd_patient_certificates';
    protected $primaryKey   = 'certificate_pk_no';
    public $sequence        = 'certificate_pk_no_seq';


    protected $guarded = ['certificate_pk_no'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['admission_no_fk', 'au_entry_at', 'au_entry_by', 'au_entry_hospital_no_fk', 'au_entry_session', 'au_sync_at', 'au_sync_hospital_no_fk', 'au_update_at', 'au_update_by', 'au_update_hospital_no_fk', 'au_update_session', 'certificate_date', 'certificate_json', 'certificate_lookup_no_fk', 'certificate_name', 'certificate_pk_no', 'certificate_text', 'certificate_uid', 'delivered_at', 'delivered_by', 'delivered_ind', 'delivered_mobile', 'delivered_to_date', 'delivered_to_name', 'director_person_no_fk', 'lookupdata_code', 'medical_officer_person_no_fk', 'patient_no_fk', 'prepared_at', 'prepared_by', 'prepared_ind', 'prescription_no_fk', 'status', 'verified_at', 'verified_by', 'verified_ind'];
}
