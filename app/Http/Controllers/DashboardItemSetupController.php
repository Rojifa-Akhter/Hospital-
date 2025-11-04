<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Session;

class DashboardItemSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $item_list =  DB::table('dashboard_item_setup')->get();

        return Template::loadView("admin.settings.dashboard.dashboard_item_setup", [
            'item_list' => $item_list
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

        return Template::loadView("admin.settings.dashboard.create_dashboard_item_setup");
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
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $auth_id = Auth::id();
        DB::beginTransaction();
        try {
            $sequence = DB::getSequence();
            $dash_board_item_set_no_pk_seq = $sequence->nextValue('dash_board_item_set_no_pk_seq');
            $data = [
                'dashboard_items' => $request->dashboard_item_name,
                'dashboard_value' => $request->dashboard_item_value,
                'card_ind' => $request->card_ind ? 1 : null,
                'chart_ind' => $request->chart_ind ? 1 : null,
                'text_ind' => $request->text_ind ? 1 : null,
                'drill_down_ind' => $request->drill_down_ind ? 1 : null,
                'status' => $request->status ? 1 : null,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
            ];

            if ($id == null || $id == '') {

                // AU_ENTRY_BY
                $data['dash_board_item_set_no_pk'] = $dash_board_item_set_no_pk_seq;
                $data['dash_board_item_set_code'] = $dash_board_item_set_no_pk_seq;
                $data['au_entry_by'] = $auth_id;
                $data['au_entry_at'] = date('Y-m-d');
                $data['au_entry_session'] = "Session";

                // return $data;
                DB::table('dashboard_item_setup')->insert($data);
                //$this->model->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                DB::table('dashboard_item_setup')->where('dash_board_item_set_no_pk', $id)->update($data);
                //$this->model->update($data, $id);
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
        //
        $items =  DB::table('dashboard_item_setup')->where('dash_board_item_set_no_pk', $id)->first();

        return Template::loadView("admin.settings.dashboard.create_dashboard_item_setup", [
            'item' => $items
        ]);
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
}
