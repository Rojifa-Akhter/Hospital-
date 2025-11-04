<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Doctor;
use App\Library\Template;
use Illuminate\Http\Request;
use App\Traits\DatatablesLoader;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Repositories\BaseRepository AS Repo;

class DoctorReferralController extends Controller
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
        return Template::loadview("admin.settings.referral_doctor.referral_doctor_list");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Template::loadview("admin.settings.referral_doctor.add_new_referral_doctor");
    }

    public function create_form()
    {
        return Template::loadview("admin.settings.referral_doctor.add_new_referral_doctor_form");
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
        //$person_id = isset($person_seq_count) ? "DOC-".($person_seq_count->person_no_pk + 1) : "DOC-". 1;

        DB::beginTransaction();
        try {
            $data = [
                'salutation'                => $request->ref_doc_salutation,
                'person_code'               => $request->ref_code,
                'full_name'                 => ucwords($request->ref_doc_first_name) . ' ' . ucwords($request->ref_doc_last_name),
                'fname'                     => ucwords($request->ref_doc_first_name),
                'lname'                     => ucwords($request->ref_doc_last_name),
                'qualification'             => $request->ref_doc_qualification,
                'pr_addr1'                  => $request->ref_doc_location,
                'phone_mobile'              => $request->ref_doc_phone_mobile,
                'email_personal'            => $request->ref_doc_email_personal,
                'pe_addr1'                  => $request->ref_doc_area,
                // 'ref_doc_photo'             => $request->ref_doc_photo,
                'status'                    => $request->status,
                'referal_ind'               => 1,
                'au_entry_hospital_pk_no' =>$ses_hospital_id,
            ];

            if($id == null)
            {
                $data['au_entry_by'] = $auth_id;
                $this->model->create($data);
            }
            else
            {
                $data['au_update_by'] = $auth_id;
                $this->model->update($data, $id);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        }
        catch (\Exception $e)
        {
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
        $referral_doctor = $this->model->show($id);
        return Template::loadview("admin.settings.referral_doctor.add_new_referral_doctor_form",['referral_doctor' => $referral_doctor]);
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

    public function getAllReferralDoctor(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            'sl',
            'full_name',
            'phone_mobile',
            'email_personal',
            'pr_addr1',
            'pe_addr1',
            'person_no_pk'
        );

        $sql = "SELECT '' as sl, full_name, phone_mobile, email_personal, pr_addr1, pe_addr1, person_no_pk, rownum rownumber, au_update_at, au_entry_at from wl_referral_list_vw where AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id ";
        $order_by_column = "person_no_pk";

        $json_data = $this->datatable( $request, $sql, $order_by_column, 'DESC', $columns);

        echo json_encode($json_data);

    }
}
