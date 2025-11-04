<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ItemSupplier extends Model
{
	protected $table        = 'SYSC_SERVICEITEM_SUPPLIER';
	protected $primaryKey   = 'SISUPPLIER_NO_PK';
	public $sequence        = 'SISUPPLIER_NO_PK_SEQ';


	protected $guarded = ['SISUPPLIER_NO_PK'];

	const CREATED_AT = 'au_entry_at';
	const UPDATED_AT = 'au_update_at';

	protected $fillable =[ 'SISUPPLIER_NO_PK', 'ITEM_NO_FK', 'SUPPLIER_NO_FK', 'status','au_entry_at',
	'au_update_at','au_entry_hospital_pk_no','au_update_hospital_pk_no'];

}
