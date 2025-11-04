<?php 
namespace App\Core\Accounts\AccountsReport;

interface AccountsReportDailyIncome
{
    public function daily_income(array $date_range);

}