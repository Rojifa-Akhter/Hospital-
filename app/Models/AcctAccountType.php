<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcctAccountType extends Model
{
    protected $table = 'acct_account_type';
    protected $id = 'acct_type_no_pk';

    public function childs() {
        return $this->hasMany(AcctChartOfAccount::class,'acct_type_no_fk','acct_type_no_pk') ;
    }
}
