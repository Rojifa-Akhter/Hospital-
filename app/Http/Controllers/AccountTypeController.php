<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Core\Accounts\AccountType\AccountType;
use App\Core\Accounts\ChartOfAccounts\ChartOfAccounts;

class AccountTypeController extends Controller
{
    /**
     * AccountType service
     *
     * @var [AccountType]
     */
    protected $account_type;

    /**
     * Chart of account service
     *
     * @var [type]
     */
    protected $chart_of_account;

    public function __construct(
        AccountType $account_type,
        ChartOfAccounts $chart_of_account
    )
    {
        $this->account_type = $account_type;
        $this->chart_of_account = $chart_of_account;
    }

    /**
     * Account entry form
     *
     * @return void
     */
    public function account_type()
    {
        return $this->account_type->get_account_type();
    }

    /**
     * Save root account type
     *
     * @param Request $request
     * @return void
     */
    public function save_account_type(Request $request)
    {
        
        $account_type = $this->account_type->save_account_type([
            'acct_type_code' => $request->acct_type_code,
            'acct_type_name' => $request->acct_type_name,
            'acct_type_sl' => $request->acct_type_sl,
            'status' => $request->status,
            'cashflow_ind' => $request->cashflow_ind,
            'income_exp_ind' => $request->income_exp_ind
        ]);

        if (! empty($account_type->getData()->data)) {
            $this->chart_of_account->save_chart_of_account([
                'account_code' => $request->acct_type_code,
                'account_name' => $request->acct_type_name,
                'acct_type_no_fk' => $account_type->getData()->last_id->acct_type_no_pk,
                'account_no_fk_root_0' => 0,
                'account_no_fk_root_s1' => 0,
                'account_no_fk_root_s2' => 0,
                'account_no_fk_root_s3' => 0,
                'account_no_fk_root_s4' => 0,
                'account_no_sl' => $request->acct_type_sl,
                'posting_head_ind' => 0,
                'status' => $request->status,
                'cashflow_ind' => $request->cashflow_ind,
                'income_exp_ind' => $request->income_exp_ind
            ]);

            return $account_type;
        }

        return $account_type;
    }

    public function update_account_type(Request $request)
    {
        $account_type = $this->account_type->update_account_type([
            'acct_type_no_pk' => $request->acct_type_no_pk,
            'acct_type_name' => $request->acct_type_name,
            'acct_type_sl' => $request->acct_type_sl,
            'status' => $request->status,
            'cashflow_ind' => $request->cashflow_ind,
            'income_exp_ind' => $request->income_exp_ind
        ]);

        
        if (! empty($account_type->getData()->data)) {
            
            $update_chart_of_accounts = $this->chart_of_account->update_acct_type_chart_of_account([
                'account_name' => $request->acct_type_name,
                'account_no_sl' => $request->acct_type_sl,
                'posting_head_ind' => 0,
                'status' => $request->status,
                'acct_type_no_pk' => $request->acct_type_no_pk,
                'cashflow_ind' => $request->cashflow_ind,
                'income_exp_ind' => $request->income_exp_ind
            ]);


            if ($update_chart_of_accounts->getData()->success == false) {
                return $this->chart_of_account->save_chart_of_account([
                    'account_code' => $request->acct_type_code,
                    'account_name' => $request->acct_type_name,
                    'acct_type_no_fk' => $request->acct_type_no_pk,
                    'account_no_fk_root_0' => 0,
                    'account_no_fk_root_s1' => 0,
                    'account_no_fk_root_s2' => 0,
                    'account_no_fk_root_s3' => 0,
                    'account_no_fk_root_s4' => 0,
                    'account_no_sl' => $request->acct_type_sl,
                    'posting_head_ind' => 0,
                    'status' => $request->status,
                    'cashflow_ind' => $request->cashflow_ind,
                    'income_exp_ind' => $request->income_exp_ind
                ]);

                return $account_type;
            }

            return $account_type;
        }
    }
    
}
