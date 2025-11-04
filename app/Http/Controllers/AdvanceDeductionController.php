<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdvanceDeduction;
use Auth;
use DB;
use App\Traits\LookupData;
use App\Traits\DatatablesLoader;
use App\Library\Template;
use App\Repositories\BaseRepository as Repo;
use App\Datatables\DataTableClass;
use Session;

class AdvanceDeductionController extends Controller
{


    use LookupData, DatatablesLoader;

    public function __construct(AdvanceDeduction $AdvanceDeduction)
    {
        $this->middleware('auth');

        $this->model = new Repo($AdvanceDeduction);
    }

    public function index()
    {
        return template::loadview('admin.settings.advance_deduction.advance_deduction_list');
    }

    public function create()
    {
        $advanceDeduction = $this->getLookUpListByCode('ADVANCE DEDUCTION');
        return template::loadview('admin.settings.advance_deduction.advance_deduction_add', ['advanceDeduction' => $advanceDeduction]);
    }

    public function advance_deduction_popup()
    {
        $advanceDeduction = $this->getLookUpListByCode('ADVANCE DEDUCTION');
        return template::loadview('admin.settings.advance_deduction.advance_deduction_popUp', ['advanceDeduction' => $advanceDeduction]);
        // dd($advanceDeduction);
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
        $auth_id = Auth::id();
        DB::beginTransaction();
        try {

            $data = [
                'person_no_fk' => $request->hdn_item_item_id_0,
                'addded_type' => $request->deduction_type,
                'amount' => $request->amount,
                'remarks' => $request->remarks,
                'year_yyyymm' => $request->year . '' . $request->month,
                'addded_date' => date('Y-m-d', strtotime($request->date)),
                'status' => $request->ad_deduction_status ? 1 : null,
                'au_entry_hospital_pk_no' => Session::get('user.ses_hospital_no_pk'),
                'au_entry_session' => "Session",
            ];

            if ($id == null) {
                $data['au_entry_by'] = $auth_id;
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
    public function getAllDeduction(Request $request)
    {


        $table = 'hrms_advance_deduct_vw';
        $primaryKey = 'addded_no_pk';
        $sql_cond = "";
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= " $clause au_entry_hospital_pk_no = '$hospital_id'";
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'full_name', 'dt' => 1),
            array('db' => 'lookupdata_name', 'dt' => 2),
            array('db' => 'year_yyyymm', 'dt' => 3),
            array('db' => 'amount', 'dt' => 4),
            array('db' => 'remarks', 'dt' => 5),
            array('db' => 'addded_date', 'dt' => 6),
            array('db' => 'addded_no_pk', 'dt' => 7)
        );

        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function editAdvanceDeduction($id)
    {

        $data = DB::table('hrms_personnel_sal_add_ded')->select('year_yyyymm as yy')->where('addded_no_pk', $id)
            ->get();
        $yyyy = str_split($data, 4);
        $year = $yyyy[2];
        $month = str_split($yyyy[3], 2);
        $month_data = $month[0];

        $advance = DB::table("hrms_personnel_sal_add_ded a")->where('addded_no_pk', $id)->leftjoin('hrms_personnel b ', 'a.person_no_fk', 'b.person_no_pk')
            ->leftjoin('sysc_lookup_data c', 'a.addded_type', 'c.lookupdata_no_pk')->select('b.full_name', 'c.lookupdata_name', 'c.lookupdata_code', 'a.amount', 'a.remarks', 'a.addded_date', 'a.status', 'a.addded_no_pk', 'b.person_no_pk')->first();

        $advanceDeduction = $this->getLookUpListByCode('ADVANCE DEDUCTION');
        return template::loadview('admin.settings.advance_deduction.advance_deduction_popUp', [
            'advanceDeduction' => $advanceDeduction, 'advance' => $advance,
            'year' => $year,
            'month_data' => $month_data
        ]);
    }
}
