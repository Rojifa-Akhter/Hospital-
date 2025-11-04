<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use PDO;
use Session;
use Exception;
use App\Events\TVUpdate;
use App\Library\Template;
use App\Core\TV\TVService;
use App\Traits\LookupData;
use Illuminate\Http\Request;
use App\DoctorScheduleDayOff;
use App\Traits\UtilitiesTrait;
use Illuminate\Support\Facades\Auth;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use App\Traits\MailEngine;
use Carbon\Carbon;
use GuzzleHttp\Client;
class HOSPatientAppointmentController extends Controller
{
    //
    use  LookupData, UtilitiesTrait,MailEngine;
    protected $tv_information;
    public function __construct(TVService $tv_information)
    {
        $this->middleware('auth');
        $this->tv_information = $tv_information;
       
    }
    public function create(Request $request)
    {
      
        $specialization = $this->getLookupListByCode("DOCSPL");
        $hospital = DB::table('wsec_hospital')->where('HOSPITAL_NO_PK', Session::get('user.ses_hospital_no_pk'))->get();
        
        $today_id = date('Y-m-d');
        //This block for showing today all doctor.
        $specialization_lookup_no_fk = '';
        $schedule = [];
        $total_app_count = '';
       
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
              
            $doctor_info = $query
                ->where('d.specialization_lookup_no_fk', $request->specialization_lookup_no_fk)
                ->where('d.status', 1)
                ->where('d.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->select('d.person_no_pk', 'd.full_name', 'd.person_code', 'd.phone_mobile', 'd.specialization', 'p.schedule_no_pk', 'p.schedule_dt')
                ->groupBy('d.person_no_pk', 'd.full_name', 'd.person_code', 'd.phone_mobile', 'd.specialization', 'p.schedule_no_pk', 'p.schedule_dt')
                ->orderByRaw("lower(d.full_name) asc")
                ->get()
                ->toArray();
          

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
            $total_app_count =   $query1->groupBy('appoint_date')->first();
        }
         
       
            return Template::loadView("admin.uhl.appointment.appointment", [
                'specialization' => $specialization,
                'hospital' => $hospital,
                'schedule' => $schedule,
                'total_app_count' => $total_app_count,
                'specialization_lookup_no_fk' => $specialization_lookup_no_fk,
                'today_id' => $today_id,
            ]);
       
    }
    public function getDoctorsListBySpeclDate(Request $request)
    {
        $today_id = $request->today ? $request->today : "";

        $tommorow_id = $request->tomorrow ? date('Y-m-d', strtotime($request->tomorrow . "+1 days")) : "";
        $date = $request->appoint_dt;

        $specialization_id = $request->specialization_id;

        $query = DB::table('doctor_info_vw d')
            ->join('hrms_schedule p', 'p.doctor_person_no_fk', 'd.person_no_pk');
        $query1 = DB::table('patn_app_count_vw d')
            ->select(DB::raw("sum(new_pat) new_pat,sum(app_patient) app_patient,sum(confirmed) confirmed  ,sum(chk) chk ,sum(can) can "));

        if (!empty($specialization_id)) {

            $query->where('d.specialization_lookup_no_fk', $specialization_id);
            $query1->where('d.specialization_lookup_no_fk', $specialization_id);
        }
        if (!empty($date)) {

            $query->where(DB::raw("trunc(p.schedule_dt)"), '=', date('Y-m-d', strtotime($date)));
            $query1->where(DB::raw("trunc(d.appoint_date)"), '=', date('Y-m-d', strtotime($date)));
        }
        if (!empty($tommorow_id)) {
            $query->where(DB::raw("trunc(p.schedule_dt)"), '=', $tommorow_id);
        }
        if (!empty($today_id)) {

            $query->where(DB::raw("trunc(p.schedule_dt)"), '=', date('Y-m-d', strtotime($today_id)));
            $query1->where(DB::raw("trunc(d.appoint_date)"), '=', date('Y-m-d', strtotime($today_id)));
        }
        if (isset($request->doctor_list)) {
            $query->where('d.person_no_pk', $request->doctor_list);
            $query1->where('d.doctor_no_fk', $request->doctor_list);
        }
        $doctor_info = $query
            ->where('d.status', 1)
            ->where('d.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->select('d.person_no_pk', 'd.full_name', 'd.person_code', 'd.phone_mobile', 'd.specialization', 'p.schedule_no_pk', 'p.schedule_dt')
            ->groupBy('d.person_no_pk', 'd.full_name', 'd.person_code', 'd.phone_mobile', 'd.specialization', 'p.schedule_no_pk', 'p.schedule_dt')
            ->orderByRaw("lower(d.full_name) asc")
            ->get()
            ->toArray();
       
        $schedule = [];
        if (!empty($doctor_info)) {
           
            foreach ($doctor_info as $doctor) {
                /**
                 * Check if Doctor has blocked the specific date.
                 * If date not blocked then return the Doctor Schedule,
                 * Otherwise show the block reason
                 */
                $blockedSchedule = DoctorScheduleDayOff::where('schedule_dt', date('Y-m-d', strtotime($today_id)))
                                            ->where('doctor_person_no_fk', $doctor->person_no_pk)
                                            ->get();

                if(count($blockedSchedule) > 0) {
                    $schedule[$doctor->person_no_pk . '_' . $doctor->full_name . '_' . $doctor->schedule_dt] = collect([
                        'block_date'    => date('M d, Y', strtotime($today_id)),
                        'block_reason'  => $blockedSchedule->first()->schedule_reason,
                    ]);
                } else {
                  
                    $schedule[$doctor->person_no_pk . '_' . $doctor->full_name . '_' . $doctor->schedule_dt] =
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
                            // 11838
                        // DB::select("SELECT 
                        //             S.* ,  
                        //             APP.PATIENT_NO_fK as PATIENT_NO_pK,
                        //             app.CANCEL_IND,
                        //             APP.PATIENT_NAME  ,
                        //             reg.PATIENT_CODE  ,
                        //             reg.GENDER_TXT  ,
                        //             reg.dob PATIENT_DOB  ,
                        //             reg.BLOOD_GROUP  ,
                        //             pat_age(reg.dob,APPOINT_DATE)AGE  ,
                        //             reg.MOBILE1  ,
                        //             APP_TYPE.LOOKUPDATA_NAME APPOINT_TYPE_CODE  ,
                        //             visit_type.LOOKUPDATA_CODE visit_type_code  ,
                        //             CCM.CCM_CLIENT_NAME  ,
                        //             (SELECT x.LOOKUPDATA_NAME
                        //             FROM SYSC_LOOKUPDATA x
                        //             WHERE app.CASE_TYPE = x.LOOKUPDATA_NO_PK) CASE_TYPE_NAME  ,
                        //             APP.APPOINT_NO_PK  ,
                        //             WSEC_USER.USER_FULLNAME  ,
                        //             APP.CALLING_NOTE  ,
                        //             APP.CONSULT_IND  ,                                    
                        //             (SELECT COUNT (*)
                        //             FROM PSN_T_PRESCRIPTION pres
                        //             WHERE pres.APPOINT_NO_FK = app.APPOINT_NO_pK
                        //             AND pres.DOCTOR_PERSON_NO_FK = app.DOCTOR_NO_FK)
                        //             pres_ind 
                        //             FROM HRMS_SCHEDULE_SLOT s
                        //             ,patn_appointment app,
                        //             patn_registration reg,
                        //             CCM_CORPORATECLIENT CCM,
                        //             WSEC_USER ,SYSC_LOOKUPDATA APP_TYPE,SYSC_LOOKUPDATA visit_type
                        //             where  S.SLOT_NO_PK   =  APP.SLOT_NO_FK  (+)
                        //             and APP.PATIENT_NO_fK  =reg.PATIENT_NO_PK(+)
                        //             and REG.CCM_CLIENT_NO_FK= CCM.CCM_CLIENT_NO_PK (+) 
                        //             and app.APPOINT_TYPE=APP_TYPE.LOOKUPDATA_NO_PK (+) 
                        //             and app.VISIT_TYPE=visit_type.LOOKUPDATA_NO_PK (+) 
                        //             and  S.BLOCK_BY   = WSEC_USER.USER_NO_PK   (+)  
                        //             -- and nvl(app.CANCEL_IND,0)=0 
                        //             and  S.SCHEDULE_NO_FK = $doctor->schedule_no_pk 
                        //             ORDER BY  S.SLOT_NO_PK   ASC");
                       
                       
                }
            }
        }
        // dd( $schedule);
        $total_app_count =   $query1->groupBy('appoint_date')->first();
        // dd(  $total_app_count);
        return Template::loadView('admin.uhl.appointment.slot_list', [
            'schedule' => $schedule,
            'total_app_count' => $total_app_count,
        ]);
    }
   
    public function appointmentDetails($slot_no_pk = "")
    {
        $hospital = DB::table('wsec_hospital')->where('HOSPITAL_NO_PK', Session::get('user.ses_hospital_no_pk'))->get();
        $gender = $this->getLookupListByCode("GENDER");
        $visit_types = $this->getLookupListByCode("APPVISITTYPE");
        
        if (Session::get('user.ses_hospital_code')=="DMHL") {
            $appointment_types = $this->getLookupListByCode("VISITTYPE");
             $appointment_types = DB::table('SYSC_LOOKUPDATA')->whereIn('LOOKUPDATA_NO_PK',array_keys($appointment_types))->select('LOOKUPDATA_NO_PK', 'LOOKUPDATA_NAME', 'LOOKUPDATA_CODE','CONSULTATION_DAYS')->get();
        }else{
            $appointment_types = $this->getLookupListByCode("VISITTYPE");
        }

        // dd($appointment_types);
        $appointment_case = $this->getLookupListByCode("APPCASETIME");
        $appointment_status = $this->getLookupListByCode("APPSTATUS");
        $scheule_info = DB::table('hrms_schedule_slot')
            ->join('hrms_personnel', 'hrms_personnel.person_no_pk', 'hrms_schedule_slot.doctor_person_no_fk')
            ->select("hrms_schedule_slot.*", "hrms_personnel.person_no_pk", "hrms_personnel.full_name", 'hrms_personnel.specialization_lookup_no_fk','hrms_personnel.serviceunit_no_fk')
            ->where('slot_no_pk', $slot_no_pk)
            ->first();
            
       
        if (Session::get('user.ses_hospital_code')=="DMHL" || Session::get('user.ses_hospital_code')=="AMCSH") {
            $patient_type = DB::table('patn_patienttype')->select('patient_type_no_pk', 'patient_type_code', 'patient_type_desc')->where('status', 1)->where('au_entry_hospital_pk_no', session::get('user.ses_hospital_no_pk'))->get();
            $priority = $this->getLookupListByCode("PRIORITY");
            return Template::loadView("admin.uhl.appointment.appointment_details_v2", [
                'hospital' => $hospital,
                'gender' => $gender,
                'visit_types' => $visit_types,
                'appointment_types' => $appointment_types,
                'appointment_case' => $appointment_case,
                'appointment_status' => $appointment_status,
                'scheule_info' => $scheule_info,
                'patient_type' => $patient_type,
                'priority' => $priority,
            ]);

        }else{
            return Template::loadView("admin.uhl.appointment.appointment_details", [
                'hospital' => $hospital,
                'gender' => $gender,
                'visit_types' => $visit_types,
                'appointment_types' => $appointment_types,
                'appointment_case' => $appointment_case,
                'appointment_status' => $appointment_status,
                'scheule_info' => $scheule_info,
            ]);
        }
    }
    public function chatAppointment()
    {
        $hospital = DB::table('wsec_hospital')->where('HOSPITAL_NO_PK', Session::get('user.ses_hospital_no_pk'))->get();
       
            return Template::loadView("admin.uhl.appointment.chat_appointment", [
                'hospital' => $hospital,               
            ]);
        
    }

    public function chat(Request $request)
    {
        $message = trim($request->message);
         $client = new Client();
         $prompt3= '
                    Patient said: "'.$message.'"
                  Return the "symptom", "doctor_selection", "select_day", "select_time", with  JSON format ONLY from the patient message.
                  formate as like 
                     Example:
                    -  {"step":"symptom"} or {"step":"doctor_selection"} or {"step":"select_day"} or {"step":"select_time"}
                   
                    ';
                // dd($prompt);
                $response3 = $client->post('https://openrouter.ai/api/v1/chat/completions', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . env('OPENAI_API_KEY')
                    ],
                    'json' => [
                        'model' => 'gpt-3.5-turbo',
                        'messages' => [
                            ['role' => 'user', 'content' => $prompt3]
                        ],
                        'temperature' => 0.5,
                    ]
                ]);

                $body3 = json_decode($response3->getBody(), true);
                $text3 = $body3['choices'][0]['message']['content'] ?? '';
                $info3 = json_decode($text3, true);
                $step = $info3['step'] ?? null;
                // $step = $request->step ?? 'symptom';
                // dd($step,$message );
            $session = $request->session();
       
        switch ($step) {
            case 'symptom':
                // 🧠 Step 1: Detect department and doctor suggestion (Bangla + English)
                $prompt = '
                    Patient said: "'.$message.'"
                    Detect patient symptom and suggest a suitable medical department and type of doctor.
                    Respond in strict JSON format ONLY, no extra text, using double quotes:
                    {
                    "department": "",
                    "doctor_type": "",
                    "language": "bn or en"
                    }
                    Example:
                    - If patient says "আমার পেট ব্যথা" → {"department":"Medicine","doctor_type":"Gastroenterologist","language":"bn"}
                    - If patient says "I have fever" → {"department":"Medicine","doctor_type":"General Physician","language":"en"}
                    ';
                // dd($prompt);
                $response = $client->post('https://openrouter.ai/api/v1/chat/completions', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . env('OPENAI_API_KEY')
                    ],
                    'json' => [
                        'model' => 'gpt-3.5-turbo',
                        'messages' => [
                            ['role' => 'user', 'content' => $prompt]
                        ],
                        'temperature' => 0.5,
                    ]
                ]);

                $body = json_decode($response->getBody(), true);
                $text = $body['choices'][0]['message']['content'] ?? '';
                $info = json_decode($text, true);
               
                if (!$info) {
                    return response()->json(['message' => 'Sorry, I could not understand the symptom.']);
                }

                $session->put('department', $info['department']);
                $session->put('language', $info['language']);
                
                $doctors = DB::table('doctor_info_vw')
                ->whereRaw('UPPER(specialization) LIKE ?', ['%' . strtoupper($info['department']) . '%'])
                ->get(['person_no_pk', 'full_name']);

                $reply = $info['language'] === 'bn'
                    ? "আপনার জন্য উপযুক্ত বিভাগ: {$info['department']}. আপনি নিচের ডাক্তারদের একজনকে বেছে নিতে পারেন:"
                    : "Suggested department: {$info['department']}. You may choose one of the following doctors:";

                return response()->json([
                    'step' => 'doctor_selection',
                    'message' => $reply,
                    'doctors' => $doctors
                ]);
                break;

            case 'doctor_selection':
                $prompt4 = 'Extract only the doctor name from this sentence and return as JSON: {"name": ""}. Sentence: "'.$message.'"';

                $response4 = $client->post('https://openrouter.ai/api/v1/chat/completions', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . env('OPENAI_API_KEY')
                    ],
                    'json' => [
                        'model' => 'gpt-3.5-turbo',
                        'messages' => [
                            ['role' => 'user', 'content' => $prompt4]
                        ],
                        'temperature' => 0.3,
                    ]
                ]);

                $body4 = json_decode($response4->getBody(), true);
                $ai = json_decode($body4['choices'][0]['message']['content'] ?? '{}', true);
                $doctorName = $ai['name'] ?? '';
               $doctor = DB::table('doctor_info_vw')
                ->whereRaw("REGEXP_LIKE(UPPER(full_name), ?, 'i')", [strtoupper($doctorName)])
                ->first();
                
                if (!$doctor) return response()->json(['message' => 'Doctor not found.']);

                $session->put('doctor_id', $doctor->person_no_pk);

                $lang = $session->get('language');
                $reply = $lang === 'bn'
                    ? "আপনি কোন দিনে ডাঃ {$doctor->full_name} কে দেখতে চান?"
                    : "Which day would you like to see Dr. {$doctor->full_name}?";

                return response()->json([
                    'step' => 'select_day',
                    'message' => $reply
                ]);
                break;

            case 'select_day':
                $doctorId = $session->get('doctor_id');
                $prompt2= '
                    Patient said: "'.$message.'"
                  Return the date in strict JSON format like:{ "date": "Y-m-d" } with asia/dhaka time zone. if say like today then show current date of bangladesh or say tomorrow then show next date of current date 
                    ';
                // dd($prompt);
                $response2 = $client->post('https://openrouter.ai/api/v1/chat/completions', [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . env('OPENAI_API_KEY')
                    ],
                    'json' => [
                        'model' => 'gpt-3.5-turbo',
                        'messages' => [
                            ['role' => 'user', 'content' => $prompt2]
                        ],
                        'temperature' => 0.5,
                    ]
                ]);

                $body = json_decode($response2->getBody(), true);
                $text = $body['choices'][0]['message']['content'] ?? '';
                $info = json_decode($text, true);
                $day = $info['date'] ?? null;
                // dd($day);
                // $day = strtolower($message);
                $slots = DB::table('hrms_schedule_slot')->where('doctor_person_no_fk', $doctorId)
                    ->where('schedule_dt', $day)
                    ->where('available_ind', 1)
                    ->whereNull('APPOINT_NO_FK')
                    ->get(['slot_no_pk', 'start_time', 'end_time']);

                if ($slots->isEmpty()) {
                    return response()->json(['message' => 'No available slots found for that day.']);
                }

                $session->put('day', $day);
                $lang = $session->get('language');

                $reply = $lang === 'bn'
                    ? "এই দিনটিতে নিচের সময়গুলো খালি আছে, আপনি কোন সময় বুক করতে চান?"
                    : "These are the available slots for that day. Which time would you like to book?";

                return response()->json([
                    'step' => 'select_time',
                    'message' => $reply,
                    'slots' => $slots
                ]);
                break;

            case 'select_time':
                $doctorId = $session->get('doctor_id');
                $day = $session->get('day');
                $lang = $session->get('language');

                $slot = DB::table('hrms_schedule_slot')->where('doctor_person_no_fk', $doctorId)
                    ->where('schedule_dt', $day)
                    ->where('start_time', 'LIKE', "%$message%")
                    ->first();

                if (!$slot) return response()->json(['message' => 'Slot not found.']);

                // $slot->available_ind = 0;
                DB::table('hrms_schedule_slot')
                ->where('slot_no_pk', $slot->slot_no_pk)
                ->update(['available_ind' => 0]);

                $appointDate = Carbon::parse($day); // day already in Y-m-d
                $sequence = DB::getSequence();
                $sequence_no =$sequence->nextValue('patn_appointment_no_pk_seq');
                $appointment = DB::table('patn_appointment')->insert([
                    'appoint_no_pk' => $sequence_no,
                    'patient_no_fk' => Auth::id(),
                    'doctor_no_fk' => $doctorId,
                    'appoint_date' => $appointDate->format('Y-m-d'),
                    'start_time' => $slot->start_time,
                    'appoint_status' => 1,
                    'status' => 1
                ]);

                $getAppInfo=DB::table('patn_appointment')->select('appoint_date','start_time')->first();
                $appDate=date('d M',strtotime($getAppInfo->appoint_date));
                $reply = $lang === 'bn'
                    ? "✅ আপনার অ্যাপয়েন্টমেন্ট সফলভাবে বুক হয়েছে {$appDate} তারিখে, সময় {$getAppInfo->start_time}."
                    : "✅ Your appointment has been successfully booked on {$appDate} at {$getAppInfo->start_time}.";

                return response()->json([
                    'step' => 'done',
                    'message' => $reply
                ]);
                break;
        }
    }
    public function store(Request $request)
    {
        try {

            DB::beginTransaction();

            // try {
            // $appointment_dt = date("Y-m-d", strtotime($appointment_dt->toDateString()));
            $app_date = date("Y-m-d", strtotime($request->app_date));

            //  $patient_dob = date("Y-m-d", strtotime($request->app_date));
            $pat_dob = date("Y-m-d", strtotime($request->dob));

            $marital_status_arr = $this->getLookupListByCode("MARSTS");
            $gender_arr = $this->getLookupListByCode("GENDER");

            $pdo = DB::getPdo();
            $doctor_id = $request->hdn_doctor_id;
            $hdn_schedule_id = $request->hdn_schedule_id;
            $slot_no_pk = $request->slot_no_pk;
            $patient_id = $request->hdn_patient_id;
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
          
            $appoint_source = 'WEB';
            $entry_session = 'UHL APP';
            $hospital_id = Session::get('user.ses_hospital_no_pk'); //$request->hdn_hospital_id;
            $is_pay_consultation = $request->is_pay_consultation;
            $is_manual_sl = isset($request->patient_manual_sl_checkbox) ? 1 : 0;
            $patient_note = $request->appoint_note;
            $app_start_time = $request->start_time;
            $app_end_time = $request->end_time;
            $in_start_time = isset($app_start_time) ? date("Y-m-d h:i:s", strtotime($app_date . " " . $app_start_time)) : null;
            $in_end_time = isset($app_end_time) ? date("Y-m-d h:i:s", strtotime($app_date . " " . $app_end_time)) : null;
            $in_manual_time_ind = (isset($in_start_time) || isset($in_end_time)) ? 1 : 0;
            $in_provider_person_no_fk = $request->in_provider_person_no_fk;
            $in_facility_no_fk = $request->in_facility_no_fk;
            $in_visit_type = $request->in_visit_type;
            $in_case_type = $request->in_case_type;
            $in_free_visit_ind = $request->in_free_visit_ind;
            $in_recurrence_ind = $request->in_recurrence_ind;
            $auth_id = Auth::user()->user_no_pk;
            $temp  = isset($request->appt_status) ? explode('_', $request->appt_status) : '';
            $in_appoint_status = isset($temp[0]) ? $temp[0] : '';
            $in_appoint_status_txt = isset($temp[1]) ? $temp[1] : '';
            $null = '';
            $appointment_type = $request->appt_type;
            $in_reason_for_visit =  $request->reason_visit;
            // dd(DB::table('patn_v1_appointment_vw')->where('slot_no_fk', $slot_no_pk)->where('doctor_no_fk', $in_provider_person_no_fk)->exists());
            if (isset($patient_id)) {
                $check_appointment = DB::table('patn_v1_appointment_vw')
                    ->where('patient_no_pk', $patient_id)
                    ->where('doctor_no_fk', $in_provider_person_no_fk)
                    ->where(DB::raw('trunc(appoint_date)'), $app_date)
                    ->get();

                if (count($check_appointment) > 0) {
                    return response()->json([
                        'responseText' => "This Patient is already booked a slot of this doctor."
                    ], 406);
                }               

               
            }
                if (DB::table('patn_v1_appointment_vw')->where('slot_no_fk', $slot_no_pk)->where('doctor_no_fk', $in_provider_person_no_fk)->where('cancel_ind',0)->exists()) {
                    return response()->json([
                        'responseText' => "This slot is already booked."
                    ], 406);
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
            $stmt->bindParam(':in_doctor_no_fk', $in_provider_person_no_fk);
            $stmt->bindParam(':in_provider_person_no_fk', $in_provider_person_no_fk);
            $stmt->bindParam(':in_schedule_no_fk', $hdn_schedule_id);
            $stmt->bindParam(':in_slot_no_pk', $slot_no_pk);
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
           $homeService=$request->homeService;
           if ($homeService==1 && $out_error !=999) {
            DB::table('patn_appointment')->where('appoint_no_pk',$out_appoint_no)->update(['home_service_ind'=>1]);
           }
           $sms = '';
            if (Session::get('user.sms_send_ind')==1) {
                $sms = $this->sendSms($app_info->appoint_date,$app_info->start_time,$app_info->end_time, $app_info->mobile1, $doctor_name,$doctor_name_english, $app_info->slot_sl, $app_info->specialization_bangla, $app_info->phone_mobile, $app_info->au_entry_at,$update_ind,$homeService);
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
                'msg'       => $message ,
                'insert_id' => $out_appoint_no,
                'sms'       =>$sms
            ];

            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['msg' => $e->getMessage()], 406);
        }
    }


    public function edit($appoint_no_fk)
    {
        $specialization = $this->getLookupListByCode("DOCSPL");
        $hospital = DB::table('wsec_hospital')->where('HOSPITAL_NO_PK', Session::get('user.ses_hospital_no_pk'))->get();
        $appointment_info = DB::table('patn_appointment_vw')->where('appoint_no_pk', $appoint_no_fk)->first();
        $gender = $this->getLookupListByCode("GENDER");
        $visit_types = $this->getLookupListByCode("APPVISITTYPE");
        $appointment_types = $this->getLookupListByCode("APPTYPE");
        $appointment_case = $this->getLookupListByCode("APPCASETIME");
        $appointment_status = $this->getLookupListByCode("APPSTATUS");
        return Template::loadView("admin.uhl.appointment.edit_appointment", [
            'specialization' => $specialization,
            'hospital' => $hospital,
            'appointment_info' => $appointment_info,
            'gender' => $gender,
            'visit_types' => $visit_types,
            'appointment_types' => $appointment_types,
            'appointment_case' => $appointment_case,
            'appointment_status' => $appointment_status,
        ]);
    }


    public function appointmentCard($appoint_no_fk)
    {
        $po_hospital_details =  DB::table('wsec_hospital')->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $pat_card = DB::table('patn_appointment_vw')->where('appoint_no_pk', $appoint_no_fk)->first();
        //    dd($pat_card);
        return Template::loadView("admin.uhl.appointment.appointment_card", [
            'pat_card' => $pat_card,
            'po_hospital_details' => $po_hospital_details,
        ]);
    }

    public function update(Request $request)
    {
        try {

            DB::beginTransaction();


            $app_date = date("Y-m-d", strtotime($request->app_date));

            $patient_dob = date("Y-m-d", strtotime($request->app_date));
            $pat_dob = date("Y-m-d", strtotime($request->dob));

            $marital_status_arr = $this->getLookupListByCode("MARSTS");
            $gender_arr = $this->getLookupListByCode("GENDER");

            $pdo = DB::getPdo();
            $doctor_id = $request->hdn_doctor_id;
            $hdn_schedule_id = $request->hdn_schedule_id;
            $slot_no_pk = $request->slot_no_pk;
            $patient_id = $request->hdn_patient_id;
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

            // $patient_type = $request->patient_type;
            $patient_type = 0; //$request->patienttype;
            $priority = $request->appointment_priority;
            $hdn_first_refer = isset($request->hdn_first_refer) ? $request->hdn_first_refer : "";
            $hdn_second_refer = isset($request->hdn_second_refer) ? $request->hdn_second_refer : "";
            $priority = $request->appointment_priority;
            $address = $request->address;
            $item_name = $request->item_name;
            $in_chief_comp_name = "";
            $service_unit = $request->hdn_service_unit;
            $appoint_source = 'WEB';
            $entry_session = 'UHL APP';
            $hospital_id = Session::get('user.ses_hospital_no_pk'); //$request->hdn_hospital_id;
            $is_pay_consultation = $request->is_pay_consultation;
            $is_manual_sl = isset($request->patient_manual_sl_checkbox) ? 1 : 0;
            $patient_note = $request->appoint_note;
            $app_start_time = $request->start_time;
            $app_end_time = $request->end_time;
            $in_start_time = isset($app_start_time) ? date("Y-m-d h:i:s", strtotime($app_date . " " . $app_start_time)) : null;
            $in_end_time = isset($app_end_time) ? date("Y-m-d h:i:s", strtotime($app_date . " " . $app_end_time)) : null;
            $in_manual_time_ind = (isset($in_start_time) || isset($in_end_time)) ? 1 : 0;
            $in_provider_person_no_fk = $request->in_provider_person_no_fk;
            $in_facility_no_fk = $request->in_facility_no_fk;
            $in_visit_type = $request->in_visit_type;
            $in_case_type = $request->in_case_type;
            $in_free_visit_ind = $request->in_free_visit_ind;
            $in_recurrence_ind = $request->in_recurrence_ind;
            $auth_id = Auth::user()->user_no_pk;
            $temp  = isset($request->appt_status) ? explode('_', $request->appt_status) : '';
            $in_appoint_status = isset($temp[0]) ? $temp[0] : '';
            $in_appoint_status_txt = isset($temp[1]) ? $temp[1] : '';
            $null = '';
            $appointment_type = $request->appt_type;
            $in_reason_for_visit =  $request->reason_visit;
            $in_appoint_no =  $request->hdn_appoint_no;

            // OUT PAREMETER INITIALIZE
            $in_religion =  isset($request->patient_religion) ? $request->patient_religion : '';
            $corporate_id  = isset($request->corporate_name) ? $request->corporate_name : '';
            $corporate_name = '';
            if ($corporate_id != "") {
                $corporate_name = DB::table('ccm_corporateclient_vw')->select('ccm_client_name')->where('ccm_client_no_pk', $corporate_id)->first()->ccm_client_name;
            }

            $out_sl_no = $out_appoint_no = $out_appoint_id = $out_start_time = $out_end_time = $out_patient_no_pk  = $out_error = "";

            $stmt = $pdo->prepare("begin pkg_v1_patmanagement.prc_appointment_edit(
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
                :in_first_referral_no_fk,
                :in_second_referral_no_fk,
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
                :in_appoint_no,
                :out_sl_no,
                :out_appoint_id,
                :out_patient_no_pk,
                :out_start_time,
                :out_end_time,
                :out_error);
                end;"); //,:in_is_manual_sl


            $stmt->bindParam(':in_appoint_date', $app_date);
            $stmt->bindParam(':in_doctor_no_fk', $in_provider_person_no_fk);
            $stmt->bindParam(':in_provider_person_no_fk', $in_provider_person_no_fk);
            $stmt->bindParam(':in_schedule_no_fk', $hdn_schedule_id);
            $stmt->bindParam(':in_slot_no_pk', $slot_no_pk);
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
            $stmt->bindParam(':in_first_referral_no_fk', $hdn_first_refer);
            $stmt->bindParam(':in_second_referral_no_fk', $hdn_second_refer);
            $stmt->bindParam(':in_is_manual_sl', $is_manual_sl);
            $stmt->bindParam(':in_appoint_note', $patient_note);
            $stmt->bindParam(':in_ccm_client_no_fk', $corporate_id);
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
            $stmt->bindParam(':in_appoint_no', $in_appoint_no);
            $stmt->bindParam(':out_sl_no', $out_sl_no, PDO::PARAM_INT);
            $stmt->bindParam(':out_appoint_id', $out_appoint_id, PDO::PARAM_STR, 200);
            $stmt->bindParam(':out_patient_no_pk', $out_patient_no_pk, PDO::PARAM_INT);
            $stmt->bindParam(':out_start_time', $out_start_time, PDO::PARAM_STR, 200);
            $stmt->bindParam(':out_end_time', $out_end_time, PDO::PARAM_STR, 200);
            $stmt->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            $stmt->execute();
            // End






            return [
                'msg' => 'Data Saved Successfully',
                'insert_id' => $in_appoint_no,
            ];
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()], 406);
        }
    }
    public function appointmentForm($appoint_no_fk)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $appoint_info = DB::table('patn_v1_appointment_vw')->where('appoint_no_pk', $appoint_no_fk)->first();
        // dd($admission_pat);
        $title = $appoint_info->appoint_no_pk;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_admission_no = $barcode->generate();

        $title = $appoint_info->patient_code;
        $pat_barcode = new BarcodeGenerator();
        $pat_barcode->setText($title);
        $pat_barcode->setType(BarcodeGenerator::Code128);
        $pat_barcode->setLabel('');
        $pat_barcode->setScale(1);
        $pat_barcode->setThickness(25);
        $pat_barcode->setFontSize(10);
        $barcode_pat_no = $pat_barcode->generate();
        $prepared_by_info  = DB::table('wsec_user')->where('user_no_pk', $appoint_info->au_entry_by)->first();
        $pdf = PDF::loadView("admin.uhl.appointment.appointment_form_print", ['appoint_info' => $appoint_info, 'barcode_admission_no' => $barcode_admission_no, 'po_hospital_details' => $po_hospital_details, 'barcode_pat_no' => $barcode_pat_no, 'prepared_by_info' => $prepared_by_info])->setPaper('a5', 'landscape');
        return $pdf->stream('Ipd Addmission Print.pdf');
    }
    public function appStatusChange(Request $request)
    {
        try {
            $in_appoint_no = $request->appoint_no_pk;
            $out_error = "";
            DB::beginTransaction();
            $pdo = DB::getPdo();

            if ($request->type == "confirm") {
                $stmt = $pdo->prepare("begin pkg_v1_patmanagement.prc_appointment_confirmed(
                    :in_appoint_no,
                    :out_error);
                    end;");
            }

            if ($request->type == "unconfirm") {
                $stmt = $pdo->prepare("begin pkg_v1_patmanagement.prc_appointment_cancle_confirmed(
                    :in_appoint_no,
                    :out_error);
                    end;");
            }
            if ($request->type == "checkin") {
                $stmt = $pdo->prepare("begin pkg_v1_patmanagement.prc_appointment_checkin(
                    :in_appoint_no,
                    :out_error);
                    end;");
            }

            if ($request->type == "cancelchecking") {
                $stmt = $pdo->prepare("begin pkg_v1_patmanagement.prc_appointment_cancle_checkin(
                    :in_appoint_no,
                    :out_error);
                    end;");
            }

            $stmt->bindParam(':in_appoint_no', $in_appoint_no);
            $stmt->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            $stmt->execute();
            DB::commit();
            if ($out_error == '999') {
                return response()->json(['msg' => $out_error], 406);
            } else {
                return response()->json(['msg' => "Status Change Successfully", "title" => 'Success'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['msg' => $out_error], 406);
        }
    }
    public function cancelAppointment($appoint_no_fk)
    {
        $appointment_info = DB::table('patn_v1_appointment_vw')->where('appoint_no_pk', $appoint_no_fk)->first();
        return Template::loadView('admin.uhl.appointment.cancel_appointment', [
            'appointment_info' => $appointment_info
        ]);
    }

    public function updateCancelAppointment(Request $request)
    {
        try {
            $in_appoint_no = $request->hdn_appointment_id;
            $hdn_slot_no_fk = $request->hdn_slot_no_fk;
            $cancel_reason = $request->cancel_reason;
            $auth_id = Auth::user()->user_no_pk;
            $out_error = "";
            DB::beginTransaction();
            $pdo = DB::getPdo();

            $stmt = $pdo->prepare("begin pkg_v1_patmanagement.prc_appointment_cancle(
            :in_appoint_no,
            :in_slot_id,
            :in_cancel_reson,
            :in_cancel_by,
            :out_error);
            end;");

            $stmt->bindParam(':in_appoint_no', $in_appoint_no);
            $stmt->bindParam(':in_slot_id', $hdn_slot_no_fk);
            $stmt->bindParam(':in_cancel_reson', $cancel_reason);
            $stmt->bindParam(':in_cancel_by', $auth_id);
            $stmt->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            $stmt->execute();
            DB::commit();
            if ($out_error != '000') {
                return response()->json(['msg' => $out_error], 406);
            } else {
                return response()->json(['msg' => "Appointment Cancelled Succesfully", "title" => 'Success'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()], 406);
        }
    }
    public function slotBlock($slot_no_fk)
    {
        $type = 1;
        $schedule_info = DB::table('doctor_info_vw d')
            ->join('hrms_schedule_slot p', 'p.doctor_person_no_fk', 'd.person_no_pk')
            ->where('d.status', 1)
            ->where('p.slot_no_pk', $slot_no_fk)
            ->where('d.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->select('d.person_no_pk', 'd.full_name', 'd.person_code', 'd.phone_mobile', 'd.specialization', 'd.specialization_lookup_no_fk', 'p.schedule_no_fk', 'p.schedule_dt', 'p.slot_no_pk')
            ->first();
        return Template::loadView('admin.uhl.appointment.slot_block', [
            'schedule_info' => $schedule_info, 'type' => $type
        ]);
    }
    public function updateSlotBlock(Request $request)
    {
        try {
            $in_doc_id = $request->in_doc_id;
            $slot_no_pk = $request->slot_no_pk;
            $cancel_reason = $request->cancel_reason;
            $auth_id = Auth::user()->user_no_pk;
            $hospital_id = Session::get('user.ses_hospital_no_pk');
            $out_error = "";
            DB::beginTransaction();
            $pdo = DB::getPdo();
            if ($request->type == 1) {
                $stmt = $pdo->prepare("begin pkg_v1_patmanagement.prc_docslot_block(
                    :in_doc_id,
                    :in_slot_id,
                    :in_block_reson,
                    :in_block_by,
                    :in_au_entry_hospital_pk_no,
                    :out_error);
                    end;");

                $stmt->bindParam(':in_doc_id', $in_doc_id);
                $stmt->bindParam(':in_slot_id', $slot_no_pk);
                $stmt->bindParam(':in_block_reson', $cancel_reason);
                $stmt->bindParam(':in_block_by', $auth_id);
                $stmt->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
                $stmt->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
                $stmt->execute();
                DB::commit();
                $message = 'Slot Block Succesfully';
            } else {
                $stmt = $pdo->prepare("begin pkg_v1_patmanagement.prc_docslot_blockrelease(
                    :in_doc_id,
                    :in_slot_id,
                    :in_release_reson,
                    :in_release_by,
                    :in_au_entry_hospital_pk_no,
                    :out_error);
                    end;");

                $stmt->bindParam(':in_doc_id', $in_doc_id);
                $stmt->bindParam(':in_slot_id', $slot_no_pk);
                $stmt->bindParam(':in_release_reson', $cancel_reason);
                $stmt->bindParam(':in_release_by', $auth_id);
                $stmt->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
                $stmt->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
                $stmt->execute();
                DB::commit();
                $message = 'Slot Relese Succesfully';
            }

            if ($out_error == '999') {
                return response()->json(['msg' => 'errpr' . $out_error], 406);
            } else {
                return response()->json(['msg' => $message, "title" => 'Success'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()], 406);
        }
    }
    public function arraySlotBlock(Request $request)
    {
        // dd( $request->slot_no);
        try {
            $in_doc_id = $request->doc_no;
            $slot_no_pk = $request->slot_no_pk;
            $cancel_reason = $request->cancel_reason;
            $auth_id = Auth::user()->user_no_pk;
            $hospital_id = Session::get('user.ses_hospital_no_pk');
            $out_error = "";
            DB::beginTransaction();
            $pdo = DB::getPdo();
            if ($request->type == 1) {
                if (!empty($request->slot_no)) {
                   foreach ($request->slot_no as $key => $value) {
                    $stmt = $pdo->prepare("begin pkg_v1_patmanagement.prc_docslot_block(
                        :in_doc_id,
                        :in_slot_id,
                        :in_block_reson,
                        :in_block_by,
                        :in_au_entry_hospital_pk_no,
                        :out_error);
                        end;");
    
                    $stmt->bindParam(':in_doc_id', $in_doc_id);
                    $stmt->bindParam(':in_slot_id', $value);
                    $stmt->bindParam(':in_block_reson', $cancel_reason);
                    $stmt->bindParam(':in_block_by', $auth_id);
                    $stmt->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
                    $stmt->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
                    $stmt->execute();
                    DB::commit();
                   }
                }
                
                $message = 'Slot Block Succesfully';
            } else {
                if (!empty($request->slot_no)) {
                    foreach ($request->slot_no as $key => $value) {
                        $stmt = $pdo->prepare("begin pkg_v1_patmanagement.prc_docslot_blockrelease(
                            :in_doc_id,
                            :in_slot_id,
                            :in_release_reson,
                            :in_release_by,
                            :in_au_entry_hospital_pk_no,
                            :out_error);
                            end;");

                        $stmt->bindParam(':in_doc_id', $in_doc_id);
                        $stmt->bindParam(':in_slot_id',  $value);
                        $stmt->bindParam(':in_release_reson', $cancel_reason);
                        $stmt->bindParam(':in_release_by', $auth_id);
                        $stmt->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
                        $stmt->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
                        $stmt->execute();
                        DB::commit();
                    }
                }
                $message = 'Slot Relese Succesfully';
            }

            if ($out_error == '999') {
                return response()->json(['msg' => 'errpr' . $out_error], 406);
            } else {
                return response()->json(['msg' => $message, "title" => 'Success'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()], 406);
        }
    }
    public function getAppointmentList(Request $request)
    {

        if ($request->appointment_type == 'APPOINTMENT') {
            // appointment_list
            $query = DB::table('patn_v1_appointment_all_vw')->join('hrms_schedule_slot', 'hrms_schedule_slot.slot_no_pk', 'patn_v1_appointment_all_vw.slot_no_fk')->where('patn_v1_appointment_all_vw.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));
            if (isset($request->specialization_id)) {
                $query->where('patn_v1_appointment_all_vw.specialization_lookup_no_fk', $request->specialization_id);
            }
            if (isset($request->today)) {
                $query->where('patn_v1_appointment_all_vw.appoint_date', date('Y-m-d', strtotime($request->today)));
            }
            $appointment_list =   $query->get();
            return Template::loadView('admin.uhl.appointment.appointment_list', [
                'appointment_list' => $appointment_list,
            ]);
        }

        if ($request->appointment_type == 'CANCEL') {
            // appointment_list
            $query = DB::table('patn_v1_appointment_all_vw')->join('hrms_schedule_slot', 'hrms_schedule_slot.slot_no_pk', 'patn_v1_appointment_all_vw.slot_no_fk')->where('patn_v1_appointment_all_vw.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('patn_v1_appointment_all_vw.cancelled_ind', 1);
            if (isset($request->specialization_id)) {
                $query->where('patn_v1_appointment_all_vw.specialization_lookup_no_fk', $request->specialization_id);
            }
            if (isset($request->today)) {
                $query->where('patn_v1_appointment_all_vw.appoint_date', date('Y-m-d', strtotime($request->today)));
            }
            $appointment_list =   $query->get();
            return Template::loadView('admin.uhl.appointment.cancel_list', [
                'appointment_list' => $appointment_list,
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
            $appointment_list =   $query->get();
            return Template::loadView('admin.uhl.appointment.block_list', [
                'appointment_list' => $appointment_list,
            ]);
        }
    }
    public function callingNote($appoint_no_fk)
    {
        $appointment_info = DB::table('patn_v1_appointment_vw')->where('appoint_no_pk', $appoint_no_fk)->first();
        return Template::loadView('admin.uhl.appointment.calling_notes', [
            'appointment_info' => $appointment_info
        ]);
    }
    public function updatecallingNote(Request $request)
    {
        try {

            $hdn_appointment_id = $request->hdn_appointment_id;
            $calling_notes = $request->calling_notes;
            $auth_id = Auth::user()->user_no_pk;
            $hospital_id = Session::get('user.ses_hospital_no_pk');
            $out_error = "";
            DB::beginTransaction();
            $pdo = DB::getPdo();

            $stmt = $pdo->prepare("begin pkg_v1_patmanagement.prc_appointment_callingnote(
            :in_appoint_no,
            :in_callingtext,
            :in_update_by,
            :out_error);
            end;");

            $stmt->bindParam(':in_appoint_no', $hdn_appointment_id);
            $stmt->bindParam(':in_callingtext', $calling_notes);
            $stmt->bindParam(':in_update_by', $auth_id);
            $stmt->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            $stmt->execute();
            DB::commit();
            if ($out_error == '999') {
                return response()->json(['msg' => 'errpr' . $out_error], 406);
            } else {
                return response()->json(['msg' => "Calling Notes Saved Successfully", "title" => 'Success'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()], 406);
        }
    }

    public function slotBlockRelease($slot_no_fk)
    {
        $type = 2;
        $schedule_info = DB::table('doctor_info_vw d')
            ->join('hrms_schedule_slot p', 'p.doctor_person_no_fk', 'd.person_no_pk')
            ->where('d.status', 1)
            ->where('p.slot_no_pk', $slot_no_fk)
            ->where('d.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->select('d.person_no_pk', 'd.full_name', 'd.person_code', 'd.phone_mobile', 'd.specialization', 'd.specialization_lookup_no_fk', 'p.schedule_no_fk', 'p.schedule_dt', 'p.slot_no_pk')
            ->first();
        return Template::loadView('admin.uhl.appointment.slot_block', [
            'schedule_info' => $schedule_info, 'type' => $type
        ]);
    }
    public function appointmentUpdate($app_id)
    {
        $app_id =  explode('_',$app_id);
        $schedule_info = DB::table('doctor_info_vw d')
            ->join('hrms_schedule_slot p', 'p.doctor_person_no_fk', 'd.person_no_pk')
            ->where('d.status', 1)
            ->where('p.slot_no_pk', $app_id[1])
            ->where('d.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->select('d.person_no_pk', 'd.full_name', 'd.person_code', 'd.phone_mobile', 'd.specialization', 'd.specialization_lookup_no_fk', 'p.schedule_no_fk', 'p.schedule_dt', 'p.slot_no_pk')
            ->first();
        return Template::loadView('admin.uhl.appointment.appointment_update', [
            'app_id' => $app_id[0],'schedule_info' => $schedule_info
        ]);
    }
    public function updatePatId(Request $request)
    {
        try {            
            $app_id = $request->app_id;
            $hdn_patient_id = $request->hdn_patient_id;
            // $pat_id=$uhid !="" ? DB::table('patn_registration')->select('patient_no_pk')->where('patient_no_pk',$uhid)->first()->patient_no_pk :'';
            if ( $hdn_patient_id !='') {
                DB::table('patn_appointment')->where('appoint_no_pk', $app_id)->update(['patient_no_fk'=> $hdn_patient_id]);
                return response()->json(['msg' => "Appointment Update Successfully", "title" => 'Success'], 200);
            }else{
                return response()->json(['msg' => 'Enter Patient Name'], 406);
            }
          
            
        } catch (\Throwable $th) {
            return response()->json(['msg' => 'Not Update'], 406);
        }     
       
    }
    public function addSlot(Request $request){
       try {
            $get_slot_info=DB::table('hrms_schedule_slot')->where('slot_no_pk', $request->slot_no)->first();
           
            if (!empty($get_slot_info)) {
                $schedule_info=DB::table('hrms_schedule')->select('avg_duration')->where('schedule_no_pk' ,$get_slot_info->schedule_no_fk)->first();
                $end_time= $get_slot_info->end_time;
                $new_slot_start_time=date('Y-m-d H:i:s', strtotime($end_time));
                $new_slot_end_time=date('Y-m-d H:i:s', strtotime($end_time . ' +' . $schedule_info->avg_duration . ' minutes'));
                $sequence = DB::getSequence();
                $slot_no_pk_seq = $sequence->nextValue('slot_no_pk_seq');
            
                $data=[
                    'slot_no_pk'=>$slot_no_pk_seq,
                    'schedule_no_fk'=>$get_slot_info->schedule_no_fk,
                    'doctor_person_no_fk'=>$get_slot_info->doctor_person_no_fk,
                    'schedule_dt'=>date('Y-m-d', strtotime($end_time)),
                    'start_time'=> $new_slot_start_time,
                    'end_time'=> $new_slot_end_time,
                    'active_status'=>1,
                    'print_schedule_flag'=>0,
                    'doctor_roomin_flag'=>0,
                    'doctor_roomout_flag'=>0,
                    'status'=>1,
                    'au_entry_by'=>Auth::id(),
                    'au_entry_at'=>date('Y-m-d'),
                    'au_entry_session'=>"add slot from new appointment",
                    'au_entry_hospital_pk_no'=>Session::get('user.ses_hospital_no_pk'),
                    'available_ind'=>1,
                ];
                if ( DB::table('hrms_schedule_slot')->insert($data)) {
                    DB::commit();
                    $message=['meg'=>'Success','start_time'=> $new_slot_start_time,'end_time'=> $new_slot_end_time];
                }else{
                    DB::rollback();
                    $message=['meg'=>'Error','start_time'=> '','end_time'=> ''];
                }        
            }else{
                DB::rollback();
                $message=['meg'=>'Error','start_time'=> '','end_time'=> ''];
            }
        } catch (\Throwable $th) {
            DB::rollback();
            $message=['meg'=>$th,'start_time'=> '','end_time'=> ''];
           }
    return response()->json($message);
    }
}
