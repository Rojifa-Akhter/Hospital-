<?php

namespace App\Core\Accounts\AccountsReport;

interface AccountsReportJournal
{
    public function get_journal_report($journal_code, $from_date, $to_date);
    public function get_auto_journal_report($journal_code, $from_date, $to_date);
    
     // Fixed Asset Depreciation
     public function get_fixed_asset_depreciation_details();
     public function datewise_balance_sheet($to_date,$account_no_pk);
     public function datewise_balance_sheet_without_depreciation($from_date,$to_date,$account_no_pk = null);
     public function fixedAssetDepreciationDaily($to_date,$account_no_pk = null);
     public function lastMonthDepreciation($account_no_pk);
}