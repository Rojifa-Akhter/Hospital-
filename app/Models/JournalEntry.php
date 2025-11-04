<?php

namespace App\Models;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

/**
 * @property int $journal_no_pk
 * @property int|null $acct_journal_entry_no_pk
 *
 * @property string|null $journal_code
 * @property \Carbon\Carbon|null $journal_date
 * @property string|null $narration_text
 * @property string|null $voucher_remarks
 * @property string|null $source_code
 *
 * @property int|null $trn_account_no_fk
 * @property string|null $trn_account_code
 * @property float|null $trn_cr_account_amount
 * @property float|null $trn_dr_account_amount
 * @property string|null $trn_type_code
 * @property int|null $is_contra
 *
 * @property int|null $voucher_type_no_fk
 * @property int|null $journalmst_no_fk
 * @property int|null $ledger_no_fk
 * @property int|null $supledger_no_fk
 * @property int|null $acct_subledger_no_fk
 * @property int|null $acct_subledger_type_fk
 * @property int|null $ledger_paymood_no_fk
 * @property int|null $ledgertrn_no_fk
 * @property int|null $costcenter_no_fk
 * @property int|null $monthly_salary_no_fk
 * @property int|null $person_no_fk
 * @property int|null $supplier_no_fk
 * @property int|null $invoice_no_fk
 * @property int|null $patient_no_fk
 * @property int|null $item_no_fk
 * @property int|null $admission_no_fk
 * @property int|null $module_no_fk
 * @property int|null $counter_su_no_fk
 * @property int|null $journal_no
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
 * @property string|null $bank_cheq_number
 * @property \Carbon\Carbon|null $bank_cheq_date
 *
 * @property AcctVoucherType|null $voucherType
 * @property AcctJournalEntryMst|null $journalHeader
 */
class JournalEntry extends Eloquent
{
    protected $connection = 'oracle';

    protected $table = 'acct_journal_entry';

    protected $primaryKey = 'journal_no_pk';

    protected $keyType = 'int';

    public $incrementing = true;

    public $sequence = 'journal_no_pk_seq';

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

    public function journalHeader()
    {
        return $this->belongsTo(
            MasterJournalEntry::class,
            'journalmst_no_fk',
            'journalmst_no_pk'
        );
    }

    public function account()
    {
        return $this->belongsTo(
            AcctChartOfAccount::class,
            'trn_account_no_fk',
            'account_no_pk'
        );
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
