<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;
use Session;

class IpdsWardcoverageNsdsController extends Controller
{
    public function index()
    {
        $item = DB::table('IPDS_WARDCOVERAGE_NSDS')
            ->orderBy('NSDSCOVERAGE_NO_PK', 'desc')
            ->get();
        return Template::loadview("admin.settings.ipds_wardcoverage_nsds.index", compact('item'));
    }

    public function store(Request $request)
    {
        $validData = Validator::make($request->all(), [
            'ward_no_fk' => 'required',
        ]);

        if ($validData->fails()) {
            return response()->json(['status' => 0, 'msg' => 'Validation error']);
        } else {

            try {
                $sequence = DB::getSequence();
                $sysc_pat_no_pk_seq = $sequence->nextValue('NSDSCOVERAGE_NO_PK_SEQ') + 1;
                DB::table('IPDS_WARDCOVERAGE_NSDS')->insert([
                    'NSDSCOVERAGE_NO_PK' => $sysc_pat_no_pk_seq,
                    'ward_no_fk' => $request->ward_no_fk,
                    'AU_ENTRY_AT' => date('Y-m-d'),
                    'AU_ENTRY_HOSPITAL_NO_FK' => Session::get('user.ses_hospital_no_pk'),
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
        $item = DB::table('IPDS_WARDCOVERAGE_NSDS')->where('NSDSCOVERAGE_NO_PK', $edit_id)->first();
        // dd($item);
        return Template::loadview("admin.settings.ipds_wardcoverage_nsds.edit", compact('item'));
    }

    public function update(Request $request, $update_id)
    {
        $validData = Validator::make($request->all(), [
            'ward_no_fk' => 'required',
        ]);

        if ($validData->fails()) {
            return response()->json(['status' => 0, 'msg' => 'Validation error']);
        } else {

            try {
                $data = [
                    'ward_no_fk' => $request->ward_no_fk,
                    'STATUS' => $request->status,
                ];
                DB::table('IPDS_WARDCOVERAGE_NSDS')->where('NSDSCOVERAGE_NO_PK', $update_id)->update($data);
                $this->message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
            } catch (\Exception $e) {
                DB::rollback();
                $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            }
            return response()->json($this->message);
        }
    }
}
