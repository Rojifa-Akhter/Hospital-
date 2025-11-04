<?php

namespace App\Core\Accounts\AccountsBalance;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Core\Accounts\AccountsBalance\AccountsBalance;

class AccountsBalanceDetails implements AccountsBalance
{
    public function get_accounts_balance($acc_code) {
        if (isset($acc_code)) {
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $get_balance = DB::select(DB::raw("select NVL(sum(trn_dr_account_amount-trn_cr_account_amount),0) as balance
                                                from acct_journal_entry
                                                where trn_account_code = $acc_code and au_entry_hospital_pk_no = $ses_hospital_id
                                            ")
            );

            return response()->json(['success' => true, 'data' => $get_balance], 200);
        }

        return response()->json(['success' => true, 'message' => 'Missing Account\'n code'], 200);
    }
}