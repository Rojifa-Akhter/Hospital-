<?php

namespace App\Core\Accounts\OpeningBalance;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Core\Accounts\OpeningBalance\OpeningBalance;
class OpeningBalanceDetails implements OpeningBalance
{
    public function get_employee_opening_balance($acc_code, $date)
    {
        $date = date("Y-m-d", strtotime($date));
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        
        $get_balance = DB::select(DB::raw("select NVL(sum(trn_dr_account_amount-trn_cr_account_amount),0) as opening_balance
                                            from acct_journal_entry
                                            where person_no_fk = $acc_code
                                            and trn_account_no_fk in (select account_no_pk from acct_chart_of_accounts where account_no_fk_root_0 in(410,501,658,743))
                                            and to_char(journal_date, 'YYYY-MM-DD') < '$date' and au_entry_hospital_pk_no = $ses_hospital_id
                                        ")
        );

        return response()->json(['success' => true, 'data' => $get_balance], 200);
    }

    public function get_supplier_opening_balance($acc_code, $date)
    {
        $date = date("Y-m-d", strtotime($date));
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        
        $get_balance = DB::select(DB::raw("select NVL(sum(trn_dr_account_amount-trn_cr_account_amount),0) as opening_balance
                                            from acct_journal_entry
                                            where supplier_no_fk = $acc_code
                                            and trn_account_no_fk in (select account_no_pk from acct_chart_of_accounts where account_no_fk_root_0 in(405))
                                            and to_char(journal_date, 'YYYY-MM-DD') < '$date' and au_entry_hospital_pk_no = $ses_hospital_id
                                        ")
        );

        return response()->json(['success' => true, 'data' => $get_balance], 200);
    }

    public function get_patient_opening_balance($acc_code, $date)
    {
        $date = date("Y-m-d", strtotime($date));
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        
        $get_balance = DB::select(DB::raw("select NVL(sum(trn_dr_account_amount-trn_cr_account_amount),0) as opening_balance
                                            from acct_journal_entry
                                            where patient_no_fk = $acc_code
                                            and trn_account_no_fk in (select account_no_pk from acct_chart_of_accounts where account_no_fk_root_0 in(418,581,627,621,623,783,441,629))
                                            and to_char(journal_date, 'YYYY-MM-DD') < '$date' and au_entry_hospital_pk_no = $ses_hospital_id
                                        ")
        );

        return response()->json(['success' => true, 'data' => $get_balance], 200);
    }

    public function get_accounts_opening_balance($acc_code, $date)
    {
        $date = date("Y-m-d", strtotime($date));
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $get_balance = DB::select(DB::raw("select NVL(sum(trn_dr_account_amount-trn_cr_account_amount),0) as opening_balance
                                            from acct_journal_entry
                                            where trn_account_code = $acc_code
                                            and to_char(journal_date, 'YYYY-MM-DD') < '$date' and au_entry_hospital_pk_no = $ses_hospital_id
                                        ")
        );

        return response()->json(['success' => true, 'data' => $get_balance], 200);
    }

    public function get_all_bank_opening_balance($date)
    {
        $date = date("Y-m-d", strtotime($date));
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $get_balance = DB::select(DB::raw("select NVL(sum(trn_dr_account_amount-trn_cr_account_amount),0) as opening_balance
                                            from acct_journal_entry
                                            where trn_account_code in(select  account_code from acct_chart_of_accounts where account_no_fk_root_0 = 403)
                                            and to_char(journal_date, 'YYYY-MM-DD') < '$date' and au_entry_hospital_pk_no = $ses_hospital_id
                                        ")
        );

        return response()->json(['success' => true, 'data' => $get_balance], 200);
    }

    public function get_root_accounts_opening_balance($acc_code, $date)
    {
        $date = date("Y-m-d", strtotime($date));
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        
        $get_balance = DB::select(DB::raw("select NVL(sum(trn_dr_account_amount-trn_cr_account_amount),0) as opening_balance
        from acct_journal_entry
        where trn_account_no_fk in (select account_no_pk from acct_chart_of_accounts where account_no_fk_root_0 = $acc_code)
        and to_char(journal_date, 'YYYY-MM-DD') < '$date' and au_entry_hospital_pk_no = $ses_hospital_id
                                        ")
        );

        return response()->json(['success' => true, 'data' => $get_balance], 200);
    }

    //Accounts V1 Method
    
    public function get_accounts_opening_balance_v1($acc_pk, $acc_code, $date)
    {
        $date = date("Y-m-d", strtotime($date));
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        
        $all_ob = DB::table('acct_openingbalance_vw')
                    ->select('opbal_no_pk', 'trn_cr_account_amount', 'trn_dr_account_amount','opbal_enddate','opbal_startdate')
                    ->where('trn_account_no_fk', $acc_pk)
                    ->where('trn_account_code', $acc_code)
                    ->where('status', 1)
                    ->where('au_entry_hospital_pk_no', $ses_hospital_id)
                    ->whereRaw("TO_CHAR(opbal_enddate, 'YYYY-MM-DD') < '$date'")
                    ->selectRaw("ABS(FLOOR(opbal_enddate - TO_DATE('$date', 'YYYY-MM-DD'))) AS day_difference")
                    ->orderByRaw("ABS(FLOOR(opbal_enddate - TO_DATE('$date', 'YYYY-MM-DD')))")
                    ->first();

        $get_balance = [];
        $orginal_from_date = $date;
        $ob_end_date = null;
        if(isset($all_ob->opbal_enddate)){
            $ob_end_date = date("Y-m-d", strtotime($all_ob->opbal_enddate));
        }
        
        $current_period_ob = $this->current_period_ob($acc_pk, $acc_code, $ob_end_date, $orginal_from_date);
        $obdr = isset($all_ob->trn_dr_account_amount) ? $all_ob->trn_dr_account_amount : 0;
        $obcr = isset($all_ob->trn_cr_account_amount) ? $all_ob->trn_cr_account_amount : 0;
        $temp = [
            'opening_balance' => (floatVal($obdr) + floatVal($current_period_ob[0]->opening_balance_dr)) - (floatVal($obcr) + floatVal($current_period_ob[0]->opening_balance_cr)),
            
        ];
  
        array_push($get_balance,$temp);
        return response()->json(['success' => true, 'data' => $get_balance], 200);
    }
    
    public function get_accounts_opening_balance_1($acc_pk,$acc_code, $date)
    {
        $date = date("Y-m-d", strtotime($date));
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $all_ob = DB::table('acct_openingbalance_vw')
                    ->select('opbal_no_pk', 'trn_cr_account_amount', 'trn_dr_account_amount','opbal_enddate','opbal_startdate','retained_earnings_ind')
                    ->where('trn_account_no_fk', $acc_pk)
                    ->where('trn_account_code', $acc_code)
                    ->where('status', 1)
                    ->where('au_entry_hospital_pk_no', $ses_hospital_id)
                    // ->where('retained_earnings_ind','!=',1)
                    ->whereRaw("TO_CHAR(opbal_enddate, 'YYYY-MM-DD') < '$date'")
                    ->selectRaw("ABS(FLOOR(opbal_enddate - TO_DATE('$date', 'YYYY-MM-DD'))) AS day_difference")
                    ->orderByRaw("ABS(FLOOR(opbal_enddate - TO_DATE('$date', 'YYYY-MM-DD')))")
                    ->first();

        $get_balance = [];
        $orginal_from_date = $date;
        $ob_end_date = null;
        if(isset($all_ob->opbal_enddate)){
            $ob_end_date = date("Y-m-d", strtotime($all_ob->opbal_enddate));
        }
   
        $current_period_ob = $this->current_period_ob($acc_pk, $acc_code, $ob_end_date, $orginal_from_date);
        
        if(isset($all_ob->trn_dr_account_amount)){
            if($all_ob->retained_earnings_ind == 1){
                $obdr = 0;
                $obcr = 0;
            }
            else{
                $obdr = isset($all_ob->trn_dr_account_amount) ? $all_ob->trn_dr_account_amount : 0;
                $obcr = isset($all_ob->trn_cr_account_amount) ? $all_ob->trn_cr_account_amount : 0;
            }
        }else{           
            $obdr = isset($all_ob->trn_dr_account_amount) ? $all_ob->trn_dr_account_amount : 0;
            $obcr = isset($all_ob->trn_cr_account_amount) ? $all_ob->trn_cr_account_amount : 0;
        }
        
        
        $temp = [
            'opening_balance_dr' => floatVal($obdr) + floatVal($current_period_ob[0]->opening_balance_dr),
            'opening_balance_cr' => floatVal($obcr) + floatVal($current_period_ob[0]->opening_balance_cr)
        ];
        array_push($get_balance,$temp);
 
        return response()->json(['success' => true, 'data' => $get_balance], 200);
    }

    public function current_period_ob($acc_pk,$acc_code, $ob_end_date, $orginal_from_date)
    {
        if($ob_end_date != null){
            $ob_end_date = date("Y-m-d", strtotime($ob_end_date));
        }
        $orginal_from_date = date("Y-m-d", strtotime($orginal_from_date));
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $sql = "select NVL(sum(trn_dr_account_amount),0) as opening_balance_dr, NVL(sum(trn_cr_account_amount),0) as opening_balance_cr
                    from acct_journal_entry
                    where trn_account_code = $acc_code and trn_account_no_fk = $acc_pk
                    and verified_ind = 1 and finalized_ind = 1 and au_entry_hospital_pk_no = $ses_hospital_id";

        if($ob_end_date != null){
            $sql.=" and to_char(journal_date, 'YYYY-MM-DD') > '$ob_end_date' and to_char(journal_date, 'YYYY-MM-DD') < '$orginal_from_date' ";
        }
        else{
            
            $sql.=" and to_char(journal_date, 'YYYY-MM-DD') < '$orginal_from_date'";
        }

                
        $get_balance = DB::select(DB::raw($sql));

        return $get_balance;
    }


    public function get_bank_accounts_balance_v1($acc_pk,$date){
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $sql = "select trn_account_no_fk,NVL(sum(trn_dr_account_amount),0) - NVL(sum(trn_cr_account_amount),0) as opening_balance
                from acct_journal_entry
                where  trn_account_no_fk = '$acc_pk'
                and verified_ind = 1 and finalized_ind = 1 and au_entry_hospital_pk_no = $ses_hospital_id";
        if(!empty($date)){
            $sql.=" and TO_CHAR(journal_date,'MM/YYYY') = '$date' ";
        }
        $sql.=" group by trn_account_no_fk";

        $get_balance = DB::select(DB::raw($sql));
        return $get_balance;
    }

    public function get_bank_accounts_journal($acc_pk,$date){
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $get_balance = DB::table('acct_journal_entry')
        ->where('verified_ind', 1)
        ->where('finalized_ind', 1)
        ->where('trn_account_no_fk',$acc_pk)->where('au_entry_hospital_pk_no',$ses_hospital_id)->whereRaw("TO_CHAR(journal_date,'MM/YYYY') = '$date'")->pluck('journal_code')->toArray();
        return $get_balance;
    }

    public function get_bank_accounts_reconcil_balance_v1($acc_pk, $date){
        $journals = $this->get_bank_accounts_journal($acc_pk, $date);
        $booked_balance = DB::table('acct_bank_reconcile')->whereIn('journal_code',$journals)->where('verified_ind',1)->where('finalized_ind',1)->select('*')->get();
        return $booked_balance;
        
    }

    public function get_bank_accounts_not_reconciled($acc_pk, $con)
    {
        $getBalance = DB::table('acc_bankreconcile_vw')
            ->where('trn_account_no_fk', $acc_pk)
            ->whereRaw($con)
            ->whereNull('finalized_ind')
            ->whereNull('verified_ind')
            ->select(
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
                'bank_cheq_number',
                'bank_cheq_date',
                'journal_no_pk',
                'commission_indicator'
            )
            ->orderByDesc('journal_date')
            ->get();

        return $getBalance;
    }

    public function get_bank_accounts_verified_reconciled($acc_pk, $con){

        $get_balance = DB::table('acc_bankreconcile_vw')
            ->where('trn_account_no_fk', $acc_pk)
            ->whereRaw($con)
            ->where('finalized_ind', 0)
            ->where('verified_ind', 1)
            ->select([
                'bank_cheq_number',
                'bank_cheq_date',
                'trn_cr_account_amount',
                'trn_dr_account_amount',
                'reconcile_date',
                'cr_amount',
                'dr_amount',
                'journal_code',
                'journal_date',
                'finalized_ind',
                'reconcile_no_pk',
                'remarks',
                'flag',
                'verified_ind',
                'verified_entry_by',
                'finalized_entry_by',
                'voucher_type_no_fk',
                'trn_account_no_fk',
                'trn_account_code',
                'bank_cheq_number',
                'bank_cheq_date',
                'journal_no_pk',
                'commission_indicator'
            ])
            ->orderByDesc('journal_date')
            ->get();

        return $get_balance;
        
    }

    public function get_bank_accounts_reconciled($acc_pk, $con){

            $get_balance = DB::table('acc_bankreconcile_vw')                    
                            ->where('trn_account_no_fk',$acc_pk)
                            ->whereRaw($con)
                            ->where('finalized_ind',1)
                            ->where('verified_ind',1)
                            ->select(
                                'bank_cheq_number',
                                'bank_cheq_date',
                                'trn_cr_account_amount',
                                'trn_dr_account_amount',
                                'reconcile_date',
                                'cr_amount',
                                'dr_amount',
                                'journal_code',
                                'journal_date',
                                'finalized_ind',
                                'reconcile_no_pk',
                                'remarks',
                                'flag',
                                'verified_ind',
                                'verified_entry_by',
                                'finalized_entry_by',
                                'voucher_type_no_fk',
                                'trn_account_no_fk',
                                'trn_account_code',
                                'bank_cheq_number',
                                'bank_cheq_date',
                                'journal_no_pk'
                                )->orderByDesc('journal_date')
                            ->get();



            return $get_balance;
        
    }
}