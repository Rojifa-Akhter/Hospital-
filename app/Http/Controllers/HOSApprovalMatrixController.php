<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Library\Template;
use App\Models\ServiceUnit;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Traits\LookupData;
use Illuminate\Support\Facades\Validator;
use Exception;
use PDO;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use PDF;
use Illuminate\Support\Facades\Auth;


use App;
use App\Models\PurchaseOrderMaster;

class HOSApprovalMatrixController extends Controller
{
    use LookupData;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $allApprovalMatrixData = DB::table('sysc_approvalmatrix_worklist_vw')
            ->select(
                'sysc_approvalmatrix_worklist_vw.approval_for_code',
                'sysc_approvalmatrix_worklist_vw.no_of_level',
                'sysc_approvalmatrix_worklist_vw.default_verified_by',
                'sysc_approvalmatrix_worklist_vw.default_prepared_by',
                'sysc_approvalmatrix_worklist_vw.default_finalized_by',
                'sysc_approvalmatrix_worklist_vw.approvalmatrixmst_no_pk',
                'sysc_approvalmatrix_worklist_vw.all_random_ind',
                'sysc_approvalmatrix_worklist_vw.all_sequential_ind',
                'sysc_approvalmatrix_worklist_vw.emp_name',
                DB::raw("COUNT(sysc_approvalmatrixdtl.approvalmatrixmst_no_fk) as total_item")
            )
            ->leftjoin('sysc_approvalmatrixdtl', 'sysc_approvalmatrixdtl.approvalmatrixmst_no_fk', '=',  'sysc_approvalmatrix_worklist_vw.approvalmatrixmst_no_pk')
            ->groupBy(
                'sysc_approvalmatrixdtl.approvalmatrixmst_no_fk',
                'sysc_approvalmatrix_worklist_vw.approval_for_code',
                'sysc_approvalmatrix_worklist_vw.no_of_level',
                'sysc_approvalmatrix_worklist_vw.default_verified_by',
                'sysc_approvalmatrix_worklist_vw.default_prepared_by',
                'sysc_approvalmatrix_worklist_vw.default_finalized_by',
                'sysc_approvalmatrix_worklist_vw.approvalmatrixmst_no_pk',
                'sysc_approvalmatrix_worklist_vw.all_random_ind',
                'sysc_approvalmatrix_worklist_vw.all_sequential_ind',
                'sysc_approvalmatrix_worklist_vw.emp_name'
            )
            ->where('dept_base_approval_ind', '!=', 1)
            ->get();

        return Template::loadview("admin.uhl.approval_matrix.matrix-worklist", [
            'allApprovalMatrixData' => $allApprovalMatrixData,
        ]);
    }
    public function index_department()
    {

        $allApprovalMatrixData = DB::table('sysc_approvalmatrix_worklist_vw')
            ->select(
                'sysc_approvalmatrix_worklist_vw.approval_for_code',
                'sysc_approvalmatrix_worklist_vw.no_of_level',
                'sysc_approvalmatrix_worklist_vw.default_verified_by',
                'sysc_approvalmatrix_worklist_vw.default_prepared_by',
                'sysc_approvalmatrix_worklist_vw.default_finalized_by',
                'sysc_approvalmatrix_worklist_vw.approvalmatrixmst_no_pk',
                'sysc_approvalmatrix_worklist_vw.all_random_ind',
                'sysc_approvalmatrix_worklist_vw.all_sequential_ind',
                'sysc_approvalmatrix_worklist_vw.emp_name',
                DB::raw("COUNT(sysc_approvalmatrixdtl_dept.approvalmatrixmst_no_fk) as total_item")
            )
            ->leftjoin('sysc_approvalmatrixdtl_dept', 'sysc_approvalmatrixdtl_dept.approvalmatrixmst_no_fk', '=',  'sysc_approvalmatrix_worklist_vw.approvalmatrixmst_no_pk')
            ->groupBy(
                'sysc_approvalmatrixdtl_dept.approvalmatrixmst_no_fk',
                'sysc_approvalmatrix_worklist_vw.approval_for_code',
                'sysc_approvalmatrix_worklist_vw.no_of_level',
                'sysc_approvalmatrix_worklist_vw.default_verified_by',
                'sysc_approvalmatrix_worklist_vw.default_prepared_by',
                'sysc_approvalmatrix_worklist_vw.default_finalized_by',
                'sysc_approvalmatrix_worklist_vw.approvalmatrixmst_no_pk',
                'sysc_approvalmatrix_worklist_vw.all_random_ind',
                'sysc_approvalmatrix_worklist_vw.all_sequential_ind',
                'sysc_approvalmatrix_worklist_vw.emp_name'
            )
            // ->where('dept_base_approval_ind',1)
            ->get();
        // dd( $allApprovalMatrixData);
        return Template::loadview("admin.uhl.approval_matrix.matrix-worklist-department", [
            'allApprovalMatrixData' => $allApprovalMatrixData,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $approval_fors = DB::table('sysc_lookup')->where('lookup_code', "APPROVALMETRIX")->where('sysc_lookupdata.status', 1)->leftJoin('sysc_lookupdata', 'sysc_lookupdata.lookup_no_fk', 'sysc_lookup.lookup_no_pk')->get();
        $approval_for = [];
        if (!empty($approval_fors)) {
            foreach ($approval_fors as  $value) {
                $approval_for[$value->lookupdata_code] = $value->lookupdata_name;
            }
        }

        //  $this->getLookupListByCode("APPROVALMETRIX");
        return Template::loadView("admin.uhl.approval_matrix.create-approval-matrix", ['approval_for' => $approval_for]);
    }
    public function createDepartment()
    {
        $approval_fors = DB::table('sysc_lookup')->where('lookup_code', "APPROVALMETRIX")->where('sysc_lookupdata.status', 1)->leftJoin('sysc_lookupdata', 'sysc_lookupdata.lookup_no_fk', 'sysc_lookup.lookup_no_pk')->get();
        $approval_for = [];
        if (!empty($approval_fors)) {
            foreach ($approval_fors as  $value) {
                $approval_for[$value->lookupdata_code] = $value->lookupdata_name;
            }
        }
        $department = ServiceUnit::select('serviceunit_no_pk', 'serviceunit_name')->where('hr_dept_ind', 1)->where('status', 1)->get();       
        return Template::loadView("admin.uhl.approval_matrix.create-approval-matrix-department", ['approval_for' => $approval_for, 'department' => $department]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $level = $request->level;
        $sequence_no = $request->sequence;
        $skip_ind = $request->skip_ind;
        $signature = $request->signature;
        $hod = $request->hod;
        $employee = $request->employee_id;
        $department = $request->department_id;
        $designation = $request->designation_id;
        $level = $request->level;
        $level_text = $request->level_text;

        $prepared = $request->hdn_prepared_id;
        $verified = $request->hdn_verified_id;
        $finalized = $request->hdn_finalized_id;

        $au_entry_at = Carbon::now();
        $au_entry_at = $au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');
        try {

            DB::beginTransaction();

            $sequence = DB::getSequence();
            $approvalmatrixmst_no_pk_seq = $sequence->nextValue('approvalmatrixmst_no_pk_seq');

            $approval_matrix_mst = DB::table('sysc_approvalmatrixmst')->insert(
                [
                    'approvalmatrixmst_no_pk' => $approvalmatrixmst_no_pk_seq,
                    'approval_for_code' => $request->approval_for,
                    'no_of_level' => $request->level_no,
                    'approval_for_link' => $request->pdf_link,
                    'approval_for_edit_link' => $request->edit_link,
                    'approvalmatrixmst_desc' => $request->approval_des,
                    'all_sequential_ind' => $request->all_sequence ? $request->all_sequence : 0,
                    'all_random_ind' => $request->all_random ? $request->all_random : 0,
                    'print_sign_use_default_ind' => $request->default_signature ?  $request->default_signature : 0,
                    'default_prepared_by' => $prepared,
                    'default_verified_by' => $verified,
                    'default_finalized_by' => $finalized,
                    'au_entry_at' => $au_entry_at,
                    'au_entry_by' => Auth::id(),
                    'au_entry_session' => $entry_session,
                    'au_entry_hospital_pk_no' => $hospital_pk_no,
                ]
            );


            if (!empty($level)) {
                foreach ($level as $key => $value) {
                    $approvalmatrixdtl_no_pk_seq = $sequence->nextValue('approvalmatrixdtl_no_pk_seq');
                    $approval_matrix_del = DB::table('sysc_approvalmatrixdtl')
                        ->insert([
                            'approvalmatrixdtl_no_pk' => $approvalmatrixdtl_no_pk_seq,
                            'approvalmatrixmst_no_fk' => $approvalmatrixmst_no_pk_seq,
                            'approvalmatrix_level_num' => $level[$key],
                            'approvalmatrix_level_txt' => $level_text[$key],
                            'print_signature_ind' => $signature[$key],
                            'approved_by_hod' => $hod[$key] ? $hod[$key] : 0,
                            'approval_sequnece' => $sequence_no[$key],
                            'skip_ind' => $skip_ind[$key],
                            'person_no_fk' => $employee[$key] ? $employee[$key] : "",
                            'su_no_fk' => $department[$key] ? $department[$key] : "",
                            'designation_no_fk' => $designation[$key] ? $designation[$key] : "",
                            'au_entry_at' => $au_entry_at,
                            'au_entry_by' => Auth::id(),
                            'au_entry_session' => $entry_session,
                            'au_entry_hospital_pk_no' => $hospital_pk_no,
                        ]);
                }
            }
            $message = ['msg' => 'Data created successfully', 'title' => 'Success'];
            DB::commit();
            return response()->json($message);

            // return response()->json(['success' => true, 'data' => $acc_chart_of_acc], 200);
        } catch (\Exception $e) {
            $message = ['msg' => ' Failled.', 'title' => 'Error'];
            DB::rollback();
            return response()->json($message);
        }
    }
    public function store_department(Request $request)
    {
        $level = $request->level;
        $sequence_no = $request->sequence;
        $skip_ind = $request->skip_ind;
        $signature = $request->signature;
        $hod = $request->hod;
        $employee = $request->employee_id;
        $department = $request->department_id;
        $designation = $request->designation_id;
        $dep_su_no = $request->department_no;
        $level = $request->level;
        $level_text = $request->level_text;

        $prepared = $request->hdn_prepared_id;
        $verified = $request->hdn_verified_id;
        $finalized = $request->hdn_finalized_id;

        $au_entry_at = Carbon::now();
        $au_entry_at = $au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');
        $id = $request->id;
        // try {

        DB::beginTransaction();

        $sequence = DB::getSequence();
        $approvalmatrixmst_no_pk_seq = $sequence->nextValue('approvalmatrixmst_no_pk_seq');


        $approval_matrix_mst = DB::table('sysc_approvalmatrixmst')->insert(
            [
                'approvalmatrixmst_no_pk' => $approvalmatrixmst_no_pk_seq,
                'approval_for_code' => $request->approval_for,
                'no_of_level' => $request->level_no,
                'approval_for_link' => $request->pdf_link,
                'approval_for_edit_link' => $request->edit_link,
                'approvalmatrixmst_desc' => $request->approval_des,
                'all_sequential_ind' => $request->all_sequence ? $request->all_sequence : 0,
                'all_random_ind' => $request->all_random ? $request->all_random : 0,
                'print_sign_use_default_ind' => $request->default_signature ?  $request->default_signature : 0,
                'default_prepared_by' => $prepared,
                'default_verified_by' => $verified,
                'default_finalized_by' => $finalized,
                'dept_base_approval_ind' => $request->department_ind,
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
            ]
        );


        if (!empty($level)) {
            foreach ($level as $key => $value) {
                $dep_su_name = ServiceUnit::select('serviceunit_name')->where('serviceunit_no_pk', $dep_su_no[$key])->first();
                $dep_name = '';
                if (!empty($dep_su_name)) {
                    $dep_name = $dep_su_name->serviceunit_name;
                }

                $approvalmatrixdtl_no_pk_seq = $sequence->nextValue('approvalmatrixdtl_d_no_pk_seq');
                $approval_matrix_del = DB::table('sysc_approvalmatrixdtl_dept')
                    ->insert([
                        'approvalmatrixdtl_dept_no_pk' => $approvalmatrixdtl_no_pk_seq,
                        'approvalmatrixdtl_dept_uid' => $approvalmatrixdtl_no_pk_seq,
                        'approvalmatrixmst_no_fk' => $approvalmatrixmst_no_pk_seq,
                        'approvalmatrix_level_num' => $level[$key],
                        'approvalmatrix_level_txt' => $level_text[$key],
                        'print_signature_ind' => $signature[$key],
                        'approved_by_hod_ind' => $hod[$key] ? $hod[$key] : 0,
                        'approval_sequnece' => $sequence_no[$key],
                        'skip_ind' => $skip_ind[$key],
                        'person_no_fk' => $employee[$key] ? $employee[$key] : "",
                        'person_su_no_fk' => $department[$key] ? $department[$key] : "",
                        'person_designation_no_fk' => $designation[$key] ? $designation[$key] : "",
                        'dept_su_no_fk' => $dep_su_no[$key] ? $dep_su_no[$key] : "",
                        'dept_su_name' => $dep_name != "" ? $dep_name : "",
                        'au_entry_at' => $au_entry_at,
                        'au_entry_by' => Auth::id(),
                        'au_entry_session' => $entry_session,
                        'au_entry_hospital_pk_no' => $hospital_pk_no,
                    ]);
            }
        }




        $message = ['msg' => 'Data created successfully', 'title' => 'Success'];
        DB::commit();
        return response()->json($message);

        // return response()->json(['success' => true, 'data' => $acc_chart_of_acc], 200);
        // } catch (\Exception $e) {
        //     $message = ['msg' => ' Failled.', 'title' => 'Error'];
        //     DB::rollback();
        //     return response()->json($message);
        // }
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
        $approval_matrix_id = $id;
        $approval_matrix_data = DB::table('sysc_approvalmatrixmst')->select('sysc_approvalmatrixmst.*')->where('approvalmatrixmst_no_pk', $approval_matrix_id)->first();
        $approval_matrix_detail = DB::table('sysc_approvalmatrixdtl')->select('sysc_approvalmatrixdtl.*')->where('approvalmatrixmst_no_fk', $approval_matrix_id)->orderBy("approval_sequnece", "asc")->get();
        $approval_fors = DB::table('sysc_lookup')->where('lookup_code', "APPROVALMETRIX")->where('sysc_lookupdata.status', 1)->leftJoin('sysc_lookupdata', 'sysc_lookupdata.lookup_no_fk', 'sysc_lookup.lookup_no_pk')->get();
        $approval_for = [];
        if (!empty($approval_fors)) {
            foreach ($approval_fors as  $value) {
                $approval_for[$value->lookupdata_code] = $value->lookupdata_name;
            }
        }
        //  $approval_for = $this->getLookupListByCode("APPROVALMETRIX")
        return Template::loadView("admin.uhl.approval_matrix.edit-approval-matrix", ['approval_for' => $approval_for, 'approval_matrix_data' => $approval_matrix_data, 'approval_matrix_detail' => $approval_matrix_detail,'approval_matrix_id'=>$approval_matrix_id]);
    }
    public function changeApproval(Request $request){
        $approval_id=$request->approval_id;
        $hdn_emp_id=$request->hdn_emp_id;
        $approval_type=$request->approval_type;
        try {
            $approval_designation=$approval_id!="" ?  DB::table('hrms_personnel')->select('jobtitle_lookup_no_fk')->where('person_no_pk',$approval_id)->first()->jobtitle_lookup_no_fk :'';
            $app_matrix_id=$approval_type !="" ? DB::table('sysc_approvalmatrixmst')->select('approvalmatrixmst_no_pk')->where('approval_for_code',$approval_type)->first()->approvalmatrixmst_no_pk :'';
           $data=[
                'person_no_fk'=>$approval_id,
                'designation_no_fk'=> $approval_designation
           ];
           $data_dep=[
                'person_no_fk'=>$approval_id,
                'person_designation_no_fk'=> $approval_designation
           ];
           DB::table('sysc_approvalmatrixdtl')->where('approvalmatrixmst_no_fk',$app_matrix_id)->where('person_no_fk',$hdn_emp_id)->update($data);
           DB::table('sysc_approvalmatrixdtl_dept')->where('approvalmatrixdtl_dept_no_pk',$app_matrix_id)->where('person_no_fk',$hdn_emp_id)->update($data_dep);
           DB::commit();
           $message=['meg'=>'success'];
        } catch (\Throwable $th) {
            $message=['meg'=>$th];
        }
        return response()->json($message);
    }
    public function edit_department($id)
    {
        $approval_matrix_id = $id;
        $approval_matrix_data = DB::table('sysc_approvalmatrixmst')->select('sysc_approvalmatrixmst.*')->where('approvalmatrixmst_no_pk', $approval_matrix_id)->first();
        $approval_matrix_detail = DB::table('sysc_approvalmatrixdtl_dept')->select('sysc_approvalmatrixdtl_dept.*')->where('approvalmatrixmst_no_fk', $approval_matrix_id)->orderBy("dept_su_name", "asc")->orderBy("approvalmatrix_level_txt", "asc")->get();

        $approval_fors = DB::table('sysc_lookup')->where('lookup_code', "APPROVALMETRIX")->where('sysc_lookupdata.status', 1)->leftJoin('sysc_lookupdata', 'sysc_lookupdata.lookup_no_fk', 'sysc_lookup.lookup_no_pk')->get();
        $approval_for = [];
        if (!empty($approval_fors)) {
            foreach ($approval_fors as  $value) {
                $approval_for[$value->lookupdata_code] = $value->lookupdata_name;
            }
        }
        $department = ServiceUnit::select('serviceunit_no_pk', 'serviceunit_name')->where('hr_dept_ind', 1)->where('status', 1)->get();
        //  $approval_for = $this->getLookupListByCode("APPROVALMETRIX")
        return Template::loadView("admin.uhl.approval_matrix.edit-approval-matrix-department", ['approval_for' => $approval_for, 'approval_matrix_data' => $approval_matrix_data, 'approval_matrix_detail' => $approval_matrix_detail, 'department' => $department]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $approval_matrix_id = $request->approval_matrix_id;
        $approval_matrix_detail_ids = $request->approval_matrix_detail_ids;

        $level = $request->level;
        $sequence_no = $request->sequence;
        $skip_ind = $request->skip_ind;
        $signature = $request->signature;
        $hod = $request->hod;
        $employee = $request->employee_id;
        $department = $request->department_id;
        $designation = $request->designation_id;
        $level = $request->level;
        $level_text = $request->level_text;

        $prepared = $request->hdn_prepared_id;

        $verified = $request->hdn_verified_id;
        $finalized = $request->hdn_finalized_id;

        $au_entry_at = Carbon::now();
        $au_entry_at = $au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');
        $delete = $request->delete_val;
        $delete_arr = [];
        if ($delete != "") {
            $exp_d = explode(',', $delete);
            $delete_arr = array_filter($exp_d);
        }

        try {
            DB::beginTransaction();
            $sequence = DB::getSequence();
            $approval_matrix_mst = DB::table('sysc_approvalmatrixmst')
                ->where('approvalmatrixmst_no_pk', $approval_matrix_id)
                ->update(
                    [
                        'approval_for_code' => $request->approval_for,
                        'no_of_level' => $request->level_no,
                        'approval_for_link' => $request->pdf_link,
                        'approval_for_edit_link' => $request->edit_link,
                        'approvalmatrixmst_desc' => $request->approval_des,
                        'all_sequential_ind' => $request->all_sequence ? $request->all_sequence : 0,
                        'all_random_ind' => $request->all_random ? $request->all_random : 0,
                        'print_sign_use_default_ind' => $request->default_signature ?  $request->default_signature : 0,
                        'default_prepared_by' => $prepared,
                        'default_verified_by' => $verified,
                        'default_finalized_by' => $finalized,
                        'au_entry_at' => $au_entry_at,
                        'au_entry_by' => Auth::id(),
                        'au_entry_session' => $entry_session,
                        'au_entry_hospital_pk_no' => $hospital_pk_no,
                    ]
                );

            // DB::table('sysc_approvalmatrixdtl')->where("approvalmatrixmst_no_fk", $approval_matrix_id)->delete();

            if (!empty($level)) {
                foreach ($level as $key => $value) {
                    $approvalmatrixdtl_no_pk_seq = $sequence->nextValue('approvalmatrixdtl_no_pk_seq');
                    $approval_matrix_del = DB::table('sysc_approvalmatrixdtl')
                        ->insert([
                            'approvalmatrixdtl_no_pk' => $approvalmatrixdtl_no_pk_seq,
                            'approvalmatrixmst_no_fk' => $approval_matrix_id,
                            'approvalmatrix_level_num' => $level[$key],
                            'approvalmatrix_level_txt' => $level_text[$key],
                            'print_signature_ind' => $signature[$key],
                            'approved_by_hod' => $hod[$key] ? $hod[$key] : "",
                            'approval_sequnece' => $sequence_no[$key],
                            'skip_ind' => $skip_ind[$key],
                            'person_no_fk' => $employee[$key] ? $employee[$key] : "",
                            'su_no_fk' => $department[$key] ? $department[$key] : "",
                            'designation_no_fk' => $designation[$key] ? $designation[$key] : "",
                            'au_entry_at' => $au_entry_at,
                            'au_entry_by' => Auth::id(),
                            'au_entry_session' => $entry_session,
                            'au_entry_hospital_pk_no' => $hospital_pk_no,
                        ]);
                }
            }
            if (!empty($delete_arr)) {
                for ($i = 0; $i < count($delete_arr); $i++) {
                    DB::table('sysc_approvalmatrixdtl')->where("approvalmatrixdtl_no_pk", $delete_arr[$i])->delete();
                }
            }
            $message = ['msg' => 'Data updated successfully', 'title' => 'Success'];
            DB::commit();
            return response()->json($message);

            // return response()->json(['success' => true, 'data' => $acc_chart_of_acc], 200);
        } catch (\Exception $e) {
            $message = ['msg' => ' Failled.', 'title' => 'Error'];
            DB::rollback();
            return response()->json($message);
        }
    }
    public function update_department(Request $request)
    {
        $approval_matrix_id = $request->approval_matrix_id;
        $approval_matrix_detail_ids = $request->approval_matrix_detail_ids;

        $level = $request->level;
        $sequence_no = $request->sequence;
        $skip_ind = $request->skip_ind;
        $signature = $request->signature;
        $hod = $request->hod;
        $employee = $request->employee_id;
        $department = $request->department_id;
        $designation = $request->designation_id;
        $level = $request->level;
        $level_text = $request->level_text;

        $prepared = $request->hdn_prepared_id;

        $verified = $request->hdn_verified_id;
        $finalized = $request->hdn_finalized_id;

        $au_entry_at = Carbon::now();
        $au_entry_at = $au_entry_at->toDateString();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');
        $dep_su_no = $request->department_no;
        $delete = $request->delete_val;
        $delete_arr = [];
        if ($delete != "") {
            $exp_d = explode(',', $delete);
            $delete_arr = array_filter($exp_d);
        }
        try {

            DB::beginTransaction();
            $sequence = DB::getSequence();

            $approval_matrix_mst = DB::table('sysc_approvalmatrixmst')
                ->where('approvalmatrixmst_no_pk', $approval_matrix_id)
                ->update(
                    [
                        'approval_for_code' => $request->approval_for,
                        'no_of_level' => $request->level_no,
                        'approval_for_link' => $request->pdf_link,
                        'approval_for_edit_link' => $request->edit_link,
                        'approvalmatrixmst_desc' => $request->approval_des,
                        'all_sequential_ind' => $request->all_sequence ? $request->all_sequence : 0,
                        'all_random_ind' => $request->all_random ? $request->all_random : 0,
                        'print_sign_use_default_ind' => $request->default_signature ?  $request->default_signature : 0,
                        'default_prepared_by' => $prepared,
                        'default_verified_by' => $verified,
                        'default_finalized_by' => $finalized,
                        'dept_base_approval_ind' => $request->department_ind,
                        'au_entry_at' => $au_entry_at,
                        'au_entry_by' => Auth::id(),
                        'au_entry_session' => $entry_session,
                        'au_entry_hospital_pk_no' => $hospital_pk_no,
                    ]
                );

            // DB::table('sysc_approvalmatrixdtl')->where("approvalmatrixmst_no_fk", $approval_matrix_id)->delete();

            if (!empty($level)) {
                foreach ($level as $key => $value) {
                    $dep_su_name = ServiceUnit::select('serviceunit_name')->where('serviceunit_no_pk', $dep_su_no[$key])->first();
                    $dep_name = '';
                    if (!empty($dep_su_name)) {
                        $dep_name = $dep_su_name->serviceunit_name;
                    }
                    $approvalmatrixdtl_no_pk_seq = $sequence->nextValue('approvalmatrixdtl_d_no_pk_seq');
                    $approval_matrix_del = DB::table('sysc_approvalmatrixdtl_dept')
                        ->insert([
                            // 'approvalmatrixdtl_no_pk' => $approvalmatrixdtl_no_pk_seq,
                            // 'approvalmatrixmst_no_fk' => $approval_matrix_id,
                            // 'approvalmatrix_level_num' => $level[$key],
                            // 'approvalmatrix_level_txt' => $level_text[$key],
                            // 'print_signature_ind' => $signature[$key],
                            // 'approved_by_hod' => $hod[$key] ? $hod[$key] : "",
                            // 'approval_sequnece' => $sequence_no[$key],
                            // 'skip_ind' => $skip_ind[$key],
                            // 'person_no_fk' => $employee[$key] ? $employee[$key] : "",
                            // 'su_no_fk' => $department[$key] ? $department[$key] : "",
                            // 'designation_no_fk' => $designation[$key] ? $designation[$key] : "",
                            // 'au_entry_at' => $au_entry_at,
                            // 'au_entry_by' => Auth::id(),
                            // 'au_entry_session' => $entry_session,
                            // 'au_entry_hospital_pk_no' => $hospital_pk_no,


                            'approvalmatrixdtl_dept_no_pk' => $approvalmatrixdtl_no_pk_seq,
                            'approvalmatrixdtl_dept_uid' => $approvalmatrixdtl_no_pk_seq,
                            'approvalmatrixmst_no_fk' => $approval_matrix_id,
                            'approvalmatrix_level_num' => $level[$key],
                            'approvalmatrix_level_txt' => $level_text[$key],
                            'print_signature_ind' => $signature[$key],
                            'approved_by_hod_ind' => $hod[$key] ? $hod[$key] : 0,
                            'approval_sequnece' => $sequence_no[$key],
                            'skip_ind' => $skip_ind[$key],
                            'person_no_fk' => $employee[$key] ? $employee[$key] : "",
                            'person_su_no_fk' => $department[$key] ? $department[$key] : "",
                            'person_designation_no_fk' => $designation[$key] ? $designation[$key] : "",
                            'dept_su_no_fk' => $dep_su_no[$key] ? $dep_su_no[$key] : "",
                            'dept_su_name' => $dep_name != "" ? $dep_name : "",
                            'au_entry_at' => $au_entry_at,
                            'au_entry_by' => Auth::id(),
                            'au_entry_session' => $entry_session,
                            'au_entry_hospital_pk_no' => $hospital_pk_no,
                        ]);
                }
            }
            if (!empty($delete_arr)) {
                for ($i = 0; $i < count($delete_arr); $i++) {
                    DB::table('sysc_approvalmatrixdtl_dept')->where("approvalmatrixdtl_dept_no_pk", $delete_arr[$i])->delete();
                }
            }
            $message = ['msg' => 'Data updated successfully', 'title' => 'Success'];
            DB::commit();
            return response()->json($message);

            // return response()->json(['success' => true, 'data' => $acc_chart_of_acc], 200);
        } catch (\Exception $e) {
            $message = ['msg' => ' Failled.', 'title' => 'Error'];
            DB::rollback();
            return response()->json($message);
        }
    }

    // public function preAproval($primary_key="",$user_id=""){
    //     $test = DB::table('sysc_approvalprocess_vw')
    //     ->select("apprprocess_no_pk" ,"approval_for_code", DB::raw("count(apprprocess_no_pk) cr"))
    //     ->where("user_no_pk", Auth::id())
    //     ->where("au_entry_hospital_pk_no", $hospital_pk_no)
    //     ->groupBy("apprprocess_no_pk","approval_for_code")
    //     ->orderBy("approval_for_code", "asc")
    //     ->get();
    // }

    public function myApproval()
    {
        $ses_hospital_code = Session()->get('user.ses_hospital_code');
        $loginUser = Session()->get('user.ses_person_no_fk');
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $currentDate = date('Y-m-d');
        
            // Get approval data in one query instead of looping
            $myApprovaldataDataGroup = DB::table('sysc_approvalprocess_vw')
                ->select("apprprocess_no_pk", "approval_for_code", DB::raw("count(apprprocess_no_pk) as cr"))
                ->where("user_no_pk", Auth::id())
                ->where("au_entry_hospital_pk_no", $hospital_pk_no)
                ->where('reject_ind', 0)
                ->where('approved_ind', 0);

                if (Session::get('user.ses_hospital_code') != 'DMHL') {
                    // Define the date range
                    $fromDate = date('Y-m-d', strtotime('-6 days', strtotime($currentDate))); // 6 days ago
                    $toDate = $currentDate; // current date
                    
                    // Use whereRaw for custom SQL with bound parameters
                    $myApprovaldataDataGroup->whereRaw("TRUNC(apprprocess_date) BETWEEN TO_DATE(?, 'YYYY-MM-DD') AND TO_DATE(?, 'YYYY-MM-DD')", [$fromDate, $toDate]);
                }

            $myApprovaldataDataGroup = $myApprovaldataDataGroup->groupBy("apprprocess_no_pk", "approval_for_code")->get();

            // Prepare an array to hold approval data for different approval codes
            $approvalDataArray = [];

            // Get all approval data at once and filter it by approval_for_code
            $approvalDataQuery = DB::table('sysc_approvalprocess_vw')
                ->where("user_no_pk", Auth::id())
                ->where("au_entry_hospital_pk_no", $hospital_pk_no)
                ->where('reject_ind', 0)
                ->where('approved_ind', 0)
                ->orderBy("apprprocess_no_pk", "desc")
                ->orderBy("approval_for_code", "asc");

            if (Session::get('user.ses_hospital_code') != 'DMHL') {
                $fromDate = date('Y-m-d', strtotime('-6 days', strtotime($currentDate))); // 6 days ago
                $toDate = $currentDate; // current date
                
                // Use whereRaw for custom SQL with bound parameters
                $approvalDataQuery->whereRaw("TRUNC(apprprocess_date) BETWEEN TO_DATE(?, 'YYYY-MM-DD') AND TO_DATE(?, 'YYYY-MM-DD')", [$fromDate, $toDate]);
            }

            // Execute the query once and filter by approval_for_code
            $allApprovalData = $approvalDataQuery->get()->toArray();

            // Loop through grouped data and match with fetched approval data
            foreach ($myApprovaldataDataGroup as $data) {
                $approvalDataArray[$data->approval_for_code] = array_filter($allApprovalData, function ($item) use ($data) {
                    return $item->approval_for_code == $data->approval_for_code || $data->approval_for_code == "all";
                });
            }
        // dd($approvalDataArray);
        $approval_fors = DB::table('sysc_lookup')->where('lookup_code', "APPROVALMETRIX")->where('sysc_lookupdata.status', 1)->leftJoin('sysc_lookupdata', 'sysc_lookupdata.lookup_no_fk', 'sysc_lookup.lookup_no_pk')->get();
       
        $approval_for = [];
        if (!empty($approval_fors)) {
            foreach ($approval_fors as  $value) {
                $approval_for[$value->lookupdata_code] = $value->lookupdata_name;
            }
        }
        // dd($approvalDataArray);
        return Template::loadview("admin.uhl.approval_matrix.my-approval", [
            'approvalDataArray' => $approvalDataArray,
            'approval_for' => $approval_for,
            'ses_hospital_code' => $ses_hospital_code,
        ]);
    }


    public function check_approval_status($primary_key,$code="")
    {
        $app_level = DB::table("sysc_approvalprocess")
            ->where('primary_key_value', $primary_key)
            ->where('approval_for_code', $code)
            // ->where('person_no_fk', Session::get('user.ses_person_no_fk'))
            ->get();
            // dd(Session::get('user.ses_person_no_fk'),$app_level);
        return $app_level;
    }

    public function myApprovalsearch(Request $request)
    {
         $ses_hospital_code = Session()->get('user.ses_hospital_code');
        $loginUser = Session()->get('user.ses_person_no_fk');
        $hospital_pk_no =  session()->get('user.ses_hospital_no_pk');

        $status  = isset($request->status) ?  $request->status  :  "";
        $approveType  = isset($request->approveType) ?  $request->approveType  :  "";
        $from_date = date("d-m-Y", strtotime($request->from_date));
        $to_date = date("d-m-Y", strtotime($request->to_date));

        $approval_fors = DB::table('sysc_lookup')->where('lookup_code', "APPROVALMETRIX")->where('sysc_lookupdata.status', 1)->leftJoin('sysc_lookupdata', 'sysc_lookupdata.lookup_no_fk', 'sysc_lookup.lookup_no_pk')->get();
        $approval_for = [];
        if (!empty($approval_fors)) {
            foreach ($approval_fors as  $value) {
                $approval_for[$value->lookupdata_code] = $value->lookupdata_name;
            }
        }
        // $myApprovaldataDataGroup = DB::table('sysc_approvalprocess_vw')
        //     ->select("apprprocess_no_pk", "approval_for_code")
        //     ->where("user_no_pk", Auth::id())
        //     ->where("au_entry_hospital_pk_no", $hospital_pk_no);
        // // ->where("approval_for_code", $approveType);
        // if ($approveType != "all") {
        //     $myApprovaldataDataGroup->where('approval_for_code', $approveType);
        // }
        // if ($status == "pending") {
        //     $myApprovaldataDataGroup->where('reject_ind', 0)
        //     ->where('approved_ind', 0);
        // }
        // if ($status == "approved") {
        //     $myApprovaldataDataGroup->where('approved_ind', "1");
        // }
        // if ($status == "rejected") {
        //     $myApprovaldataDataGroup->where('reject_ind', "1");
        // }
        // if (isset($request->from_date) && isset($request->to_date)) {
        //     $myApprovaldataDataGroup->where(DB::raw('trunc(apprprocess_date)'), '>=', date('Y-m-d', strtotime($request->from_date)));
        //     $myApprovaldataDataGroup->where(DB::raw('trunc(apprprocess_date)'), '<=', date('Y-m-d', strtotime($request->to_date)));
        // }
        // $myApprovaldataDataGroup = $myApprovaldataDataGroup->get();
        // $approvalDataArray = [];


        // foreach ($myApprovaldataDataGroup as $data) {

        //     $approvalDataArray[$data->approval_for_code] = DB::table('sysc_approvalprocess_vw')
        //         ->select("sysc_approvalprocess_vw.*")
        //         ->where("user_no_pk", Auth::id())
        //         ->where("au_entry_hospital_pk_no", $hospital_pk_no)
        //         ->orderBy("apprprocess_no_pk", "desc")
        //         ->orderBy("approval_for_code", "asc");
        //     if ($data->approval_for_code != "all") {
        //         $approvalDataArray[$data->approval_for_code]->where('approval_for_code', $data->approval_for_code);
        //     }
        //     if ($status == "pending") {
        //         $approvalDataArray[$data->approval_for_code]->where('reject_ind', 0)
        //         ->where('approved_ind', 0);
        //     }
        //     if ($status == "approved") {
        //         $approvalDataArray[$data->approval_for_code]->where('approved_ind', "1");
        //     }
        //     if ($status == "rejected") {
        //         $approvalDataArray[$data->approval_for_code]->where('reject_ind', "1");
        //     }
        //     if (isset($request->from_date) && isset($request->to_date)) {
        //         $approvalDataArray[$data->approval_for_code]->where(DB::raw('trunc(apprprocess_date)'), '>=', date('Y-m-d', strtotime($request->from_date)));
        //         $approvalDataArray[$data->approval_for_code]->where(DB::raw('trunc(apprprocess_date)'), '<=', date('Y-m-d', strtotime($request->to_date)));
        //     }
        //     $approvalDataArray[$data->approval_for_code] = $approvalDataArray[$data->approval_for_code]->get()->toArray();
        // }



            // Base query to fetch approval data based on filters
            $myApprovaldataDataGroup = DB::table('sysc_approvalprocess_vw')
            ->select("apprprocess_no_pk", "approval_for_code")
            ->where("user_no_pk", Auth::id())
            ->where("au_entry_hospital_pk_no", $hospital_pk_no);

            // Add the approval type filter
            if ($approveType != "all") {
            $myApprovaldataDataGroup->where('approval_for_code', $approveType);
            }

            // Add the status filter
            if ($status == "pending") {
            $myApprovaldataDataGroup->where('reject_ind', 0)->where('approved_ind', 0);
            } elseif ($status == "approved") {
            $myApprovaldataDataGroup->where('approved_ind', 1);
            } elseif ($status == "rejected") {
            $myApprovaldataDataGroup->where('reject_ind', 1);
            }

            // Add date range filter if provided
            if (isset($request->from_date) && isset($request->to_date)) {
            $fromDate = date('Y-m-d', strtotime($request->from_date));
            $toDate = date('Y-m-d', strtotime($request->to_date));
            $myApprovaldataDataGroup->whereRaw("TRUNC(apprprocess_date) BETWEEN TO_DATE(?, 'YYYY-MM-DD') AND TO_DATE(?, 'YYYY-MM-DD')", [$fromDate, $toDate]);
            }

            $myApprovaldataDataGroup = $myApprovaldataDataGroup->get();

            // Initialize an array to hold the approval data
            $approvalDataArray = [];

            // Pre-fetch all the relevant approval process data in a single query
            $approvalDataQuery = DB::table('sysc_approvalprocess_vw')
            ->select("sysc_approvalprocess_vw.*")
            ->where("user_no_pk", Auth::id())
            ->where("au_entry_hospital_pk_no", $hospital_pk_no);

            // Apply common filters
            if ($status == "pending") {
            $approvalDataQuery->where('reject_ind', 0)->where('approved_ind', 0);
            } elseif ($status == "approved") {
            $approvalDataQuery->where('approved_ind', 1);
            } elseif ($status == "rejected") {
            $approvalDataQuery->where('reject_ind', 1);
            }

            if (isset($request->from_date) && isset($request->to_date)) {
                $approvalDataQuery->whereRaw("TRUNC(apprprocess_date) BETWEEN TO_DATE(?, 'YYYY-MM-DD') AND TO_DATE(?, 'YYYY-MM-DD')", [$fromDate, $toDate]);
            }

            // Get all the approval data in one go
            $allApprovalData = $approvalDataQuery->orderBy("apprprocess_no_pk", "desc")
            ->orderBy("approval_for_code", "asc")
            ->get()
            ->groupBy('approval_for_code'); // Group by approval_for_code

            // Process the data
            foreach ($myApprovaldataDataGroup as $data) {
            $approvalDataArray[$data->approval_for_code] = $allApprovalData->get($data->approval_for_code, []);
            }



        // dd($approvalDataArray);
        if (Session::get('user.ses_hospital_code') == 'EWMCH') {
            return Template::loadview("admin.uhl.approval_matrix.my-approval-table-list_ewmch", [
                'approvalDataArray' => $approvalDataArray,
                'approval_for' => $approval_for
            ]);
        } else {
            return Template::loadview("admin.uhl.approval_matrix.my-approval-table-list", [
                'approvalDataArray' => $approvalDataArray,
                'approval_for' => $approval_for,
                'ses_hospital_code' => $ses_hospital_code
            ]);
            
        }
    }


    public function myApprovalStatus($id, $status=null)
    {
        $approval_matrix_id = explode('*',$id) ;

        return Template::loadView("admin.uhl.approval_matrix.edit-myapproval-status", [
            'approval_matrix_id' => $approval_matrix_id[0],
            'approval_matrix_code' => $approval_matrix_id[1],
            'hr_status' => $status
        ]);
    }
    public function myApprovalStatusReject($id, $code = null, $status=null)
    {
        $approval_matrix_id = $id;
        return Template::loadView("admin.uhl.approval_matrix.reject-myapproval-status", [
            'approval_matrix_id' => $approval_matrix_id,
            'hr_status' => $status,
            'code' => $code
        ]);
    }
    public function myApprovalStatusHold($id)
    {
        $approval_matrix_id = $id;
        return Template::loadView("admin.uhl.approval_matrix.hold-myapproval-status", [
            'approval_matrix_id' => $approval_matrix_id
        ]);
    }
    public function myApprovalStatusUnhold($id)
    {
        $approval_matrix_id = $id;
        return Template::loadView("admin.uhl.approval_matrix.unhold-myapproval-status", [
            'approval_matrix_id' => $approval_matrix_id
        ]);
    }
    public function hrMyApprovalStatus($id, $status=null)
    {
        $approval_matrix_id = explode('*',$id) ;

        return Template::loadView("admin.uhl.approval_matrix.hr-edit-myapproval-status", [
            'approval_matrix_id' => $approval_matrix_id[0],
            'approval_matrix_code' => $approval_matrix_id[1],
            'hr_status' => $status
        ]);
    }
    public function hrMyApprovalStatusReject($id, $code = null, $status=null)
    {
        $approval_matrix_id = $id;
        return Template::loadView("admin.uhl.approval_matrix.hr-reject-myapproval-status", [
            'approval_matrix_id' => $approval_matrix_id,
            'hr_status' => $status,
            'code' => $code
        ]);
    }
    public function hrMyApprovalStatusHold($id)
    {
        $approval_matrix_id = $id;
        return Template::loadView("admin.uhl.approval_matrix.hr-hold-myapproval-status", [
            'approval_matrix_id' => $approval_matrix_id
        ]);
    }

    public function hrMyApprovalStatusUnhold($id)
    {
        $approval_matrix_id = $id;
        return Template::loadView("admin.uhl.approval_matrix.hr-unhold-myapproval-status", [
            'approval_matrix_id' => $approval_matrix_id
        ]);
    }

    public function myApprovalLevelDetail($id)
    {
        $approval_matrix_id = $id; 
        $loginUser = Session()->get('user.ses_person_no_fk');
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');

        $leveldetailInfo = DB::table('sysc_approvalprocess_vw')
            ->select("status_text")
            ->where("apprprocess_no_pk", $approval_matrix_id)
            ->where("person_no_fk", $loginUser)
            ->where("au_entry_hospital_pk_no", $hospital_pk_no)
            ->first();

        return Template::loadView("admin.uhl.approval_matrix.myapproval-level-detail", [
            'leveldetailInfo' => $leveldetailInfo
        ]);
    }
    public function myApprovalLevelDetailHr($id)
    {
        $approval_matrix_id = $id; 
        $loginUser = Session()->get('user.ses_person_no_fk');
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');

        $leveldetailInfo = DB::table('sysc_approvalprocess_vw')
            ->select("status_text")
            ->where("apprprocess_no_pk", $approval_matrix_id)
            // ->where("person_no_fk", $loginUser)
            ->where("au_entry_hospital_pk_no", $hospital_pk_no)
            ->first();

        return Template::loadView("admin.uhl.approval_matrix.myapproval-level-detail", [
            'leveldetailInfo' => $leveldetailInfo
        ]);
    }
    public function myApprovalLevelDetailPrList($id,$type="")
    {
        
        $approval_matrix_id = $id;
        $loginUser = Session()->get('user.ses_person_no_fk');
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');

        $leveldetailInfo = DB::table('sysc_approvalprocess_vw')
            ->select("status_text")
            ->where("primary_key_value", $approval_matrix_id)
            //  ->where("apprprocess_no_pk", $approval_matrix_id)
            //  ->where("person_no_fk", $loginUser)
            // ->where("approval_for_code", 'INDENT')
            ->when($type != "", function ($query) use ($type) {
                return $query->where("approval_for_code", $type);
            })
            ->where("au_entry_hospital_pk_no", $hospital_pk_no)
            ->first();

        return Template::loadView("admin.uhl.approval_matrix.myapproval-level-detail", [
            'leveldetailInfo' => $leveldetailInfo
        ]);
    }
    public function myApprovalLevelDetailWorkOrderList($id)
    {
        $approval_matrix_id = $id;
        $loginUser = Session()->get('user.ses_person_no_fk');
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');

        $leveldetailInfo = DB::table('sysc_approvalprocess_vw')
            ->select("status_text")
            ->where("primary_key_value", $approval_matrix_id)
             ->where("approval_for_code", 'WORKORDER')
            ->where("au_entry_hospital_pk_no", $hospital_pk_no)
            ->first();

        return Template::loadView("admin.uhl.approval_matrix.myapproval-level-detail", [
            'leveldetailInfo' => $leveldetailInfo
        ]);
    }
    public function myApprovalLevelDetailPOList($id)
    {
        $approval_matrix_id = $id;
        $loginUser = Session()->get('user.ses_person_no_fk');
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');

        $leveldetailInfo = DB::table('sysc_approvalprocess_vw')
            ->select("status_text")
            ->where("primary_key_value", $approval_matrix_id)
             ->where("approval_for_code", 'PO')
            ->where("au_entry_hospital_pk_no", $hospital_pk_no)
            ->first();

        return Template::loadView("admin.uhl.approval_matrix.myapproval-level-detail", [
            'leveldetailInfo' => $leveldetailInfo
        ]);
    }
    public function myApprovalLevelDetailWorkOrderBillList($id)
    {
        $approval_matrix_id = $id;
        $loginUser = Session()->get('user.ses_person_no_fk');
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');

        $leveldetailInfo = DB::table('sysc_approvalprocess_vw')
            ->select("status_text")
            ->where("primary_key_value", $approval_matrix_id)
             ->where("approval_for_code", 'WORKORDERBILL')
            ->where("au_entry_hospital_pk_no", $hospital_pk_no)
            ->first();

        return Template::loadView("admin.uhl.approval_matrix.myapproval-level-detail", [
            'leveldetailInfo' => $leveldetailInfo
        ]);
    }

    public function updateStatus(Request $request)
    {
        
        $approval_matrix_id = $request->approval_matrix_id;
        $approval_matrix_code = $request->approval_matrix_code;
        $remarks = $request->remarks;
        $status = $request->status;
        $currentDateTime = Carbon::now();
        $au_entry_at = $currentDateTime->format('Y-m-d H:i:s');
        $person_no=Session::get('user.ses_person_no_fk');
        $process_data=DB::table('sysc_approvalprocess')->select('approval_for_code','primary_key_value','person_no_fk')->where('apprprocess_no_pk',$approval_matrix_id)->first();
       
        // $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        // $entry_session = Session()->get('user.ses_user_pk_no');
        // dd($process_data);
        try {

            DB::beginTransaction();
            $sequence = DB::getSequence();
            if ($status == "approve") {
                $approve_status=DB::table('sysc_approvalprocess')->select('approval_for_code','primary_key_value','person_no_fk','no_of_level','own_level')->where('apprprocess_no_pk',$approval_matrix_id)->where('person_no_fk',$person_no)->where('approval_for_code',$approval_matrix_code)->first();
                // dd($person_no,$approval_matrix_code, $approve_status);
                DB::table('sysc_approvalprocess')
                    // ->where('apprprocess_no_pk', $approval_matrix_id)
                    ->where('approval_for_code', $process_data->approval_for_code)
                    ->where('primary_key_value', $process_data->primary_key_value)
                    ->where('person_no_fk', $process_data->person_no_fk)
                    ->update(
                        [
                            'approved_ind' => 1,
                            'approved_at' => $au_entry_at,
                            'approved_by' => Auth::id(),
                            'approved_remarks' => $request->remarks ? $request->remarks : "",
                            'hold_ind' => 0,
                            'hold_at' => "",
                            'hold_by' => "",
                            'hold_reason' => "",
                            'reject_ind' => 0,
                            'reject_at' => "",
                            'reject_by' => "",
                            'reject_reason' => "",
                        ]
                    );

                    $other_persons_level = DB::table('sysc_approvalprocess')
                                        ->where('primary_key_value', $process_data->primary_key_value)
                                        ->where('person_no_fk','!=', $person_no)
                                        ->where('approval_for_code',$approval_matrix_code)
                                        ->where('approved_ind', 1)
                                        ->count();
                    $persons_level = DB::table('sysc_approvalprocess')
                                        ->where('primary_key_value', $process_data->primary_key_value)
                                        ->where('person_no_fk',$person_no)
                                        ->where('approval_for_code',$approval_matrix_code)
                                        ->count();

                    $persons_level = intval($persons_level) + intval($other_persons_level);


                    if ($approval_matrix_code == "LEAVEAPP" &&  ($approve_status->no_of_level == $approve_status->own_level || $approve_status->no_of_level == $persons_level)) { 

                        DB::table('hrms_leave_entry')->where('leave_no_pk',$approve_status->primary_key_value)->update([
                            'approved_ind'=>1,
                        ]);
                    }

                $message = ['msg' => 'Approved successfully', 'title' => 'Success'];
                DB::commit();
            } elseif ($status == "hold") {

                DB::table('sysc_approvalprocess')
                    // ->where('apprprocess_no_pk', $approval_matrix_id)
                    ->where('approval_for_code', $process_data->approval_for_code)
                    ->where('primary_key_value', $process_data->primary_key_value)
                    ->where('person_no_fk', $process_data->person_no_fk)
                    ->update(
                        [
                            'hold_ind' => 1,
                            'hold_at' => $au_entry_at,
                            'hold_by' => Auth::id(),
                            'hold_reason' => $request->hold_reason ? $request->hold_reason : "",
                            'reject_ind' => 0,
                            'reject_at' => "",
                            'reject_by' => "",
                            'reject_reason' => "",
                            'approved_ind' => 0,
                            'approved_at' => "",
                            'approved_by' => "",
                            'approved_remarks' => "",
                        ]
                    );

                $message = ['msg' => 'Hold successfully', 'title' => 'Success'];
                DB::commit();
            } else {

                DB::table('sysc_approvalprocess')
                    // ->where('apprprocess_no_pk', $approval_matrix_id)
                    ->where('approval_for_code', $process_data->approval_for_code)
                    ->where('primary_key_value', $process_data->primary_key_value)
                    ->where('person_no_fk', $process_data->person_no_fk)
                    ->update(
                        [
                            'reject_ind' => 1,
                            'reject_at' => $au_entry_at,
                            'reject_by' => Auth::id(),
                            'reject_reason' => $request->reject_reason ? $request->reject_reason : "",
                            'hold_ind' => 0,
                            'hold_at' => "",
                            'hold_by' => "",
                            'hold_reason' => "",
                            'approved_ind' => 0,
                            'approved_at' => "",
                            'approved_by' => "",
                            'approved_remarks' => "",
                        ]
                    );
                    if ($approval_matrix_code == "LEAVEAPP"){

                        $approve_status=DB::table('sysc_approvalprocess')->select('approval_for_code','primary_key_value','person_no_fk','no_of_level','own_level')->where('apprprocess_no_pk',$approval_matrix_id)->where('person_no_fk',$person_no)->where('approval_for_code',$approval_matrix_code)->first();

                            DB::table('hrms_leave_entry')->where('leave_no_pk',$approve_status->primary_key_value)->update([
                                'reject_ind' => 1,
                                'reject_at' => $au_entry_at,
                                'reject_by' => Auth::id(),
                                'reject_reason' => $request->reject_reason ? $request->reject_reason : "",
                                'hold_ind' => 0,
                                'approved_ind'=>0
                            ]);
                }
                
                $message = ['msg' => 'Rejected successfully', 'title' => 'Success'];
                DB::commit();
            }
            DB::commit();
            return response()->json($message);

            // return response()->json(['success' => true, 'data' => $acc_chart_of_acc], 200);
        } catch (\Exception $e) {
            $message = ['msg' => ' Failled.', 'title' => 'Error'];
            DB::rollback();
            return response()->json($message);
        }
    }

    public function updateStatusUnHold(Request $request)
    {
        $approval_matrix_id = $request->approval_matrix_id;
        $unhold_reason = $request->unhold_reason;
        $currentDateTime = Carbon::now();

        DB::beginTransaction();

        try {
            DB::table("SYSC_APPROVALPROCESS")
                ->where('APPRPROCESS_NO_PK', $approval_matrix_id)
                ->update([
                    'HOLD_IND' => 0,
                    'UNHOLD_REASON' => $unhold_reason,
                    'UNHOLD_AT' => $currentDateTime,
                ]);

            $message = ['msg' => 'UnHold Successfully', 'title' => 'Success'];
            DB::commit();
        } catch(Exception $exception) {
            $message = ['msg' => ' Failled.', 'title' => 'Error'];
            DB::rollback();
        }

        return response()->json($message);
    }
    //hr leave approve
    public function hrLeaveApprove(Request $request)
    { 
        if(isset($request->leave_pending)){
            foreach($request->leave_pending as $data){
                list($processNo, $approvalCode) = explode(',', $data);
                $approval_matrix_id = $processNo;
                $approval_matrix_code = $approvalCode;
                $remarks = $request->status == 'approve' ? 'Approved': ($request->status == 'reject' ? 'Rejected' : 'Hold');
                $status = $request->status;
                $currentDateTime = Carbon::now();
                $au_entry_at = $currentDateTime->format('Y-m-d H:i:s');
                $person_no=Session::get('user.ses_person_no_fk');
                $process_data=DB::table('sysc_approvalprocess')->select('approval_for_code','primary_key_value','person_no_fk')->where('apprprocess_no_pk',$approval_matrix_id)->first();
            
                // $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
                // $entry_session = Session()->get('user.ses_user_pk_no');
                // dd($process_data);
                try {

                    DB::beginTransaction();
                    $sequence = DB::getSequence();
                    if ($status == "approve") {
                        $approve_status=DB::table('sysc_approvalprocess')->select('approval_for_code','primary_key_value','person_no_fk','no_of_level','own_level')->where('apprprocess_no_pk',$approval_matrix_id)->where('person_no_fk',$person_no)->where('approval_for_code',$approval_matrix_code)->first();
                        // dd($person_no,$approval_matrix_code, $approve_status);
                        DB::table('sysc_approvalprocess')
                            // ->where('apprprocess_no_pk', $approval_matrix_id)
                            ->where('approval_for_code', $process_data->approval_for_code)
                            ->where('primary_key_value', $process_data->primary_key_value)
                            ->where('person_no_fk', $process_data->person_no_fk)
                            ->update(
                                [
                                    'approved_ind' => 1,
                                    'approved_at' => $au_entry_at,
                                    'approved_by' => Auth::id(),
                                    'approved_remarks' => $remarks,
                                    'hold_ind' => 0,
                                    'hold_at' => "",
                                    'hold_by' => "",
                                    'hold_reason' => "",
                                    'reject_ind' => 0,
                                    'reject_at' => "",
                                    'reject_by' => "",
                                    'reject_reason' => "",
                                ]
                            );

                            $other_persons_level = DB::table('sysc_approvalprocess')
                                                ->where('primary_key_value', $process_data->primary_key_value)
                                                ->where('person_no_fk','!=', $person_no)
                                                ->where('approval_for_code',$approval_matrix_code)
                                                ->where('approved_ind', 1)
                                                ->count();
                            $persons_level = DB::table('sysc_approvalprocess')
                                                ->where('primary_key_value', $process_data->primary_key_value)
                                                ->where('person_no_fk',$person_no)
                                                ->where('approval_for_code',$approval_matrix_code)
                                                ->count();

                            $persons_level = intval($persons_level) + intval($other_persons_level);


                            if ($approval_matrix_code == "LEAVEAPP" &&  ($approve_status->no_of_level == $approve_status->own_level || $approve_status->no_of_level == $persons_level)) { 

                                DB::table('hrms_leave_entry')->where('leave_no_pk',$approve_status->primary_key_value)->update([
                                    'approved_ind'=>1,
                                ]);
                            }

                        $message = ['msg' => 'Approved successfully', 'title' => 'Success'];
                        DB::commit();
                    } elseif ($status == "hold") {

                        DB::table('sysc_approvalprocess')
                            // ->where('apprprocess_no_pk', $approval_matrix_id)
                            ->where('approval_for_code', $process_data->approval_for_code)
                            ->where('primary_key_value', $process_data->primary_key_value)
                            ->where('person_no_fk', $process_data->person_no_fk)
                            ->update(
                                [
                                    'hold_ind' => 1,
                                    'hold_at' => $au_entry_at,
                                    'hold_by' => Auth::id(),
                                    'hold_reason' => $request->hold_reason ? $request->hold_reason : "",
                                    'reject_ind' => 0,
                                    'reject_at' => "",
                                    'reject_by' => "",
                                    'reject_reason' => "",
                                    'approved_ind' => 0,
                                    'approved_at' => "",
                                    'approved_by' => "",
                                    'approved_remarks' => "",
                                ]
                            );

                        $message = ['msg' => 'Hold successfully', 'title' => 'Success'];
                        DB::commit();
                    } else {

                        DB::table('sysc_approvalprocess')
                            // ->where('apprprocess_no_pk', $approval_matrix_id)
                            ->where('approval_for_code', $process_data->approval_for_code)
                            ->where('primary_key_value', $process_data->primary_key_value)
                            ->where('person_no_fk', $process_data->person_no_fk)
                            ->update(
                                [
                                    'reject_ind' => 1,
                                    'reject_at' => $au_entry_at,
                                    'reject_by' => Auth::id(),
                                    'reject_reason' => $request->reject_reason ? $request->reject_reason : "",
                                    'hold_ind' => 0,
                                    'hold_at' => "",
                                    'hold_by' => "",
                                    'hold_reason' => "",
                                    'approved_ind' => 0,
                                    'approved_at' => "",
                                    'approved_by' => "",
                                    'approved_remarks' =>  $remarks,
                                ]
                            );
                            if ($approval_matrix_code == "LEAVEAPP"){

                                $approve_status=DB::table('sysc_approvalprocess')->select('approval_for_code','primary_key_value','person_no_fk','no_of_level','own_level')->where('apprprocess_no_pk',$approval_matrix_id)->where('person_no_fk',$person_no)->where('approval_for_code',$approval_matrix_code)->first();

                                    DB::table('hrms_leave_entry')->where('leave_no_pk',$approve_status->primary_key_value)->update([
                                        'reject_ind' => 1,
                                        'reject_at' => $au_entry_at,
                                        'reject_by' => Auth::id(),
                                        'reject_reason' => $request->reject_reason ? $request->reject_reason : "",
                                        'hold_ind' => 0,
                                        'approved_ind'=>0
                                    ]);
                        }
                        
                        $message = ['msg' => 'Rejected successfully', 'title' => 'Success'];
                        DB::commit();
                    }
                    // return response()->json(['success' => true, 'data' => $acc_chart_of_acc], 200);
                } catch (\Exception $e) {
                    $message = ['msg' => ' Failled.', 'title' => 'Error'];
                    DB::rollback();
                    return response()->json($message);
                }
            }
            DB::commit();
            return response()->json($message);
        }else{
                $message = ['msg' => 'Please select at least one leave request.', 'title' => 'Error'];
                return response()->json($message);  
        }
    }
    public function hrAttendanceApprove(Request $request)
    { 
        if(isset($request->attendance_pending)){
            foreach($request->attendance_pending as $data){
                list($processNo, $approvalCode) = explode(',', $data);
                $approval_matrix_id = $processNo;
                $approval_matrix_code = $approvalCode;
                $remarks = $request->status == 'approve' ? 'Approved': ($request->status == 'reject' ? 'Rejected' : 'Hold');
                $status = $request->status;
                $currentDateTime = Carbon::now();
                $au_entry_at = $currentDateTime->format('Y-m-d H:i:s');
                $person_no=Session::get('user.ses_person_no_fk');
                $process_data=DB::table('sysc_approvalprocess')->select('approval_for_code','primary_key_value','person_no_fk')->where('apprprocess_no_pk',$approval_matrix_id)->first();            
                try {
                    DB::beginTransaction();
                    $sequence = DB::getSequence();
                    if ($status == "approve") {
                        $approve_status=DB::table('sysc_approvalprocess')->select('approval_for_code','primary_key_value','person_no_fk','no_of_level','own_level')->where('apprprocess_no_pk',$approval_matrix_id)->where('person_no_fk',$person_no)->where('approval_for_code',$approval_matrix_code)->first();
                        DB::table('sysc_approvalprocess')
                            ->where('approval_for_code', $process_data->approval_for_code)
                            ->where('primary_key_value', $process_data->primary_key_value)
                            ->where('person_no_fk', $process_data->person_no_fk)
                            ->update(
                                [
                                    'approved_ind' => 1,
                                    'approved_at' => $au_entry_at,
                                    'approved_by' => Auth::id(),
                                    'approved_remarks' => $remarks,
                                    'hold_ind' => 0,
                                    'hold_at' => "",
                                    'hold_by' => "",
                                    'hold_reason' => "",
                                    'reject_ind' => 0,
                                    'reject_at' => "",
                                    'reject_by' => "",
                                    'reject_reason' => "",
                                ]
                            );
                            $other_persons_level = DB::table('sysc_approvalprocess')
                                                ->where('primary_key_value', $process_data->primary_key_value)
                                                ->where('person_no_fk','!=', $person_no)
                                                ->where('approval_for_code',$approval_matrix_code)
                                                ->where('approved_ind', 1)
                                                ->count();
                            $persons_level = DB::table('sysc_approvalprocess')
                                                ->where('primary_key_value', $process_data->primary_key_value)
                                                ->where('person_no_fk',$person_no)
                                                ->where('approval_for_code',$approval_matrix_code)
                                                ->count();
                            $persons_level = intval($persons_level) + intval($other_persons_level);  if ($approval_matrix_code == "LEAVEAPP" &&  ($approve_status->no_of_level == $approve_status->own_level || $approve_status->no_of_level == $persons_level)) { 
                            DB::table('hrms_leave_entry')->where('leave_no_pk',$approve_status->primary_key_value)->update([
                                    'approved_ind'=>1,
                                ]);
                            }
                        $message = ['msg' => 'Approved successfully', 'title' => 'Success'];
                        DB::commit();
                    } elseif ($status == "hold") {
                        DB::table('sysc_approvalprocess')
                            ->where('approval_for_code', $process_data->approval_for_code)
                            ->where('primary_key_value', $process_data->primary_key_value)
                            ->where('person_no_fk', $process_data->person_no_fk)
                            ->update(
                                [
                                    'hold_ind' => 1,
                                    'hold_at' => $au_entry_at,
                                    'hold_by' => Auth::id(),
                                    'hold_reason' => $request->hold_reason ? $request->hold_reason : "",
                                    'reject_ind' => 0,
                                    'reject_at' => "",
                                    'reject_by' => "",
                                    'reject_reason' => "",
                                    'approved_ind' => 0,
                                    'approved_at' => "",
                                    'approved_by' => "",
                                    'approved_remarks' => "",
                                ]
                            );
                        $message = ['msg' => 'Hold successfully', 'title' => 'Success'];
                        DB::commit();
                    } else {
                        DB::table('sysc_approvalprocess')
                            ->where('approval_for_code', $process_data->approval_for_code)
                            ->where('primary_key_value', $process_data->primary_key_value)
                            ->where('person_no_fk', $process_data->person_no_fk)
                            ->update(
                                [
                                    'reject_ind' => 1,
                                    'reject_at' => $au_entry_at,
                                    'reject_by' => Auth::id(),
                                    'reject_reason' => $request->reject_reason ? $request->reject_reason : "",
                                    'hold_ind' => 0,
                                    'hold_at' => "",
                                    'hold_by' => "",
                                    'hold_reason' => "",
                                    'approved_ind' => 0,
                                    'approved_at' => "",
                                    'approved_by' => "",
                                    'approved_remarks' =>  $remarks,
                                ]
                            );
                            if ($approval_matrix_code == "LEAVEAPP"){

                                $approve_status=DB::table('sysc_approvalprocess')->select('approval_for_code','primary_key_value','person_no_fk','no_of_level','own_level')->where('apprprocess_no_pk',$approval_matrix_id)->where('person_no_fk',$person_no)->where('approval_for_code',$approval_matrix_code)->first();

                                    DB::table('hrms_leave_entry')->where('leave_no_pk',$approve_status->primary_key_value)->update([
                                        'reject_ind' => 1,
                                        'reject_at' => $au_entry_at,
                                        'reject_by' => Auth::id(),
                                        'reject_reason' => $request->reject_reason ? $request->reject_reason : "",
                                        'hold_ind' => 0,
                                        'approved_ind'=>0
                                    ]);
                        } 
                        $message = ['msg' => 'Rejected successfully', 'title' => 'Success'];
                        DB::commit();
                    }
                } catch (\Exception $e) {
                    $message = ['msg' => ' Failled.', 'title' => 'Error'];
                    DB::rollback();
                    return response()->json($message);
                }
            }
            DB::commit();
            return response()->json($message);
        }else{
                $message = ['msg' => 'Please select at least one leave request.', 'title' => 'Error'];
                return response()->json($message);  
        }
    }
}
