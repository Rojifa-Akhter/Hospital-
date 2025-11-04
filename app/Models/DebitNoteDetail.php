<?php

namespace App\Models;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

/**
 * @property int $debitnotedtl_no_pk
 *
 * @property int|null $journalmst_no_pk
 * @property string|null $journal_code
 * @property \Carbon\Carbon|null $journal_date
 *
 * @property int|null $subledger_typeno_fk
 * @property int|null $subledger_no_fk
 * @property int|null $account_no_fk
 * @property float|null $cr_amt
 * @property float|null $dr_amt
 * @property int|null $payment_flag
 * @property int|null $status
 *
 * @property int $au_entry_by
 * @property \Carbon\Carbon $au_entry_at
 * @property string $au_entry_session
 * @property int $au_entry_hospital_pk_no
 * @property int|null $au_update_by
 * @property \Carbon\Carbon|null $au_update_at
 * @property string|null $au_update_session
 * @property int|null $au_update_hospital_pk_no
 * @property int|null $au_sync_hospital_pk_no
 * @property \Carbon\Carbon|null $au_sync_at
 */
class DebitNoteDetail extends Eloquent
{
    protected $connection = 'oracle';

    protected $table = 'acct_debitnotedtl';

    protected $primaryKey = 'debitnotedtl_no_pk';

    protected $keyType = 'int';

    public $incrementing = true;

    public $sequence = 'acct_debitnotedtl_seq';

    public $timestamps = false;

    protected $guarded = [];

    public function journalHeader()
    {
        return $this->belongsTo(
            MasterJournalEntry::class,
            'journalmst_no_pk',
            'journalmst_no_pk'
        );
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}