<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $petty_cash_funding_no_pk
 * @property int $mst_journal_entry_no_fk
 * @property string $journal_code
 * @property \Carbon\Carbon $journal_date
 * @property int $bank_account_no_fk
 * @property int $petty_account_no_fk
 * @property float $amount
 * @property int $hospital_no_pk
 * @property int $created_by
 * @property string|null $remarks
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class PettyCashFunding extends Model
{   
    protected $connection = 'oracle';

    protected $table = 'petty_cash_funding';

    protected $primaryKey = 'petty_cash_funding_no_pk';

    protected $keyType = 'int';

    public $incrementing = true;

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

    public function bankAccount()
    {
        return $this->belongsTo(
            AcctChartOfAccount::class,
            'bank_account_no_fk',
            'account_no_pk'
        );
    }

    public function pettyAccount()
    {
        return $this->belongsTo(
            AcctChartOfAccount::class,
            'petty_account_no_fk',
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