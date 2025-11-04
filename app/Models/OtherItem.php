<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherItem extends Model
{

	protected $table        = 'SYSC_SERVICEITEM';
    protected $primaryKey   = 'item_no_pk';
    public $sequence        = 'sysc_serv_item_no_pk_seq';


    protected $guarded = ['item_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['item_code','item_name','item_short_name','generic_no_fk','itemtype_no_fk','serviceunit_no_fk','item_type','sales_price','manufacturer_no_fk','vat_percent','uom_no_fk','item_cat_lookupdata_no_fk','item_sub1cat_lookupdata_no_fk','item_sub2cat_lookupdata_no_fk','item_cat_lookupdata_no_fk','item_subcat_lookupdata_no_fk','normal_delivery_hour','urgent_delivery_hour','no_of_label','testbygender_ind','sc_min_volume','report_group','default_analyzer_no_fk','sam_no_fk','container_ind','report_header','test_temp_no_fk','sc_instructions','test_method','note_text','interpretation','comments_text','plain_text','active_stat','status',
'purchase_price','anaesthesia_cat_ind','ot_service_ind','expireable','dk_current_ind','in_box_qty'];
}
