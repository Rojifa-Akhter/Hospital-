<?php

namespace App\Http\Controllers\WebPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Classes\AgoraDynamicKey\RtcTokenBuilder;
use App\Events\MakeAgoraCall;

class VideoCallController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function videoCall()
    {
        $doc_id = Auth::user()->person_no_fk;

        if (Auth::user()->user_type == "doc") {

            $users = DB::select(DB::raw("select pat.*,psn.prescription_no_pk,wsec_user.user_no_pk
            from patn_appointment_vw pat
            left join psn_t_prescription_vw psn
            on pat.appoint_no_pk = psn.appoint_no_fk
            join wsec_user on  pat.patient_no_pk = wsec_user.patient_no_fk
            where appoint_status = 1
             and trunc(pat.appoint_date) = trunc(sysdate)  and doctor_no_fk = $doc_id
            order by appoint_no_pk DESC"));
            $title = "Patient";

        } else {
            $pat_id = Auth::user()->patient_no_fk;
            $users = DB::select(DB::raw("select pat.full_name as patient_name,wsec_user.user_no_pk ,psn.prescription_no_pk
            from patn_appointment_vw pat
            left join psn_t_prescription_vw psn  on pat.appoint_no_pk = psn.appoint_no_fk
            join wsec_user on  pat.doctor_no_fk = wsec_user.person_no_fk
            where appoint_status = 1 and trunc(pat.appoint_date) = trunc(sysdate)
             and patient_no_pk =   $pat_id
            order by appoint_no_pk DESC"));
            $title = "Doctor";

        }

        return view('webPanel.video_call', compact('users','title'));
    }
    public function index(Request $request)
    {
        // fetch all users apart from the authenticated user
        $doc_id = Auth::user()->person_no_fk;

        if (Auth::user()->user_type == "doc") {
            $users = DB::select(DB::raw("select pat.*,psn.prescription_no_pk,wsec_user.user_no_pk from patn_appointment_vw pat
            left join psn_t_prescription_vw psn
            on pat.appoint_no_pk = psn.appoint_no_fk
            join wsec_user on  pat.patient_no_pk = wsec_user.patient_no_fk
            where appoint_status = 1 and trunc(pat.appoint_date) = trunc(sysdate)  and doctor_no_fk =$doc_id
            order by appoint_no_pk DESC"));
        } else {
            $users = DB::select(DB::raw("select pat.*,psn.prescription_no_pk,wsec_user.user_no_pk from patn_appointment_vw pat
            left join psn_t_prescription_vw psn
            on pat.appoint_no_pk = psn.appoint_no_fk
            left join wsec_user on  pat.patient_no_pk = wsec_user.person_no_fk
            where appoint_status = 1 and trunc(pat.appoint_date) = trunc(sysdate)  and doctor_no_fk = 11854
            order by appoint_no_pk DESC"));
        }

        return view('webPanel.agora-chat', ['users' => $users]);
    }
    public function token(Request $request)
    {

        $appID = env('AGORA_APP_ID');
        $appCertificate = env('AGORA_APP_CERTIFICATE');
        $channelName = $request->channelName;
        $user = Auth::user()->name;
        $role = RtcTokenBuilder::RoleAttendee;
        $expireTimeInSeconds = 3600;
        $currentTimestamp = now()->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

        $token = RtcTokenBuilder::buildTokenWithUserAccount($appID, $appCertificate, $channelName, $user, $role, $privilegeExpiredTs);

        return $token;
    }
    public function callUser(Request $request)
    {

        $data['userToCall'] = $request->user_to_call;
        $data['channelName'] = $request->channel_name;
        $data['from'] = Auth::id();

        broadcast(new MakeAgoraCall($data))->toOthers();
    }
    
}
