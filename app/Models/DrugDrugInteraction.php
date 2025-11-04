<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrugDrugInteraction extends Model
{
    protected $table        = 'emr_drug_drug_interact';
    protected $primaryKey   = 'drug_drug_interact_no_pk';
    public $sequence        = 'sys_personnel_seq';


    protected $guarded = ['lookuplist_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['drug_name', 'interact_drug_name', 'interaction_alert_msg', 'severiaty_text','au_entry_at','au_update_at'];


}
