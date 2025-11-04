<?php

namespace App\Http\Controllers;

use App\Datatables\DataTableClass;
use App\Http\Controllers\Controller;
use App\Models\CorporateClient;
use Illuminate\Http\Request;
use App\Library\Template;
use App\Traits\DatatablesLoader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Traits\LookupData;
use App\Traits\PatientData;
use App\Repositories\BaseRepository as Repo;
use App\Models\CorporateModel;
use App\Models\CorporatePolicy;
use App\Models\CorporateStaff;
use App\Traits\UtilitiesTrait;
use App\Models\Designation;
use App\Models\StaffDependent;
use App\Models\Csu;
use App\Models\CitemType;
use App\Models\Citem;
use App\Models\Cheque;
use App\Models\ServiceUnit;

use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class CorporateController extends Controller
{

    use LookupData, DatatablesLoader, UtilitiesTrait, PatientData;

    private Repo $corporateModel;
    private Repo $staffModel;
    private Repo $dependent;
    private Repo $corporatePolicy;
    private Repo $Csu;
    private Repo $CitemType;
    private Repo $Citem;
    private Repo $Cheque;
    private Repo $model;
    private Repo $baseRepository;

    public function __construct(
        CorporateClient $CorporateClient,
        CorporateModel $corporate,
        CorporateStaff $staff,
        StaffDependent $dependent,
        CorporatePolicy $corporatePolicy,
        Csu $Csu,
        CitemType $CitemType,
        Citem $Citem,
        Cheque $Cheque
    ) {
        $this->middleware('auth');
        $this->corporateModel = new Repo($corporate);
        $this->Csu = new Repo($Csu);
        $this->CitemType = new Repo($CitemType);
        $this->Citem = new Repo($Citem);
        $this->staffModel = new Repo($staff);
        $this->dependent = new Repo($dependent);
        $this->Cheque = new Repo($Cheque);
        $this->model = new Repo($CorporateClient);
        $this->corporatePolicy = new Repo($corporatePolicy);
        $this->baseRepository = new Repo($CorporateClient);
    }

    public function corporateClientEntryForm()
    {

        $district = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();
        $nationality = $this->getLookupListByCode("NATIONALITY");
        $corporate_policy = db::table('ccm_corporatepolicy')->select('corporate_policy_no_pk', 'corporatepolicy_name')->get();
        return template::loadview('admin.corporate_client.corporate_client_entry', [
            'district' => $district,
            'nationality' => $nationality,
            'corporate' => $corporate
        ]);
    }

    public function corporateClientEntry()
    {
        return template::loadview('admin.corporate_client.corporate_client_entry_list');
    }

    public function corporateClientEntryPopup()
    {
        $district = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();
        $country = $this->getLookupListByCode("NATIONALITY");
        $corporate_policy = db::table('ccm_corporatepolicy')->select('corporate_policy_no_pk', 'corporatepolicy_name')->get();
        return template::loadview('admin.corporate_client.corporate_client_entry_popup', [
            'district' => $district,
            'country' => $country,
            'corporate_policy' => $corporate_policy
        ]);
    }

    public function clientList(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        $table = 'ccm_corporate_client';
        $primarykey = 'ccm_client_no_pk';
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'ccm_client_logo', 'dt' => 1),
            array('db' => 'ccm_client_name', 'dt' => 2),
            array('db' => 'ccm_client_address', 'dt' => 3),
            array('db' => 'ccm_client_country', 'dt' => 4),
            array('db' => 'ccm_client_city', 'dt' => 5),
            array('db' => 'ccm_client_contact_no', 'dt' => 6),
            array('db' => 'ccm_client_email', 'dt' => 7),
            array('db' => 'is_emp_health_checking_ind', 'dt' => 8),
            array('db' => 'is_proosal_approval_ind', 'dt' => 9),
            array('db' => 'is_post_bill_ind', 'dt' => 10),
            array('db' => 'status', 'dt' => 11),
            array('db' => 'ccm_client_no_pk', 'dt' => 12),
        );
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primarykey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function clientStore(Request $request)
    {
        //    dd($request->all());

        $id = $request->id;
        $auth_id = Auth::id();
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        try {
            $sequence = DB::getSequence();
            $ccm_client_no_pk_seq = $sequence->nextValue('ccm_client_no_pk_seq');

            $data = [];

            $data = [
                'ccm_client_no_pk' => $ccm_client_no_pk_seq,
                'ccm_client_code' => 'ccm_' . $ccm_client_no_pk_seq,
                'ccm_client_name' => $request->client_name,
                'ccm_client_country' => $request->present_country,
                'ccm_client_city' => $request->par_district,
                'ccm_client_address' => $request->address,
                'ccm_client_contact_no' => $request->c_phone,
                'ccm_client_email' => $request->corporate_em_ad,
                'ccm_client_contact_ad' => $request->c_address,
                'is_emp_health_checking_ind' => $request->emp_health_service,
                'is_proosal_approval_ind' => $request->is_proposal_app,
                'is_post_bill_ind' => $request->post_bill,
                'status' => $request->status ? 1 : null,
                'au_entry_hospital_pk_no' => $hospital_id,
                'au_entry_session' => 1,
                'corporate_policy_no_fk' => $request->corporate_id,
            ];

            if ($id == null) {
                $data['au_entry_by'] = $auth_id;
                $data['au_entry_at'] = date('Y-m-d');
                $inserted = $this->model->create($data);

                //logo background
                $image_name = "";
                if ($files = $request->file('corporate_logo')) {
                    $image_name = "logo_back" . date("Y_m_d_h_i") . "." . $files->getClientOriginalExtension();
                }
                $update_image['ccm_client_logo'] = $image_name;
                // $this->baseRepository->update($update_image, $inserted->ccm_client_no_pk);
            } else {
                $data['au_update_by'] = $auth_id;
                $data['au_update_at'] = date('Y-m-d');
                $this->model->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function editCorporateEntry($id)
    {
        $data = DB::table('ccm_corporate_client')->where('ccm_client_no_pk', $id)->first();
        $district = DB::table('sysc_district')->select('id', 'name')->orderBy("name", "asc")->get();
        $country = $this->getLookupListByCode("NATIONALITY");
        return template::loadview('admin.corporate_client.corporate_client_entry_popup', [
            'district' => $district,
            'country' => $country,
            'data' => $data
        ]);
    }


    // Added By Nazmul 21.01.2022
    public function corporateEntry()
    {
        $corporate_policy = db::table('ccm_corporatepolicy')->select('corporate_policy_no_pk', 'corporatepolicy_name')->get();
        $designation = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
        return template::loadview('admin.corporate.corporate_entry', compact('designation', 'corporate_policy'));
    }

    public function corporateWorklist()
    {
        // $hospital_id = Session::get('user.ses_hospital_no_pk');
        // $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        // $where = "au_entry_hospital_pk_no = $hospital_id";
        // $table = 'ccm_corporateclient_vw';
        // $primarykey = 'ccm_client_no_pk';
        // $columns = array(
        //     array('db' => 'rownum', 'dt' => 0),
        //     array('db' => 'ccm_client_code', 'dt' => 1),
        //     array('db' => 'ccm_client_name', 'dt' => 2),
        //     array('db' => 'client_address', 'dt' => 3),
        //     array('db' => 'contact_person', 'dt' => 4),
        //     array('db' => 'contact_mobile', 'dt' => 5),
        //     array('db' => 'designation_name', 'dt' => 6),
        //     array('db' => 'official_email', 'dt' => 7),
        //     array('db' => 'total_register_staff', 'dt' => 8),
        //     array('db' => 'active_status', 'dt' => 9),
        //     array('db' => 'ccm_client_no_pk', 'dt' => 10)


        // );
        // if (!empty($where)) {
        //     echo json_encode(DataTableClass::complex($request, $table, $primarykey, $columns, null, $where));
        // } else {

        //     echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        // }

        //dd($work_list);
        $work_list = DB::table('ccm_corporateclient_vw')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->orderBy('ccm_client_no_pk', 'desc')->get();
        return template::loadview('admin.corporate.corporate_entry_worklist', compact('work_list'));
    }
    public function editCorporateForm($id)
    {
        $corporate_policy = db::table('ccm_corporatepolicy')->select('corporate_policy_no_pk', 'corporatepolicy_name')->get();
        $corporate_record = DB::table('CCM_CorporateClient')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('ccm_client_no_pk', $id)->first();

        $designation = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();

        return template::loadview('admin.corporate.corporate_entry_form', compact('corporate_record', 'designation', 'corporate_policy'));
    }
    public function getCorporateForm()
    {
        return template::loadview('admin.corporate.corporate_entry_form');
    }

    public function corporateStaffEntry()
    {
        $gender = $this->getLookupListByCode("GENDER");
        $designation = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
        return template::loadview('admin.corporate.corporate_staff_entry', [
            'gender' => $gender,
            'designation' => $designation
        ]);
    }
    public function corporateStaffStore(Request $request)
    {
        $validatedData = $request->validate([
            // 'code' => 'required',
            // 'name' => 'required',
            // 'address' => 'required',
            // 'phone' => 'required'
            // // 'Address' => 'required'

        ]);
        $id = $request->id;
        $auth_id = Auth::id();

        try {
            $sequence = DB::getSequence();
            $ccm_staff_no_pk_seq = $sequence->nextValue('ccm_staff_no_pk_seq');
            $corporate_staff_info = [];
            $corporate_staff_info = [

                'ccm_staff_no_pk' => $ccm_staff_no_pk_seq,
                'ccm_company_id' => $request->companyId,
                'ccm_company_name' => $request->companyName,
                'ccm_contact_person' => $request->contactPerson,
                'ccm_contact_number' => $request->contactNumber,
                'ccm_staff_id' => $request->Id,
                'ccm_staff_name' => $request->Name,
                'ccm_designation_no_fk' => $request->Designation,
                'ccm_staff_contact' => $request->Contact,
                'ccm_staff_email' => $request->Email,
                'ccm_patient_no_fk' => $request->patientID,
                'ccm_staff_dob' => $request->DOB,
                'ccm_gender_no_fk' => $request->Gender,
                'ccm_age' => $request->Age,
                'status' => 1,
                'au_entry_at' => date('Y-m-d'),
                'au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                'au_entry_session' => 'hospital',
            ];
            if ($id == null) {
                $corporate_staff_info['au_entry_by'] = $auth_id;
                //dd($corporate_staff_info);

                $this->staffModel->insert($corporate_staff_info);
                // dd($response);
                //$last_id = $response->ccm_staff_no_pk;
                // dd($last_id);

                //    $image_name = "";
                //    if ($files = $request->file('corporateImage')) {
                //        $image_name = $last_id . "." . $files->getClientOriginalExtension();
                //    }

                //    $update_image['logo'] = $image_name;
                //    $this->model2->update($update_image, $last_id);

            } else {
                $corporate_staff_info['au_update_by'] = $auth_id;
                //dd($corporate_staff_info);

                DB::table('ccm_corporatestaff')->where('ccm_staff_no_pk', $id)->update($corporate_staff_info);

                //   $corporate_client_info['au_update_by'] = $auth_id;
                //   DB::table('ccm_corporateclient')->where('ccm_client_no_pk', $id)->update($corporate_client_info);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function corporateStaffAdd(Request $request)
    {
        $validatedData = $request->validate([
            // 'code' => 'required',
            // 'name' => 'required',
            // 'address' => 'required',
            // 'phone' => 'required'
            // // 'Address' => 'required'

        ]);
        //$id = $request->id;
        $auth_id = Auth::id();

        try {
            $sequence = DB::getSequence();
            $ccm_staff_no_pk_seq = $sequence->nextValue('ccm_staff_no_pk_seq');
            $corporate_staff_info = [];
            $corporate_staff_info = [

                'ccm_staff_no_pk' => $ccm_staff_no_pk_seq,
                'ccm_company_id' => $request->companyId,
                'ccm_company_name' => $request->companyName,
                'ccm_contact_person' => $request->contactPerson,
                'ccm_contact_number' => $request->contactNumber,
                'ccm_staff_id' => $request->Id,
                'ccm_staff_name' => $request->Name,
                'ccm_designation_no_fk' => $request->Designation,
                'ccm_staff_contact' => $request->Contact,
                'ccm_staff_email' => $request->Email,
                'ccm_patient_no_fk' => $request->patientID,
                'ccm_staff_dob' => $request->DOB,
                'ccm_gender_no_fk' => $request->Gender,
                'ccm_age' => $request->Age,
                'status' => 1,
                'au_entry_at' => date('Y-m-d'),
                'au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                'au_entry_session' => 'hospital',
            ];

            $corporate_staff_info['au_entry_by'] = $auth_id;
            //dd($corporate_staff_info);

            $this->staffModel->insert($corporate_staff_info);
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function corporateStaffAddForm($id)
    {
        $corporate_client = DB::table('ccm_corporateclient')->where('CCM_CLIENT_NO_PK', $id)->first();
        $gender = $this->getLookupListByCode("GENDER");
        $designation = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
        return template::loadview('admin.corporate.corporate_staff_add', [
            'gender' => $gender,
            'designation' => $designation,
            'ccm_client_no_pk' => $id,
            'corporate_client' => $corporate_client
        ]);
    }
    public function getStaffList(Request $request)
    {
        //  dd('test');

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        $table = 'ccm_corporatestaff_vw';
        $primaryKey = 'ccm_staff_no_pk';
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'ccm_staff_id', 'dt' => 1),
            array('db' => 'ccm_staff_name', 'dt' => 2),
            array('db' => 'designation_name', 'dt' => 3),
            array('db' => 'ccm_staff_dob', 'dt' => 4),
            array('db' => 'ccm_staff_contact', 'dt' => 5),
            array('db' => 'ccm_patient_no_fk', 'dt' => 6),
            array('db' => 'ccm_staff_no_pk', 'dt' => 7)
        );
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function editStaff($id)
    {
        $staff_record = DB::table('ccm_corporatestaff')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('ccm_staff_no_pk', $id)->first();
        // dd($staff_record);
        $gender = $this->getLookupListByCode("GENDER");
        $designation = Designation::where('status', '1')->select('designation_no_pk', 'designation_name')->orderBy('designation_name', 'asc')->get();
        return template::loadview('admin.corporate.corporate_staff_entry_edit_form', compact('staff_record', 'gender', 'designation'));
    }
    public function addStaffDependent($staff_no_pk)
    {
        $gender = $this->getLookupListByCode("GENDER");
        return template::loadview('admin.corporate.corporate_staff_dependent_entry_form', compact('staff_no_pk', 'gender'));
    }

    public function corporatePolicy()
    {
        return template::loadview('admin.corporate.corporate_policy');
    }
    public function storeCorporatePolicy(Request $request)
    {
        // dd($request->all());

        $validatedData = $request->validate([
            // 'code' => 'required',
            // 'name' => 'required',
            // 'address' => 'required',
            // 'phone' => 'required'
            // // 'Address' => 'required'

        ]);


        $auth_id = Auth::id();
        $id = $request->id;

        try {
            if($id == null){
                $sequence = DB::getSequence();
                $corporate_policy_no_pk_seq = $sequence->nextValue('corporate_policy_no_pk_seq');
            }else{
                $corporate_policy_no_pk_seq = $id;
            }

            $corporate_policy_info = [];
            $corporate_policy_info = [

                'corporate_policy_no_pk' => $corporate_policy_no_pk_seq,
                'corporatepolicy_code' => $request->corporateCode,
                'corporatepolicy_name' => $request->corporateName,
                'commission_percent' => $request->max_percent,
                'commission_taka' => $request->taka,
                'authorization_ind' => $request->has('authorization') ? 1 : 0,
                'authorization_code_ind' => $request->has('authorization_id') ? 1 : 0,
                'not_doctor_ind' => $request->has('not_doctor') ? 1 : 0,
                'signed_copy_ind' => $request->has('signed_copy') ? 1 : 0,
                'corporate_emp_id_ind' => $request->has('corporate_email_id') ? 1 : 0,
                'management_sms_ind' => $request->has('management_sms') ? 1 : 0,
                'management_email_ind' => $request->has('management_email') ? 1 : 0,
                'corporate_sms_ind' => $request->has('corporate_sms') ? 1 : 0,
                'staff_id_ind' => $request->has('staff_id') ? 1 : 0,
                'corporate_code_ind' => $request->has('corporate_code') ? 1 : 0,
                'corporate_email_ind' => $request->has('corporate_email') ? 1 : 0,
                'active_status_ind' => $request->has('active') ? 1 : 0,
                'status' => 1,

                'applied_consult_ind' => $request->consultation_ind,
                'applied_consult_percent' => $request->consultation_percent,
                'gen_billing_ind' => $request->general_billing_ind,
                'gen_billing_percent' => $request->general_billing,
                'applied_lab_percent' => $request->pathology,
                'applied_lab_ind' => $request->pathology_ind,
                'applied_rad_ind' => $request->radiology_ind,
                'applied_rad_percent' => $request->radiology,
                'applied_ipdbed_ind' => $request->ipd_bed_ind,
                'applied_ipdbed_percent' => $request->ipd_bed,
                'applied_ot_ind' => $request->ot_ind,
                'applied_ot_percent' => $request->ot,

                'au_entry_at' => date('Y-m-d'),
                'au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                'au_entry_session' => 'hospital',
            ];
            if ($id == null) {
                $corporate_policy_info['au_entry_by'] = $auth_id;
                //  dd($corporate_policy_info);

                $this->corporatePolicy->insert($corporate_policy_info);
            } else {
                $corporate_policy_info['au_update_by'] = $auth_id;
                $corporate_policy_info['au_update_at'] = date('Y-m-d');

                //  dd($corporate_policy_info);

                DB::table('ccm_corporatepolicy')->where('corporate_policy_no_pk', $id)->update($corporate_policy_info);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function editCorporatePolicy($id)
    {
        $policy_record = DB::table('ccm_corporatepolicy')->where('corporate_policy_no_pk', $id)->first();
        return template::loadview('admin.corporate.corporate_policy_edit_form', compact('policy_record'));
    }
    public function corporatePolicyList(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        //dd($hospital_id);
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        //$hospital_id";
        $table = 'ccm_corporatepolicy';
        $primarykey = 'corporate_policy_no_pk';
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'corporate_policy_no_pk', 'dt' => 1),
            array('db' => 'corporatepolicy_code', 'dt' => 2),
            array('db' => 'corporatepolicy_name', 'dt' => 3),
            array('db' => 'commission_percent', 'dt' => 4),
            array('db' => 'commission_taka', 'dt' => 5),
            array('db' => 'authorization_ind', 'dt' => 6),
            array('db' => 'authorization_code_ind', 'dt' => 7),
            array('db' => 'not_doctor_ind', 'dt' => 8),
            array('db' => 'signed_copy_ind', 'dt' => 9),
            array('db' => 'corporate_emp_id_ind', 'dt' => 10),
            array('db' => 'management_sms_ind', 'dt' => 11),
            array('db' => 'management_email_ind', 'dt' => 12),
            array('db' => 'corporate_sms_ind', 'dt' => 13),
            array('db' => 'staff_id_ind', 'dt' => 14),
            array('db' => 'corporate_code_ind', 'dt' => 15),
            array('db' => 'corporate_email_ind', 'dt' => 16),
            array('db' => 'active_status_ind', 'dt' => 17),
        );
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primarykey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function deleteCorporatePolicy(Request $request)
    {
        DB::table('ccm_corporatepolicy')->where('corporate_policy_no_pk', $request->id)->delete();
        return template::loadview('admin.corporate.corporate_policy');
    }
    
    public function showCorporatePolicy($id)
    {
    }
    public function corporateEntryStore(Request $request)
    {

        $validatedData = $request->validate([
            'code' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required'
            // 'Address' => 'required'

        ]);
        $id = $request->id;
        $auth_id = Auth::id();

        try {

            $sequence = DB::getSequence();
            $corporate_client_no_pk_seq = $sequence->nextValue('corporate_client_no_pk_seq');

            $corporate_client_info = [];
            $corporate_client_info = [


                'ccm_client_code' => $request->code,
                'ccm_client_name' => $request->name,
                'client_address' => $request->address,
                'contact_no' => $request->contact,
                'web' => $request->web,
                'land_phone' => $request->landPhone,
                'web' => $request->web,
                'phone' => $request->phone,
                'contact_person' => $request->contactPerson,
                'contact_mobile' => $request->contactMobile,
                'designation_no_fk' => $request->Designation,
                'official_email' => $request->officialEmail,
                'payment_ind' => $request->payment,
                'employee_listed_ind' => $request->employeeListed,
                'employee_id_ind' => $request->employeeID,
                'employee_approval_ind' => $request->employerApproval,
                'deposit_ind' => $request->deposit,
                'threshold_employee' => $request->thresholdEmployee,
                'threshold_company' => $request->thresholdCompany,
                'start_date' => $request->startDate,
                'expire_date' => $request->expiryDate,
                'active_status' => $request->active_status,
                'corporate_policy_no_fk' => $request->corporate_id,


                'status' => 1,
                'signatory_name' => $request->sgname,
                'signatory_designation' => $request->sgdesignation,
                'signatory_contact_number' => $request->sgphone,
                'contract_sign_date' => $request->csDate?date('Y-m-d', strtotime($request->csDate)):date('Y-m-d') ,
                //'delivery_assigned' => date('Y-m-d'),
                //'delivery_date' => date('Y-m-d', strtotime($request->date_pic)),
                'au_entry_at' => date('Y-m-d'),
                'au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                'au_entry_session' => 'hospital',
            ];

            // dd($corporate_client_info);
            if ($id == null) {
                $corporate_client_info['au_entry_by'] = $auth_id;
                $corporate_client_info['ccm_client_no_pk'] = $corporate_client_no_pk_seq;
                //dd($corporate_client_info);
                $response = $this->corporateModel->insert($corporate_client_info);
                // // dd($response);
                //  $last_id = $response->ccm_client_no_pk;
                //  dd($last_id);

                // //  $image_name = "";
                //  if ($files = $request->file('corporateImage')) {
                //      $image_name = $last_id . "." . $files->getClientOriginalExtension();
                //  }

                //  $update_image['logo'] = $image_name;
                //  $this->model2->update($update_image, $last_id);

            } else {
                $corporate_client_info['au_update_by'] = $auth_id;
                // DB::table('ccm_corporateclient')->where('ccm_client_no_pk', $id)->update($corporate_client_info);
                // $response = $this->corporateModel->insert($corporate_client_info);
                $this->corporateModel->update($corporate_client_info, $id);
            }
            // if ($files = $request->file('corporateImage')) {
            //     $this->uploadImages($files, $last_id, 'images/uploads/corporate_images/', 'images/uploads/corporate_images/thumb/');
            // }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function corporateInfoAutocomplete(Request $request)
    {
        $keyword = strtoupper($request->search_data);
        $ccm_client_info = db::table("ccm_corporateclient_vw")
            ->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name', 'contact_person', 'contact_mobile')
            ->whereraw(db::raw("upper(ccm_client_code) like '%$keyword%' or upper(ccm_client_name) like '%$keyword%' or contact_mobile like '%$keyword%' "))->get();

        $ccm_client_info_data = [];
        if (!empty($ccm_client_info)) {
            foreach ($ccm_client_info as $ccm_client) {
                $ccm_client_info_data[] = array(
                    'ccm_client_no_pk' => $ccm_client->ccm_client_no_pk,
                    'ccm_client_name' => $ccm_client->ccm_client_name,
                    //'company_name' => $ccm_client->company_name,
                    'ccm_client_code' => $ccm_client->ccm_client_code,
                    'contact_mobile' => $ccm_client->contact_mobile,
                    //'mobile1' => $ccm_client->mobile1,
                );
            }
            return $ccm_client_info_data;
        }
    }
    public function storeStaffDependent(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'Patient_ID' => 'required',
            'Patient_Name' => 'required',
            'DOB' => 'required',
            'Relation' => 'required',
            'Contact_Number' => 'required',
            'Gender' => 'required',
            'Age'

        ]);
        //$id = $request->id;
        $id = $request->id;
        $auth_id = Auth::id();

        try {
            $sequence = DB::getSequence();
            $ccm_staffdep_no_pk_seq = $sequence->nextValue('ccm_staffdep_no_pk_seq');
            $dependent_info = [];
            $dependent_info = [

                'ccm_staffdep_no_pk' => $ccm_staffdep_no_pk_seq,
                'patient_no_fk' => $request->Patient_ID,
                'ccm_staff_no_fk' => $request->staff_no_pk,
                'ccm_patient_name' => $request->Patient_Name,
                'ccm_dep_dob' => $request->DOB,
                'Age' => $request->Age,
                'gender_no_fk' => $request->Gender,
                'mobile' => $request->Contact_Number,
                'ccm_patient_relation' => $request->Relation,
                // 'web' => $request->web,
                // 'land_phone' => $request->landPhone,
                // 'web' => $request->web,
                // 'phone' => $request->phone,
                // 'contact_person' => $request->contactPerson,
                // 'contact_mobile' => $request->contactMobile,
                // 'designation_no_fk' => $request->Designation,
                // 'official_email' => $request->officialEmail,
                // 'payment_ind' => $request->payment,
                // 'employee_listed_ind' => $request->employeeListed,
                // 'employee_id_ind' => $request->employeeID,
                // 'employee_approval_ind' => $request->employerApproval,
                // 'deposit_ind' => $request->deposit,
                // 'threshold_employee' => $request->thresholdEmployee,
                // 'threshold_company' => $request->thresholdCompany,
                // 'start_date' => $request->startDate,
                // 'expire_date' => $request->expiryDate,
                // 'active_status' => $request->active_status,


                // 'status' => 1,
                //'delivery_assigned' => date('Y-m-d'),
                //'delivery_date' => date('Y-m-d', strtotime($request->date_pic)),
                'au_entry_at' => date('Y-m-d'),
                'au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                'au_entry_session' => 'hospital',
            ];
            if ($id == null) {
                $dependent_info['au_entry_by'] = $auth_id;
                $this->dependent->insert($dependent_info);
                // // dd($response);
                //  $last_id = $response->ccm_client_no_pk;
                //  dd($last_id);

                // //  $image_name = "";
                //  if ($files = $request->file('corporateImage')) {
                //      $image_name = $last_id . "." . $files->getClientOriginalExtension();
                //  }

                //  $update_image['logo'] = $image_name;
                //  $this->model2->update($update_image, $last_id);

            } else {
                $dependent_info['au_update_by'] = $auth_id;
                DB::table('ccm_corporatestaff_dep')->where('ccm_staffdep_no_pk', $id)->update($dependent_info);
            }
            // // if ($files = $request->file('corporateImage')) {
            // //     $this->uploadImages($files, $last_id, 'images/uploads/corporate_images/', 'images/uploads/corporate_images/thumb/');
            // // }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function getStaffDependentList(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        //dd($hospital_id);
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        //$hospital_id";
        $table = 'ccm_corporatestaff_dep';
        $primarykey = 'ccm_staffdep_no_pk';
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'ccm_patient_name', 'dt' => 1),
            array('db' => 'age', 'dt' => 2),
            array('db' => 'gender_no_fk', 'dt' => 3),
            array('db' => 'ccm_patient_relation', 'dt' => 4),
            array('db' => 'mobile', 'dt' => 5),
            array('db' => 'patient_no_fk', 'dt' => 6),
            array('db' => 'ccm_staffdep_no_pk', 'dt' => 7)
        );
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primarykey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function editDependent($id)
    {
        $dependent = DB::table('ccm_corporatestaff_dep')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('ccm_staffdep_no_pk', $id)->first();
        $gender = $this->getLookupListByCode("GENDER");
        return template::loadview('admin.corporate.corporate_staff_dependent_entry_form', compact('dependent', 'gender'));
    }







    // Added By 27.3.2022
    public function corporateWorklistSearch(Request $request)
    {
        // dd($request->all());
        $active_status = $request->active_status;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($active_status != "") ? " $clause active_status=$active_status" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(contract_sign_date) between TO_DATE('$date_from','MM/DD/YYYY') and TO_DATE('$date_to','MM/DD/YYYY')" : "";

        $work_list = DB::select("select * from ccm_corporateclient_vw   $sql_cond order by ccm_client_no_pk DESC");
        // dd($work_list);

        return template::loadview('admin.corporate.corporate_worklist', compact('work_list'));
    }

    public function corporateWorklistSearchPdf(Request $request)
    {
        // dd($request->all());
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $active_status = $request->active_status;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($active_status != "") ? " $clause active_status=$active_status" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(contract_sign_date) between TO_DATE('$date_from','MM/DD/YYYY') and TO_DATE('$date_to','MM/DD/YYYY')" : "";

        $work_list = DB::select("select * from ccm_corporateclient_vw   $sql_cond order by ccm_client_no_pk DESC");


        // foreach ($work_list as $row) {
        $title = 'corporate';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        // }

        // $pdf = PDF::loadView("admin.corporate.corporate_worklist_pdf", [
        //     'work_list' => $work_list, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details, 'active_status' => $active_status
        // ])->setPaper('a4', 'landscape');
        // return $pdf->download('corporate-worklist.pdf');

        if ($request->hdn_report_type == 'PDF') {
            $pdf = PDF::loadView("admin.corporate.corporate_worklist_pdf", [
                'work_list' => $work_list, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details, 'active_status' => $active_status
            ])->setPaper('a4', 'landscape');
            return $pdf->download('corporate-worklist.pdf');
        }
        if ($request->hdn_report_type == 'EXCEL') {
            $pdf = ['work_list' => $work_list, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details, 'active_status' => $active_status
        ];
            $fileToExport = "corporate-worklist";
            $html = View("admin.corporate.corporate_worklist_pdf")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        }
    }



    // Policy Part
    public function corporateItemTypePolicy($id,$type="")
    {
        $refdata = DB::table('ccm_corporatepolicy')->where('corporate_policy_no_pk', $id)->first();
        // dd($refdata);
        $discount_policy =[];
        $ref_policy =[];
        if ($type=="DISCOUNTPOLICY") {
            $discount_policy = DB::table('sysc_discountpolicy_itemtype')->where('discountpolicy_no_fk', $id)->orderBy('au_entry_at', 'DESC')->get();
        }else{
            $ref_policy = DB::table('ccm_corporatepolicy_itemtype_vw')->where('corporate_policy_no_fk', $id)->orderBy('au_entry_at', 'DESC')->get();
        }
        
        // $item_type=DB::table('sysc_itemtype_workflow')->select('workflow_code')->where('service_billing_ind',1)->where('status',1)->orderBy('workflow_code','asc')->get()->toArray();
        $item_type = $this->getLookupListByCode("ITEMTYPE");
        // dd( $item_type);
        return Template::loadview('admin.corporate.item_type.item_type_policy', ['id'=>$id,'ref_policy' => $ref_policy, 'refdata' => $refdata,'discount_policy'=>$discount_policy,'item_type_data'=>$item_type,'type'=>$type]);
    }



    public function corporateItemTypeStore(Request $request)
    {
        $id = $request->item_type_no_pk;
        // dd( $request->ref_policy_pk);
        // dd($id);
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();

        DB::beginTransaction();
        $sequence = DB::getSequence();
        $dis_no_pk_seq = $sequence->nextValue('dispolicy_itemtype_no_pk_seq');
        try {
           
            if ($request->dis_type=="DISCOUNTPOLICY") {
                $data = [
                    'discountpolicy_no_fk' => $request->ref_policy_pk,
                    'clinic_percent' => $request->sec_ref,
                    'equal_percent' => $request->comission,
                    'item_type' => $request->item_type,
                    'au_entry_hospital_pk_no'   =>  $ses_hospital_id,
                    'au_entry_session' => 'session',
                ];
                
                if ($id == "") {
    
                    $data['dispolicy_itemtype_no_pk'] = $dis_no_pk_seq;
                    $data['au_entry_by'] = $auth_id;
                    $data['au_entry_at'] = date('Y-m-d');
                    // dd($request->all(),$data);
                    DB::table('sysc_discountpolicy_itemtype')->insert( $data);
                } else {
                    $data['au_update_by'] = $auth_id;
                    DB::table('sysc_discountpolicy_itemtype')->where('dispolicy_itemtype_no_pk',$id)->update( $data);
                }
            }else{
                $data = [
                    'referral_percent' => $request->def_ref,
                    'equal_percent' => $request->def_agent,
                    'clinic_percent' => $request->sec_ref,
                    'equal_percent' => $request->comission,
                    'corporate_policy_no_fk' => $request->ref_policy_pk,
                    'item_type' => $request->item_type,
                    'au_entry_hospital_pk_no'   =>  $ses_hospital_id,
                    'au_entry_session' => 'session',
                ];
    
                if ($id == "") {
    
                    $data['au_entry_by'] = $auth_id;
                    $this->CitemType->create($data);
                } else {
                    $data['au_update_by'] = $auth_id;
                    $this->CitemType->update($data, $id);
                }
            }
            


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function corporateItemWisePolicyEdit($id, Request $request)
    {
        $ItemWiseEditdata = DB::table('sysc_referralpolicy_itemtype_vw')->where('REFPOLICY_ITEMTYPE_NO_PK', $id)->first();
        $ref_policy = DB::table('sysc_referralpolicy_itemtype_vw')->where('referralpolicy_no_fk', $id)->orderBy('au_entry_at', 'DESC')->get();
        $refdata = DB::table('sysc_referralpolicy')->where('referralpolicy_no_pk', $ItemWiseEditdata->referralpolicy_no_fk)->first();
        return Template::loadview("admin.corporate.item_type.item_type_policy", ['ItemWiseEditdata' => $ItemWiseEditdata, 'refdata' => $refdata, 'ref_policy' => $ref_policy]);
    }

    public function itemTypePolicyDelete(Request $request){
        $typeId=$request->typeIt;
         $deleteStatus=0;
        if (DB::table('ccm_corporatepolicy_itemtype')->where('corppolicy_itemtype_no_pk',$typeId)->delete()) {
            $deleteStatus=1;
        }
        return response()->json($deleteStatus);
    }


    // department POlicy
    public function corporateDepartmentWisePolicy($id)
    {
        $refdata = DB::table('ccm_corporatepolicy')->where('corporate_policy_no_pk', $id)->first();
        // dd($refdata);
        $service_unit = DB::table('sysc_serviceunit')->where('status', 1)->get();
        $dep_policy = DB::table('ccm_corporatepolicy_su_vw')->where('corporate_policy_no_fk', $id)->orderBy('au_entry_at', 'DESC')->get();
        // dd($dep_policy);
        return Template::loadview('admin.corporate.department.department_type_wise_policy', ['refdata' => $refdata, 'dep_policy' => $dep_policy, 'service_unit' => $service_unit]);
    }
    public function corporateUnitType(Request $request)
    {
        $id = $request->ref_su_policy_pk;
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        try {
            $data = [
                'referral_percent' => $request->def_ref,
                'clinic_percent' => $request->def_agent,
                'default_2nd_referral_percent' => $request->sec_ref,
                'equal_percent' => $request->comission,
                'corporate_policy_no_fk' => $request->ref_policy_pk,
                // 'referralpolicy_su_no_pk' => $request->ref_su_policy_pk,
                'su_no_fk' => $request->su_type,
                'au_entry_hospital_pk_no'   => $ses_hospital_id,
                'au_entry_session' => 'session',
                // 'au_entry_at' => date('Y-m-d'),
            ];
            // dd($data);

            if ($id == "") {

                $data['au_entry_by'] = $auth_id;
                $this->Csu->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->Csu->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function corporateDeptWisePolicyEdit($id, Request $request)
    {
        $DeptWiseEditdata = DB::table('SYSC_REFERRALPOLICY_SU_VW')->where('REFERRALPOLICY_SU_NO_PK', $id)->first();

        $refdata = DB::table('sysc_referralpolicy')->where('referralpolicy_no_pk', $DeptWiseEditdata->referralpolicy_no_fk)->first();
        $dep_policy = DB::table('sysc_referralpolicy_su_vw')->where('referralpolicy_no_fk', $DeptWiseEditdata->referralpolicy_no_fk)->orderBy('au_entry_at', 'DESC')->get();
        $service_unit = DB::table('sysc_serviceunit')->where('status', 1)->get();

        return Template::loadview("admin.pcrm.referral.department_type_wise_policy", ['DeptWiseEditdata' => $DeptWiseEditdata, 'service_unit' => $service_unit, 'refdata' => $refdata, 'dep_policy' => $dep_policy]);
    }


    // item wise Policy
    public function corporateItemWisePolicy($id)
    {
        $refdata = DB::table('ccm_corporatepolicy')->where('corporate_policy_no_pk', $id)->first();
        $item_policy_data = DB::table('ccm_corporatepolicy_item_vw')->where('corporate_policy_no_fk', $id)->orderBy('au_entry_at', 'DESC')->get();
        // dd($id ,$item_policy_data);
        return Template::loadview('admin.corporate.item.item_policy', ['refdata' => $refdata, 'item_policy_data' => $item_policy_data]);
    }
    public function corporateItemWiseDataStore(Request $request)
    {
        // dd($request->all());
        $id = $request->ref_policy_fk;
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        DB::beginTransaction();
        try {
            $data = [
                'referral_percent' => $request->def_ref,
                'clinic_percent' => $request->def_agent,
                // 'default_2nd_referral_percent' => $request->sec_ref,
                'equal_percent' => $request->comission,
                'corporate_policy_no_fk' => $request->ref_policy_pk,
                'item_no_fk' => $request->item_number_cor,
                'commission_taka' => $request->comission_tk,
                'exclude_ind' => $request->exclude,
                'status' => $request->active,

                'au_entry_hospital_pk_no'   => $ses_hospital_id,
                'au_entry_session' => 'session',
                // 'au_entry_at' => date('Y-m-d'),
            ];
            // dd($data);

            if ($id == "") {

                $data['au_entry_by'] = $auth_id;
                $this->Citem->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->Citem->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }









    // Reports
    public function corporateSalesSummary()
    {
        $type = 'SUMMARY';
        return Template::loadView("admin.corporate.reports.corporate_summary", ['type' => $type]);
    }
    public function corporateSalesDetails()
    {
        $corporate = db::table('ccm_corporateclient')
            ->select('ccm_client_no_pk', 'ccm_client_name', 'active_status', 'au_entry_at')
            ->where('active_status', '1')
            ->get();
        // dd($corporate->all());
        $type = 'DETAILS';
        return Template::loadView("admin.corporate.reports.corporate_details", ['type' => $type, 'stock_data' => $corporate]);
    }

    public function corporateStockLedger()
    {
        $corporate = db::table('ccm_corporateclient')->select('ccm_client_no_pk', 'ccm_client_name')->get();
        return Template::loadView("admin.corporate.reports.stock_ledger", ['stock_data' => $corporate]);
    }

    public function corporateWorklistSalesSearch(Request $request)
    {

        $type = $request->type;
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $date_from = $request->search_date_from;
        $date_to = $request->search_date_to;
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));
        } else {
            $date_from = "";
            $date_to = "";
        }
        $corporate = '';
        if ($request->corporate_id != "") {
            $corporate = $request->corporate_id;
        }
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($corporate != "") ? " $clause  REG.CCM_CLIENT_NO_FK = $corporate" : "";

        if ($type == 'DETAILS') {
            // $report_data = DB::select("select * from  ccm_salesvoucher_dt_vw LEFT JOIN PATIENT_INFO_VW on ccm_salesvoucher_dt_vw.PATIENT_NO_FK = PATIENT_INFO_VW.PATIENT_NO_PK $sql_cond  order By ccm_salesvoucher_dt_vw.invoice_code DESC");
            // dd($report_data);

            $report_data = DB::select("SELECT invoice_no_pk,
                   invoice_code,
                   invoice_date,
                   ccm_client_no_fk,
                   cc.ccm_client_name,
                   reg.patient_code,
                   patient_name,
                   pat_age (dob, TRUNC (invoice_date)) age,
                   reg.mobile1,
                   passport_no,
                   ccm_client_code,
                   SUM (LEDGER_AMT_SALES) net_sales,
                   SUM (LEDGER_AMT_PAYMENT) collection,
                   SUM (LEDGER_AMT_DISCOUNT) discount,
                   CASE
                      WHEN SUM (LEDGER_AMT_SALES)
                           - (SUM (LEDGER_AMT_PAYMENT) + SUM (LEDGER_AMT_DISCOUNT)) > 0
                      THEN
                         SUM (LEDGER_AMT_SALES)
                         - (SUM (LEDGER_AMT_PAYMENT) + SUM (LEDGER_AMT_DISCOUNT))
                      ELSE
                         0
                   END
                      due,
                   COUNT (DISTINCT reg.patient_code) patient_count
              FROM finc_invoicemst mst,
                   patn_registration reg,
                   ccm_corporateclient cc,
                   finc_ledgermst lmst
             WHERE     mst.patient_no_fk = reg.patient_no_pk
                   AND reg.ccm_client_no_fk = cc.ccm_client_no_pk
                   AND mst.invoice_no_pk = lmst.invoice_no_fk
                   $sql_cond
          GROUP BY invoice_no_pk,
                   invoice_code,
                   invoice_date,
                   ccm_client_no_fk,
                   cc.ccm_client_name,
                   reg.patient_code,
                   patient_name,
                   pat_age (dob, TRUNC (invoice_date)),
                   reg.mobile1,
                   passport_no,
                   ccm_client_code
          ORDER BY 3");
        } elseif ($type == 'SUMMARY') {
            $report_data = DB::select("select * from ccm_salessummary_dt_vw $sql_cond order By invoice_date DESC");
        }
        // echo "select * from  ccm_salesvoucher_dt_vw $sql_cond order By invoice_code DESC";

        return Template::loadView("admin.corporate.reports.corporate_data", ['report_data' => $report_data, 'po_hospital_details' => $po_hospital_details,  'type' => $type]);
    }

    public function corporateWorklistSalesSearchPdf(Request $request)
    {
        // dd($request->all());
        $type = $request->type;
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $date_from = $request->search_date_from;
        $date_to = $request->search_date_to;
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {
            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));
        } else {
            $date_from = "";
            $date_to = "";
        }
        $corporate = '';
        $corporate_name = '';
        if ($request->corporate_id != "") {
            $corporate = $request->corporate_id;
            $corporate_name = DB::table('ccm_corporateclient')->select('ccm_client_name')->where('ccm_client_no_pk', $corporate)->first()->ccm_client_name;
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        // COR_CLIENT_NO_FK
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($corporate != "") ? " $clause reg.ccm_client_no_fk = $corporate" : "";

        if ($type == 'DETAILS') {
            $report_data = DB::select("SELECT invoice_no_pk,
            invoice_code,
            invoice_date,
            ccm_client_no_fk,
            cc.ccm_client_name,
            reg.patient_code,
            patient_name,
            pat_age (dob, TRUNC (invoice_date)) age,
            reg.mobile1,
            passport_no,
            ccm_client_code,
            SUM (LEDGER_AMT_SALES) net_sales,
            SUM (LEDGER_AMT_PAYMENT) collection,
            SUM (LEDGER_AMT_DISCOUNT) discount,
            CASE
               WHEN SUM (LEDGER_AMT_SALES)
                    - (SUM (LEDGER_AMT_PAYMENT) + SUM (LEDGER_AMT_DISCOUNT)) > 0
               THEN
                  SUM (LEDGER_AMT_SALES)
                  - (SUM (LEDGER_AMT_PAYMENT) + SUM (LEDGER_AMT_DISCOUNT))
               ELSE
                  0
            END
               due,
            COUNT (DISTINCT reg.patient_code) patient_count
       FROM finc_invoicemst mst,
            patn_registration reg,
            ccm_corporateclient cc,
            finc_ledgermst lmst
      WHERE     mst.patient_no_fk = reg.patient_no_pk
            AND reg.ccm_client_no_fk = cc.ccm_client_no_pk
            AND mst.invoice_no_pk = lmst.invoice_no_fk
            $sql_cond
   GROUP BY invoice_no_pk,
            invoice_code,
            invoice_date,
            ccm_client_no_fk,
            cc.ccm_client_name,
            reg.patient_code,
            patient_name,
            pat_age (dob, TRUNC (invoice_date)),
            reg.mobile1,
            passport_no,
            ccm_client_code
   ORDER BY 3");
        } elseif ($type == 'SUMMARY') {
            $report_data = DB::select("select * from ccm_salessummary_dt_vw $sql_cond order By invoice_date DESC");
        }
        // echo "select * from  ccm_salesvoucher_dt_vw $sql_cond order By invoice_code DESC";



        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $print_type = $request->print_type;
        // if ($request->print_type == "PDF") {
        //     $pdf = PDF::loadView("admin.corporate.reports.corporate_pdf", ['report_data' => $report_data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'type' => $type, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'landscape');
        //     return $pdf->download('Corporate-report ' . $type . '.pdf');
        // }


        if ($request->print_type == "EXCEL") {
            $pdf = ['report_data' => $report_data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'type' => $type, 'po_hospital_details' => $po_hospital_details, 'print_type' => $print_type, 'corporate_name' => $corporate_name];
            $fileToExport = "Corporate-report " . $type;
            $html = View('admin.corporate.reports.corporate_pdf')->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        } else {
            //  return    view("admin.corporate.reports.corporate_pdf", ['report_data' => $report_data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'type' => $type, 'po_hospital_details' => $po_hospital_details]);
            $pdf = PDF::loadView("admin.corporate.reports.corporate_pdf", ['report_data' => $report_data, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'type' => $type, 'po_hospital_details' => $po_hospital_details, 'print_type' => $print_type, 'corporate_name' => $corporate_name])->setPaper('a4', 'landscape');
            return $pdf->download('Corporate-report ' . $type . '.pdf');
        }
    }



    // Stock Ledger

    public function corporateWorklistStockSearch(Request $request)
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $corporate_id = $request->corporate_id;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($corporate_id != "") ? " $clause cor_client_no_fk=$corporate_id" : "";

        $report_data = DB::select("select * from  ccm_ledger_vw $sql_cond");

        return Template::loadView("admin.corporate.reports.stock_ledger_data", ['report_data' => $report_data, 'po_hospital_details' => $po_hospital_details]);
    }

    public function corporateWorklistStockSearchPdf(Request $request)
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $corporate_id = $request->corporate_id;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($corporate_id != "") ? " $clause cor_client_no_fk=$corporate_id" : "";

        $report_data = DB::select("select * from  ccm_ledger_vw $sql_cond");

        // echo "select * from  ccm_ledger_vw $sql_cond";
        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();



        if ($request->print_type == "EXCEL") {
            $pdf = ['report_data' => $report_data, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no];
            $fileToExport = "stock-ledger-report";
            $html = View('admin.corporate.reports.stock_ledger_pdf')->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        } else {
            $pdf = PDF::loadView("admin.corporate.reports.stock_ledger_pdf", ['report_data' => $report_data, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no])->setPaper('a4', 'landscape');
            return $pdf->download('Stock-ledger-report.pdf');
        }

        // return Template::loadView("admin.corporate.reports.stock_ledger_data", ['report_data' => $report_data, 'po_hospital_details' => $po_hospital_details]);
    }
    public function getCorporateList(Request $request)
    {
        if ($request->type== 'INSURANCE') {
            $corporate = DB::table('ccm_corporateclient')->where('payer_ind', 1)->get();
        }
        if ($request->type == 'COMPANY') {
            $corporate = DB::table('ccm_corporateclient')->where('insurance_ind', 1)->get();
        }
        if ($request->type == 'DIRECT_PAT') {
            $corporate = DB::table('ccm_corporateclient')->where('direct_pat_ind', 1)->get();
        }
        $html ='';
        if (!empty($corporate)) {
            foreach ($corporate as $cor) {
                $html .= "   <option value='" . $cor->ccm_client_no_pk . "'>" . $cor->ccm_client_name . "</option>";
            }
        }
        return $html;
    }


    //corporate Bill
    public function corporateBill(){
        return Template::loadView("admin.corporate.corporate_form_kbmh",[
            'companies' => DB::table('ccm_corporateclient')->where('status',1)->get(),
        ]);
    }

    public function storeCorporateBill(Request $request)
    {
        $id = $request->id;
        $auth_id = Auth::id();
        DB::beginTransaction();
        try {
            $service_id = array_filter($request->service_id);
            $arry_val = array_values(array_filter($service_id));
            for ($i = 0; $i < count($arry_val); $i++) {
                $data = [
                    'test_result' =>  $result_txt[$i],
                    'default_ind' =>  $defult_ind[$i],
                    'status' =>  $defult_ind[$i],
                    'au_entry_by' =>  Auth::id(),
                    // 'au_entry_at' => date('Y-m-d'),
                    'au_entry_session' =>  'session',
                    'au_entry_hospital_pk_no' =>  141,
                    'teststruct_no_fk' =>  $item_id[1],
                    'item_no_fk' =>  $item_id[0],
                    'sl_no' =>  $item_id[3],
                ];
                $this->DefaultAttributeValueList->create($data);
            }
            // dd($data);

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }


     //Cheque Bill

      //    Added By Nazmul 30/06/2021
    public function chequeInfoAutocomplete(Request $request)
    {
        return $this->getChequeInfoDetails($request);
    }

    public function chequeBill(){

        $today = date('Y-m-d');
        $hospital_id = \Illuminate\Support\Facades\Session::get('user.ses_hospital_no_pk');

        return Template::loadView("admin.corporate.chaque",[
            'cheques' => DB::table('acc_chequeprint_vw a')->leftJoin('wsec_user w', 'w.user_no_pk', '=', 'a.AU_ENTRY_BY')
            ->where('a.status', '1')
            // ->where('chq_date', '=', date('Y-m-d', strtotime($today)))
            ->where(DB::raw('trunc(a.au_entry_at)'), date('Y-m-d', strtotime($today)))
            ->orderBy('a.acc_chequeprint_no_pk', 'asc')->get(),
            'PayToNames' => DB::table('acc_chequeprint_vw')->select('chq_pay_to')->groupBy("chq_pay_to")->orderBy("chq_pay_to", 'asc')->get(),
            'BankInfo' =>DB::table('sysc_lookupdata_vw')->where('lookup_code', '=', 'BANK')->where('au_entry_hospital_pk_no', '=', $hospital_id)->get(),

        ]);
    }

    public function storeCheque(Request $request)
    {

        $id = $request->id;
        $auth_id = Auth::id();
        DB::beginTransaction();
        $sequence = DB::getSequence();
        $acc_chequeprint_no_pk = $sequence->nextValue('acc_chequeprint_no_pk_seq');
        try {
            $data = [
                'chq_date' => $request->cheque_dt ? date('Y-m-d', strtotime($request->cheque_dt)) : "",
                'chq_pay_to' => $request->cheque_no,
                'chq_amount' => $request->cheque_amount,
                'chq_amount_text' => $request->sum_of_tk,
                'chq_bank_name' => $request->bank_name,
                'account_number' => $request->acc_id,
                'chq_account_pay_ind' => $request->acc_pay,
                'remarks' => $request->remarks,
                'status' => 1,
            ];

            if ($id == null) {

                $data['acc_chequeprint_no_pk'] = $acc_chequeprint_no_pk;
                $data['au_entry_by'] = $auth_id;
                $data['au_entry_at'] =  date('Y-m-d h:i:s');
                $data['au_entry_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');

                $response = $this->Cheque->create($data);

            } else {
                $data['au_update_by'] = $auth_id;
                $data['au_update_at'] =  date('Y-m-d h:i:s');
                $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');

                DB::table('acc_chequeprint')
                ->where('acc_chequeprint_no_pk', $id)
                ->update($data);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }



    public function editAccountsCheque($id)
    {
            $cheque_id = $id;

            $hospital_id = Session::get('user.ses_hospital_no_pk');
           $chequeData =  DB::table('acc_chequeprint')->where('acc_chequeprint_no_pk', $cheque_id)->first();
           $BankInfo = DB::table('sysc_lookupdata_vw')->where('lookup_code', '=', 'BANK')->where('au_entry_hospital_pk_no', '=', $hospital_id)->get();

         return Template::loadView("admin.corporate.edit_cheque", ['chequeData' => $chequeData, 'BankInfo' => $BankInfo]);
    }

    public function upadteAccountsCheque(Request $request)
    {
        // dd($request->acc_chequeprint_no_pk);
        try {
            DB::table('ipd_nicu_chart')
                ->where('nicu_no_pk', $request->nicu_id)
                ->update([
                    'notes' => $request->notes,
                    'au_update_at' => date('Y-m-d'),
                    'au_update_by' => Auth::id(),
                    'au_update_hospital_no_fk' => Session::get('user.ses_hospital_no_pk'),
                ]);
            $this->message = ['msg' => 'Updated Successfully', 'title' => 'Success',];
        } catch (\Exception $e) {

            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($this->message);
    }


    public function chequePrint($cheque_id)
    {
        // dd($cheque_id);

        $dt = explode('~',$cheque_id);
        // dd($dt);
        $ch_id = $dt[0];
        $print_id = $dt[1] == null?0:$dt[1];

          // Print update save Start
          $data = [
            'print_count' => $print_id + 1,
        ];
        DB::table('acc_chequeprint')->where('acc_chequeprint_no_pk', $ch_id)->update($data);
        // Print update save end
        $chedetails = DB::table('acc_chequeprint_vw')->where('acc_chequeprint_no_pk', $ch_id)->first();
        // dd(str_replace('-', '',substr($chedetails->chq_date, 0, -9)));
        if($chedetails->chq_bank_name == "One Bank Limited"){
            $pdf = PDF::loadView("admin.corporate.check_print",[
                'chedetails' => $chedetails
             ])->setPaper([0, 0, 3.5 * 72, 10 * 72], 'landscape');
        }elseif($chedetails->chq_bank_name == "Premier Bank Limited"){

            $pdf = PDF::loadView("admin.corporate.check_print_premier",[
                'chedetails' => $chedetails
             ])->setPaper([0, 0, 3.5 * 72, 10 * 72], 'landscape');
        }else{
            $pdf = PDF::loadView("admin.corporate.check_print",[
                'chedetails' => $chedetails
             ])->setPaper([0, 0, 3.5 * 72, 10 * 72], 'landscape');
        }

        return $pdf->stream('cheque_Print.pdf');
    }
    public function chequePrintHp($cheque_id)
    {
        // dd($cheque_id);

        $dt = explode('~',$cheque_id);
        // dd($dt);
        $ch_id = $dt[0];
        $print_id = $dt[1] == null?0:$dt[1];

          // Print update save Start
        $data = [
            'print_count' => $print_id + 1,
        ];
        DB::table('acc_chequeprint')->where('acc_chequeprint_no_pk', $ch_id)->update($data);
        // Print update save end
        $chedetails = DB::table('acc_chequeprint_vw')->where('acc_chequeprint_no_pk', $ch_id)->first();
        // dd(str_replace('-', '',substr($chedetails->chq_date, 0, -9)));

        if($chedetails->chq_bank_name == "One Bank Limited"){

            $pdf = PDF::loadView("admin.corporate.check_print_hp",[
                'chedetails' => $chedetails
             ])->setPaper([0, 0, 3.5 * 72, 10 * 72], 'landscape');
        }elseif($chedetails->chq_bank_name == "Premier Bank Limited"){

            $pdf = PDF::loadView("admin.corporate.check_print_hp_premier",[
                'chedetails' => $chedetails
             ])->setPaper([0, 0, 3.5 * 72, 10 * 72], 'landscape');
        }else{
            $pdf = PDF::loadView("admin.corporate.check_print_hp",[
                'chedetails' => $chedetails
             ])->setPaper([0, 0, 3.5 * 72, 10 * 72], 'landscape');
        }

        return $pdf->stream('cheque_Print_hp.pdf');
    }

    public function chequePrintAll(Request $request)
    {
          DB::table('acc_chequeprint')->whereIn('acc_chequeprint_no_pk', $request->cheque_item)->update( ['print_count' => 1]);

          $chedetails = DB::table('acc_chequeprint_vw')->whereIn('acc_chequeprint_no_pk', $request->cheque_item)->orderBy('acc_chequeprint_no_pk', 'asc')->get();

          $pdf = PDF::loadView("admin.corporate.check_print_all",[
              'chedetails' => $chedetails
           ])->setPaper([0, 0, 3.5 * 72, 10 * 72], 'landscape');
          return $pdf->stream('check_print_all.pdf');

    }

    public function accountsChequeReportSearch(Request $request)
    {
        $from_date = date("d-m-Y", strtotime($request->from_date));
        $to_date = date("d-m-Y", strtotime($request->to_date));
        // dd($from_date);
        $bank_name = isset($request->bank_name) ? "'".$request->bank_name."'" : "";
        $pay_to = isset($request->pay_to) ? "'".$request->pay_to."'" : "";
        $be_printed = isset($request->be_printed) ? "'".$request->be_printed."'" : "";
        $printed = isset($request->printed) ? "'".$request->printed."'" : "";
        $bank_name_con = ($bank_name != "") ? "   and a.chq_bank_name = $bank_name" : "";
        $pay_to_con = ($pay_to != "") ? "  and a.chq_pay_to = $pay_to" : "";
        if($be_printed != "" && $printed != ""){
            $be_printed_con = ($be_printed != "") ? "  and a.print_count IS NULL or a.print_count >= 1" : "";
            $printed_con = " ";
        }else{
            $be_printed_con = ($be_printed != "") ? "  and a.print_count IS NULL" : "";
            $printed_con = ($printed != "") ? "  and a.print_count >= 1 " : "";
        }
        // $from_date_cond = ($request->from_date != "") ? " and a.chq_date between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY') " : "";
        $from_date_cond = ($request->from_date != "") ? " and trunc(a.au_entry_at) between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY') " : "";

        $cheques = DB::select("select a.chq_account_pay_ind, a.remarks, a.acc_chequeprint_no_pk, a.chq_date, a.chq_pay_to, a.chq_amount,
        a.chq_amount_text, a.print_count, a.chq_bank_name, a.account_number, a.au_entry_by, w.user_no_pk
        from acc_chequeprint_vw a
        left join wsec_user w ON w.user_no_pk = a.au_entry_by where a.acc_chequeprint_no_pk IS NOT NULL and a.status ='1'
        $bank_name_con $pay_to_con $from_date_cond $be_printed_con $printed_con order by a.acc_chequeprint_no_pk asc");

        return Template::loadview("admin.corporate.accounts_cheque_list", ['cheques' => $cheques]);
    }

    public function cancelAccountsCheque(Request $request)
    {
        // dd($request->acc_chequeprint_no_pk);
        try {
            DB::table('acc_chequeprint')
                ->where('acc_chequeprint_no_pk', $request->acc_chequeprint_no_pk)
                ->update([
                    'status' => 0,
                    'au_update_at' => date('Y-m-d'),
                    'au_update_by' => Auth::id(),
                    'au_update_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                ]);
            $this->message = ['msg' => 'Accounts Cheque cancelled Successfully', 'title' => 'Success',];
        } catch (\Exception $e) {

            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($this->message);
    }
    public function accountsChequeReportPrint(Request $request)
    {
        $from_date = date("d-m-Y", strtotime($request->from_date));
        $to_date = date("d-m-Y", strtotime($request->to_date));
        $bank_name = isset($request->bank_name) ? "'".$request->bank_name."'" : "";
        $pay_to = isset($request->pay_to) ? "'".$request->pay_to."'" : "";
        $be_printed = isset($request->be_printed) ? "'".$request->be_printed."'" : "";
        $printed = isset($request->printed) ? "'".$request->printed."'" : "";
        $bank_name_con = ($bank_name != "") ? "   and a.chq_bank_name = $bank_name" : "";
        $pay_to_con = ($pay_to != "") ? "  and a.chq_pay_to = $pay_to" : "";
        if($be_printed != "" && $printed != ""){
            $be_printed_con = ($be_printed != "") ? "  and a.print_count IS NULL or a.print_count >= 1" : "";
            $printed_con = " ";
        }else{
            $be_printed_con = ($be_printed != "") ? "  and a.print_count IS NULL" : "";
            $printed_con = ($printed != "") ? "  and a.print_count >= 1 " : "";
        }
        // $from_date_cond = ($request->from_date != "") ? " and a.chq_date between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY') " : "";
        $from_date_cond = ($request->from_date != "") ? " and trunc(a.au_entry_at) between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY') " : "";



        $cheques = DB::select("select a.chq_account_pay_ind, a.remarks, a.acc_chequeprint_no_pk, a.chq_date, a.chq_pay_to, a.chq_amount,
        a.chq_amount_text, a.print_count, a.chq_bank_name, a.account_number, a.au_entry_by, w.user_no_pk from acc_chequeprint_vw a
        left join wsec_user w ON w.user_no_pk = a.au_entry_by where a.acc_chequeprint_no_pk IS NOT NULL and a.status ='1'
         $bank_name_con $pay_to_con  $from_date_cond $be_printed_con $printed_con order by a.acc_chequeprint_no_pk asc");
        $to_date = date("d-m-Y", strtotime($request->to_date));
// dd($from_date, $to_date);
        $title = "Accounts Cheque Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $pdf = PDF::loadView("admin.corporate.accounts_cheque_report_print", ["type" => "Cheque Register", "po_hospital_details" => $po_hospital_details, 'value' => $cheques,'cheques' => $cheques, 'from_date' => $from_date, 'to_date' => $to_date, 'bank_name' => $bank_name_con, 'pay_to' => $pay_to_con])->setPaper('a4', 'protrait');
         return $pdf->stream('accounts_cheque_report_print.pdf');

    }

    public function accountsChequeReportPrintExcel(Request $request)
    {
        $from_date = date("d-m-Y", strtotime($request->from_date));
        $to_date = date("d-m-Y", strtotime($request->to_date));
        $bank_name = isset($request->bank_name) ? "'".$request->bank_name."'" : "";
        $pay_to = isset($request->pay_to) ? "'".$request->pay_to."'" : "";
        $be_printed = isset($request->be_printed) ? "'".$request->be_printed."'" : "";
        $printed = isset($request->printed) ? "'".$request->printed."'" : "";
        $bank_name_con = ($bank_name != "") ? "   and a.chq_bank_name = $bank_name" : "";
        $pay_to_con = ($pay_to != "") ? "  and a.chq_pay_to = $pay_to" : "";
        if($be_printed != "" && $printed != ""){
            $be_printed_con = ($be_printed != "") ? "  and a.print_count IS NULL or a.print_count >= 1" : "";
            $printed_con = " ";
        }else{
            $be_printed_con = ($be_printed != "") ? "  and a.print_count IS NULL" : "";
            $printed_con = ($printed != "") ? "  and a.print_count >= 1 " : "";
        }
        // $from_date_cond = ($request->from_date != "") ? " and a.chq_date between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY') " : "";
        $from_date_cond = ($request->from_date != "") ? " and trunc(a.au_entry_at) between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY') " : "";

        $cheques = DB::select("select a.chq_account_pay_ind, a.remarks, a.acc_chequeprint_no_pk, a.chq_date, a.chq_pay_to, a.chq_amount,
        a.chq_amount_text, a.print_count, a.chq_bank_name, a.account_number, a.au_entry_by, w.user_no_pk from acc_chequeprint_vw a
        left join wsec_user w ON w.user_no_pk = a.au_entry_by where a.acc_chequeprint_no_pk IS NOT NULL and a.status ='1'
         $bank_name_con $pay_to_con $from_date_cond $be_printed_con $printed_con order by a.acc_chequeprint_no_pk asc");

        $title = "Accounts Cheque Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        // $pdf = PDF::loadView("admin.corporate.accounts_cheque_report_print", ["type" => "Cheque Information", "po_hospital_details" => $po_hospital_details, 'value' => $cheques,'cheques' => $cheques, 'from_date' => $from_date, 'to_date' => $to_date, 'bank_name' => $bank_name_con, 'pay_to' => $pay_to_con])->setPaper('a4', 'landscape');
        // return $pdf->stream('accounts_cheque_report_print.pdf');

        $pdf = ["type" => "Cheque Register", "po_hospital_details" => $po_hospital_details, 'value' => $cheques,'cheques' => $cheques, 'from_date' => $from_date, 'to_date' => $to_date, 'bank_name' => $bank_name_con, 'pay_to' => $pay_to_con];
        $fileToExport = "accounts_cheque_report_print_excel";
        $html = View("admin.corporate.accounts_cheque_report_print_excel")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
    }

    public function chequePrintTest()
    {
        $pdf = PDF::loadView("admin.corporate.check_print_test", [
         ])->setPaper([0, 0, 3.5 * 72, 10 * 72], 'landscape');
        return $pdf->stream('cheque_Print_test.pdf');
    }

    // marketing Report
    public function corporateMarketingReport()
    {
        $dept = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        return Template::loadView("admin.corporate.reports.corporate_marketing_report",['dept'=>$dept]);
    }

    public function corporateMarketingReportData(Request $request)
    {
        // dd($request->all());
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $search_date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $search_date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $search_date_from = "";
            $search_date_to = "";
        }

        $data = DB::select("SELECT *
          FROM (  SELECT TO_CHAR (invoice_date, 'mm') month,
                         CCM_CLIENT_NAME,
                         CLIENT_ADDRESS,
                        ccm.AU_ENTRY_AT,
                         ccm.CCM_CLIENT_NO_PK,
                         SUM (LEDGER_AMT_SALES) sales
                    FROM finc_invoicedtl_detail_vw inv,
                         finc_ledgermst mst,
                         CCM_CORPORATECLIENT ccm
                   WHERE     PATIENT_TYPE_CODE = 'CORPORATE'
                         AND mst.invoice_no_fk = inv.invoice_no_pk
                         AND ccm.CCM_CLIENT_NO_PK = mst.COR_CLIENT_NO_FK
                         AND TRUNC (invoice_date) BETWEEN TO_DATE ('01/$search_date_from',
                                                                   'dd/mm/yyyy')
                                                      AND TO_DATE ('01/$search_date_to',
                                                                   'dd/mm/yyyy')
                GROUP BY CCM_CLIENT_NAME,
                         CLIENT_ADDRESS,
                   ccm.AU_ENTRY_AT,
                         TO_CHAR (invoice_date, 'mm'),
                         ccm.CCM_CLIENT_NO_PK) PIVOT (SUM (sales)
                                               FOR month
                                               IN  ('01' JAN,
                                                   '02' FEB,
                                                   '03' MAR,
                                                   '04' APRIL,
                                                   '05' MAY,
                                                   '06' JUN,
                                                   '07' JUL,
                                                   '08' AUG,
                                                   '09' SEP,
                                                   '10' OCT,
                                                   '11' NOV,
                                                   '12' DEC))
            ORDER BY 1");


    // $corporate_data = [];
    // foreach($data as $dt){
    //     $corporate_data[$dt->department][] = $dt;
    // }

        return Template::loadview("admin.corporate.reports.corporate_marketing_data", ['data' => $data,'from_date'=>$search_date_from,'to_date'=>$search_date_to]);
    }

    public function corporateMarketingReportPdf(Request $request)
    {
        // dd($request->all());
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $search_date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $search_date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $search_date_from = "";
            $search_date_to = "";
        }

        $data = DB::select("SELECT *
        FROM (  SELECT TO_CHAR (invoice_date, 'mm') month,
                       CCM_CLIENT_NAME,
                       CLIENT_ADDRESS,
                      ccm.AU_ENTRY_AT,
                       ccm.CCM_CLIENT_NO_PK,
                       SUM (LEDGER_AMT_SALES) sales
                  FROM finc_invoicedtl_detail_vw inv,
                       finc_ledgermst mst,
                       CCM_CORPORATECLIENT ccm
                 WHERE     PATIENT_TYPE_CODE = 'CORPORATE'
                       AND mst.invoice_no_fk = inv.invoice_no_pk
                       AND ccm.CCM_CLIENT_NO_PK = mst.COR_CLIENT_NO_FK
                       AND TRUNC (invoice_date) BETWEEN TO_DATE ('01/$search_date_from',
                                                                 'dd/mm/yyyy')
                                                    AND TO_DATE ('01/$search_date_to',
                                                                 'dd/mm/yyyy')
              GROUP BY CCM_CLIENT_NAME,
                       CLIENT_ADDRESS,
                 ccm.AU_ENTRY_AT,
                       TO_CHAR (invoice_date, 'mm'),
                       ccm.CCM_CLIENT_NO_PK) PIVOT (SUM (sales)
                                             FOR month
                                             IN  ('01' JAN,
                                                 '02' FEB,
                                                 '03' MAR,
                                                 '04' APRIL,
                                                 '05' MAY,
                                                 '06' JUN,
                                                 '07' JUL,
                                                 '08' AUG,
                                                 '09' SEP,
                                                 '10' OCT,
                                                 '11' NOV,
                                                 '12' DEC))
          ORDER BY 1");


        $title = "Marketing Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        if($request->print_type == 'PDF'){
        $pdf = PDF::loadView("admin.corporate.reports.corporate_marketing_data_pdf", ['barcode_no' => $barcode_no,"po_hospital_details" => $po_hospital_details, 'data' => $data,'from_date'=>$search_date_from,'to_date'=>$search_date_to])->setPaper('a4', 'landscape');
        return $pdf->stream('marketing_report_print.pdf');
        }else{
        $pdf = ['barcode_no' => $barcode_no,"type" => "marketing report", "po_hospital_details" => $po_hospital_details, 'data' => $data,'from_date'=>$search_date_from,'to_date'=>$search_date_to];
        $fileToExport = "corporate_excel";
        $html = View("admin.corporate.reports.corporate_marketing_data_pdf")->with($pdf);
        header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        header("Content-type: application/vnd.ms-excel");
        return $html;
        }

    }




    public function corporatePerformanceReportv2()
    {
        $corporate_names = DB::table('ccm_corporateclient')->select('ccm_client_no_pk','ccm_client_name')->where('status',1)->orderBy('ccm_client_name','ASC')->get();
        $signatory_names = DB::table('ccm_corporateclient')->select('signatory_name')->groupBy('signatory_name')->orderBy('signatory_name','ASC')->get();
        return Template::loadView("admin.corporate.reports.corporate_performance_report",['corporate_names' =>$corporate_names,'signatory_names' => $signatory_names]);
    }

    public function corporatePerformanceReportDatav2(Request $request)
    {

        $signatory_name = $request->signatory_name;
        $corporate_name = $request->corporate_name;
        $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
        $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($signatory_name != "") ? " $clause cor.signatory_name='$signatory_name'" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($corporate_name != "") ? " $clause cor.ccm_client_no_pk=$corporate_name" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";



        $data = DB::select("  SELECT cor.ccm_client_code,
        COR.SIGNATORY_NAME,
        COR.CCM_CLIENT_NAME,
        SUM (
           CASE
              WHEN item_type = 'IPD' THEN item_qty - NVL (cancel_qty, 0)
              ELSE 0
           END)
           ipd_service,
        SUM (
           CASE
              WHEN item_type IN ('LAB', 'RAD')
              THEN
                 item_qty - NVL (cancel_qty, 0)
              ELSE
                 0
           END)
           investigation,
        SUM (
           CASE
              WHEN item_type = 'PROC' THEN item_qty - NVL (cancel_qty, 0)
              ELSE 0
           END)
           predure,
        SUM (
           CASE
              WHEN item_type = 'SUR' THEN item_qty - NVL (cancel_qty, 0)
              ELSE 0
           END)
           ot_excution,
        SUM (
           CASE
              WHEN item_type = 'DOCBILL' THEN item_qty - NVL (cancel_qty, 0)
              ELSE 0
           END)
           consultation,
        SUM (sales) sales
   FROM finc_invoicemst mst,
        patn_registration reg,
        ccm_corporateclient cor,
        finc_invoicedtl dtl,
        (  SELECT patient_no_fk, invoice_no_fk, SUM (ledger_amt_sales) sales
             FROM finc_ledgermst
         GROUP BY patient_no_fk, invoice_no_fk) lmst
  WHERE     reg.patient_no_pk = mst.patient_no_fk
        AND reg.ccm_client_no_fk = cor.ccm_client_no_pk
        AND mst.invoice_no_pk = dtl.invoice_no_fk
        AND mst.invoice_no_pk = lmst.invoice_no_fk
        $sql_cond
GROUP BY cor.ccm_client_code, COR.SIGNATORY_NAME, COR.CCM_CLIENT_NAME");

        return Template::loadview("admin.corporate.reports.corporate_performance_data", ['data' => $data,'from_date'=>$date_from,'to_date'=>$date_to]);
    }

    public function corporatePerformanceReportPdfv2(Request $request)
    {


        $signatory_name = $request->signatory_name;
        $corporate_name = $request->corporate_name;
        $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
        $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($signatory_name != "") ? " $clause cor.signatory_name='$signatory_name'" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($corporate_name != "") ? " $clause cor.ccm_client_no_pk=$corporate_name" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";



        $data = DB::select("  SELECT cor.ccm_client_code,
        COR.SIGNATORY_NAME,
        COR.CCM_CLIENT_NAME,
        SUM (
           CASE
              WHEN item_type = 'IPD' THEN item_qty - NVL (cancel_qty, 0)
              ELSE 0
           END)
           ipd_service,
        SUM (
           CASE
              WHEN item_type IN ('LAB', 'RAD')
              THEN
                 item_qty - NVL (cancel_qty, 0)
              ELSE
                 0
           END)
           investigation,
        SUM (
           CASE
              WHEN item_type = 'PROC' THEN item_qty - NVL (cancel_qty, 0)
              ELSE 0
           END)
           predure,
        SUM (
           CASE
              WHEN item_type = 'SUR' THEN item_qty - NVL (cancel_qty, 0)
              ELSE 0
           END)
           ot_excution,
        SUM (
           CASE
              WHEN item_type = 'DOCBILL' THEN item_qty - NVL (cancel_qty, 0)
              ELSE 0
           END)
           consultation,
        SUM (sales) sales
   FROM finc_invoicemst mst,
        patn_registration reg,
        ccm_corporateclient cor,
        finc_invoicedtl dtl,
        (  SELECT patient_no_fk, invoice_no_fk, SUM (ledger_amt_sales) sales
             FROM finc_ledgermst
         GROUP BY patient_no_fk, invoice_no_fk) lmst
  WHERE     reg.patient_no_pk = mst.patient_no_fk
        AND reg.ccm_client_no_fk = cor.ccm_client_no_pk
        AND mst.invoice_no_pk = dtl.invoice_no_fk
        AND mst.invoice_no_pk = lmst.invoice_no_fk
        $sql_cond
GROUP BY cor.ccm_client_code, COR.SIGNATORY_NAME, COR.CCM_CLIENT_NAME");


        $title = "Marketing performance Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        // if($request->print_type == 'PDF'){
        $pdf = PDF::loadView("admin.corporate.reports.corporate_performance_report_pdf", ['barcode_no' => $barcode_no,"po_hospital_details" => $po_hospital_details, 'data' => $data,'from_date'=>$date_from,'to_date'=>$date_to])->setPaper('a4', 'portrait');
        return $pdf->stream('marketing_performance_report_print.pdf');
        // }else{
        // $pdf = ['barcode_no' => $barcode_no,"type" => "marketing report", "po_hospital_details" => $po_hospital_details, 'data' => $data,'from_date'=>$from_date,'to_date'=>$to_date];
        // $fileToExport = "corporate_excel";
        // $html = View("admin.corporate.reports.corporate_performance_report_pdf")->with($pdf);
        // header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
        // header("Content-type: application/vnd.ms-excel");
        // return $html;
        // }

    }

}
