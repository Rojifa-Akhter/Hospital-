<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class BankReconciliationRepository
{
    public static string $viewName = 'acc_bankreconcile_vw';

    public static array $defaultColumns = [
        'bank_cheq_number',
        'bank_cheq_date',
        'trn_cr_account_amount',
        'trn_dr_account_amount',
        'reconcile_date',
        'cr_amount',
        'dr_amount',
        'flag',
        'journal_code',
        'journal_date',
        'finalized_ind',
        'reconcile_no_pk',
        'remarks',
        'verified_ind',
        'verified_entry_by',
        'finalized_entry_by',
        'voucher_type_no_fk',
        'trn_account_no_fk',
        'trn_account_code',
        'journal_no_pk',
        'commission_indicator',
        'payment_method',
        'invoice_no_fk',
        'mrn',
        'reconcile_journal_code',
    ];

    public static function query()
    {
        return DB::table(self::$viewName);
    }

    public static function all(): Collection
    {
        return self::query()->select(self::$defaultColumns)->get();
    }
}
