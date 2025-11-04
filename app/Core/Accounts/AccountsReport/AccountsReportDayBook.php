<?php 
namespace App\Core\Accounts\AccountsReport;

interface AccountsReportDayBook
{
    public function daily_day_book(array $date_range);

}