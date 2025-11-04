<?php

namespace App\Core\Accounts\VoucherEntry;

interface VoucherEntry
{
    public function add_voucher(array $data);
    public function get_active_inactive_voucher($conditions);
    public function set_active_inactive_voucher($voucher_no = null, $verified_ind = 0);

    public function set_finalized_notfinalized_voucher($voucher_no = null, $finalized_ind = 0);
    public function get_voucher($voucher_id);
    public function edit_voucher($voucher_id);
    public function update_voucher(array $data);
    public function delete_voucher($voucher_id);
    public function voucher_info($conditions);
    
    //Accounts V1
    public function save_journal_post(array $data);
    public function update_journal_post(array $data);
    public function journal_info($conditions);
    public function finalize_journal_info($conditions);
    public function finalize_journal_info_v1($conditions);
    public function get_journal($voucher_id);
    public function set_active_inactive_journal($voucher_no = null, $verified_ind = 0);
    public function set_active_inactive_journal_v2($voucher_no = null, $verified_ind = 0);
    public function set_finalized_notfinalized_journal($voucher_no = null, $finalized_ind = 0);
}