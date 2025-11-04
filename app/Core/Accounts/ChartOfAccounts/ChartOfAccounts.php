<?php

namespace App\Core\Accounts\ChartOfAccounts;

interface ChartOfAccounts
{
    public function save_chart_of_account(array $data);
    public function get_chart_of_account();
    public function update_acct_type_chart_of_account(array $data);
    public function update_chart_of_account(array $data);
    public function get_chart_of_account_by_id($id);
    public function delete_chart_of_account($id);
    public function get_last_account_codeno();
    public function get_root_account();
    public function get_root_child_accounts($root_id);
    public function get_accounts_level();
    public function request_get_accounts_level($acc_id);
    public function transection_accounts_head();

    // Accounts Version 1//
    public function get_accounts_levelV1();
    public function get_accounts_levelBankV1();
    public function get_account_type();
    public function add_voucher_type(array $data);
    public function get_sub_ledger_type();
    public function get_sub_ledger_by_id($id);
    public function save_sub_ledger_type(array $data);
    public function update_sub_ledger_type(array $data);
    public function get_sub_ledger_name($con);
    public function save_sub_ledger_name(array $data);
    public function update_sub_ledger_name(array $data);
    public function get_service_unit($con);
    public function get_cost_center_v1($con);
    public function save_cost_center_v1(array $data);
    public function update_cost_center_v1(array $data);
    public function get_account_level($id);
    public function get_company();
    public function get_chart_of_account_by_id_v1($id);
    public function get_chart_of_account_by_code_v1($code);
    public function get_chart_of_account_list_v1();
    public function get_type_list_by_group_type($id);
    public function get_chart_of_account_by_various_id($column, $id);
    public function get_account_list_by_type($id);
    public function get_gl_list_by_description($id);


    
}