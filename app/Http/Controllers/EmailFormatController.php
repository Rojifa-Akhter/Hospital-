<?php

namespace App\Http\Controllers;

use App\Models\EmailFormat;
use App\Library\Template;
use Illuminate\Http\Request;
use App\Traits\DatatablesLoader;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\LookupData;
use Session;
use App\Repositories\BaseRepository as Repo;

class EmailFormatController extends Controller
{
    use DatatablesLoader, LookupData;
    protected $model;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EmailFormat $emailformat)
    {
        $this->middleware('auth');
        $this->model = new Repo($emailformat);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Template::loadview("admin.settings.email_format.email_format_list");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $email_event = $this->getLookupListByCode("SYSEMAIL");
        return Template::loadview("admin.settings.email_format.create_email_format", ['email_event' => $email_event]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_form()
    {
        $email_event = $this->getLookupListByCode("SYSEMAIL");
        return Template::loadview("admin.settings.email_format.create_email_format_form", ['email_event' => $email_event]);
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
                'email_event_lookup_no_pk' => $request->email_event_ddl,
                'email_subject' => $request->email_subject,
                'email_body1' => $request->email_body,
                'comments' => $request->email_comments,
            ];

            if ($id == null) {
                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;
                $data['au_entry_session'] = 'S0901';
                $data['au_entry_hospital_pk_no'] =  $ses_hospital_id;
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
        //$data = $this->model->show($id);
        $data = DB::table("sysc_email_format")->where('email_format_no_pk', $id)->first();
        $email_event = $this->getLookupListByCode("SYSEMAIL");
        return Template::loadView(
            "admin.settings.email_format.create_email_format_form",
            [
                'email_format' => $data,
                'email_event' => $email_event
            ]
        );
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

    public function getAllModule(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array('email_event', 'email_subject', 'email_body1', 'comments', 'email_format_no_pk');

        $sql = "SELECT  el.lookupdata_name email_event, a.email_subject, a.email_body1, a.comments,a.email_format_no_pk, rownum rownumber, a.au_update_at, a.au_entry_at from sysc_email_format a
        LEFT JOIN sysc_lookupdata el on el.lookupdata_no_pk =  a.email_event_lookup_no_pk where a.AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id ";
        $order_by_column = "email_format_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);

        echo json_encode($json_data);
    }
}