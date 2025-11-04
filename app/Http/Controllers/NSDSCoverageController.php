<?php

namespace App\Http\Controllers;

use App\Library\Template;
use App\Http\Controllers\Controller;
use App\Traits\DatatablesLoader;
use App\Traits\LookupData;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Repositories\BaseRepository AS Repo;
use Auth;
use DB;
use Session;
use App\Models\NSDSCoverage;
use App\Models\Ward;
use App\Models\NurseStationDoctorStation;

class NSDSCoverageController extends Controller
{
    use DatatablesLoader, LookupData;
    protected $model;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(NSDSCoverage $wcnsds)
    {
        $this->middleware('auth');

        $this->model = new Repo($wcnsds);
    }

    public function index()
    {
        return Template::loadview("admin.settings.nsdsCoverage.wcnsds_list");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create_form()
    {
        $ward = Ward::select('ward_no_pk', 'ward_name')->get();
        $nsds = NurseStationDoctorStation::select('nsds_no_pk', 'nsds_name')->get();
        return Template::loadview("admin.settings.nsdsCoverage.create_wcnsds", [
            'ward' => $ward,
            'nsds' => $nsds
        ]);
    }


    public function create()
    {
        $ward = Ward::select('ward_no_pk', 'ward_name')->get();
        $nsds = NurseStationDoctorStation::select('nsds_no_pk', 'nsds_name')->get();
        return Template::loadview("admin.settings.nsdsCoverage.create_wcnsds_form", [
            'ward' => $ward,
            'nsds' => $nsds
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getAllWcnsdsSetup(Request $request)
    {
        $columns = array(
            'sl',
            'nsds_name',
            'ward_name',
            'status_txt',
            'nsdscoverage_no_pk'
        );

        $sql = "SELECT '' as sl, ipds_wardcoverage_nsds.nsdscoverage_no_pk, ipds_wardcoverage_nsds.nsds_no_fk, ipds_nsds.nsds_name,  ipds_wardcoverage_nsds.ward_no_fk, ipds_ward.ward_name, rownum rownumber, ipds_wardcoverage_nsds.au_update_at, ipds_wardcoverage_nsds.au_entry_at,
        CASE ipds_wardcoverage_nsds.status WHEN 1 THEN 'Active' ELSE 'Inactive' END status_txt
        from ipds_wardcoverage_nsds  left join ipds_nsds on  ipds_wardcoverage_nsds.nsds_no_fk = ipds_nsds.nsds_no_pk
        left join ipds_ward on ipds_wardcoverage_nsds.ward_no_fk = ipds_ward.ward_no_pk";
        $order_by_column = "nsdscoverage_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'desc', $columns);

        echo json_encode($json_data);

    }

    public function editWcnsdsSetup($id)
    {
        $nsdsCoverage = $this->model->show($id);
        $ward = Ward::select('ward_no_pk', 'ward_name')->get();
        $nsds = NurseStationDoctorStation::select('nsds_no_pk', 'nsds_name')->get();
        return Template::loadview("admin.settings.nsdsCoverage.create_wcnsds_form", [
            'ward' => $ward,
            'nsds' => $nsds,
            'nsdsCoverage' => $nsdsCoverage
        ]);
    }

    public function storeWcnsds(Request $request)
    {
     $nsds_no_fk = $request->nsds_no_fk;
     $ward_no_fk = $request->ward_no_fk;
     $ses_hospital_id = Session::get('user.ses_hospital_id');
     $validationArr = [
        'nsds_no_fk' => 'required',
        'ward_no_fk' => 'required',
    ];

    $validator = Validator::make($request->all(), $validationArr);
    $validator->after(function ($validator) use ($nsds_no_fk, $ward_no_fk) {
        $sql=DB::table('ipds_wardcoverage_nsds')->where('nsds_no_fk', $nsds_no_fk)->where('ward_no_fk', $ward_no_fk)->get();
        if (!$sql->isEmpty()){
            return $validator->errors()->add('error', 'Unable to recreate the same Ward Coverage NSDS.');
        }
    });
    $validator->validate(); 
    $id = $request->id;
    $auth_id = Auth::id();
    DB::beginTransaction();
    try {
        $data = [
            'nsds_no_fk' => $request->nsds_no_fk,
            'ward_no_fk' => $request->ward_no_fk,
            'status' => $request->status
        ];

        if ($id == "") {

            $data['au_entry_by'] = $auth_id;
            $data['au_entry_hospital_no_fk'] =  $ses_hospital_id;
            $this->model->create($data);
        } else {
                // AU_UPDATE_BY
            $data['au_update_by'] = $auth_id;
            $data['au_update_hospital_no_fk'] = $ses_hospital_id;
            $this->model->update($data, $id);
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
}
