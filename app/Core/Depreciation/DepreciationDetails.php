<?php

namespace App\Core\Depreciation;
use Session;
use DateTime;
use Illuminate\Support\Facades\DB;

class DepreciationDetails implements Depreciation
{
    
    public function get_fixed_asset_depreciation_details() {
        $data = DB::table('acct_journalentry_dtl_vw')
                    ->select('account_no_pk','account_code','account_name','acc_5type_description','acc_4type_name','acc_4type_code','verified_ind','balanc_income','balanc_incomegroup','cash_flow_tag','bal_inc_tag','dep_account_no_pk','bl_notes','acc_4type_no_fk')
                    ->where('depreciation_ind',1)
                    ->whereIn('balanc_income',array('BALANCE','OWNERS'))
                    ->where('verified_ind',1)
                    ->where('finalized_ind',1)
                    ->groupBy('account_no_pk','account_code','account_name','acc_5type_description','acc_4type_name','acc_4type_code','verified_ind','balanc_income','balanc_incomegroup','cash_flow_tag','bal_inc_tag','dep_account_no_pk','bl_notes','acc_4type_no_fk')
                    ->orderBy('account_code','asc') 
                    ->get();

        return $data;
    }

    public function datewise_balance_sheet_without_depreciation($from_date,$to_date,$account_no_pk = null){
        $data = DB::table('acct_journalentry_dtl_vw')
                 ->select('account_no_pk','account_code','account_name','acc_5type_description','acc_4type_name','acc_4type_code','verified_ind','balanc_income','balanc_incomegroup','cash_flow_tag','bal_inc_tag','dep_account_no_pk','bl_notes','acc_4type_no_fk')
                 ->selectRaw('NVL(sum(trn_cr_account_amount),0) - NVL(sum(trn_dr_account_amount),0) as owners_amount')
                 ->selectRaw('NVL(sum(trn_cr_account_amount),0) as cr_amount, NVL(sum(trn_dr_account_amount),0) as dr_amount')
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
 
 
         foreach ($result as $key => $value) {
            if($value->dep_account_no_pk > 0 && !empty($value->dep_account_no_pk)){
                 $depreciation_amount = $this->fixedAssetDepreciationDaily($to_date, $value->dep_account_no_pk);
                 $value->amount = floatval($value->amount) - floatval($depreciation_amount);
            }
         }
         
         return $result;
    }

    public function lastMonthDepreciation($account_no_pk = null){

        $data = DB::table('acct_journalentry_dtl_vw')
                    ->select('account_no_pk')
                    ->selectRaw('NVL(trn_cr_account_amount,0) - NVL(trn_dr_account_amount,0) as amount')
                    ->selectRaw("TO_CHAR(journal_date,'DD-MM-YYYY') as journal_date")
                    ->whereIn('balanc_income',array('BALANCE','OWNERS'))
                    ->where('verified_ind',1)
                    ->where('finalized_ind',1);
        if($account_no_pk != null) {
                    $data->where('account_no_pk',$account_no_pk) ; 
              }
        $result = $data->latest('journal_date')
                        ->take(1)
                        ->first();
        if(isset($result->amount)){
            $amount = $result;
        }
        else{
            $amount = 0;
        }
        return $amount;
    }
}


?>