<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Template;
use App\Models\Designation;
use Auth;
use DB;
use Session;
use App\Traits\DatatablesLoader;
use App\Repositories\BaseRepository as Repo;
use App\Datatables\DataTableClass;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use DatatablesLoader;
    protected $model;
    public function __construct(Designation $designation)
    {
        $this->middleware('auth');

        $this->model = new Repo($designation);
    }
    public function index()
    {

        return Template::loadview("admin.settings.designation.designation_list");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $grade = DB::table("HRMS_GRADE")->select("grade_no_pk", "grade_name")->where('status', 1)->orderBy('grade_name', 'asc')->get();

        return Template::loadview("admin.settings.designation.create_designation", [
            "grade" => $grade
        ]);
    }

    public function create_form()
    {
        //
        $grade = DB::table("HRMS_GRADE")->select("grade_no_pk", "grade_name")->where('status', 1)->orderBy('grade_name', 'asc')->get();
        return Template::loadview("admin.settings.designation.create_designation_form", [
            "grade" => $grade
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $id = $request->id;
        $hostpital = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();
        DB::beginTransaction();
        try {
            $data = [
                'designation_code'       => $request->desgination_code,
                'designation_name'       => $request->desgination,
                'grade_no_fk'            => $request->grade,
                'strength'               => $request->strength,
                'status'                 => $request->status ? $request->status : 0,
                'au_entry_session'       => 'session',
                'au_entry_hospital_pk_no' => $hostpital,
            ];

            if ($id == "") {

                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;

                $this->model->create($data);
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
        //
        $designation = $this->model->show($id);
        $grade = DB::table("HRMS_GRADE")->select("grade_no_pk", "grade_name")->orderBy('grade_name', 'asc')->where('status', 1)->get();

        return Template::loadview("admin.settings.designation.create_designation_form", [
            'designation'  =>  $designation, 'grade' => $grade
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
    public function getAllDesignation(Request $request)
    {
        // $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        // $columns = array(
        //     'sl',
        //     'designation_code',
        //     'designation_name',
        //     'grade_name',
        //     'strength',
        //     'designation_no_pk'

        // );

        // $sql = "SELECT '' as sl, a.designation_code,a.designation_name,b.grade_name,a.strength,a.designation_no_pk,rownum rownumber, a.au_update_at, a.au_entry_at from hrms_designation a left join hrms_grade b on a.grade_no_fk = b.grade_no_pk WHERE a.AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id";
        // $order_by_column = "designation_no_pk";

        // $json_data = $this->datatable($request, $sql, $order_by_column, 'desc', $columns);

        // echo json_encode($json_data);

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        $table = 'hrms_designation_grade_vw';
        // Table's primary key
        $primaryKey = 'designation_no_pk';

        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'designation_code', 'dt' => 1),
            array('db' => 'designation_name',  'dt' => 2),
            array('db' => 'grade_name',   'dt' => 3),
            array('db' => 'strength',   'dt' => 4),
            array('db' => 'designation_no_pk',   'dt' => 5)
        );

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }


    }
}
