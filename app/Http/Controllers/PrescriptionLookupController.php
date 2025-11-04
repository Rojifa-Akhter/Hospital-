<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use App\Traits\DatatablesLoader;
use App\Models\PrescriptionLookup;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PrescriptionLookupItem;
use Session;
use App\Repositories\BaseRepository as Repo;

class PrescriptionLookupController extends Controller
{
    use DatatablesLoader;
    protected $model;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PrescriptionLookup $prescriptionlookup, PrescriptionLookupItem $prescriptionlookupitem)
    {
        $this->middleware('auth');

        $this->model = new Repo($prescriptionlookup);
        $this->model2 = new Repo($prescriptionlookupitem);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Template::loadview("admin.settings.prescription_lookup.lookup_list");
    }

    public function indexPrescriptionLookupItem()
    {
        return Template::loadview("admin.settings.prescription_lookup.lookupitem_list");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Template::loadview("admin.settings.prescription_lookup.create_lookup");
    }

    public function createLookupForm()
    {
        return Template::loadview("admin.settings.prescription_lookup.create_lookup_form");
    }

    public function createPrescriptionLookupItem()
    {
        $prescriptionlookup_data = PrescriptionLookup::all();
        // return $lookupitems;
        return Template::loadview("admin.settings.prescription_lookup.create_lookup_item", ['prescriptionlookup_data' => $prescriptionlookup_data]);
    }

    public function createLookupdataForm()
    {
        $prescriptionlookup_data = PrescriptionLookup::all();
        // return $lookupitems;
        return Template::loadview("admin.settings.prescription_lookup.create_lookup_item_form", ['prescriptionlookup_data' => $prescriptionlookup_data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $auth_id = Auth::id();

        DB::beginTransaction();
        try {

            $data = [
                'pres_lookup_code' => $request->lookup_UID,
                'pres_lookup_name' => $request->lookup_name,
                'status' => $request->prescriptionlookup_status,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
            ];

            if ($id == null) {
                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;
                // return $data;
                $this->model->create($data);
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

    public function storePrescriptionLookupItem(Request $request)
    {

        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $auth_id = Auth::id();        // return $request;

        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $auth_id = Auth::id();

        DB::beginTransaction();
        try {

            $data = [
                'pres_lookupdata_code' => $request->list_UID,
                'pres_lookupdata_name' => $request->lookup_list_name,
                'pres_lookup_no_fk' => $request->lookup_no,
                'serial' => $request->lookup_serial,
                'status' => $request->lookup_status,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
            ];

            if ($id == null) {
                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;
                // return $data;
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

        return response()->json($message);
    }

    public function storePrescriptionLookupItemDoctor(Request $request)
    {
       // dd(explode("_",$request->element_id)[0]);
        if(strtoupper(explode("_",$request->element_id)[0]) == 'INSTRUCTION'){
            $lookup_type = strtoupper(explode("_",$request->element_id)[0]);
        }else{
            $lookup_type = strtoupper(explode("_",$request->element_id)[1]);
        }
        $lookup_no_fk = Db::table('pres_lookup')->select('pres_lookup_no_pk')->where('PRES_LOOKUP_CODE',$lookup_type)->first();
        $serial = DB::select("select max(serial) as sl from pres_lookupdata where  pres_lookup_no_fk = $lookup_no_fk->pres_lookup_no_pk");
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $auth_id = Auth::id();
        DB::beginTransaction();
        try {
            $data = [
                'pres_lookupdata_code' => strtoupper($request->new_option),
                'pres_lookupdata_name' => $request->new_option,
                'pres_lookup_no_fk' => $lookup_no_fk->pres_lookup_no_pk,
                'serial' => $serial[0]->sl +1,
                'status' => 1,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
            ];
            // dd($data);
            if ($id == null) {
                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;
                // return $data;
              $m = $this->model2->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->model2->update($data, $id);
            }
            
            // $sequence              = DB::getSequence();
            // $sysc_doctor_no_pk_seq = $sequence->nextValue('pres_lookupdata_seq');
            // $last_id               = $sysc_doctor_no_pk_seq;
            // , 'id' => $last_id
            $last_id = $m->pres_lookupdata_no_pk;
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'id' => $last_id];
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
        return Template::loadView("admin.settings.prescription_lookup.create_lookup_form", ['prescriptionlookup' => $data]);
    }

    public function editPrescriptionLookupItem($id)
    {

        $prescriptionlookupitem = $this->model2->show($id);
        $prescriptionlookup_data = $data = PrescriptionLookup::all();
        return Template::loadView("admin.settings.prescription_lookup.create_lookup_item_form", ['prescriptionlookup_data' => $prescriptionlookup_data, 'prescriptionlookupitem' => $prescriptionlookupitem]);
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

    public function getPrescriptionLookupInfoById($id)
    {
        return $id;
    }

    public function getAllPrescriptionLookups(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            'sl',
            'pres_lookup_code',
            'pres_lookup_name',
            'pres_lookup_no_pk',
        );

        $sql = "SELECT '' AS sl,
                pres_lookup_code,
                pres_lookup_name,
                ROWNUM rownumber,
                au_update_at,
                au_entry_at,
                pres_lookup_no_pk
            FROM pres_lookup ";
        // FROM pres_lookup where AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id ";
        $order_by_column = 'pres_lookup_no_pk';

        $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);

        echo json_encode($json_data);
    }

    public function getAllPrescriptionLookupitems(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            'sl',
            'pres_lookupdata_code',
            'pres_lookup_name',
            'pres_lookupdata_name',
            'pres_lookupdata_no_pk',
        );
        // $sql = "select a.menu_no_pk,a.menu_code,a.parent_menu_no_fk,a.menu_name,a.sl_no,a.menu_name_nls,a.menu_link,a.menu_icon, a.status, rownum rownumber,a.au_update_at,a.au_entry_at from wsec_menutree a";

        $sql = "SELECT '' AS sl,
       ld.pres_lookupdata_code,
       ld.pres_lookup_no_fk,
       ld.pres_lookupdata_name,
       ld.status,
       sl.pres_lookup_name,
       ROWNUM rownumber,
       ld.au_update_at,
       ld.au_entry_at,
       ld.pres_lookupdata_no_pk
  FROM    pres_lookupdata ld
       LEFT JOIN
          pres_lookup sl
       ON sl.pres_lookup_no_pk = ld.pres_lookup_no_fk ";
        //    ON sl.pres_lookup_no_pk = ld.pres_lookup_no_fk  where ld.AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id";
        $order_by_column = "pres_lookupdata_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);

        echo json_encode($json_data);
    }

    public function storePrescriptionLookupItemData(Request $request)
    {
        // return $request;
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $auth_id = Auth::id();
        $list_uid = 'CHEIF-' . $request->typehead_text;
        DB::beginTransaction();
        try {

            $data = [
                'pres_lookupdata_code' => $list_uid,
                'pres_lookupdata_name' => $request->typehead_text,
                'pres_lookup_no_fk' => $request->lookup_id,
                'serial' => 1,
                'status' =>1,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
            ];

            if ($id == null) {
                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;
                // return $data;
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

        return response()->json($message);
    }

    public function storePrescriptionLookupItemDoctorChiefComplain(Request $request)
    {
        // dd($request->all());
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        if ($request->lookup_id != null) {
            $serial = DB::table('pres_lookupdata')
                ->where('pres_lookup_no_fk', $request->lookup_id)
                ->max('serial');
        
            $serial = $serial ? $serial + 1 : 1;  // no array, directly int
        } else {
            $serial = 1;
        }
        
        
        

        $auth_id = Auth::id();
        DB::beginTransaction();
        try {

            $data = [
                'pres_lookupdata_code' => strtoupper($request->new_option),
                'pres_lookupdata_name' => $request->new_option,
                'pres_lookup_no_fk' => $request->lookup_id,
                'serial' => $serial,
                'status' => 1,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
                'doctor_person_no_fk' => $auth_id,
            ];
                // AU_ENTRY_BY
            $data['au_entry_by'] = $auth_id;
            // return $data;
            $this->model2->create($data);


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);

}
}
