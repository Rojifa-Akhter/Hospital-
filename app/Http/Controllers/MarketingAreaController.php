<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Library\Template;
use Illuminate\Http\Request;
use App\Models\MarketingArea;
use App\Traits\DatatablesLoader;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Repositories\BaseRepository as Repo;

class MarketingAreaController extends Controller
{
    use DatatablesLoader;
    public function __construct(MarketingArea $marketingArea)
    {
        $this->middleware('auth');
        $this->model = new Repo($marketingArea);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Template::loadview("admin.settings.marketing_area.marketing_area_list");
    }

    public function create_form()
    {
        $supervisor = Doctor::latest()->get();
        return Template::loadview("admin.settings.marketing_area.add_new_marketing_area_form", [
            'supervisor' => $supervisor
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supervisor = Doctor::latest()->get();
        return Template::loadview("admin.settings.marketing_area.add_new_marketing_area", [
            'supervisor' => $supervisor
        ]);
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
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        DB::beginTransaction();
        try {
            $data = [
                'area_code'                 => $request->marketing_area_code,
                'supervisor_person_no_fk'   => $request->marketing_area_person_no,
                'district'                  => $request->marketing_area_district,
                'post_code'                 => $request->marketing_area_post_code,
                'status'                    => $request->status,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
            ];

            if ($id == null) {
                $data['au_entry_by'] = $auth_id;
                // return $data;
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
        $marketing_area = $this->model->show($id);
        $supervisor = Doctor::latest()->get();
        return Template::loadview("admin.settings.marketing_area.add_new_marketing_area_form", ['marketing_area' => $marketing_area, 'supervisor' => $supervisor]);
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

    public function getAllMarketingArea(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            'area_no_pk',
            'area_code',
            'supervisor',
            'district',
            'post_code',
        );

        $sql = "SELECT area_no_pk, area_code,supervisor, district, post_code,
         rownum rownumber, au_update_at, au_entry_at from hrms_marketing_area_vw where AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id ";
        $order_by_column = "area_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'DESC', $columns);

        echo json_encode($json_data);
    }
}