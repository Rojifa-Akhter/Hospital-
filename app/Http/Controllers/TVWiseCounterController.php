<?php

namespace App\Http\Controllers;

use DateTime;
use App\Library\Template;
use App\Traits\LookupData;
use Illuminate\Http\Request;
use App\Events\PharmacyTVUpdate;
use App\Core\TV\PharmacyTVService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TVWiseCounterController extends Controller
{

    use LookupData;
    protected $pharmacy_tv_information;

    public function __construct(PharmacyTVService $pharmacy_tv_information)
    {
        $this->pharmacy_tv_information = $pharmacy_tv_information;
    }
    public function counterSetup(){

        $data = $this->pharmacy_tv_information->get_pharmacy_tv_data(null);
        event(new PharmacyTVUpdate($data));

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

                        
        $cash_counter = $this->getLookupListByCode("PHRDEL");
        return Template::loadview('admin.tv_screen.pharmacy_tv.tv_wise_counter_setup', compact('tv','cash_counter'));
    }

    public function saveTVWiseCounter(Request $request){
        try {
            $request->validate([
                'counter_no_fk' => 'required',
                'tv_no_fk' => 'required',
            ]);

            if(DB::table('OPD_PHRTVSCREENDISPLAY')->where('COUNTER_NO_FK',$request->counter_no_fk)->exists()){
                return response()->json(['message' => 'This Counter Already Exists.', 'success' => false, 'title' => 'Failed'],422);
            }
            $mast_seq = $this->getSequence('tvscreendisplay_no_pkseq');
            $au_entry_at = new DateTime('now');
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            $data = [
                'TVSCREENDISPLAY_NO_PK' => $mast_seq,
                'TVSCREEN_NO_FK' => $request->tv_no_fk,
                'COUNTER_NO_FK' => $request->counter_no_fk,
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no,
                'status' => 1
            ];
            DB::table('OPD_PHRTVSCREENDISPLAY')->insert($data);
            return response()->json(['message' => 'Successfully Saved!', 'success' => true,'title' => 'Success'],200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'success' => false, 'title' => 'Failed'],422);
        }
    }

    public function updateTVWiseCounterSetup(Request $request){
        try {
            $request->validate([
                'counter_no_fk' => 'required',
                'tv_no_fk' => 'required',
                'tvscreendisplay_no_pk' => 'required',

            ]);
            $tvscreendisplay_no_pk = $request->tvscreendisplay_no_pk;
            if(DB::table('opd_phrtvscreendisplay')->where('COUNTER_NO_FK',$request->counter_no_fk)->where('TVSCREENDISPLAY_NO_PK','!=',$tvscreendisplay_no_pk)->exists()){
                return response()->json(['message' => 'This Counter Already Exists.', 'success' => false, 'title' => 'Failed'],422);
            }
            
            $au_entry_at = new DateTime('now');
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            $data = [
                'TVSCREEN_NO_FK' => $request->tv_no_fk,
                'COUNTER_NO_FK' => $request->counter_no_fk,
                'au_update_at' => $au_entry_at,
                'au_update_by' => Auth::id(),
                'au_update_session' => $entry_session,
                'au_update_hospital_pk_no' => $hospital_pk_no,
                'status' => 1
            ];
            DB::table('opd_phrtvscreendisplay')->where('TVSCREENDISPLAY_NO_PK',$tvscreendisplay_no_pk)->update($data);

            return response()->json(['msg' => 'Successfully Updated!', 'success' => true,'title' => 'Success'],200);
        } catch (\Throwable $th) {
            return response()->json(['msg' => $th->getMessage(), 'success' => false, 'title' => 'Failed'],422);
        }
    }

    public function getTVWiseCounterInfo(){
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $get_account = DB::table('OPD_PHRTVSCREENDISPLAY')
                        ->leftJoin('sysc_tvscreen','sysc_tvscreen.tvscreen_no_pk','=','OPD_PHRTVSCREENDISPLAY.TVSCREEN_NO_FK')
                        ->leftJoin('sysc_physicalstructfloor','sysc_physicalstructfloor.physicalstruct_no_pk','=','sysc_tvscreen.floor_no_fk')
                        ->leftJoin('SYSC_LOOKUPDATA','SYSC_LOOKUPDATA.LOOKUPDATA_NO_PK','=','OPD_PHRTVSCREENDISPLAY.COUNTER_NO_FK')

                        ->where('OPD_PHRTVSCREENDISPLAY.au_entry_hospital_pk_no', $ses_hospital_id)
                        ->select(
                            'OPD_PHRTVSCREENDISPLAY.TVSCREENDISPLAY_NO_PK',
                            'OPD_PHRTVSCREENDISPLAY.TVSCREEN_NO_FK',
                            'OPD_PHRTVSCREENDISPLAY.status',

                            'sysc_tvscreen.tvscreen_no_pk',
                            'sysc_tvscreen.tvscreen_code',
                            'sysc_tvscreen.tvscreen_name',
                            'sysc_tvscreen.floor_no_fk',

                            'sysc_physicalstructfloor.physicalstruct_name',
                            'sysc_physicalstructfloor.physicalstruct_desc',
                            'sysc_physicalstructfloor.physicalstruct_no_pk',
                            'SYSC_LOOKUPDATA.lookupdata_name',
                            'SYSC_LOOKUPDATA.lookupdata_no_pk'
                            )
                        ->get();
        return response()->json(['success' => true, 'data' => $get_account]);
    }

    public function editTVWiseCounterSetup($tvscreendisplay_no_pk){
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $data = DB::table('OPD_PHRTVSCREENDISPLAY')
                    ->leftJoin('sysc_tvscreen','sysc_tvscreen.tvscreen_no_pk','=','OPD_PHRTVSCREENDISPLAY.TVSCREEN_NO_FK')
                    ->leftJoin('sysc_physicalstructfloor','sysc_physicalstructfloor.physicalstruct_no_pk','=','sysc_tvscreen.floor_no_fk')
                    ->leftJoin('SYSC_LOOKUPDATA','SYSC_LOOKUPDATA.LOOKUPDATA_NO_PK','=','OPD_PHRTVSCREENDISPLAY.COUNTER_NO_FK')

                    ->where('OPD_PHRTVSCREENDISPLAY.au_entry_hospital_pk_no', $ses_hospital_id)
                    ->where('TVSCREENDISPLAY_NO_PK', $tvscreendisplay_no_pk)
                    ->select(
                        'OPD_PHRTVSCREENDISPLAY.TVSCREENDISPLAY_NO_PK',
                        'OPD_PHRTVSCREENDISPLAY.TVSCREEN_NO_FK',
                        'OPD_PHRTVSCREENDISPLAY.status',

                        'sysc_tvscreen.tvscreen_no_pk',
                        'sysc_tvscreen.tvscreen_code',
                        'sysc_tvscreen.tvscreen_name',
                        'sysc_tvscreen.floor_no_fk',

                        'sysc_physicalstructfloor.physicalstruct_name',
                        'sysc_physicalstructfloor.physicalstruct_desc',
                        'sysc_physicalstructfloor.physicalstruct_no_pk',
                        'SYSC_LOOKUPDATA.lookupdata_name',
                        'SYSC_LOOKUPDATA.lookupdata_no_pk'
                        )
                    ->first();



        

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
        $cash_counter = $this->getLookupListByCode("PHRDEL");
        return Template::loadView("admin.tv_screen.pharmacy_tv.modal.edit_counter_setup", compact('tvscreendisplay_no_pk','data','tv','cash_counter'));
    }
}
