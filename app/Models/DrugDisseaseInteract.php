<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class DrugDisseaseInteract extends Model
{
    
    protected $table        = 'emr_drug_dissease_interact';
    protected $primaryKey   = 'drug_dissease_interact_no_pk';
    public $sequence        = 'emr_drug_dissease_interact_seq';


    protected $guarded = ['drug_dissease_interact_no_pk'];

    const CREATED_AT = 'au_entry_at';
    const UPDATED_AT = 'au_update_at';

    protected $fillable = ['drug_item_no_fk','drug_name','dissease_prs_lookuplist_no_fk','dissease_name','interaction_alert_msg','severiaty_ind','severiaty_text','status','au_entry_by','au_entry_at','au_entry_session','au_entry_hospital_no_fk'];
}
