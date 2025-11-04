<?php

namespace App\Http\Controllers;

use App\Models\Users as Users;
use App\Library\Template;
use Illuminate\Http\Request;
use DB;
use App\Traits\MailEngine;
use Illuminate\Support\Facades\Auth;
/*use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;*/
use Session;
use Carbon\Carbon;

class HomeController extends Controller
{
    use MailEngine;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

   
    public function index()
    {
        $app_exp_date=DB::table('wsec_hospital')->first()->hospital_exp_date;   
        if($app_exp_date !="" && !empty($app_exp_date) ? date('Y-m-d',strtotime($app_exp_date)) < date('Y-m-d') :''){           
            Auth::logout();
            return redirect()->route('login');
        }  
        /*require __DIR__ . '/../../../vendor/autoload.php';
        $connector = new NetworkPrintConnector("10.10.10.115", 9100);
        //
        $printer = new Printer($connector);
        //dd($printer);
        //
        try {
            $printer -> text("Hello World!\n");
            $printer -> cut();
            $printer -> close();

            echo "test";
        } finally {
            $printer -> close();
        }*/

        $company_details = \App\Models\Company::where("status", 1)->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        if (isset($company_details)) {
        } else {
            $company_details = \App\Models\Company::where("status", 1)->first();
        }
        // dd($company_details);
        $stores = DB::table('sysc_v1_grant_servieceunit_vw')
            ->select('*')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('sub_store_ind', '=', 1)
            ->where('user_no_pk', '=', Auth::user()->user_no_pk)
            ->get();
        $external_refferal_performance_info = [];
        $external_refferal_performance_count = 0;
        // if(Session::get('user.ses_hospital_code') == 'IMPALA'){
        //     $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        //     $appointments = DB::select(DB::raw("select app.full_name,
        //                                             app.gender_txt,
        //                                             app.mobile1,
        //                                             app.patient_dob,
        //                                             app.patient_name,
        //                                             app.patient_no_pk,
        //                                             app.patient_photo,
        //                                             pat.call_ind,
        //                                             pat.email_ind,
        //                                             pat.sms_ind,app.specialization
        //                                         from    dash_patn_app_vw app
        //                                             left join
        //                                                 pat_history_tracking pat
        //                                             on app.patient_no_pk = pat.patient_no_fk  where app.au_entry_hospital_pk_no = $ses_hospital_id"));
        //     //        dd($appointments);
        //     $last_day_appointment = db::select(db::raw("select patient_name,

        //                                                     gender_txt,
        //                                                     patient_dob,
        //                                                     blood_group,
        //                                                     age,
        //                                                     mobile1,
        //                                                     doctor_no_fk,
        //                                                     full_name,
        //                                                     specialization,
        //                                                     patient_photo,
        //                                                     patient_no_pk
        //                                                 from patn_appointment_vw
        //                                                 where appoint_date = trunc (sysdate - 1) and au_entry_hospital_pk_no  = $ses_hospital_id "));
        //     $unattendant_patients = db::select(db::raw("select * from psn_unattent_pat_list where
        //     APPOINT_STATUS = 3 and au_entry_hospital_pk_no  = $ses_hospital_id
        //     and appoint_date between trunc (sysdate - 7) and trunc (sysdate)"));

        //     $unattendant_patients_last = db::select(db::raw("select * from psn_unattent_pat_list
        //     where appoint_date between trunc (sysdate - 14) and trunc (sysdate -7 ) and au_entry_hospital_pk_no  = $ses_hospital_id"));

        //     $follow_up = db::select(db::raw("select * from psn_followup_vw
        //     where trunc (next_followup_dt) between trunc (sysdate) and trunc (sysdate + 7)
        //     order by next_followup_dt asc"));
        //     $last_s_followup = db::select(db::raw("select * from psn_followup_vw  where trunc (next_followup_dt) between trunc (sysdate - 7) and trunc (sysdate) order by next_followup_dt asc"));
        //     $schedules_doctors = db::table('dash_doctor_schdule_vw')->where('au_entry_hospital_pk_no', $ses_hospital_id)->where('schedule_dt', carbon::today())->whereNotNull('person_no_pk')->get();
        //     $all_doctors = db::select("select distinct person_no_pk,full_name from dash_doctor_schdule_vw where au_entry_hospital_pk_no = $ses_hospital_id ");


        //     return Template::loadview("admin.uhl.dashboard", [
        //         'appointments' => $appointments,
        //         'unattendant_patients' => $unattendant_patients,
        //         'schedules_doctors' => $schedules_doctors,
        //         'all_doctors' => $all_doctors,
        //         'last_day_appointment' => $last_day_appointment,
        //         'unattendant_patients_last' => $unattendant_patients_last,
        //         "follow_up" => $follow_up,
        //         "last_s_followup" => $last_s_followup,
        //     ]);
        // }else{
            // dd($external_refferal_performance_count);
            return Template::loadView("admin.dashboards.common-page", [
                'company_details' => $company_details,
                "stores" => $stores,
                "external_refferal_performance_info" => $external_refferal_performance_info,
                "external_refferal_performance_count" => $external_refferal_performance_count
            ]);
        // }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function pat_registration()
    {
        return Template::loadView("admin.patient.registration");
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function registration_list()
    {
        return Template::loadView("admin.patient.registration_list");
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function pat_appointment()
    {
        return Template::loadView("admin.patient.appointment");
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function pat_appointment_list()
    {
        return Template::loadView("admin.patient.appointment_list");
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function pat_appointment_schedule()
    {
        return Template::loadView("admin.patient.appointment_schedule");
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */





    public function opd_billing()
    {
        return Template::loadView("admin.billing.opd_billing");
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function billing_work_list()
    {
        return Template::loadView("admin.billing.billing_list");
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function create_bill()
    {
        return Template::loadView("admin.billing.create_bill");
    }
    public function writeSignature()
    {
        return view("admin.billing.write_signature");
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
}
