<?php

namespace App\Core\Accounts\AccountsReport;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Core\Accounts\AccountsReport\AccountsReportDayBook;
class AccountsReportDayBookDetails implements AccountsReportDayBook
{
    public function daily_day_book(array $date_range)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        if (!is_array($date_range)) {

            return response()->json(['success' => false, 'message' => 'date range must be an array'], 200);
        }

        $voucher = DB::table('acct_journal_entry_vw')
            ->select(
                'acct_chart_of_accounts.account_name',
                'acct_journal_entry_vw.trn_cr_account_amount',
                'acct_journal_entry_vw.trn_dr_account_amount',
                'acct_journal_entry_vw.journal_date',
                'acct_journal_entry_vw.journal_code',
                'acct_journal_entry_vw.narration_text',
                'acct_journal_entry_vw.voucher_type_name',
                'acct_journal_entry_vw.is_contra',
                'acct_journal_entry_vw.voucher_remarks'

            )
            ->join('acct_chart_of_accounts', 'acct_journal_entry_vw.trn_account_no_fk', '=', 'acct_chart_of_accounts.account_no_pk')
            ->whereDate('journal_date', '>=', $date_range['from_date'])
            ->whereDate('journal_date', '<=', $date_range['to_date'])
            ->where('acct_journal_entry_vw.au_entry_hospital_pk_no',   $ses_hospital_id)
            ->orderBy('journal_date','asc')
            ->orderBy('journal_code','asc')
            ->get();

        if (!$voucher->isEmpty()) {

            return response()->json([
                'success' => true,
                'data' => $voucher,
                'journal_date' => $voucher[0]->journal_date,
                'voucher_no' => $voucher[0]->journal_code,
                'narration' => $voucher[0]->narration_text,
                'voucher_type' => $voucher[0]->voucher_type_name
            ], 200);
        }

        return response()->json(['success' => false, 'message' => 'No data Found'], 200);
    }
}