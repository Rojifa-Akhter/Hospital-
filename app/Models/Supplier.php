<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
	protected $table        = 'inv_supplier';
	protected $primaryKey   = 'supplier_no_pk';
	public $sequence        = 'sys_supplier_seq';


	protected $guarded = ['supplier_no_pk'];

	const CREATED_AT = 'au_entry_at';
	const UPDATED_AT = 'au_update_at';

	protected $fillable = [
		'supplier_no_pk',
		'supplier_uid',
		'supplier_name',
		'company_name',
		'descr',
		'addr1',
		'addr2',
		'mobile1',
		'mobile2',
		'phone',
		'fax',
		'e_mail',
		'web',
		'contact_person',
		'cp_jobtitle',
		'cp_phone',
		'remarks',
		'foreign_flag',
		'manufecturer_flag',
		'country_no',
		'sup_type',
		'status',
		'au_entry_at',
		'au_update_at',
		'au_entry_hospital_pk_no',
		'au_update_hospital_pk_no',
		'acct_subledger_no_fk',
		'supp_type_lookup_no_fk',
		'file_no',
		'cp_email',
		'pharmacy_ind',
		'inventory_ind',
		'bank_account_name',
		'bankaccount',
		'bank_no_fk',
		'bank_branch_name',
		'routing',   // ✅ New Columns
		'supp_tin',
		'supp_tin_image_path',
		'supp_bin',
		'supp_bin_image_path',
		'supp_tradelicense_image_path',
		'trade_license',
	];
}
