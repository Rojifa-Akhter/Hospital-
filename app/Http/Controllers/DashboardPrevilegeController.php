<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;

class DashboardPrevilegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $hospital = DB::table("wsec_hospital")->select("hospital_no_pk", "hospital_name")->orderBy("hospital_name", "asc")->where("status", 1)->get();
        $dashboard_item = DB::table('dashboard_item_setup')->get();

        return Template::loadView("admin.settings.dashboard.previlege_setup.dashboard_previlege", [
            "hospital" => $hospital,
            "dashboard_item" => $dashboard_item,
            "dashboard_previllege" => collect([]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //dd($request->all());.
        DB::table('dashboard_user_previlige')->where('user_no_fk',  $request->user_name)->delete();
        DB::commit();
        $id = $request->id;
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $item_arr =  $request->item_arr;
        //dd($request->item_arr);
        if (!empty($request->item_arr)) {
            for ($i = 0; $i < count($request->item_arr); $i++) {
                DB::beginTransaction();
                try {

                    $data = [
                        'dashboard_item_no_fk' => $item_arr[$i],
                        'user_no_fk' => $request->user_name,
                        'status' => 1,
                        'au_entry_hospital_pk_no' => $ses_hospital_id,
                    ];


                    $sequence = DB::getSequence();
                    $dash_privilige_no_pk_seq = $sequence->nextValue('dash_privilige_no_pk_seq');

                    // AU_ENTRY_BY
                    $data['privilige_no_pk'] = $dash_privilige_no_pk_seq;
                    $data['privilige_code'] = "P-" . $dash_privilige_no_pk_seq;
                    $data['au_entry_by'] = $auth_id;
                    $data['au_entry_at'] = date('Y-m-d');
                    $data['au_entry_session'] = "Session";

                    // return $data;
                    DB::table('dashboard_user_previlige')->insert($data);
                    //$this->model->create($data);


                    DB::commit();
                    $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
                } catch (\Exception $e) {
                    DB::rollback();
                    $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
                }
            }
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
        //
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
    public function dashboardUserPrivilege(Request $request)
    {
        //emp_hidden

        $dashboard_item = DB::table('dashboard_item_setup')->get();
        $dashboard_previllege = DB::table('dashboard_user_previlige')
            ->where('dashboard_user_previlige.user_no_fk', $request->emp_hidden)
            ->get();
        $dashboard_previllege_arr = [];
        if (!empty($dashboard_previllege)) {
            foreach ($dashboard_previllege as $dashboard) {
                $dashboard_previllege_arr[$dashboard->dashboard_item_no_fk] = 1;
            }
        }

        //dd($dashboard_previllege,$dashboard_item);

        return Template::loadView("admin.settings.dashboard.previlege_setup.dashboard_previlege_list", [
            "userID" => $request->emp_hidden,
            "dashboard_item" => $dashboard_item,
            "dashboard_previllege_arr" => $dashboard_previllege_arr
        ]);
    }
}
