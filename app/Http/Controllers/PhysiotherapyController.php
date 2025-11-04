<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Library\Template;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\PhysiotherapySchedule;
use App\Models\Doctor;
use App\Models\Item;
use App\Repositories\BaseRepository as Repo;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use PDO;
use App\Traits\LookupData;
use App\Traits\DoctorData;
use App\Traits\MailEngine;
use Session;

class PhysiotherapyController extends Controller
{
    use DoctorData, MailEngine;
    protected $physiotherapyschedule;

    public function __construct(PhysiotherapySchedule $physiotherapyschedule)
    {
        $this->middleware('auth');
        $this->physiotherapyschedule = new Repo($physiotherapyschedule);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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


    public function physiotherapySchedule()
    {
        return Template::loadView("admin.physiotherapy.schedule");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function physiotherapyScheduleViewer()
    {
        $schedule_date = date("d-M-Y");
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        // $doctor_list = $this->getActiveDoctorsList();
        $doctor_list = DB::select("select * from doctor_info_vw
            where specialization_lookup_no_fk in (301,482) and au_entry_hospital_pk_no =   $ses_hospital_id ");
        $doctor_appointment_info = DB::table("patn_appointment_vw")->where('au_entry_hospital_pk_no', $ses_hospital_id)->get();
        $appointment_arr = [];
        if (!empty($doctor_appointment_info)) {
            foreach ($doctor_appointment_info as $app_row) {
                if (isset($appointment_arr[$app_row->doctor_no_fk])) {
                    $appointment_arr[$app_row->doctor_no_fk]++;
                } else {
                    $appointment_arr[$app_row->doctor_no_fk] = 0;
                }
            }
        }
        //dd($appointment_arr);
        $patn_schedule = DB::select("select a.schedule_no_pk,a.patient_no_fk,b.patient_name,a.selected_service_name, a.schedule_dt,a.start_time,a.end_time, (a.end_time-a.start_time) * 24 * 60 as minutesbetween,c.invoice_no_pk, app.appoint_no_pk
            from patn_service_schedule a

            left join patn_registration b on a.patient_no_fk=b.patient_no_pk
            left join PATN_APPOINTMENT_VW app on a.patient_no_fk=app.patient_no_pk
            left join finc_invoicemst_sum_vw c on a.invoice_no_fk=c.invoice_no_pk
            where a.schedule_dt=to_date('$schedule_date','dd/mm/yyyy') and a.au_entry_hospital_pk_no =   $ses_hospital_id
            order by minutesbetween desc");
        $sc_arr = [];
        if (!empty($patn_schedule)) {
            foreach ($patn_schedule as $sc_info) {
                $start_time = strtotime(date("h:i a", strtotime($sc_info->start_time)));
                $end_time = strtotime(date("h:i a", strtotime($sc_info->end_time)));
                $sc_arr[$sc_info->schedule_no_pk] = $sc_info->patient_name . "_" . $sc_info->selected_service_name . "_" . $start_time . "_" . $end_time . "_" . $sc_info->schedule_no_pk . "_" . $sc_info->invoice_no_pk . "_" . $sc_info->invoice_no_pk . "_" . $sc_info->invoice_no_pk;
            }
        }


        return Template::loadView("admin.physiotherapy.schedule_viewer", ["doctor_list" => $doctor_list, "sc_arr" => $sc_arr, "schedule_date" => $schedule_date, "appointment_arr" => $appointment_arr]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function physiotherapyScheduleCalendar($schedule_date)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $doctor_list = $this->getActiveDoctorsList();

        $patn_schedule = DB::select("select a.schedule_no_pk, a.patient_no_fk,b.patient_name, a.selected_service_name, a.schedule_dt,a.start_time,a.end_time, (a.end_time-a.start_time) * 24 * 60 as minutesbetween,c.invoice_no_pk
            from patn_service_schedule a
            left join finc_invoicemst_sum_vw c on a.invoice_no_fk=c.invoice_no_pk
            left join patn_registration b on a.patient_no_fk=b.patient_no_pk

            where a.schedule_dt= to_date('$schedule_date','dd/mm/yyyy')
            and a.au_entry_hospital_pk_no =  $ses_hospital_id
            order by minutesbetween desc");

        // left join finc_invoicemst_sum_vw c on a.schedule_no_pk=c.appoint_service_no_fk
        $sc_arr = [];
        if (!empty($patn_schedule)) {
            foreach ($patn_schedule as $sc_info) {
                $start_time = strtotime(date("h:i a", strtotime($sc_info->start_time)));
                $end_time = strtotime(date("h:i a", strtotime($sc_info->end_time)));
                $sc_arr[$sc_info->schedule_no_pk] = $sc_info->patient_name . "_" . $sc_info->selected_service_name . "_" . $start_time . "_" . $end_time . "_" . $sc_info->schedule_no_pk . "_" . $sc_info->invoice_no_pk . "_" . $sc_info->patient_no_fk;
            }
        }
        // dd($sc_arr);
        return Template::loadView("admin.physiotherapy.schedule.service_schedule_calendar", ["sc_arr" => $sc_arr, "schedule_date" => $schedule_date]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $auth_id = Auth::id();

        DB::beginTransaction();
        try {

            $sc_seq_count = PhysiotherapySchedule::latest('schedule_no_pk')->first();
            $sc_code = isset($sc_seq_count) ? "S-" . ($sc_seq_count->schedule_no_pk + 1) : "S-" . 1;

            $hdn_prescription_id = $request->hdn_prescription_id;
            $hdn_patient_id = $request->hdn_patient_id;
            $hdn_pt_service_names = rtrim($request->hdn_pt_service_names, ", ");
            $pt_service = implode(",", $request->pt_service);
            $no_of_session = $request->no_of_session * 1;
            $session_duration = $request->session_duration;
            $cmb_room = $request->cmb_room;
            // doctor
            $doctor = $request->doctor_id;


            $minutes = 0;
            if (strpos($session_duration, ':') !== false) {
                list($session_duration, $minutes) = explode(':', $session_duration);
            }
            $ses_duration = $session_duration * 60 + $minutes;


            $start_date = new Carbon($request->start_date);
            $DstartDate = date("Y-M-d", strtotime($start_date->toDateString()));
            $DendDate = date("Y-M-d", strtotime("+3 months", strtotime($start_date->toDateString())));
            $period = CarbonPeriod::create($DstartDate, $DendDate);

            $ses_no = 1;
            foreach ($period as $key => $date) {

                $sc_date  = date("Y-M-d", strtotime($date->toDateString()));
                $startDateTime = date("Y-M-d H:i", strtotime($sc_date . " " . $request->start_time));

                $endTime = date("H:i", strtotime("+$ses_duration minutes", strtotime($request->start_time)));
                $endDateTime = date("Y-M-d H:i", strtotime($sc_date . " " . $endTime));

                $sc_d  = date("D", strtotime($date->toDateString()));
                $schedule_day_arr = $request->schedule_day;

                if (in_array('All', $schedule_day_arr)) {
                    if ($ses_no <= $no_of_session) {
                        $sc_data = [
                            'SCHEDULE_CODE' => $sc_code,
                            'PATIENT_NO_FK' => $hdn_patient_id,
                            'PRESCRIPTION_NO_FK' => $hdn_prescription_id,
                            'SELECTED_SERVICE_NO'   => $pt_service,
                            'SELECTED_SERVICE_NAME' => $hdn_pt_service_names,
                            'SCHEDULE_DT' => $sc_date,
                            'SCHEDULE_SESSION' => $no_of_session,
                            'SESSION_DURATION' => $session_duration,
                            'START_TIME' => $startDateTime,
                            'END_TIME' => $endDateTime,
                            'YYYYMM' => date("Ym", strtotime($sc_date)),
                            'ROOM_NO_FK' => $cmb_room,
                            'AU_ENTRY_BY' => $auth_id,
                            'AU_ENTRY_HOSPITAL_PK_NO' => Session::get('user.ses_hospital_no_pk'),
                            // doctor
                            // 'PERSON_NO_FK' => $doctor,
                        ];

                        $this->physiotherapyschedule->create($sc_data);
                        $ses_no++;
                    }
                } else {

                    if (in_array($sc_d, $schedule_day_arr)) {
                        if ($ses_no <= $no_of_session) {
                            $sc_data = [
                                'SCHEDULE_CODE' => $sc_code,
                                'PATIENT_NO_FK' => $hdn_patient_id,
                                'PRESCRIPTION_NO_FK' => $hdn_prescription_id,
                                'SELECTED_SERVICE_NO'   => $pt_service,
                                'SELECTED_SERVICE_NAME' => $hdn_pt_service_names,
                                'SCHEDULE_DT' => $sc_date,
                                'SCHEDULE_SESSION' => $no_of_session,
                                'SESSION_DURATION' => $session_duration,
                                'START_TIME' => $startDateTime,
                                'END_TIME' => $endDateTime,
                                'YYYYMM' => date("Ym", strtotime($sc_date)),
                                'ROOM_NO_FK' => $cmb_room,
                                'AU_ENTRY_BY' => $auth_id,
                                'AU_ENTRY_HOSPITAL_PK_NO' => Session::get('user.ses_hospital_no_pk'),
                                // doctor
                                // 'PERSON_NO_FK' => $doctor,
                            ];

                            $this->physiotherapyschedule->create($sc_data);
                            $ses_no++;
                        }
                    }
                }
            }

            DB::commit();
            $message = ['msg' => 'Schedule Created Successfully', 'title' => 'Success', 'insert_id' => 1];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function appointmentList(Request $request)
    {
        //$this->sendMail();
        $appointment_date = date("Y-m-d", strtotime(date("d-m-Y")));
        $appointment_rs = DB::table("patn_appointment_vw")
            ->select("patn_appointment_vw.*", "prest_prescriptionmst_physio_vw.prescription_no_pk")
            ->leftjoin("prest_prescriptionmst_physio_vw", "patn_appointment_vw.appoint_no_pk", "=", "prest_prescriptionmst_physio_vw.appointment_no_fk")
            ->orderBy("patn_appointment_vw.appoint_no_pk", "desc")
            ->where("cancel_ind", 0)->where("appoint_date", $appointment_date)->get();

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

        return Template::loadView("admin.physiotherapy.prescription.ptherapy_appointment_list", ['appointment_rs' => $appointment_rs, 'appointment_date' => $appointment_date, "pending_ind" => $pending_ind, "payment_ind" => $payment_ind, "cancel_ind" => $cancel_ind, "prescription_ind" => $prescription_ind]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function appointmentListByDate($appointment_date)
    {
        $appointment_date = date("Y-m-d", strtotime($appointment_date));
        $appointment_rs = DB::table("patn_appointment_vw")
            ->select("patn_appointment_vw.*", "prest_prescriptionmst_physio_vw.prescription_no_pk")
            ->leftjoin("prest_prescriptionmst_physio_vw", "patn_appointment_vw.appoint_no_pk", "=", "prest_prescriptionmst_physio_vw.appointment_no_fk")
            ->orderBy("prest_prescriptionmst_physio_vw.prescription_no_pk", "desc")
            ->where("cancel_ind", 0)->where("appoint_date", $appointment_date)->get();

        return Template::loadView("admin.physiotherapy.prescription.ptherapy_appointment_list_card", ['appointment_rs' => $appointment_rs, 'appointment_date' => $appointment_date]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function serviceSchedule()
    {
        $presc_date = date("Y-m-d");
        $start_date = new Carbon($presc_date);
        $DstartDate = date("Y-M-d", strtotime($start_date->toDateString()));

        $prescription_mst = db::table("prest_prescriptionmst_physio_vw a")
            ->leftjoin('prest_prescriptiondtl_physio_vw b', 'a.prescription_no_pk', '=', 'b.prescription_no_fk')
            ->select('a.prescription_no_pk', 'a.prescription_datetime', 'a.prescription_code', 'a.doctor_person_no_fk', 'a.doctor_code', 'a.doctor_name', 'a.doctor_photo', 'a.doc_gender_txt', 'a.doctor_specialization', 'a.doctor_phone_no', 'a.degree1', 'a.degree2', 'a.degree3', 'a.degree4', 'a.patient_no_fk', 'a.patient_name', 'a.patient_code', 'a.patient_photo', 'a.gender_txt', 'a.mobile1', db::raw("listagg(b.presdtl_data , ', ') within group ( order by b.presdtl_data) presdtl_data "))
            ->where("a.status", 1)
            ->where("a.prescription_date", date('Y-m-d'))
            ->where("a.au_entry_hospital_pk_no", Session::get('user.ses_hospital_no_pk'))
            //->whereRaw(DB::raw("a.prescription_date=to_date('$DstartDate','YY-MM-DD')"))
            ->whereIn("b.itemtype_lookupdata_code", ['PTET', 'PTTE', 'ACUP'])
            ->groupby('a.prescription_no_pk', 'a.prescription_datetime', 'a.prescription_code', 'a.doctor_person_no_fk', 'a.doctor_code', 'a.doctor_name', 'a.doctor_photo', 'a.doc_gender_txt', 'a.doctor_specialization', 'a.doctor_phone_no', 'a.degree1', 'a.degree2', 'a.degree3', 'a.degree4', 'a.patient_no_fk', 'a.patient_name', 'a.patient_photo', 'a.patient_code', 'a.gender_txt', 'a.mobile1')
            ->orderBy('a.prescription_no_pk', 'desc')
            ->get();
        // dd($prescription_mst);

        $sc_date_arr = $sc_data_name_arr = [];
        $schedule_info = DB::table("patn_service_schedule")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where("active_status", 1)->get();
        if (!empty($schedule_info)) {
            foreach ($schedule_info as $sc_row) {
                $sc_date_arr[$sc_row->prescription_no_fk][] = date("d/m/Y", strtotime($sc_row->schedule_dt));
                $sc_data_name_arr[$sc_row->prescription_no_fk][] = $sc_row->selected_service_name;
            }
        }

        $room_list = Room::where("physio_ind", 1)->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->get();

        return Template::loadView("admin.physiotherapy.schedule.service_schedule", ["prescription_mst" => $prescription_mst, "sc_date_arr" => $sc_date_arr, "sc_data_name_arr" => $sc_data_name_arr, "room_list" => $room_list]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function serviceScheduleList(Request $request)
    {
        $presc_date = new Carbon($request->presc_date);
        $presc_date = date("m-d-Y", strtotime($presc_date->toDateString()));

        $presc_query = DB::table("prest_prescriptionmst_physio_vw a")
            ->select('a.prescription_no_pk', 'a.prescription_datetime', 'a.prescription_code', 'a.doctor_person_no_fk', 'a.doctor_code', 'a.doctor_name', 'a.doctor_photo', 'a.doc_gender_txt', 'a.doctor_specialization', 'a.doctor_phone_no', 'a.degree1', 'a.degree2', 'a.degree3', 'a.degree4', 'a.patient_no_fk', 'a.patient_name', 'a.patient_code', 'a.patient_photo', 'a.gender_txt', 'a.mobile1', db::raw("listagg(b.presdtl_data , ', ') within group (order by b.presdtl_data) presdtl_data"))
            ->leftjoin('prest_prescriptiondtl_physio_vw b', 'a.prescription_no_pk', '=', 'b.prescription_no_fk')
            ->where("a.au_entry_hospital_pk_no", Session::get('user.ses_hospital_no_pk'))
            ->whereIn("b.itemtype_lookupdata_code", ['PTET', 'PTTE', 'ACUP'])
            ->where("a.status", 1);

        if ($request->presc_date != "") {
            $presc_query->when($presc_date, function ($query, $presc_date) {
                //return $query->where('a.prescription_date', $presc_date);
                return $query->whereRaw(DB::raw("a.prescription_date=to_date('$presc_date','MM-DD-YYYY')"));
            });
        }
        // dd($request->hdn_presc_id);
        if ($request->hdn_presc_id != "") {
            $presc_query->when($request->hdn_presc_id, function ($query, $pres_id) {
                return $query->where('a.prescription_no_pk', $pres_id);
            });
        }
        if ($request->hdn_patient_id != "") {
            $presc_query->when($request->hdn_patient_id, function ($query, $patient_id) {
                return $query->where('a.patient_no_fk', $patient_id);
            });
        }
        if ($request->hdn_doctor_id != "") {
            $presc_query->when($request->hdn_doctor_id, function ($query, $doctor_code) {
                return $query->where('a.doctor_person_no_fk', $doctor_code);
            });
        }

        if ($request->service_room != "") {
            $presc_query->when($request->service_room, function ($query, $service_room) {
                return $query->where('a.room_no_fk', $service_room);
            });
        }


        $prescription_mst = $presc_query->groupby('a.prescription_no_pk', 'a.prescription_datetime', 'a.prescription_code', 'a.doctor_person_no_fk', 'a.doctor_code', 'a.doctor_name', 'a.doctor_photo', 'a.doc_gender_txt', 'a.doctor_specialization', 'a.doctor_phone_no', 'a.degree1', 'a.degree2', 'a.degree3', 'a.degree4', 'a.patient_no_fk', 'a.patient_name', 'a.patient_photo', 'a.patient_code', 'a.gender_txt', 'a.mobile1')
            ->orderBy('a.prescription_no_pk', 'desc')->get();

        // dd($prescription_mst);

        /*$prescription_mst = db::table("prest_prescriptionmst_physio_vw a")
        ->leftjoin('prest_prescriptiondtl_physio_vw b', 'a.prescription_no_pk', '=', 'b.prescription_no_fk')
        ->select('a.prescription_no_pk','a.prescription_date','a.prescription_code','a.doctor_person_no_fk','a.doctor_code','a.doctor_name','a.doctor_photo','a.doc_gender_txt','a.doctor_specialization','a.doctor_phone_no','a.degree1','a.degree2','a.degree3','a.degree4','a.patient_no_fk','a.patient_name','a.patient_code','a.patient_photo','a.gender_txt','a.mobile1',db::raw("listagg(b.presdtl_data , ', ') within group (order by b.presdtl_data) presdtl_data"))
        ->where("a.status", 1)
        ->whereIn("b.itemtype_lookup_code", ['ETHER', 'THRPEX'])
        ->groupby('a.prescription_no_pk','a.prescription_date','a.prescription_code','a.doctor_person_no_fk','a.doctor_code','a.doctor_name','a.doctor_photo','a.doc_gender_txt','a.doctor_specialization','a.doctor_phone_no','a.degree1','a.degree2','a.degree3','a.degree4','a.patient_no_fk','a.patient_name','a.patient_photo','a.patient_code','a.gender_txt','a.mobile1')
        ->orderBy('a.prescription_no_pk', 'desc')
        ->get();*/

        $sc_date_arr = $sc_data_name_arr = [];
        $schedule_info = DB::table("patn_service_schedule")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where("active_status", 1)->get();
        if (!empty($schedule_info)) {
            foreach ($schedule_info as $sc_row) {
                $sc_date_arr[$sc_row->prescription_no_fk][] = date("d/m/Y", strtotime($sc_row->schedule_dt));
                $sc_data_name_arr[$sc_row->prescription_no_fk][] = $sc_row->selected_service_name;
            }
        }

        return Template::loadView("admin.physiotherapy.schedule.service_schedule_list", ["prescription_mst" => $prescription_mst, "sc_date_arr" => $sc_date_arr, "sc_data_name_arr" => $sc_data_name_arr]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createServiceSchedule($prescription_id)
    {
        $doctor_info = DB::table("doctor_info_vw")
            ->where("status", 1)
            // ->where("job_type", "DR")
            ->where('serviceunit_no_fk', 1099)
            ->orderBy("full_name", "asc")
            ->get();
        // dd($doctor_info);
        $prescription_mst = DB::table("prest_prescriptionmst_physio_vw")->where("prescription_no_pk", $prescription_id)->first();
        $prescription_service = DB::table("prest_prescriptiondtl_physio_vw")
            ->whereIn("itemtype_lookupdata_code", ['PTET', 'PTTE', 'ACUP'])
            ->where("prescription_no_pk", $prescription_id)->get();
        // dd($prescription_service);
        $schedule_info = PhysiotherapySchedule::where("prescription_no_fk", $prescription_id)->get();
        $sc_data = "";
        if (!empty($schedule_info)) {
            foreach ($schedule_info as $row) {
                $sc_data .= $row->selected_service_no . ",";
            }
        }
        $sc_data = rtrim($sc_data, ", ");
        $room_list = Room::where("physio_ind", 1)->get();
        return Template::loadView("admin.physiotherapy.schedule.service_schedule_create", ["prescription_service" => $prescription_service, "room_list" => $room_list, "prescription_mst" => $prescription_mst, "sc_data" => $sc_data, 'doctor_info' => $doctor_info]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function patient_sc_details()
    {
        return "This section is under construction";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function service_consultation($schedule_id)
    {

        $consultation_details = PhysiotherapySchedule::leftjoin('patient_info_vw', 'patn_service_schedule.patient_no_fk', '=', 'patient_info_vw.patient_no_pk')
            ->select('patn_service_schedule.schedule_no_pk', 'patn_service_schedule.schedule_code', 'patn_service_schedule.patient_no_fk', 'patn_service_schedule.prescription_no_fk', 'patn_service_schedule.selected_service_no', 'patn_service_schedule.selected_service_name', 'patn_service_schedule.schedule_dt', 'patn_service_schedule.schedule_session', 'patn_service_schedule.session_duration', 'patn_service_schedule.start_time', 'patn_service_schedule.end_time', 'patn_service_schedule.active_status', 'patient_info_vw.patient_code', 'patient_info_vw.patient_name', 'patient_info_vw.gender_txt', 'patient_info_vw.age', 'patient_info_vw.mobile1')
            ->where("schedule_no_pk", $schedule_id)
            ->first();


        $item_arr = [];
        if (!empty($consultation_details)) {
            $service_item_ids = explode(",", $consultation_details->selected_service_no);
            $service_item_info = DB::table("sysc_serviceitem")->whereIn("item_no_pk", $service_item_ids)->get();
            if (!empty($service_item_info)) {
                foreach ($service_item_info as $item_row) {
                    $item_arr[$item_row->item_no_pk] = $item_row->sales_price;
                }
            }
        }

        return Template::loadView("admin.physiotherapy.billing.physiotherapy_consultation", ["consultation_details" => $consultation_details, "item_arr" => $item_arr, "schedule_id" => $schedule_id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function service_consultation_invoice($invoice_id)
    {
        $invoice_mst_info = DB::table("finc_invoicemst_sum_vw")
            ->where("invoice_no_pk", $invoice_id)
            ->first();

        $invoice_dtls_info = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->get();

        return Template::loadView("admin.physiotherapy.billing.physiotherapy_consultation_invoice", ['invoice_mst_info' => $invoice_mst_info, "invoice_dtls_info" => $invoice_dtls_info, "invoice_id" => $invoice_id]);
    }
}
