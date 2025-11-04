<?php

namespace App\Core\Accounts\AccountsReport;

interface AccountsReportReceiptPayment
{
    public function receipt_payment($bottom_head_1, $bottom_head_2, $from_date, $to_date);
}