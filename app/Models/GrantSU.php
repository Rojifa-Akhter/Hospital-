<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrantSU extends Model
{
    //

    protected $table        = 'sysc_grant_su'; //SYS_GRANT_SU
    protected $primaryKey   = 'grantsu_no_pk';
    public $sequence        = 'sys_grant_su_seq';

    protected $guarded = ['grantsu_no_pk'];

    const CREATED_AT = 'AU_ENTRY_AT';
    const UPDATED_AT = 'AU_UPDATE_AT';

    protected $fillable = ['user_no_fk','su_no_fk','default_ind','samaple_receive_ind','save_ind','verify_ind','finalize_ind','preview_ind','print_final_ind','result_edit_ind','all_su_ind','status','au_entry_by','au_entry_hospital_no_fk','hod_ind','labresult_list1_ind','labresult_list2_ind','labresult_list3_ind','labresult_list4_ind','labresult_list5_ind', 'hr_dept_ind', 'hr_unit_ind'];

}