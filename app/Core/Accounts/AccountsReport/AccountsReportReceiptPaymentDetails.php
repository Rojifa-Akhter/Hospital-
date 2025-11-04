<?php

namespace App\Core\Accounts\AccountsReport;

use Illuminate\Support\Facades\DB;
use App\Core\Accounts\AccountsReport\AccountsReportReceiptPayment;

class AccountsReportReceiptPaymentDetails implements AccountsReportReceiptPayment
{
    public function receipt_payment($bottom_head_1, $bottom_head_2, $from_date, $to_date)
    {
        if (empty($bottom_head_1) || ! isset($bottom_head_1)) {

            return response()->json(['success' => false, 'message' => 'Cash account head missing'], 200);

        }

        try {

            $from_date = date("Y-m-d", strtotime($from_date));
            $to_date = date("Y-m-d", strtotime($to_date));

            $cash_op_bal = DB::select(DB::raw("select 
                        sum(jn.trn_dr_account_amount - jn.trn_cr_account_amount) as balance
                        from acct_journal_entry_vw jn
                        where jn.account_no_fk_root_0 = $bottom_head_1
                        and to_char(jn.journal_date,'YYYY-MM-DD') <'$from_date'
            "));

            $bank_op_bal = DB::select(DB::raw("select 
                        nvl(sum(jn.trn_dr_account_amount - jn.trn_cr_account_amount),0) as balance
                        from acct_journal_entry_vw jn
                        where jn.account_no_fk_root_0 = $bottom_head_2
                        and to_char(jn.journal_date,'YYYY-MM-DD') <'$from_date'
            "));

           

//             dd("select 
//             nvl(sum(jn.trn_dr_account_amount - jn.trn_cr_account_amount),0) as balance
//             from acct_journal_entry_vw jn
//             where jn.account_no_fk_root_0 = $bottom_head_2
//             and to_char(jn.journal_date,'YYYY-MM-DD') <'$from_date'
// ");

            

            $root_head_inflow = DB::select(DB::raw("select ch.account_name as bottom_head,r1.account_name as root_head_1,r2.account_name as root_head_2,
                                                r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
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
                                                where  jn.journal_code in (select journal_code from acct_journal_entry_vw where account_no_fk_root_0 = $bottom_head_1 and trn_dr_account_amount > 0)
                                                and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'
                                                group by ch.account_name,r1.account_name,r2.account_name,
                                                r3.account_name,r4.account_name,r5.account_name
            "));

            
            
            $root_head_bank_inflow = DB::select(DB::raw("select ch.account_name as bottom_head,r1.account_name as root_head_1,r2.account_name as root_head_2,
                                                r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
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
                                                where  jn.journal_code in (select journal_code from acct_journal_entry_vw where account_no_fk_root_0=$bottom_head_2 and trn_dr_account_amount > 0)
                                                and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'
                                                group by ch.account_name,r1.account_name,r2.account_name,
                                                r3.account_name,r4.account_name,r5.account_name
            "));
            

            

            $root_head_outflow = DB::select(DB::raw("select ch.account_name as bottom_head,r1.account_name as root_head_1,r2.account_name as root_head_2,
                                                r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
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
                                                where jn.journal_code in (select journal_code from acct_journal_entry_vw where account_no_fk_root_0 = $bottom_head_1 and trn_cr_account_amount > 0)
                                                and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'
                                                group by ch.account_name,r1.account_name,r2.account_name,
                                                r3.account_name,r4.account_name,r5.account_name
            ")); 
            

            $root_head_bank_outflow = DB::select(DB::raw("select ch.account_name as bottom_head,r1.account_name as root_head_1,r2.account_name as root_head_2,
                                                r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
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
                                                where jn.journal_code in (select journal_code from acct_journal_entry_vw where account_no_fk_root_0 = $bottom_head_2 and trn_cr_account_amount > 0)
                                                and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'
                                                group by ch.account_name,r1.account_name,r2.account_name,
                                                r3.account_name,r4.account_name,r5.account_name
            "));
            
            $root_info = [];

            foreach($root_head_inflow as $root) {
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

                if ($root->dr == 0) {
                    array_push($root_info, [
                        'type' => 'inflow',
                        'cashtype' => 'cash',
                        'opbal' => $cash_op_bal,
                        'bnkopbal' => $bank_op_bal,
                        'root_head' => $root_head_name,
                        'tran_head' => $root->bottom_head,
                        'dr' => $root->cr,
                        'cr' => 0

                    ]);
                }
            }

            

            foreach($root_head_bank_inflow as $root) {
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

                if ($root->dr == 0) {
                    array_push($root_info, [
                        'type' => 'inflow',
                        'cashtype' => 'bank',
                        'opbal' => $cash_op_bal,
                        'bnkopbal' => $bank_op_bal,
                        'root_head' => $root_head_name,
                        'tran_head' => $root->bottom_head,
                        'dr' => $root->cr,
                        'cr' => 0

                    ]);
                }
            }

            $root_info_outflow = [];

            foreach($root_head_outflow as $root) {
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

                if ($root->cr == 0) {
                    array_push($root_info_outflow, [
                        'type' => 'outflow',
                        'cashtype' => 'cash',
                        'opbal' => $cash_op_bal,
                        'bnkopbal' => $bank_op_bal,
                        'root_head' => $root_head_name,
                        'tran_head' => $root->bottom_head,
                        'dr' => 0,
                        'cr' => $root->dr

                    ]);
                }
            }


            foreach($root_head_bank_outflow as $root) {
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

                if ($root->cr == 0) {
                    array_push($root_info_outflow, [
                        'type' => 'outflow',
                        'cashtype' => 'bank',
                        'opbal' => $cash_op_bal,
                        'bnkopbal' => $bank_op_bal,
                        'root_head' => $root_head_name,
                        'tran_head' => $root->bottom_head,
                        'dr' => 0,
                        'cr' => $root->dr

                    ]);
                }
            }

            //dd(collect($root_info)->where('type','outflow'));

            return response()->json(['success' => true, 'data' => $root_info,'data_one' => $root_info_outflow], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()],200);

        }
    }
}