<?php

namespace App\Models;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;
use Carbon\Carbon;

/**
 * @property int $fund_transfer_pk
 *
 * @property int $mst_fund_transfer_fk
 * @property int $account_fk
 * @property int $journal_entry_fk
 * @property string|null $direction  Direction of transaction ('DR' or 'CR')
 * @property float|null $dr_amount
 * @property float|null $cr_amount
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @property \App\Models\MasterFundTransfer|null $masterFundTransfer
 */
class FundTransfer extends Eloquent
{
    protected $connection = 'oracle';

    protected $table = 'fund_transfers';

    protected $primaryKey = 'fund_transfer_pk';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    protected $guarded = [];

    public function masterFundTransfer()
    {
        return $this->belongsTo(
            MasterFundTransfer::class,
            'mst_fund_transfer_fk',
            'mst_fund_transfer_pk'
        );
    }
}