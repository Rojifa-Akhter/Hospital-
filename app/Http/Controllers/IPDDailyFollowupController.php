<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Session;

class IPDDailyFollowupController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Dhaka');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($patient_no_fk, $admission_id)
    {
        //

        $patient_info = DB::table('pat_registration_wl_vw a')
            ->select("a.*", "b.admission_no_pk", "b.admission_uid", "b.admission_date", "b.ward_name", "b.bed_name", "b.bed_uid", "b.admitted_department")
            ->leftJoin('ipd_admitted_pat_nsrcv_wl_vw b', "a.patient_no_pk", "=", "b.patient_no_fk")
            ->where('a.patient_no_pk', $patient_no_fk)
            ->where('b.admission_uid', $admission_id)
            ->get()->first();

        return Template::loadView("admin.ipd.nurse_station.daily_followup_pop_up", ['patient_info' => $patient_info, 'patient_no_fk' => $patient_no_fk, 'admission_id' => $admission_id]);
    }


    public function indexV2($patient_no_fk, $admission_id)
    {
        $patient_info = DB::table('pat_registration_wl_vw a')
            ->select("a.*", "b.admission_no_pk", "b.admission_uid", "b.admission_date", "b.ward_name", "b.bed_name", "b.bed_uid", "b.admitted_department")
            ->leftJoin('ipd_admitted_pat_nsrcv_wl_vw b', "a.patient_no_pk", "=", "b.patient_no_fk")
            ->where('a.patient_no_pk', $patient_no_fk)
            ->where('b.admission_uid', $admission_id)
            ->first();
        $admission_info = DB::table('ipd_admitted_patlist_vw')->where('admission_uid', $admission_id)->first();
        return Template::loadView("admin.ipd.nurse_station.daily_followup_pop_up_v1", ['patient_info' => $patient_info, 'patient_no_fk' => $patient_no_fk, 'admission_id' => $admission_id,'admission_info' => $admission_info]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //dd($request->all());
        $sequence = DB::getSequence();
        $dfollowupmst_no_pk_seq = $sequence->nextValue('dfollowupmst_no_pk_seq');

        $data = [
            'dfollowupmst_date' => date('Y-m-d h:i:s'),
            'patient_no_fk' => $request->patient_no_fk,
            'admission_no_fk' => $request->admission_no_fk,
            'followup_diagnosis' => $request->followup_diagnosis,
            'followup_by_ns_person_no_fk' =>Auth::user()->user_no_pk,
            'followup_by_doc_person_no_fk' => $request->doctor_id,
            'status' => 1
        ];
        $data['au_entry_by'] = Auth::user()->user_no_pk;
        $data['au_entry_at'] = date('Y-m-d h:i:s');
        $data['au_entry_session'] = 'IPD Daily Followup';
        $data['dfollowupmst_no_pk'] = $dfollowupmst_no_pk_seq;

        $data['au_entry_hospital_no_fk'] = Session::get('user.ses_hospital_no_pk');

        DB::table('ipd_dailyfollowup_ds_ns_mst')->insert($data);

        DB::commit();
        $sequence = DB::getSequence();
        $dfollowupchd_no_pk_seq = $sequence->nextValue('dfollowupchd_no_pk_seq');

        $data1 = [
            'dfollowupchd_time' => date('Y-m-d h:i:s'),
            'dfollowupmst_no_fk' =>  $dfollowupmst_no_pk_seq,
            'symptom_lookupdata_no_fk' => $request->hdn_item_id,
            'symptom_text' => empty($request->hdn_item_name) ? $request->symptom_lookupdata_no_fk : $request->hdn_item_name,
            'symptom_severity_text' => $request->symptom_severity_text,
            'status' => 1,
        ];
        $data1['au_entry_by'] = Auth::user()->user_no_pk;
        $data1['au_entry_at'] = date('Y-m-d h:i:s');
        $data1['au_entry_session'] = 'IPD Daily Followup';
        $data1['dfollowupchd_no_pk'] = $dfollowupchd_no_pk_seq;

        $data1['au_entry_hospital_no_fk'] = Session::get('user.ses_hospital_no_pk');

        DB::table('ipd_dailyfollowup_ds_ns_chd')->insert($data1);

        DB::commit();

        $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success',];

        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function followList()
    {

        $followup_list =  DB::table('ipd_daily_followup_worklist')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('dfollowupmst_date', date('Y-m-d'))
            ->get();

        return Template::loadView("admin.ipd.nurse_station.followup_worklist", ['followup_list' => $followup_list]);
    }
    public function followListSearch(Request $request)
    {
        $query =  DB::table('ipd_daily_followup_worklist')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));
        if (isset($request->admission_no_fk)) {
            $query =  DB::table('ipd_daily_followup_worklist')
                ->where('admission_no_fk', '=', $request->admission_no_fk);
        }
        if (isset($request->date_from)) {
            $query->where('dfollowupmst_date', '>=', date('Y-m-d', strtotime($request->date_from)))
                ->where('dfollowupmst_date', '<=', date('Y-m-d', strtotime($request->date_to)));
        }
        $followup_list = $query->get();

        return Template::loadView("admin.ipd.nurse_station.followup_worklist_table", ['followup_list' => $followup_list]);
    }
}
