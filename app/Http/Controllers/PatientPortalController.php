<?php

namespace App\Http\Controllers;

use Session;
use Exception;
use Carbon\Carbon;
use App\Library\Template;
use App\Models\PatientRegistration;
use App\Traits\LookupData;
use DateTime;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Dompdf\Options;
use Illuminate\Support\Facades\Hash;

class PatientPortalController extends Controller
{
    use LookupData;

    /**
     * Patient Portal Dashboard
     */
    public function dashboard()
    {
        // $guard = 'patient';
        // dd(auth()->guard($guard)->check());

        return Template::loadview("admin.patient-portal.dashboard");
    }

    use AuthenticatesUsers;

    protected $redirectTo = '/patient-portal/patient-login';

    public function __construct()
    {
    //   $this->middleware('guest')->except('logout');
    }

    public function guard()
    {
        return Auth::guard('patient');
    }

    public function showLoginForm()
    {
        Auth::logout();

        // return view('auth.admin_login');
        return view("admin.patient-portal.login");
    }

    protected function credentials(Request $request)
    {
        // if(is_numeric($request->get('patient_code'))){
        //     return ['user_code'=>$request->get('email'),'password'=>$request->get('password')];
        // }
        // dd($request->get('email'));
        return $request->only($this->username(), 'mobile1');
    }

    public function username()
    {
        return 'patient_code';
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'mobile1' => 'required|string',
        ]);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $patient = PatientRegistration::where('patient_code', $request->input('patient_code'))
                            ->where('mobile1', $request->input('mobile1'))
                            ->first();

        if(isset($patient)) {
            Auth::guard('patient')->login($patient);

            if(auth()->guard('patient')->check()) {
                // return redirect()->intended($this->redirectPath());

                $user_info = Auth::guard('patient')->user();
                session(['user.ses_hospital_no_pk' => $user_info->au_entry_hospital_pk_no]);
                session()->save();

                return redirect()->to('patient-portal/dashboard');
            } else {
                return redirect()->to('patient-portal/login');
            }
        } else {
            // return redirect()->to('patient-portal/login')->withErrors(['errors', 'sgbfdskjgfdjb']);
            $errorsMessage = 'These credentials do not match our records.';
            return view("admin.patient-portal.login", compact('errorsMessage'));
        }

        // if ($this->attemptLogin($request)) {
        //     return $this->sendLoginResponse($request);
        // }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        // $this->incrementLoginAttempts($request);

        // return $this->sendFailedLoginResponse($request);
    }

    /**
     * Patient Invoice List
     */
    public function invoice()
    {
        $patient_code = auth()->guard('patient')->user()->patient_code;

        $items = DB::table('labt_invoicedtl_step_can_vw')
                    ->select(
                        'invoice_code', 'item_name', 'invoice_date', 'result_final_keyed_time', 'result_final_keyed_by', 'REPORT_NO_FK',
                        // 'invoice_code', 'lab_code', 'item_name', 'sc_sample_coll_keyed_time', 'lab_rcv_from_sp_keyed_time', 'result_ent_keyed_time', 'result_verify_keyed_time', 'result_final_keyed_time', 'report_procees_keyed_time', 'report_delivered_time', 'report_rcb_keyed_time', 'labt_invoicedtl_step_can_vw.patient_code',
                        // 'sc_sample_coll_keyed_by', 'lab_rcv_from_sp_keyed_by', 'result_ent_keyed_by', 'result_verify_keyed_by', 'result_final_keyed_by', 'report_procees_keyed_by', 'report_delivered_keyed_by', 'report_rcb_keyed_by',
                        // 'samp_coll.user_fullname as sc_sample_coll_keyed_name', 'samp_receive.user_fullname as lab_rcv_from_sp_keyed_name', 'samp_entry.user_fullname as result_ent_keyed_name', 'samp_verify.user_fullname as result_verify_keyed_name', 'samp_finalize.user_fullname as result_final_keyed_name', 'samp_process.user_fullname as report_procees_keyed_name', 'samp_delivered.user_fullname as report_delivered_keyed_name', 'samp_rcb.user_fullname as report_rcb_keyed_name'
                    )
                    ->leftJoin('wsec_user samp_coll', 'samp_coll.user_no_pk', 'labt_invoicedtl_step_can_vw.sc_sample_coll_keyed_by')
                    ->leftjoin('wsec_user samp_receive', 'samp_receive.user_no_pk', 'labt_invoicedtl_step_can_vw.lab_rcv_from_sp_keyed_by')
                    ->leftjoin('wsec_user samp_entry', 'samp_entry.user_no_pk', 'labt_invoicedtl_step_can_vw.result_ent_keyed_by')
                    ->leftjoin('wsec_user samp_verify', 'samp_verify.user_no_pk', 'labt_invoicedtl_step_can_vw.result_verify_keyed_by')
                    ->leftjoin('wsec_user samp_finalize', 'samp_finalize.user_no_pk', 'labt_invoicedtl_step_can_vw.result_final_keyed_by')
                    ->leftjoin('wsec_user samp_process', 'samp_process.user_no_pk', 'labt_invoicedtl_step_can_vw.report_procees_keyed_by')
                    ->leftjoin('wsec_user samp_delivered', 'samp_delivered.user_no_pk', 'labt_invoicedtl_step_can_vw.report_delivered_keyed_by')
                    ->leftjoin('wsec_user samp_rcb', 'samp_rcb.user_no_pk', 'labt_invoicedtl_step_can_vw.report_rcb_keyed_by')

                    // ->where(DB::raw('NVL(CANCEL_IND,0)'), 0)
                    ->whereRaw('nvl(CANCEL_IND,0) = 0')
                    // ->where('labt_invoicedtl_step_can_vw.patient_code', auth()->guard('patient')->user()->patient_code)
                    ->where('labt_invoicedtl_step_can_vw.PATIENT_CODE', $patient_code)
                    ->orderByDesc('invoice_date');

        $from_date = request()->get('from_date') != "" ? Carbon::parse(request()->input('from_date'))->format('Y-m-d') : '';
        $to_date = request()->get('to_date') != "" ? Carbon::parse(request()->input('to_date'))->format('Y-m-d') : '';

        if($from_date != '') {
            $items = $items->whereDate('labt_invoicedtl_step_can_vw.invoice_date', '>=', $from_date);
        }

        if($to_date != '') {
            $items = $items->whereDate('labt_invoicedtl_step_can_vw.invoice_date', '<=', $to_date);
        }

        $result = $items->paginate(10);
        
        return view("admin.patient-portal.invoice", compact('result')); 
    }

    /**
     * Prescription
     */
    public function prescription()
    {
        $result = DB::table("patn_appointment_vw a")
            ->select('a.full_name', 'a.appoint_date', "b.prescription_no_pk", 'd.su_name')
            ->leftJoin('psn_t_prescription_vw b', function ($join) {
                $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk');
            })
            ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.lookupdata_no_pk")
            ->leftJoin('DOCTOR_INFO_VW d', 'a.doctor_no_fk', 'd.PERSON_NO_PK')
            ->where('a.patient_code', auth()->guard('patient')->user()->patient_code);
            // ->whereRaw("trunc(a.appoint_date)=TO_DATE('$appointment_date', 'YYYY/mm/dd')")

        $from_date = request()->get('from_date') != "" ? Carbon::parse(request()->input('from_date'))->format('Y-m-d') : '';
        $to_date = request()->get('to_date') != "" ? Carbon::parse(request()->input('to_date'))->format('Y-m-d') : '';

        if($from_date != '') {
            $result = $result->whereDate('a.appoint_date', '>=', $from_date);
        }

        if($to_date != '') {
            $result = $result->whereDate('a.appoint_date', '<=', $to_date);
        }

        $result = $result
                    ->groupBy('a.full_name', 'a.appoint_date', "b.prescription_no_pk", 'd.su_name')
                    ->paginate(10);

        return view("admin.patient-portal.prescription", compact('result'));
    }

    /**
     * IPD
     */
    public function ipd()
    {
        $items = DB::table('IPD_ADMITTED_PATLIST_VW')
            ->where('PATIENT_CODE', auth()->guard('patient')->user()->patient_code)
            ->select('admission_no_pk', 'new_su_name', 'primary_doctor_name', 'admission_date', 'discharge_date')
            ->paginate(10);

        return view("admin.patient-portal.ipd", compact('items'));
    }

    /**
     * Invoice Report
     */
    public function invoiceReport($report_id)
    {        
        $auth_id = Auth::id();
        $to_date = date('Y-m-d');
        try {
            $report_header = DB::table("labt_testreportresultprint_vw")->select(
                'invoice_code', 'patient_code', 'report_code', 'patient_name', 'age', 'dob', 'gender_txt',
                'ref_doc_name', 'ref_doc_name_degree1', 'ref_doc_name_degree2', 'ref_doc_name_degree3', 'ward_name',
                'bed_name', 'passport_no', 'sam_name', 'admission_no_pk', 'lab_code', 'order_date', 'item_code_list',
                'report_test_name_list', 'sc_sample_coll_keyed_time', 'sample_received_time', 'serviceunit_name',
                'analyzer_desc', 'test_method', 'interpretation', 'comments_text', 'note_text', 'prepared_by',
                'pr_digital_signature_ind', 'pr_doctor_signature_image', 'pr_doctor_signature', 'verified_by',
                'vr_digital_signature_ind', 'vr_doctor_signature_image', 'vr_doctor_signature', 'finalized_by',
                'fin_digital_signature_ind', 'fin_doctor_signature_image', 'fin_doctor_signature', 
                'ent_digital_signature_ind', 'ent_doctor_signature_image', 'ent_doctor_signature',
            )->where('report_no_pk', $report_id)->first();
            $po_hospital_details = DB::table("wsec_hospital")->first();
            $report_varcode = "";
            $invoice_varcode = "";
            $patient_varcode = "";
            if (!empty($report_header)) {
                $barcode = new BarcodeGenerator();
                $barcode->setText($report_header->report_code);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $report_varcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($report_header->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setScale(1);
                $barcode1->setLabel('');
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_varcode = $barcode1->generate();

                $barcode2 = new BarcodeGenerator();
                $barcode2->setText($report_header->patient_code);
                $barcode2->setType(BarcodeGenerator::Code128);
                $barcode2->setScale(1);
                $barcode2->setLabel('');
                $barcode2->setThickness(25);
                $barcode2->setFontSize(10);
                $patient_varcode = $barcode2->generate();
            }
            $data = DB::table("labt_testresultstruct_vw")->select('item_no_fk', 'item_name')->where('report_no_fk', $report_id)->where('show_in_rep', 1)->groupBy('item_no_fk', 'item_name')->get()->toArray();

            $report_data = DB::table("labt_testresultstruct_vw")
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->where('cancel_ind', null)
                ->orderBy('sl_no', 'ASC')
                ->orderBy('group_seq', 'ASC')
                ->get()
                ->toArray();

            $report_label_query = DB::table("labt_testresultstruct_vw labtvw")
                ->join("sysc_serviceitem sysvw", 'sysvw.item_code', '=', 'labtvw.analyzer_desc')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->orderBy('group_seq', 'ASC')
                ->first();

            $report_label = isset($report_label_query->plain_text) ? $report_label_query->plain_text : '';

            $attr_group = [];
            $result_data = [];
            $pat_dob = new \DateTime($report_header->dob);
            $invoice_date = new \DateTime($report_header->order_date);
            $interval = $invoice_date->diff($pat_dob);
            $dob = $interval->format('%y');
            $gender_text = strtoupper($report_header->gender_txt);
            foreach ($report_data as $k => $value) {                
                if (in_array(Session::get('user.ses_hospital_code'), ["UNICO", "IMPERIAL","DMHL"]) && $value->graph_ind ==1) {                 
                    $ference_value = DB::table('labs_testreferencevalue')
                        ->where('teststruct_no_fk', $value->teststruct_no_fk)
                        ->get()->toArray();

                    if (!empty($ference_value) && count($ference_value) > 1 && $value->graph_ind ==1) {

                        $result_data_ind = 0;
                        $result_arrow_sign_ind = '';
                        $referencevalue_value = '';

                        foreach ($ference_value as $kye =>  $data) {
                            
                            $age_range = range($data->low_age_yy, $data->high_age_yy);
                            $filteredArray =  in_array($dob, $age_range) ? true : false;

                            if ( $filteredArray  == true &&  strtoupper($data->gender) == $gender_text && (float)str_replace(',', '', $value->result0) >= $data->low_result && (float)str_replace(',', '', $value->result0) <= $data->high_result) {
                                $result_data_ind = 1;
                            }
                                if (in_array(Session::get('user.ses_hospital_code'), ["UNICO"])) {
                                
                                if ( $filteredArray  == true &&  strtoupper($data->gender) == $gender_text && (float)str_replace(',', '', $value->result0) < $data->low_result ) {
                                    $result_arrow_sign_ind = '↓';
                                }elseif ( $filteredArray  == true &&  strtoupper($data->gender) == $gender_text  && (float)str_replace(',', '', $value->result0) > $data->high_result) {
                                    $result_arrow_sign_ind = '↑';
                                }
                                
                                }
                            if ($filteredArray  == true  && strtoupper($data->gender) == $gender_text) {
                                $referencevalue_value = $data->normal_result;
                            }
                        }

                        $result_data = [
                            'attr' => $value->attr,
                            'result0' => $value->result0,
                            'unit' => $value->unit,
                            'referencevalue' => $referencevalue_value,
                            'result_data_ind' => $result_data_ind,
                            'result_arrow_sign_ind' => $result_arrow_sign_ind,
                            'graph_ind' =>$value->graph_ind,
                        ];
                    } else {

                        $result_data_ind = 0;
                        $result_arrow_sign_ind='';
                        $result_data = [
                            'attr' => $value->attr,
                            'result0' => $value->result0,
                            'unit' => $value->unit,
                            'referencevalue' => $value->referencevalue,
                            'result_data_ind' => $result_data_ind,
                            'result_arrow_sign_ind' => $result_arrow_sign_ind,
                            'graph_ind' =>$value->graph_ind,
                        ];
                    }
                    $attr_group[$value->item_no_fk . '_' . $value->item_name . '_' . $value->item_code][$value->test_group_no_fk . '_' . $value->group_txt][] = (object) $result_data;
                } else {
                   
                    $attr_group[$value->item_no_fk . '_' . $value->item_name . '_' . $value->item_code][$value->test_group_no_fk . '_' . $value->group_txt][] = $value;
                }
            }            
            $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
            ];
            // AU_UPDATE_BY
            $data['au_update_by'] = $auth_id;
            $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
            DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);

            return view('admin.patient-portal.report.invoice', [
                "report_varcode" => $report_varcode, "report_label" => $report_label, "invoice_varcode" => $invoice_varcode, "report_header" => $report_header, 'po_hospital_details' => $po_hospital_details, 'data' => $data, "report_data" => $report_data, 'attr_group' => $attr_group, 'patient_varcode' => $patient_varcode
            ])->render();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    /**
     * Prescription Report
     */
    public function prescriptionReport($prescription_id , $type = "")
    {
        $options = new Options();
        $options->set('defaultFont', 'Kalpurush');
        $prescription_mst = DB::table('psn_t_prescription_vw')->where('prescription_no_pk', '=', $prescription_id)->first();

        $prescription_dtl = DB::table('psn_t_prescription_dtl_vw')->where('prescription_no_fk', '=', $prescription_id)->get();

        $prescription_med = DB::table('psn_t_prescription_med_vw')->where('prescription_no_fk', '=', $prescription_id)->orderBy('entry_serial', 'ASC')->get();
        $vitals =  DB::table('psn_t_patvitals')->where('prescription_no_fk', $prescription_id)->first();
        $doc_info = "";
        if (Session::get('user.ses_hospital_code') == 'IMPALA' || Session::get('user.ses_hospital_code') == 'EWMCH') {
            if ($prescription_mst->appoint_no_fk) {
                $appoint_info =  DB::table('PATN_APPOINTMENT')->where('appoint_no_pk', $prescription_mst->appoint_no_fk)->first();
                if ($appoint_info) {
                    $doc_info =  DB::table('HRMS_PERSONNEL')->where('person_no_pk', $appoint_info->doctor_no_fk)->first();
                }
            }
        }
        $barcode = new BarcodeGenerator();
        $barcode->setText($prescription_mst->patient_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode = $barcode->generate();

        $barcode1 = new BarcodeGenerator();
        $barcode1->setText($prescription_mst->prescription_uid);
        $barcode1->setType(BarcodeGenerator::Code128);
        $barcode1->setScale(1);
        $barcode1->setLabel('');
        $barcode1->setThickness(25);
        $barcode1->setFontSize(10);
        $prescription_barcode = $barcode1->generate();
        $ocular_arr = ["VAUA", "VAPH", "VAGLASS", "RETINA", "VITREOUS", "OCCULARMOTILITY", "EYELID", "IOP", "EYELASH", "SCLERA", "CORNEA", "CHOROID", "CONJUNCTIVAFORNICES", "OPTICNERVE", "AC", "CD", "PUPIL", "ANTERIORSEGMENT", "IRIS", "POSTERIORSEGMENT", "LENS", "N5"];

        $in_arr = $in_find_arr = $left_side_arr = $pr_arr = $dental_arr = $ocular_exam_left_arr = $ocular_exam_right_arr = $selected_dental_arr = $ele_thy_arr = $acup_thy_arr = $therapiu_therapy_arr = [];
        if (!empty($prescription_dtl)) {
            $investigation_arr = ["RAD", "LAB", "PROC", "FINDINGS"];
            $investigation_find_arr = [""];
            $investigation_find_uid_arr = ["INVFIND"];
            $acup_therapy = ["ACUP"];
            $electro_therapy = ["PTET"];
            $therapeutic_exce = ["PTTE"];
            $procedure_arr = ["SERVICE", "SUR", "PROCEDURE"];
            foreach ($prescription_dtl as $dtl_row) {
                $dental_arr[$dtl_row->lookup_uid][] = $dtl_row->lookupdata_uid . "_" . $dtl_row->prescrition_data;
                $selected_dental_arr[$dtl_row->lookupdata_uid] = $dtl_row->lookupdata_uid;

                if ($dtl_row->lookup_uid == "HISTORY" ||  $dtl_row->lookup_uid == "EXAMINATION") {
                    $left_side_arr[$dtl_row->lookup_uid][$dtl_row->lookupdata_uid][$dtl_row->prescrition_data] = $dtl_row->prescrition_data_dtl;
                } else {
                    $left_side_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                }
                if (in_array($dtl_row->lookup_uid, $ocular_arr)) {
                    if ($dtl_row->left_right_ind == "L") {
                        $ocular_exam_left_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }

                    if ($dtl_row->left_right_ind == "R") {
                        $ocular_exam_right_arr[$dtl_row->lookup_uid][] = $dtl_row->prescrition_data;
                    }
                }

                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["INV"][] = $dtl_row->prescrition_data;
                }
                if (in_array($dtl_row->lookupdata_uid, $investigation_arr)) {
                    $in_arr["FINDINGS"][] = $dtl_row->prescrition_data;
                }
                if ((in_array($dtl_row->lookupdata_uid, $investigation_find_arr) || in_array($dtl_row->lookupdata_uid, ["INVF101"])) && in_array($dtl_row->lookup_uid, $investigation_find_uid_arr)) {
                    $in_find_arr["INVF101"][] = $dtl_row->prescrition_data;
                }

                if (in_array($dtl_row->lookupdata_uid, $acup_therapy)) {
                    $acup_thy_arr["ACUP"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode;
                }
                if (in_array($dtl_row->lookupdata_uid, $electro_therapy)) {
                    $ele_thy_arr["PTET"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode;
                }
                if (in_array($dtl_row->lookupdata_uid, $therapeutic_exce)) {
                    $therapiu_therapy_arr["PTTE"][] = $dtl_row->prescrition_data . '_' . $dtl_row->session_duration . '_' . $dtl_row->session_mu_text . '_' . $dtl_row->no_of_session . '_' . $dtl_row->unit_intensity . '_' . $dtl_row->prescrition_phy_frequency . '_' . $dtl_row->prescrition_phy_mode;
                }

                if (in_array($dtl_row->lookup_uid, $procedure_arr)) {
                    $lookup_name = "Procedure";
                    $pr_arr["PROCEDURE"][] = $dtl_row->prescrition_data;
                }
            }
        }
        $pres_med = [];
        foreach ($prescription_med as $med) {
            $pres_med[$med->brand_name . '`' . $med->pack_type][$med->route . '^' . $med->dosage . '^' . $med->duration . '^' . $med->duration_mu . '^' . $med->item_qty . '^' . $med->instruction_take . '^' . $med->continue_ind . '^' . $med->multidose_txt][$med->multidose_txt] = $med;
        }
        $allergy =  DB::table('emr_allergies')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->where('prescription_no_fk', '=', $prescription_id)->get();
        $chronic_item =  DB::table('emr_chronic_disease')->where('appoint_no_fk', $prescription_mst->appoint_no_fk)->where('prescription_no_fk', '=', $prescription_id)->get();

        $data = [
            'prescription_mst' => $prescription_mst,
            "patient_barcode" => $patient_barcode,
            "prescription_barcode" => $prescription_barcode,
            "prescription_med" => $prescription_med,
            "left_side_arr" => $left_side_arr,
            "pr_arr" => $pr_arr,
            "in_arr" => $in_arr,
            "in_find_arr" => $in_find_arr,
            "dental_arr" => $dental_arr,
            "selected_dental_arr" => $selected_dental_arr,
            "ocular_exam_left_arr" => $ocular_exam_left_arr,
            "ocular_exam_right_arr" => $ocular_exam_right_arr,
            "vitals" => $vitals,
            "acup_thy_arr" => $acup_thy_arr,
            "ele_thy_arr" => $ele_thy_arr,
            "therapiu_therapy_arr" => $therapiu_therapy_arr,
            "allergy" => $allergy,
            "chronic_item" => $chronic_item,
            "doc_info" => $doc_info,
            "pres_med" => $pres_med
        ];

        // if (isset($prescription_mst) && $prescription_mst->physio_ind == 1) {
        //     return view("admin.prescription.phy_prescription_print_pdf", $data);
        // } else {
        //     if (Session::get('user.ses_hospital_code') == "IMPERIAL") {

        //         return view("admin.prescription.opd_prescription_print_pdf_imperial", $data);
        //     } elseif (Session::get('user.ses_hospital_code') == "AMCSH") {

        //         return view("admin.prescription.opd_prescription_print_pdf_amcsh", $data);
        //     } elseif (Session::get('user.ses_hospital_code') == "DMHL") {
        //         if (Session::get('user.serviceunit_code') == "GYNOB") {
        //             return view("admin.prescription.opd_prescription_print_pdf_dmgh_v2", $data);   
        //         }else {
        //             return view("admin.prescription.opd_prescription_print_pdf_dmgh", $data); 
        //         }
                
        //     } elseif (Session::get('user.ses_hospital_code') == "SSG") {
        //         return view("admin.prescription.opd_prescription_print_pdf_imperial", $data);
        //     } elseif (Session::get('user.ses_hospital_code') == "GMC") {
        //         return view("admin.prescription.opd_prescription_print_pdf_gmch", $data);
        //     } else {
        //         if (count($pres_med) > 10) {
        //             return view("admin.prescription.opd_prescription_print_v2", $data);
        //         } else {
        //             return view("admin.patient-portal.report.opd_prescription_print_pdf", $data);
        //         }
        //     }
        // }

        if (count($pres_med) > 10) {
            return view("admin.patient-portal.report.opd_prescription_print_v2", $data);
        } else {
            return view("admin.patient-portal.report.opd_prescription_print_pdf", $data);
        }
    }

    /**
     * Discharge Certificate
     */
    public function dischargeCertificate($id)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $discharge_data = DB::table('ipd_admitted_patlist_vw')->where('dis_ind', 1)->where('admission_no_pk', $id)->get();
        $admission_details = DB::table('ipd_admission_details')->where('admission_no_pk', $id)
            ->first();
        $med_data = DB::table("ipd_discharge_med")->where("admission_no_fk", $id)->where("continue_ind", 0)->get();
        $receive_med_data = DB::table("ipd_discharge_med")->where("admission_no_fk", $id)->where("continue_ind", 1)->get();
        $investigation_data = DB::table("ipd_discharge_investigation")->where("admission_no_fk", $id)->get();
        $item = ["LAB", "RAD"];
        $receive_investigation_data = DB::table("finc_ipd_invoicedtl_vw")->where("admission_no_fk", $id)->whereIn("item_type", $item)->get();
        $instructions = $this->getPresLookupListByCode("INSTRUCTION");
        $admite_id = $id;
        $patient_id = $discharge_data[0]->patient_code;
        //    dd($investigation_data);
        $title = $admite_id;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $title = $patient_id;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_barcode_no = $barcode->generate();

        $pdf = \App::make('dompdf.wrapper');
        $userInfo  = Auth::guard('patient')->user();
        
        $pdf = PDF::loadView(
            // 'admin.ipd.discharge.discharge_report',
            'admin.patient-portal.report.discharge_report_v2',
            [
                'po_hospital_details' => $po_hospital_details,
                'discharge_data' => $discharge_data,
                'userInfo' => $userInfo,
                'admission_details' => $admission_details,
                'barcode_no' => $barcode_no,
                'patient_barcode_no' => $patient_barcode_no,
                'med_data' => $med_data,
                'instructions' => $instructions,
                'investigation_data' => $investigation_data,
                'receive_med_data' => $receive_med_data,
                'receive_investigation_data' => $receive_investigation_data,
            ]
        );
        return $pdf->stream("Discharge Certificate.pdf", array("Attachment" => false));
    }

    /**
     * Change Password page for Patient Portal
     */
    public function passwordChange()
    {
        return view("admin.patient-portal.password-change");
    }

    /**
     * Update Password for Patient Portal
     */
    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        $errorMessage = "Sorry! Something went wrong.";
        return view("admin.patient-portal.password-change", compact('errorMessage'));

        // # Match The Old Password
        // if(!Hash::check($request->old_password, auth()->guard('patient')->user()->password)){
        //     $errorMessage = "Old Password Doesn't match!";
        //     return view("admin.patient-portal.password-change", compact('errorMessage'));
        // }
        
        // # Update the new Password
        // User::whereId(auth()->user()->id)->update([
        //     'password' => Hash::make($request->new_password)
        // ]);
    }

    public function logout()
    {
        Auth::guard('patient')->logout();
        return redirect()->route('patientPortal.showLoginForm');
    }
}
