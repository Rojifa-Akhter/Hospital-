<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use DB;
use App\Traits\LookupData;
use Illuminate\Support\Facades\Auth;
use Session;

class IPDIntakeOutputController extends Controller
{
    use LookupData;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($patient_id, $admission_uid)
    {



        $patient_info = DB::table('pat_registration_wl_vw a')
            ->select("a.*", "b.admission_no_pk", "b.admission_uid", "b.admission_date", "b.ward_name", "b.bed_name", "b.bed_uid", "b.admitted_department")
            ->leftJoin('ipd_admitted_pat_nsrcv_wl_vw b', "a.patient_no_pk", "=", "b.patient_no_fk")
            ->where('a.patient_no_pk', $patient_id)
            ->where('b.admission_uid', $admission_uid)
            ->first();

        $duration_mu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");
        $communicated_by = $this->getLookupListByCode("IPDPSNMEDIA");
        $instructions = $this->getPresLookupListByCode("INSTRUCTION", "pres_lookupdata_name");
        $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_code");
        $route = $this->getPresLookupListByCode("ROUTE", "pres_lookupdata_name");

        $input_output =  DB::table('ipd_intakeoutput')->where('admission_no_fk', $admission_uid)->where('patient_no_fk', $patient_id)->get();

        Session(['current_route' => url()->current()]);
        //dd($patient_info1);
        //dd($request->all());
        //

        return Template::loadview("admin.ipd.intake_output.intake_input_form", ['input_output' => $input_output, 'patient_info' => $patient_info, 'test' => 'this', 'duration_mu' => $duration_mu, 'communicated_by' => $communicated_by, 'instructions' => $instructions, 'dose' => $dose, 'meddurmu' => $meddurmu, 'route' => $route]);
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
        if (isset($request->inoutchart_no_pk)) {
            $data = [
                'output_urine' => $request->output_urine,
                'output_vomitius' => $request->output_vomitius,
                'output_stool_others' => $request->output_stool_others,
                'output_draintube' => $request->output_draintube,
                'output_urine_uom' => $request->output_urine_uom,
                'output_vomitius_uom' => $request->output_vomitius_uom,
                'output_stool_others_uom' => $request->output_stool_others_uom,
                'output_draintube_uom' => $request->output_draintube_uom,
                'sunction' => $request->suction,
                // 'suction_uom' => $request->suction_uom,
                'dropprer' => $request->dropper,
                // 'dropper_uom' => $request->dropper_uom
            ];
            $data['au_update_by'] = Auth::user()->user_no_pk;
            $data['au_update_at'] = date('Y-m-d h:i:s');
            DB::table('ipd_intakeoutput')->where('inoutchart_no_pk', $request->inoutchart_no_pk)->update($data);
            $message = ['msg' => 'Data Updated Successfully', 'title' => 'Success',];
        } else {
            $sequence = DB::getSequence();
            $inoutchart_no_pk_seq = $sequence->nextValue('inoutchart_no_pk_seq');
            $data = [
                'patient_no_fk' => $request->hdn_patient_no_fk,
                'admission_no_fk' => $request->hdn_admission_no_pk,
                'intake_iv' => $request->intake_iv,
                'intake_iv_amount' => $request->intake_iv_amount,
                'intake_oral_others' => $request->intake_oral_others,
                'intake_oral_others_amount' => $request->intake_oral_others_amount,
                'intake_oral_others_amount_uom' => $request->intake_oral_others_amount_uom,
                'intake_iv_amount_uom' => $request->intake_iv_amount_uom,
                'fluid_rate1' => $request->fluid_rate1,
                'fluid_rate2' => $request->fluid_rate2,
                'fluid_rate3' => $request->fluid_rate3,
                'status' => 1
            ];
            $data['au_entry_by'] = Auth::user()->user_no_pk;
            $data['au_entry_at'] = date('Y-m-d h:i:s');
            $data['au_entry_session'] = 'Intake Output';
            $data['inoutchart_no_pk'] =  $inoutchart_no_pk_seq;
            $data['au_entry_hospital_no_fk'] = Session::get('user.ses_hospital_no_pk');
            DB::table('ipd_intakeoutput')->insert($data);
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success',];
        }
        return response()->json($message);
    }

    public function ipdIntakeOutputPopUp($admission_no, $patient_no, $inoutchart_no_pk)
    {

        $medication_no_pk = DB::table("ipd_intakeoutput")->where('inoutchart_no_pk', $inoutchart_no_pk)->first();
        return Template::loadView("admin.ipd.intake_output.output_popup", ['prescribed_med_adm_no_pk' => $medication_no_pk, 'patient_no' => $patient_no, 'admission_no' => $admission_no]);
    }

    public function ipdSupportingForm($patient_id, $admission_uid)
    {
        $patient_info = DB::table('pat_registration_wl_vw a')
            ->select("a.*", "b.admission_no_pk", "b.admission_uid", "b.admission_date", "b.ward_name", "b.bed_name", "b.bed_uid", "b.admitted_department")
            ->leftJoin('ipd_admitted_pat_nsrcv_wl_vw b', "a.patient_no_pk", "=", "b.patient_no_fk")
            ->where('a.patient_no_pk', $patient_id)
            ->where('b.admission_uid', $admission_uid)
            ->first();

        $duration_mu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");
        $communicated_by = $this->getLookupListByCode("IPDPSNMEDIA");
        $instructions = $this->getPresLookupListByCode("INSTRUCTION", "pres_lookupdata_name");
        $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_code");
        $route = $this->getPresLookupListByCode("ROUTE", "pres_lookupdata_name");
        $instrument_data = $this->getLookupListByCode("INSTRUMENT");
        // dd($instrument_data);

        $supporting_data =  DB::table('ipd_support_chart')->select('ipd_support_chart.*', 'wsec_user.user_fullname', 'sysc_lookupdata.lookupdata_name')->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'ipd_support_chart.au_entry_by')->leftJoin('sysc_lookupdata', 'sysc_lookupdata.lookupdata_no_pk', '=', 'ipd_support_chart.instrument_no_fk')->where('ipd_support_chart.admission_no_fk', $admission_uid)->where('ipd_support_chart.patient_no_fk', $patient_id)->get();


        Session(['current_route' => url()->current()]);

        return Template::loadview("admin.ipd.supporting.supporting_form", ['supporting_data' => $supporting_data, 'patient_info' => $patient_info, 'test' => 'this', 'duration_mu' => $duration_mu, 'communicated_by' => $communicated_by, 'instructions' => $instructions, 'dose' => $dose, 'meddurmu' => $meddurmu, 'route' => $route, 'instrument_data'=>$instrument_data]);
    }

    public function ipdSupprotingStore(Request $request)
    {

        if(isset($request->chart_no_pk)){
            $data = [
                'instrument_no_fk' => (int)$request->instrument_id,
                // 'instrument_status' => $request->instrument_status,
                'start_time' => $request->start_supporting_time,
                'end_time' => $request->end_supporting_time,
                // 'breastfeeding_time' => $request->breastfeeding_time,
                'status' => 1
            ];
            $data['au_update_by'] = Auth::user()->user_no_pk;
            $data['au_update_at'] = date('Y-m-d h:i:s');
            DB::table('ipd_support_chart')->where('chart_no_pk', $request->chart_no_pk)->update($data);
            $message = ['msg' => 'Data Updated Successfully', 'title' => 'Success',];
        }else{
            $data = [
                'patient_no_fk' => $request->hdn_patient_no_fk,
                'admission_no_fk' => $request->hdn_admission_no_pk,
                'instrument_no_fk' => (int)$request->instrument_id,
                // 'instrument_status' => $request->instrument_status,
                'start_time' => $request->start_supporting_time,
                'end_time' => $request->end_supporting_time,
                // 'breastfeeding_time' => $request->breastfeeding_time,
                'status' => 1
            ];
            $sequence = DB::getSequence();
            $chart_NO_PK_SEQ = $sequence->nextValue('chart_NO_PK_SEQ');
            $data['au_entry_by'] = Auth::user()->user_no_pk;
            $data['au_entry_at'] = date('Y-m-d h:i:s');
            $data['au_entry_session'] = 'Supporting';
            $data['chart_no_pk'] =  $chart_NO_PK_SEQ;
            $data['au_entry_hospital_no_fk'] = Session::get('user.ses_hospital_no_pk');
            DB::table('ipd_support_chart')->insert($data);
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success',];
        }

        return response()->json($message);
    }

    public function ipdSupportingPopUp($admission_no, $patient_no, $chart_no_pk)
    {
        $support_data = DB::table("ipd_support_chart")->where('chart_no_pk', $chart_no_pk)->first();
        $instrument_data = $this->getLookupListByCode("INSTRUMENT");
        return Template::loadView("admin.ipd.supporting.supporting_popup", ['support_data' => $support_data, 'patient_no' => $patient_no, 'admission_no' => $admission_no, 'instrument_data' => $instrument_data]);
    }

    public function breastFeedingForm($patient_id, $admission_uid)
    {
        $patient_info = DB::table('pat_registration_wl_vw a')
            ->select("a.*", "b.admission_no_pk", "b.admission_uid", "b.admission_date", "b.ward_name", "b.bed_name", "b.bed_uid", "b.admitted_department")
            ->leftJoin('ipd_admitted_pat_nsrcv_wl_vw b', "a.patient_no_pk", "=", "b.patient_no_fk")
            ->where('a.patient_no_pk', $patient_id)
            ->where('b.admission_uid', $admission_uid)
            ->first();

        $duration_mu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");
        $communicated_by = $this->getLookupListByCode("IPDPSNMEDIA");
        $instructions = $this->getPresLookupListByCode("INSTRUCTION", "pres_lookupdata_name");
        $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_code");
        $route = $this->getPresLookupListByCode("ROUTE", "pres_lookupdata_name");

        $ipd_feeding_data =  DB::table('ipd_breastfeeding_chart feed')->select('feed.*', 'personnel.full_name', 'wsec_user.user_fullname')->leftJoin('hrms_personnel personnel', 'personnel.person_no_pk', '=', 'feed.supervise_no_fk')
        ->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'feed.au_entry_by')
        ->get();

        Session(['current_route' => url()->current()]);
        //dd($patient_info1);
        //dd($request->all());
        //

        return Template::loadview("admin.ipd.breast_feeding.breast_feeding_form", ['ipd_feeding_data' => $ipd_feeding_data, 'patient_info' => $patient_info, 'test' => 'this', 'duration_mu' => $duration_mu, 'communicated_by' => $communicated_by, 'instructions' => $instructions, 'dose' => $dose, 'meddurmu' => $meddurmu, 'route' => $route]);
    }

    public function breastFeedingStore(Request $request)
    {
        $sequence = DB::getSequence();
        $breastfeeding_NO_PK_seq = $sequence->nextValue('breastfeeding_NO_PK_seq');
        $data = [
            'patient_no_fk' => $request->hdn_patient_no_fk,
            'admission_no_fk' => $request->hdn_admission_no_pk,
            'sucking' => $request->sucking,
            'milk_flow' => $request->milk_flow,
            'duration' => $request->feeding_duration,
            'remarks' => $request->remark,
            'supervise_no_fk' => $request->hdn_staff__id,
            'breastfeeding_date' => $request->breastfeeding_date,
            'breastfeeding_time' => $request->breastfeeding_time,
            'status' => 1
        ];
        $data['au_entry_by'] = Auth::user()->user_no_pk;
        $data['au_entry_at'] = date('Y-m-d h:i:s');
        $data['au_entry_session'] = 'Breast Feeding';
        $data['breastfeeding_no_pk'] =  $breastfeeding_NO_PK_seq;
        $data['au_entry_hospital_no_fk'] = Session::get('user.ses_hospital_no_pk');
        DB::table('ipd_breastfeeding_chart')->insert($data);
        $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success',];

        return response()->json($message);
    }

    public function cbgForm($patient_id, $admission_uid)
    {
        $patient_info = DB::table('pat_registration_wl_vw a')
            ->select("a.*", "b.admission_no_pk", "b.admission_uid", "b.admission_date", "b.ward_name", "b.bed_name", "b.bed_uid", "b.admitted_department")
            ->leftJoin('ipd_admitted_pat_nsrcv_wl_vw b', "a.patient_no_pk", "=", "b.patient_no_fk")
            ->where('a.patient_no_pk', $patient_id)
            ->where('b.admission_uid', $admission_uid)
            ->first();

        $duration_mu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name");
        $communicated_by = $this->getLookupListByCode("IPDPSNMEDIA");
        $instructions = $this->getPresLookupListByCode("INSTRUCTION", "pres_lookupdata_name");
        $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");
        $meddurmu = $this->getPresLookupListByCode("DURMU", "pres_lookupdata_code");
        $route = $this->getPresLookupListByCode("ROUTE", "pres_lookupdata_name");

        $cbg_data =  DB::table('ipd_cbg_chart')->select('ipd_cbg_chart.*', 'wsec_user.user_fullname')->leftJoin('wsec_user', 'wsec_user.user_no_pk', '=', 'ipd_cbg_chart.au_entry_by')->where('ipd_cbg_chart.admission_no_fk', $admission_uid)->where('ipd_cbg_chart.patient_no_fk', $patient_id)->get();

        Session(['current_route' => url()->current()]);
        //dd($patient_info1);
        //dd($request->all());
        //

        return Template::loadview("admin.ipd.cbg.cbg_form", ['cbg_data' => $cbg_data, 'patient_info' => $patient_info, 'test' => 'this', 'duration_mu' => $duration_mu, 'communicated_by' => $communicated_by, 'instructions' => $instructions, 'dose' => $dose, 'meddurmu' => $meddurmu, 'route' => $route]);
    }

    public function cbgFormStore(Request $request)
    {
    //    dd($request->cbg_date);
        $sequence = DB::getSequence();
        $cbgchart_no_pk = $sequence->nextValue('cbgchart_no_pk_seq');
        $data = [
            'patient_no_fk' => $request->hdn_patient_no_fk,
            'admission_no_fk' => $request->hdn_admission_no_pk,
            'cbg' => $request->cbg,
            'cbg_hourly' => $request->cbg_hourly,
            'remarks' => $request->comments,
            'cbg_date' => $request->cbg_date,
            'cbg_time' => $request->cbg_time,
            'status' => 1
        ];
        $data['au_entry_by'] = Auth::user()->user_no_pk;
        $data['au_entry_at'] = date('Y-m-d h:i:s');
        $data['au_entry_session'] = 'CBG';
        $data['cbgchart_no_pk'] =  $cbgchart_no_pk;
        $data['au_entry_hospital_no_fk'] = Session::get('user.ses_hospital_no_pk');
        DB::table('ipd_cbg_chart')->insert($data);
        $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success',];

        return response()->json($message);
    }
}
