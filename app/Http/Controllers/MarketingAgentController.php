<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Library\Template;
use Illuminate\Http\Request;
use App\Traits\DatatablesLoader;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\MarketingArea;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Repositories\BaseRepository as Repo;

class MarketingAgentController extends Controller
{
    use DatatablesLoader;
    public function __construct(Doctor $doctor)
    {
        $this->middleware('auth');
        $this->model = new Repo($doctor);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Template::loadview("admin.settings.marketing_agent.marketing_agent_list");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supervisor = Doctor::where('status', '=', 1)->get();
        $marketing_area = MarketingArea::where('status', '=', 1)->get();
        return Template::loadview("admin.settings.marketing_agent.add_new_marketing_agent", ['supervisor' => $supervisor, 'marketing_area' => $marketing_area]);
    }

    public function create_form()
    {
        $supervisor = Doctor::where('status', '=', 1)->get();
        $marketing_area = MarketingArea::where('status', '=', 1)->get();
        return Template::loadview("admin.settings.marketing_agent.add_new_marketing_agent_form", ['supervisor' => $supervisor, 'marketing_area' => $marketing_area]);
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
        $person_seq_count = Doctor::latest('person_no_pk')->first();
        $person_id = isset($person_seq_count) ? "DOC-" . ($person_seq_count->person_no_pk + 1) : "DOC-" . 1;

        DB::beginTransaction();
        try {
            $data = [
                'salutation'                => $request->marketing_agent_salutation,
                'person_code'               => $person_id,
                'full_name'                 => ucwords($request->marketing_agent_first_name) . ' ' . ucwords($request->marketing_agent_last_name),
                'fname'                     => ucwords($request->marketing_agent_first_name),
                'lname'                     => ucwords($request->marketing_agent_last_name),
                'pr_addr1'                  => $request->marketing_agent_addess1,
                'pe_addr1'                  => $request->marketing_agent_addess2,
                'phone_mobile'              => $request->marketing_agent_phone_mobile,
                'email_personal'            => $request->marketing_agent_email_personal,
                'supervisor_person_no_fk'   => $request->marketing_agent_supervisor,
                'area_no_pk'                => $request->marketing_area_area_no,
                'status'                    => $request->status,
                'referral_agent_ind'        => 1,
                'referal_ind'               => 1,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
            ];
            // dd($data);
            if ($id == null) {
                $data['au_entry_by'] = $auth_id;
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
        $supervisor = Doctor::where('status', '=', 1)->get();
        $marketing_area = MarketingArea::where('status', '=', 1)->get();
        $marketing_agent = $this->model->show($id);
        return Template::loadview("admin.settings.marketing_agent.add_new_marketing_agent_form", ['marketing_agent' => $marketing_agent, 'supervisor' => $supervisor, 'marketing_area' => $marketing_area]);
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

    public function getAllMarketingAgent(Request $request)
    {
        // $columns = array(
        //     array( 'db' => 'person_no_pk' ),
        //     array( 'db' => 'full_name' ),
        //     array( 'db' => 'supervisor' ),
        //     array( 'db' => 'phone_mobile' ),
        //     array( 'db' => 'email_personal' ),
        //     array( 'db' => 'area' ),
        //     array( 'db' => 'pe_addr1' ),
        // );
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            'person_no_pk',
            'full_name',
            'supervisor',
            'phone_mobile',
            'email_personal',
            'area',
            'pe_addr1',
        );


        //    $sql = "SELECT ma.person_no_pk, ma.full_name, dn.full_name supervisor, ma.phone_mobile, ma.email_personal, ar.district area,
        //    ma.pe_addr1, rownum rownumber, ma.au_update_at, ma.au_entry_at from wl_referral_ma_list_vw ma
        //    LEFT JOIN wl_referral_ma_list_vw dn ON dn.person_no_pk = ma.supervisor_person_no_fk
        //    LEFT JOIN pcrm_marketing_area ar ON ar.area_no_pk = ma.area_no_pk";
        $sql = "SELECT person_no_pk,full_name,supervisor,phone_mobile,email_personal,area,pe_addr1,rownum rownumber,au_update_at, au_entry_at  from hrms_marketing_agent_vw where AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id ";
        $order_by_column = "person_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'DESC', $columns);

        echo json_encode($json_data);
    }
}
