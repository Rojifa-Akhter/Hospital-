<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Library\Template;
use App\Models\Policy;
use App\Models\PolicyDetails;
use App\Repositories\BaseRepository as Repo;
use App\Traits\LookupData;
use App\Traits\PolicyData;
use Session;
use App\Traits\DatatablesLoader;

class PolicyController extends Controller
{
    protected $model, $dtlsmodel;
    use LookupData, PolicyData, DatatablesLoader;

    public function __construct(Policy $policy, PolicyDetails $policydetails)
    {
        $this->middleware('auth');
        $this->model = new Repo($policy);
        $this->dtlsmodel = new Repo($policydetails);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apply_to = $this->getLookupListByCodeCustomKey("lookupdata_code", "POLICYAPPLY");
        return Template::loadview("admin.settings.policy.policy_setup", ["apply_to" => $apply_to]);
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
    public function store(Request $request)
    {
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();

        DB::beginTransaction();
        try {

            $data = [
                'POLICY_CODE' => $request->txt_policy_code,
                'POLICY_DESC' => $request->txt_policy_name,
                'APPLY_TO' => $request->cmb_apply_to,
                'STATUS' => 1,
                'AU_ENTRY_HOSPITAL_PK_NO' => $ses_hospital_id,
            ];

            if ($id == null) {
                $data['au_entry_by'] = $auth_id;
                $data['au_entry_session'] = 'S0901';
                // $data['au_entry_hospital_pk_no'] = $ses_hospital_id;
                $this->model->create($data);
            } else {
                $data['au_update_by'] = $auth_id;
                $this->model->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'New Policy Added Successfully', 'title' => 'Success'];
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function policyList(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array('policy_no_pk', 'policy_code', 'policy_desc', 'apply_to');

        $sql = "SELECT policy_no_pk,policy_code,policy_desc,apply_to, rownum rownumber, au_update_at,au_entry_at from pcrm_comission_policymst where AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id ";
        $order_by_column = "module_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);

        echo json_encode($json_data);
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
    public function comission($policy_id = "")
    {
        $policy_arr = [];
        $policy_name = "";
        if ($policy_id != "") {
            $policy_data = DB::table("pcrm_comission_policymst")
                ->leftJoin('pcrm_comission_policydtl', 'pcrm_comission_policymst.policy_no_pk', '=', 'pcrm_comission_policydtl.policy_no_fk')
                ->leftJoin('sysc_serviceitem', 'pcrm_comission_policydtl.item_no_fk', '=', 'sysc_serviceitem.item_no_pk')
                ->leftJoin('doctor_info_vw', 'pcrm_comission_policydtl.doctor_person_no_fk', '=', 'doctor_info_vw.person_no_pk')
                ->where("pcrm_comission_policymst.policy_no_pk", $policy_id)->get();

            if (!empty($policy_data)) {
                foreach ($policy_data as $policy) {
                    $policy_name = $policy->policy_desc;
                    $policy_arr[$policy->item_name][] = $policy->full_name . "_" . $policy->doctor_pay_percent . "_" . $policy->doctor_thanks_sms_ind . "_" . $policy->first_referral_pay_percent . "_" . $policy->first_referral_thanks_sms_ind . "_" . $policy->second_referral_pay_percent . "_" . $policy->second_referral_thanks_sms_ind . "_" . $policy->ma_pay_percent . "_" . $policy->ma_thanks_sms_ind;
                }
            }
        }
        $apply_to = $this->getLookupListByCodeCustomKey("lookupdata_code", "POLICYAPPLY");
        return Template::loadview("admin.settings.policy.policy_comission_setup", ["apply_to" => $apply_to, "policy_id" => $policy_id, "policy_name" => $policy_name, "policy_arr" => $policy_arr]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function policyAutocomplete(Request $request)
    {
        return $this->getPolicyAutocompleteList($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_comission(Request $request)
    {
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();

        DB::beginTransaction();
        try {

            $data = [
                'POLICY_NO_FK' => $request->hdn_policy_id,
                'ITEM_NO_FK' => $request->hdn_item_id,
                'DOCTOR_PERSON_NO_FK' => $request->hdn_doctor_id,
                'DOCTOR_PAY_PERCENT' => $request->txtDocCommitsion,
                'DOCTOR_THANKS_SMS_IND' => ($request->chkDocSms == 'on') ? 1 : 0,
                'FIRST_REFERRAL_PAY_PERCENT' => $request->txtFirstRefCommitsion,
                'FIRST_REFERRAL_THANKS_SMS_IND' => ($request->chkFirstRefSms == 'on') ? 1 : 0,
                'SECOND_REFERRAL_PAY_PERCENT' => $request->txtSecondRefCommitsion,
                'SECOND_REFERRAL_THANKS_SMS_IND' => ($request->chkSecondRefSms == 'on') ? 1 : 0,
                'MA_PAY_PERCENT' => $request->txtAgentComission,
                'MA_THANKS_SMS_IND' => ($request->chkAgentRefSms == 'on') ? 1 : 0,
                'STATUS' => 1,
            ];

            if ($id == null) {
                $data['au_entry_by'] = $auth_id;
                $data['au_entry_session'] = 'S0901';
                $data['AU_ENTRY_HOSPITAL_PK_NO'] = $ses_hospital_id;
                $this->dtlsmodel->create($data);
            } else {
                $data['au_update_by'] = $auth_id;
                $this->dtlsmodel->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'New Commission Policy Added Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function policyDetails(Request $request)
    {
        $policy_data = DB::table("pcrm_comission_policymst")
            ->leftJoin('pcrm_comission_policydtl', 'pcrm_comission_policymst.policy_no_pk', '=', 'pcrm_comission_policydtl.policy_no_fk')
            ->leftJoin('sysc_serviceitem', 'pcrm_comission_policydtl.item_no_fk', '=', 'sysc_serviceitem.item_no_pk')
            ->leftJoin('doctor_info_vw', 'pcrm_comission_policydtl.doctor_person_no_fk', '=', 'doctor_info_vw.person_no_pk')
            ->where("POLICY_NO_FK", $request->policy_id)->get();
        $policy_arr = [];
        $policy_name = "";
        if (!empty($policy_data)) {
            foreach ($policy_data as $policy) {
                $policy_name = $policy->policy_desc;
                $policy_arr[$policy->item_name][] = $policy->full_name . "_" . $policy->doctor_pay_percent . "_" . $policy->doctor_thanks_sms_ind . "_" . $policy->first_referral_pay_percent . "_" . $policy->first_referral_thanks_sms_ind . "_" . $policy->second_referral_pay_percent . "_" . $policy->second_referral_thanks_sms_ind . "_" . $policy->ma_pay_percent . "_" . $policy->ma_thanks_sms_ind;
            }
        }
        //dd($policy_arr);

        return Template::loadview("admin.settings.policy.policy_details", ["policy_name" => $policy_name, "policy_arr" => $policy_arr]);
    }
}
