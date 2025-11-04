<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BBDDonorDetails extends Model
{
    protected $table        = 'bbd_donor_details';
    protected $primaryKey   = 'donordtl_no_pk';
    public $sequence        = 'donordtl_no_pk_seq';
    protected $guarded = ['donordtl_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = [
        'donordtl_uid','donor_no_fk','hemoglobin','bp','pulse','blood_group','temparture','hep_jaundice','malaria','rabies','heart_disease','diabetes_polyuria','sex_trans_infec','asthma','eczema_skin_dis','hypertension','kidney_disease','tuberculosis_tb','piles','cancer','peptic_ulcer','typhoid','viral_fever','syphilis','gastric_ulcer','bloodborne_diseases','dengue_fever','measlesormumps','abortion_occurred','rec_wt_loss','currently_pregnant','breastfeeding_mother','mens_w_sixm','undergone_msw_fourw','removed_tooth_wfw','received_vac_or_inj','donated_blood_wow','taken_aspirin_or_sm','substance_abuse','con_intoxic_subordrugs','traveled_abroad','currently_tam','reg_interested_vbd','currently_fh','consumed_food','status','blood_requisition_no_fk','had_accidnt_injury','is_selected_donate','rec_unscr_bld','taking_narcotic_inta_drg','sexual_interc_habits','donor_weight', 'donated_past', 'feeling_today_well', 'discomfort_donation', 'surgery_history', 'safe_sex', 'suffered_from', 'did_you_suffer', 'last_menstrual_date', 'menstrual_problem', 'pregnant', 'breast_feeding', 'abortion'  
];
}
