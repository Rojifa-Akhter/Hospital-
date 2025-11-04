<?php

namespace App\Core\Accounts\AccountsReport;

interface AccountsReportCashFlow
{
    public function cashflow_statement($cash_bottom_head,$from_date,$to_date);
    public function cashflow_statement_v1($from_date,$to_date);
}