<?php

namespace App\Http\Controllers;

use App\Library\Template;
use App\Models\ChamberHospital;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Repositories\BaseRepository as Repo;
use App\Traits\DatatablesLoader;
use App\Traits\LookupData;
use App\Traits\UtilitiesTrait;
use Auth;
use DB;

class ChamberHospitalController extends Controller
{
    use DatatablesLoader, LookupData, UtilitiesTrait;

    protected $model;
    protected $baseRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ChamberHospital $chamberHospital)
    {
        $this->middleware('auth');


        $this->model = new BaseRepository($chamberHospital);
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Template::loadView('admin.settings.chamber_doctor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $country = $this->getLookupListByCode("1002");
        return Template::loadView('admin.settings.chamber_doctor.create', ['country' => $country]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $id = $request->id;

        $auth_id = Auth::id();

        DB::beginTransaction();
        try {
            $sequence = DB::getSequence();
            $chamber_hospital_no_pk_seq = $sequence->nextValue('chamber_hospital_no_pk_seq');
            $data = [
                //'chamber_hospital_no_pk' => $chamber_hospital_no_pk_seq,
                'chamber_hospital_name' => $request->chamber_hospital_name,
                'chamber_hospital_description' => $request->chamber_hospital_description,
                'chamber_hospital_location' => $request->chamber_hospital_location,
                'chamber_hospital_country' => $request->chamber_hospital_country,
                'chamber_hospital_speciality' => $request->chamber_hospital_speciality,
                'establishe_year' => $request->establishe_year,
                'number_of_bed' => $request->number_of_bed,
                'status' => isset($request->status) ? 1 : 0,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => 'MCARE',
            ];

            if ($id == null || $id=='') {
                $data['au_entry_by'] = $auth_id;
                $data['chamber_hospital_no_pk'] = $chamber_hospital_no_pk_seq;

                //logo
                $image_name = "";
                $image_name1 = "";
                if ($files = $request->file('hospital_image')) {
                    $image_name = "mcare_hospital_" . date("Y_m_d_h_i") . "." . $files->getClientOriginalExtension();
                    $image_name1 = "mcare_hospital_" . date("Y_m_d_h_i");
                }

                $data['image_url'] = $image_name;
                $id =  $this->model->create($data);
                // $this->model->update($update_image, $chamber_hospital_no_pk_seq);

                if ($files = $request->file('hospital_image')) {
                    $this->uploadImages($files, $image_name1, 'images/uploads/hospital_images/', 'images/uploads/hospital_images/thumb/');
                }
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;

                $image_name = "";
                $image_name1 = "";
                if ($files = $request->file('hospital_logo')) {
                    $image_name = "logo_" . date("Y_m_d_h_i") . "." . $files->getClientOriginalExtension();
                    $image_name1 = "logo_" . date("Y_m_d_h_i");
                }

                $update_image['logo'] = $image_name;

                $this->model->update($update_image, $id);

                if ($files = $request->file('hospital_logo')) {
                    $this->uploadImages($files, $image_name1, 'images/uploads/hospital_images/', 'images/uploads/hospital_images/thumb/');
                }
                //logo background
                $image_name = "";
                $image_name1 = "";
                if ($files = $request->file('login_background_image')) {
                    $image_name = "logo_back" . date("Y_m_d_h_i") . "." . $files->getClientOriginalExtension();
                    $image_name1 = "logo_back" . date("Y_m_d_h_i");
                }

                $update_image['login_background_img'] = $image_name;

                $this->model->update($update_image, $id);

                if ($files = $request->file('login_background_image')) {
                    $this->uploadImages($files, $image_name1, 'images/uploads/hospital_images/', 'images/uploads/hospital_images/thumb/');
                }
                //landing background
                $image_name = "";
                $image_name1 = "";
                if ($files = $request->file('landing_image')) {
                    $image_name = "landing_" . date("Y_m_d_h_i") . "." . $files->getClientOriginalExtension();
                    $image_name1 = "landing_" . date("Y_m_d_h_i");
                }

                $update_image['landing_img'] = $image_name;

                $this->model->update($update_image, $id);

                if ($files = $request->file('landing_image')) {
                    $this->uploadImages($files, $image_name1, 'images/uploads/hospital_images/', 'images/uploads/hospital_images/thumb/');
                }

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
     * @param  \App\Models\ChamberHospital  $chamberHospital
     * @return \Illuminate\Http\Response
     */
    public function show(ChamberHospital $chamberHospital)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChamberHospital  $chamberHospital
     * @return \Illuminate\Http\Response
     */
    public function edit(ChamberHospital $chamberHospital)
    {
        //
        $country = $this->getLookupListByCode("1002");

        return Template::loadView('admin.settings.chamber_doctor.company_form', ['chamberHospital' => $chamberHospital, 'country' => $country]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChamberHospital  $chamberHospital
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ChamberHospital $chamberHospital)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChamberHospital  $chamberHospital
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChamberHospital $chamberHospital)
    {
        //
    }
    public function chamberHospitalList(Request $request)
    {
        $columns = array(
            "sl",
            'chamber_hospital_name',
            'chamber_hospital_location',
            'establishe_year',
            'number_of_bed',
            'chamber_hospital_no_pk',
        );

        $sql = "SELECT '' sl, a.chamber_hospital_name, a.chamber_hospital_location,a.establishe_year, a.number_of_bed,a.chamber_hospital_no_pk,
        rownum rownumber, a.au_update_at, a.au_entry_at from wsec_chamber_hospital a";
        $order_by_column = "chamber_hospital_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'DESC', $columns);

        echo json_encode($json_data);
    }
}
