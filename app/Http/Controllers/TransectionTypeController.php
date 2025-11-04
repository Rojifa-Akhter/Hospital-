<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use App\Models\TransectionType;
use App\Traits\DatatablesLoader;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\BaseRepository as Repo;

class TransectionTypeController extends Controller
{
    use DatatablesLoader;
    protected $model;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TransectionType $tran_type)
    {
        $this->middleware('auth');

        $this->model = new Repo($tran_type);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Template::loadview("admin.settings.transection.tran_type_list");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Template::loadview("admin.settings.transection.create_tran_type");
    }

    public function create_form()
    {
        return Template::loadView("admin.settings.transection.create_tran_type_form");
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
                'trn_type_code' => $request->tran_type_code,
                'trn_type_name' => $request->tran_type_name,
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
        return Template::loadView("admin.settings.transection.create_tran_type_form", ['tran_type' => $data]);
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

    public function getAllTransectionType(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            'sl',
            'trn_type_code',
            'trn_type_name',
            'trn_type_no_pk',
        );
        $sql = "SELECT '' as sl,trn_type_code, trn_type_name, trn_type_no_pk ,rownum rownumber, au_update_at,au_entry_at from finc_trntype where au_entry_hospital_pk_no = $ses_hospital_id ";
        $order_by_column = "trn_type_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);

        echo json_encode($json_data);
    }
}