<?php

namespace App\Http\Controllers;

use App\Datatables\DataTableClass;
use App\Library\Template;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\DatatablesLoader;
use App\Traits\LookupData;
use App\Http\Requests\LookupRequest;
use App\Http\Requests\LookupItemRequest;
use App\Repositories\BaseRepository as Repo;
use Auth;
use DB;
use Session;
use App\Models\UomLookup as Lookup;
use App\Models\LookupItem;

class HOSUomLookupController extends Controller
{
    use DatatablesLoader, LookupData;
    protected $model;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Lookup $lookup, LookupItem $lookupitem)
    {
        $this->middleware('auth');

        $this->model = new Repo($lookup);
        $this->model2 = new Repo($lookupitem);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Template::loadview("admin.uhl.settings.lookup.uom_lookup_list");
    }

    public function indexLookupItem()
    {
        $lookup = $data = Lookup::all();
        return Template::loadview("admin.settings.lookup.lookupitem_list", ['lookup' => $lookup]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Template::loadview("admin.uhl.settings.lookup.uom_lookup");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function create_form()
    {
        return Template::loadview("admin.uhl.settings.lookup.create_uom_lookup_form");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function createLookupItem()
    {
        $lookup = $data = Lookup::where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'))->get();//all();
        $lookup_data = LookupItem::where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'))->get();
     // return $lookupitems;
        return Template::loadview("admin.settings.lookup.create_lookup_item", ['lookup' => $lookup, 'lookup_data' =>  $lookup_data]);
    }

    public function createLookupItem_form()
    {
        $lookup = $data = Lookup::where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'))->get();//all();
        $lookup_data = LookupItem::where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'))->get();

        // return $lookupitems;
        return Template::loadview("admin.settings.lookup.create_lookup_item_form", ['lookup' => $lookup, 'lookup_data' =>  $lookup_data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function create_lookup_item_mapping()
    {
        return Template::loadview("admin.settings.lookup.create_lookup_item_map");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */



    public function store(LookupRequest $request)
    {
        //return $request;
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $auth_id = Auth::id();

        DB::beginTransaction();
        try {

            $data = [
                'uom_code' => $request->lookup_UID,
                'uom_label_desc' => $request->lookup_name,
                'status' => $request->lookup_status ? 1 : null,
                'au_entry_hospital_no_fk' => $ses_hospital_id,
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

    public function storeLookupItem(LookupItemRequest $request)
    {
        // return $request;
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $auth_id = Auth::id();

        DB::beginTransaction();
        try {

            $data = [
                'lookupdata_code' => $request->list_UID,
                'lookupdata_name' => $request->lookup_list_name,
                'lookupdata_pk_no_parent' => $request->lookup_data_no,
                'lookupdata_name_bangla' => $request->lookup_name_bangla,
                'lookupdata_desc' => $request->lookup_list_description,
                'lookup_no_fk' => $request->lookup_no,
                'serial_no' => $request->lookup_serial,
                'status' => $request->lookup_status ? 1 : null,
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
        return Template::loadView("admin.uhl.settings.lookup.create_uom_lookup_form", ['lookup' => $data]);
    }

    public function editLookupItem($id)
    {
        $lookupitem = $this->model2->show($id);
        $lookup = $data = Lookup::where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'))->get();//all();
        $lookup_data = LookupItem::where('au_entry_hospital_pk_no',Session::get('user.ses_hospital_no_pk'))->get();

        return Template::loadView("admin.settings.lookup.create_lookup_item_form", ['lookup_data' => $lookup_data, 'lookupitem' => $lookupitem, 'lookup' => $lookup]);
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
        $data = $this->model->delete($id);
        return Template::loadView("admin.settings.lookup.lookup_list", $data);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getLookupInfoById($id)
    {
        return $id;
    }

    public function getAllLookups(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        $table = 'sysc_lookup';
        // Table's primary key
        $primaryKey = 'lookup_no_pk';

        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'lookup_code', 'dt' => 1),
            array('db' => 'lookup_name', 'dt' => 2),
            array('db' => 'lookup_desc',  'dt' => 3),
            array('db' => 'status',   'dt' => 4),
            array('db' => 'lookup_no_pk',   'dt' => 5),
        );

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }


        //        $columns = array(
        //            'sl',
        //            'lookup_code',
        //            'lookup_name',
        //            'lookup_desc',
        //            'status',
        //            'lookup_no_pk',
        //
        //        );
        //
        //        $sql = "SELECT '' as sl,  lookup_code, lookup_name, Lookup_desc, case when status=1
        //    then 'Active' else 'Inactive' end as status,lookup_no_pk, rownum rownumber, au_update_at,au_entry_at from sysc_lookup";
        //
        //        $order_by_column = "lookup_no_pk";
        //
        //        $json_data = $this->datatable( $request, $sql, $order_by_column, 'ASC', $columns);
        //
        //        echo json_encode($json_data);

    }

    public function getAllLookupitems(Request $request)
    {

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_no_fk = $hospital_id";
        $table = 'sysc_serviceitem_uom';
        // Table's primary key
        $primaryKey = 'uom_no_pk';

        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'uom_code', 'dt' => 1),
            array('db' => 'uom_label_desc', 'dt' => 2),
            array('db' => 'status',   'dt' => 3),
            array('db' => 'uom_no_pk',   'dt' => 4),
        );
        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }


        //        $columns = array(
        //            'sl',
        //            'lookupdata_code',
        //            'lookupdata_name',
        //            'lookupdata_name_bangla',
        //            'lookupdata_desc',
        //            'status',
        //            'lookupdata_no_pk',
        //        );
        //
        //
        //        $sql = "SELECT '' as sl, lookupdata_code,lookupdata_name, lookupdata_name_bangla,lookupdata_desc, case when status=1 then 'Active' else 'Inactive' end as status,lookupdata_no_pk,  rownum rownumber, au_update_at,au_entry_at from sysc_lookupdata ";
        //
        //        $order_by_column = "lookupdata_no_pk";
        //
        //        $json_data = $this->datatable( $request, $sql, $order_by_column, 'ASC', $columns);
        //        //dd($json_data);
        //        echo json_encode($json_data);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lookupPresDataAutocomplete(Request $request)
    {
        return $this->getPresLookupDataAutocompleteList($request);
    }
    public function genericDataAutocomplete(Request $request)
    {
        return $this->genericDataAutocompleteList($request);
    }
    public function lookupItemSearch(Request $request)
    {
        $lookup_no = $request->lookup_no;

        $sql_cond = "";

        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($lookup_no != "") ? " $clause lookup_no_fk = $lookup_no" : "";

        $columns = array(
            'sl',
            'lookupdata_code',
            'lookupdata_name',
            'lookupdata_name_bangla',
            'lookupdata_desc',
            'status',
            'lookupdata_no_pk',
        );


        $sql = "SELECT '' as sl, lookupdata_code,lookupdata_name, lookupdata_name_bangla,lookupdata_desc, case when status=1 then 'Active' else 'Inactive' end as status,lookupdata_no_pk,
       rownum rownumber, au_update_at,au_entry_at from sysc_lookupdata $sql_cond";

        $order_by_column = "lookupdata_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);
        //dd($json_data);
        echo json_encode($json_data);
    }
}
