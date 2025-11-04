<?php

namespace App\Repositories;

use App\Models\HrmsSchedule;
use App\Repositories\BaseRepository;
use App\Traits\LookupData;
use App\Traits\MailEngine;
use Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use PDO;
use App\Models\Company;
use Barryvdh\DomPDF\PDF;
use Session;

class PatientAppointmentRepository extends BaseRepository
{
    use LookupData, MailEngine;
    protected $pat_reg = null;
    protected $baseRepository;

    public function __construct(HrmsSchedule $schedule)
    {
        $this->schedule = $schedule;
        $this->baseRepository = new BaseRepository($schedule);
    }

    public function all()
    {
        return $this->schedule->all();
    }

    public function createOrUpdate($request, $id = null)
    {
        //dd($request->all());
        $auth_id = Auth::id();
        $doctor_no_fk = $request->doctor_name;
        $schedule_no = '';
        DB::beginTransaction();
        try {
            $startDate = new Carbon($request->from_date);
            $endDate = new Carbon($request->to_date);

            $check_if_exist = HrmsSchedule::select('schedule_no_pk', 'schedule_dt')
                ->where('doctor_person_no_fk', '=', $doctor_no_fk)
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
                    // dd($sc_d, $schedule_day_arr);
                    $procedureName = 'pkg_hrms_schedule.prc_docschedule';
                    $hospital_id = Session::get('user.ses_hospital_no_pk');

                    $data_bindings = [
                        'in_doctor_person_no_fk' => $request->doctor_name,
                        'in_schedule_dt' => $sc_date,
                        'in_schedule_session' => 0,
                        'in_start_time' => $sc_start_date,
                        'in_end_time' => $sc_end_date,
                        'in_YM' => 0,
                        'in_avg_load' => $request->avg_load,
                        'in_block_load' => $request->block_load,
                        'in_avg_duration' => $request->avg_duration,
                        'in_duty_type' => '0',
                        'in_room_no_fk' => 0,
                        'in_shift_no_fk' => $request->shift_type,
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
                        if(!in_array($sc_d, $schedule_day_arr) && !in_array('All', $schedule_day_arr)) {
                            continue;
                        } else {
                            $result = DB::executeProcedure($procedureName, $data_bindings);
                        }
                    }

                    // dd($request->slot,$schedule_no);
                    if ($request->slot == 1) {
                        if ($schedule_no != "") {
                            $procedureName2 = 'pkg_hrms_schedule.time_schedule';
                            $data_bindings2 = [
                                'in_SCHEDULE_NO_PK' => $schedule_no,
                                'IN_AU_ENTRY_HOSPITAL_PK_NO' => $hospital_id,

                            ];
                            DB::executeProcedure($procedureName2, $data_bindings2);
                        }
                    }
                }
                
            }
            $last_id = 0;
            DB::commit();
            $message = ['msg' => 'Doctor Schedule Created Successfully', 'title' => 'Success', 'insert_id' => $last_id];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function createOrUpdatePatientAppointment($request, $id = null)
    {
        //dd($request->all());
        $agent_id = 0;
        if($request->inform == 'Marketing Agent'){
           $agent_id = $request->agent_id_hdn;
        }elseif($request->inform == 'Staff'){
           $agent_id = $request->hdn_staff__id;
        }

        // dd($request->inform,$agent_id);
        $empty_str = "";
        $auth_id = Auth::id();
        $doctor_no_fk = $request->doctor_name;

        DB::beginTransaction();

        // try {
        $appointment_dt = new Carbon($request->hdn_appointment_date);
        $app_date = date("Y-M-d", strtotime($appointment_dt->toDateString()));

        $patient_dob = new Carbon($request->patient_dob);
        $pat_dob = date("Y-M-d", strtotime($patient_dob->toDateString()));

        $marital_status_arr = $this->getLookupListByCode("MARSTS");
        $gender_arr = $this->getLookupListByCode("GENDER");

        $pdo = DB::getPdo();
        $doctor_id = $request->hdn_doctor_id;
        $hdn_schedule_id = $request->hdn_schedule_id;
        $slot_no_pk = $request->slot_no_pk;
        // dd( $slot_no_pk);
        $appointment_type = $request->visit_type;
        $patient_id = $request->hdn_patient_id;
        $patient_code = $request->patient_code;
        $patient_salutation = $request->patient_salutation;
        $patient_first_name = $request->patient_first_name;
        $patient_last_name = $request->patient_last_name;
        $phone_no = $request->phone_no;
        $patient_gender = $request->patient_gender;
        $gender_txt = isset($gender_arr[$request->patient_gender]) ? $gender_arr[$request->patient_gender] : '';
        $marital_status = $request->patient_marital_status;
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

        // $patient_type = $request->patient_type;
        $patient_type = $request->patienttype;
        $priority = $request->appointment_priority;
        $hdn_first_refer = isset($request->hdn_first_refer) ? $request->hdn_first_refer : "";
        $hdn_second_refer = isset($request->hdn_second_refer) ? $request->hdn_second_refer : "";

        $priority = $request->appointment_priority;
        $address = $request->address;
        $inform = isset($request->inform) ? $request->inform : '';
        $in_cor_member_no_pk = isset($request->corporate_id) ? $request->corporate_id : '';

        $item_name = $request->item_name;
        $in_chief_comp_name = "";
        if (isset($item_name)) {
            for ($i = 0; $i < sizeof($item_name); $i++) {
                if ($item_name[$i] != "") {
                    $in_chief_comp_name .= $item_name[$i] . ",";
                }
            }
            $chif_complain = rtrim($in_chief_comp_name, ", ");
        } else {
            $chif_complain = null;
        }

        $service_unit = $request->hdn_service_unit;
        $appoint_source = 'WEB';
        $entry_session = 'session';
        $hospital_id = Session::get('user.ses_hospital_no_pk'); //$request->hdn_hospital_id;
        $is_pay_consultation = $request->is_pay_consultation;
        $is_manual_sl = isset($request->patient_manual_sl_checkbox) ? 1 : 0;
        $patient_note = $request->patient_note;
        $app_start_time = $request->start_time;
        $app_end_time = $request->end_time;
        $in_start_time = isset($app_start_time) ? date("Y-m-d H:i",strtotime($app_date." ".$app_start_time)) : null;
        $in_end_time = isset($app_end_time) ? date("Y-m-d H:i",strtotime($app_date." ".$app_end_time)) : null;
        $in_manual_time_ind = (isset($in_start_time) || isset($in_end_time)) ? 1: 0;


        // $start_time = $request->start_time;
        //$end_time = $request->end_time;
        // OUT PAREMETER INITIALIZE
        $in_religion =  isset($request->patient_religion)? $request->patient_religion : '';
        $corporate_id  = isset($request->corporate_name) ? $request->corporate_name : '';
        $corporate_name = '';
        if ($corporate_id != "") {
            $corporate_name = DB::table('ccm_corporateclient_vw')->select('ccm_client_name')->where('ccm_client_no_pk', $corporate_id)->first()->ccm_client_name;
        }

        $out_sl_no = $out_appoint_no = $out_appoint_id = $out_start_time = $out_end_time = $out_patient_no_pk  = $out_error = "";

        $stmt = $pdo->prepare("begin pkg_patmanagement.prc_appointment(:in_appoint_date,:in_doctor_no_fk,:in_schedule_no_fk,:in_slot_no_pk,:in_manual_time_ind,:in_start_time,:in_end_time,:in_appoint_type,:in_patient_no_fk,:in_salutation,:in_patient_fname,:in_patient_lname,:in_phone_mobile,:in_email,:in_dob,:in_age_dd,:in_age_mm,:in_age_yy,:in_age,:in_gender,:in_gender_txt,:in_marital_status,:in_marital_status_txt,:in_address,:in_address1,:in_address2,:in_blood_group,:in_religion,:in_chif_complain,:in_patient_type_no_fk,:in_su_no_fk,:in_priority_no_fk,:in_appoint_source,:in_first_referral,:in_second_referral,:in_is_manual_sl,:in_appoint_note,:in_ccm_client_no_fk,:in_ccm_client_name,:in_cor_member_no_pk,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:out_sl_no,:out_appoint_no,:out_appoint_id,:out_patient_no_pk,:out_start_time,:out_end_time,:out_error); end;"); //,:in_is_manual_sl

        $stmt->bindParam(':in_appoint_date', $app_date);
        $stmt->bindParam(':in_doctor_no_fk', $doctor_id);
        $stmt->bindParam(':in_schedule_no_fk', $hdn_schedule_id);
        $stmt->bindParam(':in_slot_no_pk', $slot_no_pk);
        $stmt->bindParam(':in_manual_time_ind', $in_manual_time_ind);
        $stmt->bindParam(':in_start_time', $in_start_time);
        $stmt->bindParam(':in_end_time', $in_end_time);
        $stmt->bindParam(':in_appoint_type', $appointment_type);
        $stmt->bindParam(':in_patient_no_fk', $patient_id);
        $stmt->bindParam(':in_salutation', $patient_salutation);
        $stmt->bindParam(':in_patient_fname', $patient_first_name);
        $stmt->bindParam(':in_patient_lname', $patient_last_name);
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
        $stmt->bindParam(':in_address1', $empty_str);
        $stmt->bindParam(':in_address2', $empty_str);
        $stmt->bindParam(':in_blood_group', $blood_group);
        $stmt->bindParam(':in_religion', $in_religion);
        $stmt->bindParam(':in_chif_complain', $chif_complain);
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
        $stmt->bindParam(':in_cor_member_no_pk', $in_cor_member_no_pk);
        $stmt->bindParam(':in_au_entry_by', $auth_id);
        $stmt->bindParam(':in_au_entry_session', $entry_session);
        $stmt->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);

        $stmt->bindParam(':out_sl_no', $out_sl_no, PDO::PARAM_INT);
        $stmt->bindParam(':out_appoint_no', $out_appoint_no, PDO::PARAM_INT);
        $stmt->bindParam(':out_appoint_id', $out_appoint_id, PDO::PARAM_STR, 200);
        $stmt->bindParam(':out_patient_no_pk', $out_patient_no_pk, PDO::PARAM_INT);
        $stmt->bindParam(':out_start_time', $out_start_time, PDO::PARAM_STR, 200);
        $stmt->bindParam(':out_end_time', $out_end_time, PDO::PARAM_STR, 200);
        $stmt->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
        // dd($stmt);
        $stmt->execute();

    

       
        if ($out_error == "000") {
            DB::table('patn_appointment')
            ->where('appoint_no_pk', $out_appoint_no)
            ->update([
                'online_ind' => $request->input('patient_type')
            ]);
            if ($request->slot_no_pk !='') {
                $slot_no_pk = $request->slot_no_pk;
                $slot_info = [
                    'available_ind' => 0,
                    'appoint_no_fk' => $out_appoint_no
                ];
                DB::table('hrms_schedule_slot')->where('slot_no_pk', $slot_no_pk)->update($slot_info);
            }
            $app_info = DB::table("patn_appointment_vw")
                ->where("appoint_no_pk", $out_appoint_no)
                ->first();
            
            $patient_id = $app_info->patient_no_pk;

            // update patient info Start
            if (Session::get('user.ses_hospital_code') == 'IMPALA' && $request->patient_type == '1'){
                $address_data = [
                    'patient_area_no_fk' => $request->hdn_area_code,
                    'patient_area_name' => $request->hdn_area_name,
                    'agent_no_fk' => $agent_id
                ];
            }else{
                $address_data = [
                    'present_addr' => $request->patient_address,
                    'patient_area_no_fk' => $request->hdn_area_code,
                    'patient_area_name' => $request->hdn_area_name,
                    'agent_no_fk' => $agent_id,
                    'inform_text' => $inform
                ];
            }

            DB::table('patn_registration')->where('patient_no_pk', $patient_id)->update($address_data);

            // End
            $patient_code = $app_info->patient_code;
            $app_code = $app_info->appoint_code;

            $appointment_date = date("l, d/m/Y", strtotime($out_start_time));
            $prescription_route = ""; //route('prescription-print');
            $msg = "<table class='table table-borderless'>
				<thead>
				<tr>
				<th scope='col' colspan='2'>New Appointment ( $app_info->appoint_code ) created.</th>
				</tr>
				</thead>
				<tbody>
				<tr>
				<th scope='row' class='text-right'>Doctor Name : </th>
				<td scope='row' class='text-left'>$app_info->full_name</td>
				</tr>
				<tr>
				<th scope='row' class='text-right'>Patient Name : </th>
				<td scope='row' class='text-left'>$app_info->patient_name</td>
				</tr>
				<tr>
				<th scope='row' class='text-right'>Chief Complain : </th>
				<td scope='row' class='text-left'>$app_info->chif_complain</td>
				</tr>
				<tr>
				<th scope='row' class='text-right'>Appointment Date : </th>
				<td scope='row' class='text-left'>" . date("d-m-Y", strtotime($app_info->appoint_date)) . "</td>
				</tr>
				<tr>
				<th scope='row' class='text-right'>Serial No : </th>
				<td scope='row' class='text-left text-danger'>$app_info->slot_sl</td>
				</tr>
				<tr>
				<th scope='col' colspan='2' class='text-center'>
				<br />
                <a href='" . route('patient-appointment-print', $out_appoint_no) . "' class='btn btn-md btn-success noprint '
                           target='_blank' data-id='{{ $out_appoint_no }}' id='apointment_card'
                           title=' Print Appointment Card'>App. Print </a>

				<a href='" . route('home') . "' class='btn btn-danger btn-md' rel='tab' title='Click here to go back to Dashboard'>Exit</a>
				</th>
				</tr>
				</tbody>
				</table>";
            // <button data-dismiss='modal' class='btn btn-md btn-success open-modal cursor-pointer mb-2' data-id='" . $out_appoint_no . "' data-action='" . route('appointment-card-pat', $out_appoint_no) . "' data-title='Appointment card' title='Appointment card' data-modal='common-modal-sm'>App. card</button>
            // <a class='btn btn-primary btn-md' href='" . route('appointments.list-view') . "' rel='tab' data-dismiss='modal' >Appointment List</a>

            $doctor_name = ($app_info->full_name_bangla == "") ? $app_info->full_name :   $app_info->full_name_bangla;
            $doctor_name_english = $app_info->full_name;
           // dd($doctor_name_english);
           $update_ind = 0;
         
           if (Session::get('user.sms_send_ind')==1) {
            $sms = $this->sendSms($app_info->appoint_date,$app_info->start_time,$app_info->end_time, $app_info->mobile1, $doctor_name,$doctor_name_english, $app_info->slot_sl, $app_info->specialization_bangla, $app_info->phone_mobile, $app_info->au_entry_at,$update_ind);
           }
           
            if ($is_pay_consultation == 1) {
                if (Session::get('user.ses_hospital_version') == "V0") {
                    $module_info = DB::table("sysc_module")->where("module_code", "OPDC")->select("module_no_pk")->first();
                    $in_module = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                    $counter_su_no = 0;
                    $second_ref_doc = 0;
                    $appointment_id = $request->visit_type;
                    $appointment_id = $request->reffered_by;
                    $item_id = $request->hdn_item_id;
                    // $patient_note
                    $out_invoice_no = $out_invoice_id = $out_error = "";
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
                    $consultation->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

                    $consultation->execute();
                    if ($out_error == "000") {
                        DB::commit();
                        //if($patient_email !=""){
                        $appointment_datetime = date("d-m-Y", strtotime($app_info->appoint_date));
                        //$this->appointmentMail($patient_email, $app_info->patient_name, $app_info->full_name, $appointment_datetime);
                        //}
                        $message = ["msg" => $msg, 'title' => 'Success', 'out_sl_no' => $out_sl_no, 'insert_id' => $out_appoint_no];
                        //return response()->json($message);
                    } else {
                        DB::rollback();
                        $message = ['msg' => $out_error, 'title' => 'Error'];
                        //return response()->json($message);
                    }
                } else {
                    $module_info = DB::table("sysc_module")->where("module_code", "OPDC")->select("module_no_pk")->first();
                    $in_module = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                    $counter_su_no = 0;
                    $second_ref_doc = 0;
                    $appointment_id = $request->visit_type;
                    $appointment_id = $request->reffered_by;
                    $item_id = $request->hdn_item_id;
                    // $patient_note
                    $out_invoice_no = $out_invoice_id = $out_error = "";

                    $consultation = $pdo->prepare("begin pkg_billing.prc_billinvoice_consult(:in_module_no_fk, :in_counter_su_no_fk, :in_patient_no_fk, :in_patient_code, :in_appoint_no_pk,  :in_appoint_code, :in_first_ref_doc_person_no_fk, :in_second_ref_doc_person_no_fk, :in_pat_type_lookup_no_fk, :in_au_entry_by, :in_au_entry_session, :in_au_entry_hospital_pk_no,:in_item_no_fk, :out_invoice_no, :out_invoice_id,:out_error); end;");

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

                    $consultation->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
                    $consultation->bindParam(':out_invoice_id', $out_invoice_id, PDO::PARAM_STR, 500);
                    $consultation->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

                    $consultation->execute();
                    if ($out_error == "000") {
                        DB::commit();
                        //if($patient_email !=""){
                        $appointment_datetime = date("d-m-Y", strtotime($app_info->appoint_date));
                        //$this->appointmentMail($patient_email, $app_info->patient_name, $app_info->full_name, $appointment_datetime);
                        //}
                        $message = ["msg" => $msg, 'title' => 'Success', 'out_sl_no' => $out_sl_no, 'insert_id' => $out_appoint_no];
                        //return response()->json($message);
                    } else {
                        DB::rollback();
                        $message = ['msg' => $out_error, 'title' => 'Error'];
                        //return response()->json($message);
                    }
                }
            } else {
                DB::commit();
                $message = ["msg" => $msg, 'title' => 'Success', 'out_sl_no' => $out_sl_no, 'insert_id' => $out_appoint_no];
            }
        } else {
            DB::rollback();
            $message = ["msg" => "Appointment Create Failed $out_error $is_manual_sl", 'title' => 'Error', 'out_sl_no' => ''];
        }
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        // }

        return response()->json($message);
    }
    

    public function consulationConfirm($appointment_id)
    {
        $app_consul = DB::table('PATN_APPOINTMENT_VW')->where('appoint_no_pk', '=', $appointment_id)->first();
        //dd($app_consul);
        $patient_id = $app_consul->patient_no_pk;
        $patient_code = $app_consul->patient_code;
        $doctor_id = $app_consul->doctor_no_fk;
        // dd($patient_code);
        $auth_id = Auth::id();
        $entry_session = 'session';
        $hospital_id = 1;
        $patient_type = 1;
        $in_module = 9;
        $counter_su_no = 1099;
        $second_ref_doc = 0;
        $appointment_id = $app_consul->appoint_no_pk;
        $item_id = 6156081;

        $out_sl_no = $out_invoice_no = $out_appoint_no = $out_invoice_id = $out_error = "";

        $pdo = DB::getPdo();

        $consultation = $pdo->prepare("begin pkg_billing.prc_billinvoice_consult(:in_module_no_fk, :in_counter_su_no_fk, :in_patient_no_fk, :in_patient_code, :in_appoint_no_pk,  :in_appoint_code, :in_first_ref_doc_person_no_fk, :in_second_ref_doc_person_no_fk, :in_pat_type_lookup_no_fk, :in_au_entry_by, :in_au_entry_session, :in_au_entry_hospital_pk_no,:in_item_no_fk, :out_invoice_no, :out_invoice_id,:out_error); end;");

        $consultation->bindParam(':in_module_no_fk', $in_module);
        $consultation->bindParam(':in_counter_su_no_fk', $counter_su_no);
        $consultation->bindParam(':in_patient_no_fk', $patient_id);
        $consultation->bindParam(':in_patient_code', $patient_code);
        $consultation->bindParam(':in_appoint_no_pk', $appointment_id);
        $consultation->bindParam(':in_appoint_code', $patient_code);
        $consultation->bindParam(':in_first_ref_doc_person_no_fk', $doctor_id);
        $consultation->bindParam(':in_second_ref_doc_person_no_fk', $doctor_id);
        $consultation->bindParam(':in_pat_type_lookup_no_fk', $patient_type);
        $consultation->bindParam(':in_au_entry_by', $auth_id);
        $consultation->bindParam(':in_au_entry_session', $entry_session);
        $consultation->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
        $consultation->bindParam(':in_item_no_fk', $item_id);

        $consultation->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
        $consultation->bindParam(':out_invoice_id', $out_invoice_id, PDO::PARAM_STR, 500);
        $consultation->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

        $consultation->execute();
        //dd($out_error);
        if ($out_error == "000") {
            DB::commit();
            $message = ["msg" => 'Consulation Invoice has been printed!', 'title' => 'Success', 'out_sl_no' => $out_sl_no, 'insert_id' => $out_appoint_no];
            return response()->json($message);
        } else {
            DB::rollback();
            $message = ['msg' => $out_error, 'title' => 'Error'];
            return response()->json($message);
        }
    }


    //    Added By Nazmul

    public function coverPatientAppointment($request, $id = null)
    {
        $empty_str = "";
        $auth_id = Auth::id();
        $doctor_no_fk = $request->doctor_name;

        DB::beginTransaction();

        try {
            $appointment_dt = new Carbon($request->hdn_appointment_date);
            $app_date = date("Y-m-d", strtotime($request->hdn_appointment_date));
            //                        $app_date = date("Y-m-d", strtotime($appointment_dt->toDateString()));

            $patient_dob = new Carbon($request->patient_dob);
            $pat_dob = date("Y-m-d", strtotime($patient_dob->toDateString()));

            $marital_status_arr = $this->getLookupListByCode("MARSTS");
            $gender_arr = $this->getLookupListByCode("GENDER");

            $pdo = DB::getPdo();
            $doctor_id = $request->hdn_doctor_id;
            $hdn_schedule_id = $request->hdn_schedule_id;
            $appointment_type = $request->visit_type;
            $patient_id = $request->hdn_patient_id;
            $patient_code = 'P202100' . $request->hdn_patient_id;
            $patient_salutation = $request->patient_salutation;
            $patient_first_name = $request->patient_first_name;
            $patient_last_name = $request->patient_last_name;
            $phone_no = $request->phone;
            $patient_gender = $request->patient_gender;
            $gender_txt = isset($gender_arr[$request->patient_gender]) ? $gender_arr[$request->patient_gender] : '';
            $marital_status = $request->patient_marital_status;
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

            $patient_type = $request->patient_type;
            $priority = $request->appointment_priority;
            $hdn_first_refer = isset($request->hdn_first_refer) ? $request->hdn_first_refer : "";
            $hdn_second_refer = isset($request->hdn_second_refer) ? $request->hdn_second_refer : "";

            $priority = $request->appointment_priority;
            $address = $request->address;

            $item_name = $request->item_name;
            $in_chief_comp_name = "";
            if (isset($item_name)) {
                for ($i = 0; $i < sizeof($item_name); $i++) {
                    if ($item_name[$i] != "") {
                        $in_chief_comp_name .= $item_name[$i] . ",";
                    }
                }
                $chif_complain = rtrim($in_chief_comp_name, ", ");
            } else {
                $chif_complain = null;
            }

            $service_unit = $request->hdn_service_unit;
            $appoint_source = 'WEB';
            $entry_session = 'session';
            $hospital_id = Session::get('user.ses_hospital_no_pk'); //$request->hdn_hospital_id;
            $is_pay_consultation = $request->is_pay_consultation;
            $is_manual_sl = isset($request->patient_manual_sl_checkbox) ? 1 : 0;
            $gender_id = $request->patient_gender_id;
            // OUT PAREMETER INITIALIZE
            $out_sl_no = $out_appoint_no = $out_appoint_id = $out_start_time = $out_patient_no_pk = $out_end_time = $out_error = "";
            $null = null;
            $stmt = $pdo->prepare("begin pkg_patmanagement.prc_appointment(:in_appoint_date,:in_doctor_no_fk,:in_schedule_no_fk,:in_appoint_type,:in_patient_no_fk,:in_salutation,:in_patient_fname,:in_patient_lname,:in_phone_mobile,:in_email,:in_dob,:in_age_dd,:in_age_mm,:in_age_yy,:in_age,:in_gender,:in_gender_txt,:in_marital_status,:in_marital_status_txt,:in_address,:in_address1,:in_address2,:in_blood_group,:in_chif_complain,:in_patient_type_no_fk,:in_su_no_fk,:in_priority_no_fk,:in_appoint_source,:in_first_referral,:in_second_referral,:in_is_manual_sl,:in_appoint_note,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no,:out_sl_no,:out_appoint_no,:out_appoint_id,:out_patient_no_pk,:out_start_time,:out_end_time,:out_error); end;"); //,:in_is_manual_sl
            $date = date("Y-m-d h:i:s");
            $stmt->bindParam(':in_appoint_date', $app_date);
            $stmt->bindParam(':in_doctor_no_fk', $doctor_id);
            $stmt->bindParam(':in_schedule_no_fk', $hdn_schedule_id);
            $stmt->bindParam(':in_appoint_type', $appointment_type);
            $stmt->bindParam(':in_patient_no_fk', $patient_id);
            $stmt->bindParam(':in_salutation', $patient_salutation);
            $stmt->bindParam(':in_patient_fname', $patient_first_name);
            $stmt->bindParam(':in_patient_lname', $patient_last_name);
            $stmt->bindParam(':in_phone_mobile', $phone_no);
            $stmt->bindParam(':in_email', $patient_email);
            $stmt->bindParam(':in_dob', $pat_dob);
            $stmt->bindParam(':in_age_dd', $patient_age_dd);
            $stmt->bindParam(':in_age_mm', $patient_age_mm);
            $stmt->bindParam(':in_age_yy', $patient_age_yy);
            $stmt->bindParam(':in_age', $age);
            $stmt->bindParam(':in_gender', $gender_id);
            $stmt->bindParam(':in_gender_txt', $gender_txt);
            $stmt->bindParam(':in_marital_status', $marital_status);
            $stmt->bindParam(':in_marital_status_txt', $marital_status_txt);
            $stmt->bindParam(':in_address', $address);
            $stmt->bindParam(':in_address1', $empty_str);
            $stmt->bindParam(':in_address2', $empty_str);
            $stmt->bindParam(':in_blood_group', $blood_group);
            $stmt->bindParam(':in_chif_complain', $chif_complain);
            $stmt->bindParam(':in_patient_type_no_fk', $patient_type);
            $stmt->bindParam(':in_su_no_fk', $service_unit);
            $stmt->bindParam(':in_priority_no_fk', $priority);
            $stmt->bindParam(':in_appoint_source', $appoint_source);
            $stmt->bindParam(':in_first_referral', $hdn_first_refer);
            $stmt->bindParam(':in_second_referral', $hdn_second_refer);
            $stmt->bindParam(':in_is_manual_sl', $is_manual_sl);
            $stmt->bindParam(':in_appoint_note', $null);
            $stmt->bindParam(':in_au_entry_by', $auth_id);
            $stmt->bindParam(':in_au_entry_session', $entry_session);
            $stmt->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);

            $stmt->bindParam(':out_sl_no', $out_sl_no, PDO::PARAM_INT);
            $stmt->bindParam(':out_appoint_no', $out_appoint_no, PDO::PARAM_INT);
            $stmt->bindParam(':out_appoint_id', $out_appoint_id, PDO::PARAM_STR, 200);
            $stmt->bindParam(':out_patient_no_pk', $out_patient_no_pk, PDO::PARAM_INT);
            $stmt->bindParam(':out_start_time', $out_start_time, PDO::PARAM_STR, 200);
            $stmt->bindParam(':out_end_time', $out_end_time, PDO::PARAM_STR, 200);
            $stmt->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            // dd($stmt);
            $stmt->execute();



            if ($out_error == "000") {
                $app_info = DB::table("patn_appointment_vw")
                    ->where("appoint_no_pk", $out_appoint_no)
                    ->first();

                $patient_id = $app_info->patient_no_pk;
                $patient_code = $app_info->patient_code;
                $app_code = $app_info->appoint_code;
                $patient_name = $app_info->patient_name;
                $pat_gender_txt = $app_info->gender_txt;
                $pat_age = $app_info->age;
                $phone_mobile = $app_info->phone_mobile;
                $full_name = $app_info->full_name;
                $app_time = date('h:i A', strtotime($app_info->start_time));




                $appointment_date = date("l, d/m/Y", strtotime($out_start_time));
                $prescription_route = ""; //route('prescription-print');
                $msg = "<table class='table table-borderless'>
				<thead>
				<tr>
				<th scope='col' class='text-right'>New Appointment :</th>
				<th scope='col' class='text-left'>( $app_info->appoint_code ) created.</th>
				</tr>
				</thead>
				<tbody>
				<tr>
				<th scope='row' class='text-right'>Doctor Name : </th>
				<td scope='row' class='text-left'>$app_info->full_name</td>
				</tr>
				<tr>
				<th scope='row' class='text-right'>Patient Name : </th>
				<td scope='row' class='text-left'>$app_info->patient_name</td>
				</tr>
				<tr>
				<th scope='row' class='text-right'>Chief Complain : </th>
				<td scope='row' class='text-left'>$app_info->chif_complain</td>
				</tr>
				<tr>
				<th scope='row' class='text-right'>Appointment Date : </th>
				<td scope='row' class='text-left'>" . date("d-m-Y", strtotime($app_info->appoint_date)) . "</td>
				</tr>
				<tr>
				<th scope='row' class='text-right'>Serial No : </th>
				<td scope='row' class='text-left text-danger'>$app_info->slot_sl</td>
				</tr>

				</tbody>
				</table>";
                $doctor_name = ($app_info->full_name_bangla == "") ? $app_info->full_name : "ডাঃ " . $app_info->full_name_bangla;

                $sms = $this->sendWebAppSms($app_info->appoint_date, $request->phone, $doctor_name, $app_info->slot_sl, $app_info->specialization_bangla, $patient_name, $pat_gender_txt, $pat_age, $phone_mobile, $app_time, $full_name);


                if ($is_pay_consultation == 1) {

                    $module_info = DB::table("sysc_module")->where("module_code", "OPDC")->select("module_no_pk")->first();
                    $in_module = isset($module_info->module_no_pk) ? $module_info->module_no_pk : "0";
                    $counter_su_no = 1099;
                    $second_ref_doc = 0;
                    $appointment_id = $request->visit_type;
                    $appointment_id = $request->reffered_by;
                    $item_id = $request->hdn_item_id;

                    $out_invoice_no = $out_invoice_id = $out_error = "";

                    $consultation = $pdo->prepare("begin pkg_billing.prc_billinvo
                    ice_consult(:in_module_no_fk, :in_counter_su_no_fk, :in_patient_no_fk, :in_patient_code, :in_appoint_no_pk,  :in_appoint_code, :in_first_ref_doc_person_no_fk, :in_second_ref_doc_person_no_fk, :in_pat_type_lookup_no_fk, :in_au_entry_by, :in_au_entry_session, :in_au_entry_hospital_pk_no,:in_item_no_fk, :out_invoice_no, :out_invoice_id,:out_error); end;");

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

                    $consultation->bindParam(':out_invoice_no', $out_invoice_no, PDO::PARAM_INT);
                    $consultation->bindParam(':out_invoice_id', $out_invoice_id, PDO::PARAM_STR, 500);
                    $consultation->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);

                    $consultation->execute();
                    if ($out_error == "000") {
                        DB::commit();
                        //if($patient_email !=""){
                        $appointment_datetime = date("d-m-Y", strtotime($app_info->appoint_date));
                        //$this->appointmentMail($patient_email, $app_info->patient_name, $app_info->full_name, $appointment_datetime);
                        //}
                        $message = ["msg" => $msg, 'title' => 'Success', 'out_sl_no' => $out_sl_no, 'insert_id' => $out_appoint_no];
                        //return response()->json($message);
                    } else {
                        DB::rollback();
                        $message = ['msg' => $out_error, 'title' => 'Error'];
                        //return response()->json($message);
                    }
                } else {
                    DB::commit();
                    $message = ["msg" => $msg, 'title' => 'Success', 'out_sl_no' => $out_sl_no, 'insert_id' => $out_appoint_no];
                }
            } else {
                DB::rollback();
                $message = ["msg" => "Appointment Create Failed $out_error $is_manual_sl", 'title' => 'Error', 'out_sl_no' => ''];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }


        //        email Part

        //        $pdf = PDF::loadview('iCure-Home');
        //        return $pdf->download('Emr-report.pdf');

        $app_info_data = DB::table("patn_appointment_vw")
            ->where("appoint_no_pk", $out_appoint_no)
            ->first();

        $company_profile = Company::orderBy('hospital_no_pk', 'desc')->first();
        $company_name = isset($company_profile->hospital_name_bangla) ? $company_profile->hospital_name_bangla : $company_profile->hospital_name;
        $company_number = isset($company_profile->telephone1) ? $company_profile->telephone1 : '01700000000';

        $app_date = isset($app_info->appoint_date) ? date('d/m/Y', strtotime($app_info->appoint_date)) : date('d/m/Y');
        $doc_specialization = isset($app_info_data->specialization_bangla) ? $app_info_data->specialization_bangla : '';
        $patient_serial = isset($app_info_data->slot_sl) ? $app_info_data->slot_sl : '';
        $dodtor_name_mcare = isset($app_info_data->full_name) ? $app_info_data->full_name : '';

        $patient_email_body = "আসসালামুআলাইকুম, $doc_specialization বিশেষজ্ঞ $dodtor_name_mcare এর $app_date তারিখে $patient_serial নং সিরিয়াল নিশ্চিত করা হয়েছে।  $company_name । প্রয়োজনেঃ $company_number";

        if ($request->email != '') {
            $to_email = $request->email;
            $to_name = $request->patient_first_name;
            $subject = 'Appointment';
            $mail_body = $patient_email_body;
            $doc_mail_body = 'Doctor Email';
            // $this->sendEmailForPatient($to_email, $to_name, $subject, $mail_body, $request->email_personal, $doc_mail_body);
        }

        //        email part end

        return response()->json($message);
    }
}
