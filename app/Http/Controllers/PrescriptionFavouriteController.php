<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Template;
use App\Models\ServiceUnit;
use DB;
use App\Repositories\BaseRepository;
use App\Models\PrescriptionFavouriteModel;
use Auth;
use Carbon\Carbon;
use Session;
use App\Http\Requests\PrescriptionFavouriteRequest;





class PrescriptionFavouriteController extends Controller
{
    private $model;
    public function __construct(PrescriptionFavouriteModel $model)
    {
        $this->middleware('auth');
        $this->model = new BaseRepository($model);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $presFavItem = DB::table('psn_s_favorite_vw')->select('pres_fav_no_pk', 'full_name', 'favourite_name', 'su_name', 'item_type_lookup_code', 'status')->where("au_entry_hospital_no_fk", Session::get('user.ses_hospital_no_pk'))->get();
        return Template::loadview("admin.settings.pres_favourite_item.pres_favourite_item_list", [
            'presFavItem'  => $presFavItem
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $department = ServiceUnit::where('status', 1)->get();
        $itemTypeCode = DB::table('pres_lookup')->get();
        return Template::loadview("admin.settings.pres_favourite_item.create_pres_favourite_item", [
            'department'  => $department,
            'itemTypeCode' => $itemTypeCode
        ]);
    }
    public function create_form()
    {
        $department = ServiceUnit::where('status', 1)->get();
        $itemTypeCode = DB::table('pres_lookup')->get();
        return Template::loadview("admin.settings.pres_favourite_item.create_pres_favourite_item_form", [
            'department'  => $department,
            'itemTypeCode' => $itemTypeCode
        ]);
    }
    public function getDepartmentId(Request $request)
    {
        $departmentId = $request->departmentId;
        $doctor = DB::table('doctor_info_vw')->where('serviceunit_no_fk', $departmentId)->get();
        $personNoFk = '';
        return Template::loadview('admin.settings.pres_favourite_item.doctor_dropdown', ['doctor' => $doctor, 'personNoFk' => $personNoFk]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrescriptionFavouriteRequest $request)
    {
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();

        DB::beginTransaction();
        try {
            $sequence = DB::getSequence();
            $pres_fav_no_pk_seq = $sequence->nextValue('pres_fav_no_pk_seq');
            $presFavItem = [];
            $presFavItem = [
                'pres_fav_no_pk' => $pres_fav_no_pk_seq,
                'su_no_fk' => $request->department,
                'doctor_person_no_fk' => $request->doctor,
                'favourite_name' => $request->favourite_name,
                'item_type_lookup_code' => $request->item_type_code,
                'status' => $request->status,
                'au_entry_at' => date('Y-m-d'),
                'au_entry_hospital_no_fk' => $ses_hospital_id,
                'au_entry_session' => 'hospital'

            ];
            if ($id == null || $id == "") {

                // AU_ENTRY_BY
                $presFavItem['au_entry_by'] = $auth_id;

                $this->model->insert($presFavItem);
                // return $res;

            } else {

                // AU_UPDATE_BY
                $presFavItem['au_update_by'] = $auth_id;
                DB::table('psn_s_favorite')->where('pres_fav_no_pk', $id)->update($presFavItem);

                // $this->model->update($presLookup, $id);
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
        $department = ServiceUnit::where('status', 1)->get();
        $itemTypeCode = DB::table('pres_lookup')->get();
        $presFavItem = DB::table('psn_s_favorite_vw')->where('pres_fav_no_pk', $id)->first();
        $departmentId = $presFavItem->su_no_fk;
        $doctor = DB::table('doctor_info_vw')->where('serviceunit_no_fk', $departmentId)->get();
        return Template::loadview('admin.settings.pres_favourite_item.create_pres_favourite_item_form', [
            'presFavItem' => $presFavItem,
            'department'  => $department,
            'itemTypeCode' => $itemTypeCode,
            'doctor' => $doctor
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
}