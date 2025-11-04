<?php

namespace App\Http\Controllers;

use App\Library\Template;

use Illuminate\Http\Request;
use App\Traits\DatatablesLoader;
use App\Traits\LookupData;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Session;
use App\Models\Grade;
use App\Repositories\BaseRepository as Repo;

class GradeController extends Controller
{
    use DatatablesLoader, LookupData;
    protected $model;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Grade $grade)
    {
        $this->middleware('auth');

        $this->model = new Repo($grade);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grade = Grade::all();
        // dd($grade);
        return template::loadview("admin.settings.grade.all_grades", ['grade' => $grade]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gradePer = $this->getLookupListByCodeCustomKey("lookupdata_code", "SALARYFACTORGRADE");
        return template::loadview("admin.settings.grade.create_new_grade", ['gradePer' => $gradePer]);
    }
    public function create_grade_form()
    {
        return template::loadview("admin.settings.grade.create_new_blade_form");
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->grade_Per);
        //return $request;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $id = $request->id;


        $auth_id = Auth::id();

        DB::beginTransaction();
        try {

            $data = [

                // 'grade_no_pk' => $request->grade_uid,
                // 'total_wages' => $request->gross_salary,
                'grade_name' => $request->grade_name,
                'salary_grade_factor' => $request->grade_Per,
                'gross_salary' => $request->gross_salary,
                'basic_salary' => $request->basic_salary,
                'basic_salary_perc' => $request->basic_salary_per,
                'house_rent' => $request->house_rent,
                'house_rent_perc' => $request->house_rent_per,
                'medical_allow' => $request->medical_allowance,
                'medical_allow_perc' => $request->medical_allowance_per,
                'attendance_bonus' => $request->attendence_bonus,
                'conveyance_allow' => $request->Conveyance_allowance,
                'conveyance_allow_perc' => $request->Conveyance_allowance_per,
                'utility' => $request->utility,
                'utility_perc' => $request->utility_per,
                'entertainment' => $request->entertainment,
                'entertainment_perc' => $request->entertainment_per,
                'festival_bonus' => $request->festival_bonus,
                'festival_bonus_perc' => $request->festival_bonus_per,
                'ta_da' => $request->ta_da,
                'ta_da_perc' => $request->ta_da_per,
                'status' => $request->grade_status ? 1 : null,
                'au_entry_hospital_pk_no' =>$ses_hospital_id,
                'au_entry_session' => 1,
            ];

            if ($id == null) {
                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;
                // return $data;
                $this->model->create($data);
            } else {
                // dd($data);
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



    public function getAllGrades(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            'sl',
            'grade_name',
            'salary_grade_factor',
            'gross_salary',
            'basic_salary',
            'basic_salary_perc',
            'house_rent',
            'house_rent_perc',
            'medical_allow',
            'medical_allow_perc',
            'conveyance_allow',
            'conveyance_allow_perc',
            'utility',
            'utility_perc',
            'entertainment',
            'entertainment_perc',
            'festival_bonus',
            'festival_bonus_perc',
            'ta_da',
            'ta_da_perc',
            'attendance_bonus',
            'grade_no_pk'
        );

        $sql = "SELECT '' sl , grade_name,salary_grade_factor,gross_salary,basic_salary,basic_salary_perc,house_rent,house_rent_perc,medical_allow,medical_allow_perc,conveyance_allow,conveyance_allow_perc,utility,utility_perc,entertainment,entertainment_perc,festival_bonus,festival_bonus_perc,ta_da,ta_da_perc,attendance_bonus, grade_no_pk, rownum rownumber,  au_update_at,au_entry_at FROM HRMS_GRADE  where AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id ";

        $order_by_column = "grade_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);

        echo json_encode($json_data);
    }
    public function editGradeList($id)
    {
        $grade = $this->model->show($id);
        $gradePer = $this->getLookupListByCodeCustomKey("lookupdata_code", "SALARYFACTORGRADE");
        // dd($data);
        return template::loadview('admin.settings.grade.create_new_blade_form', ['grade' => $grade, 'gradePer' => $gradePer]);
    }
}
