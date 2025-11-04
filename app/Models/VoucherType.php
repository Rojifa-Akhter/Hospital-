<?php

namespace App\Models;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

/**
 * @property int $voucher_type_no_pk
 * @property string|null $voucher_type_code
 * @property string|null $voucher_type_name
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
 * @property int|null $verrify_req_ind
 * @property int|null $ref_mt_no_pk
 * @property int|null $ref_hospital_no_pk
 * @property string|null $pay_mood
 * @property int|null $status
 *
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\AcctJournalEntryMst> $journalHeaders
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\AcctJournalEntry> $journalEntries
 */
class VoucherType extends Eloquent
{
    protected $connection = 'oracle';

    protected $table = 'acct_voucher_type';

    protected $primaryKey = 'voucher_type_no_pk';

    protected $keyType = 'int';

    public $incrementing = false;

    // protected $sequence = 'acct_voucher_type_no_pk_seq';

    public $timestamps = false;

    protected $guarded = [];

    public function journalHeaders()
    {
        return $this->hasMany(
            MasterJournalEntry::class,
            'voucher_type_no_fk',
            'voucher_type_no_pk'
        );
    }

    public function journalEntries()
    {
        return $this->hasMany(
            JournalEntry::class,
            'voucher_type_no_fk',
            'voucher_type_no_pk'
        );
    }


    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
