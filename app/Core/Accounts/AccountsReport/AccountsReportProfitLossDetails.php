<?php

namespace App\Core\Accounts\AccountsReport;

use Illuminate\Support\Facades\DB;
use App\Core\Accounts\OpeningBalance\OpeningBalance;
use App\Core\Accounts\AccountsReport\AccountsReportProfitLoss;

class AccountsReportProfitLossDetails implements AccountsReportProfitLoss
{
    protected $opening_balance;
    
    public function __construct(OpeningBalance $opening_balance)
    {
        $this->opening_balance = $opening_balance;
    }
    
    public function generate_profit_loss($from_dt, $to_dt)
    {
        if (empty($from_dt) || empty($to_dt)) {

            return response()->json(['success' => false, 'message' => 'Date missing'], 200);

        }

        try {

            $from_date = date("Y-m-d", strtotime($from_dt));
            $to_date = date("Y-m-d", strtotime($to_dt));
            $root_head = DB::select(DB::raw("select ch.account_name as bottom_head,r.account_name as root_head,r1.account_name as root_head_1,r2.account_name as sub_root,r2.ledger_group_name,
                                                sum(jn.trn_cr_account_amount) as cr,
                                                sum(jn.trn_dr_account_amount) as dr
                                                from acct_chart_of_accounts ch
                                                left join acct_chart_of_accounts r1
                                                on r1.account_no_pk  = ch.account_no_fk_root_s1
                                                left join acct_chart_of_accounts r2
                                                on r2.account_no_pk = ch.account_no_fk_root_0
                                                left join acct_chart_of_accounts r
                                                on r.account_no_pk = r.account_no_fk_root_s2
                                                join acct_journal_entry jn
                                                on jn.trn_account_no_fk  = ch.account_no_pk
                                                where jn.journal_code in (select journal_code from acct_journal_entry where trn_account_no_fk in(
                                                    select account_no_pk from acct_chart_of_accounts
                                                    where ledger_group_name in('income','expense','Cost of Goods Sold')

                                                ))
                                                and ch.ledger_group_name in('income','expense','Cost of Goods Sold')
                                                and to_char(jn.journal_date,'YYYY-MM-DD') between '$from_date' and '$to_date'
                                                group by ch.account_name,r.account_name,r1.account_name,r2.account_name,r2.ledger_group_name
            "));         
            
            $root_info = [];

            foreach($root_head as $root) {
                //$root_head_name = "";
                // if(! empty($root->root_head_1)) {
                //     $root_head_name = $root->root_head_1;
                // }
                // if(! empty($root->root_head_2) &&  empty($root->root_head_1) && $root_head_name == "") {
                //     $root_head_name = $root->root_head_2;
                // }
                // if(! empty($root->root_head_3) &&  empty($root->root_head_1) && $root_head_name == "") {
                //     $root_head_name = $root->root_head_3;
                // }
                // if(! empty($root->root_head_4) &&  empty($root->root_head_1) && $root_head_name == "") {
                //     $root_head_name = $root->root_head_4;
                // }
                // if(! empty($root->root_head_5) &&  empty($root->root_head_1) && $root_head_name == "") {
                //     $root_head_name = $root->root_head_5;
                // }

                array_push($root_info, [
                    'type' => 'inflow',
                    'root_head' => !empty($root->root_head_1) && !empty($root->root_head) ? $root->root_head_1 : $root->root_head,
                    'root_head3' => $root->ledger_group_name,
                    'root_head4' => $root->sub_root,
                    'tran_head' => $root->bottom_head,
                    'dr' => $root->dr,
                    'cr' => $root->cr

                ]);
            }

            //dd($root_info);

            return response()->json(['success' => true, 'data' => $root_info], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()],200);

        }
    }

    public function generate_profit_loss_v1($request){
       
       try {
        
            $search_type = $request['search_type'];
            
            if($search_type == 'daily'){
                $from_date = date('Y-m-d',strtotime($request['from_date']));
                $to_date = date('Y-m-d',strtotime($request['to_date']));
                $data = $this->datewise_profit_loss($from_date,$to_date);
                $data =  $data->getData()->data; 
                
            }
            else if($search_type == 'monthly'){
                $date = $request['date'];           
                $data =  $this->monthly_profit_loss_v1($date);     
                $data =  $data->getData()->data; 
              
            }

            if(isset($request['comparison'])){
                $prev_from_date = date('Y-m-d',strtotime($request['prev_from_date']));
                $prev_to_date = date('Y-m-d',strtotime($request['prev_to_date']));
                foreach($data as $key => $value){
                   
                    if($search_type == 'daily'){
                        $prev_amount = $this->datewise_profit_loss($prev_from_date, $prev_to_date, $value->account_no_pk);
                        $prev_amount = $prev_amount->getData()->data;                      
                    }
                    else if($search_type == 'monthly'){
                        $prev_amount =  $this->monthly_profit_loss_v1($date,$value->account_no_pk);  
                        $prev_amount = $prev_amount->getData()->data;
                    }
                 
                    $data[$key]->prev_amount = isset($prev_amount[0]->amount) ? $prev_amount[0]->amount : 0;
                    $data[$key]->prev_dr = isset($prev_amount[0]->dr) ? $prev_amount[0]->dr : 0;
                    $data[$key]->prev_cr = isset($prev_amount[0]->cr) ? $prev_amount[0]->cr : 0;
                    
                }           
            }

            return response()->json(['success' => true, 'data' => $data], 200);
            } 
            catch(\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()],422);
            }
    }


    public function datewise_profit_loss($from_date, $to_date, $account_no = null){
        $from_date = date('Y-m-d',strtotime($from_date));
        $to_date = date('Y-m-d',strtotime($to_date));
        $sql = "select jnv.account_name,                                                                                          
                    sum(jnv.trn_cr_account_amount) as cr_amount,
                    sum(jnv.trn_dr_account_amount) as dr_amount,
                    NVL(sum(jnv.trn_cr_account_amount),0) - NVL(sum(jnv.trn_dr_account_amount),0) as cr,
                    NVL(sum(jnv.trn_dr_account_amount),0) - NVL(sum(jnv.trn_cr_account_amount),0) as dr,                                                
                    NVL(sum(jnv.trn_dr_account_amount),0) - NVL(sum(jnv.trn_cr_account_amount),0) as amount,                                                
                    jnv.account_code,
                    jnv.account_no_pk,
                    jnv.balanc_income,
                    jnv.income_exp_type,
                    jnv.balanc_incomegroup as income_expense,
                    jnv.cash_flow_tag,
                    jnv.bal_inc_tag,
                    jnv.acc_5type_description,
                    jnv.type_code,
                    jnv.acc_4type_code,
                    jnv.bl_notes,
                    jnv.acc_4type_name
                                                                                                                                                                                                        
                    from acct_journalentry_dtl_vw jnv                                                                                                                                         
                    where jnv.verified_ind = 1 and jnv.finalized_ind = 1 and jnv.balanc_income  = 'INCOME' and
                    to_char(jnv.journal_date, 'YYYY-MM-DD') BETWEEN '$from_date' AND '$to_date' " ;
                    
                    if($account_no != null){
                      
                        $sql.="and jnv.account_no_pk = $account_no";
                    }
                                                      
                    $sql.= "group by jnv.account_name,jnv.account_code,jnv.account_no_pk,jnv.balanc_income,
                            jnv.balanc_incomegroup,
                            jnv.cash_flow_tag,
                            jnv.bal_inc_tag,
                            jnv.income_exp_type,
                            jnv.acc_5type_description,
                            jnv.type_code,
                            jnv.acc_4type_code,
                            jnv.bl_notes,
                            jnv.acc_4type_name                                      
                            order by jnv.account_code asc";
        $datewise_profit_loss = DB::select(DB::raw($sql)); 
      
        // if($account_no != null){
                      
        //     dd($account_no,$datewise_profit_loss);
        // }
        
        return response()->json(['success' => true, 'data' => $datewise_profit_loss], 200);
    
    }
    
    public function monthly_profit_loss_v1($date, $account_no = null){
        
        $sql = "select jnv.account_name,                                                                                          
                sum(jnv.trn_cr_account_amount) as cr_amount,
                sum(jnv.trn_dr_account_amount) as dr_amount,
                NVL(sum(jnv.trn_cr_account_amount),0) - NVL(sum(jnv.trn_dr_account_amount),0) as cr,
                NVL(sum(jnv.trn_dr_account_amount),0) - NVL(sum(jnv.trn_cr_account_amount),0) as dr,   
                NVL(sum(jnv.trn_dr_account_amount),0) - NVL(sum(jnv.trn_cr_account_amount),0) as amount,                                         
                jnv.account_code,
                jnv.account_no_pk,
                jnv.balanc_income,
                jnv.income_exp_type,
                jnv.balanc_incomegroup as income_expense,
                jnv.cash_flow_tag,
                jnv.bal_inc_tag,
                jnv.acc_5type_description,
                jnv.type_code,
                jnv.acc_4type_code,
                jnv.bl_notes,
                jnv.acc_4type_name
                                                                                                                                                                        
                from acct_journalentry_dtl_vw jnv                                                                                                                                         
                where jnv.verified_ind = 1 and jnv.finalized_ind = 1 and jnv.balanc_income  = 'INCOME' 
                and TO_CHAR(jnv.journal_date,'MM/YYYY') = '$date'";

        if($account_no != null){
                $sql.=" and jnv.account_no_pk = $account_no";
        }      
                                                                 
        $sql.="group by jnv.account_name,jnv.account_code,jnv.account_no_pk,jnv.balanc_income,
                jnv.balanc_incomegroup,
                jnv.cash_flow_tag,
                jnv.bal_inc_tag,
                jnv.income_exp_type,
                jnv.acc_5type_description,
                jnv.type_code,
                jnv.acc_4type_code,
                jnv.bl_notes,
                jnv.acc_4type_name                                      
                order by jnv.account_code asc                                            
                ";
        $monthly_profit_loss = DB::select(DB::raw($sql));         
         
           return response()->json(['success' => true, 'data' => $monthly_profit_loss], 200);

    }

    // Profit and Loss for Balance Sheet
    public function generate_profit_loss_balance_sheet_v1($request){
        try {
         
             $search_type = $request['search_type'];
             
             if($search_type == 'daily'){
                 $to_date = date('Y-m-d',strtotime($request['to_date']));
                 $data = $this->datewise_profit_loss_balance_sheet($to_date);
                 $data =  $data->getData()->data; 
                 
             }
             else if($search_type == 'monthly'){
                 $date = $request['date'];           
                 $data =  $this->monthly_profit_loss_balance_sheet_v1($date);     
                 $data =  $data->getData()->data; 
               
             }
 
             if(isset($request['comparison'])){
                 $prev_to_date = date('Y-m-d',strtotime($request['prev_to_date']));
                 foreach($data as $key => $value){
                    
                     if($search_type == 'daily'){
                         $prev_amount = $this->datewise_profit_loss_balance_sheet($prev_to_date, $value->account_no_pk);
                         $prev_amount = $prev_amount->getData()->data;                      
                     }
                     else if($search_type == 'monthly'){
                         $prev_amount =  $this->monthly_profit_loss_balance_sheet_v1($date,$value->account_no_pk);  
                         $prev_amount = $prev_amount->getData()->data;
                     }
                  
                     $data[$key]->prev_amount = isset($prev_amount[0]->amount) ? $prev_amount[0]->amount : 0;
                     $data[$key]->prev_dr = isset($prev_amount[0]->dr) ? $prev_amount[0]->dr : 0;
                     $data[$key]->prev_cr = isset($prev_amount[0]->cr) ? $prev_amount[0]->cr : 0;
                     
                 }           
             }
 
             return response()->json(['success' => true, 'data' => $data], 200);
             } 
             catch(\Exception $e) {
                 return response()->json(['success' => false, 'message' => $e->getMessage()],422);
             }
    }


    public function datewise_profit_loss_balance_sheet($to_date, $account_no = null){
        $to_date = date('Y-m-d',strtotime($to_date));
        
        $sql = "select jnv.account_name,                                                                                          
                    sum(jnv.trn_cr_account_amount) as cr_amount,
                    sum(jnv.trn_dr_account_amount) as dr_amount,
                    NVL(sum(jnv.trn_cr_account_amount),0) - NVL(sum(jnv.trn_dr_account_amount),0) as cr,
                    NVL(sum(jnv.trn_dr_account_amount),0) - NVL(sum(jnv.trn_cr_account_amount),0) as dr,                                                
                    NVL(sum(jnv.trn_dr_account_amount),0) - NVL(sum(jnv.trn_cr_account_amount),0) as amount,                                                
                    jnv.account_code,
                    jnv.account_no_pk,
                    jnv.balanc_income,
                    jnv.income_exp_type,
                    jnv.balanc_incomegroup as income_expense,
                    jnv.cash_flow_tag,
                    jnv.bal_inc_tag,
                    jnv.acc_5type_description,
                    jnv.type_code,
                    jnv.acc_4type_code,
                    jnv.bl_notes,
                    jnv.acc_4type_name
                                                                                                                                                                                                        
                    from acct_journalentry_dtl_vw jnv                                                                                                                                         
                    where jnv.verified_ind = 1 and jnv.finalized_ind = 1 and jnv.balanc_income  = 'INCOME' and
                    to_char(jnv.journal_date, 'YYYY-MM-DD') <= '$to_date' " ;
                    
                    if($account_no != null){
                      
                        $sql.="and jnv.account_no_pk = $account_no";
                    }
                                                      
                    $sql.= "group by jnv.account_name,jnv.account_code,jnv.account_no_pk,jnv.balanc_income,
                            jnv.balanc_incomegroup,
                            jnv.cash_flow_tag,
                            jnv.bal_inc_tag,
                            jnv.income_exp_type,
                            jnv.acc_5type_description,
                            jnv.type_code,
                            jnv.acc_4type_code,
                            jnv.bl_notes,
                            jnv.acc_4type_name                                      
                            order by jnv.account_code asc";
        $datewise_profit_loss = DB::select(DB::raw($sql)); 
        return response()->json(['success' => true, 'data' => $datewise_profit_loss], 200);
    
    }

    public function monthly_profit_loss_balance_sheet_v1($date, $account_no = null){
        
        $sql = "select jnv.account_name,                                                                                          
                sum(jnv.trn_cr_account_amount) as cr_amount,
                sum(jnv.trn_dr_account_amount) as dr_amount,
                NVL(sum(jnv.trn_cr_account_amount),0) - NVL(sum(jnv.trn_dr_account_amount),0) as cr,
                NVL(sum(jnv.trn_dr_account_amount),0) - NVL(sum(jnv.trn_cr_account_amount),0) as dr,   
                NVL(sum(jnv.trn_dr_account_amount),0) - NVL(sum(jnv.trn_cr_account_amount),0) as amount,                                         
                jnv.account_code,
                jnv.account_no_pk,
                jnv.balanc_income,
                jnv.income_exp_type,
                jnv.balanc_incomegroup as income_expense,
                jnv.cash_flow_tag,
                jnv.bal_inc_tag,
                jnv.acc_5type_description,
                jnv.type_code,
                jnv.acc_4type_code,
                jnv.bl_notes,
                jnv.acc_4type_name
                                                                                                                                                                        
                from acct_journalentry_dtl_vw jnv                                                                                                                                         
                where jnv.verified_ind = 1 and jnv.finalized_ind = 1 and jnv.balanc_income  = 'INCOME' 
                and TO_CHAR(jnv.journal_date,'MM/YYYY') <= '$date'";

        if($account_no != null){
                $sql.=" and jnv.account_no_pk = $account_no";
        }      
                                                                 
        $sql.="group by jnv.account_name,jnv.account_code,jnv.account_no_pk,jnv.balanc_income,
                jnv.balanc_incomegroup,
                jnv.cash_flow_tag,
                jnv.bal_inc_tag,
                jnv.income_exp_type,
                jnv.acc_5type_description,
                jnv.type_code,
                jnv.acc_4type_code,
                jnv.bl_notes,
                jnv.acc_4type_name                                      
                order by jnv.account_code asc                                            
                ";
        $monthly_profit_loss = DB::select(DB::raw($sql));         
         
           return response()->json(['success' => true, 'data' => $monthly_profit_loss], 200);

    }


    public function generate_profit_loss_date_monthwise($from_date, $to_date)
    {
        $from_date = date('Y-m-d',strtotime($from_date));
        $to_date = date('Y-m-d',strtotime($to_date));


        $sql = "select                                                                                         

                    NVL(sum(jnv.trn_cr_account_amount),0) - NVL(sum(jnv.trn_dr_account_amount),0) as cr,
                    NVL(sum(jnv.trn_dr_account_amount),0) - NVL(sum(jnv.trn_cr_account_amount),0) as dr,                                             
       
                    jnv.balanc_income,
                    jnv.income_exp_type,
                    jnv.balanc_incomegroup as income_expense,

                    jnv.bal_inc_tag,

                    jnv.acc_4type_code,
                    jnv.acc_4type_name,
                    TO_CHAR(jnv.journal_date, 'MM/YYYY') AS journal_date_formatted
                                                                                                                                                                                                        
                    from acct_journalentry_dtl_vw jnv                                                                                                                                         
                    where jnv.verified_ind = 1 and jnv.finalized_ind = 1 and jnv.balanc_income  = 'INCOME' and
                    to_char(jnv.journal_date, 'YYYY-MM-DD') BETWEEN '$from_date' AND '$to_date' " ;
                    
                                                      
                    $sql.= "group by jnv.balanc_income,
                            jnv.balanc_incomegroup,
                            jnv.bal_inc_tag,
                            jnv.income_exp_type,
                            jnv.acc_4type_code,
                            jnv.acc_4type_name,
                            TO_CHAR(jnv.journal_date, 'MM/YYYY')                                    
                            order by journal_date_formatted asc";
        $datewise_profit_loss = DB::select(DB::raw($sql)); 

        return response()->json(['success' => true, 'data' => $datewise_profit_loss], 200);
    }


    public function generate_profit_loss_description_date_monthwise($from_date, $to_date)
    {
        $from_date = date('Y-m-d',strtotime($from_date));
        $to_date = date('Y-m-d',strtotime($to_date));


        $sql = "select                                                                                         

                    NVL(sum(jnv.trn_cr_account_amount),0) - NVL(sum(jnv.trn_dr_account_amount),0) as cr,
                    NVL(sum(jnv.trn_dr_account_amount),0) - NVL(sum(jnv.trn_cr_account_amount),0) as dr,                                             
       
                    jnv.balanc_income,
                    jnv.income_exp_type,
                    jnv.balanc_incomegroup as income_expense,

                    jnv.bal_inc_tag,

                    jnv.acc_5typedescription_no_fk,
                    jnv.acc_5type_description,
                    TO_CHAR(jnv.journal_date, 'MM/YYYY') AS journal_date_formatted
                                                                                                                                                                                                        
                    from acct_journalentry_dtl_vw jnv                                                                                                                                         
                    where jnv.verified_ind = 1 and jnv.finalized_ind = 1 and jnv.balanc_income  = 'INCOME' and
                    to_char(jnv.journal_date, 'YYYY-MM-DD') BETWEEN '$from_date' AND '$to_date' " ;
                    
                                                      
                    $sql.= "group by jnv.balanc_income,
                            jnv.balanc_incomegroup,
                            jnv.bal_inc_tag,
                            jnv.income_exp_type,
                            jnv.acc_5typedescription_no_fk,
                            jnv.acc_5type_description,
                            TO_CHAR(jnv.journal_date, 'MM/YYYY')                                    
                            order by journal_date_formatted asc";
        $datewise_profit_loss = DB::select(DB::raw($sql)); 

        return response()->json(['success' => true, 'data' => $datewise_profit_loss], 200);
    }
}