<?php

namespace App\Core\Accounts\AccountSetup;

interface AccountSetup
{
    public function get_fiscal_year();
    public function save_fiscal_year(array $data);
    public function update_fiscal_year(array $data);
    public function get_fiscal_month();
    public function save_fiscal_month(array $data);
    public function update_fiscal_month(array $data);
    public function save_account_group(array $data);
    public function get_accounts_group_v1();
    public function get_accounts_group_by_id($id);
    public function update_account_group(array $data);
    public function save_account_sub_group(array $data);
    public function get_accounts_sub_group_v1();
    public function get_accounts_sub_group_by_id($id);
    public function update_account_sub_group(array $data);
    public function save_account_group_type(array $data);
    public function get_accounts_group_type_v1();
    public function get_accounts_group_type_by_id($id);
    public function update_account_group_type(array $data);
    public function save_doctor_share(array $data);
    public function get_doctor_share();
    public function get_doctor_share_by_id($id);
    public function update_doctor_share(array $data);

    public function save_account_type(array $data);
    public function get_accounts_type_v1();
    public function get_accounts_type_by_id($id);
    public function update_account_type(array $data);
    public function save_account_description(array $data);
    public function get_accounts_description_v1();
    public function get_accounts_by_id($id);
    public function update_account_description(array $data);

    public function get_item_wise_accounts_integration();
    public function get_item_wise_accounts_integration_billing();
    public function get_major_group($con);
    public function get_accounts_integration_dtl_by_parent($id);
    public function get_accounts_integration_master_by_id($id);
    public function get_accounts_integration_details_by_id($id);
    public function get_accounts_prev_opening_balance_v1();
    public function get_opening_balance_by_id($id);

    public function currency_data();
    public function get_accounts_currency_by_id($id);

}