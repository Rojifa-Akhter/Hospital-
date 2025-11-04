<?php

namespace App\Models;

use App\User;
use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

/**
 * @property int $journalmst_no_pk
 *
 * @property string|null $journal_code
 * @property \Carbon\Carbon|null $journal_date
 * @property \Carbon\Carbon|null $doc_date
 * @property string|null $voucher_remarks
 * @property string|null $journal_tracking
 *
 * @property int|null $sub_ledger_type_no_fk
 * @property int|null $sub_ledger_no_fk
 * @property float|null $cr_account_amount
 * @property float|null $dr_account_amount
 *
 * @property int|null $voucher_type_no_fk
 * @property int|null $module_no_fk
 * @property int|null $counter_su_no_fk
 *
 * @property int|null $auto_posting_ind
 * @property string|null $auto_posting_ref_value
 * @property int|null $auto_posting_ref_by
 * @property string|null $auto_posting_ref_type
 * @property int|null $verify_req_ind
 * @property int|null $verified_ind
 * @property int|null $verified_entry_by
 * @property \Carbon\Carbon|null $verified_entry_at
 * @property int|null $finalized_ind
 * @property int|null $finalized_entry_by
 * @property \Carbon\Carbon|null $finalized_entry_at
 * @property int|null $status
 *
 * @property string|null $file_name1
 * @property string|null $file_name2
 * @property string|null $file_name3
 * @property string|null $file_path1
 * @property string|null $file_path2
 * @property string|null $file_path3
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
 *
 * @property AcctVoucherType|null $voucherType
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\AcctJournalEntry> $journalEntries
 */
class MasterJournalEntry extends Eloquent
{
    protected $connection = 'oracle';

    protected $table = 'acct_journal_entrymst';

    protected $primaryKey = 'journalmst_no_pk';

    protected $keyType = 'int';

    public $incrementing = false;

    public $sequence = 'journalmst_no_pk_seq';

    public $timestamps = false;

    protected $guarded = [];

    public function voucherType()
    {
        return $this->belongsTo(
            VoucherType::class,
            'voucher_type_no_fk',
            'voucher_type_no_pk'
        );
    }

    public function journalEntries()
    {
        return $this->hasMany(
            JournalEntry::class,
            'journalmst_no_fk',
            'journalmst_no_pk'
        );
    }
    
    public function createdBy()
    {
        return $this->belongsTo(
            User::class,
            'au_entry_by',    
            'user_no_pk'      
        );
    }

    public function adjustmentDetails()
    {
        return $this->hasMany(
            AccountAdjustmentDetail::class,
            'mst_journal_entry_no_fk',
            'journalmst_no_pk'
        );
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
