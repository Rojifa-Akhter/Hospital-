<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamBuild extends Model
{
    protected $table = 'hrms_team_build';
    protected $primaryKey = 'team_build_no_pk';
    public $sequence = 'team_build_no_pk_seq';

    protected $guarded = ['team_build_no_pk'];
    protected $fillable = [
        'team_build_no_pk',
        'team_no_pk',
        'employee_no_fk',
        'area_no_fk',
        'status',
        'au_entry_by',
        'au_entry_hospital_pk_no',
        'au_entry_session'
    ];
    public $incrementing = false;

    const created_at = 'au_entry_at';

    const updated_at = 'au_update_at';

}
