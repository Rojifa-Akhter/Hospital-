<?php

namespace App\Core\Accounts\AccountType;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class AccountTypeDetails implements AccountType
{
    /**
     * Save root account
     *
     * @param array $data
     *
     * @return mixed
     */
    public function save_account_type(array $data)
    {
        $au_entry_at = Carbon::now();

        $au_entry_at = $au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        if (! is_array($data)) {
            return response()->json(['success' => false, 'message' => 'Data must be an array'], 200);
        }

        $acc_type_name = Str::upper($data['acct_type_name']);

        try {

            if (DB::table('acct_account_type')
            ->where('acct_type_name', $data['acct_type_name'])
            ->orWhere('acct_type_code', $data['acct_type_code'])
            ->exists())
            {
                return response()->json(['success' => false, 'message' => 'Account type already exist in database'], 406);
            }


            DB::beginTransaction();

            $sequence = DB::getSequence();

            $acct_type_no_pk_seq = $sequence->nextValue('acct_type_no_pk_seq');

            $acc_type = DB::table('acct_account_type')
                            ->insert([
                                'acct_type_no_pk' => $acct_type_no_pk_seq,
                                'acct_type_code' => $data['acct_type_code'],
                                'acct_type_name' => $acc_type_name,
                                'acct_type_sl' => $data['acct_type_sl'],
                                'au_entry_at' => $au_entry_at,
                                'au_entry_by' => Auth::id(),
                                'status' => $data['status'],
                                'au_entry_session' => $entry_session,
                                'au_entry_hospital_pk_no' => $hospital_pk_no,
                                'cashflow_ind' => $data['cashflow_ind'],
                                'income_exp_ind' => $data['income_exp_ind'],
                            ]);

            DB::commit();


            $acc_type_rec = DB::table('acct_account_type')->orderBy('acct_type_no_pk','asc')->get();
            $acc_type_last_rec = DB::table('acct_account_type')->orderBy('acct_type_no_pk','desc')->first();

            return response()->json(['success' => true, 'last_id' => $acc_type_last_rec, 'data' => $acc_type_rec], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);

        }

    }

    /**
     * Get add root accounts
     *
     * @return collection
     */
    public function get_account_type()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $acc_type_rec = DB::table('acct_account_type')->where('au_entry_hospital_pk_no',  $ses_hospital_id)->orderBy('acct_type_no_pk','asc')->get();

        if ($acc_type_rec->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No Data Found'], 200);
        }

        return response()->json(['success' => true, 'data' => $acc_type_rec], 200);
    }

    /**
     * update root accounts
     *
     * @param array $data
     *
     * @return mixed
     */
    public function update_account_type(array $data)
    {
        $au_update_at = Carbon::now();

        $au_update_at = $au_update_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');

        if (! is_array($data)) {
            return response()->json(['success' => false, 'message' => 'Data must be an array'], 200);
        }

        $acc_type_name = Str::upper($data['acct_type_name']);

        try {


            DB::beginTransaction();

            $acc_type = DB::table('acct_account_type')
                            ->where('acct_type_no_pk', $data['acct_type_no_pk'])
                            ->update([
                                'acct_type_name' => $acc_type_name,
                                'acct_type_sl' => $data['acct_type_sl'],
                                'au_update_at' => $au_update_at,
                                'au_entry_by' => Auth::id(),
                                'status' => $data['status'],
                                'au_entry_session' => $entry_session,
                                'au_entry_hospital_pk_no' => $hospital_pk_no,
                                'cashflow_ind' => $data['cashflow_ind'],
                                'income_exp_ind' => $data['income_exp_ind']
                            ]);

            DB::commit();

            $acc_type_rec = DB::table('acct_account_type')->orderBy('acct_type_no_pk','asc')->get();

            return response()->json(['success' => true, 'data' => $acc_type_rec], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);

        }
    }

    /**
     * Get single root account by root account id
     *
     * @param int $id
     *
     * @return mixed
     */
    public function get_account_type_id($id)
    {

    }

    /**
     * Delete root account type by id
     *
     * @param int $id
     *
     * @return mixed
     */
    public function delete_account_type($id)
    {

    }
}