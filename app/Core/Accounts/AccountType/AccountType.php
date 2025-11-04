<?php

namespace App\Core\Accounts\AccountType;

interface AccountType
{
    public function save_account_type(array $data);
    public function get_account_type();
    public function update_account_type(array $data);
    public function get_account_type_id($id);
    public function delete_account_type($id);
}