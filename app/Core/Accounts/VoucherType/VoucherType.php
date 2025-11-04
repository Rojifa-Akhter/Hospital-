<?php

namespace App\Core\Accounts\VoucherType;

interface VoucherType
{
    public function add_voucher_type(array $data);
    public function edit_voucher_type($id);
    public function update_voucher_type(array $data);
    public function set_voucher_type_status($status,$id);
    public function get_voucher_type();
    public function get_cost_center();
    
    //Accounts V1
    public function get_voucher_type_v1();
    public function add_voucher_type_v1(array $data);
    public function set_voucher_type_status_v1($status,$id);
}