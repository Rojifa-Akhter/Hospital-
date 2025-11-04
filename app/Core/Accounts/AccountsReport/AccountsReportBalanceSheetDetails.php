<?php

namespace App\Core\Accounts\AccountsReport;

use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use illuminate\Contracts\Config\Repository;
use App\Core\Accounts\AccountsReport\AccountsReportBalanceSheet;


class AccountsReportBalanceSheetDetails implements AccountsReportBalanceSheet
{

    /**
     * Config repository service
     *
     * @var [illuminate\Contracts\Config\Repositor]
     */
    public $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }


    public function generate_balance_sheet($from_date, $to_date)
    {
        if (empty($from_date) || empty($to_date)) {

            return response()->json(['success' => false, 'message' => 'Date missing'], 200);

        }

        try {

            $from_date = date("Y-m-d", strtotime($from_date));
            $to_date = date("Y-m-d", strtotime($to_date));

            $root_head = DB::select(DB::raw("select ch.account_name as bottom_head,r1.account_name as root_head_1,r2.account_name as root_head_2,
                                                r3.account_name as root_head_3,r4.account_name as root_head_4,r5.account_name as root_head_5,
                                                nvl(sum(jn.trn_dr_account_amount-jn.trn_cr_account_amount),0) as amount
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
                                                
                                                group by ch.account_name,r1.account_name,r2.account_name,
                                                r3.account_name,r4.account_name,r5.account_name
            "));         
            
            $root_info = [];

            foreach($root_head as $root) {
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
                    'root_head' => $root->root_head_5,
                    'tran_head' => $root->bottom_head,
                    'amount' => $root->amount

                ]);
            }

            return response()->json(['success' => true, 'data' => $root_info], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()],200);

        }
        
    }

    public function balance_sheet_root()
    {
        return $this->config->get('accounts_balance_sheet');
    }
    
    public function datewise_balance_sheet($to_date,$account_no_pk = null){
       $data = DB::table('acct_journalentry_dtl_vw')
                ->select('account_no_pk','account_code','account_name','acc_5type_description','acc_4type_name','acc_4type_code','verified_ind','balanc_income','balanc_incomegroup','cash_flow_tag','bal_inc_tag','dep_account_no_pk','bl_notes','acc_4type_no_fk')
                ->selectRaw('NVL(sum(trn_cr_account_amount),0) - NVL(sum(trn_dr_account_amount),0) as owners_amount')
                ->selectRaw("CASE WHEN bal_inc_tag = 'CURRLIABILITIES' OR bal_inc_tag = 'LONGLIABILITIES' THEN (NVL(sum(trn_cr_account_amount),0) - NVL(sum(trn_dr_account_amount),0)) ELSE (NVL(sum(trn_dr_account_amount),0) - NVL(sum(trn_cr_account_amount),0)) END AS amount")         
                ->whereIn('balanc_income',array('BALANCE','OWNERS'))
                ->where('verified_ind',1)
                ->where('finalized_ind',1);
                
            if($account_no_pk != null) {
                    $data->where('account_no_pk',$account_no_pk) ; 
              }
        $result = $data->whereRaw("TO_CHAR(journal_date,'YYYY-MM-DD') <= '$to_date' ")
                        ->groupBy('account_no_pk','account_code','account_name','acc_5type_description','acc_4type_name','acc_4type_code','verified_ind','balanc_income','balanc_incomegroup','cash_flow_tag','bal_inc_tag','dep_account_no_pk','bl_notes','acc_4type_no_fk')
                        ->get();


         if(Session::get('user.ses_hospital_code') != 'SSG') {
            foreach ($result as $key => $value) {
                if($value->dep_account_no_pk > 0 && !empty($value->dep_account_no_pk)){
                     $depreciation_amount = $this->fixedAssetDepreciationDaily($to_date, $value->dep_account_no_pk);
                     $value->amount = floatval($value->amount) - floatval($depreciation_amount);
                }
             }
         }          
        
        
        return $result;
    }
    public function datewise_balance_sheet_with_depreciation($from_date,$to_date,$account_no_pk = null){
       $data = DB::table('acct_journalentry_dtl_vw')
                ->select('account_no_pk','account_code','account_name','acc_5type_description','acc_4type_name','acc_4type_code','verified_ind','balanc_income','balanc_incomegroup','cash_flow_tag','bal_inc_tag','dep_account_no_pk','bl_notes','acc_4type_no_fk')
                ->selectRaw('NVL(sum(trn_cr_account_amount),0) - NVL(sum(trn_dr_account_amount),0) as owners_amount')
                ->selectRaw("CASE WHEN bal_inc_tag = 'CURRLIABILITIES' OR bal_inc_tag = 'LONGLIABILITIES' THEN (NVL(sum(trn_cr_account_amount),0) - NVL(sum(trn_dr_account_amount),0)) ELSE (NVL(sum(trn_dr_account_amount),0) - NVL(sum(trn_cr_account_amount),0)) END AS amount")
                
                ->whereIn('balanc_income',array('BALANCE','OWNERS'))
                ->where('verified_ind',1)
                ->where('finalized_ind',1);
            if($account_no_pk != null) {
                    $data->where('account_no_pk',$account_no_pk) ; 
              }
        $result = $data->whereRaw("TO_CHAR(journal_date,'YYYY-MM-DD') <= '$to_date' ")
                    ->groupBy('account_no_pk','account_code','account_name','acc_5type_description','acc_4type_name','acc_4type_code','verified_ind','balanc_income','balanc_incomegroup','cash_flow_tag','bal_inc_tag','dep_account_no_pk','bl_notes','acc_4type_no_fk')
                    ->get();



            foreach ($result as $key => $value) {
                if($value->dep_account_no_pk > 0 && !empty($value->dep_account_no_pk)){
                     $depreciation_amount = $this->fixedAssetDepreciationDaily($to_date, $value->dep_account_no_pk);
                     $value->amount = floatval($value->amount) - floatval($depreciation_amount);
                }
             }
                  
        
        
        return $result;
    }

    
    public function datewise_balance_sheet_without_depreciation($from_date,$to_date,$account_no_pk = null){
       $data = DB::table('acct_journalentry_dtl_vw')
                ->select('account_no_pk','account_code','account_name','acc_5type_description','acc_4type_name','acc_4type_code','verified_ind','balanc_income','balanc_incomegroup','cash_flow_tag','bal_inc_tag','dep_account_no_pk','bl_notes','acc_4type_no_fk')
                ->selectRaw('NVL(sum(trn_cr_account_amount),0) - NVL(sum(trn_dr_account_amount),0) as owners_amount')
                ->selectRaw("CASE WHEN bal_inc_tag = 'CURRLIABILITIES' OR bal_inc_tag = 'LONGLIABILITIES' THEN (NVL(sum(trn_cr_account_amount),0) - NVL(sum(trn_dr_account_amount),0)) ELSE (NVL(sum(trn_dr_account_amount),0) - NVL(sum(trn_cr_account_amount),0)) END AS amount")
                
                ->whereIn('balanc_income',array('BALANCE','OWNERS'))
                ->where('verified_ind',1)
                ->where('finalized_ind',1);
            if($account_no_pk != null) {
                    $data->where('account_no_pk',$account_no_pk) ; 
              }
        $result = $data->whereRaw("TO_CHAR(journal_date,'YYYY-MM-DD') <= '$to_date' ")
                    ->groupBy('account_no_pk','account_code','account_name','acc_5type_description','acc_4type_name','acc_4type_code','verified_ind','balanc_income','balanc_incomegroup','cash_flow_tag','bal_inc_tag','dep_account_no_pk','bl_notes','acc_4type_no_fk')
                    ->get();
        return $result;
    }

    public function monthwise_balance_sheet($date,$account_no_pk = null){
        $data = DB::table('acct_journalentry_dtl_vw')
                ->select('account_no_pk','account_code','account_name','acc_5type_description','acc_4type_name','acc_4type_code','verified_ind','balanc_income','balanc_incomegroup','cash_flow_tag','bal_inc_tag','dep_account_no_pk','bl_notes','acc_4type_no_fk')
                ->selectRaw('NVL(sum(trn_cr_account_amount),0) - NVL(sum(trn_dr_account_amount),0) as owners_amount')
                ->selectRaw("CASE WHEN bal_inc_tag = 'CURRLIABILITIES' OR bal_inc_tag = 'LONGLIABILITIES' THEN (NVL(sum(trn_cr_account_amount),0) - NVL(sum(trn_dr_account_amount),0)) ELSE (NVL(sum(trn_dr_account_amount),0) - NVL(sum(trn_cr_account_amount),0)) END AS amount")
                ->whereIn('balanc_income',array('BALANCE','OWNERS'))
                ->where('verified_ind',1)
                ->where('finalized_ind',1);
        if($account_no_pk != null) {
                $data->where('account_no_pk',$account_no_pk) ; 
          }     
         
        $result = $data->whereRaw("TO_CHAR(journal_date,'MM/YYYY') <= '$date'")
                       ->groupBy('account_no_pk','account_code','account_name','acc_5type_description','acc_4type_name','acc_4type_code','verified_ind','balanc_income','balanc_incomegroup','cash_flow_tag','bal_inc_tag','dep_account_no_pk','bl_notes','acc_4type_no_fk')
                       ->get();   
        if(Session::get('user.ses_hospital_code') != 'SSG') {
            foreach ($result as $key => $value) {
                if($value->dep_account_no_pk > 0 && !empty($value->dep_account_no_pk)){
                        $depreciation_amount = $this->fixedAssetDepreciationMonthly($date, $value->dep_account_no_pk);
                        $value->amount = floatval($value->amount) - floatval($depreciation_amount);
                }
            }
        }
         return $result;
    }

    public function generate_balance_sheet_v1($request){
        
        $search_type = $request['search_type'];
       
        if($search_type == 'daily'){
            $to_date = date("Y-m-d", strtotime($request['to_date']));
            $data = $this->datewise_balance_sheet($to_date);
        }
        else if($search_type == 'monthly'){
            $date = $request['date'];           
            $data =  $this->monthwise_balance_sheet($date);     
        }
        
        if(isset($request['comparison'])){
            $prev_to_date = date("Y-m-d", strtotime($request['prev_to_date']));
            foreach($data as $key => $value){
                if($search_type == 'daily'){
                    $prev_amount = $this->datewise_balance_sheet($prev_to_date, $value->account_no_pk);
                }
                else if($search_type == 'monthly'){
                    $prev_amount =  $this->monthwise_balance_sheet($date,$value->account_no_pk);    
                }
                
                $data[$key]->prev_amount = isset($prev_amount[0]->amount) ? $prev_amount[0]->amount : 0;
                $data[$key]->prev_owners_amount = isset($prev_amount[0]->owners_amount) ? $prev_amount[0]->owners_amount : 0;
            }           
        }
        
        return $data; 
    }

    public function fixedAssetDepreciationDaily($to_date,$account_no_pk = null){
        $data = DB::table('acct_journalentry_dtl_vw')
                ->select('account_no_pk','account_code','account_name','acc_5type_description','acc_4type_name','acc_4type_code','verified_ind','balanc_income','balanc_incomegroup','cash_flow_tag','bal_inc_tag','dep_account_no_pk')
                ->selectRaw('NVL(sum(trn_cr_account_amount),0) - NVL(sum(trn_dr_account_amount),0) as amount')
                // ->selectRaw("CASE WHEN bal_inc_tag = 'CURRLIABILITIES' OR bal_inc_tag = 'LONGLIABILITIES' THEN (NVL(sum(trn_cr_account_amount),0) - NVL(sum(trn_dr_account_amount),0)) ELSE (NVL(sum(trn_dr_account_amount),0) - NVL(sum(trn_cr_account_amount),0)) END AS amount")
                
                ->whereIn('balanc_income',array('BALANCE','OWNERS'))
                ->where('verified_ind',1)
                ->where('finalized_ind',1);
            if($account_no_pk != null) {
                    $data->where('account_no_pk',$account_no_pk) ; 
              }
        $result = $data->whereRaw("TO_CHAR(journal_date,'YYYY-MM-DD') <= '$to_date' ")
                    ->groupBy('account_no_pk','account_code','account_name','acc_5type_description','acc_4type_name','acc_4type_code','verified_ind','balanc_income','balanc_incomegroup','cash_flow_tag','bal_inc_tag','dep_account_no_pk')
                    ->first();
        if(isset($result->amount)){
            $amount = $result->amount;
        }
        else{
            $amount = 0;
        }
        return $amount;
    }
    
    public function fixedAssetDepreciationMonthly($date,$account_no_pk = null){
        $data = DB::table('acct_journalentry_dtl_vw')
                ->select('account_no_pk','account_code','account_name','acc_5type_description','acc_4type_name','acc_4type_code','verified_ind','balanc_income','balanc_incomegroup','cash_flow_tag','bal_inc_tag','dep_account_no_pk')
                ->selectRaw('NVL(sum(trn_cr_account_amount),0) - NVL(sum(trn_dr_account_amount),0) as amount')
                // ->selectRaw("CASE WHEN bal_inc_tag = 'CURRLIABILITIES' OR bal_inc_tag = 'LONGLIABILITIES' THEN (NVL(sum(trn_cr_account_amount),0) - NVL(sum(trn_dr_account_amount),0)) ELSE (NVL(sum(trn_dr_account_amount),0) - NVL(sum(trn_cr_account_amount),0)) END AS amount")
                ->whereIn('balanc_income',array('BALANCE','OWNERS'))
                ->where('verified_ind',1)
                ->where('finalized_ind',1);
        if($account_no_pk != null) {
                $data->where('account_no_pk',$account_no_pk) ; 
          }     
         
        $result = $data->whereRaw("TO_CHAR(journal_date,'MM/YYYY') <= '$date'")
                       ->groupBy('account_no_pk','account_code','account_name','acc_5type_description','acc_4type_name','acc_4type_code','verified_ind','balanc_income','balanc_incomegroup','cash_flow_tag','bal_inc_tag','dep_account_no_pk')
                       ->first();
        if(isset($result->amount)){
            $amount = $result->amount;
        }
        else{
            $amount = 0;
        }
        return $amount;
    }


    public function datewise_balancesheet_notes_4($type_pk,$bl_notes){
        $data = DB::table('acct_journalentry_dtl_vw')
                 ->select('account_no_pk','account_code','account_name','acc_5type_description','acc_4type_name','acc_4type_code','verified_ind','balanc_income','balanc_incomegroup','cash_flow_tag','bal_inc_tag','dep_account_no_pk','bl_notes','acc_4type_no_fk')
                 ->selectRaw("CASE WHEN bal_inc_tag = 'CURRLIABILITIES' OR bal_inc_tag = 'LONGLIABILITIES' THEN (NVL(sum(trn_cr_account_amount),0) - NVL(sum(trn_dr_account_amount),0)) ELSE (NVL(sum(trn_dr_account_amount),0) - NVL(sum(trn_cr_account_amount),0)) END AS amount")
                 ->where('bl_notes',$bl_notes)
                 ->where('acc_4type_no_fk',$type_pk)
                 ->whereIn('balanc_income',array('BALANCE','OWNERS'))
                 ->where('verified_ind',1)
                 ->where('finalized_ind',1);

         $result = $data->groupBy('account_no_pk','account_code','account_name','acc_5type_description','acc_4type_name','acc_4type_code','verified_ind','balanc_income','balanc_incomegroup','cash_flow_tag','bal_inc_tag','dep_account_no_pk','bl_notes','acc_4type_no_fk')
                        ->orderBy('account_code','asc') 
                        ->get();
 
   
         return $result;
     }
    public function generate_balance_sheet_notes_type_4($request){

        $gl = $this->datewise_balancesheet_notes_4($request['type_id'],$request['bl_notes']);
        $data = [];
        $less_one_day = date("Y-m-d", strtotime($request['prev_date'] . " -1 day")) ;
        foreach ($gl as $key => $value) {


           $cost_first = $this->datewise_balance_sheet_without_depreciation($request['to_date'],$request['prev_date'],$value->account_no_pk);
           
           $cost_third = $this->datewise_balance_sheet_without_depreciation($request['to_date'],$request['to_date'],$value->account_no_pk);
           
           $dep_first = 0;
           $dep_third = 0;
           if(!empty($value->dep_account_no_pk)){
            $dep_first = $this->fixedAssetDepreciationDaily($request['prev_date'],$value->dep_account_no_pk);
            $dep_third = $this->fixedAssetDepreciationDaily($request['to_date'],$value->dep_account_no_pk);
           }
           
           
           $write_first = $this->datewise_balance_sheet_with_depreciation($request['to_date'],$request['to_date'],$value->account_no_pk);
           $write_second = $this->datewise_balance_sheet_with_depreciation($request['to_date'],$less_one_day,$value->account_no_pk);
           
           $dep_second =  floatVal($dep_first) - floatVal($dep_third);
           $cost_second = (isset($cost_first[0]->amount) ? $cost_first[0]->amount : 0) - (isset($cost_third[0]->amount) ? $cost_third[0]->amount : 0);
           
           $rate = DB::select("select avg(ASSET_DEPRECIATION_PCT) dep_pct from sysc_itemtype where ACC_LEDGER_NO_FK='$value->account_no_pk'");
           
           $temp = (object)[
                    'cost_first' => isset($cost_first[0]->amount) ? $cost_first[0]->amount : 0,
                    
                    'cost_third' => isset($cost_third[0]->amount) ? $cost_third[0]->amount : 0,
                    'cost_second' => $cost_second,
                    'dep_first' => $dep_first,
                    'dep_third' => $dep_third,
                    'dep_second' => $dep_second,
                    'write_first' => isset($write_first[0]->amount) ? $write_first[0]->amount : 0,
                    'write_second' => isset($write_second[0]->amount) ? $write_second[0]->amount : 0,
                    'rate'       => $rate[0]->dep_pct,
                    'account_name'       => $value->account_name,
                    'account_code'       => $value->account_code,
                    'acc_4type_name'       => $value->acc_4type_name,
                ];
            array_push($data,$temp);
        }

        return $data;   
    }

    public function getDateRangeByYearMonthNumber($year, $fromMonth, $toMonth) {
    if ($fromMonth < 1 || $fromMonth > 12 || $toMonth < 1 || $toMonth > 12) {
        return "Invalid month input. Must be between 1 and 12.";
    }
    if ($fromMonth > $toMonth) {
        return "From month cannot be greater than to month.";
    }
    $fromMonthFormatted = str_pad($fromMonth, 2, "0", STR_PAD_LEFT);
    $toMonthFormatted = str_pad($toMonth, 2, "0", STR_PAD_LEFT);
    $firstDate = "$year-$fromMonthFormatted-01";
    $lastDayDate = new DateTime("$year-$toMonthFormatted-01");
    $lastDayDate->modify('last day of this month');
    $lastDate = $lastDayDate->format('Y-m-d');

    return [
        'first_date' => $firstDate,
        'last_date' => $lastDate
    ];
}

}