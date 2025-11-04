<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Datatables\DataTableClass;
use App\Traits\DatatablesLoader;
use Illuminate\Http\Request;
use App\Library\Template;
// use Illuminate\Support\Facades\Auth;
use App\Models\HrmsSchedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Traits\LookupData;
use Illuminate\Support\Facades\Session;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use App\Http\Resources\PatientResource;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use Cache;
use PDF;
use PDO;
use Auth;
use App\Helpers\ExcelHelper;
use App;

class OTController extends Controller
{
    use DatatablesLoader, LookupData;
    public function otRequisition()
    {

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        // dd(DB::table('opt_ot_reqlist_wl_vw')
        // ->select('opt_ot_reqlist_wl_vw.*', 'ipd_admitted_patlist_vw.new_serivce_unit_name')
        // ->leftJoin('ipd_admitted_patlist_vw', 'ipd_admitted_patlist_vw.admission_no_pk', '=', 'opt_ot_reqlist_wl_vw.admission_no_fk')
        // ->where('ot_comfirmation_ind', 0)->whereNull('reject_ind')
        // ->where('au_entry_hospital_no_fk',   $ses_hospital_id)
        // ->wherenotnull('opt_ot_reqlist_wl_vw.admission_uid')
        // //->where(DB::raw("trunc(ot_req_date)"),date("Y-m-d"))
        // ->where(DB::raw("trunc(ot_req_date)"), '>=', date('Y-m-d'))
        // ->orderBy('ot_req_date', 'DESC')
        // ->orderBy('opt_ot_reqlist_wl_vw.admission_no_fk', 'DESC')
        // ->get());
        return Template::loadview("admin.ot.ot_requisition", [
            'ot_requisition_wl' =>
            DB::table('opt_ot_reqlist_wl_vw')
                ->select('opt_ot_reqlist_wl_vw.*', 'ipd_admitted_patlist_vw.new_serivce_unit_name', 'ipd_admitted_patlist_vw.gender_txt')
                ->leftJoin('ipd_admitted_patlist_vw', 'ipd_admitted_patlist_vw.admission_no_pk', '=', 'opt_ot_reqlist_wl_vw.admission_no_fk')
                ->where('ot_comfirmation_ind', 0)->whereNull('reject_ind')
                ->where('au_entry_hospital_no_fk', $ses_hospital_id)
                ->wherenotnull('opt_ot_reqlist_wl_vw.admission_uid')
                //->where(DB::raw("trunc(ot_req_date)"),date("Y-m-d"))
                ->where(DB::raw("trunc(ot_req_date)"), '>=', date('Y-m-d'))
                ->orderBy('ot_req_date', 'DESC')
                ->orderBy('opt_ot_reqlist_wl_vw.admission_no_fk', 'DESC')
                ->get()
                ->toArray(),
        ]);
    }

    public function searchOTRequisition(Request $request)
    {
        //        dd($request->all());
        $query = DB::table('opt_ot_reqlist_wl_vw')->where('ot_comfirmation_ind', 0)->whereNull('reject_ind')
            ->select('opt_ot_reqlist_wl_vw.*', 'ipd_admitted_patlist_vw.new_serivce_unit_name', 'ipd_admitted_patlist_vw.gender_txt')
            ->leftJoin('ipd_admitted_patlist_vw', 'ipd_admitted_patlist_vw.admission_no_pk', '=', 'opt_ot_reqlist_wl_vw.admission_no_fk');
        if (!empty($request->service_id)) {
            $query = $query->where('prescription_no_fk', $request->hdn_presc_id);
        }
        if (!empty($request->hdn_admission_id)) {
            $query = $query->where('opt_ot_reqlist_wl_vw.admission_uid', $request->hdn_admission_id);
        }
        if (!empty($request->ot_req_date_from) && !empty($request->ot_req_date_to)) {
            $query->where(DB::raw("trunc(ot_req_date)"), '>=', date('Y-m-d', strtotime($request->ot_req_date_from)));
            $query->where(DB::raw("trunc(ot_req_date)"), '<=', date('Y-m-d', strtotime($request->ot_req_date_to)));
        } elseif (!empty($request->ot_req_date_from)) {
            $query->where(DB::raw("trunc(ot_req_date)"), '=', date('Y-m-d', strtotime($request->ot_req_date_from)));
        } elseif (!empty($request->ot_req_date_to)) {
            $query->where(DB::raw("trunc(ot_req_date)"), '=', date('Y-m-d', strtotime($request->ot_req_date_to)));
        }
        return Template::loadview("admin.ot.search_ot_requisition", [
            'ot_requisition_wl' => $query
                ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                ->orderBy('ot_req_date', 'DESC')
                ->orderBy('opt_ot_reqlist_wl_vw.admission_no_fk', 'DESC')
                ->get()->toArray(),
        ]);
    }
    public function searchOTRequisitionPrint(Request $request)
    {
        $query = DB::table('opt_ot_reqlist_wl_vw')
            ->where('ot_comfirmation_ind', 0)
            ->whereNull('reject_ind')
            ->select('opt_ot_reqlist_wl_vw.*', 'ipd_admitted_patlist_vw.new_serivce_unit_name')
            ->leftJoin('ipd_admitted_patlist_vw', 'ipd_admitted_patlist_vw.admission_no_pk', '=', 'opt_ot_reqlist_wl_vw.admission_no_fk');

        if (!empty($request->service_id)) {
            $query->where('prescription_no_fk', $request->hdn_presc_id);
        }
        if (!empty($request->hdn_admission_id)) {
            $query->where('opt_ot_reqlist_wl_vw.admission_uid', $request->hdn_admission_id);
        }
        if (!empty($request->ot_req_date_from) && !empty($request->ot_req_date_to)) {
            $query->where(DB::raw("trunc(ot_req_date)"), '>=', date('Y-m-d', strtotime($request->ot_req_date_from)));
            $query->where(DB::raw("trunc(ot_req_date)"), '<=', date('Y-m-d', strtotime($request->ot_req_date_to)));
        } elseif (!empty($request->ot_req_date_from)) {
            $query->where(DB::raw("trunc(ot_req_date)"), '=', date('Y-m-d', strtotime($request->ot_req_date_from)));
        } elseif (!empty($request->ot_req_date_to)) {
            $query->where(DB::raw("trunc(ot_req_date)"), '=', date('Y-m-d', strtotime($request->ot_req_date_to)));
        }

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        // Barcode generation
        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $ot_requisition_wl = $query->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->orderBy('ot_req_date', 'DESC')
            ->orderBy('opt_ot_reqlist_wl_vw.admission_no_fk', 'DESC')
            ->get()->toArray();

        return view("admin.ot.ot_requisition_print", [
            'barcode_no' => $barcode_no,
            'ot_requisition_wl' => $ot_requisition_wl,
            'from_date' => $request->ot_req_date_from,
            'to_date' => $request->ot_req_date_to,
            'po_hospital_details' => $po_hospital_details
        ]);
    }


    public function storeOTConfirmationPopUp(Request $request)
    {
        // dd($request->all());
        $rules = array(
            'hidden_ot_req_no_pk' => 'required',
            // 'anest_name' => 'required',
            // 'surgeon_name' => 'required',
            // 'clearance_date' => 'required',
            // 'ot_date' => 'required',
            // 'ot_confirm' => 'required',
            // 'ot_anest_clearance_ind' => 'required',
        );
        $validator = Validator::make($request->all(), $rules)->validate();

        DB::beginTransaction();
        // try {
        $result = DB::table('opt_prescribed_ot')
            ->where('ot_req_no_pk', $request->hidden_ot_req_no_pk)
            ->update([
                'anest_doc_person_no_fk' => $request->anest_name,
                'surg_doc_person_no_fk' => $request->surgeon_name,
                'ot_date' => date('Y-m-d H:i', strtotime($request->ot_date)),
                'ot_comfirmation_ind' => 2,
                'ot_comfirmation_time' => date("Y-m-d H:i"),
                'ot_time' => $request->ot_time != "" ? date('Y-m-d h:i', strtotime($request->ot_time)) : '',
                'surgeons_remark' => $request->surgeon_remarks,
                'diagnosis' => $request->diagnosis,
                'ot_comfirmation_doc_by' => Auth::id(),
                'admission_no_fk' => $request->hdn_admission_id,
                'anest_clearance_ind' => $request->ot_anest_clearance_ind,
                'anest_clearance_time' => date('Y-m-d', strtotime($request->clearance_date)),
                'anest_clearance_doc_by' => Auth::id(),
                'au_update_by' => Auth::id(),
                'au_update_at' => date('Y-m-d'),
                'au_update_session' => "SESSION",
                "au_update_hospital_no_fk" => Session::get('user.ses_hospital_no_pk'),

                'bill_clearence_ind' => $request->bill_clearence,
                'bill_clearence_at' =>  date("Y-m-d H:i"),
                'bill_clearence_by' => Auth::id(),

                'pac_clearence_ind' => $request->pac_clearence,
                'pac_clearence_at' =>  date("Y-m-d H:i"),
                'pac_clearence_by' => Auth::id(),
            ]);
        DB::commit();
        $this->message = ['msg' => 'OT Confirmation  Successful.', 'title' => 'Success',];
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        // }
        return response()->json($this->message);
    }

    public function storeOTRejectionPopUp(Request $request)
    {
        //dd($request->all());
        Validator::make($request->all(), [
            'hidden_ot_req_no_pk' => 'required',
            'rejected_by' => 'required',
            'reject_note' => 'required',
        ])
            ->validate();

        DB::beginTransaction();
        try {
            $result = DB::table('opt_prescribed_ot')
                ->where('ot_req_no_pk', $request->hidden_ot_req_no_pk)
                ->update([
                    'reject_time' => date('Y-m-d'),
                    'reject_by' => $request->rejected_by,
                    'reject_note' => $request->reject_note,
                    'reject_ind' => 1,
                    'au_update_by' => Auth::id(),
                    'au_update_at' => date('Y-m-d'),
                    'au_update_session' => "SESSION",
                    "au_update_hospital_no_fk" => Session::get('user.ses_hospital_no_pk'),
                ]);
            DB::commit();
            $this->message = ['msg' => 'Data Rejected Successfully', 'title' => 'Success',];
        } catch (\Exception $e) {
            DB::rollback();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($this->message);
    }

    public function otConfirmationPopUp($ot_req_no_pk, $admission_id)
    {
        $slot_details = DB::table('OT_SCHEDULE_SLOT')->select('START_TIME', 'END_TIME', 'SCHEDULE_DT')->where('OT_REQ_NO_FK', $ot_req_no_pk)->first();

        return Template::loadview("admin.ot.ot_confirmation_popUp", [
            'anesthesiologists' => DB::table('hrms_personnel')->where('anaestesiologis_ind', 1)->get(['person_no_pk', 'full_name'])->toArray(),
            'surgeons' => DB::table('hrms_personnel')->where('surgeon_ind', 1)->get(['person_no_pk', 'full_name'])->toArray(),
            'selected_surgen' => DB::table('opt_prescribed_ot ot')->select('per.person_no_pk', 'per.full_name')->leftjoin('hrms_personnel per', 'ot.doc_person_no_fk', 'per.person_no_pk')->where('ot.ot_req_no_pk', $ot_req_no_pk)->first(),
            'selected_anes' => DB::table('opt_prescribed_ot ot')->select('per.person_no_pk', 'per.full_name', 'anest_clearance_time', 'anest_clearance_ind', 'bill_clearence_ind', 'pac_clearence_ind', 'diagnosis', 'surgeons_remark')->leftjoin('hrms_personnel per', 'ot.anest_doc_person_no_fk', 'per.person_no_pk')->where('ot.ot_req_no_pk', $ot_req_no_pk)->first(),
            'ot_req_no_pk' => $ot_req_no_pk,
            'slot_details' => $slot_details,
            'admission_id' => $admission_id,
        ]);
    }

    public function otRejectionPopUp($ot_req_no_pk)
    {
        return Template::loadview("admin.ot.ot_rejection_popUp", [
            'reject_by' => DB::table("hrms_personnel")->select('person_no_pk', 'full_name')->where('doctor_ind', 1)->get()->toArray(),
            'ot_req_no_pk' => $ot_req_no_pk,
        ]);
    }
    public function operationStatus()
    {


        return Template::loadview("admin.ot.operation_status", [
            'operation_status_list' => DB::table('opt_ot_reqlist_wl_vw a')
                ->select("a.patient_name", "a.ot_comfirmation_ind", "a.ot_req_no_pk", "a.service_number", "a.ot_req_uid", "a.admission_uid", "a.ipd_department_name", "a.ward_name", "a.age", "a.item_name", "a.confession_note_ind", "a.anest_clearance_time", "a.anest_clearance_ind", "a.ot_in_ind", "a.ot_out_ind", "a.obs_ind", "a.return_ipd_ind", "b.ot_req_date", "ot_complete_status.anesth_record", "ot_complete_status.op_note", "ot_complete_status.pre_anes_chkup_frm", "ot_complete_status.pre_oper_chklist", "ot_complete_status.high_risk_consent", "ot_complete_status.ot_complete_ind", "ipd_admitted_patlist_vw.new_serivce_unit_name", "a.admission_no_fk", "a.patient_no_fk")
                ->leftjoin('opt_prescribed_ot b', "a.ot_req_no_pk", "=", "b.ot_req_no_pk")
                ->leftJoin('ot_complete_status', 'ot_complete_status.admission_no_fk', '=', 'a.admission_no_fk')
                ->leftJoin('ipd_admitted_patlist_vw', 'ipd_admitted_patlist_vw.admission_no_pk', '=', 'a.admission_no_fk')
                ->whereIn('a.ot_comfirmation_ind', [1, 2])
                ->where('a.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                ->orderBy('a.ot_req_date', 'DESC')
                ->orderBy('a.admission_no_fk', 'DESC')
                ->get()->toArray(),
        ]);
    }
    public function searchOperationStatus(Request $request)
    {
        //dd($request->all());
        $query = DB::table('opt_ot_reqlist_wl_vw a')
            ->select("a.patient_name", "a.service_number", "a.ot_req_uid", "a.admission_uid", "a.ipd_department_name", "a.ward_name", "a.age", "a.item_name", "a.confession_note_ind", "a.anest_clearance_time", "a.anest_clearance_ind", "a.ot_in_ind", "a.ot_out_ind", "a.obs_ind", "a.return_ipd_ind", "b.ot_req_date", "ipd_admitted_patlist_vw.new_serivce_unit_name", "a.admission_no_fk", "a.patient_no_fk")
            ->leftJoin('opt_prescribed_ot b', "a.ot_req_no_pk", "=", "b.ot_req_no_pk")->where('a.ot_comfirmation_ind', 1)
            ->leftJoin('ipd_admitted_patlist_vw', 'ipd_admitted_patlist_vw.admission_no_pk', '=', 'a.admission_no_fk');

        if (!empty($request->hdn_presc_id)) {
            $query = $query->where('a.prescription_no_fk', $request->hdn_presc_id);
        }
        if (!empty($request->hdn_admission_id)) {
            $query = $query->where('a.admission_no_fk', $request->hdn_admission_id);
        }

        return Template::loadview("admin.ot.search_operation_status", [
            'operation_status_list' => $query
                ->where('a.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                ->get()->toArray(),
        ]);
    }

    public function otRejected()
    {
        return Template::loadview("admin.ot.ot_rejected", [
            'ot_rejection_list' => DB::table('opt_ot_reqlist_wl_vw')
                ->select("patient_name", "service_number", "admission_uid", "ward_name", "age", "ot_req_date", "item_name", "reject_time", "reject_by", "reject_note")
                ->where('reject_ind', 1)
                ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                ->orderBy('ot_req_date', 'DESC')
                ->orderBy('admission_no_fk', 'DESC')
                ->get()->toArray(),
        ]);
    }
    public function searchOTRejected(Request $request)
    {
        //dd($request->all());
        $query = DB::table('opt_ot_reqlist_wl_vw')
            ->select("patient_name", "service_number", "admission_uid", "ward_name", "age", "ot_req_date", "item_name", "reject_time", "reject_by", "reject_note")
            ->where('reject_ind', 1);
        if (!empty($request->hdn_presc_id)) {
            $query = $query->where('prescription_no_fk', $request->hdn_presc_id);
        }
        if (!empty($request->hdn_admission_id)) {
            $query = $query->where('admission_no_fk', $request->hdn_admission_id);
        }
        if (!empty($request->ot_req_date_from) && !empty($request->ot_req_date_to)) {
            $query->where(DB::raw("trunc(ot_req_date)"), '>=', date('Y-m-d', strtotime($request->ot_req_date_from)));
            $query->where(DB::raw("trunc(ot_req_date)"), '<=', date('Y-m-d', strtotime($request->ot_req_date_to)));
        } elseif (!empty($request->ot_req_date_from)) {
            $query->where(DB::raw("trunc(ot_req_date)"), '=', date('Y-m-d', strtotime($request->ot_req_date_from)));
        } elseif (!empty($request->ot_req_date_to)) {
            $query->where(DB::raw("trunc(ot_req_date)"), '=', date('Y-m-d', strtotime($request->ot_req_date_to)));
        }

        return Template::loadview("admin.ot.search_ot_rejected", [
            'ot_rejection_list' => $query
                ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                ->orderBy('ot_req_date', 'DESC')
                ->orderBy('admission_no_fk', 'DESC')
                ->get()->toArray(),
        ]);
    }

    public function otExecution()
    {
        // dd( DB::table('opt_ot_confirmlist_wl_vw')
        // ->select("opt_ot_confirmlist_wl_vw.patient_name", "opt_ot_confirmlist_wl_vw.service_number", "opt_ot_confirmlist_wl_vw.admission_uid", "opt_ot_confirmlist_wl_vw.ot_req_no_pk", "opt_ot_confirmlist_wl_vw.ot_room_uid", "opt_ot_confirmlist_wl_vw.ward_name", "opt_ot_confirmlist_wl_vw.bed_name", "opt_ot_confirmlist_wl_vw.age", "opt_ot_confirmlist_wl_vw.surg_doctor_name", "opt_ot_confirmlist_wl_vw.ot_date", "opt_ot_confirmlist_wl_vw.item_name", "opt_ot_confirmlist_wl_vw.ot_req_uid", 'opt_ot_confirmlist_wl_vw.ot_note_ind', 'opt_ot_confirmlist_wl_vw.anest_note_ind', 'ot_complete_status.anesth_record', 'ot_complete_status.op_note', 'ot_complete_status.pre_anes_chkup_frm', 'ot_complete_status.pre_oper_chklist', 'ot_complete_status.high_risk_consent', 'ot_complete_status.ot_complete_ind', 'ot_complete_status.ot_rending_ind')
        // ->leftJoin('ot_complete_status','ot_complete_status.admission_no_fk','=','opt_ot_confirmlist_wl_vw.admission_no_fk')
        // ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
        // ->orderBy('ot_date', 'DESC')
        // ->orderBy('admission_uid', 'DESC')
        // ->get()->toArray());

        return Template::loadview("admin.ot.ot_execution", [
            'ot_confirmlist' => DB::table('opt_ot_confirmlist_wl_vw')
                ->select("opt_ot_confirmlist_wl_vw.patient_name", "opt_ot_confirmlist_wl_vw.patient_no_fk", "opt_ot_confirmlist_wl_vw.ot_prepered_by", "opt_ot_confirmlist_wl_vw.service_number", "opt_ot_confirmlist_wl_vw.admission_uid", "opt_ot_confirmlist_wl_vw.ot_req_no_pk", "opt_ot_confirmlist_wl_vw.ot_room_uid", "opt_ot_confirmlist_wl_vw.ward_name", "opt_ot_confirmlist_wl_vw.bed_name", "opt_ot_confirmlist_wl_vw.age", "opt_ot_confirmlist_wl_vw.surg_doctor_name", "opt_ot_confirmlist_wl_vw.ot_date", "opt_ot_confirmlist_wl_vw.item_name", "opt_ot_confirmlist_wl_vw.ot_req_uid", 'opt_ot_confirmlist_wl_vw.ot_note_ind', 'opt_ot_confirmlist_wl_vw.anest_note_ind', 'ot_complete_status.anesth_record', 'ot_complete_status.op_note', 'ot_complete_status.pre_anes_chkup_frm', 'ot_complete_status.pre_oper_chklist', 'ot_complete_status.high_risk_consent', 'ot_complete_status.ot_complete_ind', 'ot_complete_status.ot_rending_ind', 'opt_ot_confirmlist_wl_vw.ot_comfirmation_time', 'opt_ot_confirmlist_wl_vw.item_no_fk')
                ->leftJoin('ot_complete_status', 'ot_complete_status.admission_no_fk', '=', 'opt_ot_confirmlist_wl_vw.admission_no_fk')
                ->leftJoin('opt_prescribed_ot', 'opt_prescribed_ot.admission_no_fk', '=', 'opt_ot_confirmlist_wl_vw.admission_no_fk')
                ->where('opt_prescribed_ot.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                ->where('opt_prescribed_ot.anest_clearance_ind', 1)
                ->where('opt_prescribed_ot.ot_comfirmation_ind', 1)
                ->orderby('ot_date', 'desc')
                ->orderby('opt_prescribed_ot.admission_uid', 'desc')
                ->get()->toArray(),
        ]);
    }
    public function searchOTExecution(Request $request)
    {
        // dd($request->all());
        $query = DB::table('opt_ot_confirmlist_wl_vw')
            ->select("opt_ot_confirmlist_wl_vw.patient_name", "opt_ot_confirmlist_wl_vw.patient_no_fk", "opt_ot_confirmlist_wl_vw.ot_prepered_by", "opt_ot_confirmlist_wl_vw.service_number", "opt_ot_confirmlist_wl_vw.admission_uid", "opt_ot_confirmlist_wl_vw.ot_req_no_pk", "opt_ot_confirmlist_wl_vw.ot_room_uid", "opt_ot_confirmlist_wl_vw.ward_name", "opt_ot_confirmlist_wl_vw.bed_name", "opt_ot_confirmlist_wl_vw.age", "opt_ot_confirmlist_wl_vw.surg_doctor_name", "opt_ot_confirmlist_wl_vw.ot_date", "opt_ot_confirmlist_wl_vw.item_name", "opt_ot_confirmlist_wl_vw.ot_req_uid", 'opt_ot_confirmlist_wl_vw.ot_note_ind', 'opt_ot_confirmlist_wl_vw.anest_note_ind', 'ot_complete_status.anesth_record', 'ot_complete_status.op_note', 'ot_complete_status.pre_anes_chkup_frm', 'ot_complete_status.pre_oper_chklist', 'ot_complete_status.high_risk_consent', 'ot_complete_status.ot_complete_ind', 'ot_complete_status.ot_rending_ind', 'opt_ot_confirmlist_wl_vw.ot_comfirmation_time')
            ->leftJoin('ot_complete_status', 'ot_complete_status.admission_no_fk', '=', 'opt_ot_confirmlist_wl_vw.admission_no_fk')
            ->leftJoin('opt_prescribed_ot', 'opt_prescribed_ot.admission_no_fk', '=', 'opt_ot_confirmlist_wl_vw.admission_no_fk');
        // DB::table('opt_ot_confirmlist_wl_vw')
        //     ->select("patient_name", "service_number", "admission_uid", "ot_req_no_pk", "ot_room_uid", "ward_name", "bed_name", "age", "surg_doctor_name", "ot_date", "item_name", 'ot_note_ind', 'anest_note_ind');

        if (!empty($request->hdn_presc_id)) {
            $query = $query->where('opt_ot_confirmlist_wl_vw.service_number', $request->hdn_presc_id);
        }
        if (!empty($request->hdn_admission_id)) {
            $query = $query->where('opt_ot_confirmlist_wl_vw.admission_uid', $request->hdn_admission_id);
        }
        if (!empty($request->ot_date_from) && !empty($request->ot_date_to)) {
            $query->where(DB::raw("trunc(opt_ot_confirmlist_wl_vw.ot_date)"), '>=', date('Y-m-d', strtotime($request->ot_date_from)));
            $query->where(DB::raw("trunc(opt_ot_confirmlist_wl_vw.ot_date)"), '<=', date('Y-m-d', strtotime($request->ot_date_to)));
        } elseif (!empty($request->ot_date_from)) {
            $query->where(DB::raw("trunc(opt_ot_confirmlist_wl_vw.ot_date)"), '=', date('Y-m-d', strtotime($request->ot_date_from)));
        } elseif (!empty($request->ot_date_to)) {
            $query->where(DB::raw("trunc(opt_ot_confirmlist_wl_vw.ot_date)"), '=', date('Y-m-d', strtotime($request->ot_date_to)));
        }

        return Template::loadview("admin.ot.search_ot_execution", [
            'ot_confirmlist' => $query->where('opt_prescribed_ot.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                ->where('opt_prescribed_ot.anest_clearance_ind', 1)
                ->where('opt_prescribed_ot.ot_comfirmation_ind', 1)
                ->orderby('ot_date', 'desc')
                ->orderby('opt_prescribed_ot.admission_uid', 'desc')
                ->get()->toArray()
        ]);
    }

    public function otNote($ot_req_no_pk)
    {
        $ot_patient_info = DB::table('pat_registration_wl_vw a')
            ->select(
                "a.patient_no_pk",
                "a.service_number",
                "mobile1",
                "a.patient_name",
                "a.patient_code",
                "a.patient_photo",
                "a.age",
                "a.gender_txt",
                "a.blood_group",
                "a.marital_status_txt",
                "b.admission_no_fk",
                "b.admission_uid",
                "b.ward_no_fk",
                "b.ward_name",
                "b.bed_name",
                "b.surg_doctor_name",
                "b.surg_doc_person_no_fk",
                "b.item_name",
                "b.pre_ot_note",
                "b.post_ot_note",
                "b.ot_note_doc_by",
                "b.actual_anest_name",
                "b.anest_doc_person_no_fk",
                "b.ot_room_uid",
                "b.ot_room_no_fk",
                "b.ot_date",
                "b.ot_in_time",
                "b.ot_out_time",
                'b.first_baby_birthdate',
                'b.first_baby_time',
                'b.first_baby_gender_no',
                'b.first_baby_wt',
                'b.first_baby_as',
                'b.second_baby_birthdate',
                'b.second_baby_time',
                'b.second_baby_gender_no',
                'b.second_baby_wt',
                'b.second_baby_as',
                'b.first_baby_note',
                'b.second_baby_note'
            )
            ->leftJoin("opt_ot_confirmlist_wl_vw b", "a.patient_no_pk", "=", "b.patient_no_fk")
            ->where('ot_req_no_pk', $ot_req_no_pk)
            ->where('b.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->get()->first();
        $gender = $this->getLookupListByCode("GENDER");

        return Template::loadview("admin.ot.ot_note", [
            'gender' => $gender,
            'ot_patient_info' => $ot_patient_info,
            'prepared_by' => Auth::user()->user_fullname,
            'prepared_by_id' => Auth::id(),
            'ot_req_no_pk' => $ot_req_no_pk,
            'anesthesiologists' => DB::table('hrms_personnel')->where('anaestesiologis_ind', 1)->get(['person_no_pk', 'full_name'])->toArray(),
            'surgeons' => DB::table('hrms_personnel')->where('surgeon_ind', 1)->get(['person_no_pk', 'full_name'])->toArray(),
            'ot_room_list' => DB::table('sysc_room')->where('ot_ind', 1)
                ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                ->get(['room_no_pk', 'room_code', 'room_name'])->toArray(),
        ]);
    }

    public function storeOtNote(Request $request)
    {
        //dd($request->all());
        $rules = array(
            'hidden_ot_req_no_pk' => 'required',
            'anest_name' => 'required',
            'surgeon_name' => 'required',
            'hidden_prepared_by_id' => 'required',
            'ot_room' => 'required',
            'ot_date' => 'required',
            'ot_time' => 'required',
            'in_ot_time' => 'required',
            'out_ot_time' => 'required',
        );
        $validator = Validator::make($request->all(), $rules)->validate();

        DB::beginTransaction();
        try {
            $result = DB::table('opt_prescribed_ot')
                ->where('ot_req_no_pk', $request->hidden_ot_req_no_pk)
                ->update([
                    'anest_doc_person_no_fk' => $request->anest_name,
                    'surg_doc_person_no_fk' => $request->surgeon_name,
                    'pre_ot_note' => $request->pre_ot_note,
                    'post_ot_note' => $request->post_ot_note,
                    'ot_note_doc_by' => $request->hidden_prepared_by_id,
                    'ot_note_ind' => 1,
                    'ot_note_time' => date('Y-m-d'),
                    'ot_room_no_fk' => $request->ot_room,
                    'ot_room_uid' => $request->ot_room_name,
                    'ot_date' => date('Y-m-d H:i:s', strtotime($request->ot_date . ' ' . $request->ot_time)),
                    'ot_in_time' => date('Y-m-d H:i:s', strtotime($request->in_ot_date . ' ' . $request->in_ot_time)),
                    'ot_out_time' => date('Y-m-d H:i:s', strtotime($request->out_ot_date . ' ' . $request->out_ot_time)),
                    //'item_no_fk' => $request->hidden_operation_id,
                    //'item_name' => $request->operation_name,
                    'au_update_by' => Auth::id(),
                    'au_update_at' => date('Y-m-d'),
                    'au_update_session' => "SESSION",
                    "au_update_hospital_no_fk" => Session::get('user.ses_hospital_no_pk'),



                    //                    baby Part
                    'first_baby_birthdate' => $request->first_baby_birth_date ? date('Y-m-d', strtotime($request->first_baby_birth_date)) : "",
                    'first_baby_time' => $request->first_baby_time ? date('Y-m-d H:i', strtotime($request->first_baby_time)) : "",
                    'first_baby_gender_no' => $request->first_baby_gender,
                    'first_baby_wt' => $request->first_baby_wt,
                    'first_baby_as' => $request->first_baby_as,
                    'second_baby_birthdate' => $request->second_baby_birth_date ? date('Y-m-d', strtotime($request->second_baby_birth_date)) : "",
                    'second_baby_time' => $request->second_baby_time ? date('Y-m-d H:i', strtotime($request->second_baby_time)) : "",
                    'second_baby_gender_no' => $request->second_baby_gender,
                    'second_baby_wt' => $request->second_baby_wt,
                    'second_baby_as' => $request->second_baby_as,
                    'first_baby_note' => $request->first_baby_note,
                    'second_baby_note' => $request->second_baby_note,

                    //                end baby part
                ]);
            DB::commit();
            $this->message = ['msg' => 'OT Note Saved Successfully.', 'title' => 'Success',];
        } catch (\Exception $e) {
            DB::rollback();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($this->message);
    }

    public function annestNote($ot_req_no_pk)
    {
        $ot_patient_info = DB::table('opt_ot_confirmlist_wl_vw')->select("actual_anest_name", "anest_doc_person_no_fk", "anest_note_by", "anest_note", "anest_note_time")->where('ot_req_no_pk', $ot_req_no_pk)
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->get()->first();
        return Template::loadview("admin.ot.annest_note", [
            'ot_patient_info' => $ot_patient_info,
            'ot_req_no_pk' => $ot_req_no_pk,
            'anesthesiologists' => DB::table('hrms_personnel')->where('anaestesiologis_ind', 1)->get(['person_no_pk', 'full_name'])->toArray(),

        ]);
    }
    public function storeAnnestNote(Request $request)
    {
        //dd($request->all());
        $rules = array(
            'hidden_ot_req_no_pk' => 'required',
            'anest_name' => 'required',
            'anest_note' => 'required',
            'annest_date' => 'required',
            'annest_time' => 'required',
        );
        $validator = Validator::make($request->all(), $rules)->validate();

        DB::beginTransaction();
        try {
            $result = DB::table('opt_prescribed_ot')
                ->where('ot_req_no_pk', $request->hidden_ot_req_no_pk)
                ->update([
                    'anest_doc_person_no_fk' => $request->anest_name,
                    'anest_note' => $request->anest_note,
                    'anest_note_ind' => 1,
                    'anest_note_time' => date('Y-m-d H:i:s', strtotime($request->annest_date . ' ' . $request->annest_time)),
                    'ot_note_doc_by' => Auth::id(),
                    'au_update_by' => Auth::id(),
                    'au_update_at' => date('Y-m-d'),
                    'au_update_session' => "SESSION",
                    "au_update_hospital_no_fk" => Session::get('user.ses_hospital_no_pk'),
                ]);
            DB::commit();
            $this->message = ['msg' => 'Anesthesiologist\'s Note Saved Successfully.', 'title' => 'Success',];
        } catch (\Exception $e) {
            DB::rollback();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($this->message);
    }

    //    for Ipd Working on Ot
    public function removeMedicine(Request $request)
    {
        // dd($request->all());
        try {
            DB::table('psn_t_prescription_med')
                ->where('prescription_med_no_pk', $request->med_data)
                ->update([
                    'continue_ind' => 0,
                    'au_update_at' => date('Y-m-d'),
                    'au_update_by' => Auth::id(),
                    'au_update_hospital_no_fk' => Session::get('user.ses_hospital_no_pk'),
                ]);
            $this->message = ['msg' => 'Medicine Updated Successfully', 'title' => 'Success',];
        } catch (\Exception $e) {
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        //return response()->json($this->message);
        $ipd_vitals = DB::table('psn_t_patvitals_ipd_vw')->where('patient_no_fk', $request->patient_data)->where('admission_no_fk', $request->admission_data)->orderBy('vital_date', 'desc')->get()->toArray();
        // $ipd_med_list = DB::table('psn_t_prescription_med_vw')->where('patient_no_fk', $request->patient_data)->where('admission_pk_no', $request->admission_data)->where('continue_ind', 1)->orderBy('au_entry_at', 'desc')->get()->toArray();

        $ipd_med_lists = DB::select("select DISTINCT psn_t_prescription_med_vw.prescription_med_no_pk, psn_t_prescription_med_vw.au_entry_at,psn_t_prescription_med_vw.item_name,psn_t_prescription_med_vw.dosage,psn_t_prescription_med_vw.duration,psn_t_prescription_med_vw.duration_mu,psn_t_prescription_med_vw.item_qty,psn_t_prescription_med_vw.uom_txt,psn_t_prescription_med_vw.instruction_take,psn_t_prescription_med_vw.ipd_instructed_doc_name,psn_t_prescription_med_vw.ipd_instruct_media_name,psn_t_prescription_med_vw.item_no_fk,psn_t_prescription_med_vw.uom_no_fk,psn_t_prescription_med_vw.admission_pk_no,psn_t_prescription_med_vw.patient_no_fk,((NVL(b.rece_qty,0) - NVL(c.teken_qty,0)) - NVL(b.ret_quantity,0) ) as current_qty , NVL(b.ret_quantity,0) as ret_quantity , NVL(b.req_quantity,0) as req_quantity
        from    psn_t_prescription_med_vw
            left join
              (select item_no_fk, admission_no_fk ,sum (phr_requisition_item_vw.recv_quantity) as rece_qty, sum (phr_requisition_item_vw.return_quantity) as ret_quantity, sum (phr_requisition_item_vw.req_quantity) as req_quantity from  phr_requisition_item_vw group by  item_no_fk, admission_no_fk) b
             on psn_t_prescription_med_vw.admission_pk_no = b.admission_no_fk and b.item_no_fk = psn_t_prescription_med_vw.item_no_fk
            left join
              (select item_pk_no, admission_no_fk ,sum (ipd_prescription_med_nsadm.item_qty) as teken_qty from  ipd_prescription_med_nsadm group by  item_pk_no, admission_no_fk) c on psn_t_prescription_med_vw.admission_pk_no = c.admission_no_fk and c.item_pk_no = psn_t_prescription_med_vw.item_no_fk

             where psn_t_prescription_med_vw.admission_pk_no = $request->admission_data  and psn_t_prescription_med_vw.continue_ind = 1");
        $ipd_med_list = [];
        foreach ($ipd_med_lists as $key => $value) {
            $ipd_med_list[$value->item_no_fk] = $value;
        }

        $ipd_discontinue_med_list = DB::table('psn_t_prescription_med_vw')->where('patient_no_fk', $request->patient_data)->where('admission_pk_no', $request->admission_data)->where('continue_ind', 0)->orderBy('au_entry_at', 'desc')->get()->toArray();
        $ipd_investigations = DB::table('psn_t_prescription_dtl_vw')->where('patient_no_fk', $request->patient_data)->where('admission_pk_no', $request->admission_data)->whereIn('LOOKUPDATA_UID', ['RAD', 'LAB'])->orderBy('au_entry_at', 'desc')->get()->toArray();
        // $ipd_ot_list = DB::table('opt_ot_confirmlist_wl_vw')->where('patient_no_fk', $request->patient_data)->where('admission_no_fk', $request->admission_data)->orderBy('ot_req_date', 'desc')->get()->toArray();
        $ipd_ot_list = DB::table('psn_t_prescription_dtl_vw')->where('patient_no_fk', $request->patient_data)->where('admission_pk_no', $request->admission_data)->where('LOOKUPDATA_UID', 'SUR')->orderBy('au_entry_at', 'desc')->get()->toArray();
        $ipd_diet_list = DB::table('psn_t_prescription_dtl_vw')->where('patient_no_fk', $request->patient_data)->where('admission_pk_no', $request->admission_data)->where('LOOKUPDATA_UID', 'FOOD')->orderBy('au_entry_at', 'desc')->get()->toArray();
        $ipd_otherServices = DB::table('psn_t_prescription_dtl_vw')->where('patient_no_fk', $request->patient_data)->where('admission_pk_no', $request->admission_data)->where('LOOKUPDATA_UID', 'SERVICE')->orderBy('au_entry_at', 'desc')->get()->toArray();
        $extra_med = DB::table('psn_t_prescription_med')->select('psn_t_prescription_med.*', 'hrms_personnel.full_name as ipd_instructed_doc_name')->leftJoin('hrms_personnel', 'hrms_personnel.person_no_pk', '=', 'psn_t_prescription_med.ipd_instruct_doc_person_no_fk')->where('admission_pk_no', $request->admission_data)->where('item_no_fk', 0)->get();
        $patient_info = DB::table('pat_registration_wl_vw a')
            ->select("a.*", "b.admission_no_pk", "b.admission_uid", "b.admission_date", "b.ward_name", "b.bed_name", "b.bed_uid", "b.admitted_department")
            ->leftJoin('ipd_admitted_pat_nsrcv_wl_vw b', "a.patient_no_pk", "=", "b.patient_no_fk")
            ->where('a.patient_no_pk', $request->patient_data)
            ->where('b.admission_uid', $request->admission_data)
            ->get()->first();
        return Template::loadview("admin.ipd.nurse_station.nurse_station_patient_prescribed_list", ['patient_info' => $patient_info, 'ipd_vitals' => $ipd_vitals, 'ipd_med_list' => $ipd_med_list, 'ipd_investigations' => $ipd_investigations, 'ipd_ot_list' => $ipd_ot_list, 'ipd_diet_list' => $ipd_diet_list, 'ipd_otherServices' => $ipd_otherServices, "ipd_discontinue_med_list" => $ipd_discontinue_med_list, 'extra_med' => $extra_med]);
    }

    public function editMedicineDose($med_id = "")
    {

        $medicine = DB::table('psn_t_prescription_med')->where('prescription_med_no_pk', $med_id)->first();
        $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");


        return Template::loadview("admin.ipd.nurse_station.ipd_nurse_station_med_dose_edit", ['med_id' => $med_id, 'dose' => $dose, 'medicine' => $medicine]);
    }
    public function editMedicineDoseSave(Request $request)
    {

        $medicine = DB::table('psn_t_prescription_med')->where('prescription_med_no_pk', $request->med_id)->first();
        $dose = $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name");
        try {
            DB::table('psn_t_prescription_med')
                ->where('prescription_med_no_pk', $request->med_id)
                ->update([
                    'continue_ind' => 0,
                    'au_update_at' => date('Y-m-d'),
                    'au_update_by' => Auth::id(),
                    'au_update_hospital_no_fk' => Session::get('user.ses_hospital_no_pk'),
                ]);

            $sequence = DB::getSequence();
            $med_no_pk_seq = $sequence->nextValue('psn_t_prescription_med_seq');

            $data = [
                'prescription_med_no_pk' => '14100' . $med_no_pk_seq,
                'prescription_no_fk' => $medicine->prescription_no_fk,
                'prescription_uid' => $medicine->prescription_uid,
                'appointment_pk_no' => $medicine->appointment_pk_no,
                'patient_no_fk' => $medicine->patient_no_fk,
                'service_number' => $medicine->service_number,
                'entry_serial' => $medicine->entry_serial,
                'item_no_fk' => $medicine->item_no_fk,
                'generic_name' => $medicine->generic_name,
                'brand_name' => $medicine->brand_name,
                'dosage' => $request->medicine_dose,
                'duration' => $medicine->duration,
                'pack_type' => $medicine->pack_type,
                'item_qty' => $medicine->item_qty,
                'instruction_take' => $medicine->instruction_take,
                'medicine_comment' => $medicine->medicine_comment,
                'route' => $medicine->route,
                'strength' => $medicine->strength,
                'continue_ind' => 1,
                'duration_comment' => $medicine->duration_comment,
                'duration_mu' => $medicine->duration_mu,
                'eye_drop' => $medicine->eye_drop,
                'eye' => $medicine->eye,
                'mix_medicine_ind' => $medicine->mix_medicine_ind,
                'mix_medicine_group' => $medicine->mix_medicine_group,
                'admission_pk_no' => $medicine->admission_pk_no,
                'admission_uid' => $medicine->admission_uid,
                'ipd_item_taken_ind' => $medicine->ipd_item_taken_ind,
                'ipd_item_taken_by' => $medicine->ipd_item_taken_by,
                'ipd_item_taken_time' => $medicine->ipd_item_taken_time,
                'chronic_ind' => $medicine->chronic_ind,
                'opd_med_delivery_ind' => $medicine->opd_med_delivery_ind,
                'status' => $medicine->status,
                'au_entry_by' => auth::id(),
                'au_entry_at' => date('y-m-d'),
                'au_entry_session' => 'session',
                'au_entry_hospital_no_fk' => session::get('user.ses_hospital_no_pk'),
                'eye_leftright' => $medicine->eye_leftright,
                'ipd_instruct_doc_person_no_fk' => $medicine->ipd_instruct_doc_person_no_fk,
                'ipd_instruct_media_name' => $medicine->ipd_instruct_media_name,
                'ipd_ind' => $medicine->ipd_ind,
                'ipd_continue_ind' => $medicine->ipd_continue_ind,
                'ipd_entry_by' => $medicine->ipd_entry_by,
            ];
            DB::table('psn_t_prescription_med')->insert($data);
            DB::commit();
            $this->message = ['msg' => 'Medicine Dose Updated Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollBack();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($this->message);
    }




    // OT Report
    public function otReport()
    {
        return Template::loadView("admin.ot.reports.ot_reports", [
            'requestDepts' => DB::table('sysc_serviceunit_vw')
                ->orwhere('serviceunit_name', 'SURGERY')
                ->orwhere('serviceunit_name', 'NEURO SURGERY')
                ->orwhere('serviceunit_name', 'GENERAL SURGERY')
                ->get(['serviceunit_name', 'serviceunit_no_pk'])
                ->toArray(),
            'report_name' => 'OT',
            't_quantity' => 0,
            't_sales' => 0,
            't_discount' => 0,
            't_payment' => 0,

        ]);
    }
    public function procedureReport()
    {
        return Template::loadView("admin.ot.reports.ot_reports", [
            'requestDepts' => DB::table('sysc_serviceunit_vw')
                ->orwhere('serviceunit_name', 'SURGERY')
                ->orwhere('serviceunit_name', 'NEURO SURGERY')
                ->orwhere('serviceunit_name', 'GENERAL SURGERY')
                ->get(['serviceunit_name', 'serviceunit_no_pk'])
                ->toArray(),
            'report_name' => 'Procedure ',
            't_quantity' => 0,
            't_sales' => 0,
            't_discount' => 0,
            't_payment' => 0,
        ]);
    }


    public function otReportSearch(Request $request)
    {
        $report_type = $request->report_type;
        $department = $request->request_department;
        $doctor_id = $request->doctor_id;
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($department != "") ? " $clause ity_group_header_no=$department" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause PERSON_NO_FK=$doctor_id" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        if ($report_type == "OT") {
            $report_cond = "item_type='SUR'";
        } else {
            $report_cond = "ITY_GROUP_HEADER_NAME='PROCEDURE'";
        }
        //         $report_data = DB::select("select invoice_date, item_serviceunit_name,item_type, first_ref_doc_name, item_name,
        //         sum (nvl (item_qty, 0)) day_sum_item_qty,
        //         sum (nvl (cancel_qty, 0)) day_sum_cancel_qty,
        //         sum (nvl (invoicedtl_amt_sales, 0)) day_sum_invoicedtl_amt_sales,
        //         sum (nvl (invoicedtl_amt_payment, 0))
        //            day_sum_invoicedtl_amt_payment,
        //         sum (nvl (invoicedtl_amt_discount, 0)) day_sum_invoicedtl_amt_dis,
        //         count (distinct invoice_no_pk) inv_count,
        //         count (distinct patient_no_fk) pat_count
        //    from finc_invoicedtl_detail_vw
        //    where $report_cond $sql_cond
        // group by invoice_date,item_type,first_ref_doc_name,item_name,
        //         item_serviceunit_name");


        $report_data = DB::select("select invoice_date,
        item_serviceunit_name,
        item_type,
        full_name first_ref_doc_name ,
        item_name,
        sum (nvl (item_qty, 0)) day_sum_item_qty,
        sum (nvl (cancel_qty, 0)) day_sum_cancel_qty,
        sum (nvl (invoicedtl_amt_sales, 0)) day_sum_invoicedtl_amt_sales,
        sum (nvl (invoicedtl_amt_payment, 0)) day_sum_invoicedtl_amt_payment,
        sum (nvl (invoicedtl_amt_discount, 0)) day_sum_invoicedtl_amt_dis,
        count (distinct invoice_no_pk) inv_count,
        count (distinct patient_no_fk) pat_count
   from finc_invoicedtl_detail_vw
   where $report_cond $sql_cond
group by invoice_date,
        item_type,
        full_name,
        item_name,
        item_serviceunit_name");

        return Template::loadview("admin.ot.reports.ot_reports_search", [
            'report_data' => $report_data,
            'report_name' => $report_type,
        ]);
    }

    public function otReportPdf(Request $request)
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $report_type = $request->report_type;
        $department = $request->request_department;
        $doctor_id = $request->doctor_id;
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($department != "") ? " $clause ity_group_header_no=$department" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause person_no_fk =$doctor_id" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        if ($report_type == "OT") {
            $report_cond = "item_type='SUR'";
        } else {
            $report_cond = "item_type='PROCEDURE'";
        }
        $report_data = DB::select("select invoice_date,
        item_serviceunit_name,
        item_type,
        full_name first_ref_doc_name ,
        item_name,
        sum (nvl (item_qty, 0)) day_sum_item_qty,
        sum (nvl (cancel_qty, 0)) day_sum_cancel_qty,
        sum (nvl (invoicedtl_amt_sales, 0)) day_sum_invoicedtl_amt_sales,
        sum (nvl (invoicedtl_amt_payment, 0)) day_sum_invoicedtl_amt_payment,
        sum (nvl (invoicedtl_amt_discount, 0)) day_sum_invoicedtl_amt_dis,
        count (distinct invoice_no_pk) inv_count,
        count (distinct patient_no_fk) pat_count
   from finc_invoicedtl_detail_vw
   where $report_cond $sql_cond
group by invoice_date,
        item_type,
        full_name,
        item_name,
        item_serviceunit_name");

        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $pdf = PDF::loadView("admin.ot.reports.ot_reports_pdf", ['barcode_no' => $barcode_no, 'report_data' => $report_data, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details, 'report_name' => $report_type])->setPaper('a4', 'portrate');
        return $pdf->stream('Department_Wise_Performance_Report.pdf');
    }



    public function OTExecutionPrint(Request $request)
    {
        // dd($request->all());
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $type = $request->hdn_report_type;
        $query = DB::table('opt_ot_confirmlist_wl_vw')
            ->select("opt_ot_confirmlist_wl_vw.patient_name", "opt_ot_confirmlist_wl_vw.ot_prepered_by", "opt_ot_confirmlist_wl_vw.service_number", "opt_ot_confirmlist_wl_vw.admission_uid", "opt_ot_confirmlist_wl_vw.ot_req_no_pk", "opt_ot_confirmlist_wl_vw.ot_room_uid", "opt_ot_confirmlist_wl_vw.ward_name", "opt_ot_confirmlist_wl_vw.bed_name", "opt_ot_confirmlist_wl_vw.age", "opt_ot_confirmlist_wl_vw.surg_doctor_name", "opt_ot_confirmlist_wl_vw.ot_date", "opt_ot_confirmlist_wl_vw.item_name", "opt_ot_confirmlist_wl_vw.ot_req_uid", 'opt_ot_confirmlist_wl_vw.ot_note_ind', 'opt_ot_confirmlist_wl_vw.anest_note_ind', 'ot_complete_status.anesth_record', 'ot_complete_status.op_note', 'ot_complete_status.pre_anes_chkup_frm', 'ot_complete_status.pre_oper_chklist', 'ot_complete_status.high_risk_consent', 'ot_complete_status.ot_complete_ind', 'ot_complete_status.ot_rending_ind', 'opt_ot_confirmlist_wl_vw.ot_comfirmation_time')
            ->leftJoin('ot_complete_status', 'ot_complete_status.admission_no_fk', '=', 'opt_ot_confirmlist_wl_vw.admission_no_fk')
            ->leftJoin('opt_prescribed_ot', 'opt_prescribed_ot.admission_no_fk', '=', 'opt_ot_confirmlist_wl_vw.admission_no_fk');
        // DB::table('opt_ot_confirmlist_wl_vw')
        //     ->select("patient_name", "service_number", "admission_uid", "ot_req_no_pk", "ot_room_uid", "ward_name", "bed_name", "age", "surg_doctor_name", "ot_date", "item_name", 'ot_note_ind', 'anest_note_ind');

        if (!empty($request->hdn_presc_id)) {
            $query = $query->where('opt_ot_confirmlist_wl_vw.service_number', $request->hdn_presc_id);
        }
        if (!empty($request->hdn_admission_id)) {
            $query = $query->where('opt_ot_confirmlist_wl_vw.admission_uid', $request->hdn_admission_id);
        }
        if (!empty($request->ot_date_from) && !empty($request->ot_date_to)) {
            $query->where(DB::raw("trunc(opt_ot_confirmlist_wl_vw.ot_date)"), '>=', date('Y-m-d', strtotime($request->ot_date_from)));
            $query->where(DB::raw("trunc(opt_ot_confirmlist_wl_vw.ot_date)"), '<=', date('Y-m-d', strtotime($request->ot_date_to)));
        } elseif (!empty($request->ot_date_from)) {
            $query->where(DB::raw("trunc(opt_ot_confirmlist_wl_vw.ot_date)"), '=', date('Y-m-d', strtotime($request->ot_date_from)));
        } elseif (!empty($request->ot_date_to)) {
            $query->where(DB::raw("trunc(opt_ot_confirmlist_wl_vw.ot_date)"), '=', date('Y-m-d', strtotime($request->ot_date_to)));
        }

        // return Template::loadview("admin.ot.search_ot_execution", [
        //     'ot_confirmlist' => $query->where('opt_prescribed_ot.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
        //         ->where('opt_prescribed_ot.anest_clearance_ind', 1)
        //         ->where('opt_prescribed_ot.ot_comfirmation_ind', 1)
        //         ->orderby('ot_date', 'desc')
        //         ->orderby('opt_prescribed_ot.admission_uid', 'desc')
        //         ->get()->toArray()
        // ]);
        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        // $pdf = PDF::loadView("admin.reports.dept.dept_wise_item_pdf", [
        //     'ot_confirmlist' => $query->where('opt_prescribed_ot.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
        //         ->where('opt_prescribed_ot.anest_clearance_ind', 1)
        //         ->where('opt_prescribed_ot.ot_comfirmation_ind', 1)
        //         ->orderby('ot_date', 'desc')
        //         ->orderby('opt_prescribed_ot.admission_uid', 'desc')
        //         ->get()->toArray(), 'barcode_no' => $barcode_no, 'from_date' => $request->ot_date_from, 'to_date' => $request->ot_date_to, 'po_hospital_details' => $po_hospital_details, 'type' => $type
        // ])->setPaper('a4', 'portrait');
        // if ($type == 'OPD') {
        //     return $pdf->download('department-wise-item-OPD-report.pdf');
        // } else {
        //     return $pdf->download('department-wise-item-IPD-report.pdf');
        // }
        // dd($query->where('opt_prescribed_ot.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
        //     ->where('opt_prescribed_ot.anest_clearance_ind', 1)
        //     ->where('opt_prescribed_ot.ot_comfirmation_ind', 1)
        //     ->orderby('ot_date', 'desc')
        //     ->orderby('opt_prescribed_ot.admission_uid', 'desc')
        //     ->get()->toArray());

        if ($type == 'PDF') {
            $pdf = PDF::loadView("admin.ot.reports.ot_execution_report", [
                'ot_confirmlist' => $query->where('opt_prescribed_ot.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                    ->where('opt_prescribed_ot.anest_clearance_ind', 1)
                    ->where('opt_prescribed_ot.ot_comfirmation_ind', 1)
                    ->orderby('ot_date', 'desc')
                    ->orderby('opt_prescribed_ot.admission_uid', 'desc')
                    ->get()->toArray(),
                'barcode_no' => $barcode_no,
                'from_date' => $request->ot_date_from,
                'to_date' => $request->ot_date_to,
                'po_hospital_details' => $po_hospital_details,
                'type' => $type
            ])->setPaper('a4', 'landscape');
            return $pdf->stream('OT_execution_report.pdf');
        }
        if ($type == 'EXCEL') {
            // dd('ok');
            $pdf = [
                'ot_confirmlist' => $query->where('opt_prescribed_ot.au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                    ->where('opt_prescribed_ot.anest_clearance_ind', 1)
                    ->where('opt_prescribed_ot.ot_comfirmation_ind', 1)
                    ->orderby('ot_date', 'desc')
                    ->orderby('opt_prescribed_ot.admission_uid', 'desc')
                    ->get()->toArray(),
                'barcode_no' => $barcode_no,
                'from_date' => $request->ot_date_from,
                'to_date' => $request->ot_date_to,
                'po_hospital_details' => $po_hospital_details,
                'type' => $type
            ];
            $fileToExport = "OT_execution_report";
            $html = View("admin.ot.reports.ot_execution_report")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }



    //ot Medicine Setup
    public function otMedicineSetup()
    {


        $ot_items = DB::table('sysc_serviceitem_vw item')
            ->select('item.item_no_pk', 'item.item_name')
            ->leftJoin('ot_req_medicine_setup_vw otsetup', 'item.item_no_pk', 'otsetup.procedure_no_fk')
            ->where('item.item_type_name', 'PROCEDURE')
            ->whereNull('otsetup.procedure_name')
            ->get();
        return Template::loadview("admin.ot.ot_setup.ot_medicine_setup", [
            'ot_items' => $ot_items,
            'data' => [],
            'procedureData' => ''
        ]);
    }

    public function getAllPakagesListOT(Request $request)
    {

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = ""; //au_entry_hospital_pk_no = $hospital_id
        $table = 'OT_REQ_MEDICINE_SETUP_VW';
        // Table's primary key
        $primaryKey = 'procedure_no_fk';

        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            // array('db' => 'otrm_setup_uid', 'dt' => 1),
            array('db' => 'procedure_name', 'dt' => 1),
            array('db' => 'procedure_no_fk', 'dt' => 2),
        );

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    // public function otCreateMedicineSetup(){
    //     return Template::loadview("admin.ot.ot_setup.ot_create_medicine_setup");
    // }

    public function otCreateMedicineStore(Request $request)
    {

        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        try {
            // for OT Medicine Procedure
            $pkg_name = $request->pakage_name;
            $str_pkg = explode("_", $pkg_name);
            $str_pkg_id = $str_pkg[0];
            $str_pkg_name = $str_pkg[1];

            $item_array_count = sizeof($request->input("item_id"));
            $item_id = $request->input("item_id");
            $item_hdn_id = $request->input("item_hdn_id");
            $qty = $request->input("qty");
            $status = $request->input("status");
            $hdn_id = $request->input("hdn_id");




            if (isset($item_id)) {
                for ($i = 1; $i < $item_array_count; $i++) {
                    if ($item_id[$i] != null) {
                        if ($hdn_id[$i] == '') {
                            $sequence = DB::getSequence();
                            $otrm_setup_no_pk_seq = $sequence->nextValue('otrm_setup_no_pk_seq');
                            $itemData = [
                                "otrm_setup_no_pk" => $otrm_setup_no_pk_seq,
                                "otrm_setup_uid" => 'OT-' . $otrm_setup_no_pk_seq,
                                'procedure_no_fk' => $str_pkg_id,
                                'procedure_name' => $str_pkg_name,
                                'status' => (isset($status[$i])) ? $status[$i] : 0,
                                'med_item_no_fk' => (isset($item_hdn_id[$i])) ? $item_hdn_id[$i] : '',
                                'med_name' => (isset($item_id[$i])) ? $item_id[$i] : '',
                                'med_qty' => (isset($qty[$i])) ? $qty[$i] : '',
                                'au_entry_session' => "session",
                                'au_entry_hospital_pk_no' => $ses_hospital_id
                            ];
                            $itemData['au_entry_by'] = $auth_id;
                            $itemData['au_entry_at'] = date("Y-m-d");
                            DB::table('ot_req_medicine_setup')->insert($itemData);
                        } else {
                            $itemData = [
                                'procedure_no_fk' => $str_pkg_id,
                                'procedure_name' => $str_pkg_name,
                                'status' => (isset($status[$i])) ? $status[$i] : 0,
                                'med_item_no_fk' => (isset($item_hdn_id[$i])) ? $item_hdn_id[$i] : '',
                                'med_name' => (isset($item_id[$i])) ? $item_id[$i] : '',
                                'med_qty' => (isset($qty[$i])) ? $qty[$i] : '',
                                'au_entry_session' => "session",
                                'au_entry_hospital_pk_no' => $ses_hospital_id
                            ];
                            $itemData['au_entry_by'] = $auth_id;
                            $itemData['au_entry_at'] = date("Y-m-d");
                            DB::table('ot_req_medicine_setup')->where('procedure_no_fk', $str_pkg_id)->update($itemData);
                        }
                    }
                }
            }



            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'insert_id' => $auth_id];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }


    public function otCreateMedicineEdit($id)
    {

        $ot_items = DB::table('sysc_serviceitem_vw item')
            ->select('item.item_no_pk', 'item.item_name')
            ->leftJoin('ot_req_medicine_setup_vw otsetup', 'item.item_no_pk', 'otsetup.procedure_no_fk')
            ->where('item.item_type_name', 'PROCEDURE')
            // ->whereNull('otsetup.PROCEDURE_NAME')
            ->get();

        $data = DB::table('ot_req_medicine_setup')->where('procedure_no_fk', $id)->get();
        $procedureData = DB::table('ot_req_medicine_setup')->where('procedure_no_fk', $id)->first();
        // dd($procedureData);
        return Template::loadview("admin.ot.ot_setup.ot_create_medicine_setup", [
            'data' => $data,
            'procedureData' => $procedureData,
            'ot_items' => $ot_items,
        ]);
        //    return response()->json($data);
    }

    public function otAddMedicine($id)
    {
        return Template::loadView('admin.ot.ot_execution_all_item', [
            'item_data' => DB::table('ot_req_medicine_setup')->where('procedure_no_fk', $id)->where('status', 1)->get()
        ]);
    }

    public function otAddMedicineDetails(Request $request)
    {


        DB::beginTransaction();
        try {
            $indent_no = '';
            $indent_date = date('Y-m-d');
            $nurse_station_dept = DB::table('ipd_admission_details')->join('ipds_nsds', 'ipds_nsds.nsds_no_pk', '=', 'ipd_admission_details.ns_receive_by')->select('ipds_nsds.su_no_fk')->where('admission_no_pk', $request->admission_uid)->first();

            $store_from = $nurse_station_dept->su_no_fk;


            // dd($store_from);
            $store_to = 20001;
            // $store_to = $request->phr_department_id;
            // dd($store_from,$store_to);
            $return_reason = '';

            $item_no_fk_arr = $request->indent_req;
            // $item_quantities_arr = $request->item_quantities;
            // $item_uoms_arr = $request->item_uoms;
            $item_serial_dtl_arr = [];

            $item_no_fk_arr = DB::table('ot_req_medicine_setup')->where('procedure_no_fk', $request->ot_hdn_item)->get();
            // dd($item_no_fk_arr);
            if (!empty($item_no_fk_arr)) {
                foreach ($item_no_fk_arr as $key => $item_no) {
                    $item_serial_dtl_arr[] = $key + 1;
                }
            }

            $qty = $uom = $item_id = $item_pvmsno_arr = [];
            for ($i = 0; $i < count($item_no_fk_arr); $i++) {
                // dd($item_no_fk_arr[$i]);
                // $check[$i]= 'indent_req;
                $uom[$i] = '';
                $qty[$i] = $item_no_fk_arr[$i]->med_qty;
                $item_id[$i] = $item_no_fk_arr[$i]->med_item_no_fk;
                $pres_med[$i] = $item_no_fk_arr[$i]->med_item_no_fk;
                $item_pvmsno_arr[$i] = '';
            }
            // dd( $item_no_fk_arr, $uom, $qty, $item_id);
            $in_au_entry_by = Auth::id();
            $in_au_entry_session = $item_no_fk_arr[0]->procedure_name;
            $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
            //dd($in_au_entry_hospital_pk_no);

            $numelems = 500;
            $null = '';
            $out_requisition_uid = '';
            $admission_no = $request->admission_uid;
            $pres_med_id = $request->pres_med_id;
            $in_patient_no_fk = isset($request->patient_uid) ? $request->patient_uid : 0;
            $pdo = DB::getPdo();
            // $receive_items = $pdo->prepare("begin pkg_pharmacy.prc_itemrequisition(
            $receive_items = $pdo->prepare("begin  pkg_ipd.prc_ipdmedrequisition(
    			:in_patindentmst_no_pk,
    			:in_indent_date,
    			:in_store_from_su_no_fk,
    			:in_store_to_su_no_fk,
                :in_patient_no_fk,
                :in_admission_no_fk,
    			:in_pres_med_no_fk,
    			:in_a_item_no_fk,
    			:in_a_item_pvmsno,
    			:in_a_item_qty,
    			:in_a_item_uom,
    			:in_a_entry_serial_dtl,
    			:in_au_entry_by,
    			:in_au_entry_session,
    			:in_au_entry_hospital_no_fk,
                :in_return_reason,
    			:out_patindentmst_uid
    		); end;");

            $receive_items->bindparam('in_patindentmst_no_pk', $indent_no);
            $receive_items->bindparam('in_indent_date', $indent_date);
            $receive_items->bindparam('in_store_from_su_no_fk', $store_from);
            $receive_items->bindparam('in_store_to_su_no_fk', $store_to);
            $receive_items->bindparam('in_patient_no_fk', $in_patient_no_fk);
            $receive_items->bindparam('in_admission_no_fk', $admission_no);

            $receive_items->bindArray('in_pres_med_no_fk', $pres_med, count($pres_med), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_item_no_fk', $item_id, count($item_id), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_item_pvmsno', $item_pvmsno_arr, count($item_pvmsno_arr), $numelems, SQLT_CHR);
            $receive_items->bindArray('in_a_item_qty', $qty, count($qty), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_item_uom', $uom, count($uom), $numelems, SQLT_INT);
            $receive_items->bindArray('in_a_entry_serial_dtl', $item_serial_dtl_arr, count($item_serial_dtl_arr), $numelems, SQLT_INT);

            $receive_items->bindparam('in_au_entry_by', $in_au_entry_by);
            $receive_items->bindparam('in_au_entry_session', $in_au_entry_session);
            $receive_items->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
            $receive_items->bindparam('in_return_reason', $return_reason);

            $receive_items->bindParam(':out_patindentmst_uid', $out_requisition_uid, PDO::PARAM_STR, 500);
            // dd($receive_items);
            $receive_items->execute();

            DB::commit();
            $this->message = ['msg' => 'Data saved successfully. <br><strong>Indent No = ' . $out_requisition_uid . '</strong>', 'title' => 'Success'];
        } catch (\Exception $e) {

            DB::rollback();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($this->message);
    }


    // OT Reports 10/06/2024

    public function operationRequisition(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        return View("admin.ot.reports.ot_requisition", ['barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details]);
    }

    public function postAnaesthetiaRecordsPdf(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        return View("admin.ot.reports.post_anaesthetia_records", ['barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details]);
    }

    public function preoperativeCheckListPdf(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        return View("admin.ot.reports.preoparative_check_list_pdf", ['barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details]);
    }

    public function recoveryNote(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        return View("admin.ot.reports.recovery_note", ['barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details]);
    }

    public function aneastethicReferralPdf($patient_id = "", $ref_no = "")
    {
         $pat_info = DB::table('patient_info_vw')->where('patient_no_pk', $patient_id)->first();

        // $patient_info = DB::table('anaesthetic_reff_form AS ref')
        //     ->select(
        //         'ref.weight',
        //         'ref.ot_planned_date',
        //         'ref.purpose_of_referral',
        //         'ref.history',
        //         'ref.positive_findings',
        //         'ref.diagnosis',
        //         'ref.ot_planned',
        //         'ref.doc_reply_text',
        //         'pat.patient_name',
        //         'pat.patient_code',
        //         'pat.gender_txt',
        //         'ipd.admitted_department',
        //         'ipd.ward_name',
        //         'ipd.bed_name',
        //         'per.full_name AS ot_referred_doctor',
        //         DB::raw('pat_age(pat.dob, NVL(pat.dod, SYSDATE)) AS pat_age')
        //     )
        //     ->join('pat_registration_wl_vw AS pat', 'ref.patient_no_fk', '=', 'pat.patient_no_pk')
        //     ->leftJoin('ipd_admitted_patlist_vw AS ipd', 'ref.admission_no_fk', '=', 'ipd.admission_no_pk')
        //     ->join('hrms_personnel AS per', 'ref.ref_doctor_no_fk', '=', 'per.person_no_pk')
        //     ->where('ref.patient_no_fk', $patient_id)
        //     ->first();

        $reffered_info = DB::table('anaesthetic_reff_form ref')
            ->leftjoin('hrms_personnel per', 'ref.ref_doctor_no_fk', 'per.person_no_pk')
            ->where(function ($query) use ($patient_id, $ref_no) {
           $query->where('patient_no_fk', $patient_id)
            ->orWhere('REFF_ANES_DEPT_NO_fK', $ref_no);
            })
           ->first();



        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        return View("admin.ot.reports.anaeasethic_referral_pdf", ['barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details, 'pat_info' => $pat_info,'reffered_info' =>$reffered_info]);
    }
    public function IntraoperativeMonitoringChart(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        return View("admin.ot.reports.intraoperative_monitoring_chart_pdf", ['barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details]);
    }
    public function recoveryNotePdf(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        return View("admin.ot.reports.recovery_note_pdf", ['barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details]);
    }
    public function otSchedule($doctor_id = null)
    {
        // var_dump($doctor_id);
        $doctor_info = [];
        $schedules = [];
        if ($doctor_id != null) {
            $doctor_info = DB::table('doctor_info_vw')->where("person_no_pk", "=", $doctor_id)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
            $schedules = HrmsSchedule::where('doctor_person_no_fk', '=', $doctor_id)
                ->join('hrms_shift', 'hrms_schedule.shift_no_fk', '=', 'hrms_shift.shift_no_pk')->where('hrms_schedule.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        }
        //shecdule

        // return $doctor_info;
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $docspl = DB::table('SPECIALIZATION_WISE_DOC_COUNT_VW')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderByRaw('lower(specialization_name) asc ')
            ->get();
        $room_data = DB::table('sysc_room')->select('room_no_pk', 'room_name', 'room_code')->where('ot_ind', 1)->get();

        $shift = DB::SELECT("select shift_no_pk,shift_code,shift_desc,start_time,end_time from hrms_shift where au_entry_hospital_pk_no  =  $hospital_id");
        return Template::loadView("admin.ot.ot_schedule.ot_schedule_viewer", ['docspl' => $docspl, 'room_data' => $room_data, 'schedules' => $schedules]);
    }

    public function storeOtSchedule(Request $request)
    {
        $auth_id = Auth::id();
        $doctor_no_fk = $request->doctor_name;
        $room_no_fk = $request->room_no;
        $schedule_no = '';
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $check_schedule = DB::table('ot_schedule')
            ->where('ot_room_no_fk', $room_no_fk)
            ->when(!empty($from_date), function ($q) use ($from_date) {
                return $q->where('schedule_dt', '>=', Carbon::parse($from_date)->format('Y-m-d'));
            })
            ->when(!empty($to_date), function ($q) use ($to_date) {
                return $q->where('schedule_dt', '<=', Carbon::parse($to_date)->format('Y-m-d'));
            })
            ->first();

        if (!isset($check_schedule)) {
            DB::beginTransaction();
            try {
                $startDate = new Carbon($request->from_date);
                $endDate = new Carbon($request->to_date);

                $check_if_exist = HrmsSchedule::select('schedule_no_pk', 'schedule_dt')
                    ->where('room_no_fk', '=', $room_no_fk)
                    ->whereBetween('schedule_dt', [$startDate, $endDate])
                    ->get();

                $sc_dt_arr = [];
                if (!empty($check_if_exist)) {
                    foreach ($check_if_exist as $sc_row) {
                        $sc_dt_arr[date('Y-M-d', strtotime($sc_row->schedule_dt))] = date('Y-M-d', strtotime($sc_row->schedule_dt));
                    }
                }

                $DstartDate = date("Y-M-d", strtotime($startDate->toDateString()));
                $DendDate = date("Y-M-d", strtotime($endDate->toDateString()));

                $period = CarbonPeriod::create($startDate, $endDate);
                // dd($period);
                foreach ($period as $key => $date) {

                    $sc_date = date("Y-M-d", strtotime($date->toDateString()));

                    if (!isset($sc_dt_arr[$sc_date])) {

                        $sc_d = date("D", strtotime($date->toDateString()));

                        $start_dt = $date->toDateString() . " " . $request->shift_start_time;
                        $end_dt = $date->toDateString() . " " . $request->shift_end_time;
                        $sc_start_date = date("Y-M-d H:i", strtotime($start_dt));
                        $sc_end_date = date("Y-M-d H:i", strtotime($end_dt));
                        $date->addDay();

                        $schedule_day_arr = $request->schedule_day;
                        $procedureName = 'pkg_ot_schedule.prc_otschedule';
                        $hospital_id = Session::get('user.ses_hospital_no_pk');

                        $data_bindings = [
                            'in_ot_room_no_fk' => $request->room_no,
                            'in_schedule_dt' => $sc_date,
                            'in_schedule_session' => '',
                            'in_start_time' => $sc_start_date,
                            'in_end_time' => $sc_end_date,
                            'in_YM' => 0,
                            'in_avg_load' => 0,
                            'in_block_load' => 0,
                            'in_avg_duration' => $request->avg_duration,
                            'in_duty_type' => '0',
                            'in_room_no_fk' => 0,
                            // 'in_shift_no_fk' => $request->shift_type,
                            'in_au_entry_by' => $auth_id,
                            'in_au_entry_session' => '',
                            'in_au_entry_hospital_pk_no' => $hospital_id,
                            'out_schedule_no' => [
                                'value' => &$schedule_no,
                                'type' => PDO::PARAM_INT
                            ],
                            'out_invoice_id' => '',
                            'out_error' => '',
                        ];

                        if (in_array('All', $schedule_day_arr)) {
                            $result = DB::executeProcedure($procedureName, $data_bindings);
                        } else {
                            if (!in_array($sc_d, $schedule_day_arr) && !in_array('All', $schedule_day_arr)) {
                                continue;
                            } else {
                                $result = DB::executeProcedure($procedureName, $data_bindings);
                            }
                        }
                    }
                    // dd($request->slot);
                    // if ($request->slot == 1) {
                    $outError = '';
                    if ($schedule_no != "") {
                        $procedureName2 = 'pkg_ot_schedule.time_schedule';
                        $data_bindings2 = [
                            'in_schedule_no_pk' => $schedule_no,
                            'in_au_entry_hospital_pk_no' => $hospital_id,
                            'out_error' => [
                                'value' => &$outError,
                                'type' => PDO::PARAM_STR,
                                'length' => 500
                            ]

                        ];

                        DB::executeProcedure($procedureName2, $data_bindings2);
                    }
                    // }
                }
                $last_id = $schedule_no;
                // $last_id = 0;
                DB::commit();
                $message = ['msg' => 'OT Schedule Created Successfully', 'title' => 'Success', 'insert_id' => $last_id, 'outError' => $outError];
            } catch (\Exception $e) {
                DB::rollback();
                $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            }
        } else {
            $message = ['msg' => 'OT schedule already exists so can not be created again !!', 'title' => 'Error'];
        }

        return response()->json($message);
    }
    public function getOtSchedule(Request $request)
    {
        $room_id = $request->room_id;
        $from_date = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : '';
        $shift_type = $request->shift_type ? $request->shift_type : '';

        $schedules = DB::table('ot_schedule_slot_vw')
            ->leftjoin('hrms_schedule_dayoff', 'hrms_schedule_dayoff.schedule_no_fk', 'ot_schedule_slot_vw.ot_schedule_no_pk')
            ->where('ot_schedule_slot_vw.ot_room_no_fk', '=', $room_id)
            ->when($from_date != '', function ($q) use ($from_date) {
                return $q->where('ot_schedule_slot_vw.schedule_dt', '>=', $from_date);
            })
            ->when($to_date != '', function ($q) use ($to_date) {
                return $q->where('ot_schedule_slot_vw.schedule_dt', '<=', $to_date);
            })
            ->select(
                'ot_schedule_slot_vw.ot_schedule_no_pk',
                'ot_schedule_slot_vw.schedule_dt',
                'ot_schedule_slot_vw.start_time',
                'ot_schedule_slot_vw.end_time',
                'ot_schedule_slot_vw.avg_duration',
                'ot_schedule_slot_vw.total_slot',
                DB::raw('count(hrms_schedule_dayoff.schedule_no_fk) schedule_count')
            )
            ->groupBy('ot_schedule_slot_vw.ot_schedule_no_pk', 'ot_schedule_slot_vw.schedule_dt', 'ot_schedule_slot_vw.start_time', 'ot_schedule_slot_vw.end_time', 'ot_schedule_slot_vw.avg_duration', 'ot_schedule_slot_vw.total_slot')
            ->orderBy('ot_schedule_slot_vw.schedule_dt')
            ->get();
        // dd($schedules);

        $returnHTML = view('admin.ot.ot_schedule.ot_schedule')->with('schedules', $schedules)->render();

        $arr = array('msg' => 'OT Schedule', 'status' => 'success', 'html' => $returnHTML);

        return response()->json($arr);
    }

    public function deleteOtScheduleAll(Request $request)
    {
        $room_id = $request->room_id;
        $from_date = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : '';

        $check_booked_slot = DB::table('ot_schedule_slot')->where('ot_room_no_fk', '=', $room_id)
            ->when($from_date != '', function ($q) use ($from_date) {
                return $q->where('schedule_dt', '>=', $from_date);
            })
            ->when($to_date != '', function ($q) use ($to_date) {
                return $q->where('schedule_dt', '<=', $to_date);
            })
            ->where('available_ind', '=', 0)
            ->first();


        if (!isset($check_booked_slot)) {
            DB::table('ot_schedule')->where('ot_room_no_fk', '=', $room_id)
                ->when($from_date != '', function ($q) use ($from_date) {
                    return $q->where('schedule_dt', '>=', $from_date);
                })
                ->when($to_date != '', function ($q) use ($to_date) {
                    return $q->where('schedule_dt', '<=', $to_date);
                })->delete();
            DB::table('ot_schedule_slot')->where('ot_room_no_fk', '=', $room_id)
                ->when($from_date != '', function ($q) use ($from_date) {
                    return $q->where('schedule_dt', '>=', $from_date);
                })
                ->when($to_date != '', function ($q) use ($to_date) {
                    return $q->where('schedule_dt', '<=', $to_date);
                })->delete();
            $schedules = DB::table('ot_schedule_slot_vw')
                ->leftjoin('hrms_schedule_dayoff', 'hrms_schedule_dayoff.schedule_no_fk', 'ot_schedule_slot_vw.ot_schedule_no_pk')
                ->where('ot_schedule_slot_vw.ot_room_no_fk', '=', $room_id)
                ->when($from_date != '', function ($q) use ($from_date) {
                    return $q->where('ot_schedule_slot_vw.schedule_dt', '>=', $from_date);
                })
                ->when($to_date != '', function ($q) use ($to_date) {
                    return $q->where('ot_schedule_slot_vw.schedule_dt', '<=', $to_date);
                })
                ->select(
                    'ot_schedule_slot_vw.ot_schedule_no_pk',
                    'ot_schedule_slot_vw.schedule_dt',
                    'ot_schedule_slot_vw.start_time',
                    'ot_schedule_slot_vw.end_time',
                    'ot_schedule_slot_vw.avg_duration',
                    'ot_schedule_slot_vw.total_slot',
                    DB::raw('count(hrms_schedule_dayoff.schedule_no_fk) schedule_count')
                )
                ->groupBy('ot_schedule_slot_vw.ot_schedule_no_pk', 'ot_schedule_slot_vw.schedule_dt', 'ot_schedule_slot_vw.start_time', 'ot_schedule_slot_vw.end_time', 'ot_schedule_slot_vw.avg_duration', 'ot_schedule_slot_vw.total_slot')
                ->orderBy('ot_schedule_slot_vw.schedule_dt')
                ->get();

            $returnHTML = view('admin.ot.ot_schedule.ot_schedule')->with('schedules', $schedules)->render();

            $arr = array('msg' => 'Doctor schedule', 'status' => 'success', 'html' => $returnHTML);
        } else {
            $schedules = DB::table('ot_schedule_slot_vw')
                ->leftjoin('hrms_schedule_dayoff', 'hrms_schedule_dayoff.schedule_no_fk', 'ot_schedule_slot_vw.ot_schedule_no_pk')
                ->where('ot_schedule_slot_vw.ot_room_no_fk', '=', $room_id)
                ->when($from_date != '', function ($q) use ($from_date) {
                    return $q->where('ot_schedule_slot_vw.schedule_dt', '>=', $from_date);
                })
                ->when($to_date != '', function ($q) use ($to_date) {
                    return $q->where('ot_schedule_slot_vw.schedule_dt', '<=', $to_date);
                })
                ->select(
                    'ot_schedule_slot_vw.ot_schedule_no_pk',
                    'ot_schedule_slot_vw.schedule_dt',
                    'ot_schedule_slot_vw.start_time',
                    'ot_schedule_slot_vw.end_time',
                    'ot_schedule_slot_vw.avg_duration',
                    'ot_schedule_slot_vw.total_slot',
                    DB::raw('count(hrms_schedule_dayoff.schedule_no_fk) schedule_count')
                )
                ->groupBy('ot_schedule_slot_vw.ot_schedule_no_pk', 'ot_schedule_slot_vw.schedule_dt', 'ot_schedule_slot_vw.start_time', 'ot_schedule_slot_vw.end_time', 'ot_schedule_slot_vw.avg_duration', 'ot_schedule_slot_vw.total_slot')
                ->orderBy('ot_schedule_slot_vw.schedule_dt')
                ->get();

            $returnHTML = view('admin.ot.ot_schedule.ot_schedule')->with('schedules', $schedules)->render();

            $arr = array('msg' => 'Doctor schedule', 'status' => 'error', 'html' => $returnHTML);
        }
        return response()->json($arr);
    }

    public function getOtSlot($id)
    {
        $slot_details = DB::table('ot_schedule_slot')
            ->where('ot_schedule_no_fk', $id)
            //->select('product_name','quantity', 'product_price')
            ->get();
        return Template::loadview("admin.ot.ot_schedule.ot_slot", [
            'slot_details' => $slot_details
        ]);
    }
    public function otRequisitionStatus()
    {

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        // dd(DB::table('opt_ot_reqlist_wl_vw')
        // ->select('opt_ot_reqlist_wl_vw.*', 'ipd_admitted_patlist_vw.new_serivce_unit_name')
        // ->leftJoin('ipd_admitted_patlist_vw', 'ipd_admitted_patlist_vw.admission_no_pk', '=', 'opt_ot_reqlist_wl_vw.admission_no_fk')
        // ->where('ot_comfirmation_ind', 0)->whereNull('reject_ind')
        // ->where('au_entry_hospital_no_fk',   $ses_hospital_id)
        // ->wherenotnull('opt_ot_reqlist_wl_vw.admission_uid')
        // //->where(DB::raw("trunc(ot_req_date)"),date("Y-m-d"))
        // ->where(DB::raw("trunc(ot_req_date)"), '>=', date('Y-m-d'))
        // ->orderBy('ot_req_date', 'DESC')
        // ->orderBy('opt_ot_reqlist_wl_vw.admission_no_fk', 'DESC')
        // ->get());
        return Template::loadview("admin.ot.ot_requisition_status", [
            'ot_requisition_wl' =>
            DB::table('opt_ot_reqlist_wl_vw')
                ->select('opt_ot_reqlist_wl_vw.*', 'ipd_admitted_patlist_vw.new_serivce_unit_name', 'ipd_admitted_patlist_vw.gender_txt')
                ->leftJoin('ipd_admitted_patlist_vw', 'ipd_admitted_patlist_vw.admission_no_pk', '=', 'opt_ot_reqlist_wl_vw.admission_no_fk')
                // ->where('ot_comfirmation_ind', 0)->whereNull('reject_ind')
                ->where('au_entry_hospital_no_fk', $ses_hospital_id)
                ->wherenotnull('opt_ot_reqlist_wl_vw.admission_uid')
                ->where(DB::raw("trunc(ot_req_date)"), '>=', date('Y-m-d'))
                ->orderBy('ot_req_date', 'DESC')
                ->orderBy('opt_ot_reqlist_wl_vw.admission_no_fk', 'DESC')
                ->get()
                ->toArray(),
            'room_data' => DB::table('sysc_room')->select('room_no_pk', 'room_name', 'room_code')->where('ot_ind', 1)->get(),
        ]);
    }

    public function searchOTRequisitionStatusSearch(Request $request)
    {
        // dd($request->all());
        // ->where('ot_comfirmation_ind', 0)->whereNull('reject_ind')
        $query = DB::table('opt_ot_reqlist_wl_vw')
            ->select('opt_ot_reqlist_wl_vw.*', 'ipd_admitted_patlist_vw.new_serivce_unit_name', 'ipd_admitted_patlist_vw.gender_txt')
            ->leftJoin('ipd_admitted_patlist_vw', 'ipd_admitted_patlist_vw.admission_no_pk', '=', 'opt_ot_reqlist_wl_vw.admission_no_fk');
        if (!empty($request->service_id)) {
            $query = $query->where('prescription_no_fk', $request->hdn_presc_id);
        }
        if (!empty($request->hdn_patient_id)) {
            $query = $query->where('opt_ot_reqlist_wl_vw.patient_no_fk', $request->hdn_patient_id);
        }
        if (!empty($request->ot_status)) {
            if ($request->ot_status == 'REJECTED') {
                $query = $query->where('reject_ind', 1);
            } elseif ($request->ot_status == 'CONFIRM') {
                $query = $query->where('ot_comfirmation_ind', 1);
            } elseif ($request->ot_status == 'PENDING') {
                $query = $query->where('ot_comfirmation_ind', 0)->whereNull('reject_ind');
            }
        }

        if (!empty($request->hdn_admission_id)) {
            $query = $query->where('opt_ot_reqlist_wl_vw.admission_uid', $request->hdn_admission_id);
        }
        if (!empty($request->ot_req_date_from) && !empty($request->ot_req_date_to)) {
            $query->where(DB::raw("trunc(ot_req_date)"), '>=', date('Y-m-d', strtotime($request->ot_req_date_from)));
            $query->where(DB::raw("trunc(ot_req_date)"), '<=', date('Y-m-d', strtotime($request->ot_req_date_to)));
        } elseif (!empty($request->ot_req_date_from)) {
            $query->where(DB::raw("trunc(ot_req_date)"), '=', date('Y-m-d', strtotime($request->ot_req_date_from)));
        } elseif (!empty($request->ot_req_date_to)) {
            $query->where(DB::raw("trunc(ot_req_date)"), '=', date('Y-m-d', strtotime($request->ot_req_date_to)));
        }
        return Template::loadview("admin.ot.search_ot_requisition_status", [
            'ot_requisition_wl' => $query
                ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
                ->orderBy('ot_req_date', 'DESC')
                ->orderBy('opt_ot_reqlist_wl_vw.admission_no_fk', 'DESC')
                ->get()->toArray(),
        ]);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'ot_req_id' => 'required|integer',
            'status' => 'required|in:Confirm,Reject'
        ]);

        $otReq = OtRequisition::find($request->ot_req_id);
        if (!$otReq) {
            return response()->json(['success' => false, 'message' => 'Requisition not found']);
        }

        $otReq->status = $request->status;
        $otReq->save();

        return response()->json(['success' => true]);
    }

    public function getOtScheduleForStatus(Request $request)
    {
        $room_id = $request->room_id;
        $from_date = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : '';
        $shift_type = $request->shift_type ? $request->shift_type : '';

        $schedules = DB::table('ot_schedule_slot_vw')
            ->leftjoin('hrms_schedule_dayoff', 'hrms_schedule_dayoff.schedule_no_fk', 'ot_schedule_slot_vw.ot_schedule_no_pk')
            ->where('ot_schedule_slot_vw.ot_room_no_fk', '=', $room_id)
            ->when($from_date != '', function ($q) use ($from_date) {
                return $q->where('ot_schedule_slot_vw.schedule_dt', '>=', $from_date);
            })
            ->when($to_date != '', function ($q) use ($to_date) {
                return $q->where('ot_schedule_slot_vw.schedule_dt', '<=', $to_date);
            })
            ->select(
                'ot_schedule_slot_vw.ot_schedule_no_pk',
                'ot_schedule_slot_vw.schedule_dt',
                'ot_schedule_slot_vw.start_time',
                'ot_schedule_slot_vw.end_time',
                'ot_schedule_slot_vw.avg_duration',
                'ot_schedule_slot_vw.total_slot',
                DB::raw('count(hrms_schedule_dayoff.schedule_no_fk) schedule_count')
            )
            ->groupBy('ot_schedule_slot_vw.ot_schedule_no_pk', 'ot_schedule_slot_vw.schedule_dt', 'ot_schedule_slot_vw.start_time', 'ot_schedule_slot_vw.end_time', 'ot_schedule_slot_vw.avg_duration', 'ot_schedule_slot_vw.total_slot')
            ->orderBy('ot_schedule_slot_vw.schedule_dt')
            ->get();

        $returnHTML = view('admin.ot.ot_schedule.ot_schedule_for_status')->with('schedules', $schedules)->render();

        $arr = array('msg' => 'OT Schedule', 'status' => 'success', 'html' => $returnHTML);

        return response()->json($arr);
    }

    public function getAvailableAndBookCount($date, $ot_shedule_id)
    {
        $she_dt = date('Y-m-d', strtotime($date));

        $counts = DB::table('OT_SCHEDULE_SLOT')
            ->selectRaw("
            SUM(CASE WHEN AVAILABLE_IND = 1 THEN 1 ELSE 0 END) as available_count,
            SUM(CASE WHEN AVAILABLE_IND = 0 THEN 1 ELSE 0 END) as booked_count
        ")
            ->where('SCHEDULE_DT', $she_dt)
            ->where('OT_SCHEDULE_NO_FK', $ot_shedule_id)
            ->first();
        return [
            'available' => $counts->available_count,
            'booked' => $counts->booked_count,
        ];
    }


    public function getOtSlotForStatus($id)
    {
        $slot_details = DB::table('OT_SCHEDULE_SLOT as slot')
            ->leftJoin('opt_ot_reqlist_wl_vw as reqlist', 'slot.PATIENT_NO_FK', '=', 'reqlist.PATIENT_NO_FK')
            ->leftJoin('opt_prescribed_ot ot', 'slot.OT_REQ_NO_PK', 'opt_ot_reqlist_wl_vw.OT_REQ_NO_PK')
            ->select(
                'slot.OT_SLOT_NO_PK',
                'slot.SLOT_SL',
                'slot.AVAILABLE_IND',
                'ot.ot_book_ind',
                'slot.SCHEDULE_DT',
                'slot.BLOCK_DATE',
                'slot.END_TIME',
                'slot.START_TIME',
                'reqlist.PATIENT_NAME',
                'reqlist.ADMISSION_UID',
                'reqlist.ITEM_NAME'
            )
            ->where('slot.OT_SCHEDULE_NO_FK', $id)
            ->groupBy(
                'slot.OT_SLOT_NO_PK',
                'slot.SLOT_SL',
                'slot.AVAILABLE_IND',
                'ot.ot_book_ind',
                'slot.SCHEDULE_DT',
                'slot.BLOCK_DATE',
                'slot.END_TIME',
                'slot.START_TIME',
                'reqlist.PATIENT_NAME',
                'reqlist.ADMISSION_UID',
                'reqlist.ITEM_NAME'
            )
            ->orderBy('slot.START_TIME', 'asc')
            ->get();


        return Template::loadview("admin.ot.ot_schedule.ot_slot_for_status", [
            'slot_details' => $slot_details
        ]);
    }



    public function otManagerRequisition(Request $request, $req_id = '')
    {

        // $specialization = $this->getLookupListByCode("DOCSPL");
        $hospital = DB::table('wsec_hospital')->where('HOSPITAL_NO_PK', Session::get('user.ses_hospital_no_pk'))->get();

        $today_id = date('Y-m-d');
        //This block for showing today all doctor.
        $specialization_lookup_no_fk = '';
        $schedule = [];
        $total_app_count = '';
        $patient_details_info = '';
        $prescription_no_fk = '';

        if ($req_id != '') {
            $patient_details_info = DB::table('ot_requisition_list_vw')
                ->select('patient_name', 'reff_date', 'prescription_no_fk', 'admission_date', 'patient_photo', 'ward_name', 'bed_name', 'gender_txt', 'admitted_department', 'diagnosis', 'purpose_off_reff', 'user_name', 'surgen_name', 'req_given_date')
                ->where('OT_REQ_NO_FK', $req_id)
                ->first();
            $prescription_no_fk = $patient_details_info->prescription_no_fk;
        }


        if (isset($request->schedule_no_fk)) {

            $specialization_lookup_no_fk = $request->specialization_lookup_no_fk;
            $schedule_info = DB::table('hrms_schedule')->where('schedule_no_pk', $request->schedule_no_fk)->first();
            $today_id = isset($schedule_info->schedule_dt) ? date('Y-m-d', strtotime($schedule_info->schedule_dt)) : '';

            $query = DB::table('doctor_info_vw d')
                ->join('hrms_schedule p', 'p.doctor_person_no_fk', 'd.person_no_pk')
                ->where(DB::raw("trunc(p.schedule_dt)"), '=', date('Y-m-d', strtotime($today_id)));


            $query1 = DB::table('patn_app_count_vw d')
                ->select(DB::raw("sum(new_pat) new_pat,sum(app_patient) app_patient,sum(confirmed) confirmed  ,sum(chk) chk ,sum(can) can "))
                ->where(DB::raw("trunc(d.appoint_date)"), '=', date('Y-m-d', strtotime($today_id)));

            $room_info = DB::table('sysc_room')
                ->select('room_no_pk', 'room_name', 'room_code')
                ->where('ot_ind', 1)
                ->get();




            if (!empty($doctor_info)) {
                foreach ($doctor_info as $doctor) {
                    $schedule[$doctor->person_no_pk . '_' . $doctor->full_name . '_' . $doctor->schedule_dt] =
                        // DB::table('hrms_schedule_slot s')
                        // ->leftJoin('patn_v1_appointment_vw app', 's.slot_no_pk', 'app.slot_no_fk')
                        // ->leftJoin('sysc_lookupdata visit_type', 'visit_type.lookupdata_no_pk', 'app.visit_type')
                        // ->leftJoin('wsec_user', 'wsec_user.user_no_pk', 's.block_by')
                        // ->select('s.*', "app.patient_no_pk", "app.patient_name", "app.patient_code", "app.gender_txt", "app.patient_dob", "app.blood_group", "app.age", "app.mobile1", "app.appoint_type_code", "app.ccm_client_name", "app.case_type_name", "app.appoint_no_pk", "wsec_user.user_fullname", "app.calling_note","app.consult_ind","app.pres_ind","visit_type.lookupdata_code as visit_type_code")
                        // ->where('s.schedule_no_fk', $doctor->schedule_no_pk)
                        // ->orderBy('s.slot_no_pk', 'ASC')
                        // ->get();
                        DB::select("SELECT
                                S.*,
                                APP.PATIENT_NO_fK AS PATIENT_NO_pK,
                                app.CANCEL_IND,
                                APP.PATIENT_NAME,
                                reg.PATIENT_CODE,
                                reg.GENDER_TXT,
                                reg.dob AS PATIENT_DOB,
                                reg.BLOOD_GROUP,
                                pat_age(reg.dob, APPOINT_DATE) AS AGE,
                                reg.MOBILE1,
                                APP_TYPE.LOOKUPDATA_NAME AS APPOINT_TYPE_CODE,
                                visit_type.LOOKUPDATA_CODE AS visit_type_code,
                                CCM.CCM_CLIENT_NAME,
                                (SELECT x.LOOKUPDATA_NAME
                                FROM SYSC_LOOKUPDATA x
                                WHERE app.CASE_TYPE = x.LOOKUPDATA_NO_PK) AS CASE_TYPE_NAME,
                                APP.APPOINT_NO_PK,
                                WSEC_USER.USER_FULLNAME,
                                APP.CALLING_NOTE,
                                APP.CONSULT_IND,
                                (SELECT COUNT (*)
                                FROM PSN_T_PRESCRIPTION pres
                                WHERE pres.APPOINT_NO_FK = app.APPOINT_NO_pK
                                AND pres.DOCTOR_PERSON_NO_FK = app.DOCTOR_NO_FK) AS pres_ind
                            FROM
                                HRMS_SCHEDULE_SLOT S
                            LEFT JOIN
                                patn_appointment app ON S.SLOT_NO_PK = APP.SLOT_NO_FK AND NVL(app.CANCEL_IND, 0) = 0
                            LEFT JOIN
                                patn_registration reg ON APP.PATIENT_NO_fK = reg.PATIENT_NO_PK
                            LEFT JOIN
                                CCM_CORPORATECLIENT CCM ON REG.CCM_CLIENT_NO_FK = CCM.CCM_CLIENT_NO_PK
                            LEFT JOIN
                                SYSC_LOOKUPDATA APP_TYPE ON app.APPOINT_TYPE = APP_TYPE.LOOKUPDATA_NO_PK
                            LEFT JOIN
                                SYSC_LOOKUPDATA visit_type ON app.VISIT_TYPE = visit_type.LOOKUPDATA_NO_PK
                            LEFT JOIN
                                WSEC_USER ON S.BLOCK_BY = WSEC_USER.USER_NO_PK
                            WHERE
                                S.SCHEDULE_NO_FK = $doctor->schedule_no_pk
                            ORDER BY
                                S.SLOT_NO_PK ASC");
                }
            }
            $total_app_count = $query1->groupBy('appoint_date')->first();
        }


        $room_data = DB::table('sysc_room')->select('room_no_pk', 'room_name', 'room_code')->where('ot_ind', 1)->get();
        return Template::loadView("admin.prescription.uhl.ot_appointment", [
            'room_data' => $room_data,
            'hospital' => $hospital,
            'schedule' => $schedule,
            'total_app_count' => $total_app_count,
            'specialization_lookup_no_fk' => $specialization_lookup_no_fk,
            'today_id' => $today_id,
            'req_id' => $req_id,
            'prescription_no_fk' => $prescription_no_fk,
            'patient_details_info' => $patient_details_info,
        ]);
    }


    public function getRoomDataByDoctorDate(Request $request)
    {
        $req_id = $request->req_id;
        $today_id = $request->today ? $request->today : "";
        $room_no = $request->room_no ? $request->room_no : "";

        $tommorow_id = $request->tomorrow ? date('Y-m-d', strtotime($request->tomorrow . "+1 days")) : "";
        $date = $request->appoint_dt;
        $prescription_no_fk = null;

        $record = DB::table('OPD_REFF_ANESTHESIA_DEPT')
            ->select('prescription_no_fk')
            ->where('ot_req_no_fk', $req_id)
            ->first();

        if ($record && $record->prescription_no_fk) {
            $prescription_no_fk = $record->prescription_no_fk;
        }
        $query = DB::table('ot_schedule_slot_vw')
            ->leftjoin('hrms_schedule_dayoff', 'hrms_schedule_dayoff.schedule_no_fk', 'ot_schedule_slot_vw.ot_schedule_no_pk')
            ->leftjoin('SYSC_ROOM', 'ot_schedule_slot_vw.ot_room_no_fk', 'SYSC_ROOM.room_no_pk');

        if (!empty($room_no)) {

            $query->where('ot_schedule_slot_vw.ot_room_no_fk', $room_no);
        }
        if (!empty($date)) {

            $query->where(DB::raw("trunc(ot_schedule_slot_vw.schedule_dt)"), '=', date('Y-m-d', strtotime($date)));
        }
        if (!empty($tommorow_id)) {
            $query->where(DB::raw("trunc(ot_schedule_slot_vw.schedule_dt)"), '=', $tommorow_id);
        }
        if (!empty($today_id)) {

            $query->where(DB::raw("trunc(ot_schedule_slot_vw.schedule_dt)"), '=', date('Y-m-d', strtotime($today_id)));
        }
        $room_info = $query
            // ->where('d.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->select(
                'ot_schedule_slot_vw.ot_schedule_no_pk',
                'ot_schedule_slot_vw.schedule_dt',
                'ot_schedule_slot_vw.start_time',
                'SYSC_ROOM.room_name',
                'SYSC_ROOM.room_no_pk',
                'ot_schedule_slot_vw.end_time',
                'ot_schedule_slot_vw.avg_duration',
                'ot_schedule_slot_vw.total_slot',
            )
            ->orderby('SYSC_ROOM.room_name', 'asc')
            ->get()
            ->toArray();
        $schedule = [];
        if (!empty($room_info)) {

            foreach ($room_info as $room) {

                $dateFormatted = date('Y-m-d', strtotime($date));
                $schedule_dt = date('Y-m-d', strtotime($date));
                $today_date = date('Y-m-d', strtotime($today_id));
                // dd($dateFormatted,$room->schedule_dt,date('Y-m-d', strtotime($today_id)));
                $scheduleKey = $room->room_no_pk . '_' . $room->room_name . '_' . $room->schedule_dt;

                $schedule[$scheduleKey] = DB::table('OT_SCHEDULE_SLOT as slot')
                    ->leftJoin('opt_ot_reqlist_wl_vw as reqlist', 'slot.OT_REQ_NO_fK', '=', 'reqlist.OT_REQ_NO_PK')
                    ->leftJoin('opt_prescribed_ot ot', 'ot.OT_REQ_NO_PK', 'reqlist.OT_REQ_NO_PK')
                    ->leftJoin('sysc_room as room', 'slot.OT_ROOM_NO_FK', '=', 'room.room_no_pk')
                    ->select(
                        'slot.ot_slot_no_pk',
                        'slot.SLOT_SL',
                        'slot.available_ind',
                        'ot.ot_book_ind',
                        'slot.SCHEDULE_DT',
                        'room.room_name',
                        'reqlist.PATIENT_CODE',
                        'slot.BLOCK_DATE',
                        'slot.OT_ROOM_NO_FK',
                        'slot.END_TIME',
                        'slot.ot_status_ind',
                        'slot.START_TIME',
                        'reqlist.PATIENT_NAME',
                        'reqlist.ot_req_no_pk',
                        'reqlist.ADMISSION_NO_FK',
                        'reqlist.patient_no_fk',
                        'reqlist.ADMISSION_UID',
                        'reqlist.OT_COMFIRMATION_IND',
                        'reqlist.ITEM_NAME',
                        DB::raw("CASE WHEN slot.ACTIVE_STATUS = 2 THEN 'Blocked' ELSE 'Available' END AS status"),
                        DB::raw("CASE WHEN reqlist.ADMISSION_NO_FK IS NOT NULL THEN 'IPD' ELSE 'OPD' END AS appoint_type_code")
                    )
                    ->where('slot.SCHEDULE_DT', $today_id)
                    ->where('slot.ot_room_no_fk', $room->room_no_pk)
                    ->groupBy(
                        'slot.OT_SLOT_NO_PK',
                        'slot.SLOT_SL',
                        'slot.AVAILABLE_IND',
                        'ot.ot_book_ind',
                        'slot.ot_status_ind',
                        'slot.SCHEDULE_DT',
                        'slot.BLOCK_DATE',
                        'room.room_name',
                        'reqlist.patient_code',
                        'slot.END_TIME',
                        'slot.START_TIME',
                        'slot.OT_ROOM_NO_FK',
                        'reqlist.ot_req_no_pk',
                        'reqlist.patient_no_fk',
                        'reqlist.PATIENT_NAME',
                        'reqlist.ADMISSION_UID',
                        'reqlist.ADMISSION_NO_FK',
                        'reqlist.ot_comfirmation_ind',
                        'reqlist.ITEM_NAME',
                        'slot.ACTIVE_STATUS' // for CASE status
                    )
                    ->orderBy('slot.START_TIME', 'asc')
                    ->get();

                // }
            }
        }
        $query = DB::table('OT_SCHEDULE_SLOT as slot')
            ->leftJoin('OPT_PRESCRIBED_OT as ot', 'slot.OT_REQ_NO_FK', '=', 'ot.OT_REQ_NO_PK')
            ->selectRaw("
                  SUM(CASE WHEN NVL(slot.AVAILABLE_IND, 0) = 1 THEN 1 ELSE 0 END) AS available_count,
                    SUM(CASE WHEN NVL(ot.OT_BOOK_IND, 0) = 1 THEN 1 ELSE 0 END) AS booked_count,
                    SUM(CASE WHEN NVL(ot.REJECT_IND, 0) = 1 THEN 1 ELSE 0 END) AS cancel_count,
                    (COUNT(slot.OT_SLOT_NO_PK)
                    - SUM(CASE WHEN NVL(slot.AVAILABLE_IND,0)=1 THEN 1 ELSE 0 END)
                    - SUM(CASE WHEN NVL(ot.REJECT_IND,0)=1 THEN 1 ELSE 0 END)
                    -  SUM(CASE WHEN NVL(ot.OT_BOOK_IND, 0) = 1 THEN 1 ELSE 0 END)
                    ) AS pending_count,
                    COUNT(slot.OT_SLOT_NO_PK) AS total_count
             ")
            ->where('slot.SCHEDULE_DT', $today_id);

        if (!empty($room_no)) {
            $query->where('slot.OT_ROOM_NO_FK', $room_no);
        }
        $total_app_count = $query->first();

        return Template::loadView('admin.prescription.uhl.ot_slots_list', [
            'schedule' => $schedule,
            'req_id' => $req_id,
            'prescription_no_fk' => $prescription_no_fk,
            'total_app_count' => $total_app_count,
        ]);
    }

    public function getOtAppointmentList(Request $request)
    {
        if ($request->appointment_type == 'APPOINTMENT') {
            $query = DB::table('OT_SCHEDULE_SLOT as slot')
                ->leftJoin('opt_ot_reqlist_wl_vw as reqlist', 'slot.PATIENT_NO_FK', '=', 'reqlist.PATIENT_NO_FK')
                ->leftJoin('opt_prescribed_ot ot', 'ot.OT_REQ_NO_PK', 'reqlist.OT_REQ_NO_PK')
                ->select(
                    'slot.OT_SLOT_NO_PK',
                    'slot.SLOT_SL',
                    'slot.AVAILABLE_IND',
                    'slot.SCHEDULE_DT',
                    'slot.BLOCK_DATE',
                    'slot.END_TIME',
                    'slot.START_TIME',
                    'reqlist.PATIENT_NAME',
                    'reqlist.ADMISSION_UID',
                    'reqlist.ITEM_NAME'
                );
            if (isset($request->today)) {
                $query->where('slot.SCHEDULE_DT', date('Y-m-d', strtotime($request->today)));
            }

            $slot_details = $query
                ->where('ot.ot_book_ind', 1)
                ->groupBy(
                    'slot.OT_SLOT_NO_PK',
                    'slot.SLOT_SL',
                    'slot.AVAILABLE_IND',
                    'slot.SCHEDULE_DT',
                    'slot.BLOCK_DATE',
                    'slot.END_TIME',
                    'slot.START_TIME',
                    'reqlist.PATIENT_NAME',
                    'reqlist.ADMISSION_UID',
                    'reqlist.ITEM_NAME'
                )
                ->orderBy('slot.START_TIME', 'asc')
                ->get();
            return Template::loadView('admin.prescription.uhl.appointment_list', [
                'appointment_list' => $slot_details,
            ]);
        }

        if ($request->appointment_type == 'CANCEL') {
            $query = DB::table('OT_SCHEDULE_SLOT as slot')
                ->leftJoin('opt_ot_reqlist_wl_vw as reqlist', 'slot.PATIENT_NO_FK', '=', 'reqlist.PATIENT_NO_FK')
                ->select(
                    'slot.OT_SLOT_NO_PK',
                    'slot.SLOT_SL',
                    'slot.AVAILABLE_IND',
                    'slot.SCHEDULE_DT',
                    'slot.BLOCK_DATE',
                    'slot.END_TIME',
                    'slot.START_TIME',
                    'reqlist.PATIENT_NAME',
                    'reqlist.ADMISSION_UID',
                    'reqlist.ITEM_NAME'
                );
            if (isset($request->today)) {
                $query->where('slot.SCHEDULE_DT', date('Y-m-d', strtotime($request->today)));
            }

            $slot_details = $query
                ->where('reqlist.REJECT_IND', 1)
                ->groupBy(
                    'slot.OT_SLOT_NO_PK',
                    'slot.SLOT_SL',
                    'slot.AVAILABLE_IND',
                    'slot.SCHEDULE_DT',
                    'slot.BLOCK_DATE',
                    'slot.END_TIME',
                    'slot.START_TIME',
                    'reqlist.PATIENT_NAME',
                    'reqlist.ADMISSION_UID',
                    'reqlist.ITEM_NAME'
                )
                ->orderBy('slot.START_TIME', 'asc')
                ->get();
            return Template::loadView('admin.prescription.uhl.cancel_list', [
                'appointment_list' => $slot_details,
            ]);
        }
        if ($request->appointment_type == 'BLOCK') {
            // appointment_list
            $query = DB::table('hrms_schedule_slot')
                ->join('wsec_user', 'wsec_user.user_no_pk', 'hrms_schedule_slot.block_by')
                ->join('doctor_info_vw', 'doctor_info_vw.person_no_pk', 'hrms_schedule_slot.doctor_person_no_fk')
                ->where('block_ind', 1);
            //->where('hrms_schedule_slot.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk')); //
            if (isset($request->specialization_id)) {
                $query->where('doctor_info_vw.specialization_lookup_no_fk', $request->specialization_id);
            }
            if (isset($request->today)) {
                $query->where('hrms_schedule_slot.schedule_dt', date('Y-m-d', strtotime($request->today)));
            }
            $appointment_list = $query->get();
            return Template::loadView('admin.uhl.appointment.block_list', [
                'appointment_list' => $appointment_list,
            ]);
        }
        if ($request->appointment_type == 'REQUISITION') {
            // appointment_list
            $query = DB::table('OT_SCHEDULE_SLOT as slot')
                ->leftJoin('opt_ot_reqlist_wl_vw as reqlist', 'slot.PATIENT_NO_FK', '=', 'reqlist.PATIENT_NO_FK')
                ->leftJoin('opt_prescribed_ot ot', 'ot.OT_REQ_NO_PK', 'reqlist.OT_REQ_NO_PK')
                ->select(
                    'slot.OT_SLOT_NO_PK',
                    'slot.SLOT_SL',
                    'slot.AVAILABLE_IND',
                    'slot.SCHEDULE_DT',
                    'slot.BLOCK_DATE',
                    'slot.END_TIME',
                    'slot.START_TIME',
                    'reqlist.PATIENT_NAME',
                    'reqlist.ADMISSION_UID',
                    'reqlist.ITEM_NAME'
                );
            if (isset($request->today)) {
                $query->where('slot.SCHEDULE_DT', date('Y-m-d', strtotime($request->today)));
            }

            $slot_details = $query
                ->whereNull('reqlist.REJECT_IND')
                // ->where('reqlist.ot_comfirmation_ind', 1)
                ->whereNull('ot.ot_book_ind')
                ->whereNotNull('reqlist.OT_REQ_NO_PK')
                ->groupBy(
                    'slot.OT_SLOT_NO_PK',
                    'slot.SLOT_SL',
                    'slot.AVAILABLE_IND',
                    'slot.SCHEDULE_DT',
                    'slot.BLOCK_DATE',
                    'slot.END_TIME',
                    'slot.START_TIME',
                    'reqlist.PATIENT_NAME',
                    'reqlist.ADMISSION_UID',
                    'reqlist.ITEM_NAME'
                )
                ->orderBy('slot.START_TIME', 'asc')
                ->get();
            return Template::loadView('admin.prescription.uhl.requisition_list', [
                'appointment_list' => $slot_details,
            ]);
        }
    }

    public function requisitionDetailsForm($otSlotId)
    {
        $query = DB::table('OT_SCHEDULE_SLOT as slot')
            ->leftJoin('opt_ot_reqlist_wl_vw as reqlist', 'slot.PATIENT_NO_FK', '=', 'reqlist.PATIENT_NO_FK')
            ->select(
                'slot.OT_SLOT_NO_PK',
                'slot.SLOT_SL',
                'slot.AVAILABLE_IND',
                'slot.SCHEDULE_DT',
                'slot.BLOCK_DATE',
                'slot.END_TIME',
                'slot.START_TIME',
                'reqlist.PATIENT_NAME',
                'reqlist.ADMISSION_UID',
                'reqlist.PATIENT_CODE',
                'reqlist.OT_REQ_NO_PK',
                'reqlist.ITEM_NAME'
            );

        $slot_details = $query
            ->whereNull('reqlist.REJECT_IND')
            ->where('reqlist.REJECT_IND')
            ->where('slot.OT_SLOT_NO_PK', $otSlotId)
            ->whereNotNull('reqlist.OT_REQ_NO_PK')
            ->groupBy(
                'slot.ot_slot_no_pk',
                'slot.SLOT_SL',
                'slot.AVAILABLE_IND',
                'slot.SCHEDULE_DT',
                'slot.BLOCK_DATE',
                'slot.END_TIME',
                'slot.START_TIME',
                'reqlist.PATIENT_NAME',
                'reqlist.admission_uid',
                'reqlist.PATIENT_CODE',
                'reqlist.OT_REQ_NO_PK',
                'reqlist.ITEM_NAME'
            )
            ->first();

        $findAdmissionData = DB::table('opt_ot_reqlist_wl_vw')
            ->select(
                'opt_ot_reqlist_wl_vw.admission_uid',
                'opt_ot_reqlist_wl_vw.admission_no_fk',
                'opt_ot_reqlist_wl_vw.ot_req_no_pk',
                'opt_ot_reqlist_wl_vw.patient_no_fk',
                'opt_ot_reqlist_wl_vw.ot_req_date',
                'opt_ot_reqlist_wl_vw.ot_comfirmation_ind',
                'opt_ot_reqlist_wl_vw.ot_comfirmation_time',
                'opt_ot_reqlist_wl_vw.patient_name',
                'opt_ot_reqlist_wl_vw.item_no_fk',
                'opt_ot_reqlist_wl_vw.item_name',
                'opt_ot_reqlist_wl_vw.ot_comfirmation_doc_name',
                'opt_ot_reqlist_wl_vw.patient_code',
                'ipd_admitted_patlist_vw.new_serivce_unit_name',
                'ipd_admitted_patlist_vw.GENDER_TXT',
                'ipd_admitted_patlist_vw.AGE',
                'ipd_admitted_patlist_vw.WARD_NAME',
                'ipd_admitted_patlist_vw.BED_NAME',
                'ipd_admitted_patlist_vw.CONTACT_NUMBER',
                'ipd_admitted_patlist_vw.ACCOMPANIED_BY',
                'ipd_admitted_patlist_vw.PRIMARY_DOCTOR_NAME',
                'ipd_admitted_patlist_vw.PRIMARY_DOCTOR_NO_FK',
                'ot_schedule_slot.START_TIME',
                'ot_schedule_slot.END_TIME',
                'ot_schedule_slot.AVAILABLE_IND',
                'ot_schedule_slot.DOC_PERSON_NO_FK',
                'ot_schedule_slot.SCHEDULE_DT',
                'ot_schedule_slot.OT_ROOM_NO_FK',
                'sysc_room.room_name',
            )
            ->leftJoin('ipd_admitted_patlist_vw', 'ipd_admitted_patlist_vw.admission_no_pk', '=', 'opt_ot_reqlist_wl_vw.admission_no_fk')
            ->leftJoin('OT_SCHEDULE_SLOT', 'opt_ot_reqlist_wl_vw.OT_REQ_NO_PK', '=', 'OT_SCHEDULE_SLOT.OT_REQ_NO_FK')
            ->leftJoin('sysc_room', 'sysc_room.room_no_pk', '=', 'OT_SCHEDULE_SLOT.OT_ROOM_NO_FK')
            ->where('opt_ot_reqlist_wl_vw.OT_REQ_NO_PK', $slot_details->ot_req_no_pk)
            ->first();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        // dd($admission_pat);
        $title = $slot_details->admission_uid;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_admission_no = $barcode->generate();

        $title = $slot_details->patient_code;
        $pat_barcode = new BarcodeGenerator();
        $pat_barcode->setText($title);
        $pat_barcode->setType(BarcodeGenerator::Code128);
        $pat_barcode->setLabel('');
        $pat_barcode->setScale(1);
        $pat_barcode->setThickness(25);
        $pat_barcode->setFontSize(10);
        $barcode_pat_no = $pat_barcode->generate();
        return view("admin.uhl.appointment.ot_requisition_form", ['admission' => $findAdmissionData, 'slot_details' => $slot_details, 'barcode_admission_no' => $barcode_admission_no, 'po_hospital_details' => $po_hospital_details, 'barcode_pat_no' => $barcode_pat_no]);

        // $pdf = PDF::loadView("admin.uhl.appointment.ot_requisition_form", ['slot_details' => $slot_details, 'barcode_admission_no' => $barcode_admission_no, 'po_hospital_details' => $po_hospital_details, 'barcode_pat_no' => $barcode_pat_no])->setPaper('a5', 'landscape');
        // return $pdf->stream('Ipd Requisition Print.pdf');
    }


    public function updateStatusV2(Request $request)
    {
        // $request->validate([
        //     'ot_req_id' => 'required|integer',
        //     'status' => 'required|in:Confirm,Reject'
        // ]);

        // $otReq = OtRequisition::find($request->ot_req_id);
        $otReq = DB::table('opt_prescribed_ot')
            ->where('ot_req_no_pk', $request->ot_req_id)
            ->update([
                // 'anest_doc_person_no_fk' => $request->anest_name,
                'surg_doc_person_no_fk' => $request->surgeon_name,
                'ot_date' => date('Y-m-d H:i', strtotime($request->ot_date)),
                'ot_comfirmation_ind' => 1,
                'ot_comfirmation_time' => date("Y-m-d H:i"),
                'ot_time' => $request->ot_time != "" ? date('Y-m-d h:i', strtotime($request->ot_time)) : '',
                'surgeons_remark' => $request->surgeon_remarks,
                'diagnosis' => $request->diagnosis,
                'ot_comfirmation_doc_by' => Auth::id(),
                // 'admission_no_fk' => $request->hdn_admission_id,
                // 'anest_clearance_ind' => $request->ot_anest_clearance_ind,
                // 'anest_clearance_time' => date('Y-m-d', strtotime($request->clearance_date)),
                'anest_clearance_doc_by' => Auth::id(),
                'au_update_by' => Auth::id(),
                'au_update_at' => date('Y-m-d'),
                'au_update_session' => "SESSION",
                "au_update_hospital_no_fk" => Session::get('user.ses_hospital_no_pk'),
            ]);


        DB::commit();
        if (!$otReq) {
            return response()->json(['success' => false, 'message' => 'Requisition not found']);
        }

        // $otReq->status = $request->status;
        // $otReq->save();

        return response()->json(['success' => true]);
    }

    public function updateAdmissionStatusV2(Request $request)
    {
        $request->validate([
            'admissionId' => 'required|integer',
        ]);

        // $otReq = OtRequisition::find($request->ot_req_id);
        $otReq = DB::table('opt_prescribed_ot')
            ->where('ot_req_no_pk', $request->ot_req_id)
            ->update([
                'admission_no_fk' => $request->admissionId,
                'au_update_by' => Auth::id(),
                'au_update_at' => date('Y-m-d'),
                'au_update_session' => "SESSION",
                "au_update_hospital_no_fk" => Session::get('user.ses_hospital_no_pk'),
            ]);
        DB::commit();
        if (!$otReq) {
            return response()->json(['success' => false, 'message' => 'Admission Updated Successfully !']);
        }


        return response()->json(['success' => true]);
    }

    public function updateRunningStatusV2(Request $request)
    {
        $request->validate([
            'admissionId' => 'required|integer',
            'ot_req_id' => 'required|integer',
            'status' => 'required|string|in:START,END',
        ]);

        DB::beginTransaction();
        try {
            $record = DB::table('OT_SCHEDULE_SLOT')
                ->select('admission_no_fk')
                ->where('ot_req_no_fk', $request->ot_req_id)
                ->orderBy('ot_req_no_fk', 'desc')
                ->first();

            if (!$record) {
                return response()->json([
                    'success' => false,
                    'message' => 'No OT Schedule Slot found for given ot_req_id.'
                ], 404);
            }

            $admissionData = (int)$record->admission_no_fk;

            $update = ['OT_STATUS_IND' => ($request->status === 'START' ? 1 : 2)];

            if ($request->status === 'START') {
                $update['ot_starting_time'] = now();
            } else {
                $update['ot_ending_time'] = now();

                // DB::table('ot_complete_status')
                //     ->where('admission_no_fk', $admissionData)
                //     ->update([
                //         'ot_complete_ind' => 1,
                //     ]);
                $sequence = DB::getSequence();
                $ot_complete_status_no_pk_seq = $sequence->nextValue('ot_complete_status_no_pk_seq');

                // Insert the new OT complete status row
                DB::table('ot_complete_status')->insert([
                    'ot_complete_status_no_pk' => $ot_complete_status_no_pk_seq,
                    'ot_complete_ind' => 1,
                    'admission_no_fk' => $admissionData,
                    'au_entry_by' => 1, // You can replace with auth()->id() if using Auth
                    'au_entry_at' => now(),
                    'au_entry_session' => 'session',
                    'au_entry_hospital_pk_no' => 141,
                ]);

                DB::commit();
            }

            $affected = DB::table('OT_SCHEDULE_SLOT')
                ->where('ot_req_no_fk', $request->ot_req_id)
                ->update($update);

            if ($affected === 0) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'No rows updated—check the ot_req_no_fk value.'
                ], 404);
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function otBookingForm($reqid)
    {
        // dd(DB::table('opt_ot_reqlist_wl_vw')
        //         ->select(
        //             'opt_ot_reqlist_wl_vw.admission_uid',
        //             'opt_ot_reqlist_wl_vw.admission_no_fk',
        //             'opt_ot_reqlist_wl_vw.ot_req_no_pk',
        //             'opt_ot_reqlist_wl_vw.patient_no_fk',
        //             'opt_ot_reqlist_wl_vw.ot_req_date',
        //             'opt_ot_reqlist_wl_vw.ot_comfirmation_ind',
        //             'opt_ot_reqlist_wl_vw.ot_comfirmation_time',
        //             'opt_ot_reqlist_wl_vw.patient_name',
        //             'opt_ot_reqlist_wl_vw.item_no_fk',
        //             'opt_ot_reqlist_wl_vw.item_name',
        //             'opt_ot_reqlist_wl_vw.ot_comfirmation_doc_name',
        //             'opt_ot_reqlist_wl_vw.patient_code',
        //             'ipd_admitted_patlist_vw.new_serivce_unit_name',
        //             'ipd_admitted_patlist_vw.WARD_NAME',
        //             'ipd_admitted_patlist_vw.BED_NAME',
        //             'ipd_admitted_patlist_vw.CONTACT_NUMBER',
        //             'ipd_admitted_patlist_vw.ACCOMPANIED_BY',
        //             'ipd_admitted_patlist_vw.PRIMARY_DOCTOR_NAME',
        //             'ipd_admitted_patlist_vw.PRIMARY_DOCTOR_NO_FK',
        //             'ot_schedule_slot.START_TIME',
        //             'ot_schedule_slot.END_TIME',
        //             'ot_schedule_slot.AVAILABLE_IND',
        //             'ot_schedule_slot.DOC_PERSON_NO_FK',
        //             'ot_schedule_slot.SCHEDULE_DT',
        //             'ot_schedule_slot.OT_ROOM_NO_FK',
        //             'sysc_room.room_name',
        //         )
        //         ->leftJoin('ipd_admitted_patlist_vw', 'ipd_admitted_patlist_vw.admission_no_pk', '=', 'opt_ot_reqlist_wl_vw.admission_no_fk')
        //         ->leftJoin('OT_SCHEDULE_SLOT', 'opt_ot_reqlist_wl_vw.OT_REQ_NO_PK', '=', 'OT_SCHEDULE_SLOT.OT_REQ_NO_FK')
        //         ->leftJoin('sysc_room', 'sysc_room.room_no_pk', '=', 'OT_SCHEDULE_SLOT.OT_ROOM_NO_FK')
        //         ->where('opt_ot_reqlist_wl_vw.OT_REQ_NO_PK', $reqid)
        //         ->first());
        return Template::loadView('admin.prescription.uhl.ot_booking_form', [
            'anesthesiologists' => DB::table('hrms_personnel')->where('anaestesiologis_ind', 1)->get(['person_no_pk', 'full_name'])->toArray(),
            'surgeons' => DB::table('hrms_personnel')->where('surgeon_ind', 1)->get(['person_no_pk', 'full_name'])->toArray(),
            'selected_surgen' => DB::table('opt_prescribed_ot ot')->select('per.person_no_pk', 'per.full_name')->leftjoin('hrms_personnel per', 'ot.doc_person_no_fk', 'per.person_no_pk')->where('ot.ot_req_no_pk', $reqid)->first(),
            'selected_anes' => DB::table('opt_prescribed_ot ot')->select('per.person_no_pk', 'per.full_name', 'anest_clearance_time', 'anest_clearance_ind', 'bill_clearence_ind', 'pac_clearence_ind', 'diagnosis', 'surgeons_remark')->leftjoin('hrms_personnel per', 'ot.anest_doc_person_no_fk', 'per.person_no_pk')->where('ot.ot_req_no_pk', $reqid)->first(),
            'admissionDetails' => DB::table('opt_ot_reqlist_wl_vw')
                ->select(
                    'opt_ot_reqlist_wl_vw.admission_uid',
                    'opt_ot_reqlist_wl_vw.admission_no_fk',
                    'opt_ot_reqlist_wl_vw.ot_req_no_pk',
                    'opt_ot_reqlist_wl_vw.patient_no_fk',
                    'opt_ot_reqlist_wl_vw.ot_req_date',
                    'opt_ot_reqlist_wl_vw.ot_comfirmation_ind',
                    'opt_ot_reqlist_wl_vw.ot_comfirmation_time',
                    'opt_ot_reqlist_wl_vw.patient_name',
                    'opt_ot_reqlist_wl_vw.item_no_fk',
                    'opt_ot_reqlist_wl_vw.item_name',
                    'opt_ot_reqlist_wl_vw.ot_comfirmation_doc_name',
                    'opt_ot_reqlist_wl_vw.patient_code',
                    'ipd_admitted_patlist_vw.new_serivce_unit_name',
                    'ipd_admitted_patlist_vw.WARD_NAME',
                    'ipd_admitted_patlist_vw.BED_NAME',
                    'ipd_admitted_patlist_vw.CONTACT_NUMBER',
                    'ipd_admitted_patlist_vw.ACCOMPANIED_BY',
                    'ipd_admitted_patlist_vw.PRIMARY_DOCTOR_NAME',
                    'ipd_admitted_patlist_vw.PRIMARY_DOCTOR_NO_FK',
                    'ot_schedule_slot.START_TIME',
                    'ot_schedule_slot.END_TIME',
                    'ot_schedule_slot.AVAILABLE_IND',
                    'ot_schedule_slot.DOC_PERSON_NO_FK',
                    'ot_schedule_slot.SCHEDULE_DT',
                    'ot_schedule_slot.OT_ROOM_NO_FK',
                    'sysc_room.room_name',
                )
                ->leftJoin('ipd_admitted_patlist_vw', 'ipd_admitted_patlist_vw.admission_no_pk', '=', 'opt_ot_reqlist_wl_vw.admission_no_fk')
                ->leftJoin('OT_SCHEDULE_SLOT', 'opt_ot_reqlist_wl_vw.OT_REQ_NO_PK', '=', 'OT_SCHEDULE_SLOT.OT_REQ_NO_FK')
                ->leftJoin('sysc_room', 'sysc_room.room_no_pk', '=', 'OT_SCHEDULE_SLOT.OT_ROOM_NO_FK')
                ->where('opt_ot_reqlist_wl_vw.OT_REQ_NO_PK', $reqid)
                ->first(),
            'rooms' => DB::table('sysc_room as room')
                ->leftJoin('sysc_physicalstructfloor as floor', 'floor.PHYSICALSTRUCT_NO_PK', '=', 'room.PHYSICALSTRUCURE_NO_FK')
                ->leftJoin('sysc_serviceunit as unit', 'unit.SERVICEUNIT_NO_pK', '=', 'room.SERVICEUNIT_NO_FK')
                ->leftJoin('sysc_lookupdata as lookup', 'lookup.lookupdata_no_pk', '=', 'room.ROOM_CATEGORY_LOOKUP_NO_FK')
                ->leftJoin('sysc_physicalstructurebuilding as building', 'floor.PHYSICALSTRUCT_BUILDING_NO_PK', '=', 'building.PHYSICALSTRUCT_BUILD_NO_PK')
                ->select(
                    'room.room_no_pk',
                    'room.room_code',
                    'lookup.lookupdata_name as room_type',
                    'unit.serviceunit_name as department',
                    'building.PHYSICALSTRUCT_BUILD_NO_PK as building_id',
                    'building.physicalstruct_build_name as building_name',
                    'floor.physicalstruct_no_pk as floor_id',
                    'floor.PHYSICALSTRUCT_NAME as floor_name'
                )
                ->where('room.status', 1)
                ->where('room.ot_ind', 1)
                ->orderBy('room.room_name', 'ASC')
                ->get(),
            'surgeryRoles' => $this->getLookupListByCode('SURROLES'),
            'route' => $this->getPresLookupListByCode("ROUTE", "pres_lookupdata_name"),
            'duration_mu' => $this->getPresLookupListByCode("DURMU", "pres_lookupdata_name"),
            'instructions' => $this->getPresLookupListByCode("INSTRUCTION", "pres_lookupdata_name"),
            'dose' => $this->getPresLookupListByCode("DOSE", "pres_lookupdata_name"),
            'meddurmu' => $this->getPresLookupListByCode("DURMU", "pres_lookupdata_code"),
            'anestheyaRoles' => $this->getLookupListByCode('ANESROLES')

        ]);
    }

    public function findAdmissionDetails($patid)
    {
        $admission_details = DB::table('ipd_admission')
            ->select('admission_no_pk')
            ->where('dis_ind', 0)
            ->where('patient_no_fk', $patid)
            ->first();
        return $admission_details;
    }

    public function otBook(Request $request)
    {
        $medicineItems = $request->input('medicine_item');
        $medicineItemIds = $request->input('hdn_medicine_item_id_child');
        $reportSerials = $request->input('hdn_report_serial_med');
        $routes = $request->input('medicine_route');
        $doses = $request->input('medicine_dose');
        $durationTypes = $request->input('medicine_duration_type');
        $durationUnits = $request->input('medicine_duration_mu');
        $quantities = $request->input('medicine_quantity');
        $instructions = $request->input('instruction');

        $prescriptionItems = [];

        $length = is_array($medicineItems) ? count($medicineItems) : 0;

        for ($i = 0; $i < $length; $i++) {
            $prescriptionItems[] = [
                'medicine_item' => $medicineItems[$i] ?? null,
                'medicine_item_id' => $medicineItemIds[$i] ?? null,
                'report_serial' => $reportSerials[$i] ?? null,
                'route' => $routes[$i] ?? null,
                'dose' => $doses[$i] ?? null,
                'duration' => [
                    'value' => $durationTypes[$i] ?? null,
                    'unit' => $durationUnits[$i] ?? null,
                ],
                'quantity' => $quantities[$i] ?? null,
                'instruction' => $instructions[$i] ?? null,
            ];
        }

        // 👉 এখানে আমরা একটাই JSON ফিল্ডে এটি রূপান্তর করবো
        $prescriptionJson = json_encode($prescriptionItems);
        // dd($request->all(),$prescriptionJson);
        //    dd(json_encode($request->or_room));
        // Step 1: Main OT Booking Insert
        // $bookingId = DB::table('ot_booking')->insertGetId([
        //     'admission_no_fk' => $request->admission_no_fk,
        //     'primary_doctor_no_fk' => $request->primary_doctor_no_fk,
        //     'patient_no_fk' => $request->patient_no_fk,
        //     'item_no_fk' => $request->item_no_fk,
        //     'ot_room_no_fk' => $request->ot_room_no_fk,
        //     'uhid' => $request->uhid,
        //     'ip_no' => $request->ip_no,
        //     'ward_bed' => $request->ward_bed,
        //     'patient_name' => $request->patient_name,
        //     'booking_by' => $request->booking_by,
        //     'contact_no' => $request->contact_no,
        //     'surgery_date' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->surgery_date)->format('Y-m-d'),
        //     'item_name' => $request->item_name,
        //     'speciality' => $request->speciality,
        //     'ot_no' => $request->ot_no,
        //     'room_name' => $request->room_name,
        //     'primary_doctor' => $request->primary_doctor,
        //     'surgeon_name' => $request->surgeon_name,
        //     'anest_name' => $request->anest_name,
        //     'start_time' => $request->start_time,
        //     'end_time' => $request->end_time,
        //     'priority' => $request->priority,
        //     'status_display' => $request->status_display ?? 0,
        //     'status_done' => $request->status_done ?? 0,
        //     'status_cancel' => $request->status_cancel ?? 0,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // Insert Data using Query Builder

        $sequence = DB::getSequence();
        $ot_booking_no_pk_seq = $sequence->nextValue('ot_booking_no_pk_seq');
        $bookingId = DB::table('ot_booking_details')->insert([
            'ot_booking_no_pk' => $ot_booking_no_pk_seq,
            'ot_req_no_fk' => $request->ot_req_no_pk,
            'admission_no_fk' => $request->admission_no_fk,
            'primary_doctor_no_fk' => $request->primary_doctor_no_fk,
            'patient_no_fk' => $request->patient_no_fk,
            'item_no_fk' => $request->item_no_fk,
            'ot_room_no_fk' => $request->ot_room_no_fk,
            'speciality' => $request->speciality,
            'ot_no' => $request->ot_no,
            'room_name' => $request->room_name,
            'primary_doctor' => $request->primary_doctor,
            'surgeon_name' => $request->surgeon_name,
            'anest_name' => $request->anest_name,
            'priority' => $request->priority,
            'status_display' => $request->status_display ?? 0,

            // JSON Encode for CLOB fields
            'or_room_json' => json_encode($request->or_room),
            'surgery_team_json' => json_encode($request->surgery_team),
            'anesthesia_json' => json_encode($request->anesthesia),
            'indent_json' => json_encode($request->indent_products),
            'medicine_json' => $prescriptionJson,
            'preparation_note' => $request->preparation_note,
            'radiology_note' => $request->radiology_note,

            // Audit Fields
            // 'AU_ENTRY_BY' => 1,
            // 'AU_ENTRY_AT' => now(),
            // 'AU_ENTRY_SESSION' => session()->getId(),
            // 'AU_ENTRY_HOSPITAL_NO_FK' => session('user.ses_hospital_code') ?? null,
        ]);
        $data2 = [
            'OT_BOOK_TIME' => now(),
            'OT_BOOK_IND' => 1,
            'ot_comfirmation_ind' => number_format(1),
            'anest_clearance_ind' => number_format(1),
            'anest_doc_person_no_fk' => $request->anest_name,
            'surg_doc_person_no_fk' => $request->surgeon_name,
            'admission_no_fk' => (int) $request->admission_no_fk,
            'OT_BOOK_BY' => Auth::id()
        ];

        $ot_book = DB::table('opt_prescribed_ot')->where('OT_REQ_NO_PK', $request->ot_req_no_pk)->update($data2);

        // dd($ot_book);

        // $result = DB::table('opt_prescribed_ot')
        //     ->where('ot_req_no_pk', $request->ot_req_no_pk)
        //     ->update([
        //         'anest_doc_person_no_fk' => $request->anest_name,
        //         'surg_doc_person_no_fk' => $request->surgeon_name,
        //         // 'ot_date' => date('Y-m-d H:i', strtotime($request->ot_date)),
        //         // 'ot_comfirmation_ind' => 1,
        //         'ot_comfirmation_time' => date("Y-m-d H:i"),
        //         // 'ot_time' => $request->ot_time != "" ? date('Y-m-d h:i', strtotime($request->ot_time)) : '',
        //         // 'surgeons_remark' => $request->surgeon_remarks,
        //         // 'diagnosis' => $request->diagnosis,
        //         'ot_comfirmation_doc_by' => Auth::id(),
        //         'admission_no_fk' => $request->admission_no_fk,
        //         'anest_clearance_ind' => 1,
        //         'anest_clearance_time' => date('Y-m-d', strtotime($request->clearance_date)),
        //         'anest_clearance_doc_by' => Auth::id(),
        //         'au_update_by' => Auth::id(),
        //         'au_update_at' => date('Y-m-d'),
        //         'au_update_session' => "SESSION",
        //         "au_update_hospital_no_fk" => Session::get('user.ses_hospital_no_pk'),
        //     ]);
        DB::commit();
        return response()->json([
            'message' => 'Booking Saved Successfully',
            'print_url' => route('ot.booking.pdf', ['id' => $request->ot_req_no_pk]),
        ]);
    }

    public function downloadPdfOtForm($id)
    {
        // dd($id);
        // Step 1: Master Booking
        $booking = DB::table('ot_booking_details')
            ->select('ot_booking_details.*', 'ser.full_name as surgeon', 'ans.full_name as anest')
            ->leftJoin('hrms_personnel ser', 'ot_booking_details.surgeon_name', 'ser.person_no_pk')
            ->leftJoin('hrms_personnel ans', 'ot_booking_details.anest_name', 'ans.person_no_pk')
            ->where('ot_req_no_fk', $id)->first();

        $findAdmissionData = DB::table('opt_ot_reqlist_wl_vw')
            ->select(
                'opt_ot_reqlist_wl_vw.admission_uid',
                'opt_ot_reqlist_wl_vw.admission_no_fk',
                'opt_ot_reqlist_wl_vw.ot_req_no_pk',
                'opt_ot_reqlist_wl_vw.patient_no_fk',
                'opt_ot_reqlist_wl_vw.ot_req_date',
                'opt_ot_reqlist_wl_vw.ot_comfirmation_ind',
                'opt_ot_reqlist_wl_vw.ot_comfirmation_time',
                'opt_ot_reqlist_wl_vw.patient_name',
                'opt_ot_reqlist_wl_vw.item_no_fk',
                'opt_ot_reqlist_wl_vw.item_name',
                'opt_ot_reqlist_wl_vw.ot_comfirmation_doc_name',
                'opt_ot_reqlist_wl_vw.patient_code',
                'ipd_admitted_patlist_vw.new_serivce_unit_name',
                'ipd_admitted_patlist_vw.GENDER_TXT',
                'ipd_admitted_patlist_vw.AGE',
                'ipd_admitted_patlist_vw.WARD_NAME',
                'ipd_admitted_patlist_vw.BED_NAME',
                'ipd_admitted_patlist_vw.CONTACT_NUMBER',
                'ipd_admitted_patlist_vw.ACCOMPANIED_BY',
                'ipd_admitted_patlist_vw.PRIMARY_DOCTOR_NAME',
                'ipd_admitted_patlist_vw.PRIMARY_DOCTOR_NO_FK',
                'ot_schedule_slot.START_TIME',
                'ot_schedule_slot.END_TIME',
                'ot_schedule_slot.AVAILABLE_IND',
                'ot_schedule_slot.DOC_PERSON_NO_FK',
                'ot_schedule_slot.SCHEDULE_DT',
                'ot_schedule_slot.OT_ROOM_NO_FK',
                'sysc_room.room_name',
            )
            ->leftJoin('ipd_admitted_patlist_vw', 'ipd_admitted_patlist_vw.admission_no_pk', '=', 'opt_ot_reqlist_wl_vw.admission_no_fk')
            ->leftJoin('OT_SCHEDULE_SLOT', 'opt_ot_reqlist_wl_vw.OT_REQ_NO_PK', '=', 'OT_SCHEDULE_SLOT.OT_REQ_NO_FK')
            ->leftJoin('sysc_room', 'sysc_room.room_no_pk', '=', 'OT_SCHEDULE_SLOT.OT_ROOM_NO_FK')
            ->where('opt_ot_reqlist_wl_vw.OT_REQ_NO_PK', $id)
            ->first();


        if (!$booking) {
            abort(404, 'OT Booking not found');
        }

        // Step 2: Decode JSON columns (if they exist)
        $or_room = json_decode($booking->or_room_json ?? '[]', true);
        $surgery_team = json_decode($booking->surgery_team_json ?? '[]', true);
        $anesthesia = json_decode($booking->anesthesia_json ?? '[]', true);
        $medicine = json_decode($booking->medicine_json ?? '[]', true);
        $indent = json_decode($booking->indent_json ?? '[]', true);

        // Step 3: Prepare variables with fallback using null coalescing
        $data = [
            'uhid' => $findAdmissionData->patient_no_fk ?? '',
            'ip_no' => $findAdmissionData->admission_uid ?? '',
            'ward_bed' => $findAdmissionData->ward_name . '/' . $findAdmissionData->bed_name, // you can fetch from admission table if needed
            'patient_name' => $findAdmissionData->patient_name ?? '',
            'gender_txt' => $findAdmissionData->gender_txt ?? '',
            'age' => $findAdmissionData->age ?? '',

            'booking_by' => $findAdmissionData->accompanied_by ?? '',
            'contact_no' => $findAdmissionData->contact_number ?? '',

            'surgery_date' => $findAdmissionData->schedule_dt ?? '',
            'item_name' => $findAdmissionData->item_name ?? '',
            'speciality' => $booking->speciality ?? '',
            'ot_no' => $booking->ot_no ?? '',
            'room_name' => $findAdmissionData->room_name ?? '',
            'primary_doctor' => $findAdmissionData->primary_doctor_name ?? '',
            'surgeon_name' => $booking->surgeon ?? '',
            'anest_name' => $booking->anest ?? '',
            'start_time' => $findAdmissionData->start_time ?? '',
            'end_time' => $findAdmissionData->end_time ?? '',
            'priority' => $booking->priority ?? 'Normal',

            'status_display' => $booking->status_display ?? 0,
            'status_done' => $booking->status_done ?? 0,
            'status_cancel' => $booking->status_cancel ?? 0,


            'or_room' => $or_room,
            'surgery_team' => $surgery_team,
            'anesthesia' => $anesthesia,
            'medicine' => $medicine,
            'indent' => $indent,

            'preparation_note' => $booking->preparation_note ?? '',
            'radiology_note' => $booking->radiology_note ?? '',
        ];

        return view('admin.prescription.uhl.ot_form_uhl', $data);
        // Step 4: Generate PDF
        // $pdf = Pdf::loadView('admin.prescription.uhl.ot_form_uhl', $data)->setPaper('A4', 'portrait');
        // return $pdf->download('ot_booking_' . $booking->ot_booking_no_pk . '.pdf');
    }

    public function getRoomDetails(Request $request)
    {
        $roomId = $request->room_id;

        // $room = DB::table('sysc_room as room')
        //     ->leftJoin('sysc_physicalstructfloor as floor', 'floor.PHYSICALSTRUCT_NO_PK', '=', 'room.PHYSICALSTRUCURE_NO_FK')
        //     ->leftJoin('sysc_physicalstructurebuilding as building', 'floor.PHYSICALSTRUCT_BUILDING_NO_PK', '=', 'building.PHYSICALSTRUCT_BUILD_NO_PK')
        //     ->where('room.room_no_pk', $roomId)
        //     ->select([
        //         'room.room_type',
        //         'room.department',
        //         'building.physicalstruct_build_name as building_name',
        //         'floor.physicalstruct_name as floor_name'
        //     ])
        //     ->first();



        $room = DB::table('sysc_room as room')
            ->leftJoin('sysc_physicalstructfloor as floor', 'floor.PHYSICALSTRUCT_NO_PK', '=', 'room.PHYSICALSTRUCURE_NO_FK')
            ->leftJoin('sysc_serviceunit as unit', 'unit.SERVICEUNIT_NO_pK', '=', 'room.SERVICEUNIT_NO_FK')
            ->leftJoin('sysc_lookupdata as lookup', 'lookup.lookupdata_no_pk', '=', 'room.ROOM_CATEGORY_LOOKUP_NO_FK')
            ->leftJoin('sysc_physicalstructurebuilding as building', 'floor.PHYSICALSTRUCT_BUILDING_NO_FK', '=', 'building.PHYSICALSTRUCT_BUILD_NO_PK')
            ->select(
                'room.room_no_pk',
                'room.room_code',
                'lookup.lookupdata_name as room_type',
                'unit.serviceunit_name as department',
                'building.PHYSICALSTRUCT_BUILD_NO_PK as building_id',
                'building.physicalstruct_build_name as building_name',
                'floor.physicalstruct_no_pk as floor_id',
                'floor.PHYSICALSTRUCT_NAME as floor_name'
            )
            ->where('room.room_no_pk', $roomId)
            ->where('room.status', 1)
            ->where('room.ot_ind', 1)
            ->first();

        if (!$room) {
            return response()->json(['error' => 'Room not found'], 404);
        }

        return response()->json($room);
    }

    public function getOTCheckData(int $admissionNo): ?bool
    {
        // Step 1: Check if any related admission exists in schedule or prescribed tables
        // Subquery to grab only the latest request number
        $subquery = DB::table('ot_schedule_slot')
            ->select('ot_req_no_fk')
            ->where('admission_no_fk', $admissionNo)
            ->where('available_ind', 1)
            ->orderByDesc('ot_req_no_fk')
            ->limit(1);

        // Now check if that row exists with your other filters
        $hasPending = DB::table('ot_schedule_slot as oss')
            ->leftJoin('opt_prescribed_ot as opt', 'oss.admission_no_fk', '=', 'opt.admission_no_fk')
            ->where('oss.admission_no_fk', $admissionNo)
            // ->whereColumn('oss.ot_req_no_fk', '=', $subquery)
            ->where('oss.available_ind', 1)
            ->where('oss.ot_status_ind', '<>', 1)
            ->where('opt.OT_COMFIRMATION_IND', '<>', 1)
            ->exists();


        return $hasPending;
    }

    public function pacList()
    {
        $requestDepts = DB::table('sysc_serviceunit')
            ->where('ipd_ind', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get(['serviceunit_name', 'serviceunit_no_pk']);
        return Template::loadView('admin.ot.aneasthea.pac_list', [
            'requestDepts' => $requestDepts,
        ]);
    }
    public function otRequisitionList()
    {
        $requestDepts = DB::table('sysc_serviceunit')
            ->where('ipd_ind', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get(['serviceunit_name', 'serviceunit_no_pk']);
        return Template::loadView('admin.ot.aneasthea.ot_requisition_list', [
            'requestDepts' => $requestDepts,
        ]);
    }

    public function data(Request $request)
    {
        $query = Ref::select([
            'REFF_ANES_DEPT_NO_PK',
            'PATIENT_NO_FK',
            'APPOINT_NO_FK',
            'PRESCRIPTION_NO_FK',
            'REFF_DOC_NO_FK',
            'PATIENT_TYPE',
            'PURPOSE_OFF_REFF',
            'DIAGNOSIS',
            'RESULT_OF_INV_NOTE',
            'PLANE_PROC_WITHDATE',
            'REFF_DATE',
            'ESTIMATED_DURATION_SURGE',
            'SPECEFIC_REQ_N_REMARKS',
            'STATUS'
        ]);

        return DataTables::of($query)
            ->make(true);
    }

    public function pacListData(Request $request)
    {
        $table = 'anes_refered_vw';
        $primaryKey = 'reff_anes_dept_no_pk';

        // Input Parameters
        $service_number = $request->input('service_number');
        $doc_id = $request->input('doc_id');
        $from_date = $request->input('admission_date_from');
        $to_date = $request->input('admission_date_to');
        $status_filter = $request->input('status_filter'); // Add this line
        // Convert date to Y-m-d if provided
        function formatDate($dateStr)
        {
            return \Carbon\Carbon::createFromFormat('d-m-Y', $dateStr)->format('Y-m-d');
        }

        // Prepare where clause
        $where = "1 = 1"; // Default where

        if ($from_date && $to_date) {
            $from = formatDate($from_date);
            $to = formatDate($to_date);
            $where .= " AND trunc(reff_date) BETWEEN TO_DATE('$from', 'YYYY-MM-DD') AND TO_DATE('$to', 'YYYY-MM-DD')";
        } else {
            // Default: last 7 days
            $where .= " AND trunc(reff_date) BETWEEN trunc(SYSDATE-6) AND trunc(SYSDATE + 6)";
        }

        if (!empty($service_number)) {
            $where .= " AND patient_no_fk = '$service_number'";
        }
        if (!empty($doc_id)) {
            $where .= " AND reff_doc_no_fk = '$doc_id'";
        }
        if (!empty($status_filter)) {
            if ($status_filter == 'PENDING') {
                $where .= " AND (reply_type IS NULL OR TRIM(reply_type) = '')";
            } else {
                $where .= " AND UPPER(reply_type) = '" . strtoupper($status_filter) . "'";
            }
        }

        $columns = array(
            array('db' => 'rownumber', 'dt' => 0),
            array('db' => 'patient_code', 'dt' => 1),
            array('db' => 'patient_name', 'dt' => 2),
            array('db' => 'full_name', 'dt' => 3),
            array('db' => 'patient_type', 'dt' => 4),
            array('db' => 'purpose_off_reff', 'dt' => 5),
            array('db' => 'diagnosis', 'dt' => 6),
            array('db' => 'result_of_inv_note', 'dt' => 7),
            array('db' => 'plane_proc_withdate', 'dt' => 8),
            array('db' => 'reff_date', 'dt' => 9),
            array('db' => 'estimated_duration_surge', 'dt' => 10),
            array('db' => 'specefic_req_n_remarks', 'dt' => 11),
            array('db' => 'status', 'dt' => 12),
            array('db' => 'reff_anes_dept_no_pk', 'dt' => 13),
            array('db' => 'reply_type', 'dt' => 14),
            array('db' => 'andr_name', 'dt' => 15),
            array('db' => 'admission_no_fk', 'dt' => 16),
            array('db' => 'patient_no_fk', 'dt' => 17),
        );

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function pacAcceptPopup($pacId)
    {
        return Template::loadview("admin.ot.aneasthea.ot_accept_form", [
            'pac_data' => DB::table('ANES_REFERED_VW')
                ->where('REFF_ANES_DEPT_NO_PK', $pacId)
                ->first()
        ]);
    }
    public function otReplyForm(Request $request)
    {
        DB::beginTransaction();

        try {
            // Update OPD_REFF_ANESTHESIA_DEPT
            DB::table('OPD_REFF_ANESTHESIA_DEPT')
                ->where('REFF_ANES_DEPT_NO_PK', $request->reff_anes_dept_no_pk)
                ->update([
                    'REPLY_LETTER' => $request->replyMessage,
                    'REPLY_TYPE' => $request->type === 'DEFERRED' ? 'REJECT' : 'ACCEPT',
                    'ANESTH_DOC_NO_FK' => Session::get('user.ses_person_no_fk'),
                    'FEEDBACK_DATE' => date('Y-m-d'),
                ]);

            if ($request->type !== 'DEFERRED') {
                $prescription_no_fk = DB::table('opd_reff_anesthesia_dept')
                    ->where('reff_anes_dept_no_pk', (int) $request->reff_anes_dept_no_pk)
                    ->value('prescription_no_fk');
                if ($prescription_no_fk) {
                    DB::table('opt_prescribed_ot')
                        ->where('prescription_no_fk', (int) $prescription_no_fk)
                        ->update(['reff_anes_dept_no_fk' => $request->reff_anes_dept_no_pk]);
                }
            }

            DB::commit();



            $this->message = ['msg' => $request->type === 'DEFERRED' ? 'Rejected Successfully.' : 'Reply Successful.', 'title' => 'Success', 'id' => $request->reff_anes_dept_no_pk];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('otReplyForm failure: ' . $e->getMessage());
            $this->message = ['msg' => 'An error occurred, please try again.', 'title' => 'Error'];
        }

        return response()->json($this->message);
    }

    public function anaestheticRefferalReplyFormPdf(Request $request, $pacId)
    {
        $patient_info = DB::table('ANES_REFERED_VW as anes')
            ->leftJoin('patient_info_vw as pat', 'pat.PATIENT_NO_PK', '=', 'anes.patient_no_fk')
            ->select(
                'anes.*',
                'pat.DOB',
                'pat.DOD',
                'pat.GENDER_TXT',
                'pat.WEIGHT',
                DB::raw('pat_age(pat.dob, NVL(pat.dod, SYSDATE)) AS pat_age')
            )
            ->where('REFF_ANES_DEPT_NO_PK', $pacId)
            ->first();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        return View("admin.ot.aneasthea.aneastheia_referral_form", ['barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details, 'patient_info' => $patient_info]);
    }
    public function anaestheticRefferalReplyFormDocPdf(Request $request, $pacId)
    {
        $patient_info = DB::table('ANES_REFERED_VW as anes')
            ->leftJoin('patient_info_vw as pat', 'pat.PATIENT_NO_PK', '=', 'anes.patient_no_fk')
            ->select(
                'anes.*',
                'pat.DOB',
                'pat.DOD',
                'pat.GENDER_TXT',
                'pat.WEIGHT',
                DB::raw('pat_age(pat.dob, NVL(pat.dod, SYSDATE)) AS pat_age')
            )
            ->where('REFF_ANES_DEPT_NO_PK', $pacId)
            ->first();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        return View("admin.ot.aneasthea.aneastheia_referral_form_for_doc", ['barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details, 'patient_info' => $patient_info]);
    }

    public function pacdeferredPopup($pacId)
    {
        return Template::loadview("admin.ot.aneasthea.aneasthea_defered_form", [
            'pac_data' => DB::table('ANES_REFERED_VW')
                ->where('REFF_ANES_DEPT_NO_PK', $pacId)
                ->first()
        ]);
    }

    public function pacListDoc()
    {

        return Template::loadView('admin.ot.aneasthea.pac_list_doc');
    }

    public function anesthetiaDocList()
    {

        return Template::loadView('admin.ot.aneasthea.anesthetia_reffered_list');
    }
    public function otRequisitionForDoc($reqid)
    {

        return Template::loadView('admin.ot.aneasthea.pac_list_doc_req_list', [
            'room_data' => DB::table('sysc_room')->select('room_no_pk', 'room_name', 'room_code')->where('ot_ind', 1)->get(),
            'ot_data' => DB::table('ANES_REFERED_VW')->where('REFF_ANES_DEPT_NO_PK', $reqid)->first()
        ]);
    }
    public function pacListDataDoc(Request $request)
    {
        $table = 'anes_refered_vw';
        $primaryKey = 'reff_anes_dept_no_pk';

        // Input Parameters
        $service_number = $request->input('service_number');
        $doc_id = $request->input('doc_id');
        $from_date = $request->input('admission_date_from');
        $to_date = $request->input('admission_date_to');
        $person_no_fk = session('user.ses_person_no_fk');
        $specific_doctor = $request->doc;

        // Convert date to Y-m-d if provided
        function formatDate($dateStr)
        {
            return \Carbon\Carbon::createFromFormat('d-m-Y', $dateStr)->format('Y-m-d');
        }

        // Prepare where clause
        $where = "1 = 1"; // Default where

        if ($from_date && $to_date) {
            $from = formatDate($from_date);
            $to = formatDate($to_date);
            $where .= " AND trunc(reff_date) BETWEEN TO_DATE('$from', 'YYYY-MM-DD') AND TO_DATE('$to', 'YYYY-MM-DD')";
        } else {
            // Default: last 7 days
            $where .= " AND trunc(reff_date) BETWEEN trunc(SYSDATE-6) AND trunc(SYSDATE + 6)";
        }

        if (!empty($service_number)) {
            $where .= " AND patient_no_fk = '$service_number'";
        }
        // if (!empty($doc_id)) {
        //     $where .= " AND reff_doc_no_fk = '$doc_id'";
        // }

        // // Doctor filter
        // if (!empty($specific_doctor)) {
        //     $where .= " AND reff_doc_no_fk = $person_no_fk";
        // }
        $columns = array(
            array('db' => 'rownumber', 'dt' => 0),
            array('db' => 'patient_code', 'dt' => 1),
            array('db' => 'patient_name', 'dt' => 2),
            array('db' => 'full_name', 'dt' => 3),
            array('db' => 'patient_type', 'dt' => 4),
            array('db' => 'purpose_off_reff', 'dt' => 5),
            array('db' => 'diagnosis', 'dt' => 6),
            array('db' => 'result_of_inv_note', 'dt' => 7),
            array('db' => 'plane_proc_withdate', 'dt' => 8),
            array('db' => 'reff_date', 'dt' => 9),
            array('db' => 'estimated_duration_surge', 'dt' => 10),
            array('db' => 'specefic_req_n_remarks', 'dt' => 11),
            array('db' => 'status', 'dt' => 12),
            array('db' => 'reff_anes_dept_no_pk', 'dt' => 13),
            array('db' => 'reply_type', 'dt' => 14),
            array('db' => 'andr_name', 'dt' => 15),
            array('db' => 'admission_req_no_fk', 'dt' => 16),
            array('db' => 'admission_no_fk', 'dt' => 17),
            array('db' => 'patient_no_fk', 'dt' => 18),
        );


        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function admissionRequestUpdate(Request $request)
    {
        $reff_id = $request->input('reff_id');

        if (!$reff_id) {
            return response()->json(['message' => 'Missing referral ID.'], 400);
        }

        $data = DB::table('OPD_REFF_ANESTHESIA_DEPT')
            ->where('reff_anes_dept_no_pk', $reff_id)
            ->first();

        if (!$data) {
            return response()->json(['message' => 'Referral not found.'], 404);
        }

        try {
            DB::beginTransaction();

            $sequence = DB::getSequence();
            $admission_req_no_pk_seq = $sequence->nextValue('admission_req_no_pk_seq');
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');

            // Insert into ipd_admissionrequest
            DB::table('ipd_admissionrequest')->insert([
                'admission_req_no_pk' => $admission_req_no_pk_seq,
                'admission_req_date' => date('Y-m-d'),
                'admission_req_uid' => 'IR' . date('ym') . $admission_req_no_pk_seq,
                'prescription_no_fk' => $data->prescription_no_fk,
                'prescription_uid' => $data->prescription_no_fk,
                'appointment_no_fk' => $data->appoint_no_fk,
                'opd_doctor_no_fk' => $data->reff_doc_no_fk,
                'patient_no_fk' => $data->patient_no_fk,
                'status' => 1,
                'au_entry_at' => now(),
                'au_entry_session' => 'from opd pres',
                'au_entry_by' => auth()->id(),
                'au_entry_hospital_no_fk' => $hospital_pk_no,
                'reff_anes_dept_no_fk' => $data->reff_anes_dept_no_pk,
            ]);

            // Update OPD_REFF_ANESTHESIA_DEPT to link admission request
            DB::table('OPD_REFF_ANESTHESIA_DEPT')
                ->where('reff_anes_dept_no_pk', $reff_id)
                ->update([
                    'admission_req_no_fk' => $admission_req_no_pk_seq
                ]);

            DB::commit();

            return response()->json([
                'message' => 'Admission Request sent successfully.',
                'title' => 'Success',
                'msg' => 'Admission request has been created and linked successfully.',
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
    public function otRequilistFormList()
    {
        $requestDepts = DB::table('sysc_serviceunit')
            ->where('ipd_ind', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get(['serviceunit_name', 'serviceunit_no_pk']);
        $surgenlist = DB::table('hrms_personnel')->where('surgeon_ind', 1)->get(['person_no_pk', 'full_name'])->toArray();
        // $nurseList = DB::table('hrms_personnel')->get(['person_no_pk', 'full_name'])->toArray();
        return Template::loadView('admin.ot.aneasthea.ot_requision_form_list', [
            'departments' => $requestDepts,
            // 'nurses' => $nurseList,
            'surgeons' => $surgenlist
        ]);
    }
    public function otRequilistFormListDoc()
    {
        $requestDepts = DB::table('sysc_serviceunit')
            ->where('ipd_ind', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get(['serviceunit_name', 'serviceunit_no_pk']);
        $surgenlist = DB::table('hrms_personnel')->where('surgeon_ind', 1)->get(['person_no_pk', 'full_name'])->toArray();
        // $nurseList = DB::table('hrms_personnel')->get(['person_no_pk', 'full_name'])->toArray();
        return Template::loadView('admin.ot.aneasthea.ot_requision_form_list_doc', [
            'departments' => $requestDepts,
            // 'nurses' => $nurseList,
            'surgeons' => $surgenlist
        ]);
    }
    public function otRequilistFormListData(Request $request)
    {
        $person_no_fk = session('user.ses_person_no_fk');
        $table = 'ot_requisition_list_vw';
        $primaryKey = 'reff_anes_dept_no_pk';


        // Input Parameters
        $department = $request->input('department');
        $urgency_category = $request->input('urgency_category');
        $specific_doctor = $request->doc;

        // Convert date format
        function formatDate($dateStr)
        {
            try {
                return \Carbon\Carbon::createFromFormat('d-m-Y', $dateStr)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        // Default where clause
        $where = "1 = 1";
        // Patient number filter
        if (!empty($department)) {
            $department = addslashes($department);
            $where .= " AND req_department_no_fk = '$department'";
        }

        // Doctor filter
        if (!empty($urgency_category)) {
            $urgency_category = addslashes($urgency_category);
            $where .= " AND urgency_details = '$urgency_category'";
        }

        // Doctor filter
        if (!empty($specific_doctor)) {
            $where .= " AND primary_doctor_no_fk = $person_no_fk";
        }

        // Define columns for DataTable
        $columns = array(
            ['db' => 'rownumber', 'dt' => 0, 'as' => 'rownumber'],
            ['db' => 'patient_name', 'dt' => 1, 'as' => 'patient_name'],
            ['db' => 'age', 'dt' => 2, 'as' => 'age'],
            ['db' => 'gender_txt', 'dt' => 3, 'as' => 'gender_txt'],
            ['db' => 'diagnosis', 'dt' => 4, 'as' => 'diagnosis'],
            ['db' => 'purpose_off_reff', 'dt' => 5, 'as' => 'purpose_off_reff'],
            ['db' => 'estimated_duration_surge', 'dt' => 6, 'as' => 'estimated_duration_surge'],
            ['db' => 'specefic_req_n_remarks', 'dt' => 7, 'as' => 'surgeon_remarks'],
            ['db' => 'reff_anes_dept_no_pk', 'dt' => 8, 'as' => 'reff_anes_dept_no_pk'],
            ['db' => 'patient_no_fk', 'dt' => 9, 'as' => 'patient_no_fk'],
            ['db' => 'admission_no_pk', 'dt' => 10, 'as' => 'admission_no_pk'],
            ['db' => 'req_dept_name', 'dt' => 11, 'as' => 'req_dept_name'],
            ['db' => 'urgency_details', 'dt' => 12, 'as' => 'urgency_details'],
            ['db' => 'surgen_no_fk', 'dt' => 13, 'as' => 'surgen_no_fk'],
            ['db' => 'surgen_name', 'dt' => 14, 'as' => 'surgen_name'],
            ['db' => 'ipd_nurse_no_fk', 'dt' => 15, 'as' => 'ipd_nurse_no_fk'],
            ['db' => 'nurse_name', 'dt' => 16, 'as' => 'nurse_name'],
            ['db' => 'user_no_pk', 'dt' => 17, 'as' => 'user_no_pk'],
            ['db' => 'user_name', 'dt' => 18, 'as' => 'user_name'],
            ['db' => 'req_department_no_fk', 'dt' => 19, 'as' => 'req_department_no_fk'],
            ['db' => 'reff_date', 'dt' => 20, 'as' => 'reff_date']
        );


        // Fetch and return data
        $data = DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where);
        return response()->json($data);
    }

    public function sendRequisition(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction(); // Start transaction

        try {
            $reqNo = $request->reqNo;
            $diagnosis = $request->diagnosis;
            $operation = $request->operation;
            $estimated_duration = $request->estimated_duration;
            $surgeon_remarks = $request->surgeon_remarks;
            $urgency = $request->urgency;
            $date = $request->date;
            $time = $request->time;
            $combined = date('Y-m-d H:i:s', strtotime("$date $time"));
            // Update OPD_REFF_ANESTHESIA_DEPT table
            DB::table('OPD_REFF_ANESTHESIA_DEPT')
                ->where('reff_anes_dept_no_pk', $reqNo)
                ->update([
                    // 'ipd_nurse_no_fk'        => $nurse_id,
                    // 'req_department_no_fk'   => $department,
                    // 'surgen_no_fk'           => $surgeon_id,
                    'urgency_details' => $urgency,
                    'diagnosis' => $diagnosis,
                    'PURPOSE_OFF_REFF' => $operation,
                    'ESTIMATED_DURATION_SURGE' => $estimated_duration,
                    'SPECEFIC_REQ_N_REMARKS' => $surgeon_remarks,
                    'reff_date' => $combined,
                    'req_given_by' => Auth::id(),
                    'req_given_date' => now(),
                ]);

            DB::commit(); // Commit if all is well


            return response()->json([
                'message' => 'Requisition sent successfully.',
                'title' => 'Success',
                'msg' => 'Requisition has been created and linked successfully.',
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback on failure
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
                'success' => false
            ], 500);
        }
    }

    public function otRequisitionPdfExport(Request $request)
    {
        $department = $request->department;
        $urgency = $request->urgency_category;

        $person_no_fk = session('user.ses_person_no_fk');
        $query = DB::table('OT_REQUISITION_LIST_VW');
        $dept = '';
        if ($department) {
            $query->where('req_department_no_fk', $department);
            $dept = DB::table('sysc_serviceunit')
                ->select('serviceunit_name')
                ->where('ipd_ind', 1)
                ->where('serviceunit_no_pk', $department)
                ->first()->serviceunit_name;
        }

        if ($urgency) {
            $query->where('urgency_details', $urgency);
        }
        if (!empty($specific_doctor)) {
            $query->where('primary_doctor_no_fk', $person_no_fk);
        }
        $data = $query->get();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $title = 12345;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        return view("admin.ot.aneasthea.ot_requistion_form_list_pdf", [
            'data' => $data,
            'barcode_no' => $barcode_no,
            'dept' => $dept,
            'urgency' => $urgency,
            'po_hospital_details' => $po_hospital_details

        ]);
    }

    public function otBookedPdf(Request $request, $pacId)
    {
        $patient_info = DB::table('ANES_REFERED_VW as anes')
            ->leftJoin('patient_info_vw as pat', 'pat.PATIENT_NO_PK', '=', 'anes.patient_no_fk')
            ->select(
                'anes.*',
                'pat.DOB',
                'pat.DOD',
                'pat.GENDER_TXT',
                'pat.WEIGHT',
                DB::raw('pat_age(pat.dob, NVL(pat.dod, SYSDATE)) AS pat_age')
            )
            ->where('REFF_ANES_DEPT_NO_PK', $pacId)
            ->first();


        $booking_details = DB::table('ot_requisition_list_vw')
            ->select(
                'diagnosis',
                'purpose_off_reff',
                'estimated_duration_surge',
                'specefic_req_n_remarks',
                'req_dept_name',
                'urgency_details',
                'surgen_name',
                'nurse_name',
                'user_name',
                'req_department_no_fk',
                'req_given_date',
                'reff_date',
                'ot_req_no_fk',
                'available_ind'
            )->where('REFF_ANES_DEPT_NO_PK', $pacId)->first();

        $slot_details = DB::table('ot_schedule_slot as SLOT')
            ->select(
                'SLOT.SHIFT_NO_FK as shift_no',
                'SLOT.START_TIME as start_time',
                'SLOT.SLOT_SL as slot_sl',
                'SLOT.END_TIME as end_time'
            )
            ->where('SLOT.ot_req_no_fk', $booking_details->ot_req_no_fk)
            ->first();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        return View("admin.ot.aneasthea.ot_booked_form_details", ['barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details, 'patient_info' => $patient_info, 'booking_details' => $booking_details, 'slot_details' => $slot_details]);
    }

    public function recommendInvestigation()
    {
        return view("admin.ot.aneasthea.recommend_investigation");
    }

    public function otSlotBook($slotId)
    {
        return Template::loadView("admin.ot.aneasthea.ot_slot_booking_list");
    }

    public function todaysPatient()
    {
        // Define the start and end of the day using Carbon
        $start = Carbon::now()->subDays(7)->startOfDay();
        $end = Carbon::now()->endOfDay();

        // Fetch patients within the date range
        $patients = DB::table('ot_requisition_list_vw')
            ->select('ot_requisition_list_vw.*')
            ->leftJoin('ot_schedule_slot', 'reff_anes_dept_no_fk', 'reff_anes_dept_no_pk')
            ->whereNull('reff_anes_dept_no_fk')
            ->whereBetween('REFF_DATE', [$start, $end])
            ->get();

        // Return the patients as a collection of PatientResource
        return PatientResource::collection($patients);
    }
    public function show($id)
    {
        $patient = DB::table('ot_requisition_list_vw')
            // ->select('PATIENT_NAME', 'REFF_ANES_DEPT_NO_PK', 'REQ_DEPT_NAME', 'PATIENT_PHOTO', 'REFF_DATE')
            ->where('reff_anes_dept_no_pk', $id)
            ->first();

        // Optionally, handle case when not found
        if (!$patient) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return new PatientResource((object) $patient);
    }

    public function book(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                // 1. Get requisition
                $requisition = DB::table('opt_prescribed_ot')
                    ->where('prescription_no_fk', (int) $request->presId)
                    ->value('ot_req_no_pk');

                $data = DB::table('OPD_REFF_ANESTHESIA_DEPT')
                    ->where('prescription_no_fk', (int) $request->presId)
                    ->first();

                if (!$requisition || !$data) {
                    throw new \Exception('Invalid presId or reqId');
                }
                // 2. Book the slot
                $updated = DB::table('ot_schedule_slot')
                    ->where('ot_slot_no_pk', (int) $request->slotId)
                    ->update([
                        'available_ind' => 0,
                        'ot_req_no_fk' => $requisition,
                        'patient_no_fk' => (int) $data->patient_no_fk,
                        'admission_no_fk' => (int) $data->admission_no_fk,
                        'reff_anes_dept_no_fk' => (int) $data->reff_anes_dept_no_pk,
                    ]);
                DB::commit();
                if (!$updated) {
                    throw new \Exception('Slot is not available or booking failed');
                }

                // 3. Update OT requisition


                DB::table('opt_prescribed_ot')
                    ->where('ot_req_no_pk', $requisition)
                    ->update([
                        'reff_anes_dept_no_fk' => (int) $request->reqId,
                        'surg_doc_person_no_fk' => $data->surgen_no_fk,
                        'ot_date' => date('Y-m-d H:i', strtotime($data->reff_date)),
                        'ot_comfirmation_ind' => 1,
                        'ot_comfirmation_time' => now()->format('Y-m-d H:i'),
                        'surgeons_remark' => $data->specefic_req_n_remarks,
                        'diagnosis' => $data->diagnosis,
                        'ot_comfirmation_doc_by' => Auth::id(),
                        'admission_no_fk' => (int) $data->admission_no_fk,
                        'anest_clearance_ind' => 1,
                        'anest_clearance_time' => now()->toDateString(),
                        'anest_clearance_doc_by' => Auth::id(),
                        'au_update_by' => Auth::id(),
                        'au_update_at' => now()->toDateString(),
                        'au_update_session' => session('user.ses_hospital_no_pk'),
                    ]);


                $patientNo = $data->patient_no_fk;
                $newSlotId = $request->slotId;

                $track = DB::table('OT_SLOT_TRACK_HISTORY')
                    ->where('PATIENT_NO_FK', $patientNo)
                    ->whereNull('NEW_SLOT_NO')
                    ->orderByDesc('MOVED_AT')
                    ->first();

                if ($track) {
                    DB::table('OT_SLOT_TRACK_HISTORY')
                        ->where('ot_slot_track_history_no_pk', $track->ot_slot_track_history_no_pk)
                        ->update([
                            'NEW_SLOT_NO' => $newSlotId
                        ]);
                }




                DB::commit();
            }, 5); // optional retry on deadlock
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Slot booked successfully.',
        ]);
    }

    public function slotBookByDoc(Request $request)
    {
        $ot_slot_id = $request->ot_slot_id;
        $advice = $request->advice;
        DB::table('ot_schedule_slot')->where('ot_slot_no_pk', $request->ot_slot_id)->where('available_ind', 1)
            ->update([
                'available_ind' => 0,
            ]);
        DB::commit();
    }

    public function otTodayPatientList()
    {
        $requestDepts = DB::table('sysc_serviceunit')
            ->where('ipd_ind', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get(['serviceunit_name', 'serviceunit_no_pk']);
        $surgenlist = DB::table('hrms_personnel')->where('surgeon_ind', 1)->get(['person_no_pk', 'full_name'])->toArray();

        return Template::loadView('admin.ot.aneasthea.ot_today_patient_list', [
            'departments' => $requestDepts,
            'surgeons' => $surgenlist
        ]);
    }

    public function otTodayPatientListData(Request $request)
    {
        $person_no_fk = session('user.ses_person_no_fk');
        $table = 'ot_requisition_list_vw';
        $primaryKey = 'reff_anes_dept_no_pk';


        // Input Parameters
        $department = $request->input('department');
        $urgency_category = $request->input('urgency_category');
        $specific_doctor = $request->doc;

        // Convert date format
        function formatDate($dateStr)
        {
            try {
                return \Carbon\Carbon::createFromFormat('d-m-Y', $dateStr)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        // Default where clause
        // $where = "1 = 1";
        $where = " USER_NO_PK IS NOT NULL";
        // Patient number filter
        if (!empty($department)) {
            $department = addslashes($department);
            $where .= " AND req_department_no_fk = '$department'";
        }

        // Doctor filter
        if (!empty($urgency_category)) {
            $urgency_category = addslashes($urgency_category);
            $where .= " AND urgency_details = '$urgency_category'";
        }

        // Doctor filter
        if (!empty($specific_doctor)) {
            $where .= " AND primary_doctor_no_fk = $person_no_fk";
        }

        // Define columns for DataTable
        $columns = array(
            ['db' => 'rownumber', 'dt' => 0, 'as' => 'rownumber'],
            ['db' => 'patient_name', 'dt' => 1, 'as' => 'patient_name'],
            ['db' => 'age', 'dt' => 2, 'as' => 'age'],
            ['db' => 'gender_txt', 'dt' => 3, 'as' => 'gender_txt'],
            ['db' => 'diagnosis', 'dt' => 4, 'as' => 'diagnosis'],
            ['db' => 'purpose_off_reff', 'dt' => 5, 'as' => 'purpose_off_reff'],
            ['db' => 'estimated_duration_surge', 'dt' => 6, 'as' => 'estimated_duration_surge'],
            ['db' => 'specefic_req_n_remarks', 'dt' => 7, 'as' => 'surgeon_remarks'],
            ['db' => 'reff_anes_dept_no_pk', 'dt' => 8, 'as' => 'reff_anes_dept_no_pk'],
            ['db' => 'patient_no_fk', 'dt' => 9, 'as' => 'patient_no_fk'],
            ['db' => 'admission_no_pk', 'dt' => 10, 'as' => 'admission_no_pk'],
            ['db' => 'req_dept_name', 'dt' => 11, 'as' => 'req_dept_name'],
            ['db' => 'urgency_details', 'dt' => 12, 'as' => 'urgency_details'],
            ['db' => 'surgen_no_fk', 'dt' => 13, 'as' => 'surgen_no_fk'],
            ['db' => 'surgen_name', 'dt' => 14, 'as' => 'surgen_name'],
            ['db' => 'ipd_nurse_no_fk', 'dt' => 15, 'as' => 'ipd_nurse_no_fk'],
            ['db' => 'nurse_name', 'dt' => 16, 'as' => 'nurse_name'],
            ['db' => 'user_no_pk', 'dt' => 17, 'as' => 'user_no_pk'],
            ['db' => 'user_name', 'dt' => 18, 'as' => 'user_name'],
            ['db' => 'req_department_no_fk', 'dt' => 19, 'as' => 'req_department_no_fk'],
            ['db' => 'req_given_date', 'dt' => 20, 'as' => 'req_given_date'],
            ['db' => 'reff_date', 'dt' => 21, 'as' => 'reff_date'],
            ['db' => 'ot_req_no_fk', 'dt' => 22, 'as' => 'ot_req_no_fk'],
            ['db' => 'available_ind', 'dt' => 23, 'as' => 'available_ind'],
        );


        // Fetch and return data
        $data = DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where);
        return response()->json($data);
    }

    public function anesthetiaDocListData(Request $request)
    {
        $table = 'anes_referred_list_vw';
        $primaryKey = 'reff_anes_dept_no_pk';

        // Input Parameters
        $service_number = $request->input('service_number');
        $doc_id = $request->input('doc_id');
        $from_date = $request->input('admission_date_from');
        $to_date = $request->input('admission_date_to');
        $person_no_fk = session('user.ses_person_no_fk');
        $specific_doctor = $request->doc;

        // Convert date to Y-m-d if provided
        function formatDate($dateStr)
        {
            return \Carbon\Carbon::createFromFormat('d-m-Y', $dateStr)->format('Y-m-d');
        }

        // Prepare where clause
        $where = "1 = 1"; // Default where

        if ($from_date && $to_date) {
            $from = formatDate($from_date);
            $to = formatDate($to_date);
            $where .= " AND trunc(reff_date) BETWEEN TO_DATE('$from', 'YYYY-MM-DD') AND TO_DATE('$to', 'YYYY-MM-DD')";
        } else {
            // Default: last 7 days
            $where .= " AND trunc(reff_date) BETWEEN trunc(SYSDATE) AND trunc(SYSDATE +5)";
        }

        if (!empty($service_number)) {
            $where .= " AND patient_no_fk = '$service_number'";
        }
        if (!empty($doc_id)) {
            $where .= " AND reff_doc_no_fk = '$doc_id'";
        }
        $columns = [
            ['db' => 'rownumber', 'dt' => 0],
            ['db' => 'patient_code', 'dt' => 1],
            ['db' => 'patient_name', 'dt' => 2],
            ['db' => 'age', 'dt' => 3],
            ['db' => 'patient_photo', 'dt' => 4],
            ['db' => 'full_name', 'dt' => 5],
            ['db' => 'dept', 'dt' => 6],
            ['db' => 'appoint_no_fk', 'dt' => 7],
            ['db' => 'patient_no_fk', 'dt' => 10],
            ['db' => 'reff_date', 'dt' => 11],
            ['db' => 'prescription_no_fk', 'dt' => 12],
        ];



        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function submitDatajson(Request $request)
    {
        $reply_type = DB::table('OPD_REFF_ANESTHESIA_DEPT')
            ->where('reff_anes_dept_no_pk', $request->reply_id)
            ->value('reply_type');

        return response()->json([
            'reply_type' => $reply_type,
            'id' => $request->reply_id,
        ], 200);
    }
    public function cancelBooking($slotId)
    {
        $req_data = DB::table('OT_SCHEDULE_SLOT')->where('OT_SLOT_NO_PK', $slotId)->first();
        return Template::loadView("admin.ot.aneasthea.ot_slot_booking_cancellation", [
            'slotId' => $slotId,
            'req_data' => $req_data,
        ]);
    }

    public function otCancel(Request $request)
    {
        try {
            DB::beginTransaction();
            DB::table('ot_schedule_slot')
                ->where('ot_slot_no_pk', (int) $request->hdn_slot_no_fk)
                ->update([
                    'ot_req_no_fk' => '',
                    'admission_no_fk' => '',
                    'patient_no_fk' => '',
                    'reff_anes_dept_no_fk' => '',
                    'available_ind' => 1,
                    'ot_cancel_ind' => 1,
                    'cancel_note' => $request->cancel_reason,
                ]);

            $sequence = DB::getSequence();
            $ot_slot_track_history_no_pk_seq = $sequence->nextValue('ot_slot_track_history_no_pk_seq');
            DB::table('OT_SLOT_TRACK_HISTORY')->insert([
                'OT_SLOT_TRACK_HISTORY_NO_PK' => $ot_slot_track_history_no_pk_seq,
                'PATIENT_NO_FK' => (int) $request->patient_no_fk,
                'OLD_SLOT_NO' => (int) $request->hdn_slot_no_fk,
                'CANCEL_REASON' => $request->cancel_reason,
                'MOVED_BY' => Auth::id(),
                'MOVED_AT' => date("Y-m-d"),
                'AU_ENTRY_BY' => Auth::id(),
                'AU_ENTRY_AT' => date("Y-m-d"),
                'AU_ENTRY_SESSION' => 'SESSION',
                'AU_ENTRY_HOSPITAL_PK_NO' => Session::get('user.ses_hospital_no_pk')
            ]);




            DB::commit();

            $this->message = [
                'msg' => 'OT Slot Booking Cancelled Successfully.',
                'title' => 'Success',
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $this->message = [
                'msg' => 'Cancellation Failed: ' . $e->getMessage(),
                'title' => 'Error',
            ];
        }

        return response()->json($this->message);
    }

    public function otRequisitionListData(Request $request)
    {
        $table = 'ot_requisition_vw';
        $primaryKey = 'reff_anes_dept_no_pk';

        // Input Parameters
        $service_number = $request->input('service_number');
        $doc_id = $request->input('doc_id');
        $from_date = $request->input('admission_date_from');
        $to_date = $request->input('admission_date_to');
        $person_no_fk = session('user.ses_person_no_fk');
        $specific_doctor = $request->doc;

        // Convert date to Y-m-d if provided
        function formatDate($dateStr)
        {
            return \Carbon\Carbon::createFromFormat('d-m-Y', $dateStr)->format('Y-m-d');
        }

        // Prepare where clause
        $where = "1 = 1"; // Default where

        if ($from_date && $to_date) {
            $from = formatDate($from_date);
            $to = formatDate($to_date);
            $where .= " AND trunc(reff_date) BETWEEN TO_DATE('$from', 'YYYY-MM-DD') AND TO_DATE('$to', 'YYYY-MM-DD')";
        } else {
            // Default: last 7 days
            $where .= " AND trunc(reff_date) BETWEEN trunc(SYSDATE-6) AND trunc(SYSDATE + 6)";
        }

        if (!empty($service_number)) {
            $where .= " AND patient_no_fk = '$service_number'";
        }
        if (!empty($doc_id)) {
            $where .= " AND reff_doc_no_fk = '$doc_id'";
        }

        // Doctor filter
        if (!empty($specific_doctor)) {
            $where .= " AND reff_doc_no_fk = $person_no_fk";
        }
        $columns = array(
            array('db' => 'rownumber', 'dt' => 0),                     // Sl
            array('db' => 'patient_code', 'dt' => 1),                          // IP No. (NEW FIELD)
            array('db' => 'patient_name', 'dt' => 3),                  // Patient Name
            array('db' => 'full_name', 'dt' => 4),                     // Doctor
            array('db' => 'schedule_dt', 'dt' => 5),                   // Planned Time (Combined Start-End)
            array('db' => 'status', 'dt' => 7),                        // Status
            array('db' => 'reff_anes_dept_no_pk', 'dt' => 8, 'formatter' => function ($d, $row) {
                // return action buttons here
                return '<a class="btn btn-sm btn-info" href="#">View</a>';
            }),
            array('db' => 'admission_req_no_fk', 'dt' => 9),           // Hidden: required later
            array('db' => 'admission_no_fk', 'dt' => 10),              // Hidden: required later
            array('db' => 'patient_no_fk', 'dt' => 11),                // Hidden
            array('db' => 'start_time', 'dt' => 12),                   // hidden
            array('db' => 'end_time', 'dt' => 13),                     // hidden
            array('db' => 'user_name', 'dt' => 14),                    // ot confirmed by
            array('db' => 'ot_comfirmation_time', 'dt' => 15),         // ot confirm time
            array('db' => 'ot_comfirmation_ind', 'dt' => 16),          // ot confirmed flag (1/0)
        );



        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function getBillAndOtConfirmed($slotId)
    {
        $getBillData = DB::table('OT_SCHEDULE_SLOT')
            ->select('bill_clearence_ind', 'pac_clearence_ind')
            ->join('OPT_PRESCRIBED_OT', 'OT_REQ_NO_PK', 'OT_REQ_NO_fK')
            ->where('OT_SLOT_NO_PK', $slotId)
            ->first();
        return $getBillData;
    }


    public function doctorWiseSurgery()
    {
        $requestDepts = DB::table('sysc_serviceunit')
            ->where('ipd_ind', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get(['serviceunit_name', 'serviceunit_no_pk']);
        return Template::loadView('admin.ot.aneasthea.ot_requisition_list_report', [
            'requestDepts' => $requestDepts,
        ]);
    }

    public function doctorWiseSurgeryData(Request $request, $returnData = false)
    {
        $table = 'OT_PERFORMED_VW';
        $primaryKey = 'ADMISSION_UID';
        $service_number = $request->input('service_number');
        $doc_id = $request->input('doc_id');
        $from_date = $request->input('admission_date_from');
        $to_date = $request->input('admission_date_to');
        function formatDate($dateStr)
        {
            return \Carbon\Carbon::createFromFormat('d-m-Y', $dateStr)->format('Y-m-d');
        }

        // Prepare where clause
        $where = "1 = 1";

        if ($from_date && $to_date) {
            $from = formatDate($from_date);
            $to = formatDate($to_date);
            $where .= " AND trunc(ot_completed_date) BETWEEN TO_DATE('$from', 'YYYY-MM-DD') AND TO_DATE('$to', 'YYYY-MM-DD')";
        } else {
            $where .= " AND trunc(ot_completed_date) BETWEEN trunc(SYSDATE - 30) AND trunc(SYSDATE)";
        }

        if (!empty($service_number)) {
            $where .= " AND patient_no_fk = '$service_number'";
        }
        if (!empty($doc_id)) {
            $where .= " AND SURG_DOC_PERSON_NO_FK = '$doc_id'";
        }

        $columns = array(
            array('db' => 'rownumber', 'dt' => 0),
            array('db' => 'admission_uid', 'dt' => 1),
            array('db' => 'patient_name', 'dt' => 2),
            array('db' => 'age', 'dt' => 3),
            array('db' => 'ipd_department_name', 'dt' => 4),
            array('db' => 'surg_doctor_name', 'dt' => 6),
            array('db' => 'actual_anest_name', 'dt' => 7),
            array('db' => 'item_name', 'dt' => 8),
            array('db' => 'ward_name', 'dt' => 9),
            array('db' => 'ot_completed_date', 'dt' => 12),
        );

        if (!empty($where)) {
            $result = DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where);
        } else {
            $result = DataTableClass::simple($request, $table, $primaryKey, $columns);
        }

        if ($returnData) {
            return $result;
        } else {
            echo json_encode($result);
        }
    }


    public function exportDoctorSurReport(Request $request)
    {
        $response = $this->doctorWiseSurgeryData($request, true);

        $data = $response['data'] ?? [];

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $date_from = $request->search_date_from ?? '';
        $date_to = $request->search_date_to ?? '';

        if ($request->hdn_report_type === 'pdf') {
            $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();

            $pdf = PDF::loadView("admin.ot.aneasthea.doctor_wise_surgery_export", [
                'barcode_no' => $barcode_no,
                'data' => $data,
                'from_date' => $date_from,
                'to_date' => $date_to,
                'po_hospital_details' => $po_hospital_details
            ]);

            return $pdf->stream('doctor_wise_surgery_export.pdf');
        } else {
            // Excel export
            $flatData = [];

            foreach ($data as $row) {
                $flatData[] = [
                    'Sl'                     => $row[0] ?? '',
                    'IP No. ID'              => $row[1] ?? '',
                    'Patient Name'           => $row[2] ?? '',
                    'Age'                    => $row[3] ?? '',
                    'Department'             => $row[4] ?? '',
                    'Item Code'              => $row[5] ?? '',
                    'Surgeon Name'                 => $row[6] ?? '',
                    'Anesthesiologist Name'  => $row[7] ?? '',
                    'Surgery Name'           => $row[8] ?? '',
                    'Ward Name'              => $row[9] ?? '',
                    'Package'                => $row[10] ?? '',
                    'Net Amount'             => $row[11] ?? '',
                    'Completed Date'         => !empty($row[12])
                        ? \Carbon\Carbon::parse($row[12])->format('d/m/Y')
                        : '',
                ];
            }

            return ExcelHelper::export($flatData, 'doctor_wise_surgery_export.xlsx');
        }
    }

    public function investigationAneasthelization($invoice_id, $item_id)
    {
        $patient_invdata = DB::table('FINC_INV_ITEMDTL_VW')
            ->where('INVOICE_NO_FK', $invoice_id)
            ->where('ITEM_CODE', $item_id)
            ->first();
        return Template::loadView('admin.ot.aneasthea.others_aneastheia_refferred', [
            'patient_invdata' => $patient_invdata,
        ]);
    }
    public function investigationAneasthelizationIpd($admId, $item_id)
    {

        $patient_invdata = DB::table('opt_prescribed_ot')
            ->leftJoin('ot_complete_status', 'ot_complete_status.admission_no_fk', '=', 'opt_prescribed_ot.admission_no_fk')
            ->leftJoin('IPD_ADMITTED_PATLIST_VW', 'opt_prescribed_ot.admission_no_fk', '=', 'IPD_ADMITTED_PATLIST_VW.admission_no_pk')
            ->where('opt_prescribed_ot.admission_no_fk', $admId)
            ->where('opt_prescribed_ot.item_no_fk', $item_id)
            ->first();
        // dd($patient_invdata);
        return Template::loadView('admin.ot.aneasthea.others_aneastheia_refferred_ipd', [
            'patient_invdata' => $patient_invdata,
        ]);
    }

    public function invAnesStore(Request $request)
    {
        $admissionId = $request->input('admission_id');


        $now = Carbon::now();
        $userId = Auth::id();
        $userSession = session('user.ses_user_session');
        $hospitalId = session('user.ses_user_hospital_pk_no');

        DB::beginTransaction();
        try {

            if ($admissionId == null) {

                // -----------------------------
                // Create NEW referral + OT data
                // -----------------------------

                 $patientCode = $request->input('patient_na_fk');

                $patientNoPk = DB::table('patn_registration')
                    ->where('patient_code', $patientCode)
                    ->value('patient_no_pk');
                $seqRef = DB::getSequence()->nextValue('REFF_ANES_DEPT_NO_PK_SEQ');

                DB::table('opd_reff_anesthesia_dept')->insert([
                    'reff_anes_dept_no_pk'      => $seqRef,
                    'patient_no_fk'             => $patientNoPk,
                    'reff_doc_no_fk'            => $userId,
                    'patient_type'              => 'OTH',
                    'purpose_off_reff'          => $request->input('purpose'),
                    'diagnosis'                 => $request->input('diagnosis'),
                    'ot_req_no_fk'              => $request->input('last_id'),
                    'result_of_inv_note'        => $request->input('investigationResult'),
                    'plane_proc_withdate'       => $request->input('plannedProcedure'),
                    'reff_date'                 => $now,
                    'estimated_duration_surge'  => $request->input('estimatedDuration'),
                    'urgency_details'           => $request->input('urgency'),
                    'specefic_req_n_remarks'    => $request->input('specificRequirements'),
                    'status'                    => 1,
                    'au_entry_by'               => $userId,
                    'au_entry_at'               => $now,
                    'au_entry_session'          => $userSession,
                    'au_entry_hospital_pk_no'   => $hospitalId,
                ]);

                $seqOt = DB::getSequence()->nextValue('OT_REQ_NO_PK_SEQ');

                DB::table('opt_prescribed_ot')->insert([
                    'ot_req_no_pk'              => $seqOt,
                    'au_entry_at'               => $now,
                    'reff_anes_dept_no_fk'      => $seqRef,
                    'au_entry_by'               => $userId,
                    'anest_clearance_doc_by'    => $userId,
                    'patient_no_fk'             => $patientNoPk,
                    'ot_req_date'               => $now,
                    'ot_date'                   => $now,
                    'au_entry_session'          => $userSession,
                    'ot_comfirmation_ind'       => 1,
                    'anest_clearance_ind'       => 1,
                    'status'                    => 1,
                    'au_entry_hospital_no_fk'   => $hospitalId,
                ]);
            } else {

                // -----------------------------
                // Update EXISTING referral + OT
                // -----------------------------

                $latestOtReq = DB::table('opt_prescribed_ot')
                    ->where('admission_no_fk', (int)$admissionId)
                    ->orderByDesc('ot_req_no_pk')
                    ->first();

                $reff_anes_dept_no_pk = DB::table('opd_reff_anesthesia_dept')
                ->where('ot_req_no_fk',$latestOtReq->ot_req_no_pk)
                ->value('reff_anes_dept_no_pk');
                DB::table('opd_reff_anesthesia_dept')
                    ->where('ot_req_no_fk', $latestOtReq->ot_req_no_pk)
                    ->update([
                        'purpose_off_reff'         => $request->input('purpose'),
                        'diagnosis'                => $request->input('diagnosis'),
                        'result_of_inv_note'       => $request->input('investigationResult'),
                        'plane_proc_withdate'      => $request->input('plannedProcedure'),
                        'reff_date'                => $now,
                        'estimated_duration_surge' => $request->input('estimatedDuration'),
                        'urgency_details'          => $request->input('urgency'),
                        'specefic_req_n_remarks'   => $request->input('specificRequirements'),
                        'status'                   => 1,
                        'admission_no_fk'          => $admissionId,
                    ]);

                DB::table('opt_prescribed_ot')
                    ->where('ot_req_no_pk', $latestOtReq->ot_req_no_pk)
                    ->update([
                        'anest_clearance_doc_by' => $userId,
                        'reff_anes_dept_no_fk' => $reff_anes_dept_no_pk,
                        'ot_req_date'            => $now,
                        'ot_date'                => $now,
                        'au_entry_session'       => $userSession,
                        'ot_comfirmation_ind'    => 1,
                        'anest_clearance_ind'    => 1,
                    ]);
            }

            DB::commit();

            return back()->with([
                'msg' => 'Data Saved Successfully',
                'title' => 'Success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            // Optional: Log the error
            // Log::error('invAnesStore error: ' . $e->getMessage());

            return back()->with('error', 'There was an issue storing the data. Please try again.');
        }
    }
}
