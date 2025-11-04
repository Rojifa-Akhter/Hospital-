<?php

namespace App\Core\Accounts\VoucherType;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Core\Accounts\VoucherType\VoucherType;
use Session;

class VoucherTypeDetails implements VoucherType
{
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

    public function edit_voucher_type($id)
    {

    }

    public function update_voucher_type(array $data)
    {

    }

    public function set_voucher_type_status($status,$id)
    {
        if (DB::table('acct_voucher_type')->where('voucher_type_no_pk', $id)->exists()) {

            $voucher_type = DB::table('acct_voucher_type')->where('voucher_type_no_pk', $id);

            $voucher_type->update([
                'status' => $status == 1 ? 0 : 1
            ]);

            return response()->json(['success' => true, 'data' => DB::table('acct_voucher_type')->where('voucher_type_no_pk', $id)->first()], 200);

        }

        return response()->json(['success' => false, 'message' => 'No Data Found'], 200);
    }

    public function get_voucher_type()
    {
        $voucher_type = DB::table('acct_voucher_type')->where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'))->orderBy('voucher_type_no_pk','asc')->get();

        if (! $voucher_type->isEmpty()) {
            return response()->json(['success' => true, 'data' => $voucher_type], 200);
        }

        return response()->json(['success' => false, 'message' => 'No Data Found'], 200);
    }

    public function get_cost_center(){
        $cost_center = DB::table('acct_costcenter')->select('su_no_fk', 'costcenter_name', 'costcenter_code', 'costcenter_no_pk')->where('status',1)->get();

        if (! $cost_center->isEmpty()) {
            return response()->json(['success' => true, 'data' => $cost_center, 'cost_center' => $cost_center], 200);
        }

        return response()->json(['success' => false, 'message' => 'No Data Found'], 200);

    }

    public function get_voucher_type_v1()
    {
        $voucher_type = DB::table('acct_voucher_type')->where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'))->orderBy('voucher_type_no_pk','asc')->get();

        if (! $voucher_type->isEmpty()) {
            return response()->json(['success' => true, 'data' => $voucher_type], 200);
        }

        return response()->json(['success' => false, 'message' => 'No Data Found','data' => []], 200);
    }

    public function add_voucher_type_v1(array $data)
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
            return response()->json(['success' => false, 'message' => 'Journal Type Name Already Exists'], 422);
        }

        if (DB::table('acct_voucher_type')->where('voucher_type_code', $data['voucher_type_code'])->exists())
        {
            return response()->json(['success' => false, 'message' => 'Journal Type Code  Already Exists'], 422);
        }

        try {

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
            $data = $this->get_voucher_type_v1();
            return response()->json(['success' => true, 'message' => 'Successfully Saved', 'data' => $data->getData()->data], 200);

        } catch(\Exception $e) {

            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);

        }


    }

    public function set_voucher_type_status_v1($status,$id)
    {
        if (DB::table('acct_voucher_type')->where('voucher_type_no_pk', $id)->exists()) {

            $voucher_type = DB::table('acct_voucher_type')->where('voucher_type_no_pk', $id);

            $voucher_type->update([
                'status' => $status == 1 ? 0 : 1
            ]);
            $data = $this->get_voucher_type_v1();
            return response()->json(['success' => true, 'message' => 'Successfully Updated', 'data' => $data->getData()->data], 200);

        }

        return response()->json(['success' => false, 'message' => 'No Data Found','data'=> [] ], 422);
    }
}