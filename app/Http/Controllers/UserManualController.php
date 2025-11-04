<?php

namespace App\Http\Controllers;

use DateTime;
use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;


class UserManualController extends Controller
{
    public function CreateUserManual()
    {
        $menu = DB::table('menu_feature_vw')
        ->select('module', 'features_no_pk', 'features_code', 'features_name', 'page_url')
        ->orderBy('features_no_pk')
        ->get();

        $data = DB::table('user_manual_vw')
        ->select('userm_mst_no_pk', 'userm_mst_uid', 'features_no_fk', 'features_attch_name', 'userm_chd_no_pk', 'userm_chd_uid', 'header_sl', 'header_title', 'header_desc', 'features_name', 'menu_no_pk', 'menu_name', 'status')
        ->get();
        // dd($data);
        return Template::loadview("admin.user-manual.create", ['menu' => $menu, 'data' => $data]);
    }
  

    public function StoreUserManual(Request $request)
    {
        $sequence = DB::getSequence();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $id = $request->hdnmst_id;
        $chd_id = $request->userm_chd_no_pk;
        $auth_id = Auth::id();

        if (isset($request->hdnmst_id)) {
            $userm_mst_no_pk = $request->hdnmst_id;
            $userm_chd_no_pk = $request->userm_chd_no_pk;
        } else {
            $userm_mst_no_pk = $sequence->nextValue('userm_mst_no_pk_seq');
            $userm_chd_no_pk = $sequence->nextValue('userm_chd_no_pk_seq');
        }

        DB::beginTransaction();
        try {
            $mst_data = [
                'userm_mst_no_pk'     => $userm_mst_no_pk,
                'userm_mst_uid'       => $userm_mst_no_pk,
                'features_no_fk'      => $request->menu,
                'status'              => 1,
            ];

            $child_data = [
                'userm_chd_no_pk'  => $userm_chd_no_pk,
                'userm_chd_uid'    => $userm_chd_no_pk,
                'userm_mst_no_fk'  => $userm_mst_no_pk, 
                'header_sl'        => $request->serial,
                'header_title'     => $request->title,
                'header_desc'      => $request->content,
                'status'           => 1,
            ];

            if ($id == null) {
                $mst_data['au_entry_by'] = $auth_id;
                $mst_data['au_entry_at'] = date('Y-m-d');
                $mst_data['au_entry_session'] = Session()->get('user.ses_user_pk_no');
                $mst_data['au_entry_hospital_no_fk'] = Session::get('user.ses_hospital_no_pk');

                DB::table("wsec_user_manual_mst")->insert($mst_data);

                $child_data['au_entry_by'] = $auth_id;
                $child_data['au_entry_at'] = date('Y-m-d');
                $child_data['au_entry_session'] = Session()->get('user.ses_user_pk_no');
                $child_data['au_entry_hospital_no_fk'] = Session::get('user.ses_hospital_no_pk');

                DB::table("wsec_user_manual_chd")->insert($child_data);
            } else {
                $mst_data['au_update_by'] = $auth_id;
                $mst_data['au_update_at'] = date('Y-m-d');
                $mst_data['au_update_session'] = Session()->get('user.ses_user_pk_no');
                $mst_data['au_update_hospital_no_fk'] = Session::get('user.ses_hospital_no_pk');
                
                DB::table('wsec_user_manual_mst')->where('userm_mst_no_pk', $id)->update($mst_data);

                $child_data['au_update_by'] = $auth_id;
                $child_data['au_update_at'] = date('Y-m-d');
                $child_data['au_update_session'] = Session()->get('user.ses_user_pk_no');
                $child_data['au_update_hospital_no_fk'] = Session::get('user.ses_hospital_no_pk');

                DB::table('wsec_user_manual_chd')->where('userm_chd_no_pk', $chd_id)->update($child_data);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function ViewUserManualDescription($id = ""){
        $description = DB::table('user_manual_vw')
        ->select('header_desc')
        ->where('userm_mst_no_pk', $id)
        ->first();
        return Template::loadview("admin.user-manual.description-modal", ['description' => $description]);
    }

    public function EditUserManual(Request $request){
        $edit = DB::table('user_manual_vw')
        ->select('user_manual_vw.*')
        ->where('userm_mst_no_pk', $request->userm_mst_no_pk)
        ->first();
        return response()->json($edit);
    }

    public function RemoveUserManual(Request $request){
        DB::table('wsec_user_manual_mst')->where('userm_mst_no_pk', $request->userm_mst_no_pk)->delete();
        DB::table('wsec_user_manual_chd')->where('userm_mst_no_fk', $request->userm_mst_no_pk)->delete();
        $data = DB::table('user_manual_vw') 
        ->select('userm_mst_no_pk', 'userm_mst_uid', 'features_no_fk', 'features_attch_name', 'userm_chd_no_pk', 'userm_chd_uid', 'header_sl', 'header_title', 'header_desc', 'features_name', 'menu_no_pk', 'menu_name', 'status')
        ->get();
        
        return Template::loadview("admin.user-manual.user-manual-list-include", [ 'data' => $data]);
    }


}