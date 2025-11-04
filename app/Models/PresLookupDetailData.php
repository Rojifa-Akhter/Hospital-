<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class PresLookupDetailData extends Model
{
    protected $table = 'pres_lookupdata_dtl1';
    protected $primarykey = 'pres_lookupdatadtl1_no_pk';
    public $sequence = 'pat_tracking_no_seq';
    protected $guarded = ['pres_lookupdatadtl1_no_pk'];
    protected $fillable = [
       'pres_lookupdatadtl1_no_pk', 
       'input_type',
       'psn_lookupdata_no_fk',
       'su_no_fk',
       'detail_name',
       'status',
       'au_entry_by',
       'au_entry_hospital_pk_no',
       'au_entry_session'
   ];
   public $incrementing = false;

   const created_at = 'au_entry_at';

   const updated_at = 'au_update_at';

}
