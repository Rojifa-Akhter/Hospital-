<?php

namespace App\Core\Accounts\AccountsReport;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Core\Accounts\OpeningBalance\OpeningBalance;
use App\Core\Accounts\AccountsReport\AccountsReportTrialBalance;

class AccountsReportTrialBalanceDetails implements AccountsReportTrialBalance
{
    protected $opening_balance;

    public function __construct(OpeningBalance $opening_balance)
    {
        $this->opening_balance = $opening_balance;
    }
    public function generate_trial_balance($from_date, $to_date)
    {
        if (empty($from_date) || empty($to_date)) {

            return response()->json(['success' => false, 'message' => 'Date missing'], 200);

        }

        try {

            $from_date = date("Y-m-d", strtotime($from_date));
            $to_date = date("Y-m-d", strtotime($to_date));

            $root_head = DB::select(DB::raw("select ch.account_name as bottom_head,ch.account_code,r1.account_name as root_head_1,r2.account_name as root_head_2,
                                                r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,r5.account_code as root_account_code,
                                                sum(jn.trn_cr_account_amount) as cr,
                                                sum(jn.trn_dr_account_amount) as dr
                                                from acct_chart_of_accounts ch
                                                left join acct_chart_of_accounts r1
                                                on r1.account_no_pk  = ch.account_no_fk_root_s4
                                                left join acct_chart_of_accounts r2
                                                on r2.account_no_pk = ch.account_no_fk_root_s3
                                                left join acct_chart_of_accounts r3
                                                on r3.account_no_pk  = ch.account_no_fk_root_s2
                                                left join acct_chart_of_accounts r4
                                                on r4.account_no_pk  = ch.account_no_fk_root_s1
                                                left join acct_chart_of_accounts r5
                                                on r5.account_no_pk = ch.account_no_fk_root_0
                                                join acct_journal_entry jn
                                                on jn.trn_account_no_fk  = ch.account_no_pk
                                                join acct_voucher_type vt
                                                on vt.voucher_type_no_pk = jn.voucher_type_no_fk
                                                where ch.posting_head_ind = 1
                                                and jn.journal_code in (select journal_code from acct_journal_entry)
                                                and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'
                                                
                                                group by ch.account_name,ch.account_code,r1.account_name,r2.account_name,
                                                r3.account_name,r4.account_name,r5.account_name,r5.account_code
            "));         
            
            $root_info = [];

            foreach($root_head as $root) {

                $opening_balance = $this->opening_balance->get_accounts_opening_balance($root->account_code, $from_date);

                $root_head_name = "";
                if(! empty($root->root_head_1)) {
                    $root_head_name = $root->root_head_1;
                }
                if(! empty($root->root_head_2) &&  empty($root->root_head_1) && $root_head_name == "") {
                    $root_head_name = $root->root_head_2;
                }
                if(! empty($root->root_head_3) &&  empty($root->root_head_1) && $root_head_name == "") {
                    $root_head_name = $root->root_head_3;
                }
                if(! empty($root->root_head_4) &&  empty($root->root_head_1) && $root_head_name == "") {
                    $root_head_name = $root->root_head_4;
                }
                if(! empty($root->root_head_5) &&  empty($root->root_head_1) && $root_head_name == "") {
                    $root_head_name = $root->root_head_5;
                }

                array_push($root_info, [
                    'type' => 'inflow',
                    'root_account_code' => $root->root_account_code,
                    'root_head' => $root->root_head_5,
                    'tran_head' => $root->bottom_head,
                    'account_code' => $root->account_code,
                    'opening_balance' => $opening_balance->getData()->data[0]->opening_balance,
                    'dr' => $root->dr,
                    'cr' => $root->cr

                ]);
            }

            return response()->json(['success' => true, 'data' => $root_info], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()],200);

        }
    }
    
    public function generate_trial_balance_v1($category_type, $from_date, $to_date)
    {
        if (empty($from_date) || empty($to_date)) {

            return response()->json(['success' => false, 'message' => 'Date missing'], 200);

        }

        if($category_type == "accountType"){
            $acc_type = isset($account_type) && $account_type != null ? $account_type : '';
            if(!empty($acc_type)){                  
                $cat_type_con = ($acc_type != "") ? " and at.acc_4type_no_pk = '$acc_type'" : "";               
            }
        }else if($category_type == "accountDescription"){
            $description_type = isset($account_description) && $account_description != null ? $account_description : '';
            if(!empty($description_type)){        
                $cat_type_con = ($description_type != "") ? " and ch.acc_5typedescription_no_fk = '$description_type'" : "";
               
            }
        }

        try {

            $from_date = date("Y-m-d", strtotime($from_date));
            $to_date = date("Y-m-d", strtotime($to_date));

            $root_head = DB::select(DB::raw("select ch.account_name as bottom_head,
                                            ch.account_no_pk,
                                            ch.acc_5typedescription_no_fk,
                                            sum(jn.trn_cr_account_amount) as cr,
                                            sum(jn.trn_dr_account_amount) as dr,
                                            ch.account_code,
                                            ch.retained_earnings_ind,
                                            ch.opening_gl_ind,
                                            at.acc_4type_no_pk,
                                            at.acc_4type_name,
                                            at.acc_4type_code,
                   
                                            ad.acc_5type_description,
                                            ad.type_code
                                                                 
                                            from acct_chart_of_accounts ch
                                            left join acct_journal_entry jn
                                            on jn.trn_account_no_fk  = ch.account_no_pk and jn.verified_ind = 1 and jn.finalized_ind = 1 and
                                            to_char(jn.journal_date, 'YYYY-MM-DD') BETWEEN '$from_date' AND '$to_date'
                                            
                                            join acc_coa_5accountdescription ad
                                            on ad.acc_5typedescription_no_pk = ch.acc_5typedescription_no_fk
                                                                                
                                            join acc_coa_4accounttype at
                                            on at.acc_4type_no_pk = ad.acc_4type_no_fk
                                            
                                            where ch.posting_head_ind = 1 
                                            AND ch.account_no_pk in(

                                                SELECT DISTINCT trn_account_no_fk FROM 
                                                (                              
                                                    SELECT trn_account_no_fk
                                                        FROM acct_journal_entry jn_inner
                                                        WHERE jn_inner.trn_account_no_fk = ch.account_no_pk and jn_inner.verified_ind = 1 and jn_inner.finalized_ind = 1
                                                    
                                                    UNION
                                                                                                                     
                                                    SELECT ob.trn_account_no_fk     
                                                        FROM acct_openingbalance ob
                                                        WHERE ob.trn_account_no_fk = ch.account_no_pk and ob.trn_account_code = ch.account_code                  
                                                        ORDER BY trn_account_no_fk ASC FETCH FIRST 1 ROW ONLY
                                                        
                                                )
                                            )
                                            
                                            
                                            group by ch.account_name,
                                            ch.account_code,
                                            ch.retained_earnings_ind,
                                            ch.opening_gl_ind,
                                            ch.account_no_pk,                                                
                                            ch.acc_5typedescription_no_fk,
                                            at.acc_4type_no_pk,
                                            
                                            at.acc_4type_name,
                                            at.acc_4type_code,
                                            ad.acc_5type_description,
                                            ad.type_code order by ch.account_code
                                        
                                            "));         
            
            $root_info = [];
                          
            foreach($root_head as $root) {
     
                $opening_balance = $this->opening_balance->get_accounts_opening_balance_1($root->account_no_pk, $root->account_code, $from_date);


                $root_code = $category_type == 'accountType' ? $root->acc_4type_code : $root->type_code;
                $root_name = $category_type == 'accountType' ? $root->acc_4type_name : $root->acc_5type_description;
                
                array_push($root_info, [
                    'type' => 'inflow',
                    'retained_earnings_ind' => $root->retained_earnings_ind,
                    'opening_gl_ind' => $root->opening_gl_ind,
                    'root_account_code' => $root_code,
                    'root_head' => $root_name,
                    'tran_head' => $root->bottom_head,
                    'account_code' => $root->account_code,
                    'opening_balance_dr' => $opening_balance->getData()->data[0]->opening_balance_dr,
                    'opening_balance_cr' => $opening_balance->getData()->data[0]->opening_balance_cr,
                    'dr' => $root->dr,
                    'cr' => $root->cr

                ]);
            }

            return response()->json(['success' => true, 'data' => $root_info], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()],200);

        }
    }

    public function generate_trial_balance_v3($category_type, $from_date, $to_date)
    {
        if (empty($from_date) || empty($to_date)) {

            return response()->json(['success' => false, 'message' => 'Date missing'], 200);

        }

        if($category_type == "accountType"){
            $acc_type = isset($account_type) && $account_type != null ? $account_type : '';
            if(!empty($acc_type)){                  
                $cat_type_con = ($acc_type != "") ? " and at.acc_4type_no_pk = '$acc_type'" : "";               
            }
        }else if($category_type == "accountDescription"){
            $description_type = isset($account_description) && $account_description != null ? $account_description : '';
            if(!empty($description_type)){        
                $cat_type_con = ($description_type != "") ? " and ch.acc_5typedescription_no_fk = '$description_type'" : "";
               
            }
        }

        try {

            $from_date = date("Y-m-d", strtotime($from_date));
            $to_date = date("Y-m-d", strtotime($to_date));

            $root_head = DB::select(DB::raw("select ch.account_name as bottom_head,
                                            ch.account_no_pk,
                                            ch.acc_5typedescription_no_fk,
                                            sum(jn.trn_cr_account_amount) as cr,
                                            sum(jn.trn_dr_account_amount) as dr,
                                            ch.account_code,
                                            ch.retained_earnings_ind,
                                            ch.opening_gl_ind,
                                            at.acc_4type_no_pk,
                                            at.acc_4type_name,
                                            at.acc_4type_code,
                   
                                            ad.acc_5type_description,
                                            ad.type_code,
                                            ch.acc_type                     
                                            from acct_chart_of_accounts ch
                                            left join acct_journal_entry jn
                                            on jn.trn_account_no_fk  = ch.account_no_pk and jn.verified_ind = 1 and jn.finalized_ind = 1 and
                                            to_char(jn.journal_date, 'YYYY-MM-DD') BETWEEN '$from_date' AND '$to_date'
                                            
                                            join acc_coa_5accountdescription ad
                                            on ad.acc_5typedescription_no_pk = ch.acc_5typedescription_no_fk
                                                                                
                                            join acc_coa_4accounttype at
                                            on at.acc_4type_no_pk = ad.acc_4type_no_fk
                                            
                                            where ch.posting_head_ind = 1 
                                            AND ch.account_no_pk in(

                                                SELECT DISTINCT trn_account_no_fk FROM 
                                                (                              
                                                    SELECT trn_account_no_fk
                                                        FROM acct_journal_entry jn_inner
                                                        WHERE jn_inner.trn_account_no_fk = ch.account_no_pk and jn_inner.verified_ind = 1 and jn_inner.finalized_ind = 1
                                                    
                                                    UNION
                                                                                                                     
                                                    SELECT ob.trn_account_no_fk     
                                                        FROM acct_openingbalance ob
                                                        WHERE ob.trn_account_no_fk = ch.account_no_pk and ob.trn_account_code = ch.account_code                  
                                                        ORDER BY trn_account_no_fk ASC FETCH FIRST 1 ROW ONLY
                                                        
                                                )
                                            )
                                            
                                            
                                            group by ch.account_name,
                                            ch.account_code,
                                            ch.retained_earnings_ind,
                                            ch.opening_gl_ind,
                                            ch.account_no_pk,                                                
                                            ch.acc_5typedescription_no_fk,
                                            at.acc_4type_no_pk,
                                            ch.acc_type ,
                                            
                                            at.acc_4type_name,
                                            at.acc_4type_code,
                                            ad.acc_5type_description,
                                            ad.type_code order by ch.account_code
                                        
                                            "));         
            
            $root_info = [];
                          
            foreach($root_head as $root) {
     
                $opening_balance = $this->opening_balance->get_accounts_opening_balance_1($root->account_no_pk, $root->account_code, $from_date);


                $root_code = $category_type == 'accountType' ? $root->acc_4type_code : $root->type_code;
                $root_name = $category_type == 'accountType' ? $root->acc_4type_name : $root->acc_5type_description;
                
                array_push($root_info, [
                    'type' => 'inflow',
                    'retained_earnings_ind' => $root->retained_earnings_ind,
                    'opening_gl_ind' => $root->opening_gl_ind,
                    'root_account_code' => $root_code,
                    'root_head' => $root_name,
                    'tran_head' => $root->bottom_head,
                    'account_code' => $root->account_code,
                    'opening_balance_dr' => $opening_balance->getData()->data[0]->opening_balance_dr,
                    'opening_balance_cr' => $opening_balance->getData()->data[0]->opening_balance_cr,
                    'dr' => $root->dr,
                    'cr' => $root->cr,
                    'type_name' => $root->acc_type,

                ]);
            }

            return response()->json(['success' => true, 'data' => $root_info], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()],200);

        }
    }

    public function generate_trial_balance_1($from_date, $to_date)
    {
        if (empty($from_date) || empty($to_date)) {

            return response()->json(['success' => false, 'message' => 'Date missing'], 200);

        }

        try {

            $from_date = date("Y-m-d", strtotime($from_date));
            $to_date = date("Y-m-d", strtotime($to_date));

            $root_head = DB::select(DB::raw("select ch.account_name as bottom_head,
                                            ch.account_no_pk,
                                            ch.acc_5typedescription_no_fk,
                                            sum(jn.trn_cr_account_amount) as cr,
                                            sum(jn.trn_dr_account_amount) as dr,
                                            ch.account_code,
                                            at.acc_4type_no_pk,
                                            at.acc_4type_name,
                                            at.acc_4type_code,
                   
                                            ad.acc_5type_description,
                                            ad.type_code
                                           
                                            from acct_chart_of_accounts ch
                                            left join acct_journal_entry jn
                                            on jn.trn_account_no_fk  = ch.account_no_pk and jn.verified_ind = 1 and jn.finalized_ind = 1 and
                                            to_char(jn.journal_date, 'YYYY-MM-DD') BETWEEN '$from_date' AND '$to_date'
                                            
                                            join acc_coa_5accountdescription ad
                                            on ad.acc_5typedescription_no_pk = ch.acc_5typedescription_no_fk
                                                                                
                                            join acc_coa_4accounttype at
                                            on at.acc_4type_no_pk = ad.acc_4type_no_fk
                                            
                                            where ch.posting_head_ind = 1 
                                            AND ch.account_no_pk in(
                                                SELECT trn_account_no_fk
                                                    FROM acct_journal_entry jn_inner
                                                    WHERE jn_inner.trn_account_no_fk = ch.account_no_pk and jn_inner.verified_ind = 1 and jn_inner.finalized_ind = 1
                                                    
                                                UNION
                                                                                                                     
                                                SELECT ob.trn_account_no_fk     
                                                    FROM acct_openingbalance ob
                                                    WHERE ob.trn_account_no_fk = ch.account_no_pk and ob.trn_account_code = ch.account_code                  
                                                    ORDER BY trn_account_no_fk ASC FETCH FIRST 1 ROW ONLY
                                            )
                                                       
                                            group by ch.account_name,
                                            ch.account_code,
                                            ch.account_no_pk,                                                
                                            ch.acc_5typedescription_no_fk,
                                            at.acc_4type_no_pk,                                           
                                            at.acc_4type_name,
                                            at.acc_4type_code,
                                            ad.acc_5type_description,
                                            ad.type_code order by ch.account_code asc
                                        
                                            "));         
            
            $root_info = [];

            foreach($root_head as $root) {
                $opening_balance = $this->opening_balance->get_accounts_opening_balance_1($root->account_no_pk,$root->account_code, $from_date);              
                array_push($root_info, [
                    'type' => 'inflow',
                    'tran_head' => $root->bottom_head,
                    'account_code' => $root->account_code,
                    'opening_balance_dr' => $opening_balance->getData()->data[0]->opening_balance_dr,
                    'opening_balance_cr' => $opening_balance->getData()->data[0]->opening_balance_cr,
                    'dr' => $root->dr,
                    'cr' => $root->cr

                ]);
            }

            return response()->json(['success' => true, 'data' => $root_info], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()],200);

        }
    }
}