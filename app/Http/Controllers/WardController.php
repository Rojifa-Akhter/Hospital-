<?php

namespace App\Http\Controllers;

use App\Library\Template;
use App\Traits\DatatablesLoader;
use App\Traits\LookupData;
use App\User;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository as Repo;
use Auth;
use DB;
use App\Models\Ward;
use App\Models\Bed;
use App\Models\Room;
use App\Models\Doctor;
use Session;
use App\Models\ServiceUnit;
use App\Datatables\DataTableClass;

class WardController extends Controller
{
    use DatatablesLoader, LookupData;
    protected $model;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Ward $ward)
    {
        $this->middleware('auth');
        $this->model_ward = new Repo($ward);
    }

    public function index()
    {
        return Template::loadview("admin.settings.ward.ward_list");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create_form()
    {
        $service_unit = DB::table('sysc_serviceunit')->where('IPD_IND', 1)->get();

        $category = $this->getLookupListByCode("CATEGORYTYPE");
        $room = DB::table('SYSC_ROOM')->where('status', 1)->get();
        $ward_types = $this->getLookupListByCode("WARDTYPE");
        //        dd($service_unit);
        return Template::loadview("admin.settings.ward.create_ward", [
            'category' => $category,
            'service_unit' => $service_unit,
            'room' => $room,
            'ward_types' => $ward_types,
        ]);
    }
    public function createwardPopup()
    {
        $service_unit = DB::table('SYSC_SERVICEUNIT')->where('IPD_IND', 1)->get();
        $category = $this->getLookupListByCode("CATEGORYTYPE");
        $room = DB::table('SYSC_ROOM')->where('status', 1)->get();
        $ward_types = $this->getLookupListByCode("WARDTYPE");
        //        dd($service_unit);
        return Template::loadview("admin.settings.ward.create_ward_form", [
            'category' => $category,
            'service_unit' => $service_unit,
            'room' => $room,
            'ward_types' => $ward_types,
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function getAllWardSetup(Request $request)
    {
        // $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        // $columns = array(
        //     'sl',
        //     'ward_uid',
        //     'ward_name',
        //     'wardtype_name',
        //     'category_name',
        //     'serviceunit_name',
        //     'room_name',
        //     'ccu_ind',
        //     'icu_ind',
        //     'nicu_ind',
        //     'hdu_ind',
        //     'emr_ind',
        //     'vip_ind',
        //     'status_txt',
        //     'ward_no_pk'
        // );

        // $sql = "SELECT '' as sl, ward_no_pk, ward_uid, ward_name, wardtype_lookup_no_fk, wardtype_name, category_lookup_no_fk, category_name, service_unit_no_fk, SERVICEUNIT_NAME, rownum rownumber,
        //  room_no_fk,room_name, gender_ind, ccu_ind, icu_ind, nicu_ind, hdu_ind, emr_ind, vip_ind, au_entry_at, au_update_at
        //  ,   status_txt
        //  from ward_set_up_vw where au_entry_hospital_pk_no = $ses_hospital_id ";
        // $order_by_column = "ward_no_pk";

        // $json_data = $this->datatable($request, $sql, $order_by_column, 'desc', $columns);
        // echo json_encode($json_data);


        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        // $where = "au_entry_hospital_pk_no = $hospital_id";
        $table = 'ward_set_up_vw';
        // Table's primary key
        $primaryKey = 'ward_no_pk';

        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'ward_uid', 'dt' => 1),
            array('db' => 'ward_name',  'dt' => 2),
            array('db' => 'wardtype_name',   'dt' => 3),
            array('db' => 'category_name',   'dt' => 4),
            array('db' => 'serviceunit_name',   'dt' => 5),
            array('db' => 'room_name',   'dt' => 6),
            array('db' => 'ccu_ind',   'dt' => 7),
            array('db' => 'icu_ind',   'dt' => 8),

            array('db' => 'nicu_ind',   'dt' => 9),
            array('db' => 'hdu_ind',   'dt' => 10),
            array('db' => 'emr_ind',   'dt' => 11),
            array('db' => 'vip_ind',   'dt' => 12),
            array('db' => 'status_txt',   'dt' => 13),
            array('db' => 'ward_no_pk',   'dt' => 14),
        );

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }



    }

    public function editWardSetup($id)
    {
        $ward = $this->model_ward->show($id);
        $service_unit = DB::table('SYSC_SERVICEUNIT')->where('IPD_IND', 1)->get();
        $category = $this->getLookupListByCode("CATEGORYTYPE");
        $room = DB::table('SYSC_ROOM')->where('status', 1)->get();
        $ward_types = $this->getLookupListByCode("WARDTYPE");
        return Template::loadview("admin.settings.ward.create_ward_form", [
            'ward' => $ward,
            'service_unit' => $service_unit,
            'category' => $category,
            'room' => $room,
            'ward_types' => $ward_types,
        ]);
    }

    public function storeWard(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        // dd($ses_hospital_id);
        $id = $request->id;
        $auth_id = Auth::id();
        $ccu_ind = $icu_ind = $nicu_ind = $hdu_ind = $emr_ind = $vip_ind = 0;
        $gender_ind = 0;
        switch ($request->ward_ind) {
            case 1:
                $ccu_ind = 1;
                break;
            case 2:
                $icu_ind = 1;
                break;
            case 3:
                $nicu_ind = 1;
                break;
            case 4:
                $hdu_ind = 1;
                break;
            case 5:
                $vip_ind = 1;
                break;
            case 6:
                $emr_ind = 1;
                break;
        }

        DB::beginTransaction();
        try {
            $data = [
                'ward_uid' => $request->ward_uid,
                'ward_name' => $request->ward_name,
                'wardtype_lookup_no_fk' => $request->wardtype_lookup_no_fk,
                'category_lookup_no_fk' => $request->category_lookup_no_fk,
                'service_unit_no_fk' => $request->service_unit_no_fk,
                'room_no_fk' => $request->room_no_fk,
                'ccu_ind' => $ccu_ind,
                'icu_ind' => $icu_ind,
                'nicu_ind' => $nicu_ind,
                'hdu_ind' => $hdu_ind,
                'emr_ind' => $emr_ind,
                'vip_ind' => $vip_ind,
                'status' => $request->status,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
            ];

            //dd($data);
            if ($id == "") {

                $data['au_entry_by'] = $auth_id;
                $this->model_ward->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->model_ward->update($data, $id);
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

    public function deleteWard($id){
        $data = DB::table('ipds_ward')->where('ward_no_pk', $id)->delete();
        return Template::loadView("admin.settings.ward.ward_list");
    }
}
