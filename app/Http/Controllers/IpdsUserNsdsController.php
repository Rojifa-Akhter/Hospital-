<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;
use Session;


class IpdsUserNsdsController extends Controller
{
    public function index()
    {
        $item = DB::table('IPDS_USER_NSDS')
            ->orderBy('USER_NSDS_PK_NO', 'desc')
            ->get();
        // dd($item->all());
        return Template::loadview("admin.settings.ipda_uaer_nsds.index", compact('item'));
    }


    public function store(Request $request)
    {
        $validData = Validator::make($request->all(), [
            'upd_privs' => 'required',
            'ins_privs' => 'required',
        ]);

        if ($validData->fails()) {
            return response()->json(['status' => 0, 'msg' => 'Validation error']);
        } else {

            try {
                $sequence = DB::getSequence();
                $sysc_pat_no_pk_seq = $sequence->nextValue('USER_NSDS_PK_NO_SEQ') + 1;
                DB::table('IPDS_USER_NSDS')->insert([
                    'USER_NSDS_PK_NO' => $sysc_pat_no_pk_seq,
                    'upd_privs' => $request->upd_privs,
                    'ins_privs' => $request->ins_privs,
                    'AU_ENTRY_AT' => date('Y-m-d'),
                    'AU_ENTRY_HOSPITAL_PK_NO' => Session::get('user.ses_hospital_no_pk'),
                    'STATUS' => $request->status,
                    'AU_ENTRY_SESSION' => 'hospital',
                ]);
                $this->message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
            } catch (\Exception $e) {
                DB::rollback();
                $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            }
            return response()->json($this->message);
        }
    }

    public function edit($edit_id)
    {
        $item = DB::table('IPDS_USER_NSDS')->where('USER_NSDS_PK_NO', $edit_id)->first();
        // dd($item);
        return Template::loadview("admin.settings.ipda_uaer_nsds.edit", compact('item'));
    }

    public function update(Request $request, $update_id)
    {
        $validData = Validator::make($request->all(), [
            'upd_privs' => 'required',
            'ins_privs' => 'required',
        ]);

        if ($validData->fails()) {
            return response()->json(['status' => 0, 'msg' => 'Validation error']);
        } else {

            try {
                $data = [
                    'upd_privs' => $request->upd_privs,
                    'ins_privs' => $request->ins_privs,
                    'STATUS' => $request->status,
                ];
                DB::table('IPDS_USER_NSDS')->where('USER_NSDS_PK_NO', $update_id)->update($data);
                $this->message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
            } catch (\Exception $e) {
                DB::rollback();
                $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            }
            return response()->json($this->message);
        }
    }
}
