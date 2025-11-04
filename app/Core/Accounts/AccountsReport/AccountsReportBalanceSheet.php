<?php

namespace App\Core\Accounts\AccountsReport;


interface AccountsReportBalanceSheet
{
    public function generate_balance_sheet($from_date,$to_date);
    public function balance_sheet_root();
    
    //Accounts v1
    public function generate_balance_sheet_v1($request);
    public function generate_balance_sheet_notes_type_4($request);
    public function getDateRangeByYearMonthNumber($year, $fromMonth, $toMonth);
    
}