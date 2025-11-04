<?php

namespace App\Core\Accounts\AccountsReport;

use Illuminate\Support\Facades\DB;
use App\Core\Accounts\AccountsReport\AccountsReportJournal;

class AccountsReportJournalDetails implements AccountsReportJournal
{
    public function get_journal_report($journal_code, $from_date, $to_date){
        try {
            $from_date = date("Y-m-d", strtotime($from_date));
            $to_date = date("Y-m-d", strtotime($to_date));
            $voucher = DB::table('acct_v1_journal_entry_vw')
                                ->select(
                                        'acct_v1_journal_entry_vw.account_name',
                                        'acct_v1_journal_entry_vw.trn_cr_account_amount',
                                        'acct_v1_journal_entry_vw.trn_dr_account_amount',
                                        'acct_v1_journal_entry_vw.journal_date',
                                        'acct_v1_journal_entry_vw.journal_code',
                                        'acct_v1_journal_entry_vw.trn_account_code',
                                        'acct_v1_journal_entry_vw.narration_text',
                                        'acct_v1_journal_entry_vw.bank_cheq_number',
                                        'acct_v1_journal_entry_vw.bank_cheq_date',
                                        'acct_v1_journal_entry_vw.voucher_type_name',
                                        'acct_v1_journal_entry_vw.is_contra',
                                        'acct_v1_journal_entry_vw.voucher_remarks',
                                        'acct_v1_journal_entry_vw.doc_date',
                                        'acct_v1_journal_entry_vw.subledgertype_name',
                                        'acct_v1_journal_entry_vw.subledger_name',
                                        'acct_v1_journal_entry_vw.costcenter_name',
                                        'acct_v1_journal_entry_vw.verified_by',
                                        'acct_v1_journal_entry_vw.verified_ind',
                                        'acct_v1_journal_entry_vw.finalized_by',
                                        'acct_v1_journal_entry_vw.prepare_by',
                                        'acct_v1_journal_entry_vw.file_path1',
                                        'acct_v1_journal_entry_vw.file_path2',
                                        'acct_v1_journal_entry_vw.file_path3',
                                        'acct_v1_journal_entry_vw.file_name1',
                                        'acct_v1_journal_entry_vw.file_name2',
                                        'acct_v1_journal_entry_vw.file_name3',
                                        'acct_v1_journal_entry_vw.voucher_remarks',
                                        'acct_v1_journal_entry_vw.acct_subledger_no_fk',
                                        'acct_v1_journal_entry_vw.costcenter_no_fk',
                                        'acct_v1_journal_entry_vw.journalmst_no_pk',
                                        'acct_v1_journal_entry_vw.journal_no_pk',
                                        'acct_v1_journal_entry_vw.acct_subledger_type_fk',
                                        'acct_v1_journal_entry_vw.cost_center_ind',
                                        'acct_v1_journal_entry_vw.narration_text',
                                        'acct_v1_journal_entry_vw.voucher_type_name',
                                        'acct_v1_journal_entry_vw.trn_account_code'
                  

                                )
                                ->where('acct_v1_journal_entry_vw.verified_ind',1)
                                ->where('acct_v1_journal_entry_vw.finalized_ind',1)
                                ->orderBy('acct_v1_journal_entry_vw.journal_code','asc')
                                ->orderBy('acct_v1_journal_entry_vw.journal_date','asc')
                                ->orderBy('acct_v1_journal_entry_vw.trn_account_code','asc');
                                if(!empty($journal_code)){
                                    $voucher->where('acct_v1_journal_entry_vw.journal_code',$journal_code);   
                                }
                                $voucher->whereBetween('acct_v1_journal_entry_vw.journal_date',[$from_date,$to_date]);   
                                $voucher = $voucher->get();
            return response()->json(['success' => true, 'data' => $voucher], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => true,'message' => $th->getMessage(),'data'=> []], 422);
        }
        

    }

    public function get_auto_journal_report($journal_code, $from_date, $to_date){
        try {


            $voucher = DB::table('acct_v1_journal_entry_vw')
                                ->select(
                                        'acct_v1_journal_entry_vw.account_name',
                                        'acct_v1_journal_entry_vw.trn_cr_account_amount',
                                        'acct_v1_journal_entry_vw.trn_dr_account_amount',
                                        'acct_v1_journal_entry_vw.journal_date',
                                        'acct_v1_journal_entry_vw.journal_code',
                                        'acct_v1_journal_entry_vw.trn_account_code',
                                        'acct_v1_journal_entry_vw.narration_text',
                                        'acct_v1_journal_entry_vw.bank_cheq_number',
                                        'acct_v1_journal_entry_vw.bank_cheq_date',
                                        'acct_v1_journal_entry_vw.voucher_type_name',
                                        'acct_v1_journal_entry_vw.is_contra',
                                        'acct_v1_journal_entry_vw.voucher_remarks',
                                        'acct_v1_journal_entry_vw.doc_date',
                                        'acct_v1_journal_entry_vw.subledgertype_name',
                                        'acct_v1_journal_entry_vw.subledger_name',
                                        'acct_v1_journal_entry_vw.costcenter_name',
                                        'acct_v1_journal_entry_vw.verified_by',
                                        'acct_v1_journal_entry_vw.verified_ind',
                                        'acct_v1_journal_entry_vw.finalized_by',
                                        'acct_v1_journal_entry_vw.prepare_by',
                                        'acct_v1_journal_entry_vw.file_path1',
                                        'acct_v1_journal_entry_vw.file_path2',
                                        'acct_v1_journal_entry_vw.file_path3',
                                        'acct_v1_journal_entry_vw.file_name1',
                                        'acct_v1_journal_entry_vw.file_name2',
                                        'acct_v1_journal_entry_vw.file_name3',
                                        'acct_v1_journal_entry_vw.voucher_remarks',
                                        'acct_v1_journal_entry_vw.acct_subledger_no_fk',
                                        'acct_v1_journal_entry_vw.costcenter_no_fk',
                                        'acct_v1_journal_entry_vw.journalmst_no_pk',
                                        'acct_v1_journal_entry_vw.journal_no_pk',
                                        'acct_v1_journal_entry_vw.acct_subledger_type_fk',
                                        'acct_v1_journal_entry_vw.cost_center_ind',
                                        'acct_v1_journal_entry_vw.narration_text',
                                        'acct_v1_journal_entry_vw.voucher_type_name',
                                        'acct_v1_journal_entry_vw.trn_account_code'
                  

                                )
                                ->where('acct_v1_journal_entry_vw.verified_ind',1)
                                ->where('acct_v1_journal_entry_vw.finalized_ind',1)
                                ->orderBy('acct_v1_journal_entry_vw.journal_code','asc')
                                ->orderBy('acct_v1_journal_entry_vw.journal_date','asc')
                                ->orderBy('acct_v1_journal_entry_vw.trn_account_code','asc');
                                if(!empty($journal_code)){
                                    $voucher->where('acct_v1_journal_entry_vw.trn_account_no_fk',$journal_code);   
                                }
                                if(!empty($from_date) && !empty($to_date)){
                                    $voucher->whereBetween('acct_v1_journal_entry_vw.journal_date',[$from_date,$to_date]);   
                                }
                                $voucher = $voucher->get();
            return response()->json(['success' => true, 'data' => $voucher], 200);
        } catch (\Throwable $th) {
            return response()->json(['success' => true,'message' => $th->getMessage(),'data'=> []], 422);
        }
        

    }



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