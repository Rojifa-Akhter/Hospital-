<?php

namespace App\Core\Accounts\AccountsReport;

interface AccountsReportBankStatement
{
    public function bank_statement($cash_bottom_head,$from_date,$to_date);
    public function bank_ledger_statement($from_date,$to_date);
    public function subsidiary_ledger($cash_bottom_head,$from_date,$to_date);
    public function general_ledger($cash_bottom_head,$from_date,$to_date);   
    public function patient_statement($cash_bottom_head,$from_date,$to_date);
    public function supplier_statement($cash_bottom_head,$from_date,$to_date);
    public function self_ledger($cash_bottom_head,$from_date,$to_date);
    public function self_ledger_patient($cash_bottom_head,$from_date,$to_date);

    //Accounts v1 Routes
    public function bank_statement_v1($cash_bottom_head,$from_date,$to_date);
    public function general_ledger_v1($category_type, $gl_code, $account_type, $account_description,$from_date,$to_date);
    public function self_ledger_v1($acc_pk,$cash_bottom_head,$from_date,$to_date);
    public function self_ledger_summary_v1($cash_bottom_head,$from_date,$to_date);
    public function self_ledger_summary_v1_temp($cash_bottom_head,$from_date,$to_date);
    public function subledger_self_ledger_v1($gl_code,$subledger_id,$from_date,$to_date);
    public function subledger_self_ledger_individual_v1($journal_code,$gl_code,$subledger_id,$from_date,$to_date);
    public function subledger_self_ledger_v1_all($sql,$from_date,$to_date);
    public function subledger_self_ledger_v1_without_name($sql,$from_date,$to_date);

    public function general_ledger_wise_report($acc_pk,$from_date,$to_date);
    
    public function generate_bank_report($acc_pk,$from_date,$to_date);



}