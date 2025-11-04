<?php

namespace App\Http\Controllers;

use App\Datatables\DataTableClass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Template;
use App\Models\LeaveType;
use App\Traits\DatatablesLoader;
use DB;
use Session;
use Auth;
use App\Traits\LookupData;
use App\Repositories\BaseRepository as Repo;


class LeaveSetupController extends Controller
{

    use LookupData, DatatablesLoader;

    public function __construct(LeaveType $LeaveType)
    {
        $this->middleware('auth');

        $this->model = new Repo($LeaveType);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leave_category = $this->getLookupListByCode("LEAVECATEGORY");

        return template::loadview('admin.settings.leave_setup.leave_setup_index', ['leave_category' => $leave_category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leave_category = $this->getLookupListByCode("LEAVECATEGORY");
        $leave = $this->getLookupListByCode("LEAVETYPE");
        // dd($leave_category);
        return template::loadview('admin.settings.leave_setup.leave_setup_create', ['leave' => $leave, 'leave_category' => $leave_category]);
    }

    public function popUpCreate()
    {
        $leave = $this->getLookupListByCode("LEAVETYPE");
        $leave_category = $this->getLookupListByCode("LEAVECATEGORY");
        // dd($leave);
        return template::loadview('admin.settings.leave_setup.create_new_leave_setup_form', ['leave' => $leave, 'leave_category' => $leave_category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $ex = explode('_', $request->leave_type);
        // dd($ex);
        $auth_id = Auth::id();

        DB::beginTransaction();
        try {
            $data = [
                // 'grade_no_pk' => $request->grade_uid,
                'no_of_days' => $request->leave_days,
                'leave_type_lkp_name' => $ex[0],
                // 'leave_type_lkp_name' => $request->leave_type,
                'leave_code' => $request->leave_code,
                'status' => $request->leave_status ? 1 : null,
                'carry_forword_ind' => $request->carry_forword_ind ? 1 : null,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
                'au_entry_session' => 1,
                'leave_type_lkp_no_fk' => $ex[1],
                'gender' => $request->gender,
                'leave_category_lookup_no_fk' => $request->leave_category
            ];
            // dd($request->all(), $data);
            if ($id == null) {
                $data['au_entry_by'] = $auth_id;
                // return $data;
                $this->model->create($data);
            } else {
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
    
    public function getAllLeaveList(Request $request)
    {
        $cat_id = $request->category_id != "" ? 'AND LEAVE_CATEGORY_LOOKUP_NO_FK =' . $request->category_id : '';
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $where = "AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id $cat_id ";
        $table = 'hrms_leavetype_days';
        $primaryKey = 'leavetypedays_no_pk';
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'leave_type_lkp_name', 'dt' => 1),
            array('db' => 'no_of_days', 'dt' => 2),
            array('db' => 'status', 'dt' => 3),
            array('db' => 'leavetypedays_no_pk', 'dt' => 4),
        );

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function editGradeList($id)
    {
        $leave_data = $this->model->show($id);
        // dd($leave_data);
        $leave = $this->getLookupListByCode("LEAVETYPE");
        $leave_category = $this->getLookupListByCode("LEAVECATEGORY");
        // dd($leave_data);
        return template::loadview('admin.settings.leave_setup.create_new_leave_setup_form', ['leave_data' => $leave_data, 'leave' => $leave, 'leave_category' => $leave_category]);
    }

    public function checkLeaveType(Request $request)
    {
        $leave = $this->getLookupListByCode("LEAVETYPE");

        $data = DB::table('hrms_leavetype_days')
            ->select('hrms_leavetype_days.leave_type_lkp_no_fk')
            ->where('leave_category_lookup_no_fk', $request->cate_id)
            ->get();

        $name = [];

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $name[$value->leave_type_lkp_no_fk] = $value->leave_type_lkp_no_fk;
            }
        }
        
        foreach ($name as $index) {
            if (array_key_exists($index, $leave)) {
                unset($leave[$index]);
            }
        }
        // dd($leave, $data, $name);
        return response()->json($leave);
    }
}
