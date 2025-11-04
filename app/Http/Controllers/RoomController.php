<?php

namespace App\Http\Controllers;

use App\Library\Template;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Traits\DatatablesLoader;
use App\Traits\LookupData;
use Illuminate\Http\Request;
use App\Http\Requests\LookUpMapRequest;
use App\Repositories\BaseRepository as Repo;
use Auth;
use DB;
use App\Models\Room;
use App\Models\ServiceUnit;
use App\Models\LookUpMap;
use Session;
use App\Datatables\DataTableClass;

class RoomController extends Controller
{
    use DatatablesLoader, LookupData;
    protected $model;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Room $room, LookUpMap $LookUpMap)
    {
        $this->middleware('auth');

        $this->model = new Repo($room);
        $this->model2 = new Repo($LookUpMap);
    }
    public function index()
    {
        return Template::loadview("admin.settings.room.room_list");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $service_unit = ServiceUnit::select('serviceunit_no_pk', 'serviceunit_name')->get();
        $category = $this->getLookupListByCode("ROOMCAT");
        $floorWiseRoom = DB::table('sysc_physicalstructfloor_vw')->get();
        return Template::loadview("admin.settings.room.create_room", [
            'category'  =>  $category,
            'floorWiseRoom'  =>  $floorWiseRoom,
            'service_unit'  =>  $service_unit
        ]);
    }
    public function assetRoomSetup()
    {
        $service_unit = ServiceUnit::select('serviceunit_no_pk', 'serviceunit_name')->get();
        $category = $this->getLookupListByCode("ROOMCAT");
        $floorWiseRoom = DB::table('sysc_physicalstructfloor_vw')->get();
        return Template::loadview("admin.settings.room.create_asset_room", [
            'category'  =>  $category,
            'floorWiseRoom'  =>  $floorWiseRoom,
            'service_unit'  =>  $service_unit
        ]);
    }

    public function create_form()
    {

        $service_unit = ServiceUnit::select('serviceunit_no_pk', 'serviceunit_name')->get();
        $category = $this->getLookupListByCode("ROOMCAT");
        $floorWiseRoom = DB::table('sysc_physicalstructfloor_vw')->get();
        return Template::loadview("admin.settings.room.create_room_form", [
            'category'  =>  $category,
            'floorWiseRoom'  =>  $floorWiseRoom,
            'service_unit'  =>  $service_unit
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {
        // return $request;
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();

        DB::beginTransaction();
        try {
            $data = [
                'room_code' => $request->room_code,
                'room_name' => $request->room_name,
                'room_description' => $request->room_description,
                'room_capacity' => $request->room_capacity,
                'room_category_lookup_no_fk' => $request->category_lookup,
                'serviceunit_no_fk' => $request->serviceunit_no_fk,
                'room_size' => $request->room_size,
                'physicalstrucure_no_fk' => $request->physicalstruct_no_pk,
                'ipd_ind' => $request->ipd == '1' ? '1' : 0,
                'opd_ind' => $request->opd  == '1' ? '1' : 0,
                'ot_ind' => $request->ot  == '1' ? '1' : 0,
                'physio_ind' => $request->physio  == '1' ? '1' : 0,
                'store_location_ind' => $request->store_location  == '1' ? '1' : 0,
                'open_location_ind' => $request->open_loction  == '1' ? '1' : 0,

                'asset_location_ind' => $request->asset_location_ind  == '1' ? '1' : 0,
                'duty_location_ind' => $request->duty_location_ind  == '1' ? '1' : 0,

                'status' => $request->status ? $request->status : 0,
                'au_entry_hospital_no_fk' => $ses_hospital_id,

            ];
            if ($id == null || $id == "") {

                // AU_ENTRY_BY
                if ($request->serviceunit_no_fk == 1099) {
                    $data['physio_ind'] = 1;
                }
                $data['au_entry_by'] = $auth_id;

                $this->model->create($data);
                // return $res;

            } else {
                // AU_UPDATE_BY
                if ($request->serviceunit_no_fk == 1099) {
                    $data['physio_ind'] = 1;
                }
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
        $room = $this->model->show($id);
        // dd($room);
        $service_unit = ServiceUnit::select('serviceunit_no_pk', 'serviceunit_name')->get();
        $category = $this->getLookupListByCode("ROOMCAT");
        $floorWiseRoom = DB::table('sysc_physicalstructfloor_vw')->get();
        return Template::loadview("admin.settings.room.create_room_form", [
            'room'  =>  $room,
            'category'  =>  $category,
            'floorWiseRoom'  =>  $floorWiseRoom,
            'service_unit'  =>  $service_unit
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

    public function getAllRoom(Request $request)
    {

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $where = "AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id";

        $table ="SYSC_ROOM_SU_VW";

        $primaryKey = 'room_no_pk';
        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'room_code', 'dt' => 1),
            array('db' => 'room_name', 'dt' => 2),
            array('db' => 'room_capacity', 'dt' => 3),
            array('db' => 'room_size', 'dt' => 4),
            array('db' => 'serviceunit_name', 'dt' => 5),
            array('db' => 'lookupdata_name', 'dt' => 6),
            array('db' => 'room_no_pk', 'dt' => 7),
        );


        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {
            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }



        // $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        // $columns = array(
        //     'sl',
        //     'room_code',
        //     'room_name',
        //     'room_capacity',
        //     'room_size',
        //     'serviceunit_name',
        //     'lookupdata_name',
        //     'room_no_pk'
        // );

        // $sql = "SELECT '' as sl, a.room_code, a.room_name, a.room_capacity, a.room_size, su.serviceunit_name serviceunit_name, ld.lookupdata_name lookupdata_name,a.room_no_pk, rownum rownumber, a.au_update_at, a.au_entry_at from sysc_room a
        // LEFT JOIN sysc_lookupdata ld on ld.lookupdata_no_pk =  a.room_category_lookup_no_fk
        // LEFT JOIN sysc_serviceunit su on su.serviceunit_no_pk = a.serviceunit_no_fk
        // where a.AU_ENTRY_HOSPITAL_NO_FK = $ses_hospital_id
        // ";
        // $order_by_column = "room_no_pk";

        // $json_data = $this->datatable($request, $sql, $order_by_column, 'DESC', $columns);

        // echo json_encode($json_data);
    }

    // Get User Room

    public function userRoomSetup()
    {
        return Template::loadview("admin.settings.room.user_room_setup");
    }

    public function getAllUserRoomSetup(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            'sl',
            'user_fullname',
            'serviceunit_name',
            'room_name',
            'lookupmap_no_pk'
        );

        $sql = "SELECT '' as sl, wsec_user.user_fullname,sysc_serviceunit.SERVICEUNIT_NAME, sysc_room.room_name, sysc_lookupmap.lookupmap_no_pk, rownum rownumber, sysc_lookupmap.au_update_at,sysc_lookupmap.au_entry_at from sysc_lookupmap LEFT JOIN wsec_user ON wsec_user.user_no_pk = sysc_lookupmap.user_no_fk LEFT JOIN
        sysc_room ON sysc_room.room_no_pk = sysc_lookupmap.room_no_fk LEFT JOIN sysc_serviceunit ON sysc_serviceunit.SERVICEUNIT_NO_PK = sysc_lookupmap.su_no_fk ";
        $order_by_column = "sysc_lookupmap.lookupmap_no_pk";
        // where sysc_lookupmap.au_entry_hospital_no_fk = $ses_hospital_id
        $json_data = $this->datatable($request, $sql, $order_by_column, 'DESC', $columns);

        echo json_encode($json_data);
    }


    public function userRoomSetupPopup()
    {
        $user_name = DB::table("wsec_user")->select('user_no_pk', 'user_fullname')->where('status', '1')->get();
        $department_name = DB::table('sysc_serviceunit')->where('status', '1')->get();
        $room_no = Room::where('status', '1')->get();
        return Template::loadview("admin.settings.room.user_room_setup_popup", ["user_name" => $user_name, "department_name" => $department_name, "room_no" => $room_no]);
    }

    public function editUserRoomSetup($id)
    {

        $roomSetup = $this->model2->show($id);
        //  dd($roomSetup);
        $user_name = DB::table("wsec_user")->select('user_no_pk', 'user_fullname')->where('status', '1')->get();
        $department_name = DB::table('sysc_serviceunit')->where('status', '1')->get();
        $room_no = Room::where('status', '1')->get();
        return Template::loadview("admin.settings.room.user_room_setup_popup", ["roomSetup" => $roomSetup, "user_name" => $user_name, "department_name" => $department_name, "room_no" => $room_no]);
    }


    public function storeuserroom(LookUpMapRequest $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $id = $request->id;
        $auth_id = Auth::id();
        $lookup_id = $this->getLookupIDByCode("USERROOM");
        DB::beginTransaction();
        try {
            $data = [
                'user_no_fk' => $request->user_no_fk,
                'su_no_fk' => $request->su_no_fk,
                'room_no_fk' => $request->room_no_fk,
                'lookup_no_fk' => $lookup_id,
                'status' => 1,
                'au_entry_hospital_no_fk' => $ses_hospital_id,

            ];

            if ($id == "") {

                $data['au_entry_by'] = $auth_id;
                $this->model2->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
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


    public function getAllRoomSetup(Request $request)
    {

        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $columns = array(
            'sl',
            'category',
            'service_unit',
            'room_uid',
            'room_name',
            'room_capacity',
            'room_size',
            'room_no_pk'
        );

        $sql = "SELECT '' as sl, category,service_unit,  room_uid, room_name, room_capacity, room_size,room_no_pk, rownum rownumber, au_update_at, au_entry_at from room_list_vw where au_entry_hospital_no_fk =   $ses_hospital_id ";
        $order_by_column = "room_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'desc', $columns);

        echo json_encode($json_data);
    }

    public function editRoomSetup($id)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_id');
        $room = $this->model->show($id);

        $service_unit = ServiceUnit::select('su_no_pk', 'su_name')->where("au_entry_hospital_no_fk", $ses_hospital_id)->get();
        $category = $this->getLookupListByCode("RMCAT");
        return Template::loadview("admin.settings.room.create_room_form", [
            'category' => $category,
            'service_unit' => $service_unit,
            'room' => $room
        ]);
    }

    // public function storeRoom(Request $request)
    // {

    //     $id = $request->id;
    //     $ses_hospital_id = Session::get('user.ses_hospital_id');

    //     $auth_id = Auth::id();

    //     DB::beginTransaction();
    //     try {
    //         $data = [
    //             'room_uid' => $request->room_uid,
    //             'room_name' => $request->room_name,
    //             'room_description' => $request->room_description,
    //             'room_capacity' => $request->room_capacity,
    //             'room_size' => $request->room_size,
    //             'su_no_fk' => $request->su_no_pk,
    //             'room_category_lup_no_fk' => $request->category_lookup,
    //             'status' => $request->status,

    //         ];

    //         if ($id == "") {

    //             $data['au_entry_by'] = $auth_id;
    //             $data['au_entry_hospital_no_fk'] =  $ses_hospital_id;
    //             $this->model->create($data);
    //         } else {
    //             // AU_UPDATE_BY
    //             $data['au_update_by'] = $auth_id;
    //             $data['au_update_hospital_no_fk'] = $ses_hospital_id;
    //             $this->model->update($data, $id);
    //         }


    //         DB::commit();
    //         $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
    //     }
    //     // dd($data);
    //     return response()->json($message);

    // }

    public function getRoomData(Request $request)
    {


        $room_number = Room::select("room_name", "room_no_pk")
            // ->where("serviceunit_no_fk", $request->id)
            ->get();

        $data = '';
        $data .= '
        <select name="room_no_fk" id="room" class=\'form-control select2\'>
        <option value="" selected="selected">Select Room</option>>
        ';
        if (!empty($room_number)) {
            foreach ($room_number as $value) {
                $data .= ' <option value="' . $value->room_no_pk . '">
                ' .
                    $value->room_name . '
                </option>';
            }
        } else {
            $data .= '<option>No Image Found</option>';
        }
        $data .= '</select>';
        echo $data;
    }

    public function getUserRoomInfo(Request $request)
    {
        $room_number = DB::table("sysc_user_room_privs_vw")
            ->select("room_no_pk", "room_name")
            ->where("user_no_fk", Auth::id())
            ->where("serviceunit_no_pk", $request->id)
            ->where("au_entry_hospital_no_fk", Session::get('user.ses_hospital_no_pk'))
            ->get();

        $data = '';
        $data .= '
        <select name="room_no_fk" id="room" class=\'form-control select2\'>
        <option value="" selected="selected">Select Room</option>>
        ';
        if (!empty($room_number)) {
            foreach ($room_number as $value) {
                $data .= ' <option value="' . $value->room_no_pk . '">
                ' .
                    $value->room_name . '
                </option>';
            }
        } else {
            $data .= '<option>No Image Found</option>';
        }
        $data .= '</select>';
        echo $data;
    }
}
