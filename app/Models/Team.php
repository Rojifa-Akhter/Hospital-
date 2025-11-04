<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'hrms_sales_team';
    protected $primaryKey = 'team_no_pk';
    public $sequence = 'team_no_pk_seq';

    protected $guarded = ['team_no_pk'];
    protected $fillable = [
        'team_no_pk',
        'team_name',
        'au_entry_by',
        'au_entry_hospital_pk_no',
        'au_entry_session'
    ];
    public $incrementing = false;

    const created_at = 'au_entry_at';

    const updated_at = 'au_update_at';

}
