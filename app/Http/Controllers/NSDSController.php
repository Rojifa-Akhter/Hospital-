<?php

namespace App\Http\Controllers;

use App\Library\Template;
use App\Http\Controllers\Controller;
use App\Traits\DatatablesLoader;
use App\Traits\LookupData;
use App\Datatables\DataTableClass;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository as Repo;
use Auth;
use DB;
use App\Models\NurseStationDoctorStation;
use App\Models\Room;
use Session;
use App\Models\Nsds;

class NSDSController extends Controller
{
    use DatatablesLoader, LookupData;
    protected $model;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(NurseStationDoctorStation $nsds)
    {
        $this->middleware('auth');
        $this->model_nsds = new Repo($nsds);
    }

    public function index()
    {
        return Template::loadview("admin.settings.nsds.nsds_list");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create()
    {
        $room = Room::select('room_no_pk', 'room_name')->where('ipd_ind', 1)->get();
        $person = DB::table('hrms_personnel')->select('person_no_pk', 'full_name')->get();
        $ns_types = $this->getLookupListByCode("NURSESTATIONTYPE");

        $department = DB::table('sysc_serviceunit_vw')
        ->select('serviceunit_name', 'serviceunit_no_pk')
        ->where('status',1)
        ->where('ipd_ind',1)
        ->where('med_store_ind',1)
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->orderBy('serviceunit_name', 'asc')
        ->get();

        // dd($department);

        return Template::loadview("admin.settings.nsds.create_nsds_form", [
            'person' => $person,
            'room' => $room,
            'ns_types' => $ns_types,
            'department' => $department,
        ]);
    }


    public function create_form()
    {
        $room = Room::select('room_no_pk', 'room_name')->where('ipd_ind', 1)->get();
        $person = DB::table('hrms_personnel')->select('person_no_pk', 'full_name')->get();
        $ns_types = $this->getLookupListByCode("NURSESTATIONTYPE");

        return Template::loadview("admin.settings.nsds.create_nsds", [
            'person' => $person,
            'room' => $room,
            'ns_types' => $ns_types,
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



    public function getAllNSDSSetup(Request $request)
    {

        $ses_hospital_id = Session::get('user.IPDS_NSDS_SEQ');
        $where = "AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id";
        $table ='IPDS_NSDS_VW';
        $primaryKey = 'nsds_no_pk';
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'nsds_name', 'dt' => 1),
            array('db' => 'nsds_uid', 'dt' => 2),
            array('db' => 'room_name', 'dt' => 3),
            array('db' => 'category', 'dt' => 4),
            array('db' => 'service_unit', 'dt' => 5),
            array('db' => 'full_name', 'dt' => 6),
            array('db' => 'lookupdata_name', 'dt' => 7),
            array('db' => 'ns_ind', 'dt' => 8),
            array('db' => 'ds_ind', 'dt' => 9),
            array('db' => 'serviceunit_name', 'dt' => 10),
            array('db' => 'status_txt', 'dt' => 11),
            array('db' => 'nsds_no_pk', 'dt' => 12),
        );

        // if (!empty($where)) {
            // echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        // } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        // }
    }

    public function editNSDSSetup($id)
    {
        $nsds = $this->model_nsds->show($id);
        $room = Room::select('room_no_pk', 'room_name')->where('ipd_ind', 1)->get();
        // dd($room);
        $person = DB::table('HRMS_PERSONNEL')->select('person_no_pk', 'full_name')->get();

        $ns_types = $this->getLookupListByCode("NURSESTATIONTYPE");
        // dd($ns_types);
        $department = DB::table('sysc_serviceunit_vw')
        ->select('serviceunit_name', 'serviceunit_no_pk')
        ->where('status',1)
          ->where('ipd_ind',1)
          ->where('med_store_ind',1)
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->orderBy('serviceunit_name', 'asc')
        ->get();

        return Template::loadview("admin.settings.nsds.create_nsds_form", [
            'nsds' => $nsds,
            'person' => $person,
            'room' => $room,
            'ns_types' => $ns_types,
            'department' => $department,
        ]);
    }

    public function storeNSDS(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_id');
        $auth_id = Auth::id();
        DB::beginTransaction();
        try {
            if ($request->nsds_ind == 1) {
                $ns_ind = 1;
                $ds_ind = 0;
            } else {
                $ns_ind = 0;
                $ds_ind = 1;
            }
            $data = [
                'nsds_name' => $request->nsds_name,
                'nsds_uid' => $request->nsds_uid,
                'ns_ind' => $ns_ind,
                'ds_ind' => $ds_ind,
                'room_no_fk' => $request->room_no_fk,
                'sup_person_no_fk' => $request->sup_person_no_fk,
                'nursestation_type' => $request->nursestation_type,
                'status' => $request->status,
                'su_no_fk' => $request->su_no_fk
            ];

            if ($id == "") {

                $data['au_entry_by'] = $auth_id;
                $data['au_entry_hospital_no_fk'] =  $ses_hospital_id;
                $this->model_nsds->create($data);
            } else {
                // dd($data);
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_no_fk'] = $ses_hospital_id;
                $this->model_nsds->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
}
