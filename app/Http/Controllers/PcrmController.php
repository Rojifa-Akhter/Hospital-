<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository as Repo;
use App\Library\Template;
use Carbon\Carbon;
use PDO;
use App\Traits\DatatablesLoader;
use App\Datatables\DataTableClass;
use App\Models\ReferralPaymentDtls;
use App\Models\ReferralConfigaration;
use App\Models\ServiceUnitWisePolicy;
use App\Models\ServiceUnit;
use App\Models\ItemWisePolicy;
use App\Models\PatHistoryTracking;
use Session;
use App\Models\ItemTypeWisePolicy;
use App\Models\DiscountPolicy;
use App\Models\DiscountDeptPolicy;
use \PDF;
use App\Traits\ItemData;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Sabberworm\CSS\Value\Value;
use App\Models\PatientType;
use App\Models\AutoItemType;
use Exception;

class PcrmController extends Controller
{
    use DatatablesLoader, ItemData;
    protected $model;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ReferralPaymentDtls $referralpaymentdtls, ReferralConfigaration $ReferralConfigaration, ServiceUnitWisePolicy $ServiceUnitWisePolicy, ItemWisePolicy $ItemWisePolicy, ItemTypeWisePolicy $ItemTypeWisePolicy, DiscountPolicy $discountPolicy, PatHistoryTracking $PatHistoryTracking, PatientType $PatientType, AutoItemType $AutoItemType, DiscountDeptPolicy $DiscountDeptPolicy)
    {
        $this->middleware('auth');

        $this->model = new Repo($referralpaymentdtls);
        $this->model_ref = new Repo($ReferralConfigaration);
        $this->model_ser_ref = new Repo($ServiceUnitWisePolicy);
        $this->model_Item_ref = new Repo($ItemWisePolicy);
        $this->model_itemtype_ref = new Repo($ItemTypeWisePolicy);
        $this->model_discount_policy = new Repo($discountPolicy);
        $this->PatHistoryTracking = new Repo($PatHistoryTracking);
        $this->PatientType = new Repo($PatientType);
        $this->AutoItemType = new Repo($AutoItemType);
        $this->DiscountDeptPolicy = new Repo($DiscountDeptPolicy);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function referralPayment()
    {
        return Template::loadview("admin.pcrm.referral_payment");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function pcrmDashboard()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $appointments = DB::select(DB::raw("select app.full_name,
                                                   app.gender_txt,
                                                   app.mobile1,
                                                   app.patient_dob,
                                                   app.patient_name,
                                                   app.patient_no_pk,
                                                   app.patient_photo,
                                                   pat.call_ind,
                                                   pat.email_ind,
                                                   pat.sms_ind,app.specialization
                                              from    dash_patn_app_vw app
                                                   left join
                                                      pat_history_tracking pat
                                                   on app.patient_no_pk = pat.patient_no_fk  where app.au_entry_hospital_pk_no = $ses_hospital_id"));
        //        dd($appointments);
        $last_day_appointment = db::select(db::raw("select patient_name,

                                                          gender_txt,
                                                          patient_dob,
                                                          blood_group,
                                                          age,
                                                          mobile1,
                                                          doctor_no_fk,
                                                          full_name,
                                                          specialization,
                                                          patient_photo,
                                                          patient_no_pk
                                                     from patn_appointment_vw
                                                    where appoint_date = trunc (sysdate - 1) and au_entry_hospital_pk_no  = $ses_hospital_id "));
        $unattendant_patients = db::select(db::raw("select * from psn_unattent_pat_list where
        APPOINT_STATUS = 3 and au_entry_hospital_pk_no  = $ses_hospital_id
        and appoint_date between trunc (sysdate - 7) and trunc (sysdate)"));

        $unattendant_patients_last = db::select(db::raw("select * from psn_unattent_pat_list
         where appoint_date between trunc (sysdate - 14) and trunc (sysdate -7 ) and au_entry_hospital_pk_no  = $ses_hospital_id"));

        $follow_up = db::select(db::raw("select * from psn_followup_vw
        where trunc (next_followup_dt) between trunc (sysdate) and trunc (sysdate + 7)
        order by next_followup_dt asc"));
        $last_s_followup = db::select(db::raw("select * from psn_followup_vw  where trunc (next_followup_dt) between trunc (sysdate - 7) and trunc (sysdate) order by next_followup_dt asc"));
        $schedules_doctors = db::table('dash_doctor_schdule_vw')->where('au_entry_hospital_pk_no', $ses_hospital_id)->where('schedule_dt', carbon::today())->whereNotNull('person_no_pk')->get();
        $all_doctors = db::select("select distinct person_no_pk,full_name from dash_doctor_schdule_vw where au_entry_hospital_pk_no = $ses_hospital_id ");


        return Template::loadview("admin.pcrm.dashboard", [
            'appointments' => $appointments,
            'unattendant_patients' => $unattendant_patients,
            'schedules_doctors' => $schedules_doctors,
            'all_doctors' => $all_doctors,
            'last_day_appointment' => $last_day_appointment,
            'unattendant_patients_last' => $unattendant_patients_last,
            "follow_up" => $follow_up,
            "last_s_followup" => $last_s_followup,
        ]);
    }
    public function dashboardSearchData(Request $request)
    {
        $query = DB::table('Dash_Doctor_Schdule_VW');

        if (!empty($request->doctor_id)) {
            $query->where('person_no_pk', $request->doctor_id);
        }
        if (!empty($request->app_date)) {
            $query->where(DB::raw("trunc(schedule_dt)"), '=', date('Y-m-d', strtotime($request->app_date)));
        }
        //  elseif(!empty($request->type)){
        //      $query->where('referral_agent_ind', $request->type);
        //  }

        return Template::loadview("admin.pcrm.dashboard_doctor_shedule", [
            'schedules_doctors' => $query->get()
                ->toArray(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function pcrmCallPerson(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $user_id = Session::get('user.ses_user_pk_no');
        $id = $request->id;
        $call = $request->call;
        $sms = $request->sms;
        $email = $request->email;
        $auth_id = Auth::id();

        if (!empty($call)) {
            $call_ind = 1;
            $sms_ind = 0;
            $email_ind = 0;
            $sms_text = "N/A";
            $email_text = "N/A";
            $call_text = "আপনাকে কল করা হয়েছে আপনার এপয়মেন্ট ছিল ডক্টর আপনাকে সেবা দিতে প্রস্তুত আপনি কি আবার এপয়মেন্ট নিতে পারেন  ";
        } elseif (!empty($sms)) {
            $call_ind = 0;
            $sms_ind = 1;
            $email_ind = 0;
            $call_text = "N/A";
            $email_text = "N/A";
            $sms_text = "আপনার এপয়মেন্ট ছিল ডক্টর আপনাকে সেবা দিতে প্রস্তুত আপনি কি আবার এপয়মেন্ট নিতে পারেন ";
        } elseif (!empty($email)) {
            $call_ind = 0;
            $sms_ind = 0;
            $email_ind = 1;
            $call_text = "N/A";
            $sms_text = "N/A";
            $email_text = " ইমেইল পাঠানো";
        }


        DB::beginTransaction();
        try {
            $data = [
                'call_ind' => $call_ind,
                'sms_ind' => $sms_ind,
                'email_ind' => $email_ind,
                'email_text' => $email_text,
                'sms_text' => $sms_text,

                'mobile_no' => $request->mobile_num,
                'note_text' => $call_text,
                'patient_no_fk' => $id,
                'status' => 1,
                'traking_date' => date('Y-m-d h:i'),
                'au_entry_hospital_pk_no' => $ses_hospital_id,
                'user_no_fk' => $user_id,
                'au_entry_session' => "Session",
            ];

            $data['au_entry_by'] = $auth_id;
            $this->PatHistoryTracking->create($data);

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function patientAppInfo(Request  $request, $id)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $patient_data = DB::table('pat_history_tracking')
            ->leftJoin('patn_registration', 'patient_no_fk', 'patient_no_pk')
            ->where('patient_no_fk', $id)
            ->get();
        return Template::loadview("admin.pcrm.patient_app_info_data", ['patient_info_data' => $patient_data, 'po_hospital_details' => $po_hospital_details]);
    }


    function mobileappDashboard()
    {
        return Template::loadview("admin.mobile-apps.dashboard");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */





    function referralPaymentProcess(Request $request)
    {
        $auth_id = Auth::id();
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $entry_session     = 'session';

        $date_from = new Carbon($request->date_from);
        $from_dt  = date("Y-M-d", strtotime($date_from->toDateString()));

        $date_to  = new Carbon($request->date_to);
        $to_dt = date("Y-M-d", strtotime($date_to->toDateString()));

        $pdo = DB::getPdo();
        $process_payment = $pdo->prepare("begin pkg_billing.prc_referral_calc(:in_invoice_date_from,:in_invoice_date_to,:in_au_entry_by,:in_au_entry_session,:in_au_entry_hospital_pk_no); end;");

        $process_payment->bindParam(':in_invoice_date_from', $from_dt);
        $process_payment->bindParam(':in_invoice_date_to', $to_dt);
        $process_payment->bindParam(':in_au_entry_by', $auth_id);
        $process_payment->bindParam(':in_au_entry_session', $entry_session);
        $process_payment->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);


        $process_payment->execute();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function referralPaymentList(Request $request)
    {
        $referral_payment_rs = DB::table("pcrm_comission_paymst_vw a")
            ->leftJoin("pcrm_comission_paydtl_vw b", "a.pay_no_pk", "=", "b.pay_no_pk")
            ->get();

        return Template::loadview("admin.pcrm.referral_payment_list", ["referral_payment_rs" => $referral_payment_rs]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function referralPaymentStore(Request $request)
    {
        $id = $request->id;
        $auth_id = Auth::id();



        DB::beginTransaction();
        try {
            $paydtl_ids     = $request->paydtl_id;
            $paid_amount    = $request->paid_amount;
            $is_paid_amount = $request->is_paid_amount;

            for ($i = 0; $i < sizeof($paydtl_ids); $i++) {
                if ($is_paid_amount[$i] == "on") {
                    $data = [
                        'paid_amount'   => $paid_amount[$i],
                        'paid_date'     => date("d-m-Y"),
                        'paid_by'       => $auth_id,
                        'paid_at'       => date("d-m-Y"),
                        'paid_ind'      => 1
                    ];

                    $data['au_update_by'] = $auth_id;
                    $this->model->update($data, $paydtl_ids[$i]);
                    $last_id = $id;
                }
            }

            DB::commit();
            $message = ['msg' => 'Referral Payment Done Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }



    // Referral policy Configaration


    public function RefarralPolicyConfigaration()
    {

        $refdata = [];
        $data = DB::table('sysc_referralpolicy_vw')->orderBy('au_entry_at', 'DESC')->get();
        return Template::loadview('admin.pcrm.referral.referral_policy', ['data' => $data, 'refdata' => $refdata]);
    }
    public function ipdPhrPaymentProcessSettings()
    {

        $ipd_date = [];
        $data = DB::table('ipd_medicine_inv_set')->orderBy('au_entry_at', 'DESC')->get();
        return Template::loadview('admin.pcrm.referral.ipd_phr_payment_process_settings', ['data' => $data, 'refdata' => $ipd_date]);
    }
    public function ipdPhrPaymentProcessSettingsStore(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        $type_name = $request->payment_type;
        $type = '';
        $name = '';
        if ($type_name != "") {
            $type_name_exp = explode('_', $type_name);
            $type = $type_name_exp[0];
            $name = $type_name_exp[1];
        }
        $auth_id = Auth::id();
        DB::beginTransaction();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        try {
            $data = [
                'ipd_setting_type' => $type,
                'IPD_SETTING_NAME' =>  $name,
                'status' => $request->active,
                'au_entry_by'   =>  $auth_id,
                'au_entry_hospital_pk_no'   =>  $ses_hospital_id,
                'au_entry_session' => 'session',

            ];
            // dd($data);

            if ($id == "") {
                $sequence = DB::getSequence();
                $ipd_medicine_inv_set_no_pk_seq = $sequence->nextValue('ipd_medicine_inv_set_no_pk_seq');
                $data['ipd_medicine_inv_set_no_pk'] = $ipd_medicine_inv_set_no_pk_seq;
                DB::table('IPD_MEDICINE_INV_SET')->insert($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                DB::table('ipd_medicine_inv_set')->where('ipd_medicine_inv_set_no_pk', $id)->update($data);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        // dd($data);
        return response()->json($message);
    }
    public function refDoctorStore(Request $request)
    {
        $id = $request->hdn_ref;
        $auth_id = Auth::id();
        DB::beginTransaction();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        try {
            $data = [
                'referralpolicy_code' => $request->code,
                'referralpolicy_name' => $request->referralpolicy_name,
                'applied_to_agent_ind' => $request->agent_ref,
                'applied_to_ref_doctor_ind' => $request->def_ref,
                'applied_to_seconnd_ref_ind' => $request->def_2nd_ref,
                'default_ref_percnet' => $request->doc_ref,
                'default_agent_percnet' => $request->def_agent,
                'default_2nd_ref_percent' => $request->second_referral,
                'status' => $request->active,
                'au_entry_by'   =>  $auth_id,
                'au_entry_hospital_pk_no'   =>  $ses_hospital_id,
                'au_entry_session' => 'session',
                'au_entry_hospital_pk_no' =>  $ses_hospital_id,
            ];
            // dd($data);

            if ($id == "") {

                $data['au_entry_by'] = $auth_id;
                $this->model_ref->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->model_ref->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        // dd($data);
        return response()->json($message);
    }
    public function deleteReflist(Request $request)
    {
        DB::table('sysc_referralpolicy')->where('referralpolicy_no_pk', $request->ref_id)->delete();
    }

    public function RefPolicyEdit($id)
    {
        $refdata = DB::table('sysc_referralpolicy')->where('referralpolicy_no_pk', $id)->first();
        return Template::loadview("admin.pcrm.referral.referral_policy_popup", ['refdata' => $refdata]);
    }

    public function disPolicyEdit($id)
    {
        $data = $this->model_discount_policy->show($id);
        // dd($data);
        return Template::loadview("admin.pcrm.discount.discount_policy_popup", ['data' =>  $data]);
    }

    public function policyView($id)
    {
        $refdata = DB::table('sysc_referralpolicy')->where('referralpolicy_no_pk', $id)->first();
        return Template::loadview("admin.pcrm.referral.ref_policy_view", ['refdata' => $refdata]);
    }


    public function itemTypePolicy($id)
    {
        $refdata = DB::table('sysc_referralpolicy')->where('referralpolicy_no_pk', $id)->first();

        $ref_policy = DB::table('sysc_referralpolicy_itemtype_vw')->where('referralpolicy_no_fk', $id)->orderBy('au_entry_at', 'DESC')->get();

        return Template::loadview('admin.pcrm.referral.item_type_policy', ['ref_policy' => $ref_policy, 'refdata' => $refdata]);
    }



    public function refItemType(Request $request)
    {
        $id = $request->item_type_no_pk;
        // dd( $request->ref_policy_pk);
        // dd($id);
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        try {
            $data = [
                'default_referral_percnet' => $request->def_ref,
                'default_agent_percnet' => $request->def_agent,
                'default_2nd_referral_percent' => $request->sec_ref,
                'commission_percent' => $request->comission,
                'referralpolicy_no_fk' => $request->ref_policy_pk,
                'item_type' => $request->item_type,
                'au_entry_hospital_pk_no'   => $ses_hospital_id,
                'au_entry_session' => 'session',
            ];

            if ($id == "") {

                $data['au_entry_by'] = $auth_id;
                $this->model_itemtype_ref->create($data);
            } else {
                $data['au_update_by'] = $auth_id;
                $this->model_itemtype_ref->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function itemWisePolicyEdit($id, Request $request)
    {
       
        $ItemWiseEditdata = DB::table('sysc_referralpolicy_itemtype_vw')->where('REFPOLICY_ITEMTYPE_NO_PK', $id)->first();
        $ref_policy = DB::table('sysc_referralpolicy_itemtype_vw')->where('referralpolicy_no_fk', $id)->orderBy('au_entry_at', 'DESC')->get();
        $refdata = DB::table('sysc_referralpolicy')->where('referralpolicy_no_pk', $ItemWiseEditdata->referralpolicy_no_fk)->first();
        return Template::loadview("admin.pcrm.referral.item_type_policy", ['ItemWiseEditdata' => $ItemWiseEditdata, 'refdata' => $refdata, 'ref_policy' => $ref_policy]);
    }
    public function itemWiseDisPolicyEdit($id, Request $request)
    {
        $ItemWiseEditdata =[];// DB::table('sysc_referralpolicy_itemtype_vw')->where('REFPOLICY_ITEMTYPE_NO_PK', $id)->first();
        $ref_policy = [];
        $discount_policy = DB::table('sysc_discountpolicy_itemtype')->where('discountpolicy_no_fk', $id)->orderBy('au_entry_at', 'DESC')->get();
        $refdata =[];// DB::table('sysc_referralpolicy')->where('referralpolicy_no_pk', $ItemWiseEditdata->referralpolicy_no_fk)->first();
        return Template::loadview("admin.pcrm.referral.item_type_policy", ['ItemWiseEditdata' => $ItemWiseEditdata, 'refdata' => $refdata, 'ref_policy' => $ref_policy,'discount_policy'=>$discount_policy,'edit_type'=>"DISCOUNTPOLICY"]);
    }



    // department POlicy
    public function departmentWisePolicy($id)
    {
        $refdata = DB::table('sysc_referralpolicy')->where('referralpolicy_no_pk', $id)->first();
        // dd($refdata);
        $service_unit = DB::table('sysc_serviceunit')->where('status', 1)->get();
        $dep_policy = DB::table('sysc_referralpolicy_su_vw')->where('referralpolicy_no_fk', $id)->orderBy('au_entry_at', 'DESC')->get();

        return Template::loadview('admin.pcrm.referral.department_type_wise_policy', ['refdata' => $refdata, 'dep_policy' => $dep_policy, 'service_unit' => $service_unit]);
    }
    public function refUnitType(Request $request)
    {
        $id = $request->ref_su_policy_pk;
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        try {
            $data = [
                'default_referral_percnet' => $request->def_ref,
                'default_agent_percnet' => $request->def_agent,
                'default_2nd_referral_percent' => $request->sec_ref,
                'commission_percent' => $request->comission,
                'referralpolicy_no_fk' => $request->ref_policy_pk,
                // 'referralpolicy_su_no_pk' => $request->ref_su_policy_pk,
                'su_no_fk' => $request->su_type,
                'au_entry_hospital_pk_no'   =>  $ses_hospital_id,
                'au_entry_session' => 'session',
                // 'au_entry_at' => date('Y-m-d'),
            ];
            // dd($data);

            if ($id == "") {

                $data['au_entry_by'] = $auth_id;
                $this->model_ser_ref->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->model_ser_ref->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function DeptWisePolicyEdit($id, Request $request)
    {
        $DeptWiseEditdata = DB::table('SYSC_REFERRALPOLICY_SU_VW')->where('REFERRALPOLICY_SU_NO_PK', $id)->first();

        $refdata = DB::table('sysc_referralpolicy')->where('referralpolicy_no_pk', $DeptWiseEditdata->referralpolicy_no_fk)->first();
        $dep_policy = DB::table('sysc_referralpolicy_su_vw')->where('referralpolicy_no_fk', $DeptWiseEditdata->referralpolicy_no_fk)->orderBy('au_entry_at', 'DESC')->get();
        $service_unit = DB::table('sysc_serviceunit')->where('status', 1)->get();

        return Template::loadview("admin.pcrm.referral.department_type_wise_policy", ['DeptWiseEditdata' => $DeptWiseEditdata, 'service_unit' => $service_unit, 'refdata' => $refdata, 'dep_policy' => $dep_policy]);
    }


    // item wise Policy
    public function itemWisePolicy($id)
    {
        $refdata = DB::table('sysc_referralpolicy')->where('referralpolicy_no_pk', $id)->first();

        $item_policy_data = DB::table('sysc_referralpolicy_item_vw')->where('referralpolicy_no_fk', $id)->orderBy('au_entry_at', 'DESC')->get();
        // dd($item_policy);
        return Template::loadview('admin.pcrm.referral.item_policy', ['refdata' => $refdata, 'item_policy_data' => $item_policy_data]);
    }
    public function itemWiseDataStore(Request $request)
    {
        // dd($request->all());
        $id = $request->ref_policy_fk;
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        // dd($id);
        try {
            $data = [
                'default_referral_percnet' => $request->def_ref,
                'default_agent_percnet' => $request->def_agent,
                'default_2nd_referral_percent' => $request->sec_ref,
                'commission_percent' => $request->comission,
                'referralpolicy_no_fk' => $request->ref_policy_pk,
                'item_no_fk' => $request->item_number,
                'commission_taka' => $request->comission_tk,
                'exclude_ind' => $request->exclude,
                'status' => $request->active,
                'no_other_item_apply_vn_lvl' => $request->apply_invoice,
                'no_other_item_apply_an_lvl' => $request->apply_admission,

                'au_entry_hospital_pk_no'   =>  $ses_hospital_id,
                'au_entry_session' => 'session',
                // 'au_entry_at' => date('Y-m-d'),
            ];
            // dd($data);

            if ($id == "") {

                $data['au_entry_by'] = $auth_id;
                $this->model_Item_ref->create($data);
            } else {
                // dd( $data);
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->model_Item_ref->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }


    public function itemWisePolicyEditData($id)
    {
        $item_policy = DB::table('sysc_referralpolicy_item_vw')->where('referralpolicy_item_no_pk', $id)->first();
        $refdata = DB::table('sysc_referralpolicy')->where('referralpolicy_no_pk', $item_policy->referralpolicy_no_fk)->first();
        $item_policy_data = DB::table('sysc_referralpolicy_item item')
            ->select('item.*', 'service.item_name', 'service.sales_price')
            ->join('sysc_serviceitem service', 'item.item_no_fk', 'service.item_no_pk')
            ->where('item.referralpolicy_no_fk', $item_policy->referralpolicy_no_fk)
            ->orderBy('item.au_entry_at', 'DESC')
            ->get();
        //  dd($item_policy_data);
        return Template::loadview('admin.pcrm.referral.item_policy', [
            'refdata' => $refdata,
            'item_policy' => $item_policy,
            'item_policy_data' => $item_policy_data
        ]);
    }

    public function printReferralPolicy(Request $request, $id)
    {
        $data = DB::table('sysc_referralpolicy_vw r')
            ->select(
                'r.au_entry_at',
                'r.referralpolicy_code',
                'r.applied_to_agent_ind',
                'r.applied_to_ref_doctor_ind',
                'r.applied_to_seconnd_ref_ind',
                'r.default_2nd_referral_percent as r_sec_ref',
                'r.default_agent_percnet as r_agent_ref',
                'r.default_ref_percnet as r_def_ref',
                'r.policy_name',
                'item.commission_percent as item_percent',
                'item.default_2nd_referral_percent as item_def_2nd_ref',
                'item.item_type',
                'item.default_agent_percnet as item_def_agent',
                'item.default_referral_percnet as item_def_ref',
                'su.default_2nd_referral_percent as su_def_2nd',
                'su.default_agent_percnet as su_def_agent',
                'su.default_referral_percnet as su_def_ref',
                // 'su.serviceunit_name',
                'su.commission_percent as su_comission',
                'it.commission_percent',
                'it.commission_taka',
                'it.default_2nd_referral_percent as it_sec_ref',
                'it.default_agent_percnet as it_def_agent',
                'it.default_referral_percnet as it_def_ref',
                'it.exclude_ind',
                'it.item_no_fk',
                'it.item_name',
                'it.sales_price'
            )
            ->leftJoin('sysc_referralpolicy_su_vw su', 'r.referralpolicy_no_pk', 'su.referralpolicy_no_fk')
            ->leftJoin('sysc_referralpolicy_item_vw it', 'r.referralpolicy_no_pk', 'it.referralpolicy_no_fk')
            ->leftJoin('sysc_referralpolicy_itemtype_vw item', 'r.referralpolicy_no_pk', 'item.referralpolicy_no_fk')
            ->where('r.referralpolicy_no_pk', $id)
            ->first();


        // $data = DB::table("select * from sysc_referralpolicy_vw r
        //     left join sysc_referralpolicy_su_vw su
        //     on r.referralpolicy_no_pk = su.referralpolicy_no_fk
        //     left join sysc_referralpolicy_item_vw it
        //     on r.referralpolicy_no_pk = it.referralpolicy_no_fk
        //     left join sysc_referralpolicy_itemtype_vw item
        //     on r.referralpolicy_no_pk = item.referralpolicy_no_fk
        //     where referralpolicy_no_pk = $id");
        //  dd($data);
        $title = "Referral Policy Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        // dd($data);

        $pdf = PDF::loadView("admin.pcrm.referral.referral_policy_print_data", ['barcode_no' => $barcode_no, 'data' => $data]);
        return $pdf->download('daily_attendance_report_print.pdf');
    }



    protected function referalPolicyAutocomplete(Request $request)
    {
        return $this->getpolicyListAutoComplete($request->search_data);
    }

    protected function discountPolicyAutocomplete(Request $request)
    {
        return $this->getDiscountListAutoComplete($request->search_data);
    }

    public function referralPaymentv2()
    {
        // $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        if ( Session::get('user.ses_hospital_code')!="KBMH") {
           
            $query = [];
            // DB::table('pcrm_referral_invoicelist_vw')
            // ->select("invoice_no_pk", "invoice_date", "patient_code", "customer_name", "invoice_code", "process_done_ind", "full_name", "first_ref_doc_name", "second_ref_doc_name", 'ref_applicable','admission_no_pk', DB::raw('SUM(net_sales - (net_discount + net_collection)) AS due'))
            // ->whereDate('invoice_datetime', '=', date('Y/m/d'))
            // ->where("process_done_ind", null)
            // // ->where("ref_first_payable_ind", 1)
            // ->orderBy('invoice_no_pk', 'desc')
            // ->groupBy("invoice_no_pk", "invoice_date", "patient_code", "customer_name", "invoice_code", "process_done_ind", "full_name", "first_ref_doc_name", "second_ref_doc_name", 'ref_applicable','admission_no_pk')
            // ->get();
        } else {
            $query = DB::table('pcrm_referral_invoicelist_vw')
                ->select("invoice_no_pk", "invoice_date", "patient_code", "customer_name", "invoice_code", "process_done_ind", "full_name", "first_ref_doc_name", "second_ref_doc_name", 'ref_applicable', 'admission_no_pk', DB::raw('SUM(net_sales - (net_discount + net_collection)) AS due'))
                ->whereDate('invoice_datetime', '=', date('Y/m/d'))
                ->where("process_done_ind", null)
                ->where("ref_first_payable_ind", 1)
                ->orderBy('invoice_no_pk', 'desc')
                ->groupBy("invoice_no_pk", "invoice_date", "patient_code", "customer_name", "invoice_code", "process_done_ind", "full_name", "first_ref_doc_name", "second_ref_doc_name", 'ref_applicable', 'admission_no_pk')
                ->get();
        }


        // dd($query);
      
        $item_name = [];
        // if ($query) {
        //     foreach ($query as  $value) {
        //         $item_name[$value->invoice_no_pk] = DB::table('pcrm_referral_invoicelist_vw')->select("item_name", "invoice_no_pk", "item_rate", "ledgerdtl_amt_sales", "ledgerdtl_amt_payment", "ledgerdtl_amt_discount")->where("invoice_no_pk", $value->invoice_no_pk)->get();
        //     }
        // }


        //   dd($item_name);
        return Template::loadview('admin.pcrm.referral_v2.referral_payment', [
            'data' => $query,
            'item_name' => $item_name


            // ->where("process_done_ind", null)
            // ->where("paid_ind", null)
            // ->orderBy('invoice_no_pk', 'desc')
            // ->get()
            // ->toArray()
        ]);
    }

    public function searchReferralPolicy(Request $request)
    {

        $ref_doctor = $request->doctor_id;
        $agent = $request->ref_agent;
        $sec_ref = $request->second_ref;
        $item_type = $request->item_id;
        $patient_code = $request->hdn_patient_id;
        $admission = $request->hdn_admission_id;
        $voucher_no = $request->voucher;
        $not_processed = $request->not_processed;
        $skipped = $request->skipped;
        $all = $request->all;
        if (Session::get('user.ses_hospital_code') == 'JKMH' || Session::get('user.ses_hospital_code') == 'AMCSH') {
            $query = DB::table('pcrm_referral_invlist_tm_vw')->select("invoice_no_pk", "invoice_date", "patient_code", "customer_name", "invoice_code", "process_done_ind", "full_name", "first_ref_doc_name", "second_ref_doc_name", 'ref_applicable', 'admission_no_pk', DB::raw('SUM(net_sales - (net_discount + net_collection)) AS due'));
            
        } else {
            $query = DB::table('pcrm_referral_invoicelist_vw')->select("invoice_no_pk", "invoice_date", "patient_code", "customer_name", "invoice_code", "process_done_ind", "full_name", "first_ref_doc_name", "second_ref_doc_name", 'ref_applicable', 'admission_no_pk', DB::raw('SUM(net_sales - (net_discount + net_collection)) AS due'))
                ->where("ref_first_payable_ind", 1);
        }
      
        //dd($query->where('admission_no_pk', $admission)->groupBy("invoice_no_pk", "invoice_date", "patient_code", "customer_name", "invoice_code", "process_done_ind", "full_name", "first_ref_doc_name", "second_ref_doc_name", 'ref_applicable', 'admission_no_pk')->get());
        if (!empty($voucher_no)) {
            $query->where('invoice_no_pk', $voucher_no);
        }
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $query->whereDate('invoice_datetime', '>=', date('Y/m/d', strtotime($request->search_date_from)));
            $query->whereDate('invoice_datetime', '<=', date('Y/m/d', strtotime($request->search_date_to)));
        } elseif (!empty($request->search_date_from)) {
            $query->whereDate('invoice_datetime', '=', date('Y/m/d', strtotime($request->search_date_from)));
        } elseif (!empty($request->search_date_to)) {
            $query->whereDate('invoice_datetime', '=', date('Y/m/d', strtotime($request->search_date_to)));
        }
        if ($ref_doctor != "") {
            $query->where('person_no_fk', $ref_doctor);
        }
        if (!empty($agent)) {
            $query->where('first_ref_doc_person_no_fk', $agent);
        }
        if (!empty($sec_ref)) {
            $query->where('second_ref_doc_person_no_fk', $sec_ref);
        }
        if (!empty($item_type)) {
            $query->where('item_name', $item_type);
        }
        if (!empty($patient_code)) {
            $query->where('patient_no_fk', $patient_code);
        }
        if (!empty($admission)) {
            $query->where('admission_no_pk', $admission);
        }

        // if(!empty($not_processed)){
        //     $query->where('referal_ind', $not_processed);
        // }if(!empty($skipped)){
        //     $query->where('referal_ind', $skipped);
        // }if(!empty($all)){
        //     $query->where('referal_ind', $all);
        // }
        // dd($query->get());
        
        $invoice = $query
            ->where("process_done_ind", null)
            ->orderBy('invoice_no_pk', 'desc')
            ->groupBy("invoice_no_pk", "invoice_date", "patient_code", "customer_name", "invoice_code", "process_done_ind", "full_name", "first_ref_doc_name", "second_ref_doc_name", 'ref_applicable', 'admission_no_pk')
            ->get();
          
         
           
        $item_name = [];
        if ($invoice) {
            foreach ($invoice as  $value) {
                $item_name[$value->invoice_no_pk] = DB::table('pcrm_referral_invoicelist_vw')->select("item_name", "invoice_no_pk", "item_rate", "ledgerdtl_amt_sales", "ledgerdtl_amt_payment", "ledgerdtl_amt_discount")->where("invoice_no_pk", $value->invoice_no_pk)->get();
            }
        }
        return Template::loadview("admin.pcrm.referral_v2.referral_payment_search_data", [
            'data' => $invoice,
            'item_name' => $item_name

            // ->where("process_done_ind", null)
            // ->where("paid_ind", null)
            // ->orderBy('invoice_no_pk', 'desc')
            // ->get()
            // ->toArray()
        ]);
    }

    public function referralPolicyProcess(Request $request)
    {
        //  dd($request->is_paid_amount);
        $invoice_no_pk =  $request->is_paid_amount;

        $auth_id = Auth::id();
        $hospital = Session::get('user.ses_hospital_no_pk');
        $numelems = 200;
        $date = date('Y-m-d');
        $session = "Session";
        DB::beginTransaction();
        try {
            $invoice_arr = [];
            $outParam = $out_invoice_id = $out_invoice_no = '';
            $pdo = DB::getPdo();
            for ($i = 0; $i < count($invoice_no_pk); $i++) {
                $invoice_arr[$i] =   $invoice_no_pk[$i];
            }
            $itemExpiry = $pdo->prepare("begin pkg_refferal_policy.prc_referral_calculation(:in_invoice_no_pk,:in_au_entry_by,:in_au_entry_at,:in_au_entry_session,:in_au_entry_hospital_pk_no,:out_error); end;");

            $itemExpiry->bindArray(':in_invoice_no_pk', $invoice_arr, count($invoice_arr), $numelems, SQLT_INT); // will be adjust later
            $itemExpiry->bindParam(':in_au_entry_by', $auth_id);
            $itemExpiry->bindParam(':in_au_entry_at', $date);
            $itemExpiry->bindParam(':in_au_entry_session', $session);
            $itemExpiry->bindParam(':in_au_entry_hospital_pk_no', $hospital);
            $itemExpiry->bindParam(':out_error', $outParam, PDO::PARAM_STR, 500);

            $itemExpiry->execute();

            $exp = str_replace('^', ',', $outParam);
            // dd($outParam);
            if ($outParam == '000') {
                DB::commit();

                $message = ['msg' => 'Referral Payment Process completed successfully.', 'title' => 'Success'];
            } else {

                DB::rollback();
                $message = ['msg' => 'Referral Payment Process Failed' . $outParam, 'title' => 'Error'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        // dd( $message);
        return response()->json($message);
    }

    public function monthlyProcessPolicy(Request $request)
    {
        //  dd($request->is_paid_amount);
        $invoice_no_pk =  $request->is_paid_amount;

        $auth_id = Auth::id();
        $hospital = Session::get('user.ses_hospital_no_pk');
        $numelems = 200;
        $date = date('Y-m-d');
        $session = "Session";
        DB::beginTransaction();
        try {
            $invoice_arr = [];
            $outParam = $out_invoice_id = $out_invoice_no = '';
            $pdo = DB::getPdo();

            $in_from_date = date('Y-m-d', strtotime($request->search_date_from));
            $in_to_date = date('Y-m-d', strtotime($request->search_date_to));
            $itemExpiry = $pdo->prepare("begin pkg_refferal_policy.prc_referral_monthly(
            :in_from_date,
            :in_to_date,
            :in_au_entry_by,
            :in_au_entry_at,
            :in_au_entry_session,
            :in_au_entry_hospital_pk_no,
            :out_error);
            end;");

            $itemExpiry->bindParam(':in_from_date', $in_from_date); // will be adjust later
            $itemExpiry->bindParam(':in_to_date', $in_to_date); // will be adjust later
            $itemExpiry->bindParam(':in_au_entry_by', $auth_id);
            $itemExpiry->bindParam(':in_au_entry_at', $date);
            $itemExpiry->bindParam(':in_au_entry_session', $session);
            $itemExpiry->bindParam(':in_au_entry_hospital_pk_no', $hospital);
            $itemExpiry->bindParam(':out_error', $outParam, PDO::PARAM_STR, 500);

            $itemExpiry->execute();


            // dd($outParam);
            if ($outParam == '') {
                DB::commit();

                $message = ['msg' => 'Referral Payment Process completed successfully.', 'title' => 'Success'];
            } else {

                DB::rollback();
                $message = ['msg' => 'Referral Payment Process Failed' . $outParam, 'title' => 'Error'];
            }
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        // dd( $message);
        return response()->json($message);
    }


    public function processedList(Request $request)
    {
        $query = DB::table('sysc_referral_payment_vw')
            ->where("process_done_ind", 1)
            ->where(DB::raw("trunc(process_date)"), "=", date('Y-m-d'))->get()->toArray();

        $payment = DB::table('sysc_referral_payment_ipd')->select("admission_no_fk", "collection_amount", "refpaymentipd_no_pk", "pay_voucher_print_cnt", "head_name", "sales_amount", "paid_amount", "discount_amount")->where('ADMISSION_NO_FK', $request->hdn_admission_id)->get();


        return Template::loadview('admin.pcrm.referral_v2.processed_list', ['data' => $query, 'payment' => $payment]);
    }

    public function refferalPaymentEdit($invoice_id, $type)
    {
        $invoice_item_list = DB::table('sysc_referral_payment')
            ->join('sysc_serviceitem', 'sysc_referral_payment.item_no_fk', 'sysc_serviceitem.item_no_pk') //ITEM_NAME
            ->select('sysc_referral_payment.*', 'sysc_serviceitem.item_name')
            ->where('INVOICE_NO_FK', $invoice_id)->get();
        //    dd( $invoice_item_list);
        return Template::loadview('admin.pcrm.referral_v2.ref_payment_edit', ['type' => $type, 'invoice_item_list' => $invoice_item_list, 'invoice_id' => $invoice_id]);
    }

    public function refferalPaymentUpdate(Request $request)
    {

        try {
            for ($i = 0; $i < count($request->payment_id); $i++) {
                if ($request->type == 1)
                    DB::table('sysc_referral_payment')
                        ->where('refinvoice_no_pk', $request->payment_id[$i])
                        ->update(
                            ['referral_amount_doc' => $request->item_payment_arr[$i]]
                        );
                if ($request->type == 2)
                    DB::table('sysc_referral_payment')
                        ->where('refinvoice_no_pk', $request->payment_id[$i])
                        ->update(
                            ['referral_amount_first' => $request->item_payment_arr[$i]]
                        );
                if ($request->type == 3)
                    DB::table('sysc_referral_payment')
                        ->where('refinvoice_no_pk', $request->payment_id[$i])
                        ->update(
                            ['referral_amount_second' => $request->item_payment_arr[$i]]
                        );
            }
            DB::commit();
            $message = ['msg' => 'Data saved successfully', 'title' => 'Success'];
        } catch (Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }


    public function refferalPaymentUpdateAdm(Request $request)
    {


        try {
            for ($i = 0; $i < count($request->payment_id); $i++) {
                if ($request->type == 1)
                    DB::table('sysc_referral_payment')
                        ->where('refinvoice_no_pk', $request->payment_id[$i])
                        ->update(
                            ['referral_amount_doc' => $request->item_payment_arr[$i]]
                        );
                if ($request->type == 2)
                    DB::table('sysc_referral_payment')
                        ->where('refinvoice_no_pk', $request->payment_id[$i])
                        ->update(
                            ['referral_amount_first' => $request->item_payment_arr[$i]]
                        );
                if ($request->type == 3)
                    DB::table('sysc_referral_payment')
                        ->where('refinvoice_no_pk', $request->payment_id[$i])
                        ->update(
                            ['referral_amount_second' => $request->item_payment_arr[$i]]
                        );
            }
            DB::commit();
            $message = ['msg' => 'Data saved successfully', 'title' => 'Success'];
        } catch (Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function referralDetaislReport()
    {
        $service_unit = DB::table('sysc_serviceunit')->where('status', 1)->get();
        // dd($service_unit);
        $card_no = "";
        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.referral_details_report", ['service_unit' => $service_unit, 'card_no' => $card_no]);
    }
    public function referralDetaislReportSearch(Request $request)
    {
        $card_no = $request->card_hidn;
        // dd($card_no);
        // if ($request->service_unit != "") {
        //     $su_exp = explode('_', $request->service_unit);
        //     $service_unit_no = $su_exp[0];
        // }

        $referral_arr = [];
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";
        $referral_detail_data = DB::table('sysc_referral_payment_vw');
        if ($from_date != "" && $to_date != "") {
            $referral_detail_data->where(DB::raw("trunc(refinvoice_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $referral_detail_data->where(DB::raw("trunc(refinvoice_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
            $referral_arr = $referral_detail_data->where('paid_ind', 1)->orderBy('refinvoice_date', 'desc')->get();
        } elseif ($from_date != "") {
            $referral_detail_data->where(DB::raw("trunc(refinvoice_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))));
            $referral_arr = $referral_detail_data->where('paid_ind', 1)->orderBy('refinvoice_date', 'desc')->get();
        }

        // if ($request->service_unit) {
        //     $referral_detail_data->where('su_no_fk', '=', $service_unit_no);
        // }
        // $referral_detail_data_arr = $referral_detail_data;
        if ($card_no != null) {
            $referral_detail_data->where(function ($query) use ($card_no) {
                $query->where('doc_person_no_fk', $card_no)
                    ->orWhere('first_ref_doc_person_no_fk', $card_no)
                    ->orWhere('second_ref_doc_person_no_fk', $card_no);
            });
            $referral_arr = $referral_detail_data->where('paid_ind', 1)->orderBy('refinvoice_date', 'desc')->get();
        }

        // $referral_detail_data_arr = $referral_detail_data
        // ->where(function ($query) use ($card_no) {
        //     $query->where('person_no_fk', $card_no)
        //         ->orWhere('first_ref_doc_person_no_fk', $card_no)
        //         ->orWhere('second_ref_doc_person_no_fk', $card_no);
        // })
        //$referral_detail_data->orderBy('serviceunit_name', 'asc')->orderBy('invoice_date', 'asc');

        // foreach ($referral_detail_data->get() as $key => $value) {
        //     $referral_arr[$value->serviceunit_name][] = $value;
        // }
        //dd( $referral_arr);

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.referral_details_report_list", ['referral_arr' => $referral_arr, 'card_no' => $card_no]);
    }

    public function referralDetaislReportPdf(Request $request)
    {

        // $card_no = $request->card_hidn;
        // $service_unit_name = '';
        // if ($request->service_unit != "") {
        //     $su_exp = explode('_', $request->service_unit);
        //     $service_unit_no = $su_exp[0];
        //     $service_unit_name = $su_exp[1];
        // }
        $card_no = $request->card_hidn;
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $ref_info = DB::table('employee_info_vw')->where('person_no_pk', $card_no)->first();
        // dd($card_no);
        // if ($request->service_unit != "") {
        //     $su_exp = explode('_', $request->service_unit);
        //     $service_unit_no = $su_exp[0];
        // }

        $referral_arr = [];
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";
        $referral_detail_data = DB::table('sysc_referral_payment_vw');
        if ($from_date != "" && $to_date != "") {
            $referral_detail_data->where(DB::raw("trunc(refinvoice_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $referral_detail_data->where(DB::raw("trunc(refinvoice_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
            $referral_arr = $referral_detail_data->where('paid_ind', 1)->orderBy('refinvoice_date', 'desc')->get();
        } elseif ($from_date != "") {
            $referral_detail_data->where(DB::raw("trunc(refinvoice_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))));
            $referral_arr = $referral_detail_data->where('paid_ind', 1)->orderBy('refinvoice_date', 'desc')->get();
        }

        // if ($request->service_unit) {
        //     $referral_detail_data->where('su_no_fk', '=', $service_unit_no);
        // }
        // $referral_detail_data_arr = $referral_detail_data;
        if ($card_no != null) {
            $referral_detail_data->where(function ($query) use ($card_no) {
                $query->where('doc_person_no_fk', $card_no)
                    ->orWhere('first_ref_doc_person_no_fk', $card_no)
                    ->orWhere('second_ref_doc_person_no_fk', $card_no);
            });
            $referral_arr = $referral_detail_data->where('paid_ind', 1)->orderBy('refinvoice_date', 'desc')->get();
        }

        // $referral_detail_data_arr = $referral_detail_data->where(function ($query) use ($card_no) {
        //     $query->where('first_ref_doc_person_no_fk', $card_no)
        //         ->orWhere('second_ref_doc_person_no_fk', $card_no)
        //         ->orWhere('person_no_fk', $card_no);
        // });
        // foreach ($referral_detail_data_arr->orderBy('serviceunit_name', 'asc')->orderBy('invoice_date', 'asc')->get() as $key => $value) {
        //     $referral_arr[$value->serviceunit_name][] = $value;
        // }
        // // }

        // $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        //     $barcode = new BarcodeGenerator();
        //    // $barcode->setText($title);
        //     $barcode->setType(BarcodeGenerator::Code128);
        //     $barcode->setLabel('');
        //     $barcode->setScale(1);
        //     $barcode->setThickness(25);
        //     $barcode->setFontSize(10);
        // $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.referral_details_report_pdf", ['referral_arr' => $referral_arr, 'from_date' => $from_date, 'to_date' => $to_date, 'card_no' => $card_no, 'ref_info' => $ref_info, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');
        return $pdf->download('referral_details_report_pdf.pdf');
    }
    public function referralSummarylReport()
    {


        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.referral_summary_report");
    }
    public function referralSummaryReportSearch(Request $request)
    {
        $card_no = $request->card_hidn;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";

        $referral_detail_data = DB::table('pcrm_referral_sum_vw')->select(DB::raw('SUM(ledger_amt_sales) as ledger_amt_sales'), DB::raw('SUM(ledger_amt_payment) as ledger_amt_payment'), DB::raw('SUM(ledger_amt_discount) as ledger_amt_discount'), DB::raw('SUM(referral_amount_doc) as referral_amount_doc'), DB::raw('SUM(referral_amount_first) as referral_amount_first'), DB::raw('SUM(referral_amount_second) as referral_amount_second'), DB::raw('count(invoice_no_pk) as count_inv'), 'person_code', 'doc_full_name', 'ref_first_person_code', 'first_ref_doc_name', 'ref_scn_person_code', 'second_ref_doc_name', 'person_no_fk', 'first_ref_doc_person_no_fk', 'second_ref_doc_person_no_fk');

        if ($from_date != "" && $to_date != "") {
            $referral_detail_data->where(DB::raw("trunc(invoice_datetime)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $referral_detail_data->where(DB::raw("trunc(invoice_datetime)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
        } elseif ($from_date != "") {
            $referral_detail_data->where(DB::raw("trunc(invoice_datetime)"), '=', date('Y/m/d', strtotime(request('date_pic'))));
        }

        $referral_detail_data_arr = $referral_detail_data
            // ->where(function ($query) use ($card_no) {
            //     $query->where('first_ref_doc_person_no_fk', $card_no)
            //         ->orWhere('second_ref_doc_person_no_fk', $card_no)
            //         ->orWhere('person_no_fk', $card_no);
            //})
            ->groupBy('person_code', 'doc_full_name', 'ref_first_person_code', 'first_ref_doc_name', 'ref_scn_person_code', 'second_ref_doc_name', 'person_no_fk', 'first_ref_doc_person_no_fk', 'second_ref_doc_person_no_fk')->get();
        // dd($referral_detail_data_arr);
        $referral_arr = [];
        foreach ($referral_detail_data_arr as $key => $value) {
            $referral_arr[$value->person_no_fk . '_' . $value->first_ref_doc_person_no_fk . '_' . $value->second_ref_doc_person_no_fk][] = $value;
        }

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.referral_summary_report_list", ['referral_arr' => $referral_arr]);
    }

    public function referralSummaryReportPdf(Request $request)
    {

        $card_no = $request->card_hidn;
        // $ref_info = DB::table('employee_info_vw')->where('person_no_pk', $card_no)->first();
        $from_date = $request->date_pic != "" ? date("d/m/Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d/m/Y", strtotime($request->date_pic2)) : "";
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $referral_arr = [];
        if ($from_date != "") {
            $referral_detail_data = DB::table('pcrm_referral_sum_vw')->select(DB::raw('SUM(ledger_amt_sales) as ledger_amt_sales'), DB::raw('SUM(ledger_amt_payment) as ledger_amt_payment'), DB::raw('SUM(ledger_amt_discount) as ledger_amt_discount'), DB::raw('SUM(referral_amount_doc) as referral_amount_doc'), DB::raw('SUM(referral_amount_first) as referral_amount_first'), DB::raw('SUM(referral_amount_second) as referral_amount_second'), DB::raw('count(invoice_no_pk) as count_inv'), 'person_code', 'doc_full_name', 'ref_first_person_code', 'first_ref_doc_name', 'ref_scn_person_code', 'second_ref_doc_name', 'person_no_fk', 'first_ref_doc_person_no_fk', 'second_ref_doc_person_no_fk');

            if ($from_date != "" && $to_date != "") {
                $referral_detail_data->where(DB::raw("trunc(invoice_datetime)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
                $referral_detail_data->where(DB::raw("trunc(invoice_datetime)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
            } elseif ($from_date != "") {
                $referral_detail_data->where(DB::raw("trunc(invoice_datetime)"), '=', date('Y/m/d', strtotime(request('date_pic'))));
            }

            $referral_detail_data_arr = $referral_detail_data
                // ->where(function ($query) use ($card_no) {
                //     $query->where('first_ref_doc_person_no_fk', $card_no)
                //         ->orWhere('second_ref_doc_person_no_fk', $card_no)
                //         ->orWhere('person_no_fk',  $card_no);
                // })
                ->groupBy('person_code', 'doc_full_name', 'ref_first_person_code', 'first_ref_doc_name', 'ref_scn_person_code', 'second_ref_doc_name', 'person_no_fk', 'first_ref_doc_person_no_fk', 'second_ref_doc_person_no_fk')->get();

            foreach ($referral_detail_data_arr as $key => $value) {
                $referral_arr[$value->person_no_fk . '_' . $value->first_ref_doc_person_no_fk . '_' . $value->second_ref_doc_person_no_fk][] = $value;
            }
        }


        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.referral_summary_report_pdf", ['barcode_no' => $barcode_no, 'referral_arr' => $referral_arr,  'from_date' => $from_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');
        return $pdf->download('referral_details_report_pdf.pdf');
    }
    public function searchReferralPayment(Request $request)
    {

        $ref_doctor = $request->doctor_id;
        $agent = $request->ref_agent;
        $sec_ref = $request->second_ref;
        $item_type = $request->item_id;
        $patient_code = $request->hdn_patient_id;
        $voucher_no = $request->hdn_invoice_id;
        $not_processed = $request->process;
        $skipped = $request->skipped;
        $all = $request->all;
        // dd($ref_doctor,$request->search_date_from, $request->search_date_to);
        $query = DB::table('sysc_referral_payment_vw');
        if (!empty($voucher_no)) {
            $query->where('invoice_no_pk', $voucher_no);
        }
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $query->where(DB::raw("trunc(process_date)"), '>=', date('Y/m/d', strtotime($request->search_date_from)));
            $query->where(DB::raw("trunc(process_date)"), '<=', date('Y/m/d', strtotime($request->search_date_to)));
        } elseif (!empty($request->search_date_from)) {
            $query->where(DB::raw("trunc(process_date)"), '=', date('Y/m/d', strtotime($request->search_date_from)));
        } elseif (!empty($request->search_date_to)) {
            $query->where(DB::raw("trunc(process_date)"), '=', date('Y/m/d', strtotime($request->search_date_to)));
        }
        if ($ref_doctor != "") {
            $query->where('doc_person_no_fk', $ref_doctor);
        }
        if ($agent != "") {
            $query->where('first_ref_doc_person_no_fk', $agent);
        }
        if ($sec_ref != "") {
            $query->where('second_ref_doc_person_no_fk', $sec_ref);
        }
        if (!empty($item_type)) {
            $query->where('item_name', $item_type);
        }
        if (!empty($patient_code)) {
            $query->where('patient_no_fk', $patient_code);
        }

        if (!empty($not_processed) && $not_processed == "PAID") {
            $query->where('paid_ind', 1);
        }
        if (!empty($not_processed) && $not_processed == "UNPAID") {
            $query->where('paid_ind', 0);
        }
        if (Session::get('user.ses_hospital_code') != 'JKMH') {
            $query->whereNotNull('first_ref_doc_person_no_fk');
        }

        $payment = DB::table('sysc_referral_payment_ipd')->select("admission_no_fk", "collection_amount", "refpaymentipd_no_pk", "pay_voucher_print_cnt", "head_name", "sales_amount", "paid_amount", "discount_amount")->where('ADMISSION_NO_FK', $request->hdn_admission_id)->get();

        // dd($payment);
        // $payment = DB::select("SELECT admission_no_fk,
        // refpaymentipd_no_pk,
        // pay_voucher_print_cnt,
        // head_name,
        // sales_amount,
        // nvl(paid_amount,0) + nvl(discount_amount,0) paid_amount,
        // DISCOUNT_MINUS_IND,
        // discount_amount,
        // case when nvl(DISCOUNT_MINUS_IND,0) =1 then paid_amount else nvl(paid_amount,0) + nvl(discount_amount,0) end net_commission
        // FROM sysc_referral_payment_ipd
        // where ADMISSION_NO_FK = $request->hdn_admission_id");

        return Template::loadview("admin.pcrm.referral_v2.processed_list_data", [
            'data' => $query
                ->where("process_done_ind", 1)
                ->orderBy('invoice_date', 'desc')
                ->get()
                ->toArray(),
            'payment' => $payment
        ]);
    }
    public function referralPaymentIndUpdate(Request $request)
    {
        $auth_id = Auth::id();
        $hospital = Session::get('user.ses_hospital_no_pk');

        $inv_ref = $request->is_paid_amount;
        $inv_ref_amt = $request->ref_amout;


        for ($i = 0; $i < count($inv_ref); $i++) {

            $invoice_ref =  explode('_',  $inv_ref[$i]);
            // $invoice_ref_amt =  explode('_',  $inv_ref_amt[$i]);
            //     $filter_arr=array_filter($invoice_ref);
            //     $sl=0;
            //     $create_arr=[];
            //    foreach ($filter_arr as $key => $value) {
            //       $create_arr[ $sl] = $value;
            //       $sl++;
            //    }

            $invoice_no_pk[$i] = $invoice_ref[0];
            $doc_no_fk[$i] = $invoice_ref[1];
            $first_ref_no_fk[$i] = $invoice_ref[2];
            $second_ref_no_fk[$i] = $invoice_ref[3];

            $doc_amt[$i] = $invoice_ref[4];
            $first_ref_amt[$i] = $invoice_ref[5];
            $second_ref_amt[$i] = $invoice_ref[6];
            // dd( $invoice_ref);
            $data = array();
            $data['paid_ind'] = 1;
            if ($doc_amt[$i]  != 0) {

                $data['paid_amount'] = $doc_amt[$i];
            } elseif ($first_ref_amt[$i] != 0) {

                $data['paid_amount'] = $first_ref_amt[$i];
            } elseif ($second_ref_amt[$i] != 0) {
                $data['paid_amount'] = $second_ref_amt[$i];
            }

            $data['au_entry_by'] = $auth_id;
            $data['paid_by'] = $auth_id;
            $data['paid_date'] = date('Y-m-d');
            $data['au_entry_at'] = date('Y-m-d');
            $data['au_entry_session'] = 'session';
            $data['au_update_hospital_pk_no'] =  $hospital;

            // $getDataRefNo[$i] = DB::table('sysc_referral_payment')->where('invoice_no_fk', $invoice_no_pk[$i])->get();


            $update[$i] = DB::table('sysc_referral_payment')->where('invoice_no_fk', $invoice_no_pk[$i]);
            if ($doc_no_fk[$i] != "") {
                $ref_con[$i] = $update[$i]->where('doc_person_no_fk', $doc_no_fk[$i]);
            } elseif ($first_ref_no_fk[$i] != "") {
                $ref_con[$i] = $update[$i]->where('first_ref_doc_person_no_fk', $first_ref_no_fk[$i]);
            } elseif ($second_ref_no_fk[$i] != "") {
                $ref_con[$i] = $update[$i]->where('second_ref_doc_person_no_fk', $second_ref_no_fk[$i]);
            }
            //    dd($ref_con[$i]->get());

            $getData =  $ref_con[$i]->update($data);
            // DB::table('sysc_referral_payment')->where('invoice_no_fk', $invoice_no_pk[$i])->where($ref_con[$i])->update($data);
        }

        DB::commit();

        if (!empty($getData)) {
            $message = ['msg' => 'Referral Paid Completed successfully.', 'title' => 'Success'];
        } else {
            DB::rollback();
            $message = ['msg' => 'Referral Paid Failed', 'title' => 'Error'];
        }
        return response()->json($message);






        //
        //
        //        $invoice_no_pk =  $request->is_paid_amount;
        //        for ($i = 0; $i < count($invoice_no_pk); $i++) {
        //
        //            DB::beginTransaction();
        //            try {
        //
        //                $procedureName = "pkg_refferal_policy.prc_referral_calcu lation";
        //                $outError = $out_invoice_id = $out_process_no_pk = '';
        //                $dataBindingArr = [
        //                    'in_invoice_no_pk' => $invoice_no_pk,
        //                    'in_au_entry_by' => 1,
        //                    'in_au_entry_at'   => date('Y-m-d H:i'),
        //                    'in_au_entry_session' => 'session',
        //                    'in_au_entry_hospital_pk_no' => 1,
        //                    'out_error' => [
        //                        'value' => &$outError,
        //                        'type' => PDO::PARAM_STR,
        //                        'length' => 500
        //                    ]
        //                ];
        //
        //                $result = DB::executeProcedure($procedureName, $dataBindingArr);
        //
        //                if ($outError == '000') {
        //                    DB::commit();
        //                    $message = ['msg' => 'Refferral Payment Process completed successfully.', 'title' => 'Success'];
        //                } else {
        //
        //                    DB::rollback();
        //                    $message = ['msg' => 'Refferral Payment Process Failed' . $outError, 'title' => 'Error'];
        //                }
        //            } catch (\Exception $e) {
        //                DB::rollback();
        //                $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        //            }
        //        }
        //
        //        return response()->json($message);
    }
    public function printReferralPayment($id, $print_id)
    {
        // dd($print_id);
        $id_expl = explode('_', $id);


        $invoice = $id_expl[0];
        $doc_no_fk = $id_expl[1];
        $first_ref_no_fk = $id_expl[2];
        $second_ref_no_fk = $id_expl[3];
        $ref_comission = [];
        if ($doc_no_fk != "") {
            $ref_comission = DB::table('sysc_referral_payment_vw')->where("doc_person_no_fk", $doc_no_fk)->where("invoice_no_pk", $invoice)->first()->paid_amount;
        } elseif ($first_ref_no_fk != "") {
            $ref_comission = DB::table('sysc_referral_payment_vw')->where("first_ref_doc_person_no_fk", $first_ref_no_fk)->where("invoice_no_pk", $invoice)->first()->paid_amount;
        } elseif ($second_ref_no_fk != "") {
            $ref_comission = DB::table('sysc_referral_payment_vw')->where("second_ref_doc_person_no_fk", $second_ref_no_fk)->where("invoice_no_pk", $invoice)->first()->paid_amount;
        }
        // dd($ref_comission);

        if ($doc_no_fk != "") {
            $ref_name = DB::table('sysc_referral_payment_vw')->where("doc_person_no_fk", $doc_no_fk)->where("invoice_no_pk", $invoice)->first()->doctor_name;
        } elseif ($first_ref_no_fk != "") {
            $ref_name = DB::table('sysc_referral_payment_vw')->where("first_ref_doc_person_no_fk", $first_ref_no_fk)->where("invoice_no_pk", $invoice)->first()->first_ref_doc_name;
        } elseif ($second_ref_no_fk != "") {
            $ref_name = DB::table('sysc_referral_payment_vw')->where("second_ref_doc_person_no_fk", $second_ref_no_fk)->where("invoice_no_pk", $invoice)->first()->sec_ref_doc_name;
        }

        $ref_data_invoice = DB::table('pcrm_referral_invoicelist_vw')->where('invoice_no_pk', $invoice)->get();
        $ref_data = DB::table('pcrm_referral_invoicelist_vw inv')
            ->select("inv.*", "wsec.user_name", "pay.process_date")
            ->leftJoin("sysc_referral_payment pay", "inv.invoice_no_pk", "pay.invoice_no_fk")
            ->leftjoin("wsec_user wsec", "pay.au_entry_by", "wsec.user_no_pk")
            ->where('inv.invoice_no_pk', $invoice)->first();
        // dd($ref_data);

        $invoice_amount = DB::table('finc_voucherwise_vw')->select("sales as ledger_amt_sales", "discount as ledger_amt_discount", "collection as ledger_amt_payment")->where('invoice_no_pk', $invoice)->first();

        // Print save Start
        $data = [
            'pay_voucher_print_cnt' => $print_id + 1,
        ];
        DB::table('sysc_referral_payment')->where('invoice_no_fk', $invoice)->update($data);
        // Print save end

        $print_dt = $print_id + 1;
        //  dd( $invoice);
        $title = $ref_data->invoice_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $title = $ref_data->patient_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_code = $barcode->generate();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $pdf = PDF::loadView("admin.pcrm.referral_v2.referral_process_list_pdf", ['ref_data' => $ref_data, 'barcode_no' => $barcode_no, 'ref_data_invoice' => $ref_data_invoice, 'patient_code' => $patient_code, "invoice_amount" => $invoice_amount, 'ref_comission' => $ref_comission, 'ref_name' => $ref_name, 'po_hospital_details' => $po_hospital_details, 'print_dt' => $print_dt]);
        return $pdf->stream('Referral-payment.pdf');
    }


    public function printReferralPaymentAdm($id, $print_id)
    {
        // dd($id, $print_id);
        $id_expl = explode('_', $id);
        // dd( $id_expl[2]);

        $invoice = $id_expl[0];
        $doc_no_fk = $id_expl[1];
        $first_ref_no_fk = $id_expl[2];
        $second_ref_no_fk = $id_expl[3];
        $admission_id = $id_expl[4];
        // dd($admission_id);
        $comission = [];
        if ($doc_no_fk != "") {
            $comission = DB::select("select sum(PAID_AMOUNT) paid_comission from sysc_referral_payment_vw
            where ADMISSION_NO_PK = $admission_id");
        } elseif ($first_ref_no_fk != "") {
            $comission = DB::select("select sum(PAID_AMOUNT) from sysc_referral_payment_vw
            where ADMISSION_NO_PK = $admission_id");
        } elseif ($second_ref_no_fk != "") {
            $comission = DB::table('sysc_referral_payment_vw')->where("second_ref_doc_person_no_fk", $second_ref_no_fk)->where("invoice_no_pk", $invoice)->first()->paid_amount;
        }
        $ref_comission = 0;
        // dd($invoice,
        // $doc_no_fk);
        if ($doc_no_fk != "") {
            $ref_name = DB::table('sysc_referral_payment_vw')->where("doc_person_no_fk", $doc_no_fk)->where("invoice_no_pk", $invoice)->first()->doctor_name;
        } elseif ($first_ref_no_fk != "") {
            $ref_name = DB::table('sysc_referral_payment_vw')->select('first_ref_doc_name')->where("first_ref_doc_person_no_fk", $first_ref_no_fk)->where("invoice_no_pk", $invoice)->first();
            // dd($ref_name);

        } elseif ($second_ref_no_fk != "") {
            $ref_name = DB::table('sysc_referral_payment_vw')->where("second_ref_doc_person_no_fk", $second_ref_no_fk)->where("invoice_no_pk", $invoice)->first()->sec_ref_doc_name;
        }

        // $ref_data_invoice = DB::table('pcrm_referral_invoicelist_vw')->where('invoice_no_pk', $invoice)->get();

        // $ref_data_invoice = DB::select("select * from sysc_referral_payment_ipd where admission_no_fk = $admission_id");




        $ref_data_invoice = db::select("select admission_no_fk,
                                    refpaymentipd_no_pk,
                                    pay_voucher_print_cnt,
                                    head_name,
                                    sales_amount,
                                    nvl(paid_amount,0) + nvl(discount_amount,0) paid_amount,
                                    discount_minus_ind,
                                    discount_amount,
                                    COLLECTION_AMOUNT,
                                    case when nvl(discount_minus_ind,0) =1 then paid_amount else nvl(paid_amount,0) + nvl(discount_amount,0) end net_commission
                            from sysc_referral_payment_ipd
                            where admission_no_fk = $admission_id");

        $ref_data = DB::table('pcrm_referral_invoicelist_vw')->where('admission_no_pk', $admission_id)->first();
        //  dd($ref_data);
        $invoice_amount = DB::table('finc_voucherwise_vw')->select("sales as ledger_amt_sales", "discount as ledger_amt_discount", "collection as ledger_amt_payment")->where('invoice_no_pk', $invoice)->first();

        // Print save Start
        $data = [
            'pay_voucher_print_cnt' => $print_id + 1,
        ];
        DB::table('sysc_referral_payment_ipd')->where('admission_no_fk', $admission_id)->update($data);
        // Print save end
        $adjustment_amount = 0;
        $print_dt = $print_id + 1;

        $title = $ref_data->invoice_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $title = $ref_data->patient_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $patient_code = $barcode->generate();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        return view("admin.pcrm.referral_v2.referral_payment_admission", ['ref_data' => $ref_data, 'barcode_no' => $barcode_no, 'ref_data_invoice' => $ref_data_invoice, 'patient_code' => $patient_code, "invoice_amount" => $invoice_amount, 'ref_comission' => $ref_comission, 'ref_name' => $ref_name, 'po_hospital_details' => $po_hospital_details, 'print_dt' => $print_dt, 'adjustment_amount' => $adjustment_amount]);
        $pdf = PDF::loadView("admin.pcrm.referral_v2.referral_payment_admission", ['ref_data' => $ref_data, 'barcode_no' => $barcode_no, 'ref_data_invoice' => $ref_data_invoice, 'patient_code' => $patient_code, "invoice_amount" => $invoice_amount, 'ref_comission' => $ref_comission, 'ref_name' => $ref_name, 'po_hospital_details' => $po_hospital_details, 'print_dt' => $print_dt, 'adjustment_amount' => $adjustment_amount]);
        return $pdf->stream('Referral-payment.pdf');
    }
    //discount policy

    public function discountPolicyConfigation()
    {
        // $data = DB::table('sysc_discountpolicy_vw')->orderBy('au_entry_at', 'DESC')->get();
        $data = DB::table('sysc_discountpolicy')->orderBy('au_entry_at', 'DESC')->get();
        //dd($data);
        return Template::loadview('admin.pcrm.discount.discount_policy_configation', [
            'discountPolicy' => $data,
        ]);
    }
    public function discountPolicyStore(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $auth_id = Auth::id();
        $id = $request->id;

        DB::beginTransaction();
        try {
            $data = [
                'dispolicy_code' => $request->code,
                'discount_name' => $request->discount_name,
                'maximum_percent' => $request->max_percent,
                'maximum_amount' => $request->max_value,
                'req_authorization_ind' => $request->authorization,
                'req_authorization_code_ind' => $request->authorization_id,
                'req_doctor_ind' => $request->not_doctor,
                'req_signed_copy_ind' => $request->signed_copy,
                'req_corporate_email_ind' => $request->corporate_email_id,
                'req_management_sms_ind' => $request->management_sms,
                'req_management_email_ind' => $request->management_email,
                'req_corporate_sms_ind' => $request->corporate_sms,
                'req_staff_id_ind' => $request->staff_id,
                'req_corporate_code_ind' => $request->corporate_code,
                'req_corporate_email_ind' => $request->corporate_email,
                'status' => $request->active,
                'au_entry_hospital_pk_no'   => $ses_hospital_id,
                'au_entry_session' => 'session',

                'applied_consult_ind' => $request->consultation_ind,
                'gen_billing_ind' => $request->general_billing_ind,
                'applied_lab_ind' => $request->pathology_ind,
                'applied_rad_ind' => $request->radiology_ind,
                'applied_ipdbed_ind' => $request->ipd_bed_ind,
                'applied_ot_ind' => $request->ot_ind,
                'item_level_disc_ind' => $request->item_level_ind,

                'applied_consult_percent' => $request->consultation_percent,
                'gen_billing_percent' => $request->general_billing,
                'applied_lab_percent' => $request->pathology,
                'applied_rad_percent' => $request->radiology,
                'applied_ipdbed_percent' => $request->ipd_bed,
                'applied_ot_percent' => $request->ot,
            ];
            //  dd($data);
            if ($id == "") {

                $data['au_entry_by'] = $auth_id;
                $this->model_discount_policy->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->model_discount_policy->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function editDiscountPolicy($id)
    {
        // dd($id);
        $discountPolicy = DiscountPolicy::findOrfail($id);

        return Template::loadview('admin.pcrm.discount.discount_policy_configation', [
            'discountPolicy' => $discountPolicy,
        ]);
    }
    public function discountItemTypeWisePolicy()
    {
        return Template::loadView('admin.pcrm.discount.create_discount_item_type_wise_policy');
    }

    //    Added By Nazmul

    public function referralPaymentBill()
    {
        $requestDepts = DB::table('sysc_serviceunit')
            ->get(['serviceunit_name', 'serviceunit_no_pk']);
        $card_no = "";
        return Template::loadview("admin.pcrm.referral_v2.billPayment.bill_payment_report", ['requestDepts' => $requestDepts, 'card_no' => $card_no]);
    }
    public function referralPaymentBillSearch(Request $request)
    {
        $card_no = $request->card_hidn;
        $dept_id = $request->dept_name;

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from";
            $date_to = "$request->date_to";
        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($dept_id != "") ? " $clause su_no_fk =$dept_id" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($card_no != "") ? " $clause (person_no_fk =$card_no or first_ref_doc_person_no_fk =$card_no or  second_ref_doc_person_no_fk =$card_no)" : "";
        //        $clause = ($sql_cond == "") ? " where" : " or";
        //        $sql_cond .= ($card_no != "") ? " $clause first_ref_doc_person_no_fk =$card_no" : "";
        //        $clause = ($sql_cond == "") ? " where" : " or";
        //        $sql_cond .= ($card_no != "") ? " $clause second_ref_doc_person_no_fk =$card_no" : "";


        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_datetime) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $referral_detail_data = DB::select(DB::raw("select referral_amount,discount_amt_by_hos,discount_amt_by_doc,invoice_no_pk,invoice_date,invoice_datetime,patient_no_fk,patient_code,admission_no_pk,prescription_no_fk,first_ref_doc_person_no_fk,second_ref_doc_person_no_fk,person_no_fk,age,customer_name,age_yy,item_no_fk,item_name,itemtype_no_fk,item_qty,item_rate,item_vat,urgent_fee,service_charge,given_amt,ledgerdtl_amt_sales,ledgerdtl_amt_payment,ledgerdtl_amt_discount,agent,invoice_skip_ind,process_done_ind,full_name,first_ref_doc_name,second_ref_doc_name,SU_NO_FK,SERVICEUNIT_NAME,first_ref_doc_name,full_name,
                                second_ref_doc_name from pcrm_referral_invoicelist_vw $sql_cond ORDER BY invoice_date,serviceunit_name asc"));
        //        dd("select referral_amount,discount_amt_by_hos,discount_amt_by_doc,invoice_no_pk,invoice_date,invoice_datetime,patient_no_fk,patient_code,admission_no_pk,prescription_no_fk,first_ref_doc_person_no_fk,second_ref_doc_person_no_fk,person_no_fk,age,customer_name,age_yy,item_no_fk,item_name,itemtype_no_fk,item_qty,item_rate,item_vat,urgent_fee,service_charge,given_amt,ledgerdtl_amt_sales,ledgerdtl_amt_payment,ledgerdtl_amt_discount,agent,invoice_skip_ind,process_done_ind,full_name,first_ref_doc_name,second_ref_doc_name,SU_NO_FK,SERVICEUNIT_NAME from pcrm_referral_invoicelist_vw $sql_cond");
        // dd($referral_detail_data->get());
        $referral_arr = [];
        foreach ($referral_detail_data as $key => $value) {
            $referral_arr[$value->serviceunit_name][] = $value;
        }

        return Template::loadview("admin.pcrm.referral_v2.billPayment.referral_bill_payment_report_list", ['referral_arr' => $referral_arr, 'card_no' => $card_no]);
    }

    public function referralPaymentBillPdf(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $card_no = $request->card_hidn;
        $dept_id = $request->dept_name;

        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from";
            $date_to = "$request->date_to";
        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " or";
        $sql_cond .= ($dept_id != "") ? " $clause su_no_fk =$dept_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($card_no != "") ? " $clause (person_no_fk =$card_no or first_ref_doc_person_no_fk =$card_no or  second_ref_doc_person_no_fk =$card_no)" : "";

        //        $clause = ($sql_cond == "") ? " where" : " and";
        //        $sql_cond .= ($card_no != "") ? " $clause person_no_fk =$card_no" : "";
        //        $clause = ($sql_cond == "") ? " where" : " or";
        //        $sql_cond .= ($card_no != "") ? " $clause first_ref_doc_person_no_fk =$card_no" : "";
        //        $clause = ($sql_cond == "") ? " where" : " or";
        //        $sql_cond .= ($card_no != "") ? " $clause second_ref_doc_person_no_fk =$card_no" : "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_datetime) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $referral_detail_data = DB::select(DB::raw("select referral_amount,discount_amt_by_hos,discount_amt_by_doc,invoice_no_pk,invoice_date,invoice_datetime,patient_no_fk,patient_code,admission_no_pk,prescription_no_fk,first_ref_doc_person_no_fk,second_ref_doc_person_no_fk,person_no_fk,age,customer_name,age_yy,item_no_fk,item_name,itemtype_no_fk,item_qty,item_rate,item_vat,urgent_fee,service_charge,given_amt,ledgerdtl_amt_sales,ledgerdtl_amt_payment,ledgerdtl_amt_discount,agent,invoice_skip_ind,process_done_ind,full_name,first_ref_doc_name,second_ref_doc_name,SU_NO_FK,SERVICEUNIT_NAME,first_ref_doc_name,full_name,
                                second_ref_doc_name from pcrm_referral_invoicelist_vw $sql_cond ORDER BY invoice_date,serviceunit_name asc"));

        $ref_info = DB::table('employee_info_vw')->where('person_no_pk', $card_no)->first();

        $referral_arr = [];
        foreach ($referral_detail_data as $key => $value) {
            $referral_arr[$value->serviceunit_name][] = $value;
        }

        foreach ($referral_detail_data as $data) {
            $title = $data->invoice_no_pk;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();
        }

        $pdf = PDF::loadView("admin.pcrm.referral_v2.billPayment.referral_bill_payment_report_pdf", ['barcode_no' => $barcode_no, 'referral_arr' => $referral_arr, 'ref_info' => $ref_info, 'po_hospital_details' => $po_hospital_details, 'from_date' => $date_from, 'to_date' => $date_to, 'card_no' => $card_no, 'dept_id' => $dept_id])->setPaper('a4', 'landscape');
        return $pdf->download('Individual_Bill_Payment_Report.pdf');
    }
    public function getDoctorPerformanceSummaryReport()
    {

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_performance_summary_report", [
            'type' => '',
            'requestDepts' => DB::table('sysc_serviceunit_vw')
                ->where('ipd_ind', 1)
                ->get(['serviceunit_name', 'serviceunit_no_pk'])
        ]);
    }
    public function getDailyDoctorPerformanceReport()
    {

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.daily_doctor_performance_report", [
            'type' => '',
            'requestDepts' => DB::table('sysc_serviceunit_vw')
                // ->where('ipd_ind', 1)
                ->get(['serviceunit_name', 'serviceunit_no_pk'])
        ]);
    }
    public function getDailyMisOpdReport()
    {

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.daily_mis_opd_report", [
            'type' => '',
            'requestDepts' => DB::table('sysc_serviceunit_vw')
                // ->where('ipd_ind', 1)
                ->get(['serviceunit_name', 'serviceunit_no_pk'])
        ]);
    }
    public function getDailyMisIpdReport()
    {

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.daily_mis_ipd_report", [
            'type' => '',
            'requestDepts' => DB::table('sysc_serviceunit_vw')
                // ->where('ipd_ind', 1)
                ->get(['serviceunit_name', 'serviceunit_no_pk'])
        ]);
    }

    public function deptWisePatientReport()
    {
        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_performance_summary_report", [
            'type' => 'DEPT',
            'requestDepts' => DB::table('sysc_serviceunit_vw')
                // ->where('ipd_ind', 1)
                ->get(['serviceunit_name', 'serviceunit_no_pk'])
        ]);
    }

    public function getDoctorPerformanceSummaryReportSearch(Request $request)
    {
        $type = $request->type;
        $doctor_code = $request->doctor_hidn;
        $department = $request->department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";

        if ($type != 'DEPT') {
            $selectQuery = DB::table('finc_doc_appoint_sum_date_vw')->select('person_code', 'doctor_name', 'serviceunit_name',DB::raw("SUM(total_appoint) as total_appoint"),DB::raw("SUM(ledger_amt_sales) as ledger_amt_sales"),DB::raw("SUM(ledger_amt_discount) as ledger_amt_discount"),DB::raw("SUM(ledger_amt_payment) as ledger_amt_payment"),DB::raw("SUM(total_appoint_free) as total_appoint_free"),DB::raw("SUM(total_appoint_new) as total_appoint_new"),DB::raw("SUM(total_appoint_followup) as total_appoint_followup"))->wherenotnull('person_no_fk');
            $doctorPerformanceSummary = [];

            if ($from_date != "" && $to_date != "") {

                $selectQuery->where(DB::raw("trunc(invoice_date)"), '>=', date('Y-m-d', strtotime(request('date_pic'))));
                $selectQuery->where(DB::raw("trunc(invoice_date)"), '<=', date('Y-m-d', strtotime(request('date_pic2'))));
                $doctorPerformanceSummary = $selectQuery->groupby('person_code', 'doctor_name', 'serviceunit_name')->orderBy('doctor_name', 'ASC')->get();
            } elseif ($from_date != "") {
                $doctorPerformanceSummary = $selectQuery->where(DB::raw("trunc(invoice_date)"), '=', date('Y-m-d', strtotime(request('date_pic'))))->groupby('person_code', 'doctor_name', 'serviceunit_name')->orderBy('doctor_name', 'ASC')->get();
            }
            if ($doctor_code != null) {
                $doctorPerformanceSummary = $selectQuery
                    ->where('person_no_fk', $doctor_code)
                    // ->orderBy('invoice_date', 'ASC')
                    ->groupby('person_code', 'doctor_name', 'serviceunit_name')->orderBy('doctor_name', 'ASC')->get();
            }
            if ($department != null) {
                $doctorPerformanceSummary = $selectQuery
                    ->where('serviceunit_no_pk', $department)
                    // ->orderBy('invoice_date', 'ASC')
                    ->groupby('person_code', 'doctor_name', 'serviceunit_name')->orderBy('doctor_name', 'ASC')->get();
            }
            // dd(  $doctorPerformanceSummary );
        } else {
            $sql_cond = "";
            $clause = ($sql_cond == "") ? " where" : " and";
            $sql_cond .= ($department != "") ? " $clause serviceunit_no_fk = $department" : "";
            $clause = ($sql_cond == "") ? " where" : " and";
            $sql_cond .= ($from_date != "") ? " $clause invoice_date between TO_DATE('$from_date','DD/MM/YYYY') and TO_DATE('$to_date','DD/MM/YYYY')" : "";

            $doctorPerformanceSummary = DB::select(DB::raw("SELECT SUM (current_item_qty) AS current_item_qty,
                                                        SUM (total_item_amt) AS ledger_amt_sales,
                                                        SUM (disc_amount) AS ledger_amt_discount,
                                                        SUM (ledgerdtl_amt_payment) AS ledger_amt_payment,
                                                        serviceunit_no_fk,
                                                        serviceunit_name,
                                                        TRUNC (INVOICE_DATE) INVOICE_DATE
                                                FROM finc_inv_itemdtl_vw $sql_cond  AND MODULE_CODE = 'OPD'
                                            GROUP BY serviceunit_no_fk, serviceunit_name, TRUNC (INVOICE_DATE)
                                            ORDER BY INVOICE_DATE ASC"));
        }

        // dd(  $doctorPerformanceSummary );
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();


        // dd($doctorPerformanceSummary);
        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_performance_summary_report_list", ['doctorPerformanceSummary' => $doctorPerformanceSummary, 'type' => $type, 'po_hospital_details' => $po_hospital_details]);
    }
    public function getDailyDoctorPerformanceReportSearch(Request $request)
    {
        $type = $request->type;
        $doctor_code = $request->doctor_hidn;
        $department = $request->department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($department != "") ? " $clause serviceunit_no_fk = $department" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_code != "") ? " $clause person_no_pk = $doctor_code" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "") ? " $clause income_date between TO_DATE('$from_date','DD/MM/YYYY') and TO_DATE('$to_date','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .=  "$clause (total_appointment is not null or patient_free is not null or patient_followup_free is not null or patient_new_paid is not null or total_patient_paid is not null or lab_amt !=0)";

        $doctorPerformanceSummary = DB::select(DB::raw("SELECT sum(total_appointment) as total_appointment, sum(patient_free) as patient_free, sum(patient_followup_free) patient_followup_free, sum(patient_new_paid) as patient_new_paid , sum(total_appointment) as total_appointment , sum(pathology_amt_count) as pathology_amt_count, sum(total_admission_no) as total_admission_no,full_name , su_name FROM finc_doctor_income_dt_vw $sql_cond   group by full_name , su_name ORDER BY full_name desc"));


        //  dd(  $doctorPerformanceSummary);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        // dd($doctorPerformanceSummary);
        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.daily_doctor_performance_report_list", ['doctorPerformanceSummary' => $doctorPerformanceSummary, 'type' => $type, 'po_hospital_details' => $po_hospital_details]);
    }
    public function getDailyMisOpdReportSearch(Request $request)
    {
        $type = $request->type;
        $doctor_code = $request->doctor_hidn;
        $department = $request->department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($department != "") ? " $clause serviceunit_no_fk = $department" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_code != "") ? " $clause person_no_pk = $doctor_code" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "") ? " $clause appoint_date between TO_DATE('$from_date','DD/MM/YYYY') and TO_DATE('$to_date','DD/MM/YYYY')" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .=  "$clause (total_appointment is not null or patient_free is not null or patient_followup_free is not null or patient_new_paid is not null or total_patient_paid is not null or lab_amt !=0)";

        $doctorPerformanceSummary = DB::select(DB::raw("SELECT SUM (PATIENT_CNT_TOTAL) AS total_appointment,
        SUM (PATIENT_CNT_FREE_ACA) AS patient_free,
        SUM (PATIENT_CNT_NEWCONS)+SUM (PATIENT_CNT_CORPORATE) AS patient_new_paid,
        SUM (PATIENT_CNT_FOLLOWUP) AS patient_followup_free
   FROM RPT_03_OPD_PAT_COUNT_SU_DT_VW $sql_cond "));
 $doctorPerformanceSummarydept = DB::select(DB::raw("  SELECT SERVICEUNIT_NAME,
 SUM (PATIENT_CNT_TOTAL) AS total_appointment,
 SUM (PATIENT_CNT_FREE_ACA) AS patient_free,
 SUM (PATIENT_CNT_NEWCONS) + SUM (PATIENT_CNT_CORPORATE)
    AS patient_new_paid,
 SUM (PATIENT_CNT_FOLLOWUP) AS patient_followup_free
FROM RPT_03_OPD_PAT_COUNT_SU_DT_VW
$sql_cond
GROUP BY SERVICEUNIT_NAME
ORDER BY 1"));
// dd($doctorPerformanceSummarydept);
   $doctorPerformanceSummaryEmr = DB::select(DB::raw("SELECT SUM (PATIENT_CNT_TOTAL) AS total_appointment,
        SUM (PATIENT_CNT_FREE_ACA) AS patient_free,
        SUM (PATIENT_CNT_NEWCONS)+SUM (PATIENT_CNT_CORPORATE) AS patient_new_paid,
        SUM (PATIENT_CNT_FOLLOWUP) AS patient_followup_free
   FROM RPT_03_OPD_PAT_COUNT_SU_DT_VW $sql_cond and SERVICEUNIT_NAME = 'EMERGENCY'"));

   $emergencyProcedure = DB::select("SELECT SUM (patient_cnt_newcons) patient_cnt_newcons,
   SUM (free_patient) free_patient,
   SUM (patient_followup) patient_followup
FROM finc_emargency_procedure_vw where invoice_date between TO_DATE('$from_date','DD/MM/YYYY') and TO_DATE('$to_date','DD/MM/YYYY')");

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        // dd($doctorPerformanceSummary);
        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.daily_mis_opd_report_list", ['doctorPerformanceSummarydept' => $doctorPerformanceSummarydept,'doctorPerformanceSummary' => $doctorPerformanceSummary,'emergencyProcedure' => $emergencyProcedure,'doctorPerformanceSummaryEmr' => $doctorPerformanceSummaryEmr, 'type' => $type, 'po_hospital_details' => $po_hospital_details]);
    }
    public function getDailyMisIpdReportSearch(Request $request)
    {
        $type = $request->type;
        $doctor_code = $request->doctor_hidn;
        $department = $request->department;
        $from_date = $request->date_pic != "" ? date("Y-m-d", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("Y-m-d", strtotime($request->date_pic2 . ' +1 day')) : "";

        $sql_cond = "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($department != "") ? " $clause serviceunit_no_fk = $department" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($doctor_code != "") ? " $clause person_no_pk = $doctor_code" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "") ? " $clause admission_date between TO_DATE('$from_date','YYYY/MM/DD') and TO_DATE('$to_date','YYYY/MM/DD')" : "";

        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .=  "$clause (total_appointment is not null or patient_free is not null or patient_followup_free is not null or patient_new_paid is not null or total_patient_paid is not null or lab_amt !=0)" ;

        $ipd_data = DB::select(DB::raw("SELECT  dis_ind,ward_no_pk, ward_name , trunc(admission_date) as admission_date,new_ward_no_fk , new_ward_name from ipd_admitted_patlist_vw $sql_cond group by ward_no_pk, ward_name ,dis_ind, admission_date ,new_ward_no_fk ,new_ward_name order by admission_date desc"));

        $ipd_datas = [];

        if (!empty($ipd_data)) {
            foreach ($ipd_data as $key => $value) {
                $ward_no_name = $value->new_ward_no_fk != "" ? $value->new_ward_no_fk . '_' . $value->new_ward_name : $value->ward_no_pk . '_' . $value->ward_name;
                $ipd_datas[$ward_no_name][] = $value;
            }
        }

        $ipd_department_data = DB::select(DB::raw("SELECT  dis_ind,su_no_fk ,new_su_no_fk, old_serivce_unit_name, new_serivce_unit_name, trunc(admission_date) as admission_date from ipd_admitted_patlist_vw $sql_cond group by dis_ind, admission_date ,su_no_fk ,new_su_no_fk, old_serivce_unit_name, new_serivce_unit_name order by admission_date desc"));

        $ipd_department_datas = [];

        if (!empty($ipd_department_data)) {
            foreach ($ipd_department_data as $key => $value) {
                $su_no_name = $value->new_su_no_fk != "" ? $value->new_su_no_fk . '_' . $value->new_serivce_unit_name : $value->su_no_fk . '_' . $value->old_serivce_unit_name;
                $ipd_department_datas[$su_no_name][] = $value;
            }
        }
        $sql_cond_dept = "";
        $clause_dept = ($sql_cond_dept == "") ? " where" : " and";
        $sql_cond_dept .= ($from_date != "") ? " $clause_dept invoice_date between TO_DATE('$from_date','YYYY/MM/DD') and TO_DATE('$to_date','YYYY/MM/DD')" : "";
        $clause_dept = ($sql_cond_dept == "") ? " where" : " and";
        $sql_cond_dept .=  "$clause_dept item_type in ( 'OT','SUR') and module_code = 'IPD'";

        $surgical_data = DB::select(DB::raw("SELECT sum(current_item_qty) as current_item_qty,serviceunit_name ,item_type from finc_invoicedtl_vw $sql_cond_dept group by serviceunit_name, item_type order by serviceunit_name asc"));

        $sql_cond_rad = "";
        $clause_rad = ($sql_cond_rad == "") ? " where" : " and";
        $sql_cond_rad .= ($from_date != "") ? " $clause_rad invoice_date between TO_DATE('$from_date','YYYY/MM/DD') and TO_DATE('$to_date','YYYY/MM/DD')" : "";
        $clause_rad = ($sql_cond_rad == "") ? " where" : " and";
        $sql_cond_rad .=  "$clause_rad item_type ='RAD' and module_code = 'IPD'";

        $radiology_data = DB::select(DB::raw("SELECT sum(current_item_qty) as current_item_qty,serviceunit_name ,item_type from finc_invoicedtl_vw $sql_cond_rad group by serviceunit_name, item_type order by serviceunit_name asc"));


        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.daily_mis_ipd_report_list", ['ipd_datas' => $ipd_datas, 'ipd_department_datas' => $ipd_department_datas, 'type' => $type, 'po_hospital_details' => $po_hospital_details, 'surgical_data' => $surgical_data, 'radiology_data' => $radiology_data]);
    }
    public function getDoctorPerformanceSummaryReportPdf(Request $request)
    {
        $type = $request->type;
        $doctor_code = $request->doctor_hidn;
        $department = $request->department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";

        $selectQuery = DB::table('finc_doc_appoint_sum_date_vw')->select('invoice_date', 'person_code', 'doctor_name', 'serviceunit_name', 'total_appoint', 'ledger_amt_sales', 'ledger_amt_discount', 'ledger_amt_payment', 'total_appoint_free', 'total_appoint_new');
        $doctorPerformanceSummary = [];
        $doctor_name = '';
        if ($type != 'DEPT') {
            $selectQuery = DB::table('finc_doc_appoint_sum_date_vw')->select('person_code', 'doctor_name', 'serviceunit_name',DB::raw("SUM(total_appoint) as total_appoint"),DB::raw("SUM(ledger_amt_sales) as ledger_amt_sales"),DB::raw("SUM(ledger_amt_discount) as ledger_amt_discount"),DB::raw("SUM(ledger_amt_payment) as ledger_amt_payment"),DB::raw("SUM(total_appoint_free) as total_appoint_free"),DB::raw("SUM(total_appoint_new) as total_appoint_new"),DB::raw("SUM(total_appoint_followup) as total_appoint_followup"))->wherenotnull('person_no_fk');
            $doctorPerformanceSummary = [];

            if ($from_date != "" && $to_date != "") {
                $selectQuery->where(DB::raw("trunc(invoice_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
                $selectQuery->where(DB::raw("trunc(invoice_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
                $doctorPerformanceSummary = $selectQuery->groupby('person_code', 'doctor_name', 'serviceunit_name')->orderBy('doctor_name', 'ASC')->get();
            } elseif ($from_date != "") {
                $doctorPerformanceSummary = $selectQuery->where(DB::raw("trunc(invoice_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))))->groupby('person_code', 'doctor_name', 'serviceunit_name')->orderBy('doctor_name', 'ASC')->get();
            }
            if ($doctor_code != null) {
                $doctorPerformanceSummary = $selectQuery
                    ->where('person_no_fk', $doctor_code)
                    // ->orderBy('invoice_date', 'ASC')
                    ->groupby('person_code', 'doctor_name', 'serviceunit_name')->orderBy('doctor_name', 'ASC')->get();
            }
            if ($department != null) {
                $doctorPerformanceSummary = $selectQuery
                    ->where('serviceunit_no_pk', $department)
                    // ->orderBy('invoice_date', 'ASC')
                    ->groupby('person_code', 'doctor_name', 'serviceunit_name')->orderBy('doctor_name', 'ASC')->get();
            }
        } else {
            $sql_cond = "";
            $clause = ($sql_cond == "") ? " where" : " and";
            $sql_cond .= ($department != "") ? " $clause serviceunit_no_fk = $department" : "";
            $clause = ($sql_cond == "") ? " where" : " and";
            $sql_cond .= ($from_date != "") ? " $clause invoice_date between TO_DATE('$from_date','DD/MM/YYYY') and TO_DATE('$to_date','DD/MM/YYYY')" : "";

            $doctorPerformanceSummary = DB::select(DB::raw("SELECT SUM (current_item_qty) AS current_item_qty,
            SUM (total_item_amt) AS ledger_amt_sales,
                            SUM (disc_amount) AS ledger_amt_discount,
                            SUM (ledgerdtl_amt_payment) AS ledger_amt_payment,
                            serviceunit_no_fk,
                            serviceunit_name,
                            TRUNC (INVOICE_DATE) INVOICE_DATE
                    FROM finc_inv_itemdtl_vw $sql_cond  AND MODULE_CODE = 'OPD'
                GROUP BY serviceunit_no_fk, serviceunit_name, TRUNC (INVOICE_DATE)
                ORDER BY INVOICE_DATE ASC"));
        }
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();


        //return $doctorPerformanceSummary->orderBy('appoint_date', 'ASC')->get();
        $title = date('d/m/Y');
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        //return view("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_performance_summary_report_pdf", ['doctorPerformanceSummary' => $doctorPerformanceSummary->orderBy('appoint_date', 'ASC')->get(),'barcode_no' => $barcode_no,  'from_date' => $from_date, 'to_date' => $to_date, 'doctor' => $doctor, 'department' => $department, 'po_hospital_details'=> $po_hospital_details]);

        if ($request->hdn_report_type == 'PDF') {
            $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_performance_summary_report_pdf", ['doctorPerformanceSummary' => $doctorPerformanceSummary, 'barcode_no' => $barcode_no,  'from_date' => $from_date, 'to_date' => $to_date, 'doctor_name' => $doctor_name, 'department' => $department, 'po_hospital_details' => $po_hospital_details, 'type' => $type])->setPaper('a4', 'landscape');
            if ($type != 'DEPT') {
                return $pdf->download('doctor_performance_summary_report.pdf');
            } else {
                return $pdf->download('Dept_wise_Performance_summary_report.pdf');
            }
        }
        if ($request->hdn_report_type == 'EXCEL') {

            // dd('ok');
            $pdf = ['doctorPerformanceSummary' => $doctorPerformanceSummary, 'barcode_no' => $barcode_no,  'from_date' => $from_date, 'to_date' => $to_date, 'doctor_name' => $doctor_name, 'department' => $department, 'po_hospital_details' => $po_hospital_details, 'type' => $type];
            $fileToExport = "doctor_performance_summary_report";
            $html = View("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_performance_summary_report_pdf")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }



    }
    public function getDailyDoctorPerformanceReportPdf(Request $request)
    {

        // dd(5);
        $type = $request->type;
        $doctor_code = $request->doctor_hidn;
        $department = $request->department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($department != "") ? " $clause serviceunit_no_fk = $department" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_code != "") ? " $clause person_no_pk = $doctor_code" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "") ? " $clause income_date between TO_DATE('$from_date','DD/MM/YYYY') and TO_DATE('$to_date','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .=  "$clause (total_appointment is not null or patient_free is not null or patient_followup_free is not null or patient_new_paid is not null or total_patient_paid is not null or lab_amt !=0)";

        $doctorPerformanceSummary = DB::select(DB::raw("SELECT sum(total_appointment) as total_appointment, sum(patient_free) as patient_free, sum(patient_followup_free) patient_followup_free, sum(patient_new_paid) as patient_new_paid , sum(total_appointment) as total_appointment , sum(pathology_amt_count) as pathology_amt_count, sum(total_admission_no) as total_admission_no,full_name , su_name FROM finc_doctor_income_dt_vw $sql_cond   group by full_name , su_name ORDER BY full_name desc"));



        // dd(  $doctorPerformanceSummary );
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        // dd($doctorPerformanceSummary);



        $title = date('d/m/Y');
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        //return view("admin.pcrm.referral_v2.IndividualReferralDetails.doctor_performance_summary_report_pdf", ['doctorPerformanceSummary' => $doctorPerformanceSummary->orderBy('appoint_date', 'ASC')->get(),'barcode_no' => $barcode_no,  'from_date' => $from_date, 'to_date' => $to_date, 'doctor' => $doctor, 'department' => $department, 'po_hospital_details'=> $po_hospital_details]);
        $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.daily_doctor_performance_report_pdf", ['doctorPerformanceSummary' => $doctorPerformanceSummary, 'barcode_no' => $barcode_no,  'from_date' => $from_date, 'to_date' => $to_date,  'department' => $department, 'po_hospital_details' => $po_hospital_details, 'type' => $type])->setPaper('a4', 'portrait');

        return $pdf->stream('daly_performance_consultant.pdf');
    }
    public function getDailyMisOpdReportPdf(Request $request)
    {

        // dd(5);
        $type = $request->type;
        $doctor_code = $request->doctor_hidn;
        $department = $request->department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($department != "") ? " $clause serviceunit_no_fk = $department" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($doctor_code != "") ? " $clause person_no_pk = $doctor_code" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "") ? " $clause appoint_date between TO_DATE('$from_date','DD/MM/YYYY') and TO_DATE('$to_date','DD/MM/YYYY')" : "";

        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .=  "$clause (total_appointment is not null or patient_free is not null or patient_followup_free is not null or patient_new_paid is not null or total_patient_paid is not null or lab_amt !=0)";

        $doctorPerformanceSummary = DB::select(DB::raw("SELECT SUM (PATIENT_CNT_TOTAL) AS total_appointment,
        SUM (PATIENT_CNT_FREE_ACA) AS patient_free,
        SUM (PATIENT_CNT_NEWCONS)+SUM (PATIENT_CNT_CORPORATE) AS patient_new_paid,
        SUM (PATIENT_CNT_FOLLOWUP) AS patient_followup_free
   FROM RPT_03_OPD_PAT_COUNT_SU_DT_VW $sql_cond "));

   $doctorPerformanceSummaryEmr = DB::select(DB::raw("SELECT SUM (PATIENT_CNT_TOTAL) AS total_appointment,
        SUM (PATIENT_CNT_FREE_ACA) AS patient_free,
        SUM (PATIENT_CNT_NEWCONS)+SUM (PATIENT_CNT_CORPORATE) AS patient_new_paid,
        SUM (PATIENT_CNT_FOLLOWUP) AS patient_followup_free
   FROM RPT_03_OPD_PAT_COUNT_SU_DT_VW $sql_cond and serviceunit_name = 'EMERGENCY'"));



   $doctorPerformanceSummarydept = DB::select(DB::raw("  SELECT SERVICEUNIT_NAME,
   SUM (PATIENT_CNT_TOTAL) AS total_appointment,
   SUM (PATIENT_CNT_FREE_ACA) AS patient_free,
   SUM (PATIENT_CNT_NEWCONS) + SUM (PATIENT_CNT_CORPORATE)
      AS patient_new_paid,
   SUM (PATIENT_CNT_FOLLOWUP) AS patient_followup_free
FROM RPT_03_OPD_PAT_COUNT_SU_DT_VW
$sql_cond
GROUP BY SERVICEUNIT_NAME
ORDER BY 1"));

$emergencyProcedure = DB::select("SELECT SUM (patient_cnt_newcons) patient_cnt_newcons,
SUM (free_patient) free_patient,
SUM (patient_followup) patient_followup
FROM finc_emargency_procedure_vw where invoice_date between TO_DATE('$from_date','DD/MM/YYYY') and TO_DATE('$to_date','DD/MM/YYYY')");

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $title = date('d/m/Y');
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.daily_mis_opd_report_pdf", ['doctorPerformanceSummary' => $doctorPerformanceSummary,'doctorPerformanceSummarydept' => $doctorPerformanceSummarydept,'emergencyProcedure' => $emergencyProcedure,'doctorPerformanceSummaryEmr' => $doctorPerformanceSummaryEmr, 'barcode_no' => $barcode_no,  'from_date' => $from_date, 'to_date' => $to_date,  'department' => $department, 'po_hospital_details' => $po_hospital_details, 'type' => $type])->setPaper('a4', 'portrait');

        return $pdf->stream('daly_performance_consultant.pdf');
    }
    public function getDailyMisIpdReportPdf(Request $request)
    {
        $type = $request->type;
        $doctor_code = $request->doctor_hidn;
        $department = $request->department;
        $from_date = $request->date_pic != "" ? date("Y-m-d", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("Y-m-d", strtotime($request->date_pic2 . ' +1 day')) : "";

        $sql_cond = "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($department != "") ? " $clause serviceunit_no_fk = $department" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($doctor_code != "") ? " $clause person_no_pk = $doctor_code" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($from_date != "") ? " $clause admission_date between TO_DATE('$from_date','YYYY/MM/DD') and TO_DATE('$to_date','YYYY/MM/DD')" : "";

        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .=  "$clause (total_appointment is not null or patient_free is not null or patient_followup_free is not null or patient_new_paid is not null or total_patient_paid is not null or lab_amt !=0)" ;

        $ipd_data = DB::select(DB::raw("SELECT  dis_ind,ward_no_pk, ward_name , trunc(admission_date) as admission_date,new_ward_no_fk , new_ward_name from ipd_admitted_patlist_vw $sql_cond group by ward_no_pk, ward_name ,dis_ind, admission_date ,new_ward_no_fk ,new_ward_name order by admission_date desc"));

        $ipd_datas = [];

        if (!empty($ipd_data)) {
            foreach ($ipd_data as $key => $value) {
                $ward_no_name = $value->new_ward_no_fk != "" ? $value->new_ward_no_fk . '_' . $value->new_ward_name : $value->ward_no_pk . '_' . $value->ward_name;
                $ipd_datas[$ward_no_name][] = $value;
            }
        }

        $ipd_department_data = DB::select(DB::raw("SELECT  dis_ind,su_no_fk ,new_su_no_fk, old_serivce_unit_name, new_serivce_unit_name, trunc(admission_date) as admission_date from ipd_admitted_patlist_vw $sql_cond group by dis_ind, admission_date ,su_no_fk ,new_su_no_fk, old_serivce_unit_name, new_serivce_unit_name order by admission_date desc"));

        $ipd_department_datas = [];

        if (!empty($ipd_department_data)) {
            foreach ($ipd_department_data as $key => $value) {
                $su_no_name = $value->new_su_no_fk != "" ? $value->new_su_no_fk . '_' . $value->new_serivce_unit_name : $value->su_no_fk . '_' . $value->old_serivce_unit_name;
                $ipd_department_datas[$su_no_name][] = $value;
            }
        }
        $sql_cond_dept = "";
        $clause_dept = ($sql_cond_dept == "") ? " where" : " and";
        $sql_cond_dept .= ($from_date != "") ? " $clause_dept invoice_date between TO_DATE('$from_date','YYYY/MM/DD') and TO_DATE('$to_date','YYYY/MM/DD')" : "";
        $clause_dept = ($sql_cond_dept == "") ? " where" : " and";
        $sql_cond_dept .=  "$clause_dept item_type in ( 'OT','SUR') and module_code = 'IPD'";

        $surgical_data = DB::select(DB::raw("SELECT sum(current_item_qty) as current_item_qty,serviceunit_name ,item_type from finc_invoicedtl_vw $sql_cond_dept group by serviceunit_name, item_type order by serviceunit_name asc"));

        $sql_cond_rad = "";
        $clause_rad = ($sql_cond_rad == "") ? " where" : " and";
        $sql_cond_rad .= ($from_date != "") ? " $clause_rad invoice_date between TO_DATE('$from_date','YYYY/MM/DD') and TO_DATE('$to_date','YYYY/MM/DD')" : "";
        $clause_rad = ($sql_cond_rad == "") ? " where" : " and";
        $sql_cond_rad .=  "$clause_rad item_type ='RAD' and module_code = 'IPD'";

        $radiology_data = DB::select(DB::raw("SELECT sum(current_item_qty) as current_item_qty,serviceunit_name ,item_type from finc_invoicedtl_vw $sql_cond_rad group by serviceunit_name, item_type order by serviceunit_name asc"));



        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $title = date('d/m/Y');
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.daily_mis_ipd_report_pdf", ['barcode_no' => $barcode_no,  'from_date' => $from_date, 'to_date' => $to_date,  'department' => $department, 'po_hospital_details' => $po_hospital_details, 'type' => $type, 'ipd_datas' => $ipd_datas, 'ipd_department_datas' => $ipd_department_datas, 'surgical_data' => $surgical_data, 'radiology_data' => $radiology_data])->setPaper('a4', 'portrait');

        return $pdf->stream('daly_performance_consultant.pdf');
    }




    // Patient Type


    public function patientType()
    {
        return Template::loadview("admin.settings.patient_type.type_list");
    }
    public function patientTypeCreate()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $discountPolicy = DB::table('sysc_discountpolicy')
            // ->where('au_entry_hospital_no_pk', $ses_hospital_id)
            ->get();
        return Template::loadview("admin.settings.patient_type.create_patient_type", ['discountPolicy' => $discountPolicy]);
    }
    public function storePatientType(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $id = $request->id;
        $auth_id = Auth::id();
        DB::beginTransaction();
        try {
            $data = [
                'patient_type_code'        => $request->patient_type_code,
                'patient_type_desc'        => $request->patient_type_description,
                'status'                   => $request->status,
                'discountpolicy_no_fk'     => $request->discount_policy,
            ];

            if ($id == "") {

                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;
                $data['au_entry_hospital_pk_no'] =  $ses_hospital_id;

                $this->PatientType->create($data);
                // return $res;

            } else {
                // dd($data,$id);
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_pk_no'] =  $ses_hospital_id;
                // $this->PatientType->update($data, $id);
                DB::table('PATN_PATIENTTYPE')->where('PATIENT_TYPE_NO_PK', $id)->update($data);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function create_form()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $discountPolicy = DB::table('sysc_discountpolicy')
            // ->where('au_entry_hospital_no_pk', $ses_hospital_id)
            ->get();
        return Template::loadview("admin.settings.patient_type.create_patient_type_form", ['discountPolicy' => $discountPolicy]);
    }

    public function editPatientType($id)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $discountPolicy = DB::table('sysc_discountpolicy')
            // ->where('au_entry_hospital_no_pk', $ses_hospital_id)
            ->get();
        $data = $this->PatientType->show($id);

        return Template::loadview("admin.settings.patient_type.create_patient_type_form", ['discountPolicy' => $discountPolicy, 'data' => $data]);
    }
    public function getAllPatientType(Request $request)
    {
        $columns = array(
            'sl',
            'patient_type_code',
            'patient_type_desc',
            'discount_name',
            'status',
            'patient_type_no_pk',
        );

        $sql = "SELECT * FROM patient_type_vw";
        $order_by_column = "patient_type_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'desc', $columns);

        echo json_encode($json_data);
    }



    // Auto Item Type


    public function autoItemType()
    {
        return Template::loadview("admin.settings.auto_item_type.auto_item_type_list");
    }
    public function autoItemTypeCreate()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->where('au_entry_hospital_pk_no', $ses_hospital_id)->get();
        $items = DB::table('sysc_serviceitem')->select('item_no_pk', 'item_name')->where('au_entry_hospital_pk_no', $ses_hospital_id)->where('status', 1)->get();
        return Template::loadview("admin.settings.auto_item_type.create_auto_item_patient_type", ['item_type' => $item_type, 'items' => $items]);
    }

    public function storeAutoItemType(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $id = $request->id;
        $auth_id = Auth::id();
        DB::beginTransaction();
        try {
            $data = [
                'autoitemlst_code'         => $request->auto_item_type_code,
                'item_no_fk'               => $request->parent_item_name,

                'auto_item_no_fk'          => $request->item_name,
                'free_ind'                 => $request->free_item,
                'pkg_item_ind'             => $request->pakage_item,
                'item_uom'             => $request->uom,
                'item_qty'             => $request->item_qty,
                // 'stockable_ind'            => $request->patient_type_description,
                'discount_applicable_ind'   => $request->discount_available,
                'status'                    => $request->status,
                'au_entry_session'          => 'session',

            ];

            if ($id == "") {

                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;
                $data['au_entry_hospital_pk_no'] =  $ses_hospital_id;

                $this->AutoItemType->create($data);
                // return $res;

            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_pk_no'] =  $ses_hospital_id;
                $this->AutoItemType->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function autoItemTypeForm()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->where('au_entry_hospital_pk_no', $ses_hospital_id)->get();
        $items = DB::table('sysc_serviceitem item')
                ->leftjoin('sysc_itemtype type','item.itemtype_no_fk','type.itemtype_no_pk')
                ->select('item.item_no_pk', 'item.item_name','type.item_type_name','item.item_type')
                ->where('item.au_entry_hospital_pk_no', $ses_hospital_id)
                ->whereNotIn('ITEM_TYPE', ['MED', 'INV'])
                ->where('item.status', 1)
                ->get();

        


        return Template::loadview("admin.settings.auto_item_type.create_auto_item_type_form", ['item_type' => $item_type, 'items' => $items]);
    }

    public function EditAutoItemType($id)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $item_type = DB::table('item_type_vw')->select('item_name', 'itemtype_no_pk')->get();
        // $items = DB::table('sysc_serviceitem')->select('item_no_pk', 'item_name')->where('au_entry_hospital_pk_no', $ses_hospital_id)->where('status', 1)->get();
        $items = DB::table('sysc_serviceitem item')
        ->leftjoin('sysc_itemtype type','item.itemtype_no_fk','type.itemtype_no_pk')
        ->select('item.item_no_pk', 'item.item_name','type.item_type_name','item.item_type')
        ->where('item.au_entry_hospital_pk_no', $ses_hospital_id)
        ->whereNotIn('ITEM_TYPE', ['MED', 'INV'])
        ->where('item.status', 1)
        ->get();
        $data = $this->AutoItemType->show($id);

        return Template::loadview("admin.settings.auto_item_type.create_auto_item_type_form", ['item_type' => $item_type, 'data' => $data, 'items' => $items]);
    }
    public function getAllAutoItemType(Request $request)
    {
        //         $columns = array(
        //             'sl',
        //             'autoitemlst_code',
        //             'item_name',
        //             'item',
        //             'item_uom',
        //             'item_qty',
        //             'free_ind',
        //             'discount_applicable_ind',
        //             'pkg_item_ind',
        //             'status',
        //             'autoitemlst_no_pk',
        //         );

        //         $sql = "SELECT '' AS sl,
        //         service.autoitemlst_code,
        //         item.item_name,
        //         item.item_name item,
        //         service.item_uom,
        //         service.item_qty,
        //         service.free_ind,
        //         service.discount_applicable_ind,
        //         service.pkg_item_ind,
        //         service.status,
        //         service.autoitemlst_no_pk,
        //         ROWNUM rownumber,
        //         service.au_update_at,
        //         service.au_entry_at
        //    FROM    sysc_serviceitem_auto service
        //         LEFT JOIN
        //            sysc_serviceitem item
        //         ON service.item_no_fk = item.item_no_pk";
        //         $order_by_column = "AUTOITEMLST_NO_PK";

        //         $json_data = $this->datatable($request, $sql, $order_by_column, 'desc', $columns);

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        $table = 'sysc_auto_itemtype_vw';
        // Table's primary key
        $primaryKey = 'autoitemlst_no_pk';

        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'autoitemlst_code', 'dt' => 1),
            array('db' => 'item_name',  'dt' => 2),
            array('db' => 'item',   'dt' => 3),
            array('db' => 'item_uom',   'dt' => 4),
            array('db' => 'item_qty',   'dt' => 5),
            array('db' => 'free_ind',   'dt' => 6),
            array('db' => 'discount_applicable_ind',   'dt' => 7),
            array('db' => 'pkg_item_ind',   'dt' => 8),
            array('db' => 'status',   'dt' => 9),
            array('db' => 'autoitemlst_no_pk',   'dt' => 10)
        );

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }

        // echo json_encode($json_data);
    }

    public function autoItemListForItemType(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $items = DB::table('sysc_serviceitem')->select('item_no_pk', 'item_name')->where('au_entry_hospital_pk_no', $ses_hospital_id)->where('status', 1)->where('itemtype_no_fk', $request->item_type)->get();
        return Template::loadview("admin.settings.auto_item_type.item_list", ['items' => $items]);
    }

    public function referralPaymentReport()
    {
        $card_no = '';
        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.referral_payment_report", ['card_no' => $card_no]);
    }
    public function referralPaymentSearch(Request $request)
    {
        $card_no = $request->card_hidn;
        $from_date = $request->date_pic != "" ? date("Y-m-d", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("Y-m-d", strtotime($request->date_pic2)) : '';
        $selectQuery = DB::table('sysc_referral_payment_vw')->where('process_done_ind', 1);
        $doctor_income = [];

        if ($from_date != "" && $to_date != "") {

            $selectQuery->whereBetween(DB::raw("trunc(refinvoice_date)"), [$from_date, $to_date]); //refinvoice_date
            // $selectQuery->where(DB::raw("trunc(refinvoice_date)"), '>=', date('Y-m-d', strtotime(request('date_pic'))));
            // $selectQuery->where(DB::raw("trunc(refinvoice_date)"), '<=', date('Y-m-d', strtotime(request('date_pic2'))));
        } elseif ($from_date != "") {
            //   $selectQuery->where(DB::raw("trunc(refinvoice_date)"), '=', date('Y-m-d', strtotime(request('date_pic'))));
        }
        if ($card_no != '') {
            $selectQuery->whereRaw("(sysc_referral_payment_vw.doc_person_no_fk = '$card_no' or sysc_referral_payment_vw.first_ref_doc_person_no_fk = '$card_no' or  sysc_referral_payment_vw.second_ref_doc_person_no_fk =  '$card_no')");
        }

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.referral_payment_list_report", ['doctor_income' => $selectQuery->orderBy('refinvoice_date', 'ASC', 'full_name', 'ASC')->get(), 'card_no' => $card_no]);
    }
    public function referralPaymentPdf(Request $request, $id = '')
    {
        
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $card_no = $request->card_hidn;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : '';

        $selectQuery = DB::table('sysc_referral_payment_vw')->where('paid_ind', 1)->where('ipd_su_item_available', '=', '0');
        $selectQuery1 = DB::table('sysc_referral_payment_vw')->leftJoin('ipd_admission', 'ipd_admission.admission_no_pk', 'sysc_referral_payment_vw.admission_no_pk')->where('paid_ind', 1)->select('sysc_referral_payment_vw.*', 'ipd_admission.admission_date')->where('sysc_referral_payment_vw.ipd_su_item_available', '>', 0)->select(DB::raw("ipd_admission.admission_no_pk , ipd_admission.admission_date,sysc_referral_payment_vw.patient_name,sum(sysc_referral_payment_vw.paid_amount) as paid_amount, sum(ledger_amt_payment)  as ledger_amt_sales,
        sum(referral_amount_doc) as referral_amount_doc,
        sum(referral_amount_first) as referral_amount_first,
        sum(referral_amount_second) as referral_amount_second,
        LISTAGG (item_ref_code ,',') WITHIN GROUP (ORDER BY ipd_admission.admission_no_pk) AS item_ref_code "));
        $doctor_income = [];

        if ($from_date != "" && $to_date != "") {
            $selectQuery->where(DB::raw("trunc(sysc_referral_payment_vw.refinvoice_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectQuery->where(DB::raw("trunc(sysc_referral_payment_vw.refinvoice_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
        } elseif ($from_date != "") {
            $selectQuery->where(DB::raw("trunc(sysc_referral_payment_vw.refinvoice_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))));
        }
        if ($card_no != '') {
            $selectQuery->whereRaw("(sysc_referral_payment_vw.doc_person_no_fk = '$card_no' or sysc_referral_payment_vw.first_ref_doc_person_no_fk = '$card_no' or  sysc_referral_payment_vw.second_ref_doc_person_no_fk =  '$card_no')");
            // $selectQuery->orWhere('first_ref_doc_person_no_fk', $card_no);
            // $selectQuery->orWhere('second_ref_doc_person_no_fk', $card_no);
        }


        if ($from_date != "" && $to_date != "") {
            $selectQuery1->where(DB::raw("trunc(sysc_referral_payment_vw.refinvoice_date)"), '>=', date('Y/m/d', strtotime(request('date_pic'))));
            $selectQuery1->where(DB::raw("trunc(sysc_referral_payment_vw.refinvoice_date)"), '<=', date('Y/m/d', strtotime(request('date_pic2'))));
        } elseif ($from_date != "") {
            $selectQuery1->where(DB::raw("trunc(sysc_referral_payment_vw.refinvoice_date)"), '=', date('Y/m/d', strtotime(request('date_pic'))));
        }
        $employee = '';
        if ($card_no != '') {
            $selectQuery1->whereRaw("(sysc_referral_payment_vw.doc_person_no_fk = '$card_no' or sysc_referral_payment_vw.first_ref_doc_person_no_fk = '$card_no' or  sysc_referral_payment_vw.second_ref_doc_person_no_fk =  '$card_no')");
            // $selectQuery->orWhere('first_ref_doc_person_no_fk', $card_no);
            // $selectQuery->orWhere('second_ref_doc_person_no_fk', $card_no);
            $employee =  DB::table("hrms_personnel")->where('person_no_pk', $card_no)->first();
        }


        $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        if (Session::get('user.ses_hospital_code') == 'JKMH') {
           
            if ($id == "PDF") {
                
                $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.referral_payment_pdf_jkmh", ['doctor_income_opd' => $selectQuery->orderBy('refinvoice_date', 'ASC', 'full_name', 'ASC')->get(), 'doctor_income_ipd' => $selectQuery1->groupBy('ipd_admission.admission_no_pk', 'ipd_admission.admission_date', 'sysc_referral_payment_vw.patient_name')->get(), 'card_no' => $card_no, 'print_type' => $id, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'employee' => $employee])->setPaper('a4', 'portarit');
                return $pdf->stream('referral_payment_pdf.pdf');
            } else {
                $pdf = ['doctor_income_opd' => $selectQuery->orderBy('refinvoice_date', 'ASC', 'full_name', 'ASC')->get(), 'doctor_income_ipd' => $selectQuery1->groupBy('ipd_admission.admission_no_pk', 'ipd_admission.admission_date', 'sysc_referral_payment_vw.patient_name', 'sysc_referral_payment_vw.rf_ipd_package')->get(), 'card_no' => $card_no, 'print_type' => $id, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date, 'employee' => $employee];

                $fileToExport = "referral_payment_pdf";
                $html = View("admin.pcrm.referral_v2.IndividualReferralDetails.referral_payment_pdf_jkmh")->with($pdf);
                header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
                header("Content-type: application/vnd.ms-excel");
                return $html;
            }
        } else {
            if ($id == "PDF") {
                $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.referral_payment_pdf", ['doctor_income' => $selectQuery->orderBy('refinvoice_date', 'ASC', 'full_name', 'ASC')->get(), 'card_no' => $card_no, 'print_type' => $id, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date])->setPaper('a4', 'landscape');
                return $pdf->stream('referral_payment_pdf.pdf');
            } else {
                $pdf = ['doctor_income' => $selectQuery->orderBy('refinvoice_date', 'ASC', 'full_name', 'ASC')->get(), 'card_no' => $card_no, 'print_type' => $id, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $from_date, 'to_date' => $to_date];

                $fileToExport = "referral_payment_pdf";
                $html = View("admin.pcrm.referral_v2.IndividualReferralDetails.referral_payment_pdf")->with($pdf);
                header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
                header("Content-type: application/vnd.ms-excel");
                return $html;
            }
        }
    }



    // Discount Policy Department
    public function discountDepartmentWisePolicy($id)
    {
        $refdata = DB::table('sysc_discountpolicy')->where('discountpolicy_no_pk', $id)->first();
        //dd($refdata);
        $service_unit = DB::table('sysc_serviceunit')->where('status', 1)->get();
        //         $dep_policy = db::raw(DB::select('select su.referral_percent,
        //         su.discountpolicy_no_fk,
        //         su.dispolicy_su_no_pk,
        //         ser.serviceunit_name
        //    from    sysc_discountpolicy_su su
        //         left join
        //            sysc_serviceunit ser
        //         on su.su_no_fk = ser.serviceunit_no_pk where su.discountpolicy_no_fk = '.$id));
        $DeptWiseEditdata = [];
        $dep_policy = DB::table('sysc_discountpolicy_su su')->leftjoin('sysc_serviceunit ser', 'su.su_no_fk', 'ser.serviceunit_no_pk')->where('su.discountpolicy_no_fk', $id)->get();
        return Template::loadview('admin.pcrm.discount.department_type_wise_policy', ['DeptWiseEditdata' => $DeptWiseEditdata, 'refdata' => $refdata, 'dep_policy' => $dep_policy, 'service_unit' => $service_unit]);
    }
    public function discountDeptStore(Request $request)
    {
        // dd($request->all());
        $id = $request->ref_su_policy_pk;
        $auth_id = Auth::id();
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        try {
            $data = [
                'equal_percent' => $request->def_ref,
                'clinic_percent' => $request->def_agent,
                // 'referral_percent' => $request->sec_ref,
                'equal_percent' => $request->comission,
                'discountpolicy_no_fk' => $request->ref_policy_pk,
                // 'referralpolicy_su_no_pk' => $request->ref_su_policy_pk,
                'su_no_fk' => $request->su_type,
                'status'   => 1,
                'au_entry_hospital_pk_no'   => $hospital_id,
                'au_entry_session' => 'session',
                // 'au_entry_at' => date('Y-m-d'),
            ];
            // dd($data);

            if ($id == "") {

                $data['au_entry_by'] = $auth_id;
                $this->DiscountDeptPolicy->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->DiscountDeptPolicy->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function discountDepartmentWisePolicyEdit($id, Request $request)
    {
        $DeptWiseEditdata = DB::table('sysc_discountpolicy_su')->where('dispolicy_su_no_pk', $id)->first();
        $refdata = DB::table('sysc_discountpolicy')->where('discountpolicy_no_pk', $DeptWiseEditdata->discountpolicy_no_fk)->first();
        $service_unit = DB::table('sysc_serviceunit')->where('status', 1)->get();
        $dep_policy = DB::table('sysc_discountpolicy_su su')->leftjoin('sysc_serviceunit ser', 'su.su_no_fk', 'ser.serviceunit_no_pk')->where('su.discountpolicy_no_fk', $DeptWiseEditdata->discountpolicy_no_fk)->get();

        return Template::loadview("admin.pcrm.discount.department_type_wise_policy", ['DeptWiseEditdata' => $DeptWiseEditdata, 'service_unit' => $service_unit, 'refdata' => $refdata, 'dep_policy' => $dep_policy]);
    }

    public function adjustingAmountAdmission(Request $request)
    {
        $admission_no_pk =  $request->admission_id;
        $refpaymentipd_no_pk =  $request->refpaymentipd_no_id;


        for ($i = 0; $i < count($refpaymentipd_no_pk); $i++) {
            $data = array();
            $data['paid_amount'] = $request->comission[$i];
            $data['pay_voucher_print_cnt'] = $request->print_id[$i] + 1;
            $data['paid_ind'] = 1;
            $data['paid_date'] = date('y-m-d');
            $data['paid_by'] = auth::id();
            DB::table('sysc_referral_payment_ipd')->where('refpaymentipd_no_pk', $refpaymentipd_no_pk[$i])->update($data);
        }

        DB::commit();
        $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        return response()->json($message);
    }


    public function ipdDoctorPerformanceSummaryReport()
    {

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.ipddoctor_performance_summary_report", [
            'type' => '',
            'requestDepts' => DB::table('sysc_serviceunit_vw')
                ->where('ipd_ind', 1)
                ->get(['serviceunit_name', 'serviceunit_no_pk'])
        ]);
    }
    public function ipdDoctorPerformanceSummaryReportSearch(Request $request)
    {

        $type = $request->type;
        $doctor_code = $request->doctor_hidn;
        $department = $request->department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($department != "") ? " $clause per.serviceunit_no_fk = $department" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($doctor_code != "") ? " $clause per.person_no_pk = $doctor_code" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($from_date != "") ? " $clause trunc(admission_date) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')" : "";

            $report_data = DB::select(DB::raw("SELECT COUNT (*) no_of_patient,
                   primary_doctor_no_fk,
                   FULL_NAME primary_doctor_name,
                   UNIT.SERVICEUNIT_NAME dept
              FROM ipd_admission ipd, hrms_personnel per, sysc_serviceunit unit
             WHERE ipd.primary_doctor_no_fk = PER.PERSON_NO_PK
             AND PER.SERVICEUNIT_NO_FK = UNIT.SERVICEUNIT_NO_PK
                $sql_cond
                   AND ipd.EMERGENCY_DAYCARE_IND_TXT IS NULL
          GROUP BY primary_doctor_no_fk, FULL_NAME, UNIT.SERVICEUNIT_NAME ORDER BY 3 ASC"));

        return Template::loadview("admin.pcrm.referral_v2.IndividualReferralDetails.ipddoctor_performance_summary_report_list", ['doctorPerformanceSummary' => $report_data, 'type' => $type]);
    }




    public function ipdDoctorPerformanceSummaryReportPdf(Request $request)
    {
        $type = $request->type;
        $doctor_code = $request->doctor_hidn;
        $department = $request->department;
        $from_date = $request->date_pic != "" ? date("d-m-Y", strtotime($request->date_pic)) : '';
        $to_date = $request->date_pic2 != "" ? date("d-m-Y", strtotime($request->date_pic2)) : "";
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($department != "") ? " $clause per.serviceunit_no_fk = $department" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($doctor_code != "") ? " $clause per.person_no_pk = $doctor_code" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($from_date != "") ? " $clause trunc(admission_date) between to_date('$from_date','dd/mm/yyyy') and to_date('$to_date','dd/mm/yyyy')" : "";

            $report_data = DB::select(DB::raw("SELECT COUNT (*) no_of_patient,
                   primary_doctor_no_fk,
                   FULL_NAME primary_doctor_name,
                   UNIT.SERVICEUNIT_NAME dept
              FROM ipd_admission ipd, hrms_personnel per, sysc_serviceunit unit
             WHERE ipd.primary_doctor_no_fk = PER.PERSON_NO_PK
             AND PER.SERVICEUNIT_NO_FK = UNIT.SERVICEUNIT_NO_PK
                $sql_cond
                   AND ipd.EMERGENCY_DAYCARE_IND_TXT IS NULL
          GROUP BY primary_doctor_no_fk, FULL_NAME, UNIT.SERVICEUNIT_NAME ORDER BY 3 ASC"));



        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();


        //return $doctorPerformanceSummary->orderBy('appoint_date', 'ASC')->get();
        $title = date('d/m/Y');
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        if ($request->hdn_report_type == 'PDF') {
            $pdf = PDF::loadView("admin.pcrm.referral_v2.IndividualReferralDetails.ipddoctor_performance_report_pdf", ['doctorPerformanceSummary' => $report_data, 'barcode_no' => $barcode_no,  'from_date' => $from_date, 'to_date' => $to_date, 'department' => $department, 'po_hospital_details' => $po_hospital_details, 'type' => $type])->setPaper('a4', 'landscape');
            if ($type != 'DEPT') {
                return $pdf->download('ipd_doctor_performance_summary_report.pdf');
            } else {
                return $pdf->download('ipd_Dept_wise_Performance_summary_report.pdf');
            }
        }
        if ($request->hdn_report_type == 'EXCEL') {

            // dd('ok');
            $pdf = ['doctorPerformanceSummary' => $report_data, 'barcode_no' => $barcode_no,  'from_date' => $from_date, 'to_date' => $to_date, 'department' => $department, 'po_hospital_details' => $po_hospital_details, 'type' => $type];
            $fileToExport = "ipd_doctor_performance_summary_report";
            $html = View("admin.pcrm.referral_v2.IndividualReferralDetails.ipddoctor_performance_report_pdf")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }



    }
}
