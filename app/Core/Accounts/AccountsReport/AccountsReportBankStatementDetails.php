<?php

namespace App\Core\Accounts\AccountsReport;

use stdClass;
use Illuminate\Support\Facades\DB;
use App\Core\Accounts\OpeningBalance\OpeningBalance;
use App\Core\Accounts\AccountsReport\AccountsReportBankStatement;

class AccountsReportBankStatementDetails implements AccountsReportBankStatement
{
    // protected $opben_balance;
    protected $opening_balance;
    public function __construct(OpeningBalance $opening_balance)
    {
        $this->opening_balance = $opening_balance;
    }

    public function self_ledger($cash_bottom_head,$from_date,$to_date)
    {
        if (empty($cash_bottom_head) || ! isset($cash_bottom_head)) {

            return response()->json(['success' => false, 'message' => 'Cash account head missing'], 200);

        }

        $opening_bal = DB::select(DB::raw("select sum(trn_dr_account_amount-trn_cr_account_amount) opening_bal
        from acct_journal_entry_vw
        where trn_account_code = '$cash_bottom_head'
        and trunc(journal_date) < TO_DATE('$from_date','YYYY-MM-DD')"));

        $ledger_details = DB::select(DB::raw("select journal_date,journal_code,voucher_type_name,narration_text,patient_name,patient_no_fk,full_name,person_no_fk,supplier_name,supplier_no_fk, sum(trn_dr_account_amount) dr, sum(trn_cr_account_amount) cr,is_contra
        from acct_journal_entry_vw
        where trn_account_code = '$cash_bottom_head'
        and trunc(journal_date) between  TO_DATE('$from_date','YYYY-MM-DD') AND TO_DATE('$to_date','YYYY-MM-DD')
        group by journal_date,journal_code,voucher_type_name,narration_text,patient_name,patient_no_fk,full_name,person_no_fk,supplier_name,supplier_no_fk,is_contra
        order by journal_date asc"));

        $closing_bal = DB::select(DB::raw("select sum(trn_dr_account_amount-trn_cr_account_amount) closing_bal
        from acct_journal_entry_vw
        where trn_account_code = '$cash_bottom_head'
        and trunc(journal_date) between  TO_DATE('$from_date','YYYY-MM-DD') AND TO_DATE('$to_date','YYYY-MM-DD')"));

        return response()->json([
            'success' => true,
            'message' => 'Ledger Statement',
            'opening_bal' => $opening_bal,
            'ledger_details' => $ledger_details,
            'closing_bal' => $closing_bal
        ]);
    }

    public function self_ledger_patient($cash_bottom_head,$from_date,$to_date)
    {
        if (empty($cash_bottom_head) || ! isset($cash_bottom_head)) {

            return response()->json(['success' => false, 'message' => 'Cash account head missing'], 200);

        }



        $opening_bal = DB::select(DB::raw("select sum(trn_dr_account_amount-trn_cr_account_amount) opening_bal
        from acct_journal_entry_vw
        where patient_no_fk = $cash_bottom_head
        and trn_account_no_fk in(586,481,582)
        and trunc(journal_date) < TO_DATE('$from_date','YYYY-MM-DD')"));

        $ledger_details = DB::select(DB::raw("select journal_date,journal_code,voucher_type_name,narration_text,patient_name,patient_no_fk,full_name,person_no_fk,supplier_name,supplier_no_fk, sum(trn_dr_account_amount) dr, sum(trn_cr_account_amount) cr
        from acct_journal_entry_vw
        where patient_no_fk = '$cash_bottom_head'
        and trn_account_no_fk in(586,481,582)
        and trunc(journal_date) between  TO_DATE('$from_date','YYYY-MM-DD') AND TO_DATE('$to_date','YYYY-MM-DD')
        group by journal_date,journal_code,voucher_type_name,narration_text,patient_name,patient_no_fk,full_name,person_no_fk,supplier_name,supplier_no_fk"));


        $closing_bal = DB::select(DB::raw("select sum(trn_dr_account_amount-trn_cr_account_amount) closing_bal
        from acct_journal_entry_vw
        where patient_no_fk = '$cash_bottom_head'
        and trn_account_no_fk in(586,481,582)
        and trunc(journal_date) between  TO_DATE('$from_date','YYYY-MM-DD') AND TO_DATE('$to_date','YYYY-MM-DD')"));

        return response()->json([
            'success' => true,
            'message' => 'Ledger Statement',
            'opening_bal' => $opening_bal,
            'ledger_details' => $ledger_details,
            'closing_bal' => $closing_bal
        ]);
    }


    public function bank_statement($bank_bottom_head, $from_date, $to_date)
    {
        if (empty($bank_bottom_head) || ! isset($bank_bottom_head)) {

            return response()->json(['success' => false, 'message' => 'Cash account head missing'], 200);

        }

        try {

            $acc_head_info = DB::table('acct_chart_of_accounts')->where('account_code', $bank_bottom_head)->first();
            $from_date = date("Y-m-d", strtotime($from_date));
            $to_date = date("Y-m-d", strtotime($to_date));


            $root_head_inflow = DB::select(DB::raw("select ch.account_name as bottom_head,ch.account_no_pk,r1.account_name as root_head_1,r2.account_name as root_head_2,
                                                r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
                                                sum(jn.trn_cr_account_amount) as cr,
                                                sum(jn.trn_dr_account_amount) as dr,
                                                jn.journal_code,
                                                jn.journal_date,
                                                jn.narration_text,
                                                e.full_name,
                                                e.person_no_pk,
                                                p.patient_name,
                                                p.patient_no_pk,
                                                s.supplier_name,
                                                s.supplier_no_pk,
                                                vt.voucher_type_name
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
                                                left join acct_journal_entry jn
                                                on jn.trn_account_no_fk  = ch.account_no_pk
                                                join acct_voucher_type vt
                                                on vt.voucher_type_no_pk = jn.voucher_type_no_fk
                                                left join hrms_personnel_vw e
                                                on e.person_no_pk = jn.person_no_fk
                                                left join acct_vouchermst_sum_vw p
                                                on p.invoice_no_pk = jn.invoice_no_fk
                                                left join suppliers_vw s
                                                on s.supplier_no_pk = jn.supplier_no_fk
                                                where ch.posting_head_ind = 1
                                                and jn.journal_code in (select journal_code from acct_journal_entry where trn_account_code = $bank_bottom_head)

                                                and trn_account_code! = $bank_bottom_head
                                                and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'

                                                group by jn.journal_date,jn.journal_code,ch.account_name,ch.account_no_pk,r1.account_name,r2.account_name,
                                                r3.account_name,r4.account_name,r5.account_name,e.full_name,e.person_no_pk,p.patient_name,p.patient_no_pk,s.supplier_name,s.supplier_no_pk,vt.voucher_type_name,jn.narration_text
                                                order by jn.journal_date asc
            "));
             //and jn.trn_account_no_fk not in (select account_no_pk from acct_chart_of_accounts where account_no_fk_root_0 in(723,743,665,761))

            $root_head_outflow = DB::select(DB::raw("select ch.account_name as bottom_head,r1.account_name as root_head_1,r2.account_name as root_head_2,
                                                r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
                                                sum(jn.trn_cr_account_amount) as cr,
                                                sum(jn.trn_dr_account_amount) as dr,
                                                jn.journal_code,journal_date
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
                                                and jn.journal_code in (select journal_code from acct_journal_entry where trn_account_code = $bank_bottom_head and trn_cr_account_amount > 0)
                                                and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'
                                                group by ch.account_name,r1.account_name,r2.account_name,
                                                r3.account_name,r4.account_name,r5.account_name,jn.journal_code,jn.journal_date
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

                $client_name = "";
                $client_code = "";
                $report_type = "";
                if (!empty($root->patient_name)) {
                    $client_name = $root->patient_name;
                    $client_code = $root->patient_no_pk;
                    $report_type = "patient";
                } elseif(!empty($root->full_name)) {
                    $client_name = $root->full_name;
                    $client_code = $root->person_no_pk;
                    $report_type = "employee";
                } else {
                    $client_name = $root->supplier_name;
                    $client_code = $root->supplier_no_pk;
                    $report_type = "supplier";
                }


                //if ($root->dr == 0) {
                array_push($root_info, [
                    'ledger_of' => $acc_head_info->account_name,
                    'ledger_of_code' => $acc_head_info->account_code,
                    'type' => 'inflow',
                    'voucher_type' => $root->voucher_type_name,
                    'root_head' => $root_head_name,
                    'tran_head' => $root->bottom_head,//$root->bottom_head == "SALARY & ALLOWANCE-DIRECT" && $root->full_name != "" ? $root->full_name : $root->bottom_head,
                    'client' => $client_name,
                    'client_code' => $client_code,
                    'report_type' => $report_type,
                    'journal_date' => $root->journal_date,
                    'journal_code' => $root->journal_code,
                    'narration' => $root->narration_text,
                    'dr' => $root->dr,
                    'cr' => $root->cr
                ]);
            }



            if (count($root_info) == 0) {
                array_push($root_info, [
                    'ledger_of' => $acc_head_info->account_name,
                    'type' => 'inflow',
                    'voucher_type' => null,
                    'root_head' => null,
                    'tran_head' => null,//$root->bottom_head == "SALARY & ALLOWANCE-DIRECT" && $root->full_name != "" ? $root->full_name : $root->bottom_head,
                    'client' => null,
                    'client_code' => null,
                    'report_type' => null,
                    'journal_code' => null,
                    'journal_date' => null,
                    'narration' => null,
                    'dr' => 0,
                    'cr' => 0
                ]);
            }

            return response()->json(['success' => true, 'data' => $root_info], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()],200);

        }
    }

    public function bank_ledger_statement($from_date, $to_date)
    {

        try {

            $acc_head_info = DB::table('acct_chart_of_accounts')->where('account_no_pk', 403)->first();
            $from_date = date("Y-m-d", strtotime($from_date));
            $to_date = date("Y-m-d", strtotime($to_date));


            $root_head_inflow = DB::select(DB::raw("select ch.account_name as bottom_head,ch.account_no_pk,r1.account_name as root_head_1,r2.account_name as root_head_2,
                            r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
                            sum(jn.trn_cr_account_amount) as cr,
                            sum(jn.trn_dr_account_amount) as dr,
                            jn.journal_code,
                            jn.journal_date,
                            jn.narration_text,
                            e.full_name,
                            e.person_no_pk,
                            p.patient_name,
                            p.patient_no_pk,
                            s.supplier_name,
                            s.supplier_no_pk,
                            vt.voucher_type_name
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
                            left join acct_journal_entry jn
                            on jn.trn_account_no_fk  = ch.account_no_pk
                            join acct_voucher_type vt
                            on vt.voucher_type_no_pk = jn.voucher_type_no_fk
                            left join hrms_personnel_vw e
                            on e.person_no_pk = jn.person_no_fk
                            left join acct_vouchermst_sum_vw p
                            on p.invoice_no_pk = jn.invoice_no_fk
                            left join suppliers_vw s
                            on s.supplier_no_pk = jn.supplier_no_fk
                            where ch.posting_head_ind = 1
                            and ch.ACCOUNT_NO_FK_ROOT_0 = 403
                            and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'

                            group by jn.journal_date,jn.journal_code,ch.account_name,ch.account_no_pk,r1.account_name,r2.account_name,
                            r3.account_name,r4.account_name,r5.account_name,e.full_name,e.person_no_pk,p.patient_name,p.patient_no_pk,s.supplier_name,s.supplier_no_pk,vt.voucher_type_name,jn.narration_text
                            order by jn.journal_date asc
            "));
             //and jn.trn_account_no_fk not in (select account_no_pk from acct_chart_of_accounts where account_no_fk_root_0 in(723,743,665,761))

            $root_head_outflow = DB::select(DB::raw("select ch.account_name as bottom_head,r1.account_name as root_head_1,r2.account_name as root_head_2,
                                                r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
                                                sum(jn.trn_cr_account_amount) as cr,
                                                sum(jn.trn_dr_account_amount) as dr,
                                                jn.journal_code,journal_date
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
                                                and ch.ACCOUNT_NO_FK_ROOT_0 = 403
                                                and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'
                                                group by ch.account_name,r1.account_name,r2.account_name,
                                                r3.account_name,r4.account_name,r5.account_name,jn.journal_code,jn.journal_date
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

                $client_name = "";
                $client_code = "";
                $report_type = "";
                if (!empty($root->patient_name)) {
                    $client_name = $root->patient_name;
                    $client_code = $root->patient_no_pk;
                    $report_type = "patient";
                } elseif(!empty($root->full_name)) {
                    $client_name = $root->full_name;
                    $client_code = $root->person_no_pk;
                    $report_type = "employee";
                } else {
                    $client_name = $root->supplier_name;
                    $client_code = $root->supplier_no_pk;
                    $report_type = "supplier";
                }


                //if ($root->dr == 0) {
                array_push($root_info, [
                    'ledger_of' => $acc_head_info->account_name,
                    'ledger_of_code' => $acc_head_info->account_code,
                    'type' => 'inflow',
                    'voucher_type' => $root->voucher_type_name,
                    'root_head' => $root_head_name,
                    'tran_head' => $root->bottom_head,//$root->bottom_head == "SALARY & ALLOWANCE-DIRECT" && $root->full_name != "" ? $root->full_name : $root->bottom_head,
                    'client' => $client_name,
                    'client_code' => $client_code,
                    'report_type' => $report_type,
                    'journal_date' => $root->journal_date,
                    'journal_code' => $root->journal_code,
                    'narration' => $root->narration_text,
                    'dr' => $root->dr,
                    'cr' => $root->cr
                ]);
            }



            if (count($root_info) == 0) {
                array_push($root_info, [
                    'ledger_of' => $acc_head_info->account_name,
                    'type' => 'inflow',
                    'voucher_type' => null,
                    'root_head' => null,
                    'tran_head' => null,//$root->bottom_head == "SALARY & ALLOWANCE-DIRECT" && $root->full_name != "" ? $root->full_name : $root->bottom_head,
                    'client' => null,
                    'client_code' => null,
                    'report_type' => null,
                    'journal_code' => null,
                    'journal_date' => null,
                    'narration' => null,
                    'dr' => 0,
                    'cr' => 0
                ]);
            }

            return response()->json(['success' => true, 'data' => $root_info], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()],200);

        }
    }

    function _group_by($array, $key) {
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }

    public function patient_supplier_general_ledger($bank_bottom_head, $from_date, $to_date)
    {
        // if (empty($bank_bottom_head) || ! isset($bank_bottom_head)) {

        //     return response()->json(['success' => false, 'message' => 'Cash account head missing'], 200);

        // }

        try {

            $acc_head_info = DB::table('acct_chart_of_accounts')->where('account_code', $bank_bottom_head)->first();
            $from_date = date("Y-m-d", strtotime($from_date));
            $to_date = date("Y-m-d", strtotime($to_date));

            $root_head_inflow = DB::select(DB::raw("select ch.account_name as bottom_head,ch.account_no_pk,r1.account_name as root_head_1,r2.account_name as root_head_2,
                                                r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
                                                sum(jn.trn_cr_account_amount) as cr,
                                                sum(jn.trn_dr_account_amount) as dr,
                                                jn.journal_code,
                                                e.full_name,
                                                p.patient_name,
                                                s.supplier_name
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
                                                left join hrms_personnel_vw e
                                                on e.person_no_pk = jn.person_no_fk
                                                left join acct_vouchermst_sum_vw p
                                                on p.invoice_no_pk = jn.invoice_no_fk
                                                left join suppliers_vw s
                                                on s.supplier_no_pk = jn.supplier_no_fk
                                                where ch.posting_head_ind = 1

                                                and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'

                                                group by jn.journal_code,ch.account_name,ch.account_no_pk,r1.account_name,r2.account_name,
                                                r3.account_name,r4.account_name,r5.account_name,e.full_name,p.patient_name,s.supplier_name
            "));


            // $root_head_outflow = DB::select(DB::raw("select ch.account_name as bottom_head,r1.account_name as root_head_1,r2.account_name as root_head_2,
            //                                     r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
            //                                     sum(jn.trn_cr_account_amount) as cr,
            //                                     sum(jn.trn_dr_account_amount) as dr,
            //                                     jn.journal_code,journal_date
            //                                     from acct_chart_of_accounts ch
            //                                     left join acct_chart_of_accounts r1
            //                                     on r1.account_no_pk  = ch.account_no_fk_root_s4
            //                                     left join acct_chart_of_accounts r2
            //                                     on r2.account_no_pk = ch.account_no_fk_root_s3
            //                                     left join acct_chart_of_accounts r3
            //                                     on r3.account_no_pk  = ch.account_no_fk_root_s2
            //                                     left join acct_chart_of_accounts r4
            //                                     on r4.account_no_pk  = ch.account_no_fk_root_s1
            //                                     left join acct_chart_of_accounts r5
            //                                     on r5.account_no_pk = ch.account_no_fk_root_0
            //                                     join acct_journal_entry jn
            //                                     on jn.trn_account_no_fk  = ch.account_no_pk
            //                                     join acct_voucher_type vt
            //                                     on vt.voucher_type_no_pk = jn.voucher_type_no_fk
            //                                     where ch.posting_head_ind = 1
            //                                     and jn.journal_code in (select journal_code from acct_journal_entry where trn_account_code = $bank_bottom_head and trn_cr_account_amount > 0)
            //                                     and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'
            //                                     group by ch.account_name,r1.account_name,r2.account_name,
            //                                     r3.account_name,r4.account_name,r5.account_name,jn.journal_code,jn.journal_date
            // "));


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


                // $bottom_head = $root->bottom_head;

                // //OPD BILL PROCESS

                // if ($bank_bottom_head == 1198 && $root->patient_name != NULL) {
                //     if ($root->account_no_pk == 484) {
                //         $bottom_head = $root->patient_name;
                //     } else {
                //         $bottom_head = $root->bottom_head;
                //     }
                // }

                // if ($bank_bottom_head == 1201 && $root->patient_name != NULL) {
                //     if ($root->account_no_pk == 481) {
                //         $bottom_head = $root->patient_name;
                //     } else {
                //         $bottom_head = $root->bottom_head;
                //     }
                // }

                // if ($bank_bottom_head == 1200 && $root->patient_name != NULL) {
                //     // if ($root->account_no_pk == 481) {
                //     //     $bottom_head = $root->patient_name;
                //     // } else {
                //     //     $bottom_head = $root->bottom_head;
                //     // }

                //     if ($root->account_no_pk == 484) {
                //         $bottom_head = $root->patient_name;
                //     } else {
                //         $bottom_head = $root->bottom_head;
                //     }
                // }

                // if ($bank_bottom_head == 1172 && $root->patient_name != NULL) {
                //     if ($root->account_no_pk == 481) {
                //         $bottom_head = $root->patient_name;
                //     } else {
                //         $bottom_head = $root->bottom_head;
                //     }

                //     if ($root->account_no_pk == 521) {
                //         $bottom_head = $root->patient_name;
                //     } else {
                //         $bottom_head = $root->bottom_head;
                //     }
                // }

                // //END OPD BILL PROCESS

                // //CONSULTATION FEE
                // if ($bank_bottom_head == 1216 && $root->patient_name != NULL) {
                //     if ($root->account_no_pk == 562) {
                //         $bottom_head = $root->patient_name;
                //     } else {
                //         $bottom_head = $root->bottom_head;
                //     }
                // }

                // if ($bank_bottom_head == 1212 && $root->patient_name != NULL) {
                //     if ($root->account_no_pk == 582) {
                //         $bottom_head = $root->patient_name;
                //     } else {
                //         $bottom_head = $root->bottom_head;
                //     }
                // }

                // if ($bank_bottom_head == 1223 && $root->patient_name != NULL) {
                //     if ($root->account_no_pk == 582) {
                //         $bottom_head = $root->patient_name;
                //     } else {
                //         $bottom_head = $root->bottom_head;
                //     }
                // }

                //CONSULTATION FEE END


                //CASH LEDGER



                //if ($root->dr == 0) {
                array_push($root_info, [
                    'ledger_of' => @$acc_head_info->account_name,
                    'type' => 'inflow',
                    'root_head' => $root_head_name,
                    'tran_head' => $root->bottom_head,//$root->bottom_head == "SALARY & ALLOWANCE-DIRECT" && $root->full_name != "" ? $root->full_name : $root->bottom_head,
                    'client' => $root->patient_name,
                    'journal_code' => $root->journal_code,
                    'dr' => $root->dr,
                    'cr' => $root->cr
                ]);
                //}

                // if ($root->cr == 0) {
                //     array_push($root_info, [
                //         'ledger_of' => $acc_head_info->account_name,
                //         'type' => 'outflow',
                //         'root_head' => $root_head_name,
                //         'tran_head' => $root->bottom_head,
                //         'journal_date' => $root->journal_date,
                //         'journal_code' => $root->journal_code,
                //         'dr' => 0,
                //         'cr' => $root->dr

                //     ]);
                // }
            }

            //return $root_info;

            // foreach($root_head_outflow as $root) {
            //     $root_head_name = "";
            //     if(! empty($root->root_head_1)) {
            //         $root_head_name = $root->root_head_1;
            //     }
            //     if(! empty($root->root_head_2) &&  empty($root->root_head_1) && $root_head_name == "") {
            //         $root_head_name = $root->root_head_2;
            //     }
            //     if(! empty($root->root_head_3) &&  empty($root->root_head_1) && $root_head_name == "") {
            //         $root_head_name = $root->root_head_3;
            //     }
            //     if(! empty($root->root_head_4) &&  empty($root->root_head_1) && $root_head_name == "") {
            //         $root_head_name = $root->root_head_4;
            //     }
            //     if(! empty($root->root_head_5) &&  empty($root->root_head_1) && $root_head_name == "") {
            //         $root_head_name = $root->root_head_5;
            //     }

            //     if ($root->cr == 0) {
            //         array_push($root_info, [
            //             'ledger_of' => $acc_head_info->account_name,
            //             'type' => 'outflow',
            //             'root_head' => $root_head_name,
            //             'tran_head' => $root->bottom_head,
            //             'journal_date' => $root->journal_date,
            //             'journal_code' => $root->journal_code,
            //             'dr' => 0,
            //             'cr' => $root->dr

            //         ]);
            //     }
            // }

            if (count($root_info) == 0) {
                array_push($root_info, [
                    'ledger_of' => $acc_head_info->account_name,
                    'type' => 'inflow',
                    'root_head' => null,
                    'tran_head' => null,//$root->bottom_head == "SALARY & ALLOWANCE-DIRECT" && $root->full_name != "" ? $root->full_name : $root->bottom_head,

                    'journal_code' => null,
                    'opening_balance' => 0,
                    'dr' => 0,
                    'cr' => 0
                ]);
            }

            return response()->json(['success' => true, 'data' => $root_info], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()],200);

        }
    }


    public function subsidiary_ledger($bank_bottom_head, $from_date, $to_date)
    {
        if (empty($bank_bottom_head) || ! isset($bank_bottom_head)) {

            return response()->json(['success' => false, 'message' => 'Cash account head missing'], 200);

        }

        try {

            $acc_head_info = DB::table('acct_chart_of_accounts')->where('account_no_pk', $bank_bottom_head)->first();
            $from_date =date("Y-m-d", strtotime($from_date));
            $to_date = date("Y-m-d", strtotime($to_date));

            $root_head_inflow = DB::select(DB::raw("select ch.account_name as bottom_head,ch.account_no_pk,r1.account_name as root_head_1,r2.account_name as root_head_2,
                                                r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
                                                sum(jn.trn_cr_account_amount) as cr,
                                                sum(jn.trn_dr_account_amount) as dr,
                                                ch.account_code
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
                                                and jn.trn_account_no_fk in (select account_no_pk from acct_chart_of_accounts where account_no_fk_root_0 = $bank_bottom_head)
                                                and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'

                                                group by ch.account_code,ch.account_name,ch.account_no_pk,r1.account_name,r2.account_name,
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

                $opening_balance = $this->opening_balance->get_accounts_opening_balance($root->account_code, $from_date);

                array_push($root_info, [
                    'ledger_of' => @$acc_head_info->account_name,
                    'ledger_of_code' => @$acc_head_info->account_code,
                    'type' => 'inflow',
                    'root_head' => $root_head_name,
                    'tran_head' => $root->bottom_head,
                    'journal_code' => $root->account_code,
                    'opening_balance' =>$opening_balance->getData()->data[0]->opening_balance,
                    'dr' => $root->dr,
                    'cr' => $root->cr
                ]);
            }

            if (count($root_info) == 0) {
                array_push($root_info, [
                    'ledger_of' => $acc_head_info->account_name,
                    'ledger_of_code' => @$acc_head_info->account_code,
                    'type' => 'inflow',
                    'root_head' => null,
                    'tran_head' => null,

                    'journal_code' => null,
                    'opening_balance' => 0,
                    'dr' => 0,
                    'cr' => 0
                ]);
            }

            return response()->json(['success' => true, 'data' => $root_info], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()],200);

        }
    }

    public function general_ledger($bank_bottom_head, $from_date, $to_date)
    {
        // if (empty($bank_bottom_head) || ! isset($bank_bottom_head)) {

        //     return response()->json(['success' => false, 'message' => 'Cash account head missing'], 200);

        // }

        

        try {

            $acc_head_info = DB::table('acct_chart_of_accounts')->where('account_code', $bank_bottom_head)->first();
            $from_date = date("Y-m-d", strtotime($from_date));
            $to_date = date("Y-m-d", strtotime($to_date));

            $root_head_inflow = DB::select(DB::raw("select r5.account_no_pk root_account_no,r5.account_code account_code,r1.account_name as root_head_1,r2.account_name as root_head_2,
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
                                               
                                                where ch.posting_head_ind = 1
                                                
                                                and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'
                                                
                                                group by r1.account_name,r2.account_name,
                                                r3.account_name,r4.account_name,r5.account_no_pk,r5.account_code,r5.account_name
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

                // return "select NVL(sum(trn_dr_account_amount-trn_cr_account_amount),0) as opening_balance
                //                             from acct_journal_entry
                //                             where trn_account_code in (select account_code from acct_chart_of_accounts where account_no_fk_root_0 = $root->account_code)
                //                             and to_char(journal_date, 'YYYY-MM-DD') < '$from_date' and au_entry_hospital_pk_no = 141
                //                         ";

                $opening_balance = $this->opening_balance->get_root_accounts_opening_balance($root->root_account_no, $from_date);

                
                array_push($root_info, [
                    'ledger_of' => @$acc_head_info->account_name,
                    'type' => 'inflow',
                    'root_head' => $root_head_name,
                    'tran_head' => $root->root_head_5,//$root->bottom_head == "SALARY & ALLOWANCE-DIRECT" && $root->full_name != "" ? $root->full_name : $root->bottom_head,
                    
                    'journal_code' => $root->root_account_no,
                    'opening_balance' =>$opening_balance->getData()->data[0]->opening_balance,
                    'dr' => $root->dr,
                    'cr' => $root->cr
                ]);
            }

            
            if (count($root_info) == 0) {
                array_push($root_info, [
                    'ledger_of' => $acc_head_info->account_name,
                    'type' => 'inflow',
                    'root_head' => null,
                    'tran_head' => null,//$root->bottom_head == "SALARY & ALLOWANCE-DIRECT" && $root->full_name != "" ? $root->full_name : $root->bottom_head,
                    'client' => null,
                    'journal_date' => $from_date,
                    'journal_code' => null,
                    'dr' => 0,
                    'cr' => 0
                ]);
            }

            return response()->json(['success' => true, 'data' => $root_info], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()],200);

        }
    }
 
    public function patient_statement($bank_bottom_head, $from_date, $to_date)
    {
        if (empty($bank_bottom_head) || ! isset($bank_bottom_head)) {

            return response()->json(['success' => false, 'message' => 'Cash account head missing'], 200);

        }

        try {

            $acc_head_info = DB::table('acct_vouchermst_sum_vw')->where('patient_no_pk', $bank_bottom_head)->first();
            //return response()->json(['patient' => $acc_head_info],200);
            $from_date = date("Y-m-d", strtotime($from_date));
            $to_date = date("Y-m-d", strtotime($to_date));

            $d = 0;
            $d_1 = 0;
            $voucher_code_dr  = "";
            $voucher_code_cr  = "";

            $root_head_inflow = DB::select(DB::raw("select ch.account_name as bottom_head,ch.account_no_pk,r1.account_name as root_head_1,r2.account_name as root_head_2,
                                                r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
                                                sum(jn.trn_cr_account_amount) as cr,
                                                sum(jn.trn_dr_account_amount) as dr,
                                                jn.journal_no_pk,
                                                jn.journal_code,
                                                jn.journal_date,
                                                jn.narration_text,
                                                e.full_name,
                                                p.patient_name,
                                                s.supplier_name,
                                                vt.voucher_type_name
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
                                                left join hrms_personnel_vw e
                                                on e.person_no_pk = jn.person_no_fk
                                                left join acct_vouchermst_sum_vw p
                                                on p.invoice_no_pk = jn.invoice_no_fk
                                                left join suppliers_vw s
                                                on s.supplier_no_pk = jn.supplier_no_fk
                                                where ch.posting_head_ind = 1
                                                and jn.journal_code in (select journal_code from acct_journal_entry where patient_no_fk = $bank_bottom_head  and trn_dr_account_amount > 0)
                                                and jn.patient_no_fk = $bank_bottom_head
                                                and jn.trn_account_no_fk in (select account_no_pk from acct_chart_of_accounts where account_no_fk_root_0 in(231,684,482,441,786,401,403,743))

                                                and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'

                                                group by jn.journal_no_pk,jn.journal_code,journal_date,ch.account_name,ch.account_no_pk,r1.account_name,r2.account_name,
                                                r3.account_name,r4.account_name,r5.account_name,e.full_name,p.patient_name,s.supplier_name,vt.voucher_type_name,jn.narration_text
                                                order by jn.journal_date asc

            ")); //removed 761


            $root_head_outflow = DB::select(DB::raw("select ch.account_name as bottom_head,ch.account_no_pk,r1.account_name as root_head_1,r2.account_name as root_head_2,
            r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
            sum(jn.trn_cr_account_amount) as cr,
            sum(jn.trn_dr_account_amount) as dr,
            jn.journal_no_pk,
            jn.journal_code,
            jn.journal_date,
            jn.narration_text,
            e.full_name,
            p.patient_name,
            s.supplier_name,
            vt.voucher_type_name
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
            left join hrms_personnel_vw e
            on e.person_no_pk = jn.person_no_fk
            left join acct_vouchermst_sum_vw p
            on p.invoice_no_pk = jn.invoice_no_fk
            left join suppliers_vw s
            on s.supplier_no_pk = jn.supplier_no_fk
            where ch.posting_head_ind = 1
            and jn.journal_code in (select journal_code from acct_journal_entry where patient_no_fk = $bank_bottom_head  and trn_cr_account_amount > 0)
            and jn.patient_no_fk = $bank_bottom_head
            and jn.trn_account_no_fk in (select account_no_pk from acct_chart_of_accounts where account_no_fk_root_0 in(231,684,482,441,786,401,403,743))

            and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'

            group by jn.journal_no_pk,jn.journal_code,journal_date,ch.account_name,ch.account_no_pk,r1.account_name,r2.account_name,
            r3.account_name,r4.account_name,r5.account_name,e.full_name,p.patient_name,s.supplier_name,vt.voucher_type_name,jn.narration_text
            order by jn.journal_date asc

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

                array_push($root_info, [
                    'ledger_of' => $acc_head_info->patient_name,
                    'type' => 'inflow',
                    'voucher_type' => $root->voucher_type_name,
                    'root_head' => $root->root_head_5,
                    'tran_head' => $root->bottom_head,//$root->bottom_head == "SALARY & ALLOWANCE-DIRECT" && $root->full_name != "" ? $root->full_name : $root->bottom_head,
                    'client' => $root->patient_name,
                    'journal_date' => $root->journal_date,
                    'journal_code' => $root->journal_code,
                    'narration' => $root->narration_text,
                    'dr' => $root->dr,
                    'cr' => $root->cr
                ]);

            }


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

                array_push($root_info, [
                    'ledger_of' => $acc_head_info->patient_name,
                    'type' => 'inflow',
                    'voucher_type' => $root->voucher_type_name,
                    'root_head' => $root->root_head_5,
                    'tran_head' => $root->bottom_head,//$root->bottom_head == "SALARY & ALLOWANCE-DIRECT" && $root->full_name != "" ? $root->full_name : $root->bottom_head,
                    'client' => $root->patient_name,
                    'journal_date' => $root->journal_date,
                    'journal_code' => $root->journal_code,
                    'narration' => $root->narration_text,
                    'dr' => $root->dr,
                    'cr' => $root->cr
                ]);
            }

            if (count($root_info) == 0) {
                array_push($root_info, [
                    'ledger_of' => $acc_head_info->patient_name,
                    'type' => 'inflow',
                    'voucher_type' => null,
                    'root_head' => null,
                    'tran_head' => null,//$root->bottom_head == "SALARY & ALLOWANCE-DIRECT" && $root->full_name != "" ? $root->full_name : $root->bottom_head,
                    'client' => null,
                    'journal_date' => $from_date,
                    'journal_code' => null,
                    'narration' => null,
                    'dr' => 0,
                    'cr' => 0
                ]);
            }

            return response()->json(['success' => true, 'data' => array_unique($root_info, SORT_REGULAR)], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()],200);

        }
    }


    public function supplier_statement($bank_bottom_head, $from_date, $to_date)
    {
        if (empty($bank_bottom_head) || ! isset($bank_bottom_head)) {

            return response()->json(['success' => false, 'message' => 'Cash account head missing'], 200);

        }

        try {

            $acc_head_info = DB::table('suppliers_vw')->where('supplier_no_pk', $bank_bottom_head)->first();
            //return response()->json(['patient' => $acc_head_info],200);
            $from_date = date("Y-m-d", strtotime($from_date));
            $to_date = date("Y-m-d", strtotime($to_date));

            $d = 0;
            $d_1 = 0;
            $voucher_code_dr  = "";
            $voucher_code_cr  = "";

            $root_head_inflow = DB::select(DB::raw("select ch.account_name as bottom_head,ch.account_no_pk,r1.account_name as root_head_1,r2.account_name as root_head_2,
                                                r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
                                                sum(jn.trn_cr_account_amount) as cr,
                                                sum(jn.trn_dr_account_amount) as dr,
                                                jn.journal_no_pk,
                                                jn.journal_code,
                                                jn.journal_date,
                                                jn.narration_text,
                                                vt.voucher_type_name,
                                                s.supplier_name
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
                                                left join suppliers_vw s
                                                on s.supplier_no_pk = jn.supplier_no_fk
                                                where ch.posting_head_ind = 1
                                                and jn.journal_code in (select journal_code from acct_journal_entry where supplier_no_fk in(select supplier_no_pk from suppliers_vw where supplier_no_pk = $bank_bottom_head)  and trn_dr_account_amount > 0)
                                                and jn.trn_account_no_fk in (select account_no_pk from acct_chart_of_accounts where account_no_fk_root_0 in(761,643,786,401,403,861))
                                                and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'

                                                group by jn.journal_no_pk,jn.journal_code,journal_date,ch.account_name,ch.account_no_pk,r1.account_name,r2.account_name,
                                                r3.account_name,r4.account_name,r5.account_name,s.supplier_name,vt.voucher_type_name,jn.narration_text
                                                order by jn.journal_date asc
            "));


            $root_head_outflow = DB::select(DB::raw("select ch.account_name as bottom_head,ch.account_no_pk,r1.account_name as root_head_1,r2.account_name as root_head_2,
            r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
            sum(jn.trn_cr_account_amount) as cr,
            sum(jn.trn_dr_account_amount) as dr,
            jn.journal_no_pk,
            jn.journal_code,
            jn.journal_date,
            jn.narration_text,
            s.supplier_name,
            vt.voucher_type_name
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
            left join suppliers_vw s
            on s.supplier_no_pk = jn.supplier_no_fk
            where ch.posting_head_ind = 1
            and jn.journal_code in (select journal_code from acct_journal_entry where supplier_no_fk in(select supplier_no_pk from suppliers_vw where supplier_no_pk = $bank_bottom_head)  and trn_dr_account_amount > 0)
            and jn.trn_account_no_fk in (select account_no_pk from acct_chart_of_accounts where account_no_fk_root_0 in(761,643,786,401,403,861))
            and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'

            group by jn.journal_no_pk,jn.journal_code,journal_date,ch.account_name,ch.account_no_pk,r1.account_name,r2.account_name,
            r3.account_name,r4.account_name,r5.account_name,s.supplier_name,vt.voucher_type_name,jn.narration_text
            order by jn.journal_date asc
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

                array_push($root_info, [
                    'ledger_of' => $acc_head_info->supplier_name,
                    'type' => 'inflow',
                    'voucher_type' => $root->voucher_type_name,
                    'root_head' => $root->root_head_5,
                    'tran_head' => $root->bottom_head,//$root->bottom_head == "SALARY & ALLOWANCE-DIRECT" && $root->full_name != "" ? $root->full_name : $root->bottom_head,
                    'client' => $root->supplier_name,
                    'journal_date' => $root->journal_date,
                    'journal_code' => $root->journal_code,
                    'narration' => $root->narration_text,
                    'dr' => $root->dr,
                    'cr' => $root->cr
                ]);

            }


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

                array_push($root_info, [
                    'ledger_of' => $acc_head_info->supplier_name,
                    'type' => 'inflow',
                    'voucher_type' => $root->voucher_type_name,
                    'root_head' => $root->root_head_5,
                    'tran_head' => $root->bottom_head,//$root->bottom_head == "SALARY & ALLOWANCE-DIRECT" && $root->full_name != "" ? $root->full_name : $root->bottom_head,
                    'client' => $root->supplier_name,
                    'journal_date' => $root->journal_date,
                    'journal_code' => $root->journal_code,
                    'narration' => $root->narration_text,
                    'dr' => $root->dr,
                    'cr' => $root->cr
                ]);
            }

            if (count($root_info) == 0) {
                array_push($root_info, [
                    'ledger_of' => $acc_head_info->supplier_name,
                    'type' => 'inflow',
                    'voucher_type' => null,
                    'root_head' => null,
                    'tran_head' => null,//$root->bottom_head == "SALARY & ALLOWANCE-DIRECT" && $root->full_name != "" ? $root->full_name : $root->bottom_head,
                    'client' => null,
                    'journal_date' => $from_date,
                    'journal_code' => null,
                    'narration' => null,
                    'dr' => 0,
                    'cr' => 0
                ]);
            }

            return response()->json(['success' => true, 'data' => array_unique($root_info, SORT_REGULAR)], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()],200);

        }
    }


    public function employee_statement($bank_bottom_head, $from_date, $to_date)
    {
        if (empty($bank_bottom_head) || ! isset($bank_bottom_head)) {

            return response()->json(['success' => false, 'message' => 'Cash account head missing'], 200);

        }

        try {

            $acc_head_info = DB::table('hrms_personnel_vw')->where('person_no_pk', $bank_bottom_head)->first();
            //return response()->json(['patient' => $acc_head_info],200);
            $from_date = date("Y-m-d", strtotime($from_date));
            $to_date = date("Y-m-d", strtotime($to_date));

            $d = 0;
            $d_1 = 0;
            $voucher_code_dr  = "";
            $voucher_code_cr  = "";

            $root_head_inflow = DB::select(DB::raw("select ch.account_name as bottom_head,ch.account_no_pk,r1.account_name as root_head_1,r2.account_name as root_head_2,
                                                r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
                                                sum(jn.trn_cr_account_amount) as cr,
                                                sum(jn.trn_dr_account_amount) as dr,
                                                jn.journal_no_pk,
                                                jn.journal_code,
                                                jn.journal_date,
                                                jn.narration_text,
                                                e.full_name,
                                                vt.voucher_type_name
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
                                                left join hrms_personnel_vw e
                                                on e.person_no_pk = jn.person_no_fk
                                                where ch.posting_head_ind = 1
                                                and jn.journal_code in (select journal_code from acct_journal_entry where person_no_fk in(select person_no_pk from hrms_personnel_vw where person_no_pk = $bank_bottom_head)  and trn_dr_account_amount > 0)
                                                and jn.trn_account_no_fk in (select account_no_pk from acct_chart_of_accounts where account_no_fk_root_0 in(261,786,401,403,665))
                                                and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'

                                                group by jn.journal_no_pk,jn.journal_code,journal_date,ch.account_name,ch.account_no_pk,r1.account_name,r2.account_name,
                                                r3.account_name,r4.account_name,r5.account_name,e.full_name,vt.voucher_type_name,jn.narration_text
                                                order by jn.journal_date asc
            "));


            $root_head_outflow = DB::select(DB::raw("select ch.account_name as bottom_head,ch.account_no_pk,r1.account_name as root_head_1,r2.account_name as root_head_2,
            r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
            sum(jn.trn_cr_account_amount) as cr,
            sum(jn.trn_dr_account_amount) as dr,
            jn.journal_no_pk,
            jn.journal_code,
            jn.journal_date,
            jn.narration_text,
            e.full_name,
            vt.voucher_type_name
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
            left join hrms_personnel_vw e
            on e.person_no_pk = jn.person_no_fk
            where ch.posting_head_ind = 1
            and jn.journal_code in (select journal_code from acct_journal_entry where person_no_fk in(select person_no_pk from hrms_personnel_vw where person_no_pk = $bank_bottom_head)  and trn_dr_account_amount > 0)
            and jn.trn_account_no_fk in (select account_no_pk from acct_chart_of_accounts where account_no_fk_root_0 in(261,786,401,403,665))
            and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'

            group by jn.journal_no_pk,jn.journal_code,journal_date,ch.account_name,ch.account_no_pk,r1.account_name,r2.account_name,
            r3.account_name,r4.account_name,r5.account_name,e.full_name,vt.voucher_type_name,jn.narration_text
            order by jn.journal_date asc
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

                array_push($root_info, [
                    'ledger_of' => $acc_head_info->full_name,
                    'type' => 'inflow',
                    'voucher_type' => $root->voucher_type_name,
                    'root_head' => $root->root_head_5,
                    'tran_head' => $root->bottom_head,//$root->bottom_head == "SALARY & ALLOWANCE-DIRECT" && $root->full_name != "" ? $root->full_name : $root->bottom_head,
                    'client' => $root->full_name,
                    'journal_date' => $root->journal_date,
                    'journal_code' => $root->journal_code,
                    'narration' => $root->narration_text,
                    'dr' => $root->dr,
                    'cr' => $root->cr
                ]);

            }


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

                array_push($root_info, [
                    'ledger_of' => $acc_head_info->full_name,
                    'type' => 'inflow',
                    'voucher_type' => $root->voucher_type_name,
                    'root_head' => $root->root_head_5,
                    'tran_head' => $root->bottom_head,//$root->bottom_head == "SALARY & ALLOWANCE-DIRECT" && $root->full_name != "" ? $root->full_name : $root->bottom_head,
                    'client' => $root->full_name,
                    'journal_date' => $root->journal_date,
                    'journal_code' => $root->journal_code,
                    'narration' => $root->narration_text,
                    'dr' => $root->dr,
                    'cr' => $root->cr
                ]);
            }

            if (count($root_info) == 0) {
                array_push($root_info, [
                    'ledger_of' => $acc_head_info->full_name,
                    'type' => 'inflow',
                    'voucher_type' => null,
                    'root_head' => null,
                    'tran_head' => null,//$root->bottom_head == "SALARY & ALLOWANCE-DIRECT" && $root->full_name != "" ? $root->full_name : $root->bottom_head,
                    'client' => null,
                    'journal_date' => $from_date,
                    'journal_code' => null,
                    'narration' => null,
                    'dr' => 0,
                    'cr' => 0
                ]);
            }

            return response()->json(['success' => true, 'data' => array_unique($root_info, SORT_REGULAR)], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()],200);

        }
    }

    // Accounts v1 Method
    public function bank_statement_v1($bank_bottom_head, $from_date, $to_date)
    {
        if (empty($bank_bottom_head) || ! isset($bank_bottom_head)) {

            return response()->json(['success' => false, 'message' => 'Cash account head missing'], 200);

        }

        try {

            $acc_head_info = DB::table('acct_chart_of_accounts')->where('account_code', $bank_bottom_head)->first();
            $from_date = date("Y-m-d", strtotime($from_date));
            $to_date = date("Y-m-d", strtotime($to_date));


            $root_head_inflow = DB::select(DB::raw("select ch.account_name as bottom_head,ch.account_no_pk,r1.account_name as root_head_1,r2.account_name as root_head_2,
                                                r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
                                                sum(jn.trn_cr_account_amount) as cr,
                                                sum(jn.trn_dr_account_amount) as dr,
                                                jn.journal_code,
                                                jn.journal_date,
                                                jn.narration_text,
                                                e.full_name,
                                                e.person_no_pk,
                                                p.patient_name,
                                                p.patient_no_pk,
                                                s.supplier_name,
                                                s.supplier_no_pk,
                                                vt.voucher_type_name
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
                                                left join acct_journal_entry jn
                                                on jn.trn_account_no_fk  = ch.account_no_pk
                                                join acct_voucher_type vt
                                                on vt.voucher_type_no_pk = jn.voucher_type_no_fk
                                                left join hrms_personnel_vw e
                                                on e.person_no_pk = jn.person_no_fk
                                                left join acct_vouchermst_sum_vw p
                                                on p.invoice_no_pk = jn.invoice_no_fk
                                                left join suppliers_vw s
                                                on s.supplier_no_pk = jn.supplier_no_fk
                                                where ch.posting_head_ind = 1
                                                and jn.journal_code in (select journal_code from acct_journal_entry where trn_account_code = $bank_bottom_head)

                                                and trn_account_code! = $bank_bottom_head
                                                and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'

                                                group by jn.journal_date,jn.journal_code,ch.account_name,ch.account_no_pk,r1.account_name,r2.account_name,
                                                r3.account_name,r4.account_name,r5.account_name,e.full_name,e.person_no_pk,p.patient_name,p.patient_no_pk,s.supplier_name,s.supplier_no_pk,vt.voucher_type_name,jn.narration_text
                                                order by jn.journal_date asc
            "));
             //and jn.trn_account_no_fk not in (select account_no_pk from acct_chart_of_accounts where account_no_fk_root_0 in(723,743,665,761))

            $root_head_outflow = DB::select(DB::raw("select ch.account_name as bottom_head,r1.account_name as root_head_1,r2.account_name as root_head_2,
                                                r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
                                                sum(jn.trn_cr_account_amount) as cr,
                                                sum(jn.trn_dr_account_amount) as dr,
                                                jn.journal_code,journal_date
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
                                                and jn.journal_code in (select journal_code from acct_journal_entry where trn_account_code = $bank_bottom_head and trn_cr_account_amount > 0)
                                                and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'
                                                group by ch.account_name,r1.account_name,r2.account_name,
                                                r3.account_name,r4.account_name,r5.account_name,jn.journal_code,jn.journal_date
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

                $client_name = "";
                $client_code = "";
                $report_type = "";
                if (!empty($root->patient_name)) {
                    $client_name = $root->patient_name;
                    $client_code = $root->patient_no_pk;
                    $report_type = "patient";
                } elseif(!empty($root->full_name)) {
                    $client_name = $root->full_name;
                    $client_code = $root->person_no_pk;
                    $report_type = "employee";
                } else {
                    $client_name = $root->supplier_name;
                    $client_code = $root->supplier_no_pk;
                    $report_type = "supplier";
                }


                //if ($root->dr == 0) {
                array_push($root_info, [
                    'ledger_of' => $acc_head_info->account_name,
                    'ledger_of_code' => $acc_head_info->account_code,
                    'type' => 'inflow',
                    'voucher_type' => $root->voucher_type_name,
                    'root_head' => $root_head_name,
                    'tran_head' => $root->bottom_head,//$root->bottom_head == "SALARY & ALLOWANCE-DIRECT" && $root->full_name != "" ? $root->full_name : $root->bottom_head,
                    'client' => $client_name,
                    'client_code' => $client_code,
                    'report_type' => $report_type,
                    'journal_date' => $root->journal_date,
                    'journal_code' => $root->journal_code,
                    'narration' => $root->narration_text,
                    'dr' => $root->dr,
                    'cr' => $root->cr
                ]);
            }



            if (count($root_info) == 0) {
                array_push($root_info, [
                    'ledger_of' => $acc_head_info->account_name,
                    'type' => 'inflow',
                    'voucher_type' => null,
                    'root_head' => null,
                    'tran_head' => null,//$root->bottom_head == "SALARY & ALLOWANCE-DIRECT" && $root->full_name != "" ? $root->full_name : $root->bottom_head,
                    'client' => null,
                    'client_code' => null,
                    'report_type' => null,
                    'journal_code' => null,
                    'journal_date' => null,
                    'narration' => null,
                    'dr' => 0,
                    'cr' => 0
                ]);
            }

            return response()->json(['success' => true, 'data' => $root_info], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()],200);

        }
    }

    public function general_ledger_v1($category_type, $gl_code, $account_type, $account_description, $from_date, $to_date)
    {
        $cat_type_con = "";
        $acc_type = "";
        $description_type = "";
        $title = "";
        if($category_type != '0'){
            if($category_type == "Account Type"){
                $acc_type = isset($account_type) && $account_type != null ? $account_type : '';
                if(!empty($acc_type)){                  
                    $cat_type_con = ($acc_type != "") ? " and at.acc_4type_no_pk = '$acc_type'" : "";
                    $temp_data = DB::table('acc_coa_4accounttype')->where('acc_4type_no_pk',$acc_type)->select('acc_4type_name')->first();
                    $title = 'Account Type : '. $temp_data->acc_4type_name;
                }
            }else if($category_type == "GL"){
                $cat_type = isset($gl_code) ? $gl_code : [];
                if(!empty($cat_type)){  
                    $old_gl = $cat_type; 
                    $cat_type = implode(",",$cat_type);       
                    $cat_type_con = ($cat_type != "") ? " and ch.account_no_pk in ($cat_type)" : "";
                    $temp_data = DB::table('acct_chart_of_accounts')->whereIn('account_no_pk',$old_gl)->pluck('account_code')->toArray();
                    $title = 'GL Code : '.  implode(', ', $temp_data);
                }
               
            }else if($category_type == "Account Description"){
                $description_type = isset($account_description) && $account_description != null ? $account_description : '';
                if(!empty($description_type)){        
                    $cat_type_con = ($description_type != "") ? " and ch.acc_5typedescription_no_fk = '$description_type'" : "";
                    $temp_data = DB::table('acc_coa_5accountdescription')->where('acc_5typedescription_no_pk',$description_type)->select('acc_5type_description')->first();
                    $title = 'Account Description : '. $temp_data->acc_5type_description;
                }
            }       
        }
        
        try {
            
            $from_date =date("Y-m-d", strtotime($from_date));
            $to_date = date("Y-m-d", strtotime($to_date));
            $root_head_inflow = DB::select(DB::raw("select
            
            ch.account_name as bottom_head,
            ch.account_no_pk,                                          
            NVL(sum(jn.trn_cr_account_amount),0) as cr,
            NVL(sum(jn.trn_dr_account_amount),0) as dr,
            ch.account_code
                                                                                                  
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
            $cat_type_con
           
            group by ch.account_code,
            ch.account_name,
            ch.account_no_pk                                                                                   
            order by ch.account_code asc                               

            "));

            $root_info = [];
            foreach(collect($root_head_inflow)->sortBy('account_code')->values() as $root) {
                $opening_balance = $this->opening_balance->get_accounts_opening_balance_v1($root->account_no_pk, $root->account_code, $from_date);
                if(floatVal($root->dr) != 0 || floatVal($root->cr) != 0 || $opening_balance->getData()->data[0]->opening_balance != 0)
                    {
                        array_push($root_info, [
                                'root_head' => $root->bottom_head,
                                'tran_head' => $root->bottom_head,
                                'journal_code' => $root->account_code,
                                'opening_balance' =>$opening_balance->getData()->data[0]->opening_balance,
                                'dr' => $root->dr,
                                'cr' => $root->cr,
                                'from_date' => $from_date,
                                'to_date' => $to_date, 
                                'title'   => $title,
                                'account_no_pk' => $root->account_no_pk                
                            ]);
                    }
            }
            return response()->json(['success' => true, 'data' => $root_info], 200);
        } catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()],422);

        }
    }

    public function self_ledger_v1($acc_pk,$cash_bottom_head,$from_date,$to_date)
    {
        if (empty($cash_bottom_head) || ! isset($cash_bottom_head)) {

            return response()->json(['success' => false, 'message' => 'Cash account head missing'], 200);

        }
        
        $opening_bal = DB::select(DB::raw("select sum(trn_dr_account_amount-trn_cr_account_amount) opening_bal
        from acct_v1_journal_entry_vw
        where trn_account_code = '$cash_bottom_head' and acct_v1_journal_entry_vw.verified_ind = 1
        and trunc(journal_date) < TO_DATE('$from_date','YYYY-MM-DD')"));
        
        $opening_bal = [];
        $opening_bal_temp = $this->opening_balance->get_accounts_opening_balance_v1($acc_pk,$cash_bottom_head,$from_date);
        
        $temp_ob = new stdClass();
        $temp_ob->opening_bal = $opening_bal_temp->getData()->data[0]->opening_balance;
        array_push($opening_bal,$temp_ob);

        $ledger_details = DB::select(DB::raw("select account_name,journal_date,trunc(au_entry_at) as au_entry_at,doc_date,journal_code,voucher_type_name,prepare_by,voucher_remarks,subledger_name,narration_text,acct_subledger_no_fk, sum(trn_dr_account_amount) dr, sum(trn_cr_account_amount) cr,journal_no_pk
        from acct_v1_journal_entry_vw
        where trn_account_code = '$cash_bottom_head' and acct_v1_journal_entry_vw.verified_ind = 1 and acct_v1_journal_entry_vw.finalized_ind = 1
        and trunc(journal_date) between  TO_DATE('$from_date','YYYY-MM-DD') AND TO_DATE('$to_date','YYYY-MM-DD')
        group by account_name,journal_date,au_entry_at,doc_date,journal_code,voucher_type_name,prepare_by,voucher_remarks,subledger_name,narration_text,acct_subledger_no_fk,journal_no_pk
        order by journal_date desc"));

        $data = [];
        foreach($ledger_details as  $key => $value) {

            $condition_dr = [
                ['verified_ind', '=', 1],
                ['finalized_ind', '=', 1],
                ['journal_code', '=', $value->journal_code],
                ['trn_dr_account_amount', '>', 0],
            ];
            $temp_dr = DB::table('acct_v1_journal_entry_vw')
                        ->selectRaw('account_name,journal_date,doc_date,journal_code,voucher_type_name,prepare_by,voucher_remarks,subledger_name,narration_text,acct_subledger_no_fk, trn_dr_account_amount as dr, trn_cr_account_amount as cr')
                        ->where($condition_dr)
                        ->get();

            $condition_cr = [
                ['verified_ind', '=', 1],
                ['finalized_ind', '=', 1],
                ['journal_code', '=', $value->journal_code],
                ['trn_cr_account_amount', '>', 0],
            ];
            $temp_cr = DB::table('acct_v1_journal_entry_vw')
                        ->selectRaw('account_name,journal_date,doc_date,journal_code,voucher_type_name,prepare_by,voucher_remarks,subledger_name,narration_text,acct_subledger_no_fk, trn_dr_account_amount as dr, trn_cr_account_amount as cr')
                        ->where($condition_cr)
                        ->get();
                                                                              
           
            $account_name = DB::table('acct_v1_journal_entry_vw')
                        ->select('account_name','trn_dr_account_amount','trn_cr_account_amount')
                        ->where('verified_ind',1)
                        ->where('finalized_ind',1)
                        ->where('journal_code',$value->journal_code)
                        ->where('trn_account_code',$cash_bottom_head)
                        ->where('journal_no_pk',$value->journal_no_pk)
                        ->first();
       
            $own_cr_dr = $account_name->trn_dr_account_amount > 0 ? 'Debit' : 'Credit';
            if(count($temp_dr) == 1 && count($temp_cr) == 1){                
                $temp_data= [
                    'opposite_head' =>  $account_name->trn_dr_account_amount > 0 ? $temp_cr[0]->account_name : $temp_dr[0]->account_name,
                    'journal_code' => $value->journal_code,
                    'journal_date' => $value->journal_date,
                    'doc_date' => $value->doc_date,
                    'voucher_type_name' => $value->voucher_type_name,
                    'voucher_remarks' => $value->voucher_remarks,
                    'subledger_name' => $value->subledger_name,
                    'narration_text' => $value->narration_text,
                    'acct_subledger_no_fk' => $value->acct_subledger_no_fk,
                    'dr' => $value->dr,
                    'cr' => $value->cr,
                    'account_name' => $value->account_name,
                    
                    'prepare_by' => $value->prepare_by,
                ]; 

                if($own_cr_dr == 'Debit'){
                    $temp_data['sub_ledger_opposite_head'] = !empty($temp_cr[0]->subledger_name) ? $temp_cr[0]->subledger_name : $value->subledger_name;
                }
                else{              
                    $temp_data['sub_ledger_opposite_head'] = !empty($temp_dr[0]->subledger_name) ? $temp_dr[0]->subledger_name : $value->subledger_name;
                }
                 
                array_push($data,$temp_data);
            }
            else if(count($temp_dr) > 1 && count($temp_cr) == 1){
                
                
                if($own_cr_dr == 'Credit'){
                    
                    foreach($temp_dr as $item1){
                        $temp_data= [
                            'opposite_head' =>  $item1->account_name,
                            'journal_code' => $value->journal_code,
                            'journal_date' => $value->journal_date,
                            'doc_date' => $value->doc_date,
                            'voucher_type_name' => $value->voucher_type_name,
                            'voucher_remarks' => $item1->voucher_remarks,
                            'subledger_name' => $value->subledger_name,
                            'narration_text' => $item1->narration_text,
                            'acct_subledger_no_fk' => $value->acct_subledger_no_fk,
                            'dr' => $item1->cr,
                            'cr' => $item1->dr,
                            'account_name' => $value->account_name,
                            'prepare_by' => $value->prepare_by,
                        ];             
                        $temp_data['sub_ledger_opposite_head'] = !empty($item1->subledger_name) ? $item1->subledger_name : $value->subledger_name;
                        array_push($data,$temp_data); 
                    }
                      
                }
                else{
                    $temp_data= [
                        'opposite_head' =>  $temp_cr[0]->account_name,
                        'journal_code' => $value->journal_code,
                        'journal_date' => $value->journal_date,
                        'doc_date' => $value->doc_date,
                        'voucher_type_name' => $value->voucher_type_name,
                        'voucher_remarks' => $value->voucher_remarks,
                        'subledger_name' => $value->subledger_name,
                        'narration_text' => $value->narration_text,
                        'acct_subledger_no_fk' => $value->acct_subledger_no_fk,
                        'dr' => $value->dr,
                        'cr' => $value->cr,
                        'account_name' => $value->account_name,              
                        'prepare_by' => $value->prepare_by,
                    ];    
                     $temp_data['sub_ledger_opposite_head'] = !empty($temp_cr[0]->subledger_name) ? $temp_cr[0]->subledger_name : $value->subledger_name;              
                    array_push($data,$temp_data);
                }
                
            }
            else if(count($temp_dr) == 1 && count($temp_cr) > 1){
                
                
                if($own_cr_dr == 'Debit'){
                    
                    foreach($temp_cr as $item2){
                        $temp_data= [
                            'opposite_head' =>  $item2->account_name,
                            'journal_code' => $value->journal_code,
                            'journal_date' => $value->journal_date,
                            'doc_date' => $value->doc_date,
                            'voucher_type_name' => $value->voucher_type_name,
                            'voucher_remarks' => $item2->voucher_remarks,
                            'subledger_name' => $value->subledger_name,
                            'narration_text' => $item2->narration_text,
                            'acct_subledger_no_fk' => $value->acct_subledger_no_fk,
                            'dr' => $item2->cr,
                            'cr' => $item2->dr,
                            'account_name' => $value->account_name,
                            'prepare_by' => $value->prepare_by,
                        ];     
                         $temp_data['sub_ledger_opposite_head'] = !empty($item2->subledger_name) ? $item2->subledger_name : $value->subledger_name;                           
                        array_push($data,$temp_data); 
                    }
                      
                }
                else{
                    $temp_data= [
                        'opposite_head' =>  $temp_dr[0]->account_name,
                        'journal_code' => $value->journal_code,
                        'journal_date' => $value->journal_date,
                        'doc_date' => $value->doc_date,
                        'voucher_type_name' => $value->voucher_type_name,
                        'voucher_remarks' => $value->voucher_remarks,
                        'subledger_name' => $value->subledger_name,
                        'narration_text' => $value->narration_text,
                        'acct_subledger_no_fk' => $value->acct_subledger_no_fk,
                        'dr' => $value->dr,
                        'cr' => $value->cr,
                        'account_name' => $value->account_name,
                        'sub_ledger_opposite_head' => $value->subledger_name,
                        'prepare_by' => $value->prepare_by,
                    ]; 
                    $temp_data['sub_ledger_opposite_head'] = !empty($temp_dr[0]->subledger_name) ? $temp_dr[0]->subledger_name : $value->subledger_name;                                            
                    array_push($data,$temp_data);
                }
                
            }
            else if(count($temp_dr) > 1 && count($temp_cr) > 1){
                $temp_data= [
                    'opposite_head' =>  $value->account_name,
                    'journal_code' => $value->journal_code,
                    'journal_date' => $value->journal_date,
                    'doc_date' => $value->doc_date,
                    'voucher_type_name' => $value->voucher_type_name,
                    'voucher_remarks' => $value->voucher_remarks,
                    'subledger_name' => $value->subledger_name,
                    'narration_text' => $value->narration_text,
                    'acct_subledger_no_fk' => $value->acct_subledger_no_fk,
                    'dr' => $value->dr,
                    'cr' => $value->cr,
                    'account_name' => $value->account_name,
                    'sub_ledger_opposite_head' => $value->subledger_name,
                    'prepare_by' => $value->prepare_by,
                ]; 
                 
                array_push($data,$temp_data);
            }
             
        }


        return response()->json([
            'success' => true,
            'message' => 'Ledger Statement',
            'opening_bal' => $opening_bal,
            'ledger_details' => $data,
        ]);
    }

    public function self_ledger_summary_v1($cash_bottom_head,$from_date,$to_date)
    {
        if (empty($cash_bottom_head) || ! isset($cash_bottom_head)) {

            return response()->json(['success' => false, 'message' => 'Cash account head missing'], 200);

        }
        
        $ledger_details = DB::select(DB::raw("select subledger_name,acct_subledger_no_fk, sum(trn_dr_account_amount) dr, sum(trn_cr_account_amount) cr
        from acct_v1_journal_entry_vw
        where trn_account_code = '$cash_bottom_head' and verified_ind = 1 and finalized_ind = 1 and acct_subledger_no_fk != 0
        and trunc(journal_date) between  TO_DATE('$from_date','YYYY-MM-DD') AND TO_DATE('$to_date','YYYY-MM-DD')
        group by subledger_name,acct_subledger_no_fk
        order by acct_subledger_no_fk asc"));
        $data = [];

        foreach($ledger_details as $item){
                $opening_balance = $this->sub_ledger_name_opening_bal($item->acct_subledger_no_fk,$from_date);
            
            $d = [
                'acct_subledger_no_fk' => $item->acct_subledger_no_fk,
                'subledger_name' => $item->subledger_name,
                'opening_bal' => $opening_balance[0]->opening_bal ?? 0,
                'dr' => $item->dr,
                'cr' => $item->cr
            ];
            array_push($data,$d);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Summary Statement',
            'ledger_details' => $data
        ]);
    }

    public function self_ledger_summary_v1_temp($cash_bottom_head,$from_date,$to_date)
    {
        if (empty($cash_bottom_head) || ! isset($cash_bottom_head)) {

            return response()->json(['success' => false, 'message' => 'Cash account head missing'], 200);

        }
        

        
        $ledger_details = DB::select(DB::raw("
                select subledger_name,
                acct_subledger_no_fk,
                sum(trn_dr_account_amount) dr,
                sum(trn_cr_account_amount) cr
                from acct_v1_journal_entry_vw
                where trn_account_code = '$cash_bottom_head' and verified_ind = 1 and finalized_ind = 1 and acct_subledger_no_fk != 0
                and trunc(journal_date) between  TO_DATE('$from_date','YYYY-MM-DD') AND TO_DATE('$to_date','YYYY-MM-DD')
                group by subledger_name,
                acct_subledger_no_fk
                order by lower(subledger_name) asc 
        "));


        
        $ledger_details_2 = DB::select(DB::raw("
            select subledger_name,
            acct_subledger_no_fk,
            trn_account_code,
            0 dr,
            0 cr
            from acct_v1_journal_entry_vw
            where trn_account_code = '$cash_bottom_head' and verified_ind = 1 and finalized_ind = 1 and  acct_subledger_no_fk != 0
            and trunc(journal_date) <  TO_DATE('$from_date','YYYY-MM-DD')
            group by subledger_name,acct_subledger_no_fk,trn_account_code
            order by lower(subledger_name) asc
        "));
        // dd($ledger_details,$ledger_details_2);
        $prev_ledger_fk = collect($ledger_details)->pluck('acct_subledger_no_fk')->toArray();

        foreach ($ledger_details_2 as $key => $value) {
            if(!in_array($value->acct_subledger_no_fk, $prev_ledger_fk)){
                 $temp = (object)[
                    'acct_subledger_no_fk' => $value->acct_subledger_no_fk,
                    'subledger_name' => $value->subledger_name,
                    'dr' => 0,
                    'cr' => 0,
                 ];               
                 array_push($ledger_details,$temp);
            }
        }
        
        $data = [];
        foreach($ledger_details as $item){
                $opening_balance = $this->sub_ledger_name_opening_bal_by_gl_code($cash_bottom_head,$item->acct_subledger_no_fk,$from_date);
            
            $d = [
                'acct_subledger_no_fk' => $item->acct_subledger_no_fk,
                'subledger_name' => $item->subledger_name,
                'opening_bal' => isset($opening_balance[0]->opening_bal) ? $opening_balance[0]->opening_bal : 0,
                'dr' => $item->dr,
                'cr' => $item->cr
            ];
            array_push($data,$d);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Summary Statement',
            'ledger_details' => $data
        ]);
    }
    

    public function sub_ledger_name_opening_bal($acct_subledger_no_fk,$from_date){

        $opening_bal = DB::select(DB::raw("select sum(trn_dr_account_amount-trn_cr_account_amount) opening_bal
        from acct_v1_journal_entry_vw
        where verified_ind = 1 and finalized_ind = 1 and acct_subledger_no_fk = '$acct_subledger_no_fk'
        and trunc(journal_date) < TO_DATE('$from_date','YYYY-MM-DD')"));

        return $opening_bal;
    }

    public function sub_ledger_name_opening_bal_by_gl_code($gl_code,$acct_subledger_no_fk,$from_date){

        $opening_bal = DB::select(DB::raw("select sum(trn_dr_account_amount-trn_cr_account_amount) opening_bal
        from acct_v1_journal_entry_vw
        where verified_ind = 1 and finalized_ind = 1 and acct_subledger_no_fk = '$acct_subledger_no_fk' and trn_account_code = '$gl_code'
        and trunc(journal_date) < TO_DATE('$from_date','YYYY-MM-DD')"));

        return $opening_bal;
    }

    
    public function subledger_self_ledger_v1($gl_code,$subledger_id,$from_date,$to_date)
    {
        if (empty($subledger_id) || ! isset($subledger_id)) {

            return response()->json(['success' => false, 'message' => 'Cash account head missing'], 200);

        }
       $glCodeCondition=!empty($gl_code) ? "and trn_account_code = '$gl_code'" :'';
        $opening_bal = DB::select(DB::raw("select sum(trn_dr_account_amount-trn_cr_account_amount) opening_bal
        from acct_v1_journal_entry_vw
        where verified_ind = 1 and finalized_ind = 1 and acct_subledger_no_fk = '$subledger_id'
        and trunc(journal_date) < TO_DATE('$from_date','YYYY-MM-DD') $glCodeCondition "));
        //  dd(  $opening_bal);
        $sql = "";
        $sql = "select journal_date,journal_code,account_name,acct_subledger_no_fk,doc_date,bank_cheq_number,bank_cheq_date,journal_code,voucher_type_name,prepare_by,voucher_remarks,subledger_name,narration_text,patient_name,patient_no_fk,full_name,person_no_fk,supplier_name,supplier_no_fk, sum(trn_dr_account_amount) dr, sum(trn_cr_account_amount) cr
        from acct_v1_journal_entry_vw
        where verified_ind = 1 and finalized_ind = 1 and acct_subledger_no_fk = '$subledger_id'";
       
        if(!empty($gl_code)){
            $sql.="and trn_account_code = '$gl_code'";
        }

        $sql.=" and trunc(journal_date) between  TO_DATE('$from_date','YYYY-MM-DD') AND TO_DATE('$to_date','YYYY-MM-DD')
        group by journal_date,journal_code,account_name,acct_subledger_no_fk,doc_date,bank_cheq_number,bank_cheq_date,journal_code,voucher_type_name,prepare_by,voucher_remarks,subledger_name,narration_text,patient_name,patient_no_fk,full_name,person_no_fk,supplier_name,supplier_no_fk
        order by journal_date asc";
        $ledger_details = DB::select(DB::raw($sql));

        return response()->json([
            'success' => true,
            'message' => 'subLedger Statement',
            'opening_bal' => $opening_bal,
            'ledger_details' => $ledger_details,
        ]);
    }

    public function subledger_self_ledger_individual_v1($journal_code,$gl_code,$subledger_id,$from_date,$to_date)
    {
        
        // if (empty($subledger_id) || ! isset($subledger_id)) {

        //     return response()->json(['success' => false, 'message' => 'Cash account head missing'], 200);

        // }
     
        $opening_bal = DB::select(DB::raw("select sum(trn_dr_account_amount-trn_cr_account_amount) opening_bal
        from acct_v1_journal_entry_vw
        where verified_ind = 1 and finalized_ind = 1 and acct_subledger_no_fk = '$subledger_id' and trn_account_code = '$gl_code'
        and trunc(journal_date) < TO_DATE('$from_date','YYYY-MM-DD')"));

        $ledger_details = DB::select(DB::raw("select journal_date,journal_code,account_name,acct_subledger_no_fk,doc_date,bank_cheq_number,bank_cheq_date,journal_code,voucher_type_name,prepare_by,voucher_remarks,subledger_name,narration_text,patient_name,patient_no_fk,full_name,person_no_fk,supplier_name,supplier_no_fk, sum(trn_dr_account_amount) dr, sum(trn_cr_account_amount) cr
        from acct_v1_journal_entry_vw
        where verified_ind = 1 and finalized_ind = 1 and acct_subledger_no_fk = '$subledger_id' and trn_account_code = '$gl_code' and journal_code = '$journal_code'
        and trunc(journal_date) between  TO_DATE('$from_date','YYYY-MM-DD') AND TO_DATE('$to_date','YYYY-MM-DD')
        group by journal_date,journal_code,account_name,acct_subledger_no_fk,doc_date,bank_cheq_number,bank_cheq_date,journal_code,voucher_type_name,prepare_by,voucher_remarks,subledger_name,narration_text,patient_name,patient_no_fk,full_name,person_no_fk,supplier_name,supplier_no_fk
        order by journal_date asc"));

        return response()->json([
            'success' => true,
            'message' => 'subLedger Statement',
            'opening_bal' => $opening_bal,
            'ledger_details' => $ledger_details,
        ]);
    }

    public function subledger_self_ledger_v1_all($sql,$from_date,$to_date)
    {
       
        $opening_bal = DB::select(DB::raw("select NVL(sum(trn_dr_account_amount-trn_cr_account_amount),0) opening_bal
        from acct_v1_journal_entry_vw
        where $sql and verified_ind = 1 and finalized_ind = 1
        and trunc(journal_date) < TO_DATE('$from_date','YYYY-MM-DD')"));

        $ledger_details = DB::select(DB::raw("select journal_date,journal_code,acct_subledger_no_fk,doc_date,bank_cheq_number,bank_cheq_date,journal_code,voucher_type_name,prepare_by,voucher_remarks,subledger_name,narration_text,subledgertype_name,trn_account_code,account_name,sum(trn_dr_account_amount) dr, sum(trn_cr_account_amount) cr
        from acct_v1_journal_entry_vw
        where $sql and verified_ind = 1 and finalized_ind = 1 
        and trunc(journal_date) between  TO_DATE('$from_date','YYYY-MM-DD') AND TO_DATE('$to_date','YYYY-MM-DD')
        group by journal_date,journal_code,acct_subledger_no_fk,doc_date,bank_cheq_number,bank_cheq_date,journal_code,voucher_type_name,prepare_by,voucher_remarks,subledger_name,narration_text,subledgertype_name,trn_account_code,account_name
        order by journal_date asc"));
        return response()->json([
            'success' => true,
            'message' => 'subLedger Statement',
            'opening_bal' => $opening_bal,
            'ledger_details' => $ledger_details,
            // 'closing_bal' => $closing_bal
        ]);
    }


    public function subledger_self_ledger_v1_without_name($sql,$from_date,$to_date)
    {
       


        $ledger_details = DB::select(DB::raw("select subledger_code,acct_subledger_no_fk,subledger_name,sum(trn_dr_account_amount) dr, sum(trn_cr_account_amount) cr
        from acct_v1_journal_entry_vw
        where $sql and acct_subledger_no_fk != 0 and verified_ind = 1 and finalized_ind = 1
        and trunc(journal_date) between  TO_DATE('$from_date','YYYY-MM-DD') AND TO_DATE('$to_date','YYYY-MM-DD')
        group by subledger_code,acct_subledger_no_fk, subledger_name
        order by lower(subledger_name) asc"));



        // dd( $ledger_details );
        foreach($ledger_details as $item){
            $data = DB::select(DB::raw("
                                    select NVL(sum(trn_dr_account_amount-trn_cr_account_amount),0) opening_bal
                                    from acct_v1_journal_entry_vw
                                    where $sql and acct_subledger_no_fk = '$item->acct_subledger_no_fk' and verified_ind = 1 and finalized_ind = 1
                                    and trunc(journal_date) < TO_DATE('$from_date','YYYY-MM-DD')
                                "));

            $item->opening_bal = 0;
            if(isset($data[0]->opening_bal)){
                $item->opening_bal = $data[0]->opening_bal;
            }
        }
        

        return response()->json([
            'success' => true,
            'message' => 'subLedger Statement',
            'ledger_details' => $ledger_details,
        ]);
    }



    public function general_ledger_wise_report($acc_pk,$from_date,$to_date)
    {




        $cash_bottom_head = DB::table("acct_chart_of_accounts")->where('account_no_pk',$acc_pk)->value('account_code');

        $opening_bal_temp = $this->opening_balance->get_accounts_opening_balance_v1($acc_pk, $cash_bottom_head, $from_date);

        $open_bl = isset($opening_bal_temp->getData()->data[0]->opening_balance) ? $opening_bal_temp->getData()->data[0]->opening_balance : 0;

        $ledger_details = DB::table("acct_v1_journal_entry_vw")
                                ->select(
                                        'account_name',
                                        'journal_date',
                                        'au_entry_at',
                                        'doc_date',
                                        'journal_code',
                                        'voucher_type_name',
                                        'prepare_by',
                                        'voucher_remarks',
                                        'subledger_name',
                                        'narration_text',
                                        'acct_subledger_no_fk',
                                        'trn_dr_account_amount as dr',
                                        'trn_cr_account_amount as cr',
                                        'journal_no_pk',
                                        'bank_cheq_date',
                                        'bank_cheq_number'
                                );
                                if(!empty($from_date) && !empty($to_date)){
                                    $ledger_details->whereRaw("to_char(journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'");
                                }
                                            
        $ledger_details =   $ledger_details->where('trn_account_no_fk',$acc_pk)
                                            ->where('verified_ind',1)
                                            ->where('finalized_ind',1)
                                            ->orderByDesc('journal_date')->get();

                  
        return response()->json([
            'success' => true,
            'opening_bal' => $open_bl,
            'ledger_details' => $ledger_details,
        ]);
    }



    public function generate_bank_report($acc_pk,$from_date,$to_date)
    {




        $cash_bottom_head = DB::table("acct_chart_of_accounts")->where('account_no_pk',$acc_pk)->value('account_code');

        $opening_bal_temp = $this->opening_balance->get_accounts_opening_balance_v1($acc_pk, $cash_bottom_head, $from_date);

        $open_bl = isset($opening_bal_temp->getData()->data[0]->opening_balance) ? $opening_bal_temp->getData()->data[0]->opening_balance : 0;

        $ledger_details = DB::table("acct_v1_journal_entry_vw")
                                ->select(
                                        'account_name',
                                        'journal_date',
                                        'au_entry_at',
                                        'doc_date',
                                        'journal_code',
                                        'voucher_type_name',
                                        'prepare_by',
                                        'voucher_remarks',
                                        'subledger_name',
                                        'narration_text',
                                        'acct_subledger_no_fk',
                                        'trn_dr_account_amount as dr',
                                        'trn_cr_account_amount as cr',
                                        'journal_no_pk',
                                        'bank_cheq_date',
                                        'bank_ac_no',
                                        'bank_address',
                                        'bank_cheq_number'
                                );
                                if(!empty($from_date) && !empty($to_date)){
                                    $ledger_details->whereRaw("to_char(journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'");
                                }
                                            
        $ledger_details =   $ledger_details->where('trn_account_no_fk',$acc_pk)
                                            ->where('verified_ind',1)
                                            ->where('finalized_ind',1)
                                            ->orderByDesc('journal_date')->get();

  
        return response()->json([
            'success' => true,
            'opening_bal' => $open_bl,
            'ledger_details' => $ledger_details,
        ]);
    }
}