<?php

namespace App\Core\Accounts\OpeningBalance;


interface OpeningBalance
{
    public function get_employee_opening_balance($acc_code, $date);
    public function get_supplier_opening_balance($acc_code, $date);
    public function get_patient_opening_balance($acc_code, $date);
    public function get_accounts_opening_balance($acc_code, $date);
    public function get_accounts_opening_balance_v1($acc_pk,$acc_code, $date);
    public function get_accounts_opening_balance_1($acc_pk,$acc_code, $date);
    public function get_root_accounts_opening_balance($acc_code, $date);
    public function get_all_bank_opening_balance($date);

    public function get_bank_accounts_balance_v1($acc_pk, $date);
    public function get_bank_accounts_reconcil_balance_v1($acc_pk, $date);

    public function get_bank_accounts_not_reconciled($acc_pk, $con);
    public function get_bank_accounts_reconciled($acc_pk, $con);
    public function get_bank_accounts_verified_reconciled($acc_pk, $con);
}