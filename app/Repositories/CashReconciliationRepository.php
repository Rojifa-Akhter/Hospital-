<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class CashReconciliationRepository
{
    public static string $viewName = 'acc_cashreconcile_vw';
    
    public static array $defaultColumns = [
        'cashier_pk',
        'cashier_name',
        'journal_date',
        'journal_code',
        'trn_account_no_fk',
        'total_amt',
        'amount',
        'reconcile_no_pk',
        'reconcile_date',
        'remarks',
        'verified_ind',
        'verified_entry_by',
        'verified_entry_at',
        'finalized_ind',
        'finalized_entry_by',
        'finalized_entry_at',
        'account_code',
        'account_name'
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