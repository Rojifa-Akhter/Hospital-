<?php

namespace App\Models;

use App\User;
use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;
use Carbon\Carbon;

/**
 * @property int $mst_fund_transfer_pk
 *
 * @property string $transfer_type
 * @property int|null $mst_journal_fk
 * @property string|null $voucher_code
 * @property \Carbon\Carbon|null $transfer_date
 * @property float|null $total_amount
 * @property string|null $created_by
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\FundTransfer> $fundTransfers
 */
class MasterFundTransfer extends Eloquent
{
    protected $connection = 'oracle';

    protected $table = 'mst_fund_transfers';

    protected $primaryKey = 'mst_fund_transfer_pk';

    protected $keyType = 'int';

    public $incrementing = true;

    public $timestamps = false;

    protected $guarded = [];

    public function fundTransfers()
    {
        return $this->hasMany(
            FundTransfer::class,
            'mst_fund_transfer_fk',
            'mst_fund_transfer_pk'
        );
    }

    public function createdBy()
    {
        return $this->belongsTo(
            User::class,
            'created_by',
            'user_no_pk'
        );
    }
}