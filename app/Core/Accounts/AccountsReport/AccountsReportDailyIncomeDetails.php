<?php

namespace App\Core\Accounts\AccountsReport;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Core\Accounts\AccountsReport\AccountsReportDailyIncome;

class AccountsReportDailyIncomeDetails implements AccountsReportDailyIncome
{
    public function daily_income(array $date_range)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        if (!is_array($date_range)) {

            return response()->json(['success' => false, 'message' => 'date range must be an array'], 200);

        }

        $from_date = $date_range['from_date'];
        $to_date = $date_range['to_date'];

        $voucher = DB::select(DB::raw("select account_name, sum(trn_cr_account_amount-trn_dr_account_amount) total_amount
                from acct_journal_entry_vw
                where ledger_group_name = 'income'
                and TRUNC(journal_date) between TO_DATE('$from_date','YYYY-MM-DD') and TO_DATE('$to_date','YYYY-MM-DD')
                group by account_name
        "));
        //if (!$voucher->isEmpty()) {

            return response()->json([
                'success' => true,
                'data' => $voucher
            ], 200);
        //}

        return response()->json(['success' => false, 'message' => 'No data Found'], 200);
    }
}