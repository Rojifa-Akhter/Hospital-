<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use App\Models\HospitalChain;
use App\Traits\DatatablesLoader;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Repositories\BaseRepository as Repo;

class HospitalChainController extends Controller
{
    use DatatablesLoader;
    protected $model;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(HospitalChain $hospitalchain)
    {
        $this->middleware('auth');

        $this->model = new Repo($hospitalchain);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function hospitalChalin()
    {
        return Template::loadview("admin.settings.hospitalchain.hospitalchain_list");
    }

    public function index()
    {
        return Template::loadview("admin.settings.hospitalchain.hospitalchain_list");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Template::loadview("admin.settings.hospitalchain.create_hospitalchain");
    }

    public function create_form()
    {
        return Template::loadview("admin.settings.hospitalchain.create_hospitalchain_form");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        //return $request;
        $id = $request->id;


        $auth_id = Auth::id();

        DB::beginTransaction();
        try {

            $data = [
                'hospitalchain_code' => $request->hospitalchain_code,
                'hospitalchain_name' => $request->hospitalchain_name,
                'hospitalchain_alias' => $request->hospitalchain_alias,
                'hospitalchain_slogan' => $request->hospitalchain_slogan,
                'addrress1' => $request->hospitalchain_addrress1,
                'addrress2' => $request->hospitalchain_addrress2,
                'village' => $request->hospitalchain_village,
                'thana_po' => $request->hospitalchain_thana_po,
                'district' => $request->hospitalchain_district,
                'division' => $request->hospitalchain_division,
                'country' => $request->hospitalchain_country,
                'telephone1' => $request->hospitalchain_telephone1,
                'telephone2' => $request->hospitalchain_telephone2,
                'email' => $request->hospitalchain_email,
                'website' => $request->hospitalchain_website,
                'logo' => '',
                'status' => $request->hospitalchain_status,
                // 'au_entry_hospital_pk_no' => $ses_hospital_id,
            ];

            if ($id == null) {
                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;
                $data['au_entry_session'] = 'S0901';
                $data['au_entry_hospital_pk_no'] = $ses_hospital_id;
                //  return $data;
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
        return Template::loadView("admin.settings.hospitalchain.create_hospitalchain_form", ['hospitalchain' => $data]);
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

    public function getAllHospitalChain(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(

            'sl',
            'hospitalchain_code',
            'hospitalchain_name',
            'addrress1',
            'district',
            'division',
            'telephone1',
            'email',
            'website',
            'hospitalchain_no_pk',
        );

        $sql = "SELECT '' as sl, hospitalchain_code, hospitalchain_name,  addrress1, district, division, telephone1, email, website, hospitalchain_no_pk, rownum rownumber, au_update_at, au_entry_at from wsec_hospitalchain where AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id ";
        $order_by_column = "hospitalchain_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);

        echo json_encode($json_data);
    }
}
