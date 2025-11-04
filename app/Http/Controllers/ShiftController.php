<?php

namespace App\Http\Controllers;

use App\Library\Template;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\DatatablesLoader;
use App\Http\Requests\ShiftRequest;
use App\Repositories\BaseRepository as Repo;
use Auth;
use DB;
use Session;
use App\Models\ShiftType;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ShiftController extends Controller
{
    use DatatablesLoader;
    protected $model;

    public function __construct(ShiftType $shift)
    {
        $this->middleware('auth');

        $this->model = new Repo($shift);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Template::loadview("admin.settings.shift.shift_list");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Template::loadview("admin.settings.shift.create_shift");
    }

    public function create_form()
    {
        return Template::loadView("admin.settings.shift.create_shift_form");
    }

    public function uomCreate()
    {
        return Template::loadView("admin.settings.shift.uom_form");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShiftRequest $request)
    {
        // return $request;
        $id = $request->id;

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();
        $start_time = (date("H:i", strtotime($request->start_time)));
        $end_time = (date("H:i", strtotime($request->end_time)));
        $startTime = Carbon::createFromTimeString($request->start_time);
        $endTime = Carbon::createFromTimeString($request->end_time);
        $hours = $endTime->diffInHours($startTime);
        $status = (($request->status == 1) ? 1 : 0);
        DB::beginTransaction();
        try {
            $data = [

                'shift_code' => $request->shift_code,
                'start_time' => date('Y/m/d', strtotime($request->start_date)) . " " . $start_time,
                'end_time' => date('Y/m/d', strtotime($request->end_date)) . " " . $end_time,
                'minimum_in_time' => ($request->min_in_time != '') ? date('Y/m/d H:i', strtotime($request->min_in_time)) : '',
                'maximum_out_time' => ($request->max_out_time != '') ?  date('Y/m/d H:i', strtotime($request->max_out_time)) : '',
                'grace_in_time_min' => $request->Grace_in_time_min,
                'grace_out_time_min' => $request->Grace_out_time_min,
                'shift_desc' => $request->shift_description,
                'sheft_hour' => $hours,
                'status' => $status,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
                'au_entry_session' => 'session',
            ];
            // dd($data);
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
        $data = $this->model->show($id);
        return Template::loadView("admin.settings.shift.create_shift_form", ['shift' => $data]);
    }
    public function editUom($id)
    {
        $data = DB::table('SYSC_SERVICEITEM_UOM')->where('id', $id)->first();
        return Template::loadView("admin.settings.shift.uom_form", ['shift' => $data]);
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
    public function getShiftInfoById($id)
    {
        return $id;
    }

    public function getAllShifts(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            'sl',
            'shift_code',
            'start_time',
            'end_time',
            'minimum_in_time',
            'maximum_out_time',
            'grace_in_time_min',
            'grace_out_time_min',
            'shift_no_pk',


        );

        $sql = "SELECT '' as sl, shift_code,   to_char(start_time, 'fmHH:MI AM') start_time, to_char(end_time, 'fmHH:MI AM') end_time, to_char(minimum_in_time, 'fmHH:MI AM') minimum_in_time, to_char(maximum_out_time, 'fmHH:MI AM')maximum_out_time,grace_in_time_min,grace_out_time_min ,shift_no_pk, rownum rownumber, au_update_at,au_entry_at from hrms_shift";
        // -- where au_entry_hospital_pk_no = $ses_hospital_id ";
        $order_by_column = "shift_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'desc', $columns);

        echo json_encode($json_data);
    }


    public function uomList()
    {
        return Template::loadview("admin.settings.shift.uom_list");
    }

    public function getUomList(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            'sl',
            'uom_code',
            'uom_label_desc',
            'uom_no_pk'
        );

        $sql = "SELECT '' as sl,uom_code,uom_label_desc,uom_no_pk, rownum rownumber, au_update_at,au_entry_at from SYSC_SERVICEITEM_UOM";
        // -- where au_entry_hospital_pk_no = $ses_hospital_id ";
        $order_by_column = "shift_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'desc', $columns);

        echo json_encode($json_data);
    }



}

