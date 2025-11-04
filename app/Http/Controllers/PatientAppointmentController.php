<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Carbon\Carbon;
use App\Models\Doctor;
use App\Library\Template;
use App\Traits\DoctorData;
use App\Traits\LookupData;
use App\Traits\MailEngine;
use App\Models\HrmsSchedule;
use Illuminate\Http\Request;
use App\Models\PatnAppointment;
use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorScheduleRequest;
use App\Repositories\BaseRepository as Repo;
use App\Repositories\PatientAppointmentRepository;
use \PDF;
use QR;
use PDO;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use App\Models\Company;
use Session;

class PatientAppointmentController extends Controller
{
    use LookupData, DoctorData, MailEngine;
    protected $model;
    protected $appointment;
    protected $appointmentRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(HrmsSchedule $schedule, PatnAppointment $appointment)
    {
        // $this->middleware('auth');
        $this->model = new Repo($schedule);
        $this->appointment = new Repo($appointment);
        $this->appointmentRepository = new PatientAppointmentRepository($schedule);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $priority = $this->getLookupListByCode("PRIORITY");
        $gender = $this->getLookupListByCode("GENDER");
        $marsts = $this->getLookupListByCode("MARSTS");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $patient_type = DB::table('patn_patienttype')->select('patient_type_no_pk', 'patient_type_code', 'patient_type_desc')->where('status', 1)->where('au_entry_hospital_pk_no', session::get('user.ses_hospital_no_pk'))->get();

        return Template::loadView("admin.appointment.create_appointment", ['chiefcom' => $chiefcom, 'priority' => $priority, 'gender' => $gender, 'marsts' => $marsts, 'bloodg' => $bloodg, 'patient_type' => $patient_type]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($pabx_id = null)
    {
        if ($pabx_id != null) {
            $pabx_appointment = DB::table('patn_pabxappointment mst')
                ->join('doctor_info_vw dr', 'mst.DOCTOR_NO_FK', 'dr.PERSON_NO_PK')
                ->join('SYSC_LOOKUPDATA lookup', 'mst.sex', 'lookup.lookupdata_no_pk')
                ->where('mst.status', true)
                ->select('mst.pabxappointment_no_pk', 'mst.appoint_date', 'mst.DOCTOR_NO_FK', 'mst.PATIENT_NO_FK', 'mst.pat_name', 'mst.dob', 'mst.sex', 'mst.mobile_no', 'dr.full_name', 'lookup.lookupdata_name')
                ->where('PABXAPPOINTMENT_NO_PK', $pabx_id)
                ->first();
        } else {
            $pabx_appointment = [];
        }

        // $pabx_appointment = [
        //     'pat_name'          => request()->get('pat_name'),
        //     'doctor_name'       => request()->get('doctor_name'),
        //     'appointment_date'  => request()->get('appointment_date'),
        //     'sex'               => request()->get('sex'),
        //     'mobile'            => request()->get('mobile'),
        // ];

        $specialization = $this->getLookupListByCode("DOCSPL");
        $chiefcom = $this->getPresLookupIDByCode("CHIEFCOM");
        $priority = $this->getLookupListByCode("PRIORITY");
        $gender = $this->getLookupListByCode("GENDER");
        $marsts = $this->getLookupListByCode("MARSTS");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $visit_types = $this->getLookupListByCode("VISITTYPE");
        $name_prefix = $this->getLookupListByCode("NAMEPREFIX");
        $religion = $this->getLookupListByCode("RELIGION");
        $inform = $this->getLookupListByCode("INFORM");
        $patient_type = DB::table('patn_patienttype')->select('patient_type_no_pk', 'patient_type_code', 'patient_type_desc')->where('status', 1)->where('au_entry_hospital_pk_no', session::get('user.ses_hospital_no_pk'))->get();
        $corporate_info = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '!=', 0)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->orderBy('ccm_client_name', 'Asc')->get();
        $district = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();

        return Template::loadView("admin.patient.appointment", ['pabx_appointment' => $pabx_appointment, 'religion' => $religion, 'inform' => $inform, 'chiefcom' => $chiefcom, 'priority' => $priority, 'gender' => $gender, 'marsts' => $marsts, 'bloodg' => $bloodg, 'visit_types' => $visit_types, 'specialization' => $specialization, 'name_prefix' => $name_prefix, 'patient_type' => $patient_type, 'corporate_info' => $corporate_info, 'district' => $district]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_appointment_form(Request $request)
    {
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $priority = $this->getLookupListByCode("PRIORITY");
        $gender = $this->getLookupListByCode("GENDER");
        $marsts = $this->getLookupListByCode("MARSTS");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $district = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();

        return Template::loadView("admin.appointment.create_appointment", ['chiefcom' => $chiefcom, 'priority' => $priority, 'request' => $request, 'gender' => $gender, 'marsts' => $marsts, 'bloodg' => $bloodg, 'district' => $district]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function pat_appointment_list()
    {
        /*$this->sendMail("jahid0209@gmail.com", "Jahid Hasan"); die;
        echo $app_date = date("Y-m-d");
        $this->appointmentMail("jahid0209@gmail.com", "jahid Hasan", "Ahamed Beg", $app_date);
        die;*/
        $doctors = [];// Doctor::latest()->get();
        $specialization = [];// $this->getLookupListByCode("DOCSPL");
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $priority = $this->getLookupListByCode("PRIORITY");
        date_default_timezone_set('Asia/Dhaka');
        $time = Carbon::now();
        $appointment_date = date('Y-m-d', strtotime($time));
        $appointment_date = date("d-m-Y");
        $hospital_id = Session::get('user.ses_hospital_no_pk');

        $appointment_rs = DB::select("select A.*, B.PRESCRIPTION_NO_PK,a.invdtl_cancel_ind,
        C.APPOINT_SERVICE_NO_FK, C.INVOICE_NO_PK, C.INVOICE_TRN_LIST,user_data.user_fullname
        from PATN_APPOINTMENT_VW a
        left join wsec_user user_data on user_data.user_no_pk = A.au_entry_by
        left join (select APPOINT_NO_FK, max(PRESCRIPTION_NO_PK) PRESCRIPTION_NO_PK from PSN_T_PRESCRIPTION
        group by APPOINT_NO_FK)  b on A.APPOINT_NO_PK = B.APPOINT_NO_FK
        left join FINC_INVOICEMST_SUM_VW c on C.INVOICE_NO_PK = A.CONSULT_VOUCHER_NO_PK  where A.APPOINT_DATE = to_date('$appointment_date','dd/mm/yyyy') and A.AU_ENTRY_HOSPITAL_PK_NO = $hospital_id
        order by A.APPOINT_NO_PK desc ");
        // and nvl(a.cancel_ind,0) = 0
        $patient_type = [];// DB::table('patn_patienttype')->select('patient_type_no_pk', 'patient_type_code', 'patient_type_desc')->where('status', 1)->where('status', 1)->get();


        $app_arr = [];
        $pending_ind = $payment_ind = $cancel_ind = $prescription_ind = $invdtl_cancel_ind = 0;
        if (!empty($appointment_rs)) {
            foreach ($appointment_rs as $app_data) {

                if ($app_data->consult_ind == 1 && $app_data->cancel_ind == 0 && $app_data->invdtl_cancel_ind == 0) {
                    $payment_ind++;
                }

                if ($app_data->cancel_ind == 0 && $app_data->consult_ind == 0) {
                    $pending_ind++;
                }

                if ($app_data->cancel_ind == 1 ) {
                    $cancel_ind++;
                }
                if ($app_data->invdtl_cancel_ind == 1 && $app_data->cancel_ind == 0) {
                    $invdtl_cancel_ind++;
                }

                // if ($app_data->prescription_no_pk != "") {
                //     $prescription_ind++;
                // }

                if ($app_data->blank_pres_print_ind == 1) {
                    $prescription_ind++;
                }
            }
        }
        // dd( $cancel_ind);
        $page_type = "list";
        return Template::loadView("admin.patient.appointment_list", ['chiefcom' => $chiefcom, 'priority' => $priority, 'appointment_rs' => $appointment_rs, 'specialization' => $specialization, 'doctors' => $doctors, "pending_ind" => $pending_ind, "payment_ind" => $payment_ind, "invdtl_cancel_ind" => $invdtl_cancel_ind, "cancel_ind" => $cancel_ind, "prescription_ind" => $prescription_ind, "appointment_date" => $appointment_date, "page_type" => $page_type, 'patient_type' => $patient_type]);
    }

    public function free_pat_appointment_list()
    {
        /*$this->sendMail("jahid0209@gmail.com", "Jahid Hasan"); die;
        echo $app_date = date("Y-m-d");
        $this->appointmentMail("jahid0209@gmail.com", "jahid Hasan", "Ahamed Beg", $app_date);
        die;*/
        $doctors = Doctor::latest()->get();
        $specialization = $this->getLookupListByCode("DOCSPL");
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $priority = $this->getLookupListByCode("PRIORITY");
        $appointment_date = date("d-m-Y");

        $appointment_rs = DB::table("patn_appointment_vw a")
            ->select('a.*', 'b.prescription_no_pk', 'c.appoint_service_no_fk', 'c.invoice_no_pk')
            ->leftJoin("psn_t_prescription b", "a.appoint_no_pk", "=", "b.appoint_no_fk")
            ->leftJoin("FINC_INVOICEMST_SUM_VW c", "c.appoint_service_no_fk", "=", "a.appoint_no_pk")
            ->where("a.appoint_date", date("Y-m-d"))
            // ->where("a.appoint_type_code", "REPORT")
            ->where(function ($query) {
                $query->where("a.appoint_type_code", "REPORT")
                    ->orWhere('FREE_PAT_IND', '=', 1);
            })
            ->where("a.au_entry_hospital_pk_no", Session::get('user.ses_hospital_no_pk'))
            ->orderBy('a.appoint_no_pk', 'DESC')
            ->get();
        // dd($appointment_rs);
        $patient_type = DB::table('patn_patienttype')->select('patient_type_no_pk', 'patient_type_code', 'patient_type_desc')->where('status', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();


        $app_arr = [];
        $pending_ind = $payment_ind = $cancel_ind = $prescription_ind = $report_pat = $free_pat = 0;
        if (!empty($appointment_rs)) {
            foreach ($appointment_rs as $app_data) {
                if ($app_data->consult_ind == 1) {
                    $payment_ind++;
                }

                if ($app_data->cancel_ind == 0 && $app_data->consult_ind == 0) {
                    $pending_ind++;
                }

                if ($app_data->cancel_ind == 1) {
                    $cancel_ind++;
                }

                if ($app_data->prescription_no_pk != "") {
                    $prescription_ind++;
                }
                if ($app_data->appoint_type_code == "REPORT") {
                    $report_pat++;
                }
                if ($app_data->free_pat_ind == 1) {
                    $free_pat++;
                }
            }
        }
        $page_type = "list";
        return Template::loadView("admin.patient.free_patient.appointment_list", ['chiefcom' => $chiefcom, 'priority' => $priority, 'appointment_rs' => $appointment_rs, 'specialization' => $specialization, 'doctors' => $doctors, "pending_ind" => $pending_ind, "payment_ind" => $payment_ind, "cancel_ind" => $cancel_ind, "prescription_ind" => $prescription_ind, "appointment_date" => $appointment_date, "page_type" => $page_type, 'patient_type' => $patient_type, 'report_pat' => $report_pat, 'free_pat' => $free_pat]);
    }

    public function get_free_appointment_list_by_search(Request $request)
    {
        $appointment_date = date('Y-m-d', strtotime($request->app_date));
        // dd($appointment_date);
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $priority = $this->getLookupListByCode("PRIORITY");

        $appointment_qeury = DB::table("PATN_APPOINTMENT_VW a")
            ->select('a.*', 'b.prescription_no_pk', 'c.appoint_service_no_fk', 'c.invoice_no_pk')
            ->leftJoin("psn_t_prescription b", "a.appoint_no_pk", "=", "b.appoint_no_fk")
            ->leftJoin("FINC_INVOICEMST_SUM_VW c", "c.appoint_service_no_fk", "=", "a.appoint_no_pk")
            ->where(function ($query) {
                $query->where("a.appoint_type_code", "REPORT")
                    ->orWhere('FREE_PAT_IND', '=', 1);
            })
            ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));

        if ($request->app_date != "") {
            $appointment_qeury->when($appointment_date, function ($query, $appointment_date) {
                return $query->where('a.appoint_date', $appointment_date);
            });
        }

        if ($request->hdn_patient_id != "") {
            $appointment_qeury->when($request->hdn_patient_id, function ($query, $patient_id) {
                return $query->where('a.patient_no_pk', $patient_id);
            });
        }

        if ($request->hdn_doctor_id != "") {
            $appointment_qeury->when($request->hdn_doctor_id, function ($query, $doctor_code) {
                return $query->where('a.doctor_no_fk', $doctor_code);
            });
        }

        if ($request->cheif_compl != "") {
            $appointment_qeury->when($request->cheif_compl, function ($query, $cheif_compl) {
                return $query->where('a.chif_complain', $cheif_compl);
            });
        }


        if ($request->patient_type != "") {
            $appointment_qeury->when($request->patient_type, function ($query, $patient_type) {
                return $query->where('a.patient_type', $patient_type);
            });
        }


        $appointment_rs = $appointment_qeury->get();
        // dd($appointment_rs);
        $app_arr = [];
        $pending_ind = $payment_ind = $cancel_ind = $prescription_ind = $report_pat = $free_pat = 0;
        if (!empty($appointment_rs)) {
            foreach ($appointment_rs as $app_data) {

                if ($app_data->consult_ind == 1) {
                    $payment_ind++;
                } else {
                    $pending_ind++;
                }

                if ($app_data->cancel_ind == 1) {
                    $cancel_ind++;
                }

                if ($app_data->blank_pres_print_ind == 1) {
                    $prescription_ind++;
                }
                if ($app_data->appoint_type_code == "REPORT") {
                    $report_pat++;
                }
                if ($app_data->free_pat_ind == 1) {
                    $free_pat++;
                }
            }
        }

        $appointment_date = date("l, d M Y");

        $page_name = ($request->page_view_type == "list") ? "admin.patient.free_patient.appointment_list_table" : "admin.physiotherapy.prescription.ptherapy_appointment_list_card";

        return Template::loadView($page_name, ['chiefcom' => $chiefcom, 'priority' => $priority, 'appointment_rs' => $appointment_rs, 'appointment_date' => $appointment_date, "pending_ind" => $pending_ind, "payment_ind" => $payment_ind, "cancel_ind" => $cancel_ind, "prescription_ind" => $prescription_ind, 'report_pat' => $report_pat, 'free_pat' => $free_pat]);
    }
    public function free_appointment_list_pdf(request $request)
    {
        $toDate = date('Y/m/d');
        $appointment_date = date('Y/m/d', strtotime($request->app_date));
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $priority = $this->getLookupListByCode("PRIORITY");

        $appointment_qeury = DB::table("PATN_APPOINTMENT_VW a")
            ->select('a.*', 'b.prescription_no_pk', 'c.appoint_service_no_fk')
            ->leftJoin("psn_t_prescription b", "a.appoint_no_pk", "=", "b.appoint_no_fk")->leftJoin("FINC_INVOICEMST_SUM_VW c", "c.appoint_service_no_fk", "=", "a.appoint_no_pk")
            ->where(function ($query) {
                $query->where("a.appoint_type_code", "REPORT")
                    ->orWhere('FREE_PAT_IND', '=', 1);
            })
            ->orderBy('appoint_code', 'asc')
            ->orderBy('slot_sl', 'ASC');

        if ($request->app_date != "" || $request->patient_id != "" || $request->hdn_doctor_id != "" || $request->cheif_compl != "" || $request->app_priority != 0) {

            if ($request->app_date != "") {
                $appointment_qeury->when($appointment_date, function ($query, $appointment_date) {
                    return $query->where('a.appoint_date', $appointment_date);
                });
            }
            $appointment_qeury->when($request->patient_id, function ($query, $patient_id) {
                return $query->where('a.patient_name', $patient_id);
            });
            $appointment_qeury->when($request->hdn_doctor_id, function ($query, $doctor_code) {
                return $query->where('a.doctor_no_fk', $doctor_code);
            });
            $appointment_qeury->when($request->cheif_compl, function ($query, $cheif_compl) {
                return $query->where('a.chif_complain', $cheif_compl);
            });
            $appointment_qeury->when($request->app_priority, function ($query, $app_priority) {
                return $query->where('a.priority_no_fk', $app_priority);
            });
        } else {

            $appointment_qeury->when($toDate, function ($query, $toDate) {
                return $query->where('a.appoint_date', $toDate);
            });
        }
        $appointment_rs = $appointment_qeury->get();


        $app_arr = [];
        $pending_ind = $payment_ind = $cancel_ind = $prescription_ind = $report_pat = $free_pat = 0;
        if (!empty($appointment_rs)) {
            foreach ($appointment_rs as $app_data) {

                if ($app_data->consult_ind == 1) {
                    $payment_ind++;
                } else {
                    $pending_ind++;
                }

                if ($app_data->cancel_ind == 1) {
                    $cancel_ind++;
                }

                if ($app_data->blank_pres_print_ind == 1) {
                    $prescription_ind++;
                }
                if ($app_data->appoint_type_code == "REPORT") {
                    $report_pat++;
                }
                if ($app_data->free_pat_ind == 1) {
                    $free_pat++;
                }
            }
        }
        // dd($appointment_rs);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $appointments_date = $request->app_date != "" ? $request->app_date : '';
        $to_date = '';
        $barcode = new BarcodeGenerator();
        $barcode->setText("appointment list");
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $page_name = ($request->page_view_type == "list") ? "admin.patient.free_patient.free_appointment_list_print" : "admin.physiotherapy.prescription.ptherapy_appointment_list_card";
        $print_type = $request->print_type;
        if ($request->print_type == "PDF") {
            $pdf = PDF::loadView($page_name, ['chiefcom' => $chiefcom, 'priority' => $priority, 'appointment_rs' => $appointment_rs, 'appointment_date' => $appointment_date, "pending_ind" => $pending_ind, "payment_ind" => $payment_ind, "cancel_ind" => $cancel_ind, "prescription_ind" => $prescription_ind, 'print_type' => $print_type, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'to_date' => $to_date, 'appointments_date' => $appointments_date, 'report_pat' => $report_pat, 'free_pat' => $free_pat])->setPaper('a4', 'portrait');
            return $pdf->download('Appointment-List.pdf');
        }
        if ($request->print_type == "EXCEL") {
            $pdf = ['chiefcom' => $chiefcom, 'priority' => $priority, 'appointment_rs' => $appointment_rs, 'appointment_date' => $appointment_date, "pending_ind" => $pending_ind, "payment_ind" => $payment_ind, "cancel_ind" => $cancel_ind, "prescription_ind" => $prescription_ind, 'print_type' => $print_type, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'to_date' => $to_date, 'appointments_date' => $appointments_date, 'report_pat' => $report_pat, 'free_pat' => $free_pat];
            $fileToExport = "appointment-list";
            $html = View($page_name)->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }



        // return $pdf->stream('Appointment-List.pdf');


        // $report_data = DB::table("patn_appointment_vw")
        // ->select('appoint_code','slot_sl','full_name','patient_name','chif_complain','priority')->where("appoint_date", date("Y-m-d"))->get();

        // ;
        // $pdf = PDF::loadView("admin.appointment.appointment_list_print", ['report_data' => $report_data]);


    }

    public function free_appointmentList(Request $request)
    {
        //$this->sendMail();
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $priority = $this->getLookupListByCode("PRIORITY");

        $appointment_date = date("Y-m-d", strtotime(date("d-m-Y")));
        $appointment_rs = DB::table("patn_appointment_vw")
            ->select("patn_appointment_vw.*", "prest_prescriptionmst_physio_vw.prescription_no_pk")
            ->leftjoin("prest_prescriptionmst_physio_vw", "patn_appointment_vw.appoint_no_pk", "=", "prest_prescriptionmst_physio_vw.appointment_no_fk")
            ->orderBy("patn_appointment_vw.appoint_no_pk", "desc")
            ->where("appoint_date", $appointment_date)->get();

        $app_arr = [];
        $pending_ind = $payment_ind = $cancel_ind = $prescription_ind = 0;
        if (!empty($appointment_rs)) {
            foreach ($appointment_rs as $app_data) {
                if ($app_data->consult_ind == 1) {
                    $payment_ind++;
                }

                if ($app_data->cancel_ind == 0 && $app_data->consult_ind == 0) {
                    $pending_ind++;
                }

                if ($app_data->cancel_ind == 1) {
                    $cancel_ind++;
                }

                if ($app_data->prescription_no_pk != "") {
                    $prescription_ind++;
                }
            }
        }
        $page_type = "grid";
        return Template::loadView("admin.physiotherapy.prescription.ptherapy_appointment_list", ['chiefcom' => $chiefcom, 'priority' => $priority, 'appointment_rs' => $appointment_rs, 'appointment_date' => $appointment_date, "pending_ind" => $pending_ind, "payment_ind" => $payment_ind, "cancel_ind" => $cancel_ind, "prescription_ind" => $prescription_ind, "page_type" => $page_type]);
    }



    public function changeAppDate($id)
    {
        $doctor_shedule = [];
        $appointment_card = DB::table('PATN_APPOINTMENT_VW')->where('appoint_no_pk', '=', $id)->first();
        if ($appointment_card->start_time && $appointment_card->end_time) {
            return Template::loadView("admin.patient.chenge_app_date_slot", ['slot_ind' => 1, 'doctor_shedule' => $doctor_shedule, 'appointment_card' => $appointment_card]);
        }
        // dd($appointment_card);


        return Template::loadView("admin.patient.chenge_app_date", ['doctor_shedule' => $doctor_shedule, 'appointment_card' => $appointment_card]);
    }
    public function updateAppDateAndTime(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $id = $request->id;
            $data = [];
            if ($request->slot_ind) {
                $start_time = $request->date_pic . " " . $request->shift_start_time;
                $end_time = $request->date_pic . " " . $request->shift_end_time;

                $data = [
                    'appoint_date' => date("Y-m-d", strtotime($request->date_pic)),
                    'start_time' => date("Y-m-d H:i", strtotime($start_time)),
                    'end_time' => date("Y-m-d H:i", strtotime($end_time))
                ];
            } else {
                $start_time = $request->date_pic . " " . $request->shift_start_time;

                $data = [
                    'patn_appoint_update_ind' => 1,
                    'appoint_date' => date("Y-m-d", strtotime($request->date_pic)),
                    'au_entry_at' => date("Y-m-d H:i", strtotime($start_time))
                ];
            }
            $app_info = DB::table("patn_appointment_vw")
                ->where("appoint_no_pk", $id)
                ->first();
            $update_ind = 1;
            $sms = $this->sendSms($request->date_pic, $request->shift_start_time, $app_info->end_time, $app_info->mobile1, $app_info->full_name_bangla, $app_info->full_name, $app_info->slot_sl, $app_info->specialization_bangla, $app_info->phone_mobile, $app_info->au_entry_at, $update_ind);


            DB::table('patn_appointment')->where('appoint_no_pk', $id)->update($data);

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }



    public function pat_appointment_list_doctor_wise()
    {
        /*$this->sendMail("jahid0209@gmail.com", "Jahid Hasan"); die;
        echo $app_date = date("Y-m-d");
        $this->appointmentMail("jahid0209@gmail.com", "jahid Hasan", "Ahamed Beg", $app_date);
        die;*/
        $doctors = Doctor::latest()->get();
        $specialization = $this->getLookupListByCode("DOCSPL");
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $priority = $this->getLookupListByCode("PRIORITY");
        $appointment_date = date("d-m-Y");

        $auth_id = Auth::id();
        $person_id = DB::table("wsec_user")->select("person_no_fk")->where("user_no_pk", $auth_id)->first();

        $appointment_rs = DB::table("patn_appointment_vw a")
            ->select('a.*', 'b.prescription_no_pk', 'c.appoint_service_no_fk', 'c.invoice_no_pk')
            ->leftJoin("psn_t_prescription b", "a.appoint_no_pk", "=", "b.appoint_no_fk")
            ->leftJoin("FINC_INVOICEMST_SUM_VW c", "c.appoint_service_no_fk", "=", "a.appoint_no_pk")
            ->where('a.doctor_no_fk', $person_id->person_no_fk)
            ->orderBy('a.appoint_no_pk', 'DESC')
            ->get();
        //->where("a.appoint_date", date("Y-m-d"))

        $app_arr = [];
        $pending_ind = $payment_ind = $cancel_ind = $prescription_ind = 0;
        if (!empty($appointment_rs)) {
            foreach ($appointment_rs as $app_data) {
                if ($app_data->consult_ind == 1) {
                    $payment_ind++;
                }

                if ($app_data->cancel_ind == 0 && $app_data->consult_ind == 0) {
                    $pending_ind++;
                }

                if ($app_data->cancel_ind == 1) {
                    $cancel_ind++;
                }

                if ($app_data->prescription_no_pk != "") {
                    $prescription_ind++;
                }
            }
        }
        $page_type = "list";
        return Template::loadView("admin.patient.appointment_list_doctor_wise", ['chiefcom' => $chiefcom, 'priority' => $priority, 'appointment_rs' => $appointment_rs, 'specialization' => $specialization, 'doctors' => $doctors, "pending_ind" => $pending_ind, "payment_ind" => $payment_ind, "cancel_ind" => $cancel_ind, "prescription_ind" => $prescription_ind, "appointment_date" => $appointment_date, "page_type" => $page_type]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function appointmentList(Request $request)
    {
        //$this->sendMail();
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $priority = $this->getLookupListByCode("PRIORITY");

        $appointment_date = date("Y-m-d", strtotime(date("d-m-Y")));
        $appointment_rs = DB::table("patn_appointment_vw")
            ->select("patn_appointment_vw.*", "prest_prescriptionmst_physio_vw.prescription_no_pk")
            ->leftjoin("prest_prescriptionmst_physio_vw", "patn_appointment_vw.appoint_no_pk", "=", "prest_prescriptionmst_physio_vw.appointment_no_fk")
            ->orderBy("patn_appointment_vw.appoint_no_pk", "desc")
            ->where("appoint_date", $appointment_date)->get();

        $app_arr = [];
        $pending_ind = $payment_ind = $cancel_ind = $prescription_ind = 0;
        if (!empty($appointment_rs)) {
            foreach ($appointment_rs as $app_data) {
                if ($app_data->consult_ind == 1) {
                    $payment_ind++;
                }

                if ($app_data->cancel_ind == 0 && $app_data->consult_ind == 0) {
                    $pending_ind++;
                }

                if ($app_data->cancel_ind == 1) {
                    $cancel_ind++;
                }

                if ($app_data->prescription_no_pk != "") {
                    $prescription_ind++;
                }
            }
        }
        $page_type = "grid";
        return Template::loadView("admin.physiotherapy.prescription.ptherapy_appointment_list", ['chiefcom' => $chiefcom, 'priority' => $priority, 'appointment_rs' => $appointment_rs, 'appointment_date' => $appointment_date, "pending_ind" => $pending_ind, "payment_ind" => $payment_ind, "cancel_ind" => $cancel_ind, "prescription_ind" => $prescription_ind, "page_type" => $page_type]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel_appointment_form($appointment_id)
    {
        $app_info = DB::table("patn_appointment_vw")
            ->where("appoint_no_pk", $appointment_id)
            ->first()->pat_email_address;

        return Template::loadView("admin.appointment.cancel_appointment_form", ['appointment_id' => $appointment_id, 'app_info' => $app_info]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function cancel_appointment(Request $request)
    {
        $app_info = DB::table("patn_appointment_vw")
            ->where("appoint_no_pk", $request->hdn_appointment_id)
            ->first();
        // dd($app_info);

        $auth_id = Auth::id();
        DB::beginTransaction();
        try {
            $data = [
                'cancel_ind' => 1,
                'cancel_reason' => $request->txt_cancel_reason,
                'au_update_by' => $auth_id
            ];

            if ($this->appointment->update($data, $request->hdn_appointment_id)) {
                if ($request->cancelSms != null) {
                    $sms = $this->appCancelSms($app_info->appoint_date, $app_info->mobile1, $app_info->full_name, $app_info->slot_sl, $app_info->specialization_bangla);
                }
                if ($request->cancelEmail != null) {

                    //        email Part

                    // $pdf = PDF::loadview('iCure-Home');
                    // return $pdf->download('Emr-report.pdf');
                    $company_profile = Company::orderBy('hospital_no_pk', 'desc')->first();
                    $company_number = isset($company_profile->telephone1) ? $company_profile->telephone1 : '01700000000';
                    $app_date = date("d/m/Y", strtotime($app_info->appoint_date));
                    $email_addr = $app_info->pat_email_address;
                    $m_body = "আসসালামুআলাইকুম, $app_info->specialization_bangla বিশেষজ্ঞ $app_info->full_name এর $app_date তারিখে $app_info->slot_sl নং সিরিয়াল বাতিল করা হয়েছে।  প্রয়োজনেঃ $company_number";

                    $to_email = $email_addr; //$app_info->email;
                    $to_name = $app_info->patient_name;
                    $subject = 'Cancel Appointment';
                    $mail_body = $m_body;
                    $doc_mail_body = 'Doctor Email';
                    $this->sendEmailCancelPatient($to_email, $to_name, $subject, $mail_body, $request->email_personal, $doc_mail_body);
                    //        email part end

                }
            }


            DB::commit();
            $message = ['msg' => 'Appointment Canceled Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function appointment_consulation_confirm($appointment_id)
    {
        return $this->appointmentRepository->consulationConfirm($appointment_id);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function get_appointment_list_by_search(Request $request)
    {
        // dd($request->all());

        $appointment_date = date('Y-m-d', strtotime($request->search_date_from));
        $from_date = $request->search_date_from != "" ? date("Y-m-d", strtotime($request->search_date_from)) : '';
        $to_date = $request->search_date_to != "" ? date("Y-m-d", strtotime($request->search_date_to)) : '';
        // dd($from_date,$to_date);
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $priority = $this->getLookupListByCode("PRIORITY");
        if (Session::get('user.ses_hospital_code') != 'IMPALA') {
            $appointment_qeury = DB::table("PATN_APPOINTMENT_VW a")
                ->select('a.appoint_code', 'a.appoint_date', 'a.start_time', 'a.end_time', 'a.au_entry_at', 'a.invdtl_cancel_ind', 'a.doctor_no_fk', 'a.doctor_photo', 'a.doc_gender_txt', 'a.person_code', 'a.full_name', 'a.degree1', 'a.degree2', 'a.degree3', 'a.degree4', 'a.specialization', 'a.phone_mobile', 'a.patient_photo', 'a.patient_code', 'a.patient_name', 'a.mobile1', 'a.chif_complain', 'a.priority', 'a.patient_type_code', 'a.first_ref_name', 'a.second_ref_name', 'a.appoint_no_pk', 'a.cancel_ind', 'a.consult_ind', 'a.physio_ind', 'a.patient_no_pk', 'a.gender_txt', 'a.age', 'a.blank_pres_print_ind', 'b.prescription_no_pk', 'c.appoint_service_no_fk', 'c.invoice_no_pk', 'c.invoice_trn_list', 'u.user_fullname')
                ->leftJoin("wsec_user u", "u.user_no_pk", "=", "A.au_entry_by")
                ->leftJoin("psn_t_prescription b", "a.appoint_no_pk", "=", "b.appoint_no_fk")
                ->leftJoin("FINC_INVOICEMST_SUM_VW c", "c.appoint_service_no_fk", "=", "a.appoint_no_pk")
                ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));
            // ->where('c.MODULE_CODE', 'OPDC');

            // if ($request->app_date != "") {
            //     $appointment_qeury->when($appointment_date, function ($query, $appointment_date) {
            //         return $query->where('a.appoint_date', $appointment_date);
            //     });
            // }
            if ($from_date != "" && $to_date != "") {
                // dd($from_date , $to_date);
                $appointment_qeury->where(DB::raw("trunc(a.appoint_date)"), '>=', $from_date);
                $appointment_qeury->where(DB::raw("trunc(a.appoint_date)"), '<=', $to_date);
            }

            if ($request->hdn_patient_id != "") {
                $appointment_qeury->when($request->hdn_patient_id, function ($query, $patient_id) {
                    return $query->where('a.patient_no_pk', $patient_id);
                });
            }

            if ($request->hdn_app_user != "") {

                $user_id = DB::table('wsec_user')->select('user_no_pk')->where('person_no_fk', $request->hdn_app_user)->first();

                $appointment_qeury->when($user_id->user_no_pk, function ($query, $emp_id) {
                    return $query->where('a.au_entry_by', $emp_id);
                });
            }
            if ($request->hdn_doctor_id != "") {
                $appointment_qeury->when($request->hdn_doctor_id, function ($query, $doctor_code) {
                    return $query->where('a.doctor_no_fk', $doctor_code);
                });
            }

            if ($request->cheif_compl != "") {
                $appointment_qeury->when($request->cheif_compl, function ($query, $cheif_compl) {
                    return $query->where('a.chif_complain', $cheif_compl);
                });
            }


            if ($request->patient_type != "") {
                $appointment_qeury->when($request->patient_type, function ($query, $patient_type) {
                    return $query->where('a.patient_type', $patient_type);
                });
            }

            /**
             * Status
             */
            // Pending
            $appointment_qeury->when($request->status == "pending", function ($query) {
                return $query->where('a.cancel_ind', 0)->where('a.consult_ind', 0);
            });

            // Payment
            $appointment_qeury->when($request->status == "payment", function ($query) {
                return $query->where('a.consult_ind', 1);
            });

            // Canceled
            $appointment_qeury->when($request->status == "canceled", function ($query) {
                return $query->where('a.cancel_ind', 1);
            });

            // Canceled
            $appointment_qeury->when($request->status == "Payment Cancel", function ($query) {
                return $query->where('a.invdtl_cancel_ind', 1);
            });
        } else {
            // dd($request->all());
            $toDate = date('Y/m/d');
            $appointment_date = date('Y-m-d', strtotime($request->search_date_from));
            $from_date = $request->search_date_from != "" ? date("Y-m-d", strtotime($request->search_date_from)) : '';
            $to_date = $request->search_date_to != "" ? date("Y-m-d", strtotime($request->search_date_to)) : '';
            $chiefcom = $this->getLookupListByCode("CHIEFCOM");
            $priority = $this->getLookupListByCode("PRIORITY");

            $appointment_qeury = DB::table("PATN_APPOINTMENT_VW a")
                ->select('a.appoint_code', 'a.appoint_date', 'a.start_time', 'a.end_time', 'a.au_entry_at', 'a.doctor_no_fk', 'a.doctor_photo', 'a.doc_gender_txt', 'a.person_code', 'a.full_name', 'a.degree1', 'a.degree2', 'a.degree3', 'a.degree4', 'a.specialization', 'a.phone_mobile', 'a.patient_photo', 'a.patient_code', 'a.patient_name', 'a.mobile1', 'a.chif_complain', 'a.priority', 'a.patient_type_code', 'a.first_ref_name', 'a.second_ref_name', 'a.appoint_no_pk', 'a.cancel_ind', 'a.consult_ind', 'a.physio_ind', 'a.patient_no_pk', 'a.gender_txt', 'a.age', 'a.blank_pres_print_ind', 'a.invdtl_cancel_ind', 'b.prescription_no_pk', 'c.appoint_service_no_fk', 'c.invoice_trn_list', 'u.user_fullname')
                ->leftJoin("wsec_user u", "u.user_no_pk", "=", "A.au_entry_by")
                ->leftJoin("psn_t_prescription b", "a.appoint_no_pk", "=", "b.appoint_no_fk")->leftJoin("FINC_INVOICEMST_SUM_VW c", "c.appoint_service_no_fk", "=", "a.appoint_no_pk")->orderBy('appoint_code', 'asc')->orderBy('slot_sl', 'ASC');

            if ($from_date != "" || $request->patient_id != "" || $request->hdn_doctor_id != "" || $request->cheif_compl != "" || $request->app_priority != 0 || $request->status != "") {

                // if ($request->app_date != "") {
                //     $appointment_qeury->when($appointment_date, function ($query, $appointment_date) {
                //         return $query->where('a.appoint_date', $appointment_date);
                //     });
                // }
                if ($from_date != "" && $to_date != "") {
                    $appointment_qeury->where(DB::raw("trunc(a.appoint_date)"), '>=', $from_date);
                    $appointment_qeury->where(DB::raw("trunc(a.appoint_date)"), '<=', $to_date);
                }

                if ($request->hdn_patient_id != "") {
                    $appointment_qeury->when($request->hdn_patient_id, function ($query, $patient_id) {
                        return $query->where('a.patient_no_pk', $patient_id);
                    });
                }

                if ($request->hdn_doctor_id != "") {
                    $appointment_qeury->when($request->hdn_doctor_id, function ($query, $doctor_code) {
                        return $query->where('a.doctor_no_fk', $doctor_code);
                    });
                }

                if ($request->cheif_compl != "") {
                    $appointment_qeury->when($request->cheif_compl, function ($query, $cheif_compl) {
                        return $query->where('a.chif_complain', $cheif_compl);
                    });
                }


                if ($request->patient_type != "") {
                    $appointment_qeury->when($request->patient_type, function ($query, $patient_type) {
                        return $query->where('a.patient_type', $patient_type);
                    });
                }

                /**
                 * Status
                 */
                // Pending
                $appointment_qeury->when($request->status == "pending", function ($query) {
                    return $query->where('a.cancel_ind', 0)->where('a.consult_ind', 0);
                });

                // Payment
                $appointment_qeury->when($request->status == "payment", function ($query) {
                    return $query->where('a.consult_ind', 1);
                });

                // Canceled
                $appointment_qeury->when($request->status == "canceled", function ($query) {
                    return $query->where('a.cancel_ind', 1);
                });
            } else {

                $appointment_qeury->when($toDate, function ($query, $toDate) {
                    return $query->where('a.appoint_date', $toDate);
                });
            }
        }
        $appointment_rs = $appointment_qeury->get();
        $app_arr = [];
        $pending_ind = $payment_ind = $cancel_ind = $prescription_ind = $invdtl_cancel_ind = 0;
        if (!empty($appointment_rs)) {
            foreach ($appointment_rs as $app_data) {

                if ($app_data->consult_ind == 1 && $app_data->cancel_ind == 0 && $app_data->invdtl_cancel_ind == 0) {
                    $payment_ind++;
                }

                if ($app_data->cancel_ind == 0 && $app_data->consult_ind == 0) {
                    $pending_ind++;
                }

                if ($app_data->cancel_ind == 1) {
                    $cancel_ind++;
                }
                if ($app_data->invdtl_cancel_ind == 1 && $app_data->cancel_ind == 0) {
                    $invdtl_cancel_ind++;
                }

                // if ($app_data->prescription_no_pk != "") {
                //     $prescription_ind++;
                // }

                if ($app_data->blank_pres_print_ind == 1) {
                    $prescription_ind++;
                }
            }
        }
        $appointment_date = date("l, d M Y");

        $page_name = ($request->page_view_type == "list") ? "admin.appointment.appointment_list_data" : "admin.physiotherapy.prescription.ptherapy_appointment_list_card";

        return Template::loadView($page_name, ['chiefcom' => $chiefcom, 'priority' => $priority, 'appointment_rs' => $appointment_rs, 'appointment_date' => $appointment_date, "pending_ind" => $pending_ind, "payment_ind" => $payment_ind, "cancel_ind" => $cancel_ind, "invdtl_cancel_ind" => $invdtl_cancel_ind, "prescription_ind" => $prescription_ind]);
    }



    public function get_appointment_list_by_search_doctor_wise(Request $request)
    {

        $appointment_date = date('Y-m-d', strtotime($request->app_date));
        // dd($appointment_date);
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $priority = $this->getLookupListByCode("PRIORITY");

        $appointment_qeury = DB::table("PATN_APPOINTMENT_VW a")
            ->select('a.*', 'b.prescription_no_pk', 'c.appoint_service_no_fk', 'c.invoice_no_pk')
            ->leftJoin("psn_t_prescription b", "a.appoint_no_pk", "=", "b.appoint_no_fk")
            ->leftJoin("FINC_INVOICEMST_SUM_VW c", "c.appoint_service_no_fk", "=", "a.appoint_no_pk");

        if ($request->app_date != "") {
            $appointment_qeury->when($appointment_date, function ($query, $appointment_date) {
                return $query->where('a.appoint_date', $appointment_date);
            });
        }
        $appointment_qeury->when($request->patient_id, function ($query, $patient_id) {
            return $query->where('a.patient_name', $patient_id);
        });
        $appointment_qeury->when($request->hdn_doctor_id, function ($query, $doctor_code) {
            return $query->where('a.doctor_no_fk', $doctor_code);
        });
        $appointment_qeury->when($request->cheif_compl, function ($query, $cheif_compl) {
            return $query->where('a.chif_complain', $cheif_compl);
        });
        $appointment_qeury->when($request->app_priority, function ($query, $app_priority) {
            return $query->where('a.priority_no_fk', $app_priority);
        });
        $auth_id = Auth::id();
        $person_id = DB::table("wsec_user")->select("person_no_fk")->where("user_no_pk", $auth_id)->first();


        $appointment_rs = $appointment_qeury->where('a.doctor_no_fk', $person_id->person_no_fk)->get();

        $app_arr = [];
        $pending_ind = $payment_ind = $cancel_ind = $prescription_ind = 0;
        if (!empty($appointment_rs)) {
            foreach ($appointment_rs as $app_data) {

                if ($app_data->consult_ind == 1) {
                    $payment_ind++;
                } else {
                    $pending_ind++;
                }

                if ($app_data->cancel_ind == 1) {
                    $cancel_ind++;
                }

                if ($app_data->blank_pres_print_ind == 1) {
                    $prescription_ind++;
                }
            }
        }

        $appointment_date = date("l, d M Y");

        $page_name = ($request->page_view_type == "list") ? "admin.patient.appointment_list_table_doctor_wise" : "admin.physiotherapy.prescription.ptherapy_appointment_list_card";

        return Template::loadView($page_name, ['chiefcom' => $chiefcom, 'priority' => $priority, 'appointment_rs' => $appointment_rs, 'appointment_date' => $appointment_date, "pending_ind" => $pending_ind, "payment_ind" => $payment_ind, "cancel_ind" => $cancel_ind, "prescription_ind" => $prescription_ind]);
    }



    public function get_appointment_card($id)
    {
        $appointment_card = DB::table('PATN_APPOINTMENT_VW')->where('appoint_no_pk', '=', $id)->first();
        $bill_id = DB::table('billing_list_vw')->select('invoice_no_pk', 'invoice_trn_list')->where('appoint_service_no_fk', $id)->first();

        return Template::loadView('admin.appointment.appointment_card', ['appointment_card' => $appointment_card, 'bill_id' => $bill_id]);
    }

    public function get_sales_price(Request $request)
    {
        $s_price = DB::table('doctor_wise_consult_fee_vw')
            ->where('doc_id', '=', $request->doctor_id)
            ->where('visit_type_lookup_no_fk', '=', $request->v_type)
            ->select('sales_price', 'item_no_fk', 'lookupdata_code', 'visit_type_lookup_no_fk')->first();
        return response()->json($s_price);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function appointment_consultation()
    {
        return Template::loadView("admin.appointment.pat_appointment_consultation");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */



    public function store(Request $request)
    {
        return $this->appointmentRepository->createOrUpdatePatientAppointment($request, $request->id);
    }

    public function coverStore(Request $request)
    {
        return $this->appointmentRepository->coverPatientAppointment($request, $request->id);
    }
    public function test()
    {
        return Template::loadView("admin.test-sms");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete_appointment_by_id($id)
    {
        $auth_id = Auth::id();
        DB::beginTransaction();
        try {
            $data = [
                'cancel_ind' => 1,
                'au_update_by' => $auth_id
            ];

            $this->appointment->update($data, $id);

            DB::commit();
            $message = ['msg' => 'Appointment Canceled Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function doctor_schedule($doctor_id = null)
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
        $shift = DB::SELECT("select shift_no_pk,shift_code,shift_desc,start_time,end_time from hrms_shift where au_entry_hospital_pk_no  =  $hospital_id");
        return Template::loadView("admin.patient.doctors_schedule_viewer", ['docspl' => $docspl, 'shift' => $shift, 'doctor_info' => $doctor_info, 'schedules' => $schedules]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_doctor_schedule(DoctorScheduleRequest $request)
    {
        return $this->appointmentRepository->createOrUpdate($request);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_appointment_list_by_doctor_date(Request $request)
    {
        $doctor_id = $request->doctor_id;

        $appointment_dt = new Carbon($request->appointment_date);
        $app_date = date("Y-M-d", strtotime($appointment_dt->toDateString()));

        $appointment_list = DB::table("patn_appointment_vw")
            ->where("cancel_ind", 0)
            ->where('doctor_no_fk', '=', $doctor_id)
            ->where('appoint_date', '=', $app_date)
            ->where("cancel_ind", 0)
            ->get();

        $chiefcom = $this->getLookupListByCode("CHIEFCOM");

        return Template::loadView("admin.appointment.appointment_list_by_doctor_date", ['appointment_list' => $appointment_list]);
    }

    public function delete_doctor_schedule(Request $request)
    {
        HrmsSchedule::where('schedule_no_pk', $request->schedule_id)->delete();
        $doctor_id = $request->doctor_id;
        $schedules = DB::SELECT("select a.schedule_no_pk, a.doctor_person_no_fk, a.schedule_dt, b.shift_desc, a.start_time, a.end_time, a.avg_duration, a.avg_load, a.block_load from hrms_schedule a ,  hrms_shift  b where  b.shift_no_pk = a.shift_no_fk and a.doctor_person_no_fk = '$doctor_id' ");

        $returnHTML = view('admin.patient.doctor_schedule')->with('schedules', $schedules)->render();
        $arr = array('msg' => 'Doctor schedule', 'status' => 'success', 'html' => $returnHTML);
        return response()->json($arr);
    }

    public function delete_doctor_schedule_all(Request $request)
    {
        $doctor_id = $request->doctor_id;
        $from_date = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : '';
        $shift_type = $request->shift_type ? $request->shift_type : '';
        $pp = DB::table('hrms_schedule')->where('doctor_person_no_fk', '=', $doctor_id)
            ->when($from_date != '', function ($q) use ($from_date) {
                return $q->where('schedule_dt', '>=', $from_date);
            })
            ->when($to_date != '', function ($q) use ($to_date) {
                return $q->where('schedule_dt', '<=', $to_date);
            })
            ->when($shift_type != '', function ($q) use ($shift_type) {
                return $q->where('shift_no_pk', '=', $shift_type);
            })->delete();

        $schedules = DB::SELECT("select a.schedule_no_pk, a.doctor_person_no_fk, a.schedule_dt, b.shift_desc, a.start_time, a.end_time, a.avg_duration, a.avg_load, a.block_load from hrms_schedule a ,  hrms_shift  b where  b.shift_no_pk = a.shift_no_fk and a.doctor_person_no_fk = '$doctor_id' ");

        $returnHTML = view('admin.patient.doctor_schedule')->with('schedules', $schedules)->render();
        $arr = array('msg' => 'Doctor schedule', 'status' => 'success', 'html' => $returnHTML);
        return response()->json($arr);
    }

    public function get_doctor_schedule(Request $request)
    {
        $doctor_id = $request->doctor_id;
        // dd($doctor_id);
        $from_date = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : '';
        $shift_type = $request->shift_type ? $request->shift_type : '';

        // $schedules = HrmsSchedule::where('doctor_person_no_fk', '=', $doctor_id)
        //     ->join('hrms_shift', 'hrms_schedule.shift_no_fk', '=', 'hrms_shift.shift_no_pk')
        //     ->when($from_date != '', function ($q) use ($from_date) {
        //         return $q->where('hrms_schedule.schedule_dt', '>=', $from_date);
        //     })
        //     ->when($to_date != '', function ($q) use ($to_date) {
        //         return $q->where('hrms_schedule.schedule_dt', '<=', $to_date);
        //     })
        //     ->when($shift_type != '', function ($q) use ($shift_type) {
        //         return $q->where('hrms_shift.shift_no_pk', '=', $shift_type);
        //     })

        //     ->select('hrms_schedule.schedule_no_pk', 'hrms_schedule.doctor_person_no_fk', 'hrms_schedule.schedule_dt', 'hrms_shift.shift_desc', 'hrms_schedule.start_time', 'hrms_schedule.end_time', 'hrms_schedule.avg_duration', 'hrms_schedule.avg_load', 'hrms_schedule.block_load')
        //     ->orderBy('hrms_schedule.schedule_dt', 'asc')
        //     ->get();
        //dd($schedules);
        $schedules = DB::table('hrms_schedule_slot_vw')
            ->leftjoin('hrms_schedule_dayoff', 'hrms_schedule_dayoff.schedule_no_fk', 'hrms_schedule_slot_vw.schedule_no_pk')
            ->where('hrms_schedule_slot_vw.doctor_person_no_fk', '=', $doctor_id)
            ->when($from_date != '', function ($q) use ($from_date) {
                return $q->where('hrms_schedule_slot_vw.schedule_dt', '>=', $from_date);
            })
            ->when($to_date != '', function ($q) use ($to_date) {
                return $q->where('hrms_schedule_slot_vw.schedule_dt', '<=', $to_date);
            })
            ->when($shift_type != '', function ($q) use ($shift_type) {
                return $q->where('hrms_schedule_slot_vw.shift_no_pk', '=', $shift_type);
            })
            ->select(
                'hrms_schedule_slot_vw.schedule_no_pk',
                'hrms_schedule_slot_vw.doctor_person_no_fk',
                'hrms_schedule_slot_vw.schedule_dt',
                'hrms_schedule_slot_vw.shift_desc',
                'hrms_schedule_slot_vw.start_time',
                'hrms_schedule_slot_vw.end_time',
                'hrms_schedule_slot_vw.avg_duration',
                'hrms_schedule_slot_vw.avg_load',
                'hrms_schedule_slot_vw.block_load',
                'hrms_schedule_slot_vw.total_slot',
                DB::raw('count(hrms_schedule_dayoff.schedule_no_fk) schedule_count')
            )
            ->groupBy('hrms_schedule_slot_vw.schedule_no_pk', 'hrms_schedule_slot_vw.doctor_person_no_fk', 'hrms_schedule_slot_vw.schedule_dt', 'hrms_schedule_slot_vw.shift_desc', 'hrms_schedule_slot_vw.start_time', 'hrms_schedule_slot_vw.end_time', 'hrms_schedule_slot_vw.avg_duration', 'hrms_schedule_slot_vw.avg_load', 'hrms_schedule_slot_vw.block_load', 'hrms_schedule_slot_vw.total_slot')
            ->orderBy('hrms_schedule_slot_vw.schedule_dt')
            ->get();
        // dd($schedules);
        // dd($schedules);

        $returnHTML = view('admin.patient.doctor_schedule')->with('schedules', $schedules)->render();

        $arr = array('msg' => 'Doctor schedule', 'status' => 'success', 'html' => $returnHTML);

        return response()->json($arr);
    }
    public function get_slot($id)
    {
        $slot_details = DB::table('hrms_schedule_slot')
            ->where('schedule_no_fk', $id)
            //->select('product_name','quantity', 'product_price')
            ->get();

        return Template::loadview("admin.patient.doctor_slot", [
            'slot_details' => $slot_details
        ]);
    }


    public function get_doctor_schedule_dates(Request $request)
    {
        $doctor_id = $request->doctor_id;

        $schedules = DB::select("select doctor_person_no_fk,b.serviceunit_no_fk service_unit_id,b.au_entry_hospital_pk_no hospital_id, listagg(to_char(a.schedule_dt, 'DD-MM-YYYY'), ', ') within group (order by a.schedule_dt) schedule_dt, listagg(a.schedule_no_pk,', ') within group (order by a.schedule_no_pk) schedule_no_pk
    		from hrms_schedule a,hrms_personnel b
    		where a.doctor_person_no_fk=b.person_no_pk and doctor_person_no_fk=$doctor_id
    		group by doctor_person_no_fk,b.serviceunit_no_fk,b.au_entry_hospital_pk_no");
        if (!empty($schedules)) {
            $sc_dates = $schedules[0]->schedule_dt;
            $sc_ids = $schedules[0]->schedule_no_pk;
            $service_unit = $schedules[0]->service_unit_id;
            $hospital_id = $schedules[0]->hospital_id;
        } else {
            $sc_dates = $sc_ids = $service_unit = $hospital_id = "";
        }

        $sc_info = array(
            'sc_dates' => $sc_dates,
            'sc_ids' => $sc_ids,
            'service_unit' => $service_unit,
            'hospital_id' => $hospital_id
        );
        return $sc_info;
    }

    public function get_doctor_appointment_info(Request $request)
    {
        //$appointment_dt_like_db =date("Y/m/d",strtotime($request->appointment_dt));
        $appointment_dt = new Carbon($request->appointment_dt);
        $app_date = date("Y-m-d", strtotime($appointment_dt->toDateString()));

        $app_stat = DB::table("doctor_appointment_stat_vw a")
            ->select('a.*', 'b.visit_type_lookup_no_fk', 'b.sales_price', 'b.item_no_fk')
            ->leftJoin("doctor_wise_consult_fee_vw b", "a.person_no_pk", "=", "b.doc_id")
            ->orWhere("b.lookupdata_code", "NEWCONS")
            ->where("a.person_no_pk", $request->doctor_id)
            ->where("a.schedule_dt", $app_date)
            ->first();
        $hospital_code = Session::get('user.ses_hospital_code');

        // dd($app_stat);
        //  $slot_details = DB::table('hrms_schedule_slot_vw')->where('schedule_dt', $appointment_dt_like_db)->get();
        //dd($slot_details);
        $app_stat_info = [];
        if (!empty($app_stat)) {
            $app_stat_info = array(
                'doctor_id' => $app_stat->person_no_pk,
                'specialization' => $app_stat->specialization,
                'hospital_id' => $app_stat->au_entry_hospital_pk_no,
                'service_unit_id' => $app_stat->serviceunit_no_fk,
                'schedule_id' => $app_stat->schedule_no_pk,
                'avg_duration' => $app_stat->avg_duration,
                'avg_load' => $app_stat->avg_load,
                'block_load' => $app_stat->block_load,
                'total_appointment' => $app_stat->total_appointment,
                'total_cancel' => $app_stat->total_cancel,
                'total_billed' => $app_stat->total_billed,
                'total_arrived' => $app_stat->total_arrived,
                'total_confirmed' => $app_stat->total_confirmed,
                'visit_type_lookup_no_fk' => $app_stat->visit_type_lookup_no_fk,
                'sales_price' => $app_stat->sales_price,
                'item_no_fk' => $app_stat->item_no_fk,
                'hospital_code' => $hospital_code

            );
        }
        dd($app_stat, $request->doctor_id, $app_date);
        return $app_stat_info;
    }

    public function get_doctor_patient_appointment_info(Request $request)
    {
        $doctor_click_id = $request->doctor_click_id;
        $patient_id = $request->patient_id;
        
        $admission_info = DB::table('ipd_admission')
                            ->select('DIS_DATE', 'ADMISSION_UID')
                            ->where("patient_no_fk", $patient_id)
                            ->orderBy('DIS_DATE', 'desc')
                            ->take(5)
                            ->get();
        
        $appoint_info = DB::table("patn_appointment_vw")
                            ->select('appoint_date', 'appoint_typename','consultation_days')
                            ->where("doctor_no_fk", $doctor_click_id)
                            ->where("patient_no_pk", $patient_id)
                            ->where("cancel_ind", 0)
                            ->where("consult_ind", 1)
                            ->orderBy("appoint_date", "desc")
                            ->get();
        // Calculate Appointment Type

        // dd($appoint_info);


        //Case 1
        //  $appoint_info = [

        //         ];
        //         /*  Output: New Consultation :: Pass*/


        // //Case 2
        //  $appoint_info = [
        //             (object)['appoint_date' => '2025-08-08 12:00:00','appoint_typename' => 'New Consultation', 'consultation_days' => 1],
        //         ];
        //         /*  Output: Follow up 7 Days :: Pass*/


        //Case 3,4
        //  $appoint_info = [
        //             (object)['appoint_date' => '2025-08-08 12:00:00','appoint_typename' => 'New Consultation','consultation_days' => 1],
        //             (object)['appoint_date' => '2025-08-09 12:00:00','appoint_typename' => 'Followup 7 Days','consultation_days' => 7],
        //         ];
        //         /*  Output: Follow up 14 Days :: Pass*/


        //Case 4
        //  $appoint_info = [
        //             (object)['appoint_date' => '2025-08-08 12:00:00','appoint_typename' => 'New Consultation', 'consultation_days' => 1],
        //             (object)['appoint_date' => '2025-08-09 12:00:00','appoint_typename' => 'Followup 7 Days', 'consultation_days' => 7],
        //             (object)['appoint_date' => '2025-08-10 12:00:00','appoint_typename' => 'Followup 14 Days', 'consultation_days' => 14],
        //         ];
        //         /*  Output: Follow up 14 Days :: Pass*/


        // //Case 5
        //  $appoint_info = [
        //             (object)['appoint_date' => '2025-08-08 12:00:00','appoint_typename' => 'Followup 7 Days', 'consultation_days' => 7],
        //             (object)['appoint_date' => '2025-08-07 12:00:00','appoint_typename' => 'New Consultation', 'consultation_days' => 1],
        //             (object)['appoint_date' => '2025-08-9 12:00:00','appoint_typename' => 'Followup 14 Days', 'consultation_days' => 14],
        //             (object)['appoint_date' => '2025-08-10 12:00:00','appoint_typename' => 'Followup 14 Days', 'consultation_days' => 14],
        //         ];
        //         /*  Output: New Consultation :: Pass*/

        // //Case Extra
        //  $appoint_info = [
        //             (object)['appoint_date' => '2025-08-06 12:00:00','appoint_typename' => 'New Consultation', 'consultation_days' => 1],
        //             (object)['appoint_date' => '2025-08-07 12:00:00','appoint_typename' => 'New Consultation', 'consultation_days' => 1],
        //             (object)['appoint_date' => '2025-08-08 12:00:00','appoint_typename' => 'Followup 7 Days', 'consultation_days' => 7],
        //             (object)['appoint_date' => '2025-08-9 12:00:00','appoint_typename' => 'Followup 14 Days', 'consultation_days' => 14],
        //             (object)['appoint_date' => '2025-08-10 12:00:00','appoint_typename' => 'Followup 14 Days', 'consultation_days' => 14],
        //         ];
        //         /*  Output: New Consultation */


        // // //Case 6
        //  $appoint_info = [
        //             (object)['appoint_date' => '2025-07-08 12:00:00','appoint_typename' => 'New Consultation'],
        //         ];
        // /*  Output: New Consultation  :: Remarks: Pass*/





        $eligible = $collection = collect($appoint_info)
                        ->filter(fn($item) => Carbon::parse($item->appoint_date)
                            ->between(Carbon::today()->subDays(14), Carbon::today()))
                        ->where('consultation_days', '=', 1)
                        ->count();
        

                        
        $appointment_type =  Session::get('user.ses_hospital_code')=="DMHL" ? 1 : '';
   
        if($eligible > 0 && Session::get('user.ses_hospital_code')=="DMHL"){
            
            $collection = collect($appoint_info)
                            ->filter(fn($item) => Carbon::parse($item->appoint_date)
                                ->between(Carbon::today()->subDays(14), Carbon::today()))
                            ->sortBy(fn($item) => Carbon::parse($item->appoint_date)->timestamp)
                            ->values();

            // consultation_days == 1 এর মধ্যে সবচেয়ে নিকটবর্তী তারিখের index
            $startIndex = $collection
                            ->filter(fn($i) => $i->consultation_days == 1)
                            ->sortBy(fn($i) => Carbon::parse($i->appoint_date)->diffInDays(Carbon::today()))
                            ->keys()
                            ->first();

            $new_appoint_info = $collection
                            ->slice($startIndex)
                            ->values()
                            ->toArray();



            

            if(count($new_appoint_info) >= 4 ){
                $appointment_type = 1;
            }else if(count($new_appoint_info) == 1){
                if($new_appoint_info[0]->consultation_days == 1){
                    if($this->dayDiff($new_appoint_info[0]->appoint_date) <= 7){
                        $appointment_type = 7; 
                    }
                    else{
                        $appointment_type = 14;
                    }
                }

            }else if(count($new_appoint_info) == 2 ){
                $appointment_type = 14;
            }else if(count($new_appoint_info) == 3){
                if($new_appoint_info[1]->consultation_days == 14 && $new_appoint_info[2]->consultation_days == 14){
                    $appointment_type = 1; 
                }
                else{
                    $appointment_type = 14;
                }
            }

        }

        // Close Appointment Type

        return response()->json([
            'appointment_info' => $appoint_info,
            'admission_info' => $admission_info,
            'appointment_type' => $appointment_type,
        ]);
    }

    public function dayDiff($date)
    {
       return  Carbon::parse($date)->diffInDays(Carbon::now());
    }

    public function get_doctor_slot(Request $request)
    {
        // dd( date('h:i:s'));
        $slot_details = [];
        $appointment_dt_like_db = date("Y/m/d", strtotime($request->appointment_dt));
        $slot_details = DB::table('hrms_schedule_slot')
            ->where('doctor_person_no_fk', $request->doctor_id)
            ->where('schedule_dt', $appointment_dt_like_db)
            ->where('start_time', '>=', date('Y-m-d h:i:s'))
            //->where('total_slot', '>', 0)
            ->get();
        //   dd( $slot_details);
        if ($slot_details->count() > 0) {
            //dd($slot_details);
            return view('admin.patient.appointment_slot', [
                'slot_details' => $slot_details,
                'slot_ind' => 1
            ]);
        }
        $slot_details = DB::table('patn_appointment')
            ->where('doctor_no_fk', $request->doctor_id)
            ->where('appoint_date', $appointment_dt_like_db)
            //->where('start_time' ,'>=',  date('Y-m-d h:i:s'))
            //->where('total_slot', '>', 0)
            ->get();
        //   dd( $slot_details);
        return view(
            'admin.patient.appointment_slot',
            [
                'slot_details' => $slot_details,
                'slot_ind' => 0
            ]
        );
    }

    public function appointment_list_pdf(request $request)
    {
        // dd($request->all());

        $appointment_date = date('Y-m-d', strtotime($request->search_date_from));
        $from_date = $request->search_date_from != "" ? date("Y-m-d", strtotime($request->search_date_from)) : '';
        $to_date = $request->search_date_to != "" ? date("Y-m-d", strtotime($request->search_date_to)) : '';
        // dd($from_date,$to_date);
        $chiefcom = $this->getLookupListByCode("CHIEFCOM");
        $priority = $this->getLookupListByCode("PRIORITY");
        if (Session::get('user.ses_hospital_code') != 'IMPALA') {
            $appointment_qeury = DB::table("PATN_APPOINTMENT_VW a")
                ->select('a.appoint_code', 'a.cancel_reason', 'a.appoint_date', 'a.start_time', 'a.end_time', 'a.au_entry_at', 'a.doctor_no_fk', 'a.doctor_photo', 'a.doc_gender_txt', 'a.person_code', 'a.full_name', 'a.degree1', 'a.degree2', 'a.degree3', 'a.degree4', 'a.specialization', 'a.phone_mobile', 'a.patient_photo', 'a.patient_code', 'a.patient_name', 'a.mobile1', 'a.chif_complain', 'a.priority', 'a.patient_type_code', 'a.first_ref_name', 'a.second_ref_name', 'a.appoint_no_pk', 'a.cancel_ind','a.invdtl_cancel_ind', 'a.consult_ind', 'a.physio_ind', 'a.patient_no_pk', 'a.gender_txt', 'a.age', 'a.blank_pres_print_ind', 'a.su_name', 'a.first_ref_code', 'a.slot_sl', 'b.prescription_no_pk', 'c.appoint_service_no_fk', 'c.invoice_no_pk', 'c.invoice_trn_list', 'u.user_fullname')
                ->leftJoin("wsec_user u", "u.user_no_pk", "=", "A.au_entry_by")
                ->leftJoin("psn_t_prescription b", "a.appoint_no_pk", "=", "b.appoint_no_fk")
                ->leftJoin("FINC_INVOICEMST_SUM_VW c", "c.appoint_service_no_fk", "=", "a.appoint_no_pk")
                ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));
            // ->where('c.MODULE_CODE', 'OPDC');

            // if ($request->app_date != "") {
            //     $appointment_qeury->when($appointment_date, function ($query, $appointment_date) {
            //         return $query->where('a.appoint_date', $appointment_date);
            //     });
            // }
            if ($from_date != "" && $to_date != "") {
                $appointment_qeury->where(DB::raw("trunc(a.appoint_date)"), '>=', $from_date);
                $appointment_qeury->where(DB::raw("trunc(a.appoint_date)"), '<=', $to_date);
            }

            if ($request->hdn_patient_id != "") {
                $appointment_qeury->when($request->hdn_patient_id, function ($query, $patient_id) {
                    return $query->where('a.patient_no_pk', $patient_id);
                });
            }
            $user_id = [];
            if ($request->hdn_app_user != "") {

                $user_id = DB::table('wsec_user')->select('user_no_pk', 'user_fullname')->where('person_no_fk', $request->hdn_app_user)->first();

                $appointment_qeury->when($user_id->user_no_pk, function ($query, $emp_id) {
                    return $query->where('a.au_entry_by', $emp_id);
                });
            }
            if ($request->hdn_doctor_id != "") {
                $appointment_qeury->when($request->hdn_doctor_id, function ($query, $doctor_code) {
                    return $query->where('a.doctor_no_fk', $doctor_code);
                });
            }

            if ($request->cheif_compl != "") {
                $appointment_qeury->when($request->cheif_compl, function ($query, $cheif_compl) {
                    return $query->where('a.chif_complain', $cheif_compl);
                });
            }


            if ($request->patient_type != "") {
                $appointment_qeury->when($request->patient_type, function ($query, $patient_type) {
                    return $query->where('a.patient_type', $patient_type);
                });
            }

            /**
             * Status
             */
            // Pending
            $appointment_qeury->when($request->status == "pending", function ($query) {
                return $query->where('a.cancel_ind', 0)->where('a.consult_ind', 0);
            });

            // Payment
            $appointment_qeury->when($request->status == "payment", function ($query) {
                return $query->where('a.consult_ind', 1);
            });

            // Canceled
            $appointment_qeury->when($request->status == "canceled", function ($query) {
                return $query->where('a.cancel_ind', 1);
            });
        } else {
            $user_id = [];
            // dd($request->all());
            $toDate = date('Y/m/d');
            $appointment_date = date('Y-m-d', strtotime($request->search_date_from));
            $from_date = $request->search_date_from != "" ? date("Y-m-d", strtotime($request->search_date_from)) : '';
            $to_date = $request->search_date_to != "" ? date("Y-m-d", strtotime($request->search_date_to)) : '';
            $chiefcom = $this->getLookupListByCode("CHIEFCOM");
            $priority = $this->getLookupListByCode("PRIORITY");

            $appointment_qeury = DB::table("PATN_APPOINTMENT_VW a")
                ->select('a.appoint_code', 'a.cancel_reason', 'a.appoint_date', 'a.start_time', 'a.end_time', 'a.au_entry_at', 'a.doctor_no_fk', 'a.doctor_photo', 'a.doc_gender_txt', 'a.person_code', 'a.full_name', 'a.degree1', 'a.degree2', 'a.degree3', 'a.degree4', 'a.specialization', 'a.phone_mobile', 'a.patient_photo', 'a.patient_code', 'a.patient_name', 'a.mobile1', 'a.chif_complain', 'a.priority', 'a.patient_type_code', 'a.first_ref_name', 'a.second_ref_name', 'a.appoint_no_pk', 'a.cancel_ind', 'a.consult_ind', 'a.physio_ind', 'a.patient_no_pk', 'a.gender_txt', 'a.age', 'a.blank_pres_print_ind', 'a.su_name', 'a.first_ref_code', 'a.slot_sl', 'b.prescription_no_pk', 'c.appoint_service_no_fk', 'c.invoice_trn_list', 'u.user_fullname')
                ->leftJoin("psn_t_prescription b", "a.appoint_no_pk", "=", "b.appoint_no_fk")->leftJoin("FINC_INVOICEMST_SUM_VW c", "c.appoint_service_no_fk", "=", "a.appoint_no_pk")->leftJoin("wsec_user u", "u.user_no_pk", "=", "A.au_entry_by")->orderBy('appoint_code', 'asc')->orderBy('slot_sl', 'ASC');

            if ($from_date != "" || $request->patient_id != "" || $request->hdn_doctor_id != "" || $request->cheif_compl != "" || $request->app_priority != 0 || $request->status != "") {

                // if ($request->app_date != "") {
                //     $appointment_qeury->when($appointment_date, function ($query, $appointment_date) {
                //         return $query->where('a.appoint_date', $appointment_date);
                //     });
                // }
                if ($from_date != "" && $to_date != "") {
                    $appointment_qeury->where(DB::raw("trunc(a.appoint_date)"), '>=', $from_date);
                    $appointment_qeury->where(DB::raw("trunc(a.appoint_date)"), '<=', $to_date);
                }

                if ($request->hdn_patient_id != "") {
                    $appointment_qeury->when($request->hdn_patient_id, function ($query, $patient_id) {
                        return $query->where('a.patient_no_pk', $patient_id);
                    });
                }

                if ($request->hdn_doctor_id != "") {
                    $appointment_qeury->when($request->hdn_doctor_id, function ($query, $doctor_code) {
                        return $query->where('a.doctor_no_fk', $doctor_code);
                    });
                }

                if ($request->cheif_compl != "") {
                    $appointment_qeury->when($request->cheif_compl, function ($query, $cheif_compl) {
                        return $query->where('a.chif_complain', $cheif_compl);
                    });
                }


                if ($request->patient_type != "") {
                    $appointment_qeury->when($request->patient_type, function ($query, $patient_type) {
                        return $query->where('a.patient_type', $patient_type);
                    });
                }

                /**
                 * Status
                 */
                // Pending
                $appointment_qeury->when($request->status == "pending", function ($query) {
                    return $query->where('a.cancel_ind', 0)->where('a.consult_ind', 0);
                });

                // Payment
                $appointment_qeury->when($request->status == "payment", function ($query) {
                    return $query->where('a.consult_ind', 1);
                });

                // Canceled
                $appointment_qeury->when($request->status == "canceled", function ($query) {
                    return $query->where('a.cancel_ind', 1);
                });
            } else {

                $appointment_qeury->when($toDate, function ($query, $toDate) {
                    return $query->where('a.appoint_date', $toDate);
                });
            }
        }
        $appointment_rs = $appointment_qeury->get();

        $app_arr = [];
        $pending_ind = $payment_ind = $cancel_ind = $prescription_ind = $invdtl_cancel_ind = 0;
         if (!empty($appointment_rs)) {
            foreach ($appointment_rs as $app_data) {

                // if ($app_data->consult_ind == 1) {
                //     $payment_ind++;
                // } else {
                //     $pending_ind++;
                // }

                // if ($app_data->cancel_ind == 1) {
                //     $cancel_ind++;
                // }

                // if ($app_data->blank_pres_print_ind == 1) {
                //     $prescription_ind++;
                // }
                if ($app_data->consult_ind == 1 && $app_data->cancel_ind == 0 && $app_data->invdtl_cancel_ind == 0) {
                    $payment_ind++;
                }

                if ($app_data->cancel_ind == 0 && $app_data->consult_ind == 0) {
                    $pending_ind++;
                }

                if ($app_data->cancel_ind == 1 ) {
                    $cancel_ind++;
                }
                if ($app_data->invdtl_cancel_ind == 1 && $app_data->cancel_ind == 0) {
                    $invdtl_cancel_ind++;
                }

                // if ($app_data->prescription_no_pk != "") {
                //     $prescription_ind++;
                // }

                if ($app_data->blank_pres_print_ind == 1) {
                    $prescription_ind++;
                }
            }
        }
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $appointments_date = $request->app_date != "" ? $request->app_date : '';
        // $to_date = '';
        $barcode = new BarcodeGenerator();
        $barcode->setText("appointment list");
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        if (Session::get('user.ses_hospital_code') != 'IMPALA') {
            $page_name = ($request->page_view_type == "list") ? "admin.appointment.appointment_list_print" : "admin.physiotherapy.prescription.ptherapy_appointment_list_card";
        } else {
            $page_name = ($request->page_view_type == "list") ? "admin.appointment.appointment_list_print_impala" : "admin.physiotherapy.prescription.ptherapy_appointment_list_card";
        }
        $print_type = $request->print_type;
        if ($request->print_type == "PDF") {
            $pdf = PDF::loadView($page_name, ['chiefcom' => $chiefcom, 'priority' => $priority, 'appointment_rs' => $appointment_rs, 'appointment_date' => $appointment_date, "pending_ind" => $pending_ind, "payment_ind" => $payment_ind, "cancel_ind" => $cancel_ind,"invdtl_cancel_ind" => $invdtl_cancel_ind,  "prescription_ind" => $prescription_ind, 'print_type' => $print_type, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'to_date' => $to_date, 'appointments_date' => $appointments_date, 'to_date' => $to_date, 'from_date' => $from_date, 'user_id' => $user_id])->setPaper('a4', 'landscape');
            return $pdf->stream('Appointment-List.pdf');
        }
        if ($request->print_type == "EXCEL") {
            $pdf = ['chiefcom' => $chiefcom, 'priority' => $priority, 'appointment_rs' => $appointment_rs, 'appointment_date' => $appointment_date, "pending_ind" => $pending_ind, "payment_ind" => $payment_ind, "cancel_ind" => $cancel_ind, "prescription_ind" => $prescription_ind,"invdtl_cancel_ind" => $invdtl_cancel_ind,  'print_type' => $print_type, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'to_date' => $to_date, 'from_date' => $from_date, 'appointments_date' => $appointments_date, 'user_id' => $user_id];
            $fileToExport = "appointment-list";
            $html = View($page_name)->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }



        // return $pdf->stream('Appointment-List.pdf');


        // $report_data = DB::table("patn_appointment_vw")
        // ->select('appoint_code','slot_sl','full_name','patient_name','chif_complain','priority')->where("appoint_date", date("Y-m-d"))->get();

        // ;
        // $pdf = PDF::loadView("admin.appointment.appointment_list_print", ['report_data' => $report_data]);


    }


    public function viewDoctorSchedule(Request $request, $id)
    {
        $data = DB::table('hrms_personnel AS d')
            ->select('d.person_no_pk', 'd.salutation', 'd.full_name', 'd.father_name', 'd.mother_name', 'd.spouse_name', 'gen.lookupdata_name AS gender', 'mar.lookupdata_name AS marital', 'd.dob', 'ser.serviceunit_name AS service_unit', 'd.join_date', 'jti.lookupdata_name AS job_title', 'jty.lookupdata_name AS job_type', 'hrt.lookupdata_name AS hr_type', 'empt.lookupdata_name AS emp_type', 'blo.lookupdata_name AS blood_group', 'rel.lookupdata_name AS religion', 'spe.lookupdata_name AS specialization', 'd.phone_home', 'd.phone_mobile', 'd.phone_office', 'd.nationality', 'd.pe_addr1', 'd.pe_addr_dist', 'd.pe_addr_country', 'd.pr_addr1', 'd.pr_addr_dist', 'd.pr_addr_country', 'd.emergency_contact_name', 'd.emergency_contact_addr', 'd.emergency_contact_relation', 'd.emergency_contact_contact', 'd.email_personal', 'd.passport_no', 'd.place_of_birth', 'd.card_no', 'she.schedule_dt')
            ->leftJoin('sysc_lookupdata AS gen', 'gen.lookupdata_no_pk', '=', 'd.gender_lookup_no_fk')
            ->leftJoin('sysc_lookupdata AS mar', 'mar.lookupdata_no_pk', '=', 'd.marital_lookup_no_fk')
            ->leftJoin('sysc_serviceunit AS ser', 'ser.serviceunit_no_pk', '=', 'd.serviceunit_no_fk')
            ->leftJoin('sysc_lookupdata AS jti', 'jti.lookupdata_no_pk', '=', 'd.jobtitle_lookup_no_fk')
            ->leftJoin('sysc_lookupdata AS jty', 'jty.lookupdata_no_pk', '=', 'd.job_type_lookup_no_fk')
            ->leftJoin('sysc_lookupdata AS hrt', 'hrt.lookupdata_no_pk', '=', 'd.hr_type_lookup_no_fk')
            ->leftJoin('sysc_lookupdata AS empt', 'empt.lookupdata_no_pk', '=', 'd.emp_type_lookup_no_fk')
            ->leftJoin('sysc_lookupdata AS blo', 'blo.lookupdata_no_pk', '=', 'd.blood_group_lookup_no_fk')
            ->leftJoin('sysc_lookupdata AS rel', 'rel.lookupdata_no_pk', '=', 'd.religion_lookup_no_fk')
            ->leftJoin('sysc_lookupdata AS spe', 'spe.lookupdata_no_pk', '=', 'd.specialization_lookup_no_fk')
            ->leftJoin('hrms_schedule as she', 'she.doctor_person_no_fk', 'd.person_no_pk')
            ->where('d.person_no_pk', '=', $id)
            ->first();

        $schedule_data = DB::select("select * from DASH_DOCTOR_SCHDULE_VW
where SCHEDULE_DT between trunc(sysdate) and trunc(sysdate+7) and person_no_pk= '$id' order By schedule_dt desc");
        return Template::loadview("admin.appointment.schedule_information", [
            'data' => $data,
            'schedule_data' => $schedule_data
        ]);
    }

    public function schedule_search_data(Request $request)
    {
        $query = DB::table('patn_appointment_vw pat')
            ->leftJoin('hrms_schedule she', 'she.schedule_no_pk', 'pat.schedule_no_fk');
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $query->where(DB::raw("trunc(schedule_dt)"), '>=', date('Y-m-d', strtotime($request->search_date_from)));
            $query->where(DB::raw("trunc(schedule_dt)"), '<=', date('Y-m-d', strtotime($request->search_date_to)));
        } elseif (!empty($request->search_date_from)) {
            $query->where(DB::raw("trunc(schedule_dt)"), '=', date('Y-m-d', strtotime($request->search_date_from)));
        } elseif (!empty($request->search_date_to)) {
            $query->where(DB::raw("trunc(schedule_dt)"), '=', date('Y-m-d', strtotime($request->search_date_to)));
        }
        return Template::loadview("admin.appointment.schedule_all_data", [
            'schedule_data' => $query
                ->where('pat.doctor_no_fk', $request->person_data)
                ->orderBy('schedule_dt', 'DESC')
                ->get()
                ->toArray(),
        ]);
    }
    public function printPatientAppointment($appointment_no_pk)
    {

        $data = DB::table('PATN_APPOINTMENT_VW')->where('appoint_no_pk', '=', $appointment_no_pk)->first();
        // dd($data);
        $title = $data->appoint_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        if ($po_hospital_details->hospital_code == 'DIGILAB') {
            return view("admin.appointment.appointment_card_pdf_digilab", ['data' => $data, 'barcode_no' => $barcode_no]);
        } else {
            $pdf = PDF::loadView("admin.appointment.appointment_card_pdf", ['data' => $data, 'barcode_no' => $barcode_no]);
            return $pdf->stream('Patient_Appointment_card.pdf');
        }
    }


    public function slotData($doctorid)
    {
        // Fetch doctor's primary key
        $doctor_pk = DB::table('hrms_personnel')
            ->where('person_code', $doctorid)
            ->value('person_no_pk');

        // Retrieve schedule slots
        $schedules = DB::table('hrms_schedule_slot_vw')
        ->leftJoin('HRMS_SCHEDULE_SLOT', 'hrms_schedule_slot_vw.schedule_no_pk', '=', 'HRMS_SCHEDULE_SLOT.schedule_no_fk')
        ->leftJoin('hrms_schedule_dayoff', 'hrms_schedule_dayoff.schedule_no_fk', '=', 'hrms_schedule_slot_vw.schedule_no_pk')
        ->leftJoin('DOCTOR_INFO_VW', 'hrms_schedule_slot_vw.doctor_person_no_fk', '=', 'DOCTOR_INFO_VW.person_no_pk')
        ->where('hrms_schedule_slot_vw.doctor_person_no_fk', '=', $doctor_pk)
        ->where('HRMS_SCHEDULE_SLOT.AVAILABLE_IND', '=', 1)
        ->where('hrms_schedule_slot_vw.schedule_dt', '>=', now()->toDateString())
        ->select(
            'hrms_schedule_slot_vw.schedule_dt',
            'hrms_schedule_slot_vw.schedule_no_pk',
            'HRMS_SCHEDULE_SLOT.start_time',
            'DOCTOR_INFO_VW.specialization',
            'HRMS_SCHEDULE_SLOT.SLOT_NO_PK'
        )
        ->orderBy('HRMS_SCHEDULE_SLOT.start_time', 'asc')
        ->get();
        // ->simplePaginate(10);


        // Structure the schedule data
        $structuredSchedules = [];
        foreach ($schedules as $schedule) {
            $formattedDate = Carbon::parse($schedule->schedule_dt)->format('Y-m-d');
            $slotTime = Carbon::parse($schedule->start_time)->format('g:i A');

            // Initialize doctor entry if not exists
            if (!isset($structuredSchedules[$doctor_pk])) {
                $structuredSchedules[$doctor_pk] = [
                    '_id' => $doctor_pk,
                    'DUID' => $doctorid,
                    'doctorName' => 'Dr. ' . $doctor_pk,
                    'specialization' => $schedule->specialization,
                    'slots' => []
                ];
            }

            // Add slot to the doctor's schedule
            $structuredSchedules[$doctor_pk]['slots'][] = [
                'date' => $formattedDate,
                'id' => $schedule->slot_no_pk,
                'slot_time' => $slotTime,
            ];
        }

        // Prepare final result
        $result = array_values($structuredSchedules);

        return response()->json($result);
    }
    // public function saveApiApointment(Request $request)
    // {
    //     return response()->json($request->all());
    // }

    public function saveApiApointment(Request $request)
    {

        try {

            DB::beginTransaction();

            // try {
            // $appointment_dt = date("Y-m-d", strtotime($appointment_dt->toDateString()));
            // $app_date = date("Y-m-d", strtotime($request->app_date));

            //  $patient_dob = date("Y-m-d", strtotime($request->app_date));
            $pat_dob = date("Y-m-d", strtotime($request->pat_dob));

            $marital_status_arr = $this->getLookupListByCode("MARSTS");
            $gender_arr = $this->getLookupListByCode("GENDER");

            $pdo = DB::getPdo();
            $doctor_id = $request->hdn_doctor_id;
            $slot_id = $request->hdn_schedule_id;
            $slot_no_pk = $request->slot_no_pk;

            $patient_id = $request->hdn_patient_id;

            if($patient_id != null){
                $patient_id = DB::table('patn_registration')
                ->where('patient_code', $patient_id)
                ->value('patient_no_pk');
            }
            $full_name = $request->full_name;
            $phone_no = $request->phone_no;
            $patient_gender = $request->patient_gender;
            $gender_txt = isset($gender_arr[$request->patient_gender]) ? $gender_arr[$request->patient_gender] : '';
            $marital_status = isset($request->patient_marital_status) ?  $request->patient_marital_status : 0;
            $marital_status_txt = isset($marital_status[$request->patient_marital_status]) ? $marital_status[$request->patient_marital_status] : '';

            $blood_group = $request->patient_blood_group;
            $patient_email = $request->patient_email;
            $patient_age_dd = $request->patient_age_dd ? sprintf("%02d", $request->patient_age_dd) : "";
            $patient_age_mm = $request->patient_age_mm ? sprintf("%02d", $request->patient_age_mm) : "";
            $patient_age_yy = $request->patient_age_yy ? sprintf("%02d", $request->patient_age_yy) : "";
            $y = $patient_age_yy ? $patient_age_yy . " " . "Y " : "";
            $m = $patient_age_mm ? "," . $patient_age_mm . " " . "M " : "";
            $d = $patient_age_dd ? "," . $patient_age_dd . " " . "D" : "";
            $age = $y . " " . $m . " " . $d;
            // dd($y,
            // $m,
            // $d,
            // $age);
            // $patient_type = $request->patient_type;
            $patient_type = $request->patienttype;
            $priority = $request->appointment_priority;
            $hdn_first_refer = isset($request->hdn_first_refer) ? $request->hdn_first_refer : "";
            $hdn_second_refer = isset($request->hdn_second_refer) ? $request->hdn_second_refer : "";
            $priority = $request->appointment_priority;
            $address = $request->address;
            $item_name = $request->item_name;
            $in_chief_comp_name = "";
            $service_unit = $request->hdn_service_unit;

            
            $schedule = db::table('hrms_schedule_slot')
                ->where('slot_no_pk', $slot_id)
                ->select('schedule_dt', 'start_time', 'end_time','schedule_no_fk')
                ->first();
            $app_date = date("Y-m-d", strtotime($schedule->schedule_dt));
            $schedule_no_fk = $schedule->schedule_no_fk;
            $in_start_time = isset($schedule->start_time) ? date("Y-m-d h:i:s", strtotime($schedule->start_time)) : null;
            $in_end_time = isset($schedule->end_time) ? date("Y-m-d h:i:s", strtotime($schedule->end_time)) : null;
            


            $appoint_source = 'WEB';
            $entry_session = 'UHL APP';
            $hospital_id = 141; //$request->hdn_hospital_id;
            $is_pay_consultation = $request->is_pay_consultation;
            $is_manual_sl = isset($request->patient_manual_sl_checkbox) ? 1 : 0;
            $patient_note = $request->appoint_note;
            $app_start_time = $request->start_time;
            $app_end_time = $request->end_time;

            // $in_start_time = isset($app_start_time) ? date("Y-m-d h:i:s", strtotime($app_date . " " . $app_start_time)) : null;
            // $in_end_time = isset($app_end_time) ? date("Y-m-d h:i:s", strtotime($app_date . " " . $app_end_time)) : null;
            
            $in_manual_time_ind = (isset($in_start_time) || isset($in_end_time)) ? 1 : 0;
            $in_provider_person_no_fk = $request->in_provider_person_no_fk;
            $in_facility_no_fk = $request->in_facility_no_fk;
            $in_visit_type = 1;
            // $in_visit_type = $request->in_visit_type;
            $in_case_type = $request->in_case_type;
            $in_free_visit_ind = $request->in_free_visit_ind;
            $in_recurrence_ind = $request->in_recurrence_ind;
            // $auth_id = Auth::user()->user_no_pk;
            $auth_id = 1;
            $temp  = isset($request->appt_status) ? explode('_', $request->appt_status) : '';
            $in_appoint_status = isset($temp[0]) ? $temp[0] : '';
            $in_appoint_status_txt = isset($temp[1]) ? $temp[1] : '';
            $null = '';
            $appointment_type = 161;
            $in_reason_for_visit =  $request->reason_visit;
            if (isset($patient_id)) {
                $check_appointment = DB::table('patn_v1_appointment_vw')
                    ->where('patient_no_pk', $patient_id)
                    ->where('doctor_no_fk', $in_provider_person_no_fk)
                    ->where(DB::raw('trunc(appoint_date)'), $app_date)
                    ->get();

                if (count($check_appointment) > 0) {
                    return response()->json([
                        'responseText' => "This Patient is already booked a slot of this doctor "
                    ], 406);
                }
            }
            // $start_time = $request->start_time;
            //$end_time = $request->end_time;
            // OUT PAREMETER INITIALIZE
            $in_religion =  isset($request->patient_religion) ? $request->patient_religion : '';
            $corporate_id  = isset($request->corporate_name) ? $request->corporate_name : '';
            $corporate_name = '';
            if ($corporate_id != "") {
                $corporate_name = DB::table('ccm_corporateclient_vw')->select('ccm_client_name')->where('ccm_client_no_pk', $corporate_id)->first()->ccm_client_name;
            }

            $out_sl_no = $out_appoint_no = $out_appoint_id = $out_start_time = $out_end_time = $out_patient_no_pk  = $out_error = "";

            $stmt = $pdo->prepare("begin pkg_v1_patmanagement.prc_appointment(
                :in_appoint_date,
                :in_doctor_no_fk,
                :in_provider_person_no_fk,
                :in_schedule_no_fk,
                :in_slot_no_pk,
                :in_manual_time_ind,
                :in_start_time,
                :in_end_time,
                :in_appoint_type,
                :in_patient_no_fk,
                :in_salutation,
                :in_patient_name,
                :in_first_name,
                :in_last_name,
                :in_phone_mobile,
                :in_email,
                :in_dob,
                :in_age_dd,
                :in_age_mm,
                :in_age_yy,
                :in_age,
                :in_gender,
                :in_gender_txt,
                :in_marital_status,
                :in_marital_status_txt,
                :in_address,
                :in_address1,
                :in_address2,
                :in_blood_group,
                :in_religion,
                :in_chif_complain,
                :in_patient_type_no_fk,
                :in_su_no_fk,
                :in_priority_no_fk,
                :in_appoint_source,
                :in_first_referral,
                :in_second_referral,
                :in_is_manual_sl,
                :in_appoint_note,
                :in_ccm_client_no_fk,
                :in_ccm_client_name,
                :in_facility_no_fk,
                :in_visit_type,
                :in_reason_for_visit,
                :in_appoint_status,
                :in_appoint_status_txt,
                :in_case_type,
                :in_free_visit_ind,
                :in_recurrence_ind,
                :in_au_entry_by,
                :in_au_entry_session,
                :in_au_entry_hospital_pk_no,
                :in_reffer_type,
                :out_sl_no,
                :out_appoint_no,
                :out_appoint_id,
                :out_patient_no_pk,
                :out_start_time,
                :out_end_time,
                :out_error);
                end;"); //,:in_is_manual_sl

            $in_reffer_type = $request->referred_type;
            $stmt->bindParam(':in_appoint_date', $app_date);
            $stmt->bindParam(':in_doctor_no_fk', $doctor_id);
            $stmt->bindParam(':in_provider_person_no_fk', $in_provider_person_no_fk);
            $stmt->bindParam(':in_schedule_no_fk', $schedule_no_fk);
            $stmt->bindParam(':in_slot_no_pk', $slot_id);
            //
            $stmt->bindParam(':in_manual_time_ind', $in_manual_time_ind);
            $stmt->bindParam(':in_start_time', $in_start_time);
            $stmt->bindParam(':in_end_time', $in_end_time);
            $stmt->bindParam(':in_appoint_type', $appointment_type);
            $stmt->bindParam(':in_patient_no_fk', $patient_id);
            $stmt->bindParam(':in_salutation', $null);
            $stmt->bindParam(':in_patient_name', $full_name);
            $stmt->bindParam(':in_first_name', $null);
            $stmt->bindParam(':in_last_name', $null);
            $stmt->bindParam(':in_phone_mobile', $phone_no);
            $stmt->bindParam(':in_email', $patient_email);
            $stmt->bindParam(':in_dob', $pat_dob);
            $stmt->bindParam(':in_age_dd', $patient_age_dd);
            $stmt->bindParam(':in_age_mm', $patient_age_mm);
            $stmt->bindParam(':in_age_yy', $patient_age_yy);
            $stmt->bindParam(':in_age', $age);
            $stmt->bindParam(':in_gender', $patient_gender);
            $stmt->bindParam(':in_gender_txt', $gender_txt);
            $stmt->bindParam(':in_marital_status', $marital_status);
            $stmt->bindParam(':in_marital_status_txt', $marital_status_txt);
            $stmt->bindParam(':in_address', $address);
            $stmt->bindParam(':in_address1', $null);
            $stmt->bindParam(':in_address2', $null);
            $stmt->bindParam(':in_blood_group', $blood_group);
            $stmt->bindParam(':in_religion', $in_religion);
            $stmt->bindParam(':in_chif_complain', $null);
            $stmt->bindParam(':in_patient_type_no_fk', $patient_type);
            $stmt->bindParam(':in_su_no_fk', $service_unit);
            $stmt->bindParam(':in_priority_no_fk', $priority);
            $stmt->bindParam(':in_appoint_source', $appoint_source);
            $stmt->bindParam(':in_first_referral', $hdn_first_refer);
            $stmt->bindParam(':in_second_referral', $hdn_second_refer);
            $stmt->bindParam(':in_is_manual_sl', $is_manual_sl);
            $stmt->bindParam(':in_appoint_note', $patient_note);
            $stmt->bindParam(':in_ccm_client_no_fk', $corporate_id);
            $stmt->bindParam(':in_ccm_client_name', $corporate_name);
            $stmt->bindParam(':in_ccm_client_name', $corporate_name);
            $stmt->bindParam(':in_facility_no_fk', $in_facility_no_fk);

            $stmt->bindParam(':in_visit_type', $in_visit_type);
            $stmt->bindParam(':in_reason_for_visit', $in_reason_for_visit);

            $stmt->bindParam(':in_appoint_status', $in_appoint_status);
            $stmt->bindParam(':in_appoint_status_txt', $in_appoint_status_txt);
            $stmt->bindParam(':in_case_type', $in_case_type);
            $stmt->bindParam(':in_free_visit_ind', $in_free_visit_ind);
            $stmt->bindParam(':in_recurrence_ind', $in_recurrence_ind);
            $stmt->bindParam(':in_au_entry_by', $auth_id);
            $stmt->bindParam(':in_au_entry_session', $entry_session);
            $stmt->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
            $stmt->bindParam(':in_reffer_type', $in_reffer_type);
            $stmt->bindParam(':out_sl_no', $out_sl_no, PDO::PARAM_INT);
            $stmt->bindParam(':out_appoint_no', $out_appoint_no, PDO::PARAM_INT);
            $stmt->bindParam(':out_appoint_id', $out_appoint_id, PDO::PARAM_STR, 200);
            $stmt->bindParam(':out_patient_no_pk', $out_patient_no_pk, PDO::PARAM_INT);
            $stmt->bindParam(':out_start_time', $out_start_time, PDO::PARAM_STR, 200);
            $stmt->bindParam(':out_end_time', $out_end_time, PDO::PARAM_STR, 200);
            $stmt->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            // dd($stmt);
            $stmt->execute();
            // End
            $app_info = DB::table("patn_appointment_vw")
            ->where("appoint_no_pk", $out_appoint_no)
            ->first();
            $doctor_name = ($app_info->full_name == "") ? $app_info->full_name :   '';
            $doctor_name_english = $app_info->full_name;
           $update_ind = 0;
            if (Session::get('user.sms_send_ind')==1) {
                $sms = $this->sendSms($app_info->appoint_date,$app_info->start_time,$app_info->end_time, $app_info->mobile1, $doctor_name,$doctor_name_english, $app_info->slot_sl, $app_info->specialization_bangla, $app_info->phone_mobile, $app_info->au_entry_at,$update_ind);
               }
            if ($is_pay_consultation == 1) {
                    $app_info = DB::table("patn_appointment_vw")
                    ->where("appoint_no_pk", $out_appoint_no)
                    ->first();
                    $patient_code = $app_info->patient_code;
                    $app_code = $app_info->appoint_code;
                    $module_info = DB::table("sysc_module")->where("module_code", "OPDC")->select("module_no_pk")->first();
                    $in_module = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                    $counter_su_no = 0;
                    $second_ref_doc = 0;
                    $appointment_id = $request->visit_type;
                    $appointment_id = $request->reffered_by;
                    $item_id = $request->hdn_item_id;
                    // $patient_note
                    $out_invoice_no = $out_invoice_id = $out_error_bill = "";
                    $in_ledgertrn_no = $out_ledgertrn_no =  "";
                    $consultation = $pdo->prepare("begin pkg_billing_v0.prc_billinvoice_consult(:in_module_no_fk, :in_counter_su_no_fk, :in_patient_no_fk, :in_patient_code, :in_appoint_no_pk,  :in_appoint_code, :in_first_ref_doc_person_no_fk, :in_second_ref_doc_person_no_fk, :in_pat_type_lookup_no_fk, :in_au_entry_by, :in_au_entry_session, :in_au_entry_hospital_pk_no,:in_item_no_fk, :in_ledgertrn_no,:out_invoice_no, :out_invoice_id,:out_ledgertrn_no,:out_error); end;");

                    $consultation->bindParam(':in_module_no_fk', $in_module);
                    $consultation->bindParam(':in_counter_su_no_fk', $counter_su_no);
                    $consultation->bindParam(':in_patient_no_fk', $patient_id);
                    $consultation->bindParam(':in_patient_code', $patient_code);
                    $consultation->bindParam(':in_appoint_no_pk', $out_appoint_no);
                    $consultation->bindParam(':in_appoint_code', $app_code);
                    $consultation->bindParam(':in_first_ref_doc_person_no_fk', $hdn_first_refer);
                    $consultation->bindParam(':in_second_ref_doc_person_no_fk', $hdn_second_refer);
                    $consultation->bindParam(':in_pat_type_lookup_no_fk', $patient_type);
                    $consultation->bindParam(':in_au_entry_by', $auth_id);
                    $consultation->bindParam(':in_au_entry_session', $entry_session);
                    $consultation->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
                    $consultation->bindParam(':in_item_no_fk', $item_id);
                    $consultation->bindParam(':in_ledgertrn_no', $in_ledgertrn_no);

                    $consultation->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
                    $consultation->bindParam(':out_invoice_id', $out_invoice_id, PDO::PARAM_STR, 500);
                    $consultation->bindParam(':out_ledgertrn_no', $out_ledgertrn_no, PDO::PARAM_INT);
                    $consultation->bindParam(':out_error', $out_error_bill, PDO::PARAM_STR, 500);

                    $consultation->execute();
                    if ($out_error_bill == "000") {
                        DB::commit();
                        //if($patient_email !=""){
                        // $appointment_datetime = date("d-m-Y", strtotime($app_info->appoint_date));
                        //$this->appointmentMail($patient_email, $app_info->patient_name, $app_info->full_name, $appointment_datetime);
                        //}
                        $message = 'Data Saved Successfully';
                        //return response()->json($message);
                    } else {
                        DB::rollback();
                        $message =$out_error_bill;
                        //return response()->json($message);
                    }
               
            } else {
                DB::commit();
                $message = 'Data Saved Successfully';
            }

            return [
                'msg' => $message ,
                'insert_id' => $out_appoint_no,
            ];

            
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()], 406);
        }
    }
}
