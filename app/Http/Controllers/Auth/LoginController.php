<?php

namespace App\Http\Controllers\Auth;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Library\Template;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        $this->middleware('check.active')->only('login');
    }


    public function logout()
    {

        Auth::logout();
        return redirect()->route('login');
    }

    protected function credentials(Request $request)
    {

        if(is_numeric($request->get('email'))){
            return ['user_code'=>$request->get('email'),'password'=>$request->get('password')];
        }
        // dd($request->get('email'));
        return $request->only($this->username(), 'password');
    }

    protected function authenticated(Request $request, $user)
    {

        if (!Auth::check()) {
            return redirect('/login');
        }

        $user_info = Auth::user();
        if (DB::table("wsec_user")
        ->leftjoin("employee_info_vw", "employee_info_vw.person_no_pk", "wsec_user.person_no_fk")
        ->where('employee_info_vw.person_no_pk', $user_info->person_no_fk)
        ->exists()) {

                $hod_approval_grant_service= DB::table("sysc_grant_su")
                ->select('hod_ind')
                ->where('user_no_fk',  Auth::id())
                ->where('hod_ind', 1)
                ->first();

                $user_info_data = DB::table("wsec_user")
                    ->leftjoin("employee_info_vw", "employee_info_vw.person_no_pk", "wsec_user.person_no_fk")
                    ->where('employee_info_vw.person_no_pk', $user_info->person_no_fk)
                    ->first();
                // dd( $user_info_data);
                    $approval_info=DB::table('sysc_approvalmatrixdtl')->where('person_no_fk',$user_info->person_no_fk)->first();
                    $approvalmatrix_level_num=!empty($approval_info) ? $approval_info->approvalmatrix_level_num :'';
                    $approval_ind=!empty($approval_info) ? 1 :'';
                //$company_details = $lead_unit = \App\Models\Company::where("status", 1)->where("hospital_no_pk", $user_info_data->au_entry_hospital_pk_no)->first();
                $company_details = $lead_unit = \App\Models\Company::where("status", 1)->first();

                // ASSIGN SESSION VALUE OF AUTHENTICATED USER
                session(['user.ses_user_name' => $user_info->user_name]);
                //session(['user.ses_hospital_no_pk' => $user_info->hospital_no_pk]); this was here in before

                session(['user.ses_hospital_no_pk' => $user_info->au_entry_hospital_pk_no]);
                session(['user.ses_email' => $user_info->email]);
                session(['user.ses_user_pk_no' => $user_info->user_no_pk]);
                session(['user.user_code' => $user_info_data->person_code]);
                session(['user.speci_discount_auth_ind' => $user_info_data->speci_discount_auth_ind]);
                session(['user.ses_person_no_fk' => $user_info->person_no_fk]);
                session(['user.ses_invoice_ref_edit_ind' => isset($user_info_data->invoice_ref_edit_ind) && $user_info_data->invoice_ref_edit_ind !="" ? $user_info_data->invoice_ref_edit_ind : ""]);
                session(['user.ses_gender' => $user_info_data->gender_txt]);
                session(['user.ses_specialization_fk' => $user_info_data->specialization_lookup_no_fk]);
                session(['user.job_title' => $user_info_data->job_title]);

                session(['user.ses_gender_lookup_no' => $user_info_data->gender]);
                session(['user.ses_specialization' => $user_info_data->specialization]);
                session(['user.job_title_lookup_no' => $user_info_data->job_type_lookup_no_fk]);
                session(['user.designation_name' => $user_info_data->designation]);

                session(['user.join_data' => $user_info_data->join_date]);
                session(['user.su_pk_no' => $user_info_data->serviceunit_no_fk]);
                // session(['user.serviceunit_no_fk_dept' => $user_info_data->serviceunit_no_fk_dept]);
                session(['user.serviceunit' => $user_info_data->su_name]);
                session(['user.serviceunit_code' => $user_info_data->serviceunit_code]);

                session(['user.inv_director_admin_ind' => $user_info_data->inv_director_admin_ind]);
                session(['user.inv_director_acc_ind' => $user_info_data->inv_director_acc_ind]);
                session(['user.inv_chairman_ind' => $user_info_data->inv_chairman_ind]);
                session(['user.inv_gen_man_proc_ind' => $user_info_data->inv_gen_man_proc_ind]);
                session(['user.inv_manager_acc_ind' => $user_info_data->inv_manager_acc_ind]);
                session(['user.inv_proc_ind' => $user_info_data->inv_proc_ind]);
                session(['user.inv_store_ind' => $user_info_data->inv_store_ind]);
                session(['user.financial_ind' => $user_info_data->financial_ind]);

                session(['user.inv_hod_ind' => $user_info_data->inv_hod_ind]);
                session(['user.inv_auth_admin_ind' => $user_info_data->inv_auth_admin_ind]);
                session(['user.inv_auth_director_ind' => $user_info_data->inv_auth_director_ind]);
                session(['user.inv_auth_chairman_ind' => $user_info_data->inv_auth_chairman_ind]);
                session(['user.email_personal' => $user_info_data->email_personal]);
                session(['user.inv_auth_chairman_login' => $user_info->personnel->inv_auth_chairman_ind]);
                session(['user.approval_ind' => $approval_ind]);
                session(['user.approvalmatrix_level_num' => $approvalmatrix_level_num]);
                session(['user.grant_hod_ind' => !empty($hod_approval_grant_service)? $hod_approval_grant_service->hod_ind : '']);

                session(['user.hospital_name' => $company_details->hospital_name]);
                session(['user.hospital_telephone1' => $company_details->telephone1]);
                session(['user.hospital_name_bangla' => $company_details->hospital_name_bangla]);
                session(['user.ses_hospital_code' => $company_details->hospital_code]);
                session(['user.hospital_exp_date' => $company_details->hospital_exp_date]);
                session(['user.ses_hospital_mobile_no' => $company_details->telephone1]);
                session(['user.ses_hospital_logo' => $company_details->logo]);
                session(['user.email_send_ind' => $company_details->email_send_ind]);
                session(['user.sms_send_ind' => $company_details->sms_send_ind]);
                session(['user.ses_hospital_version' => isset($company_details->h360_app_version) ? $company_details->h360_app_version : '']);
                session(['user.ses_store_no_fk' => null]);
                session(['previous_route_name' => \Illuminate\Support\Facades\Route::currentRouteName()]);


                session()->save();

                if (Auth::check()) {
                    return redirect()->route('home');
                }

        }

        if (!Auth::check()) {
            return redirect('/login');
        }

        //     dd($user_info);
        //      $data = session('user.ses_hospital_no_pk');;
        //      dd($data);

    }
}
