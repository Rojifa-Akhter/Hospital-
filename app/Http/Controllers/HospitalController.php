<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Library\Template;
use App\Models\Company;
use App\Models\HospitalChain;
use App\Repositories\BaseRepository;
use App\Repositories\BaseRepository as Repo;
use App\Traits\DatatablesLoader;
use App\Traits\LookupData;
use App\Traits\UtilitiesTrait;
use Auth;
use DB;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;

class HospitalController extends Controller
{
    use DatatablesLoader, LookupData, UtilitiesTrait;
    protected $model;
    protected $baseRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Company $company)
    {
        $this->middleware('auth');

        $this->model = $company;
        $this->model2 = new Repo($company);
        $this->baseRepository = new BaseRepository($company);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = $this->model->all();
        return Template::loadview("admin.settings.hospital.company_list", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hospital_chain = HospitalChain::latest()->get();
        $district = $this->getLookupListByCode("DISTRICT");
        $country = $this->getLookupListByCode("1002");
        $division = $this->getLookupListByCode("1041");
        $thana = $this->getLookupListByCode("THANA");
        return Template::loadview("admin.settings.hospital.create_new_company", ['hospital_chain' => $hospital_chain, 'district' => $district, 'country' => $country, 'division' => $division, 'thana' => $thana]);
    }

    public function popUp()
    {
        $hospital_chain = HospitalChain::latest()->get();
        $district = $this->getLookupListByCode("DISTRICT");
        $country = $this->getLookupListByCode("1002");
        $division = $this->getLookupListByCode("1041");
        $thana = $this->getLookupListByCode("THANA");
        return Template::loadview("admin.settings.hospital.create_new_company_form", ['hospital_chain' => $hospital_chain, 'district' => $district, 'country' => $country, 'division' => $division, 'thana' => $thana]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        // return $request;
        //dd($request->all());

        $id = $request->id;


        $auth_id = Auth::id();

        DB::beginTransaction();
        // try {

        $data = [
            'hospital_code' => $request->hospital_code,
            'hospitalchain_no_fk' => $request->hospital_group_name,
            'hospital_name' => $request->hospital_name,
            'hospital_alias' => $request->hospital_alias,
            'hospital_slogan' => $request->hospital_slogan,
            'addrress1' => $request->hospital_address1,
            'addrress2' => $request->hospital_address2,
            //                        'village' =>'',
            'thana' => $request->thana,
            'district' => $request->district,
            'division' => $request->division,
            'country' => $request->country,
            'telephone1' => $request->hospital_telephone1,
            'telephone2' => $request->hospital_telephone2,
            'email' => $request->hospital_email,
            'website' => $request->hospital_website,
            //                        'logo' => $request->hospital_logo,
            'status' => $request->hospital_status,
            'report_footer1' => '',
            'report_footer2' => '',
            'sl_no' => '',
            'logon_url' => $request->hospital_login_url,
            'logo_background_color' => $request->logo_background_color,
            'width_logo' => $request->width_logo,
            'width_nav' => $request->width_nav,
            'width_landing' => $request->landing_width,
            'company_name_text_size' => $request->company_name_text_size,
            'company_slogan_text_size' => $request->company_slogan_text_size,
            'company_address_text_size' => $request->company_ad_text_size,
            'border_colur' => $request->border_color,
            'background_position' => $request->background_position,
            'hospital_name_bangla' => $request->hospital_name_bangla,
            'report_header_image_prshde_ind' => $request->header_image_ind,

        ];

        if ($id == null) {
            // AU_ENTRY_BY
            $data['au_entry_by'] = $auth_id;

            $inserted = $this->model->create($data);



            //logo
            $image_name = "";
            $header_image_name = "";
            $image_name1 = "";
            if ($files = $request->file('hospital_logo')) {
                $image_name = "logo_" . date("Y_m_d_h_i") . "." . $files->getClientOriginalExtension();
                $image_name1 = "logo_" . date("Y_m_d_h_i");
            }
            if ($files = $request->file('header_image')) {

                $header_image_name = "logo_" . date("Y_m_d_h_i") . "." . $files->getClientOriginalExtension();
            }
            // 'report_header_image' => $request->header_image,
            $update_image['logo'] = $image_name;
            $update_header_image['report_header_image'] = $header_image_name;

            $this->baseRepository->update($update_image, $inserted->hospital_no_pk);
            $this->baseRepository->update($update_header_image, $inserted->hospital_no_pk);

            if ($files = $request->file('header_image')) {
                $this->uploadImages($files, $update_header_image, 'images/uploads/hospital_images/', 'images/uploads/hospital_images/thumb/');
            }
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

            $this->baseRepository->update($update_image, $inserted->hospital_no_pk);

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

            $this->baseRepository->update($update_image, $inserted->hospital_no_pk);

            if ($files = $request->file('landing_image')) {
                $this->uploadImages($files, $image_name1, 'images/uploads/hospital_images/', 'images/uploads/hospital_images/thumb/');
            }
        } else {
            // AU_UPDATE_BY
            // dd($data);
            $data['au_update_by'] = $auth_id;

            $image_name = "";
            $image_name1 = "";
            if ($files = $request->file('hospital_logo')) {
                $image_name = "logo_" . date("Y_m_d_h_i") . "." . $files->getClientOriginalExtension();
                $image_name1 = "logo_" . date("Y_m_d_h_i");
            }

            $update_image['logo'] = $image_name;

            $updated =  $this->baseRepository->update($update_image, $id);

            if ($files = $request->file('hospital_logo')) {
                $this->uploadImages($files, $image_name1, 'images/uploads/hospital_images/', 'images/uploads/hospital_images/thumb/');
            }
            $header_image_name = "";
            $header_image_name1 = "";
            if ($files = $request->file('header_image')) {
                $header_image_name = "header_image" . date("Y_m_d_h_i") . "." . $files->getClientOriginalExtension();
                $header_image_name1 = "header_image" . date("Y_m_d_h_i");
            }
            $update_header_image['report_header_image'] = $header_image_name;
            // dd($update_header_image);
            $this->baseRepository->update($update_header_image, $id);
            if ($files = $request->file('header_image')) {
                $this->uploadImages($files, $header_image_name1, 'images/uploads/hospital_images/', 'images/uploads/hospital_images/thumb/');
            }
            //logo background
            $image_name = "";
            $image_name1 = "";
            if ($files = $request->file('login_background_image')) {
                $image_name = "logo_back" . date("Y_m_d_h_i") . "." . $files->getClientOriginalExtension();
                $image_name1 = "logo_back" . date("Y_m_d_h_i");
            }

            $update_image['login_background_img'] = $image_name;

            $this->baseRepository->update($update_image, $id);

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

            $this->baseRepository->update($update_image, $id);

            if ($files = $request->file('landing_image')) {
                $this->uploadImages($files, $image_name1, 'images/uploads/hospital_images/', 'images/uploads/hospital_images/thumb/');
            }

            $this->baseRepository->update($data, $id);
        }

        // if ($files = $request->file('hospital_logo')) {
        //     $this->uploadImages($files, 141, 'images/uploads/hospital_images/', 'images/uploads/hospital_images/thumb/');
        // }

        DB::commit();
        $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        // }

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
        $data = $this->model2->show($id);
        $hospital_chain = HospitalChain::latest()->get();
        $district = $this->getLookupListByCode("DISTRICT");
        $country = $this->getLookupListByCode("1002");
        $division = $this->getLookupListByCode("1041");
        $thana = $this->getLookupListByCode("THANA");
        return Template::loadView("admin.settings.hospital.create_new_company_form", ['data' => $data, 'hospital_chain' => $hospital_chain, 'district' => $district, 'country' => $country, 'division' => $division, 'thana' => $thana]);
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

    public function getAllHospitals(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            "sl",
            'hospital_code',
            'hospital_name',
            'telephone1',
            'email',
            'website',
            'hospital_no_pk',
        );

        $sql = "SELECT '' sl, a.hospital_code, a.hospital_name,a.telephone1, a.email, a.website,a.hospital_no_pk, rownum rownumber, a.au_update_at, a.au_entry_at
        from wsec_hospital a where a.hospital_no_pk = $ses_hospital_id";
        //  left join wsec_hospitalchain hc on hc.hospitalchain_no_pk =  a.hospitalchain_no_fk";
        $order_by_column = "hospital_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'DESC', $columns);

        echo json_encode($json_data);
    }

    //hospital salary setup
    public function hospitalSalarySetup()
    {
        $salaryData = DB::table("hrms_hospital_wise_salary_setup")->first();
        // dd($salaryData);
        return Template::loadView("admin.settings.salary.hospital_salary_setup", [
            "salaryData" => $salaryData
        ]);
    }

    public function storeHospitalSalarySetup(Request $request)
    {
        DB::beginTransaction();
        try {
            $sequence = DB::getSequence();
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            // dd($request->cut_off ? 1 : 0);
            $data = [
                'hws_setup_no_pk' =>  $sequence->nextValue('hws_setup_no_pk_seq'),
                'cut_off_ind' => $request->cut_off ? '1' : '0',
                'basic_salary_perc' => $request->basic_salary,
                'house_rent_perc' => $request->house_rent,
                'medical_allow_perc' => $request->medical_allowance,
                'ta_da_perc' => $request->transport_allowance,
                'utility_allow_perc' => $request->utility,
                'conveyance_allow_perc' => $request->conveyance_allowance,
                'entertainment_perc' => $request->entertainment,
                'festival_bonus_perc' => $request->festival_bonus,
                'ca_perc' => $request->critical_allowance,
                'sa_perc' => $request->special_allowance,
                'ica_prea' => $request->incharge_allowance,
                'ra_prec' => $request->risk_allowance,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'status' => 1
            ];

            if ($request->cut_off) {
                $data['cut_off_strday'] = $request->startday;
                $data['cut_off_endday'] = $request->endday;
            }else{
                $data['cut_off_strday'] = '';
                $data['cut_off_endday'] = '';
            }

            if ($request->hws_setup_no_pk) {
                $data['au_update_at'] = $au_entry_at;
                $data['au_update_by'] = Auth::id();
                DB::table("hrms_hospital_wise_salary_setup")->where('hws_setup_no_pk', $request->hws_setup_no_pk)
                    ->update($data);
            } else {
                $data['au_entry_at'] = $au_entry_at;
                $data['au_entry_by'] = Auth::id();
                $data['au_entry_session'] = 'session';
                DB::table("hrms_hospital_wise_salary_setup")
                    ->insert($data);
            }
            DB::commit();
            $this->message = ['msg' => 'Data saved successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $this->message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($this->message);
    }
}
