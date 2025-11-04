<?php

namespace App\Http\Controllers;

use DateTime;
use App\Events\TVUpdate;
use App\Library\Template;
use App\Core\TV\TVService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TVScreenSetupController extends Controller
{

    protected $tv_information;
    public function __construct(TVService $tv_information)
    {
        $this->tv_information = $tv_information;
    }

    public function index(){
        $data = $this->tv_information->get_tv_data(null);
        event(new TVUpdate($data));
        $floor = DB::table("sysc_physicalstructfloor")->where("status",1)->get();
        return Template::loadview('admin.tv_screen.tv_setup', compact('floor'));
    }

    public function saveTVSetup(Request $request){
        try {
            $request->validate([
                'floor_no_fk' => 'required',
                'code' => 'required',
                'name' => 'required',
            ]);

            if(DB::table('sysc_tvscreen')->where('TVSCREEN_CODE',$request->code)->exists()){
                return response()->json(['message' => 'Code Already Exists.', 'success' => false, 'title' => 'Failed'],422);
            }
            $mast_seq = $this->getSequence('tvscreen_no_pk_seq');
            $au_entry_at = new DateTime('now');
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            $data = [
                'TVSCREEN_NO_PK' => $mast_seq,
                'TVSCREEN_CODE' => $request->code,
                'TVSCREEN_NAME' => $request->name,
                'FLOOR_NO_FK' => $request->floor_no_fk,
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'status' => 1
            ];
            DB::table('sysc_tvscreen')->insert($data);
            return response()->json(['message' => 'Successfully Saved!', 'success' => true,'title' => 'Success'],200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'success' => false, 'title' => 'Failed'],422);
        }
    }
    public function updateTVSetup(Request $request){
        try {
            $request->validate([
                'floor_no_fk' => 'required',
                'code' => 'required',
                'tvscreen_no_pk' => 'required',
                'name' => 'required',
            ]);

            $tvscreen_no_pk = $request->tvscreen_no_pk;
            $au_entry_at = new DateTime('now');
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            $data = [
                'TVSCREEN_NAME' => $request->name,
                'FLOOR_NO_FK' => $request->floor_no_fk,
                'au_update_at' => $au_entry_at,
                'au_update_by' => Auth::id(),
                'au_update_session' => $entry_session,
                'au_update_hospital_pk_no' => $hospital_pk_no,
                'status' => 1
            ];
            DB::table('sysc_tvscreen')->where('TVSCREEN_NO_PK',$tvscreen_no_pk)->update($data);

            return response()->json(['msg' => 'Successfully Updated!', 'success' => true,'title' => 'Success'],200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => $th->getMessage(), 'success' => false, 'title' => 'Failed'],422);
        }
    }
    public function getTVInfo(){
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $get_account = DB::table('sysc_tvscreen')
                        ->leftJoin('sysc_physicalstructfloor','sysc_physicalstructfloor.physicalstruct_no_pk','=','sysc_tvscreen.floor_no_fk')
                        ->orderBy('sysc_tvscreen.tvscreen_no_pk', 'desc')
                        ->where('sysc_tvscreen.au_entry_hospital_pk_no', $ses_hospital_id)
                        ->where('sysc_tvscreen.status', 1)
                        ->select(
                            'sysc_tvscreen.tvscreen_no_pk',
                            'sysc_tvscreen.status',
                            'sysc_tvscreen.tvscreen_code',
                            'sysc_tvscreen.tvscreen_name',
                            'sysc_tvscreen.floor_no_fk',
                            'sysc_physicalstructfloor.physicalstruct_name',
                            'sysc_physicalstructfloor.physicalstruct_desc',
                            'sysc_physicalstructfloor.physicalstruct_no_pk'
                            )
                        ->get();
        return response()->json(['success' => true, 'data' => $get_account]);
    }

    public function editTVSetup($tvscreen_no_pk){
        $data = DB::table('sysc_tvscreen')
                    ->where('tvscreen_no_pk', $tvscreen_no_pk)
                    ->select(
                        'sysc_tvscreen.tvscreen_no_pk',
                        'sysc_tvscreen.status',
                        'sysc_tvscreen.tvscreen_code',
                        'sysc_tvscreen.tvscreen_name',
                        'sysc_tvscreen.floor_no_fk',
                        )
                    ->first();
        $floor = DB::table("sysc_physicalstructfloor")->where("status",1)->get();
        return Template::loadView("admin.tv_screen.modal.edit_tv_setup", compact('tvscreen_no_pk','data','floor'));
    }

    public function doctorSetup(){
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $tv = DB::table('sysc_tvscreen')
                        ->leftJoin('sysc_physicalstructfloor','sysc_physicalstructfloor.physicalstruct_no_pk','=','sysc_tvscreen.floor_no_fk')
                        ->orderBy('sysc_tvscreen.tvscreen_no_pk', 'desc')
                        ->where('sysc_tvscreen.au_entry_hospital_pk_no', $ses_hospital_id)
                        ->where('sysc_tvscreen.status', 1)
                        ->select(
                            'sysc_tvscreen.tvscreen_no_pk',
                            'sysc_tvscreen.status',
                            'sysc_tvscreen.tvscreen_code',
                            'sysc_tvscreen.tvscreen_name',
                            'sysc_tvscreen.floor_no_fk',
                            'sysc_physicalstructfloor.physicalstruct_name',
                            'sysc_physicalstructfloor.physicalstruct_desc',
                            'sysc_physicalstructfloor.physicalstruct_no_pk'
                            )
                        ->get();

        return Template::loadview('admin.tv_screen.tv_wise_doctor_setup', compact('tv'));
    }

    public function saveTVWiseDoctor(Request $request){
        try {
            $request->validate([
                'doctor_id' => 'required',
                'tv_no_fk' => 'required',
            ]);

            if(DB::table('opd_tvscreendisplay')->where('PERSON_NO_FK',$request->doctor_id)->exists()){
                return response()->json(['message' => 'This Doctor Already Exists.', 'success' => false, 'title' => 'Failed'],422);
            }
            $mast_seq = $this->getSequence('tvscreendisplay_no_pk_seq');
            $au_entry_at = new DateTime('now');
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            $data = [
                'TVSCREENDISPLAY_NO_PK' => $mast_seq,
                'TVSCREEN_NO_FK' => $request->tv_no_fk,
                'PERSON_NO_FK' => $request->doctor_id,
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'status' => 1
            ];
            DB::table('opd_tvscreendisplay')->insert($data);
            return response()->json(['message' => 'Successfully Saved!', 'success' => true,'title' => 'Success'],200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'success' => false, 'title' => 'Failed'],422);
        }
    }

    public function updateTVWiseSetup(Request $request){
        try {
            $request->validate([
                'doctor_id' => 'required',
                'tv_no_fk' => 'required',
            ]);
            $tvscreendisplay_no_pk = $request->tvscreendisplay_no_pk;
            if(DB::table('opd_tvscreendisplay')->where('PERSON_NO_FK',$request->doctor_id)->where('TVSCREENDISPLAY_NO_PK','!=',$tvscreendisplay_no_pk)->exists()){
                return response()->json(['message' => 'This Doctor Already Exists.', 'success' => false, 'title' => 'Failed'],422);
            }
            
            $au_entry_at = new DateTime('now');
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            $data = [
                'TVSCREEN_NO_FK' => $request->tv_no_fk,
                'PERSON_NO_FK' => $request->doctor_id,
                'au_update_at' => $au_entry_at,
                'au_update_by' => Auth::id(),
                'au_update_session' => $entry_session,
                'au_update_hospital_pk_no' => $hospital_pk_no,
                'status' => 1
            ];
            DB::table('opd_tvscreendisplay')->where('TVSCREENDISPLAY_NO_PK',$tvscreendisplay_no_pk)->update($data);

            return response()->json(['msg' => 'Successfully Updated!', 'success' => true,'title' => 'Success'],200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => $th->getMessage(), 'success' => false, 'title' => 'Failed'],422);
        }
    }

    public function getTVWiseDoctorInfo(){
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $get_account = DB::table('OPD_TVSCREENDISPLAY')
            ->leftJoin('HRMS_PERSONNEL', function ($q) {
                $q->on("HRMS_PERSONNEL.PERSON_NO_PK", "=", "OPD_TVSCREENDISPLAY.PERSON_NO_FK");
            })
            ->leftJoin('sysc_tvscreen','sysc_tvscreen.tvscreen_no_pk','=','OPD_TVSCREENDISPLAY.TVSCREEN_NO_FK')
            ->leftJoin('sysc_physicalstructfloor','sysc_physicalstructfloor.physicalstruct_no_pk','=','sysc_tvscreen.floor_no_fk')

            ->where('OPD_TVSCREENDISPLAY.au_entry_hospital_pk_no', $ses_hospital_id)
            ->select(
                'OPD_TVSCREENDISPLAY.TVSCREENDISPLAY_NO_PK',
                'OPD_TVSCREENDISPLAY.person_no_fk',
                'OPD_TVSCREENDISPLAY.TVSCREEN_NO_FK',
                'OPD_TVSCREENDISPLAY.status',

                'sysc_tvscreen.tvscreen_no_pk',
                'sysc_tvscreen.tvscreen_code',
                'sysc_tvscreen.tvscreen_name',
                'sysc_tvscreen.floor_no_fk',

                'sysc_physicalstructfloor.physicalstruct_name',
                'sysc_physicalstructfloor.physicalstruct_desc',
                'sysc_physicalstructfloor.physicalstruct_no_pk',
                "HRMS_PERSONNEL.full_name as doctor_name",
                )
            ->get();
        return response()->json(['success' => true, 'data' => $get_account]);
    }

    public function editTVWiseSetup($tvscreendisplay_no_pk){
        $data = DB::table('OPD_TVSCREENDISPLAY')
                ->leftJoin('HRMS_PERSONNEL', function ($q) {
                    $q->on("HRMS_PERSONNEL.PERSON_NO_PK", "=", "OPD_TVSCREENDISPLAY.PERSON_NO_FK");
                })
                    ->where('TVSCREENDISPLAY_NO_PK', $tvscreendisplay_no_pk)
                    ->select(
                        'OPD_TVSCREENDISPLAY.TVSCREENDISPLAY_NO_PK',
                        'OPD_TVSCREENDISPLAY.status',
                        'OPD_TVSCREENDISPLAY.person_no_fk',
                        'OPD_TVSCREENDISPLAY.tvscreen_no_fk',
                        "HRMS_PERSONNEL.full_name as doctor_name",
                        )
                    ->first();

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $tv = DB::table('sysc_tvscreen')
                    ->leftJoin('sysc_physicalstructfloor','sysc_physicalstructfloor.physicalstruct_no_pk','=','sysc_tvscreen.floor_no_fk')
                    ->orderBy('sysc_tvscreen.tvscreen_no_pk', 'desc')
                    ->where('sysc_tvscreen.au_entry_hospital_pk_no', $ses_hospital_id)
                    ->where('sysc_tvscreen.status', 1)
                    ->select(
                        'sysc_tvscreen.tvscreen_no_pk',
                        'sysc_tvscreen.status',
                        'sysc_tvscreen.tvscreen_code',
                        'sysc_tvscreen.tvscreen_name',
                        'sysc_tvscreen.floor_no_fk',
                        'sysc_physicalstructfloor.physicalstruct_name',
                        'sysc_physicalstructfloor.physicalstruct_desc',
                        'sysc_physicalstructfloor.physicalstruct_no_pk'
                        )
                    ->get();
        return Template::loadView("admin.tv_screen.modal.edit_tv_wise_doctor_setup", compact('tvscreendisplay_no_pk','data','tv'));
    }
}
