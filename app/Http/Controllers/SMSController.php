<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\PatHistoryTracking;
use Illuminate\Http\Request;
use App\Traits\MailEngine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use App\Repositories\BaseRepository as Repo;


class SMSController extends Controller
{
    //
    use MailEngine;
    protected $model;
    public function __construct(PatHistoryTracking $PatHistoryTracking)
    {
        $this->middleware('auth');
        $this->PatHistoryTracking = new Repo($PatHistoryTracking);
    }

    public function smsModal($param)
    {
        $hospital = DB::table("wsec_hospital")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        return Template::loadView("admin.sms.sms_modal", ['param' => $param,'hospital'=> $hospital]);
    }
    public function sendSms(Request $request)
    {
        $sms = $this->sendCustomSms($request->mobile_num, $request->message_body);
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
            $call_text = $request->message_body;
        } elseif (!empty($sms)) {
            $call_ind = 0;
            $sms_ind = 1;
            $email_ind = 0;
            $call_text = "N/A";
            $email_text = "N/A";
            $sms_text = $request->message_body;
        } elseif (!empty($email)) {
            $call_ind = 0;
            $sms_ind = 0;
            $email_ind = 1;
            $call_text = "N/A";
            $sms_text = "N/A";
            $email_text = $request->message_body;
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
    public function ipdSmsModal($param)
    {
        return Template::loadView("admin.sms.ipd_sms_modal", ['param' => $param]);
    }
    public function sendIPDSms(Request $request)
    {
        $sms = $this->sendCustomSms($request->mobile_num, $request->message_body);
        $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        return response()->json($message);
    }
}
