<?php

namespace App\Http\Controllers;

use App\Datatables\DataTableClass;
use App\Library\Template;
use App\Http\Controllers\Controller;
use App\Traits\LookupData;
use App\Http\Requests\ServiceUnitRequest;
use App\Traits\DatatablesLoader;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository as Repo;
use Auth;
use DB;
use App\Models\ServiceUnit;
use App\Http\Requests\GrantSuRequest;
use App\Models\GrantSU;
use Session;

class ServiceUnitController extends Controller
{
    use DatatablesLoader;
    protected $model;
    use LookupData;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(ServiceUnit $serviceunit, GrantSU $grantSU)
    {
        $this->middleware('auth');

        $this->model = new Repo($serviceunit);
        $this->model2 = new Repo($grantSU);
    }

    public function index()
    {
        return Template::loadview("admin.settings.serviceunit.serviceunit_list");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $serviceunit_data = ServiceUnit::where('serviceunit_no_parent_fk', '=', 0)->get();
        $bedtextind = $this->getLookupListByCode('BEDTEXTIND');
        return Template::loadview("admin.settings.serviceunit.create_serviceunit", [
            'serviceunit_data'  =>  $serviceunit_data,
            'bedtextind'  =>  $bedtextind,
        ]);
    }

    public function create_form()
    {
        $serviceunit_data = ServiceUnit::where('serviceunit_no_parent_fk', '=', 0)->get();
        $bedtextind = $this->getLookupListByCode('BEDTEXTIND');
        return Template::loadView("admin.settings.serviceunit.create_serviceunit_form", ['serviceunit_data' => $serviceunit_data, 'bedtextind' => $bedtextind]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceUnitRequest $request)
    {
        // return $request;
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();

        DB::beginTransaction();
        try {

            $data = [
                'serviceunit_code' => $request->service_unit_id,
                'serviceunit_no_parent_fk' => $request->parent_service_unit,
                'serviceunit_name' => $request->service_name,
                'emergency_daycare_ind_txt' => $request->module_type,
                'report_header' => $request->service_report_header,
                'serviceunit_hod_person_no_fk' => $request->service_unit_hod,
                'clinical_ind' => $request->clinical_status,
                'med_store_ind' => $request->medicine_status ? $request->medicine_status : 0,
                'radiology_ind' => $request->radiology_status ? $request->radiology_status : 0,
                'pathology_ind' => $request->pathology_status ? $request->pathology_status : 0,
                'ipd_ind' => $request->ipd_status ? $request->ipd_status : 0,
                'ot_ind' => $request->ot_status ? $request->ot_status : 0,
                'dental_ind' => $request->dental_status ? $request->dental_status : 0,
                'eye_ind' => $request->eye_status ? $request->eye_status : 0,
                'pharmacy_ind' => $request->pharmacy_status ? $request->pharmacy_status : 0,
                'lp_ind' => $request->lp_store ? $request->lp_store : 0,
                'hospital_store_ind' => $request->hospital_status ? $request->hospital_status : 0,
                'pta_ind' => $request->pta_status ? $request->pta_status : 0,
                'physio_ind' => $request->physio_ind ? $request->physio_ind : 0,
                'hs_pos_ind' => $request->pos_ind ? $request->pos_ind : 0,

                'cash_counter_ind' => $request->cash_counter ? $request->cash_counter : 0,
                'duty_area_ind' => $request->duty_area ? $request->duty_area : 0,
                'external_hosp_su_ind' => $request->external_hospital ? $request->external_hospital : 0,
                'main_store_ind' => $request->main_ind ? $request->main_ind : 0,
                'sub_store_ind' => $request->sub_store_ind ? $request->sub_store_ind : 0,
                'hk_ind' => $request->hk_ind ? $request->hk_ind : 0,

                'asset_ind' => $request->asset_store ? $request->asset_store : 0,
                'asset_sub_store_ind' => $request->asset_sub_store ? $request->asset_sub_store : 0,
                'hr_unit_ind'       => $request->hr_unit_ind ? $request->hr_unit_ind : 0,
                'hr_dept_ind'       => $request->hr_dept_ind ? $request->hr_dept_ind : 0,
                'status' => $request->status ? $request->status : 0,
                'sl_no' => $request->sl_no ? $request->sl_no : 0,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
            ];
            // dd($data);
            if ($id == null || $id == "") {

                // AU_ENTRY_BY
                $data['au_entry_by'] = 1;

                $res = $this->model->create($data);
                // return $res;

            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
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
        $serviceunit_data = ServiceUnit::where('serviceunit_no_parent_fk', '=', 0)->get();
        $serviceunit = $this->model->show($id);
        $bedtextind = $this->getLookupListByCode('BEDTEXTIND');
        return Template::loadView("admin.settings.serviceunit.create_serviceunit_form", [
            'serviceunit_data' => $serviceunit_data,
            'serviceunit'            => $serviceunit, 'bedtextind' => $bedtextind
        ]);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getServiceUnitInfoById($id)
    {
        return $id;
    }

    public function getAllServiceUnits(Request $request)
    {
       
        $hospital_id = Session::get('user.ses_hospital_no_pk');
       
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        $table = 'sysc_serviceunit';
        // Table's primary key
        $primaryKey = 'serviceunit_no_pk';

        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'serviceunit_code', 'dt' => 1),
            array('db' => 'serviceunit_no_parent_fk',  'dt' => 2),
            array('db' => 'serviceunit_name',   'dt' => 3),
            array('db' => 'report_header',   'dt' => 4),
            array('db' => 'serviceunit_hod_person_no_fk',   'dt' => 5),
            array('db' => 'clinical_ind',   'dt' => 6),
            array('db' => 'med_store_ind',   'dt' => 7),
            array('db' => 'pharmacy_ind',   'dt' => 8),
            array('db' => 'hospital_store_ind',   'dt' => 9),
            array('db' => 'lp_ind',   'dt' => 10),
            array('db' => 'pathology_ind',   'dt' => 11),
            array('db' => 'radiology_ind',   'dt' => 12),
            array('db' => 'ipd_ind',   'dt' => 13),
            array('db' => 'dental_ind',   'dt' => 14),
            array('db' => 'eye_ind',   'dt' => 15),
            array('db' => 'ot_ind',   'dt' => 16),
            array('db' => 'external_hosp_su_ind',   'dt' => 17),
            array('db' => 'cash_counter_ind',   'dt' => 18),
            array('db' => 'duty_area_ind',   'dt' => 19),
            array('db' => 'physio_ind',   'dt' => 20),
            array('db' => 'main_store_ind',   'dt' => 21),
            array('db' => 'sub_store_ind',   'dt' => 22),
            array('db' => 'status',   'dt' => 23),
            array('db' => 'serviceunit_no_pk',   'dt' => 24),
        );

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }

        //        $columns = array(
        //            'sl',
        //            'serviceunit_code',
        //            'serviceunit_no_parent_fk',
        //            'serviceunit_name',
        //            'report_header',
        //            'serviceunit_hod_person_no_fk',
        //            'clinical_ind',
        //            'med_store_ind',
        //            'pharmacy_ind',
        //            'hospital_store_ind',
        //            'lp_ind',
        //            'pathology_ind',
        //            'radiology_ind',
        //            'ipd_ind',
        //            'dental_ind',
        //            'eye_ind',
        //            'ot_ind',
        //            'external_hosp_su_ind',
        //            'cash_counter_ind',
        //            'duty_area_ind',
        //            'status',
        //            'serviceunit_no_pk',
        //        );
        //        $active = '<span class="badge badge-md badge-success"> Active</span>';
        //        $inactive = '<span class="badge badge-md badge-secondary"> Inactive</span>';
        //        $yes = '<span class="badge badge-md badge-success"> Yes</span>';
        //        $no = '<span class="badge badge-md badge-secondary"> No</span>';
        //
        //        $sql = "SELECT '' as sl, a.serviceunit_code, a.serviceunit_no_parent_fk, a.serviceunit_name, a.report_header, a.serviceunit_hod_person_no_fk,
        //
        //        CASE WHEN a.clinical_ind  =1  THEN '$yes' ELSE '$no' END AS clinical_ind,
        //        CASE WHEN a.med_store_ind =1  THEN '$yes' ELSE '$no' END AS med_store_ind ,
        //        CASE WHEN a.pharmacy_ind  =1 THEN '$yes' ELSE '$no' END AS pharmacy_ind ,
        //        CASE WHEN a.hospital_store_ind =1  THEN '$yes' ELSE '$no' END AS hospital_store_ind,
        //        CASE WHEN a.lp_ind  =1 THEN '$yes' ELSE '$no' END AS lp_ind,
        //        CASE WHEN a.pathology_ind =1  THEN '$yes' ELSE '$no' END AS pathology_ind,
        //        CASE WHEN a.radiology_ind =1  THEN '$yes' ELSE '$no' END AS radiology_ind ,
        //        CASE WHEN a.ipd_ind =1   THEN '$yes' ELSE '$no' END AS ipd_ind,
        //        CASE WHEN a.dental_ind =1   THEN '$yes' ELSE '$no' END AS dental_ind,
        //        CASE WHEN a.eye_ind =1   THEN '$yes' ELSE '$no' END AS eye_ind,
        //        CASE WHEN a.ot_ind  =1  THEN '$yes' ELSE '$no' END AS ot_ind,
        //        CASE WHEN a.external_hosp_su_ind  =1  THEN '$yes' ELSE '$no' END AS external_hosp_su_ind,
        //        CASE WHEN a.cash_counter_ind  =1  THEN '$yes' ELSE '$no' END AS cash_counter_ind,
        //        CASE WHEN a.duty_area_ind  =1  THEN '$yes' ELSE '$no' END AS duty_area_ind,
        //        CASE WHEN a.status  =1  THEN '$active' ELSE '$inactive' END AS status,
        //
        //        a.serviceunit_no_pk, rownum rownumber, au_update_at,au_entry_at from sysc_serviceunit a";
        //
        //        $order_by_column = "serviceunit_no_pk";
        //
        //        $json_data = $this->datatable( $request, $sql, $order_by_column, 'DESC', $columns);
        //
        //        echo json_encode($json_data);

    }



    // Grant ServiceUnit

    public function grantServiceUnitToUser()
    {
        return Template::loadview("admin.settings.serviceunit.grant_service_unit_to_user");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function grantServiceUnitToUserForm()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        // dd($ses_hospital_id);
        $doctor_data = DB::table("wsec_user")->select('user_no_pk', 'user_fullname', 'user_code')
        ->where('status', 1)->where('au_entry_hospital_pk_no', $ses_hospital_id)->get();
        //dd($doctor_data);
        $department_data = DB::table('sysc_serviceunit')->where('status', 1)->where('au_entry_hospital_pk_no', $ses_hospital_id)->get();
        // $department_data = ServiceUnit::where("status", "1")->get();
        // dd($department_data);
        return Template::loadView("admin.settings.serviceunit.grant_service_unit_to_user_popup_form", ["doctor_data" => $doctor_data, "department_data" => $department_data]);
    }


    public function storeGrantServiceUnitToUser(Request $request)
    {

        $id = $request->id;
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        try {
            $data = [
                'user_no_fk' => $request->grantuser_user,
                'su_no_fk' => $request->grantuser_department,
                'default_ind' => $request->grantServiceUnitDefault,
                'save_ind' => $request->grantServiceUnitSave,
                'verify_ind' => $request->grantServiceUnitVerify,
                'finalize_ind' => $request->grantServiceUnitFinalize,
                'print_final_ind' => $request->grantServiceUnitPrint,

                'samaple_receive_ind' => $request->sample_receive,
                'preview_ind' => $request->preview,
                'result_edit_ind' => $request->result_edit,
                'all_su_ind' => $request->su,
                'hod_ind' => $request->hod_ind,
                'labresult_list1_ind' => $request->prepared_by,
                'labresult_list2_ind' => $request->verified,
                'labresult_list3_ind' => $request->finalize,
                'labresult_list4_ind' => $request->consult_1,
                'labresult_list5_ind' => $request->consult_2,
                'hr_dept_ind' => $request->hr_dept_ind,
                'hr_unit_ind' => $request->hr_unit_ind,
                'status' => $request->grantServiceUnitStatus,
                'au_entry_hospital_no_fk'  => $ses_hospital_id,

            ];

            if ($id == "") {
                $data['au_entry_by'] = $auth_id;
                $this->model2->create($data);
            } else {
                $data['au_update_by'] = $auth_id;
                // $data['au_entry_hospital_no_fk'] = $ses_hospital_id;
                $this->model2->update($data, $id);
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

    public function getAllGrantServiceUnit(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        $table = 'SYSC_GRANT_SERVIECEUNIT_VW';
        // Table's primary key
        $primaryKey = 'grantsu_no_pk';

        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'user_name', 'dt' => 1),
            // array('db' => "CONCAT(user_name, ' (', person_code, ')') AS user_name", 'dt' => 1),
            array('db' => 'serviceunit_name',  'dt' => 2),
            array('db' => 'default_ind',   'dt' => 3),
            array('db' => 'verify_ind',   'dt' => 4),
            array('db' => 'samaple_receive_ind',   'dt' => 5),
            array('db' => 'preview_ind',   'dt' => 6),
            array('db' => 'save_ind',   'dt' => 7),
            array('db' => 'finalize_ind',   'dt' => 8),
            array('db' => 'result_edit_ind',   'dt' => 9),
            array('db' => 'print_final_ind',   'dt' => 10),
            array('db' => 'user_code', 'dt' => 11),
            array('db' => 'grantsu_no_pk',   'dt' => 12)
        );

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }


    public function getServiceEditData($id)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $data = $this->model2->show($id);
        $doctor_data = DB::table("wsec_user")->select('user_no_pk', 'user_fullname','user_code')->where('status', 1)->get();
        $department_data = ServiceUnit::where('au_entry_hospital_pk_no', $ses_hospital_id)->where("status", "1")->get();
        // dd($doctor_data);

        return Template::loadView("admin.settings.serviceunit.grant_service_unit_to_user_popup_form", ['grantServiceData' => $data, "doctor_data" => $doctor_data, "department_data" => $department_data]);
    }
}
