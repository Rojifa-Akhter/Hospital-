<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Template;
use App\Models\HolidayEntry;
use App\Traits\DatatablesLoader;
use Auth;
use DB;
use Session;
use App\Repositories\BaseRepository as Repo;
use App\Datatables\DataTableClass;

class HolidayEntryController extends Controller
{
    use DatatablesLoader;
    protected $model;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(HolidayEntry $HolidayEntry)
    {
        $this->middleware('auth');

        $this->model = new Repo($HolidayEntry);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function popup()
    {
        return template::loadview('admin.settings.holiday_entry.all_holiday');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return template::loadview("admin.settings.holiday_entry.all_holiday");
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
        $finalDate = explode(',', $request->holiday_entry_data);
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        
        for ($i = 0; $i < sizeof($finalDate); $i++) {

            DB::beginTransaction();

            $ex = explode("-", date("Y-M-d", strtotime($finalDate[$i])));

            try {

                $data = [
                    // 'grade_no_pk' => $request->grade_uid,

                    'holiday_year' => $ex[0],
                    'holiday_name' => $request->holiday_name,
                    'holiday_date' => (string) date("Y-M-d", strtotime($finalDate[$i])),
                    'au_update_session' => 1,
                    'au_entry_session' => 1,
                    'au_entry_hospital_pk_no' => $ses_hospital_id,
                ];

                if ($id == null) {
                    // AU_ENTRY_BY
                    $data['au_entry_by'] = $auth_id;
                    // return $data;
                    $this->model->create($data);

                    // dd($data);

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
    public function getAllHolidaysEntry(Request $request)
    {
        // $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        // $columns = array(
        //     'sl',
        //     'holiday_name',
        //     'holiday_date',
        //     'holiday_year',
        //     'holiday_no_pk'
        // );
        // $sql = "SELECT '' AS sl,
        //            holiday_name,
        //            to_char (holiday_date,'dd/mm/yyyy') holiday_date,
        //            holiday_year,
        //            holiday_no_pk,
        //            ROWNUM rownumber,
        //            au_update_at,
        //            au_entry_at
        //       FROM hrms_holiday where AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id ";
        // $order_by_column = "holiday_no_pk";
        // $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);
        // // dd($json_data);
        // echo json_encode($json_data);

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $where = "AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id";
        $table ="hrms_holiday";
        $primaryKey = 'holiday_no_pk';
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'holiday_name', 'dt' => 1),
            array('db' => 'holiday_date', 'dt' => 2),
            array('db' => 'holiday_year', 'dt' => 3),
            array('db' => 'holiday_no_pk', 'dt' => 4),
        );
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }


    public function editHolidayList($id)
    {

        $holiday_data = $this->model->show($id);
        // dd($holiday_data);
        return template::loadview('admin.settings.holiday_entry.edit_holiday_form', ['holiday_data' => $holiday_data]);
    }
}
