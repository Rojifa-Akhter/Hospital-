<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcctChartOfAccount extends Model
{
    const ACCOUNT_TYPE_CASH = 'Cash';
    const ACCOUNT_TYPE_BANK = 'Bank';

    const STATUS_ACTIVE   = 1;
    const STATUS_INACTIVE = 0;

    protected $table = 'acct_chart_of_accounts';
    protected $primaryKey = 'account_no_pk';

    public $timestamps = false;

    public function childs()
    {
        return $this->hasMany(
            AcctChartOfAccount::class,
            'account_no_fk_root_0',
            'account_no_pk'
        );
    }
}

