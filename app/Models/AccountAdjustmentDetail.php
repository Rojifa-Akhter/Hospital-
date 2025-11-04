<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $adjustment_detail_no_pk
 *
 * @property string $adjustment_type
 * @property int|null $mst_journal_entry_no_fk
 * @property string $journal_code
 * @property \Carbon\Carbon|null $journal_date
 * @property int|null $account_no_fk
 * @property float|null $cr_amount
 * @property float|null $dr_amount
 * @property int|null $hospital_no_fk
 * @property int|null $created_by
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class AccountAdjustmentDetail extends Model
{   
    const ADJUSTMENT_TYPE_DEBIT = 'debit';
    const ADJUSTMENT_TYPE_CREDIT = 'credit';

    protected $connection = 'oracle';

    protected $table = 'account_adjustment_details';

    protected $primaryKey = 'adjustment_detail_no_pk';

    protected $keyType = 'int';

    public $incrementing = true;

    public $sequence = 'account_adjustment_details_seq';

    public $timestamps = true;

    protected $guarded = [];

    public function journalHeader()
    {
        return $this->belongsTo(
            MasterJournalEntry::class,
            'mst_journal_entry_no_fk',
            'journalmst_no_pk'
        );
    }

    public function account()
    {
        return $this->belongsTo(
            AcctChartOfAccount::class,
            'account_no_fk',
            'account_no_pk'
        );
    }

    public function createdBy()
    {
        return $this->belongsTo(
            \App\User::class,
            'created_by',    
            'user_no_pk'      
        );
    }
}