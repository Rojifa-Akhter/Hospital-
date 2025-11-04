<?php

namespace App\Core\Accounts\AccountsReport;

interface AccountsReportProfitLoss
{
    public function generate_profit_loss_date_monthwise($from_dt, $to_dt);
    
    public function generate_profit_loss($from_dt, $to_dt);
    public function generate_profit_loss_v1($all);
    public function datewise_profit_loss($from_date, $to_date,$account_no = null);
    //Balance Sheet Profit and Loss
    public function generate_profit_loss_balance_sheet_v1($all);
    public function datewise_profit_loss_balance_sheet($to_date,$account_no = null);

    public function generate_profit_loss_description_date_monthwise($from_dt, $to_dt);
}