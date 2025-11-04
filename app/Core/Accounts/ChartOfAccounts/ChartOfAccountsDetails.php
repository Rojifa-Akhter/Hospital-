<?php

namespace App\Core\Accounts\ChartOfAccounts;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Traits\UtilitiesTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Core\Accounts\ChartOfAccounts\ChartOfAccounts;
class ChartOfAccountsDetails implements ChartOfAccounts
{
    use UtilitiesTrait;
    public function save_chart_of_account(array $data)
    {
        $au_entry_at = Carbon::now();

        $au_entry_at = $au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        if (!is_array($data)) {
            return response()->json(['success' => false, 'message' => 'Data must be an array'], 200);
        }

        $account_name = Str::ucfirst($data['account_name']);

        try {

            if (DB::table('acct_chart_of_accounts')
                ->where('account_name', $data['account_name'])
                ->orWhere('account_code', $data['account_code'])
                ->exists()
            ) {
                return response()->json(['success' => false, 'message' => 'Account name already exist in database'], 406);
            }


            DB::beginTransaction();

            $sequence = DB::getSequence();

            $account_no_pk_seq = $sequence->nextValue('account_no_pk_seq');

            $account_name = Str::upper($data['account_name']);

            $acc_type = DB::table('acct_chart_of_accounts')
                ->insert([
                    'account_no_pk' => $account_no_pk_seq,
                    'account_code' => $data['account_code'],
                    'account_name' => $account_name,
                    'acct_type_no_fk' => $data['acct_type_no_fk'],
                    'account_no_fk_root_0' => $data['account_no_fk_root_0'],
                    'account_no_fk_root_s1' => $data['account_no_fk_root_s1'],
                    'account_no_fk_root_s2' => $data['account_no_fk_root_s2'],
                    'account_no_fk_root_s3' => $data['account_no_fk_root_s3'],
                    'account_no_fk_root_s4' => $data['account_no_fk_root_s4'],
                    'cashflow_category_no_fk' => !empty($data['cashflow_category_no_fk']) ? $data['cashflow_category_no_fk'] : 0,
                    'ledger_group_name' => !empty($data['ledger_group_name']) ? $data['ledger_group_name'] : null,
                    'account_no_sl' => $data['account_no_sl'],
                    'posting_head_ind' => $data['posting_head_ind'],
                    'au_entry_at' => $au_entry_at,
                    'au_entry_by' => Auth::id(),
                    'status' => $data['status'],
                    'au_entry_session' => $entry_session,
                    'au_entry_hospital_pk_no' => $hospital_pk_no,
                    'cashflow_ind' => $data['cashflow_ind'],
                    'income_exp_ind' => $data['income_exp_ind'],
                    'income_exp_type' => !empty($data['income_exp_type']) ? $data['income_exp_type'] : null
                ]);

            DB::commit();

            $acc_chart_of_acc = DB::table('acct_chart_of_accounts')->orderBy('account_no_sl', 'asc')->get();

            return response()->json(['success' => true, 'data' => $acc_chart_of_acc], 200);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);
        }
    }

    public function get_chart_of_account()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $get_account = DB::table('acct_chart_of_accounts')
            ->orderBy('account_no_pk', 'asc')
            ->where('au_entry_hospital_pk_no',    $ses_hospital_id)
            ->get();

        if ($get_account->isEmpty()) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'No Data Found'], 200);
        }

        return response()->json(['success' => true, 'data' => $get_account], 200);
    }


    public function get_root_child_accounts($root_id)
    {
        $get_account = DB::table('acct_chart_of_accounts')
            ->where('account_no_fk_root_0', $root_id)
            ->orderBy('account_no_pk', 'asc')
            ->get();

        if ($get_account->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No Data Found'], 200);
        }

        return response()->json(['success' => true, 'data' => $get_account], 200);
    }

    public function get_root_account()
    {
        $get_root_account = DB::table('acct_chart_of_accounts')
            ->where('acct_type_no_fk', '>', 0)
            ->orderBy('account_no_pk', 'asc')
            ->get();

        if ($get_root_account->isEmpty()) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'No Data Found'], 200);
        }

        return response()->json(['success' => true, 'data' => $get_root_account], 200);
    }

    public function update_chart_of_account(array $data)
    {
        $au_entry_at = Carbon::now();

        $au_entry_at = $au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        if (!is_array($data)) {
            return response()->json(['success' => false, 'message' => 'Data must be an array'], 200);
        }

        $account_name = Str::upper($data['account_name']);

        try {


            DB::beginTransaction();


            $acc_type = DB::table('acct_chart_of_accounts')
                ->where('account_no_pk', $data['account_no_pk'])
                ->update([
                    'account_name' => $account_name,
                    'account_no_sl' => $data['account_no_sl'],
                    'au_entry_at' => $au_entry_at,
                    'au_entry_by' => Auth::id(),
                    'status' => $data['status'],
                    'au_entry_session' => $entry_session,
                    'au_entry_hospital_pk_no' => $hospital_pk_no,
                    'posting_head_ind' => $data['posting_head_ind'],
                    'cashflow_category_no_fk' => $data['cashflow_category_no_fk'],
                    'ledger_group_name' => $data['ledger_group_name'],
                    'cashflow_ind' => $data['cashflow_ind'],
                    'income_exp_ind' => $data['income_exp_ind'],
                    'income_exp_type' => $data['income_exp_type']
                ]);

            DB::commit();

            $acc_chart_of_acc = DB::table('acct_chart_of_accounts')->orderBy('account_no_pk', 'asc')->get();

            return response()->json(['success' => true, 'data' => $acc_chart_of_acc], 200);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);
        }
    }

    public function update_acct_type_chart_of_account(array $data)
    {
        $au_entry_at = Carbon::now();

        $au_entry_at = $au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        if (!is_array($data)) {
            return response()->json(['success' => false, 'message' => 'Data must be an array'], 200);
        }

        $account_name = Str::upper($data['account_name']);

        try {



            DB::beginTransaction();


            $acc_type = DB::table('acct_chart_of_accounts')
                ->where('acct_type_no_fk', $data['acct_type_no_pk'])
                ->update([
                    'account_name' => $account_name,
                    'acct_type_no_fk' => $data['acct_type_no_pk'],
                    'account_no_sl' => $data['account_no_sl'],
                    'au_entry_at' => $au_entry_at,
                    'au_entry_by' => Auth::id(),
                    'status' => $data['status'],
                    'au_entry_session' => $entry_session,
                    'au_entry_hospital_pk_no' => $hospital_pk_no,
                    'cashflow_category_no_fk' => $data['cashflow_category_no_fk'],
                    'ledger_group_name' => $data['ledger_group_name'],
                    'cashflow_ind' => $data['cashflow_ind'],
                    'income_exp_ind' => $data['income_exp_ind'],
                    'income_exp_type' => $data['income_exp_type']
                ]);

            DB::commit();

            $acc_chart_of_acc = DB::table('acct_chart_of_accounts')->orderBy('account_no_pk', 'asc')->get();

            return response()->json(['success' => true, 'data' => $acc_chart_of_acc], 200);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);
        }
    }

    public function get_chart_of_account_by_id($id)
    {
        if (!isset($id) || empty($id)) {

            return response()->json(['success' => false, 'message' => 'ID missing'], 200);
        }

        if (!DB::table('acct_chart_of_accounts')
            ->where('account_no_pk', $id)
            ->exists()) {
            return response()->json(['success' => false, 'message' => 'No Data Found'], 200);
        }

        $get_account = DB::table('acct_chart_of_accounts')
            ->where('account_no_pk', $id)
            ->first();

        return response()->json(['success' => true, 'data' => $get_account], 200);
    }

    public function delete_chart_of_account($id)
    {
    }

    public function get_last_account_codeno()
    {
        $last_account_info = DB::table('acct_chart_of_accounts')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->orderBy('account_no_pk', 'desc')->first();

        if (!$last_account_info) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'No Data Found'
                ], 200);
        }

        return response()
            ->json([
                'success' => true,
                'data' => $last_account_info
            ], 200);
    }

    public function get_accounts_level()
    {
        $chartof_accounts = $this->get_chart_of_account();

        $chartof_accounts = $chartof_accounts->getData()->data;

        if (count($chartof_accounts) == 0) {
            throw new \Exception('No Record Found');
        }

        $accoutns_level = [];

        $ac = 1;

        foreach ($chartof_accounts as $account) {

            $account_no_pk = $account->account_no_pk;
            // select*from acct_chart_of_accounts
            // where account_no_pk in(select account_no_fk_root_0 from acct_chart_of_accounts where account_no_pk = 65)

            $acct_type = DB::table('acct_chart_of_accounts')->whereIn('account_no_pk', function ($query) use ($account_no_pk) {
                return $query->select('account_no_fk_root_0')
                    ->from('acct_chart_of_accounts')
                    ->where('account_no_pk', $account_no_pk)
                    ->get();
            })->get();

            $cashflow_cat = DB::table('acct_cashflow_category')->where('cashflow_category_no_pk', $account->cashflow_category_no_fk)->get();

            array_push($accoutns_level, [
                'sl' => str_pad($ac, 2, '0', STR_PAD_LEFT),
                'acc_code' => $account->account_code,
                'acc_name' => $account->account_name,
                'acc_type_name' => @$acct_type[0]->account_name,
                'cashflow_category_name' => @$cashflow_cat[0]->cashflow_category_name
            ]);

            $ac++;
        }

        return response()->json(['success' => true, 'data' => $accoutns_level]);
    }

    public function get_accounts_levelV1()
    {
        $chartof_accounts = $this->get_chart_of_accountV1();

        $chartof_accounts = $chartof_accounts->getData()->data;

        if (count($chartof_accounts) == 0) {
            return response()->json(['success' => true, 'data' => []]);
        }
        return response()->json(['success' => true, 'data' => $chartof_accounts]);
    }

    public function request_get_accounts_level($acc_id)
    {
        if ($acc_id == "all") {

            $chartof_accounts = $this->get_chart_of_account();
            $chartof_accounts = $chartof_accounts->getData()->data;
        } else {

            $chartof_accounts = DB::table('acct_chart_of_accounts')
                ->where('account_no_fk_root_0', $acc_id)
                ->get();
        }

        if (count($chartof_accounts) == 0) {

            throw new \Exception('No Record Found');
        }

        $accoutns_level = [];

        $ac = 1;

        foreach ($chartof_accounts as $account) {

            $account_no_pk = $account->account_no_pk;
            // select*from acct_chart_of_accounts
            // where account_no_pk in(select account_no_fk_root_0 from acct_chart_of_accounts where account_no_pk = 65)

            $acct_type = DB::table('acct_chart_of_accounts')->whereIn('account_no_pk', function ($query) use ($account_no_pk) {
                return $query->select('account_no_fk_root_0')
                    ->from('acct_chart_of_accounts')
                    ->where('account_no_pk', $account_no_pk)
                    ->get();
            })->get();

            $cashflow_cat = DB::table('acct_cashflow_category')->where('cashflow_category_no_pk', $account->cashflow_category_no_fk)->get();

            array_push($accoutns_level, [
                'sl' => str_pad($ac, 2, '0', STR_PAD_LEFT),
                'acc_code' => $account->account_code,
                'acc_name' => $account->account_name,
                'acc_type_name' => @$acct_type[0]->account_name,
                'cashflow_category_name' => @$cashflow_cat[0]->cashflow_category_name
            ]);

            $ac++;
        }

        return response()->json(['success' => true, 'data' => $accoutns_level]);
    }

    public function transection_accounts_head()
    {
        $get_account = DB::table('acct_chart_of_accounts c')
            ->join('acct_chart_of_accounts pr', 'c.account_no_fk_root_0', '=', 'pr.account_no_pk')
            ->leftJoin('acct_chart_of_accounts r', 'pr.account_no_fk_root_s1', '=', 'r.account_no_pk')
            ->select('c.account_code', 'c.account_name', 'pr.account_name as pr_account_name', 'r.account_name as root_account_name')
            ->where('c.posting_head_ind', 1)
            ->where('c.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get();

        if ($get_account->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No Data Found'], 200);
        }

        return response()->json(['success' => true, 'data' => $get_account], 200);
    }


    // Accounts V1 Methods
    
    public function get_chart_of_accountV1()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $get_account = DB::table('acct_chart_of_accounts')
            ->orderBy('account_no_pk', 'asc')
            ->where('au_entry_hospital_pk_no',    $ses_hospital_id)
            ->where('posting_head_ind',1)
            // ->where('acc_5typedescription_no_fk','!=',null)
            ->select(
                'status',
                'bank_ind',
                'default_dr_cr',
                'account_code',
                'account_name',
                'cashflow_ind',
                'account_no_sl',
                'account_no_pk',
                'control_acc_ind',
                'cost_center_ind',
                'sub_ledger_ind',
                'income_exp_ind',
                'income_exp_type',
                'posting_head_ind',
                'recurring_cost_ind',
                'cash_flow_report_txt',
                'liabilities_report_txt',
                'balance_sheet_report_txt',
                'income_statement_report_txt'
                )
            ->get();

        if ($get_account->isEmpty()) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'No Data Found'], 200);
        }

        return response()->json(['success' => true, 'data' => $get_account], 200);
    }

    public function get_accounts_levelBankV1()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $get_account = DB::table('acct_chart_of_accounts')
                            ->orderBy('account_no_pk', 'asc')
                            ->where('au_entry_hospital_pk_no', $ses_hospital_id)
                            ->where('posting_head_ind', 1)
                            ->where('bank_ind', 1) 
                            ->select(
                                'status',
                                'bank_ind',
                                'default_dr_cr',
                                'account_code',
                                'account_name',
                                'cashflow_ind',
                                'account_no_sl',
                                'account_no_pk',
                                'control_acc_ind',
                                'cost_center_ind',
                                'sub_ledger_ind',
                                'income_exp_ind',
                                'income_exp_type',
                                'posting_head_ind',
                                'recurring_cost_ind',
                                'cash_flow_report_txt',
                                'liabilities_report_txt',
                                'balance_sheet_report_txt',
                                'income_statement_report_txt'
                                )
                            ->get();
        return $get_account;
    }
    
    public function get_account_type()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $acc_type_rec = DB::table('acct_account_type')->where('au_entry_hospital_pk_no',  $ses_hospital_id)->orderBy('acct_type_no_pk','asc')->get();

        if ($acc_type_rec->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No Data Found'], 200);
        }

        return response()->json(['success' => true, 'data' => $acc_type_rec], 200);
    }

    public function add_voucher_type(array $data)
    {
        $au_entry_at = Carbon::now();

        $au_entry_at = $au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        if (! is_array($data)) {
            return response()->json(['success' => false, 'message' => 'Data Must Be an Array'], 200);
        }

        $voucher_type_name = Str::upper($data['voucher_type_name']);

        if (DB::table('acct_voucher_type')->where('voucher_type_name', $voucher_type_name)->exists())
        {
            return response()->json(['success' => false, 'message' => 'Voucher type already exists'], 200);
        }

        if (DB::table('acct_voucher_type')->where('voucher_type_code', $data['voucher_type_code'])->exists())
        {
            return response()->json(['success' => false, 'message' => 'Voucher type already exists'], 200);
        }

        try {
            DB::beginTransaction();

            $sequence = DB::getSequence();

            $voucher_type_no_pk_seq = $sequence->nextValue('voucher_type_no_pk_seq');


            DB::table('acct_voucher_type')
                ->insert([
                    'voucher_type_no_pk' => $voucher_type_no_pk_seq,
                    'voucher_type_code' => $data['voucher_type_code'],
                    'voucher_type_name' => $voucher_type_name,
                    'verrify_req_ind' => 1,
                    'status' => 1,
                    'au_entry_by' => Auth::id(),
                    'au_entry_at' => $au_entry_at,
                    'au_entry_session' => $entry_session,
                    'au_entry_hospital_pk_no' => $hospital_pk_no
                ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Voucher type successfully inserted'], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 200);

        }


    }
    
    public function get_sub_ledger_type(){

        $sub_ledger_type = $this->get_sub_ledger_type_v1();

        $sub_ledger_type = $sub_ledger_type->getData()->data;

        // if (count($sub_ledger_type) == 0) {
        //     throw new \Exception('No Record Found');
        // }
        return response()->json(['success' => true, 'data' => $sub_ledger_type]);
    }

    public function get_sub_ledger_name($con=null){

        $sub_ledger_type = $this->get_sub_ledger_name_v1($con);

        $sub_ledger_type = $sub_ledger_type->getData()->data;

        // if (count($sub_ledger_type) == 0) {
        //     throw new \Exception('No Record Found');
        // }
        return response()->json(['success' => true, 'data' => $sub_ledger_type]);
    }

    public function get_sub_ledger_type_v1(){

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $get_account = DB::table('acct_subledger_type as st')
            ->leftJoin('acct_chart_of_accounts as cr', 'cr.account_no_pk', '=', 'st.cr_account_no_fk')
            ->leftJoin('acct_chart_of_accounts as dr', 'dr.account_no_pk', '=', 'st.dr_account_no_fk')
            ->where('st.au_entry_hospital_pk_no', $ses_hospital_id)
            ->select(
                'st.notes',
                'st.status',
                'st.subledgertype_name',
                'st.subledgertype_code',
                'st.cr_account_no_fk',
                'st.dr_account_no_fk',
                'st.acct_subledger_typeno_pk',
                'cr.account_name as cr_account_name',
                'dr.account_name as dr_account_name'
            )
            ->orderBy('st.acct_subledger_typeno_pk', 'desc')
            ->get();

        // $get_account = DB::table('acct_subledger_type')
        //     ->where('au_entry_hospital_pk_no',    $ses_hospital_id)
        //     ->select(
        //         'notes',
        //         'status',
        //         'subledgertype_name',
        //         'subledgertype_code',
        //         'cr_account_no_fk',
        //         'dr_account_no_fk',
        //         'acct_subledger_typeno_pk'
        //         )
        //     ->orderBy(DB::raw('LOWER(subledgertype_name)'), 'asc')
        //     ->get();

        if ($get_account->isEmpty()) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'No Data Found'], 200);
        }

        return response()->json(['success' => true, 'data' => $get_account], 200);
    }
    
    public function get_sub_ledger_by_id($id){
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $get_subledger = DB::table('acct_subledger_name')
            ->orderBy('acct_subledger_name.acct_subledger_no_pk', 'desc')
            ->leftJoin('acct_subledger_type','acct_subledger_type.acct_subledger_typeno_pk','=','acct_subledger_name.acct_subledger_typeno_fk')
            ->where('acct_subledger_name.au_entry_hospital_pk_no', $ses_hospital_id)
            ->where('acct_subledger_name.acct_subledger_no_pk', $id)
            ->select(
                'acct_subledger_name.notes',
                'acct_subledger_name.status',
                'acct_subledger_name.subledger_name',
                'acct_subledger_name.subledger_code',
                'acct_subledger_name.acct_subledger_no_pk',
                'acct_subledger_name.acct_subledger_typeno_fk',
                'acct_subledger_type.subledgertype_name'
                )
            ->first();

      return $get_subledger;
    }
    
    public function save_sub_ledger_type(array $data){
        
        try {
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            if (!is_array($data)) {
                return response()->json(['success' => false, 'message' => 'Data must be an array'], 200);
            }

            $sequence = DB::getSequence();
            $acct_subledger_typeno_pk = $sequence->nextValue('acct_subledger_typeno_pk_seq');

            $datas = [
                'notes' => $data['notes'],
                'status' => $data['status'],
                'subledgertype_name' => $data['subledgertype_name'],
                'subledgertype_code' => $data['subledgertype_code'],
                'dr_account_no_fk' => $data['dr_account_no_fk'],
                'cr_account_no_fk' => $data['cr_account_no_fk'],
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'acct_subledger_typeno_pk' => $acct_subledger_typeno_pk
            ];
            if(DB::table('acct_subledger_type')->where('subledgertype_code',$data['subledgertype_code'])->exists()){
                return response()->json(['success' => false,'message' => 'Sub Ledger Code Already Exists'],422);
            }
            DB::table('acct_subledger_type')->insert($datas);

            // $sub_ledger_type = DB::table('acct_subledger_type')->orderBy('acct_subledger_typeno_pk', 'desc')->get();

            $sub_ledger_type = DB::table('acct_subledger_type as st')
            ->leftJoin('acct_chart_of_accounts as cr', 'cr.account_no_pk', '=', 'st.cr_account_no_fk')
            ->leftJoin('acct_chart_of_accounts as dr', 'dr.account_no_pk', '=', 'st.dr_account_no_fk')
            ->where('st.au_entry_hospital_pk_no', $hospital_pk_no)
            ->select(
                'st.notes',
                'st.status',
                'st.subledgertype_name',
                'st.subledgertype_code',
                'st.cr_account_no_fk',
                'st.dr_account_no_fk',
                'st.acct_subledger_typeno_pk',
                'cr.account_name as cr_account_name',
                'dr.account_name as dr_account_name'
            )
            ->orderBy('st.acct_subledger_typeno_pk', 'desc')
            ->get();

            return response()->json(['success' => true, 'message' => 'Successfully Saved', 'data' => $sub_ledger_type], 200);
            } catch (\Throwable $th) {
                return response()->json(['success' => false, 'message' => $th->getMessage(), 'data' => []], 422);
            }
    }
    
    public function update_sub_ledger_type(array $data){
        
        try {
            $update = [               
                'notes' => $data['notes'],
                'status' => $data['status'],
                'subledgertype_name' =>$data['subledgertype_name'],
                'subledgertype_code' =>$data['subledgertype_code'],
                'dr_account_no_fk' =>$data['dr_account_no_fk'],
                'cr_account_no_fk' =>$data['cr_account_no_fk'],
            ];
            if(DB::table('acct_subledger_type')->where('acct_subledger_typeno_pk','!=', $data['acct_subledger_typeno_pk'])->where('subledgertype_code',$data['subledgertype_code'])->exists()){
                return response()->json(['success' => false,'msg' => 'Sub Ledger Code Already Exists','title' => 'Error'],422);
            }
            DB::table('acct_subledger_type')->where('acct_subledger_typeno_pk', $data['acct_subledger_typeno_pk'])->update($update);      
            return response()->json(['success' => true,'msg' => 'Successfully Updated','title' => 'Success'],200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false,'msg' => $th->getMessage(),'title' => 'Error'],422);
        }
        
        
    }

    public function get_sub_ledger_name_v1($con){

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $get_account = DB::table('acct_subledger_name')
            ->leftJoin('acct_subledger_type','acct_subledger_type.acct_subledger_typeno_pk','=','acct_subledger_name.acct_subledger_typeno_fk')
            ->where('acct_subledger_name.au_entry_hospital_pk_no',    $ses_hospital_id)
            ->select(
                'acct_subledger_name.notes',
                'acct_subledger_name.status',
                'acct_subledger_name.subledger_name',
                'acct_subledger_name.subledger_code',
                'acct_subledger_name.acct_subledger_no_pk',
                'acct_subledger_name.acct_subledger_typeno_fk',
                'acct_subledger_name.sub_ledger_tracking_no',
                'acct_subledger_type.dr_account_no_fk',
                'acct_subledger_type.cr_account_no_fk',
                'acct_subledger_type.subledgertype_name'
            );

             if($con != null) 
             { 
                $get_account->whereRaw($con);
             }
            $get_account = $get_account->orderBy(DB::raw('LOWER(acct_subledger_type.subledgertype_name)'), 'asc')
            ->get();

        if ($get_account->isEmpty()) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'No Data Found'], 200);
        }

        return response()->json(['success' => true, 'data' => $get_account], 200);
    }
    
    public function save_sub_ledger_name(array $data){
        
        try {
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');

            if (!is_array($data)) {
                return response()->json(['success' => false, 'message' => 'Data must be an array'], 200);
            }

            $sequence = DB::getSequence();
            $acct_subledger_no_pk = $sequence->nextValue('acct_subledger_no_pk_seq');

            $datas = [
                'notes' => $data['notes'],
                'status' => $data['status'],
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'acct_subledger_typeno_fk' => $data['sub_ledger_type'],
                'subledger_name' => $data['sub_ledger_name'],
                'subledger_code' => $data['sub_ledger_name_code'],
                'sub_ledger_tracking_no' => $data['tracking_id'],
                'acct_subledger_no_pk' => $acct_subledger_no_pk
            ];
            if(DB::table('acct_subledger_name')->where('subledger_code',$data['sub_ledger_name_code'])->exists()){
                return response()->json(['success' => false,'message' => 'Sub Ledger Code Already Exists'],422);
            }
            DB::table('acct_subledger_name')->insert($datas);

            $sub_ledger_name = $this->get_sub_ledger_name_v1(null);

            return response()->json(['success' => true, 'message' => 'Successfully Saved', 'data' => $sub_ledger_name->getData()->data], 200);
            } catch (\Throwable $th) {
                return response()->json(['success' => false, 'message' => $th->getMessage(), 'data' => []], 422);
            }
    }

    public function update_sub_ledger_name(array $data){
        
        try {
            $update = [               
                'notes' => $data['notes'],
                'status' => $data['status'],
                'subledger_name' =>$data['sub_ledger_name'],
                'subledger_code' =>$data['sub_ledger_name_code'],
                'acct_subledger_typeno_fk' =>$data['sub_ledger_type'],
                'sub_ledger_tracking_no' =>$data['tracking_id']
            ];
            if(DB::table('acct_subledger_name')->where('acct_subledger_no_pk','!=', $data['acct_subledger_no_pk'])->where('subledger_code',$data['sub_ledger_name_code'])->exists()){
                return response()->json(['success' => false,'msg' => 'Sub Ledger Code Already Exists','title' => 'Error'],422);
            }
            DB::table('acct_subledger_name')->where('acct_subledger_no_pk', $data['acct_subledger_no_pk'])->update($update);      
            return response()->json(['success' => true,'msg' => 'Successfully Updated','title' => 'Success'],200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false,'msg' => $th->getMessage(),'title' => 'Error'],422);
        }
        
        
    }

    public function get_service_unit($con){

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $query = DB::table('sysc_serviceunit')
            ->orderBy('serviceunit_no_pk', 'asc')
            ->where('au_entry_hospital_pk_no',$ses_hospital_id);
            if(!empty($con)){
                $query->whereRaw($con);
            }
            $query->select(
                'status',
                'serviceunit_code',
                'serviceunit_name',
                'report_header',
                'serviceunit_no_pk'
            );
            
            $get_account =   $query->get();

        if ($get_account->isEmpty()) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'No Data Found'], 200);
        }

        return response()->json(['success' => true, 'data' => $get_account], 200);
    }

    public function get_cost_center_v1($con = null){

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $get_account = DB::table('acct_costcenter')

            ->leftJoin('sysc_serviceunit','sysc_serviceunit.serviceunit_no_pk','=','acct_costcenter.su_no_fk')
            ->where('acct_costcenter.au_entry_hospital_pk_no',    $ses_hospital_id)
            ->select(
                'acct_costcenter.notes',
                'acct_costcenter.status',
                'acct_costcenter.costcenter_code',
                'acct_costcenter.costcenter_name',
                'acct_costcenter.costcenter_no_pk',
                'acct_costcenter.su_no_fk',
                'sysc_serviceunit.serviceunit_code',
                'sysc_serviceunit.serviceunit_name',
                'sysc_serviceunit.report_header'
            );
           
            if($con != null){
                $get_account->whereRaw($con);
            }
            $get_account = $get_account->orderBy(DB::raw('lower(serviceunit_name)'),'asc')->get();

        if ($get_account->isEmpty()) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'No Data Found'], 200);
        }

        return response()->json(['success' => true, 'data' => $get_account], 200);
    }
     
    public function save_cost_center_v1(array $data){
          
        try {
                $au_entry_at = Carbon::now();
                $au_entry_at = $au_entry_at->toDateString();
                $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
                $entry_session = Session()->get('user.ses_user_pk_no');

                if (!is_array($data)) {
                    return response()->json(['success' => false, 'message' => 'Data must be an array'], 200);
                }

                $sequence = DB::getSequence();
                $costcenter_no_pk = $sequence->nextValue('seq_costcenter_no_pk');

                $datas = [
                    'notes' => $data['notes'],
                    'status' => $data['status'],
                    'au_entry_at' => $au_entry_at,
                    'au_entry_by' => Auth::id(),
                    'au_entry_session' => $entry_session,
                    'au_entry_hospital_pk_no' => $hospital_pk_no,
                    'su_no_fk' => $data['department'],
                    'costcenter_name' => $data['cost_center_name'],
                    'costcenter_code' => $data['cost_center_code'],
                    'costcenter_no_pk' => $costcenter_no_pk
                ];
                if(DB::table('acct_costcenter')->where('costcenter_code',$data['cost_center_code'])->exists()){
                    return response()->json(['success' => false,'message' => 'Cost Center Code Already Exists'],422);
                }
                DB::table('acct_costcenter')->insert($datas);

                $cost_center = $this->get_cost_center_v1();

                return response()->json(['success' => true, 'message' => 'Successfully Saved', 'data' => $cost_center->getData()->data], 200);
            } catch (\Throwable $th) {
                return response()->json(['success' => false, 'message' => $th->getMessage(), 'data' => []], 200);
            }
    }
    
    public function update_cost_center_v1(array $data){
        try {
            $update = [               
                'notes' => $data['notes'],
                'status' => $data['status'],
                'su_no_fk' =>$data['department'],
                'costcenter_name' =>$data['costcenter_name'],
                'costcenter_code' =>$data['costcenter_code'],
                'costcenter_no_pk' =>$data['costcenter_no_pk']
            ];
            if(DB::table('acct_costcenter')->where('costcenter_no_pk','!=', $data['costcenter_no_pk'])->where('costcenter_code',$data['costcenter_code'])->exists()){
                return response()->json(['success' => false,'msg' => 'Cost Center Code Already Exists','title' => 'Error'],422);
            }
            DB::table('acct_costcenter')->where('costcenter_no_pk', $data['costcenter_no_pk'])->update($update);      
            return response()->json(['success' => true,'msg' => 'Successfully Updated','title' => 'Success'],200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false,'msg' => $th->getMessage(),'title' => 'Error'],422);
        }
    }
    
    public function get_account_level($id){
        $accountLevel =  DB::table('acct_chart_of_accounts')->where('account_no_pk', $id)->get();
        
        if ($accountLevel->isEmpty()) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'No Data Found'], 200);
        }

        return response()->json(['success' => true, 'data' => $accountLevel], 200);
    }

    public function get_company(){
        $company = DB::table('wsec_hospital')->select('hospital_no_pk','hospital_code','hospitalchain_no_fk','hospital_name','hospital_alias','hospital_slogan','status')->get();
        if ($company->isEmpty()) {
            return response()->json(['success' => false, 'data' => [], 'message' => 'No Data Found'], 200);
        }

        return response()->json(['success' => true, 'data' => $company], 200);
    }

    public function get_chart_of_account_by_id_v1($id)
    {
        if (!isset($id) || empty($id)) {

            return response()->json(['success' => false, 'message' => 'ID missing'], 200);
        }

        if (!DB::table('acct_chart_of_accounts')
            ->where('account_no_pk', $id)
            ->exists()) {
            return response()->json(['success' => false, 'message' => 'No Data Found'], 200);
        }

        $get_account = DB::table('acct_chart_of_accounts')
            ->where('account_no_pk', $id)
            ->first();

        return response()->json(['success' => true, 'data' => $get_account], 200);
    }   


    public function get_chart_of_account_by_code_v1($code)
    {
        if (!isset($code) || empty($code)) {

            return response()->json(['success' => false, 'message' => 'ID missing'], 200);
        }

        if (!DB::table('acct_chart_of_accounts')
            ->where('account_code', $code)
            ->exists()) {
            return response()->json(['success' => false, 'message' => 'No Data Found'], 200);
        }

        $get_account = DB::table('acct_chart_of_accounts')
            ->where('account_code', $code)
            ->select('account_name','account_code','account_no_pk')
            ->first();

        return response()->json(['success' => true, 'data' => $get_account], 200);
    } 
    
    public function get_chart_of_account_list_v1(){
        $get_account = DB::table('acc_coa_4accounttype_vw')
                        ->selectRaw("distinct ACC_1GROUP_NO_PK, ACC_1GROUP_CODE, ACC_1GROUP_NAME, ACC_CODE_RANGE_1_START, ACC_CODE_RANGE_1_END, ACC_2SUBGROUP_NO_PK, ACC_2SUBGROUP_CODE, ACC_2SUBGROUP_NAME, ACC_CODE_RANGE_2_START, ACC_CODE_RANGE_2_END, ACC_3GROUPTYPE_NO_PK, ACC_3GROUPTYPE_CODE, ACC_3GROUPTYPE_NAME, ACC_CODE_RANGE_3_START, ACC_CODE_RANGE_3_END, ACC_4TYPE_NO_PK, ACC_4TYPE_CODE, ACC_4TYPE_NAME, ACC_CODE_RANGE_4_START, ACC_CODE_RANGE_4_END, ACC_5TYPE_DESCRIPTION, ACC_5TYPE_DESCRIPTION_NOTES, ACC_CODE_RANGE_5_START, ACC_CODE_RANGE_5_END, ACC_5TYPEDESCRIPTION_NO_PK")
                        ->get();
        return response()->json(['success' => true, 'data' => $get_account]);
    }
    
    public function get_type_list_by_group_type($id){
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $get_account = DB::table('acc_coa_4accounttype')
            ->leftJoin('acc_coa_3accountgrouptype','acc_coa_3accountgrouptype.acc_3grouptype_no_pk','=','acc_coa_4accounttype.acc_3grouptype_no_fk')
            ->orderBy('acc_coa_4accounttype.acc_4type_no_pk', 'desc')
            ->where('acc_coa_4accounttype.au_entry_hospital_pk_no',    $ses_hospital_id)
            ->where('acc_coa_4accounttype.acc_3grouptype_no_fk', $id)
            ->select(
                'acc_coa_4accounttype.acc_4type_notes',
                'acc_coa_4accounttype.status',
                'acc_coa_4accounttype.acc_4type_name',
                'acc_coa_4accounttype.acc_4type_code',
                'acc_coa_4accounttype.acc_4type_description',
                'acc_coa_4accounttype.acc_code_range_4_start',
                'acc_coa_4accounttype.acc_code_range_4_end',
                'acc_coa_4accounttype.acc_4type_no_pk',
                'acc_coa_4accounttype.acc_3grouptype_no_fk',
                'acc_coa_3accountgrouptype.acc_3grouptype_name',
                'acc_coa_3accountgrouptype.acc_3grouptype_code'
                )
                // ->groupBy(
                // 'acc_coa_4accounttype.acc_4type_notes',
                // 'acc_coa_4accounttype.status',
                // 'acc_coa_4accounttype.acc_4type_name',
                // 'acc_coa_4accounttype.acc_4type_code',
                // 'acc_coa_4accounttype.acc_4type_description',
                // 'acc_coa_4accounttype.acc_code_range_4_start',
                // 'acc_coa_4accounttype.acc_code_range_4_end',
                // 'acc_coa_4accounttype.acc_4type_no_pk',
                // 'acc_coa_4accounttype.acc_3grouptype_no_fk',
                // 'acc_coa_3accountgrouptype.acc_3grouptype_name',
                // 'acc_coa_3accountgrouptype.acc_3grouptype_code'
                // )

            ->get();
        return response()->json(['success' => true, 'data' => $get_account]);
    }

    public function get_chart_of_account_by_various_id($column,$id){
        $get_cof = DB::table('acc_coa_4accounttype_vw')
                        ->where($column,$id)
                        ->first();
        return response()->json(['success' => true, 'data' => $get_cof]);
    }
    
    public function get_account_list_by_type($id){

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $get_account = DB::table('acc_coa_5accountdescription')
            ->leftJoin('acc_coa_4accounttype','acc_coa_4accounttype.acc_4type_no_pk','=','acc_coa_5accountdescription.acc_4type_no_fk')
            ->orderBy('acc_coa_5accountdescription.acc_5typedescription_no_pk', 'desc')
            ->where('acc_coa_5accountdescription.au_entry_hospital_pk_no', $ses_hospital_id)
            ->where('acc_coa_5accountdescription.acc_4type_no_fk', $id)
            ->select(
                'acc_coa_5accountdescription.acc_5type_description_notes',
                'acc_coa_5accountdescription.status',
                'acc_coa_5accountdescription.acc_5type_description',
                'acc_coa_5accountdescription.type_code',
                'acc_coa_5accountdescription.acc_code_range_5_start',
                'acc_coa_5accountdescription.acc_code_range_5_end',
                'acc_coa_5accountdescription.acc_5typedescription_no_pk',
                'acc_coa_5accountdescription.acc_4type_no_fk',
                'acc_coa_4accounttype.acc_4type_name',
                'acc_coa_4accounttype.acc_4type_code'
                )
            ->get();
        return response()->json(['success' => true, 'data' => $get_account]);
    }

    public function get_gl_list_by_description($id){

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        
        $get_account = DB::table('acct_chart_of_accounts')
            ->orderBy('acct_chart_of_accounts.account_code', 'asc')
            ->leftJoin('acc_coa_5accountdescription','acc_coa_5accountdescription.acc_5typedescription_no_pk','=','acct_chart_of_accounts.acc_5typedescription_no_fk')
            ->where('acct_chart_of_accounts.au_entry_hospital_pk_no', $ses_hospital_id);
            
            if($id != 'all'){
                $get_account->where('acct_chart_of_accounts.acc_5typedescription_no_fk', $id); 
            }
            
            $get_account->where('acct_chart_of_accounts.posting_head_ind',1);
            $get_account->select(
                'acct_chart_of_accounts.status',
                'acct_chart_of_accounts.bank_ind',
                'acct_chart_of_accounts.account_code',
                'acct_chart_of_accounts.account_name',
                'acct_chart_of_accounts.cashflow_ind',
                'acct_chart_of_accounts.account_no_sl',
                'acct_chart_of_accounts.account_no_pk',
                'acct_chart_of_accounts.control_acc_ind',
                'acct_chart_of_accounts.cost_center_ind',
                'acct_chart_of_accounts.income_exp_ind',
                'acct_chart_of_accounts.income_exp_type',
                'acct_chart_of_accounts.posting_head_ind',
                'acct_chart_of_accounts.recurring_cost_ind',
                'acct_chart_of_accounts.cashflow_report_header',
                'acct_chart_of_accounts.cash_flow_ind',
                'acct_chart_of_accounts.report_header',
                'acct_chart_of_accounts.mapped_report',
                'acct_chart_of_accounts.default_dr_cr',
                'acct_chart_of_accounts.depreciation_ind',
                'acc_coa_5accountdescription.status',
                'acc_coa_5accountdescription.acc_5type_description',
                'acc_coa_5accountdescription.type_code',
                'acc_coa_5accountdescription.acc_code_range_5_start',
                'acc_coa_5accountdescription.acc_code_range_5_end',
            )
            ->orderBy('acct_chart_of_accounts.account_code','asc');
            $get_account_2 =  $get_account->get();
        return response()->json(['success' => true, 'data' => $get_account_2]);
    }
}