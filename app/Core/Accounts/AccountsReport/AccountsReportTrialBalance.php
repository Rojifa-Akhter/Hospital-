<?php

namespace App\Core\Accounts\AccountsReport;


interface AccountsReportTrialBalance
{
    public function generate_trial_balance($from_date, $to_date);
    public function generate_trial_balance_v1($category_type, $from_date, $to_date);
    public function generate_trial_balance_1($from_date, $to_date);
    public function generate_trial_balance_v3($category_type, $from_date, $to_date);
}